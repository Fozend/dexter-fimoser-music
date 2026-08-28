<?php

require 'includes/background.php';

session_start();

if (!isset($_SESSION['yearCounts'])) {
    $_SESSION['yearCounts'] = [];
}

if (isset($_GET['add']) && !empty($_GET['year']) && !empty($_GET['year_count'])) {
    $year = $_GET['year'];
    $year_count = (int)$_GET['year_count'];
    
    if (isset($_SESSION['yearCounts'][$year])) {
        $_SESSION['yearCounts'][$year] += $year_count;
    } else {
        $_SESSION['yearCounts'][$year] = $year_count;
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_GET['submit'])) {
    $groupedYearCounts = $_SESSION['yearCounts'];

    $finalGroupedYearCounts = [];
    foreach ($groupedYearCounts as $year => $count) {
        if ($year >= 1900 && $year <= 2029) {
            $decade = floor($year / 10) * 10;
            $decadeKey = ($decade < 2000) ? "{$decade}s" : "{$decade}" . "s";
            if (!isset($finalGroupedYearCounts[$decadeKey])) {
                $finalGroupedYearCounts[$decadeKey] = 0;
            }
            $finalGroupedYearCounts[$decadeKey] += $count;
        } elseif ($year >= 1700 && $year <= 1799) {
            $finalGroupedYearCounts['1700s'] = ($finalGroupedYearCounts['1700s'] ?? 0) + $count;
        } elseif ($year >= 1800 && $year <= 1899) {
            $finalGroupedYearCounts['1800s'] = ($finalGroupedYearCounts['1800s'] ?? 0) + $count;
        } elseif ($year < 1700) {
            $finalGroupedYearCounts['До 1700'] = ($finalGroupedYearCounts['До 1700'] ?? 0) + $count;
        }
    }

    arsort($finalGroupedYearCounts);

    $year_counts = array_values($finalGroupedYearCounts);
    $year = array_keys($finalGroupedYearCounts);

    $year_counts_param = implode(',', $year_counts);
    $year_param = implode(',', $year);

    session_destroy();
    
} else {

    $dir    = './mp3';
    $files = scandir($dir);
    $songs = [];
    $yearCounts = [];
    
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
            if (!isset($yearCounts[$parts[1]])) {
                $yearCounts[$parts[1]] = 0;
            }
            $yearCounts[$parts[1]]++;
        }
    }
    // Group years by decade
    $groupedYearCounts = [];
    foreach ($yearCounts as $year => $count) {
        if ($year >= 1900 && $year <= 2029) {

            // Determine the decade
            $decade = floor($year / 10) * 10;

            // Create a key for the decade
            $decadeKey = ($decade < 2000) ? "{$decade}s" : "{$decade}" . "s";

            // Initialize the value if it has not been set yet
            if (!isset($groupedYearCounts[$decadeKey])) {
                $groupedYearCounts[$decadeKey] = 0;
            }

            // Add the count to the group
            $groupedYearCounts[$decadeKey] += $count;
        
        } elseif ($year >= 1700 && $year <= 1799) {
            if (!isset($groupedYearCounts['1700s'])) {
                $groupedYearCounts['1700s'] = 0;
                }
            $groupedYearCounts['1700s'] += $count;
        
        } elseif ($year >= 1800 && $year <= 1899) {
        if (!isset($groupedYearCounts['1800s'])) {
            $groupedYearCounts['1800s'] = 0;
            }
            $groupedYearCounts['1800s'] += $count;

        } elseif ($year < 1700) {
            if (!isset($groupedYearCounts['До 1700'])) {
                $groupedYearCounts['До 1700'] = 0;
            }
            $groupedYearCounts['До 1700'] += $count;

        } else {
            // Leave other years unchanged
            $groupedYearCounts[$year] = $count;
        }
    }

    // Sort by values in descending order
    arsort($groupedYearCounts);

    $year_counts = array_values($groupedYearCounts); // Get the sorted values
    $year = array_keys($groupedYearCounts); // Get the corresponding keys (years)

    // Build the URL
    $year_counts_param = implode(',', $year_counts); // Combine values into a comma-separated string
    $year_param = implode(',', $year); // Combine years into a comma-separated string
    
}

$pageTitle = 'Dexter Fimoser Diagram';
require 'includes/header.php';

?>

<div class="quote-box">
  <div class="quote-text">
    "We have become so quick and effective in building things today. It would be easy to build another Pyramid of Giza or another Great Wall. But these buildings haven't withstood the test of time because of their building quality. They stand tall because they have a symbolic value, they represent a culture."
  </div>
  <div class="author">
    — Zhang Xin
  </div>
</div>

<div class="diagram">
    <p class="diagram-title">Випробовування часом: еволюція музичного сприйняття</p>
    <p class="quote-text"> На діаграмі зображено кількість пісень з сайту різних десятиліть, де видно, що сучасні треки кількісно переважають над старими. Чи означає це, що нова музика краща? Ні, річ у тому, що нові пісні ще не пройшли випробування часом. Лише сильні твори залишаються в пам'яті, а слабкі зникають у забутті.</p>
    <img src="helpers/diagram.php?year_counts=<?php echo $year_counts_param; ?>&year=<?php echo $year_param; ?>">
</div>

<div class="form-box">
    <p>Заповніть форму, якщо маєте інші дані. Вони будуть відображені на діаграмі</p>
    <p>Щоб додати рік натисніть "Додати", щоб відправити форму натисніть "ОК"</p>
    <form action="" method="get">
        <div class="label-input">
            <label for="year">Рік:</label>
            <input type="text" name="year" id="year"/>
        </div>
        <div class="label-input">
            <label for="year_count">Кількість пісень:</label>
            <input type="text" name="year_count" id="year_count"/>
        </div>
        <div class="buttons">
            <button type="submit" name="add" value="1">Додати</button>
            <button type="submit" name="submit" value="1">ОК</button>
        </div>
    </form>
</div>

</body>
</html>