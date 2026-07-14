/**
 * Lite Sails service worker.
 *
 * Its main job is to make the site installable (Android/Chromium requires a
 * service worker with a fetch handler). In production it keeps forecasts fresh
 * (network-first for pages, offline fallback) and caches our own static assets.
 *
 * On local/dev hosts it does NOT cache anything, so you never get served a
 * stale page while developing. Add your own dev hostnames to DEV_HOST if needed.
 */
const CACHE = 'litesails-v2';
const OFFLINE_URL = '/offline.html';
const PRECACHE = [OFFLINE_URL, '/images/favicon.svg'];

const DEV_HOST = /^(localhost|127\.0\.0\.1|\[::1\])$|\.test$|\.local$|\.localhost$|izdelava\.si$/i;
const IS_DEV = DEV_HOST.test(self.location.hostname);

self.addEventListener('install', (event) => {
    if (!IS_DEV) {
        event.waitUntil(caches.open(CACHE).then((cache) => cache.addAll(PRECACHE)));
    }
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    // Drop any old caches (also cleans dev machines that cached an earlier version).
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(keys.filter((key) => key !== CACHE).map((key) => caches.delete(key)))
        )
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    // Dev: never intercept — always hit the network (still installable).
    if (IS_DEV) {
        return;
    }

    const request = event.request;

    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);

    // Only handle same-origin requests; forecast images stay on the network.
    if (url.origin !== self.location.origin) {
        return;
    }

    // Page navigations: network first (fresh forecasts), offline page as fallback.
    if (request.mode === 'navigate') {
        event.respondWith(fetch(request).catch(() => caches.match(OFFLINE_URL)));
        return;
    }

    // Local static assets: cache first, refresh in the background.
    if (/^\/(dist|images)\//.test(url.pathname)) {
        event.respondWith(
            caches.match(request).then((cached) =>
                cached ||
                fetch(request).then((response) => {
                    const copy = response.clone();
                    caches.open(CACHE).then((cache) => cache.put(request, copy));
                    return response;
                })
            )
        );
    }
});
