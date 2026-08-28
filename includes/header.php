<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Dexter Fimoser Music' ?></title>
    <link rel="icon" type="image/png" href="logo/logo.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" ...>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { background-image: url('<?= $dexter ?>'); }
    </style>
</head>
<body>

<div class="header">
    <span id="logo"><a href="index.php"><img id="logo" src="logo/logo.png" alt="logo"></a></span>
    <nav id="nav">
        <span class="header-item"><a href="index.php"><i class="fa-solid fa-house icon"></i>Головна</a></span>
        <span class="header-item"><a href="map.php"><i class="fa-solid fa-map-location-dot icon"></i></i>Мапа</a></span>
        <span class="header-item"><a href="videos.php"><i class="fa-brands fa-youtube icon"></i></i>Відео</a></span>
        <span class="header-item"><a href="interesting.php"><i class="fa-regular fa-lightbulb icon"></i>Цікаве</a></span>
        <span class="header-item"><a href="DB.php"><i class="fa-solid fa-users icon"></i>Користувачі</a></span>
        <span class="header-item"><a href="telegram.php"><i class="fa-brands fa-telegram"></i>Telegram</a></span>
    </nav>
</div>

<?php require $menuPartial ?? __DIR__ . '/menu-simple.php'; ?>

<div class="settings-wrapper">
    <input type="checkbox" id="settings-toggle" class="submenu-toggle">

    <div class="settings">
        <span class="settings-label">Налаштування<label for="settings-toggle"><i class="fa-solid fa-xmark icon"></i></label></span>
        
        <label class="tab-fixed" for="gallery-toggle"><i class="fa-regular fa-image icon"></i>Встановити фон</label>
        <input type="checkbox" id="gallery-toggle" class="submenu-toggle">

        <div class="submenu">
            <div class="gallery">
                <?php foreach ($images as $image): ?>
                    <form method="get" style="display: inline;">
                        <input type="hidden" name="background" value="<?php echo $image; ?>">
                        <button type="submit"><img src="<?php echo $image; ?>" alt="Background"></button>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>

        <form method="get" style="display: inline;">
            <input type="hidden" name="background" value="rand">
            <button type="submit" class="tab-fixed"><i class="fa-regular fa-image icon"></i>Кожен раз випадковий фон</button>
        </form>

        <form method="get" style="display: inline;">
            <input type="hidden" name="background" value="default">
            <button type="submit" class="tab-fixed"><i class="fa-regular fa-image icon"></i>Фон за замовчуванням</button>
        </form>

        <div id="contact">
            <p>Contact us:</p>
            <p><i class="fa-solid fa-phone-volume icon"></i> +38(069)-148-8228</p>
            <p><i class="fa-regular fa-envelope icon"></i>freed_rove@gmail.com</p>
            <p><i class="fa-brands fa-telegram icon"></i><a href="https://t.me/Pedr0Filho" target="_blank">t.me/Pedr0Filho</a></p>
        </div>
    </div>
    <div class="text"> 
</div>

<?php if (empty($hideFooter)): ?>
    <div class="footer">
        <p class="subtitle">Dexter Fimoser Music</p>
        <p class="title">Tonight's the night</p>
    </div>
<?php endif; ?>