<?php
    // Per-page SEO values (set before include('header.php'); sensible defaults otherwise).
    $title       = $pageTitle       ?? 'Lite Sails — Wind, weather and sea forecast for the Adriatic';
    $description = $pageDescription ?? 'Free, mobile-friendly wind, weather and sea forecast for the Adriatic coast — for sailors and boaters.';
    $robots      = $pageRobots      ?? 'index, follow';

    $scheme    = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host      = $_SERVER['HTTP_HOST'] ?? 'lite.fliper.si';
    $baseUrl   = $scheme . '://' . $host;
    // Canonical = this page without its query string, so ?map / ?code variants
    // consolidate onto the main URLs.
    $canonical = $pageCanonical ?? ($baseUrl . strtok($_SERVER['REQUEST_URI'] ?? '/', '?'));
    $ogImage   = $baseUrl . '/images/web-app-manifest-512x512.png';

    // Schema.org structured data (JSON-LD). WebSite + Organization, linked by @id.
    // Safe under the strict CSP: application/ld+json is a data block, not an
    // executed script, so script-src doesn't apply.
    $structuredData = [
        '@context' => 'https://schema.org',
        '@graph'   => [
            [
                '@type'       => 'WebSite',
                '@id'         => $baseUrl . '/#website',
                'url'         => $baseUrl . '/',
                'name'        => 'Lite Sails',
                'description' => 'Wind, weather and sea forecast for the Adriatic coast.',
                'inLanguage'  => 'en',
                'publisher'   => ['@id' => $baseUrl . '/#organization'],
            ],
            [
                '@type'  => 'Organization',
                '@id'    => $baseUrl . '/#organization',
                'name'   => 'Lite Sails',
                'url'    => $baseUrl . '/',
                'logo'   => [
                    '@type'  => 'ImageObject',
                    'url'    => $baseUrl . '/images/web-app-manifest-512x512.png',
                    'width'  => 512,
                    'height' => 512,
                ],
                'sameAs' => ['https://github.com/BlazOrazem/litesails'],
            ],
        ],
    ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <?php foreach (($preconnect ?? []) as $origin): ?>
    <link rel="preconnect" href="<?= htmlspecialchars($origin) ?>">
    <link rel="dns-prefetch" href="<?= htmlspecialchars($origin) ?>">
    <?php endforeach; ?>

    <title><?= htmlspecialchars($title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>"/>
    <meta name="robots" content="<?= htmlspecialchars($robots) ?>"/>
    <meta name="author" content="Blaž Oražem"/>
    <link rel="canonical" href="<?= htmlspecialchars($canonical) ?>"/>

    <!-- Open Graph / Twitter (link previews) -->
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="Lite Sails"/>
    <meta property="og:title" content="<?= htmlspecialchars($title) ?>"/>
    <meta property="og:description" content="<?= htmlspecialchars($description) ?>"/>
    <meta property="og:url" content="<?= htmlspecialchars($canonical) ?>"/>
    <meta property="og:image" content="<?= htmlspecialchars($ogImage) ?>"/>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:title" content="<?= htmlspecialchars($title) ?>"/>
    <meta name="twitter:description" content="<?= htmlspecialchars($description) ?>"/>
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImage) ?>"/>

    <script type="application/ld+json"><?= json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>

    <link rel="icon" type="image/png" href="/images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/images/favicon.svg" />
    <link rel="shortcut icon" href="/images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Lite Sails" />
    <link rel="manifest" href="/images/site.webmanifest" />

    <meta name="theme-color" content="#5290CC" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />

    <link rel="stylesheet" href="/dist/app.min.css?v=<?= @filemtime(__DIR__ . '/dist/app.min.css') ?>">
</head>

<body>
