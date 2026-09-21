<?php
/*
 * Fetching and caching of meteo.hr (DHMZ) pages, shared by sea.php and
 * weather.php. Defines functions only — no output, so it is safe to include
 * before setcookie()/headers. Not meant to be requested over HTTP; .htaccess
 * returns 403 for it.
 *
 * The cache is the reason there is no cron job: the first request after the TTL
 * expires refreshes it, everyone else is served from disk.
 */

/** Directory holding the cache files. Kept out of the web root's top level. */
function dhmzCacheDir() {
    return __DIR__ . '/cache';
}

/**
 * Path of a cache file for a given key.
 *
 * Always keeps the `_dhmz_` prefix and drops anything that isn't safe in a
 * filename, because both the .htaccess 403 rule and .gitignore key off that
 * prefix — a cache file named otherwise would be publicly readable and would
 * get committed. (`Options -Indexes` already stops cache/ being listed.)
 */
function dhmzCachePath($key) {
    return dhmzCacheDir() . '/_dhmz_' . preg_replace('/[^A-Za-z0-9_-]/', '', $key) . '.html';
}

/**
 * Fetch remote HTML, no caching.
 *
 * Prefers cURL with full TLS verification. If that fails (e.g. a server with
 * a misconfigured CA bundle), it retries without peer verification so the
 * page still works — acceptable here since we only read public forecast HTML.
 * Falls back to file_get_contents when cURL is unavailable.
 */
function dhmzHttpGet($url) {
    if (function_exists('curl_init')) {
        foreach ([true, false] as $verify) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT        => 15,
                CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; LiteSails/1.0)',
                CURLOPT_SSL_VERIFYPEER => $verify,
                CURLOPT_SSL_VERIFYHOST => $verify ? 2 : 0,
            ]);
            $html = curl_exec($ch);
            curl_close($ch);
            if ($html !== false && $html !== '') {
                return $html;
            }
        }
    }

    $html = @file_get_contents($url);

    return $html === false ? '' : $html;
}

/**
 * Fetch a URL through a filesystem cache (default 30 min TTL).
 *
 * Serves the cache while it's fresh; otherwise fetches live and rewrites the
 * cache. If the live fetch fails, falls back to a stale cache so the page still
 * renders rather than going blank when meteo.hr is down.
 */
function dhmzFetch($url, $cacheFile, $ttl = 1800) {
    if (is_file($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
        $cached = file_get_contents($cacheFile);
        if ($cached !== false && $cached !== '') {
            return $cached;
        }
    }

    $html = dhmzHttpGet($url);

    if ($html !== '') {
        // The directory ships with the project, but recreate it if a deploy
        // dropped it (git does not carry empty ones) -- otherwise every request
        // would silently refetch.
        $dir = dirname($cacheFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        @file_put_contents($cacheFile, $html, LOCK_EX);
        return $html;
    }

    // Live fetch failed — fall back to a stale cache if one exists.
    if (is_file($cacheFile)) {
        $stale = file_get_contents($cacheFile);
        if ($stale !== false && $stale !== '') {
            return $stale;
        }
    }

    return '';
}
