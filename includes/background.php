<?php 
$dirimg = './img'; 
$allFiles = scandir($dirimg); 
$images = []; 
foreach ($allFiles as $file) { 
    if ($file !== '.' && $file !== '..') { 
        $images[] = $dirimg . '/' . $file; 
    } 
} 
 
// Check if the user has selected a background
if (isset($_GET['background'])) { 
    if ($_GET['background'] === 'rand') { 
        $dexter = $images[array_rand($images)]; 
        setcookie('background', '', time() - (86400 * 365), "/");  // Delete the cookie for the random background
    } elseif ($_GET['background'] === 'default') { 
        $dexter = './img/dexter1.png'; 
        setcookie('background', $dexter, time() + (86400 * 365), "/"); 
    } else { 
        // A check should be added here to ensure that the value actually exists in $images
        $dexter = $_GET['background']; 
        setcookie('background', $dexter, time() + (86400 * 365), "/"); // The cookie is stored for one year
    } 
} elseif (isset($_COOKIE['background'])) { 
    $dexter = $_COOKIE['background']; 
} else { 
    $dexter = $images[array_rand($images)]; 
} 
 
?>