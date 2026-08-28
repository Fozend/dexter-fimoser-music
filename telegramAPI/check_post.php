<?php

header('Content-Type: application/json');

const ALLOWED_CHANNEL = 'LiterallyDexter';

// Simple file-based cache so repeat visits don't re-check the same post IDs
// against Telegram every time. A post's existence essentially never changes
// back from "deleted" to "exists", so a long TTL is safe.
const CACHE_FILE = __DIR__ . '/../cache/telegram_posts.json';
const CACHE_TTL_SECONDS = 60 * 60 * 24; // 24h

$ids = isset($_GET['ids']) ? explode(',', $_GET['ids']) : [];
$ids = array_slice($ids, 0, 20); // hard cap per request
$ids = array_values(array_unique(array_filter(array_map('intval', $ids), fn($id) => $id > 0)));

$cache = loadCache();
$now = time();

$result = [];
$toFetch = [];

foreach ($ids as $id) {
    if (isset($cache[$id]) && ($now - $cache[$id]['ts']) < CACHE_TTL_SECONDS) {
        $result[$id] = $cache[$id]['exists'];
    } else {
        $toFetch[] = $id;
    }
}

if (!empty($toFetch)) {
    $fetched = fetchExistenceInParallel($toFetch);
    foreach ($fetched as $id => $exists) {
        $result[$id] = $exists;
        $cache[$id] = ['exists' => $exists, 'ts' => $now];
    }
    saveCache($cache);
}

echo json_encode($result);

// --- helpers ---------------------------------------------------------

function fetchExistenceInParallel(array $ids): array {
    $multiHandle = curl_multi_init();
    $handles = [];

    foreach ($ids as $id) {
        $url = "https://t.me/" . ALLOWED_CHANNEL . "/{$id}?embed=1";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        // Force English response so the "Post not found" string match is reliable
        // regardless of the server's own locale/IP-based language detection.
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept-Language: en']);

        curl_multi_add_handle($multiHandle, $ch);
        $handles[$id] = $ch;
    }

    $running = null;
    do {
        curl_multi_exec($multiHandle, $running);
        curl_multi_select($multiHandle);
    } while ($running > 0);

    $result = [];
    foreach ($handles as $id => $ch) {
        $html = curl_multi_getcontent($ch);

        // A missing/deleted post's embed page explicitly says "Post not found".
        // Treat a failed request the same way (skip it) rather than assuming
        // it exists — a broken embed is worse than a missing one.
        $exists = $html !== false
            && $html !== ''
            && stripos($html, 'Post not found') === false;

        $result[$id] = $exists;

        curl_multi_remove_handle($multiHandle, $ch);
        curl_close($ch);
    }

    curl_multi_close($multiHandle);

    return $result;
}

function loadCache(): array {
    if (!file_exists(CACHE_FILE)) {
        return [];
    }
    $data = @file_get_contents(CACHE_FILE);
    $decoded = $data ? json_decode($data, true) : null;
    return is_array($decoded) ? $decoded : [];
}

function saveCache(array $cache): void {
    $dir = dirname(CACHE_FILE);
    if (!is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }
    @file_put_contents(CACHE_FILE, json_encode($cache));
}
