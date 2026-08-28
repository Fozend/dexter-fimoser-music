<?php

require 'includes/background.php';

// Process songs
$dir    = './mp3';
$files = scandir($dir);
$songs = []; // Array for storing songs by their parts

foreach ($files as $i) {
    if ($i == "." || $i == "..") continue;
    $parts = explode(" -- ", substr($i, 0, -4));
    if (count($parts) == 4) {
        $songs[] = [
            'artist' => $parts[0],
            'year' => $parts[1],
            'album' => $parts[2],
            'name' => $parts[3],
            'file' => $i
        ];
    } else {
        echo "<div class='query' id='error'>Something went wrong in '{$i}'. Probably, incorrect format was specified.</div><br><br>";
    }
}
// Check if the song file name was provided
$fileName = isset($_GET['file'])  ? $_GET['file'] : null;
$song = null;
$songIndex = null;

if ($fileName) {
    setcookie('file', $fileName, time() + (86400 * 7), "/");
    
    // Search for the song by file name
    foreach ($songs as $index => $s) {
        if ($s['file'] === $fileName) {
            $song = $s;
            $songIndex = $index;
            break;
        }
    }
} 

// If the file name is not provided, iterate through all songs
elseif (isset($_COOKIE['file'])) {
    $fileName = $_COOKIE['file'];
    foreach ($songs as $index => $s) {
        if ($s['file'] === $fileName) {
            $song = $s;
            $songIndex = $index;
            break;
        }
    }
} else {
    // If the file parameter is not specified, use the first song
    $song = $songs[0];
    $songIndex = 0;
}

// Moved lower so that cookies are processed first
$pageTitle = 'Dexter Fimoser Videos';
$hideFooter = true;
require 'includes/header.php';

// Get the next and previous songs for navigation
$nextSong = isset($songs[$songIndex + 1]) ? $songs[$songIndex + 1] : $songs[0]; 
$prevSong = isset($songs[$songIndex - 1]) ? $songs[$songIndex - 1] : end($songs);


if ($song) {
    $config = require __DIR__ . '/helpers/config.php';
    $apiKey = $config['youtube_api_key'];

    // Build the search query
    $query = urlencode($song['name'] . ' ' . $song['artist']);
    $maxResults = 1;

    // URL for the YouTube Data API request
    $apiUrl = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=$query&type=video&maxResults=$maxResults&key=$apiKey";

    // Execute the request and get the results
    $response = file_get_contents($apiUrl);
    if ($response === false) {
        echo "<div class='query' id='error'>Помилка під час звернення до Youtube API. Схоже, ви перевищили квоту запитів</div>";
        echo '<iframe class="video" src="https://www.youtube.com/embed/vabnZ9-ex7o?si=WCt4GJFnWWq1Jv4y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
    } else {
        $videos = json_decode($response);
        if (!empty($videos->items)) {
            $videoId = $videos->items[0]->id->videoId;
            echo "<iframe class='video' src='https://www.youtube.com/embed/$videoId' frameborder='0' allowfullscreen></iframe>";
        } else {
            echo "<div class='query' id='error'>Відео не знайдено</div>";
        }
    }
} else {
    echo "<div class='query' id='error'>Пісня не знайдена</div>";
}
?>

<div class='song-info'>
    <p id="h"><?php echo htmlspecialchars($song['name']); ?></p>
    <p><?php echo htmlspecialchars($song['artist']); ?></p>
    <p><?php echo htmlspecialchars($song['year']); ?></p>
    <p><?php echo htmlspecialchars($song['album']); ?></p>
</div>

<div class="navigation">
    <a href="videos.php?file=<?php echo $prevSong['file']; ?>" class="prev"><i class="fa-solid fa-backward icon"></i></a>
    <a href="videos.php?file=<?php echo $nextSong['file']; ?>" class="next"><i class="fa-solid fa-forward icon"></i></a>
</div>

</body>
</html>