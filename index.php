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

// Search for songs
$searchTerm = isset($_GET['search']) ? $_GET['search'] : ''; // If the 'search' key has a value in $_GET

$searchedSongs = []; // Array for storing search results

$queryMessage = '';
$queryMessageType = '';
if (!empty($searchTerm)) {
    foreach ($songs as $song) {
        // Check whether the query is contained in the song name, artist, album, or year
        if (stripos($song['name'], $searchTerm) !== false || // stripos is an excellent search function; it checks for the occurrence of a substring within a string
            stripos($song['artist'], $searchTerm) !== false || 
            stripos($song['album'], $searchTerm) !== false || 
            stripos($song['year'], $searchTerm) !== false) 
            {
                $searchedSongs[] = $song;
            }
        }

    if (empty($searchedSongs)) {
        $queryMessage = "Oops! We didn't find anything";
        $queryMessageType = 'error';
    } else {
        $queryMessage = "Found a match with {$searchTerm}";
        $queryMessageType = 'success';
    }
}

// Get the current year and the last three years
$currentYear = date("Y");
$threeYearsAgo = $currentYear - 2;

// Filter songs from the last three years
$filterNew = isset($_GET['filter']) && $_GET['filter'] === 'new';

$filteredSongs = $filterNew 
    ? array_filter($songs, function ($song) use ($currentYear, $threeYearsAgo) {
        return $song['year'] >= $threeYearsAgo && $song['year'] <= $currentYear;
    })
    : $songs;

// Filter songs by artist
$filterArtist = isset($_GET['artist']) ? $_GET['artist'] : '';
$filteredByArtist = $filterArtist 
    ? array_filter($songs, function ($song) use ($filterArtist) {
        return $song['artist'] == $filterArtist;
    })
    : $songs;
$artists = array_unique(array_column($songs, 'artist')); // Get unique artists

// Filter songs by album
$filterAlbum = isset($_GET['album']) ? $_GET['album'] : '';
$filteredByAlbum = $filterAlbum
    ? array_filter($songs, function ($song) use ($filterAlbum) {
        return $song['album'] == $filterAlbum;
    })
    : $filteredByArtist;

// Get unique albums for the selected artist, excluding the "Сингл" album
$albumsWithArtists = [];
foreach ($songs as $song) {
    if (($filterArtist === '' || $song['artist'] === $filterArtist) && $song['album'] !== 'Сингл') {
        if (!in_array($song['album'], array_keys($albumsWithArtists))) {
            $albumsWithArtists[$song['album']] = $song['artist'];
        }
    }
}

if (!empty($searchedSongs)) {
    $songsToDisplay = $searchedSongs;
} else {
    $songsToDisplay = $filterNew ? $filteredSongs : $filteredByAlbum;
}

// Sorting
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'name';
usort($songsToDisplay, function ($a, $b) use ($sortBy) {
    return strcasecmp($a[$sortBy], $b[$sortBy]);
});

// Moved lower so that the song list is processed first
$menuPartial = __DIR__ . '/includes/menu-index.php';
require 'includes/header.php';
?>

<?php if ($queryMessage): ?>
    <div class="query" id="<?= $queryMessageType ?>">
        <?= htmlspecialchars($queryMessage) ?>
    </div>
<?php endif; ?>

<script src="helpers/player.js"></script>

<div class="sorting-song-container">

    <div class="sorting">
        <form method="get">
            <input type="hidden" name="artist" value="<?php echo htmlspecialchars($filterArtist); ?>">
            <input type="hidden" name="album" value="<?php echo htmlspecialchars($filterAlbum); ?>">
            <input type="hidden" name="filter" value="<?php echo htmlspecialchars($filterNew ? 'new' : ''); ?>">
            <input type="hidden" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">

            <div class="sort-select-wrapper">
                <select name="sort" id="sort" onchange="this.form.submit()" aria-label="Сортувати за">
                    <option value="artist" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'artist') ? 'selected' : ''; ?>>Виконавець</option>
                    <option value="year" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'year') ? 'selected' : ''; ?>>Рік</option>
                    <option value="album" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'album') ? 'selected' : ''; ?>>Альбом</option>
                    <option value="name" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name') ? 'selected' : ''; ?>>Назва пісні</option>
                </select>
                <i class="fa-solid fa-chevron-down sort-arrow"></i>
            </div>
        </form>
    </div>

    <div class="song-list">
        <?php foreach ($songsToDisplay as $song): ?>
            <div class="main">
                <div class="song">
                    <div class="song-header">
                        <div class="song-meta">
                            <span class="year"><?php echo $song['year']; ?></span>
                            <span class="dot" aria-hidden="true">•</span>
                            <span class="album"><?php echo $song['album']; ?></span>
                        </div>
                        <div class="song-actions">
                            <button type="button" class="icon-button like-button" aria-label="Вподобати" aria-pressed="false">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <a href="<?php echo $dir . '/' . $song['file']; ?>" download>
                                <button type="button" class="icon-button download-button" aria-label="Завантажити">
                                    <i class="fa-solid fa-download"></i>
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="name">
                        <a href="videos.php?file=<?php echo urlencode($song['file']); ?>"><?php echo $song['name']; ?></a>
                    </div>

                    <div class="artist"><?php echo $song['artist']; ?></div>

                    <div class="player">
                        <audio class="player-audio" preload="metadata" src="<?php echo htmlspecialchars($dir . '/' . $song['file']); ?>"></audio>

                        <button type="button" class="player-play" aria-label="Відтворити">
                            <i class="fa-solid fa-play"></i>
                        </button>

                        <span class="player-time player-time-current">0:00</span>

                        <div class="player-progress">
                            <div class="player-progress-buffered"></div>
                            <div class="player-progress-fill"></div>
                            <input type="range" class="player-seek" min="0" max="100" value="0" step="0.1" aria-label="Перемотка">
                        </div>

                        <span class="player-time player-time-duration">0:00</span>

                        <div class="player-volume">
                            <button type="button" class="player-volume-btn" aria-label="Гучність">
                                <i class="fa-solid fa-volume-high"></i>
                            </button>
                            <input type="range" class="player-volume-slider" min="0" max="1" step="0.01" value="1" aria-label="Рівень гучності">
                        </div>

                        <select class="player-speed" aria-label="Швидкість відтворення">
                            <option value="0.75">0.75x</option>
                            <option value="1" selected>1x</option>
                            <option value="1.25">1.25x</option>
                            <option value="1.5">1.5x</option>
                            <option value="2">2x</option>
                        </select>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

</body>
</html>