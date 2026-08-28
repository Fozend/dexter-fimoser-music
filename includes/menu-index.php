<div class="menu">
    <input type="checkbox" id="menu-toggle" class="menu-toggle" />
    <label for="menu-toggle" class="menu-icon"><i class="fa-solid fa-bars"></i></label>
    <div class="tabs">

        <div id="searchsong">
        <form method="get">
            <input type="text" name="search" placeholder="Пошук пісні" required>
            <button type="submit">Пошук</button>
        </form>
        </div>

        <label class="tab" for="artists-toggle"><i class="fa-regular fa-user icon"></i>Виконавці</label>
        <input type="checkbox" id="artists-toggle" class="submenu-toggle">
        <div class="submenu">
            <div class="tab">
            <form method="get">
                <select name="artist" id="artist" onchange="this.form.submit()">
                    <option value="" id="option">Вибрати виконавця</option>
                    <?php foreach ($artists as $artist): ?>
                        <option value="<?php echo $artist; ?>" <?php if ($filterArtist == $artist) echo 'selected'; ?>><?php echo $artist; ?></option>
                    <?php endforeach; ?>
                </select>
            </form>
            </div>
        </div>

        <label class="tab" for="albums-toggle"><i class="fa-solid fa-compact-disc icon"></i>Альбоми</label>
        <input type="checkbox" id="albums-toggle" class="submenu-toggle">
        <div class="submenu">
            <div class="tab">
                <form method="get">
                    <input type="hidden" name="artist" value="<?php echo htmlspecialchars($filterArtist); ?>"> 
                    <select name="album" id="album" onchange="this.form.submit()">
                        <option value="" id="option">Вибрати альбом</option>
                        <?php foreach ($albumsWithArtists as $album => $artist): ?>
                            <option value="<?php echo $album; ?>"><?php echo "{$album} ({$artist})"; ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>

        <form method="get" style="display: inline;">
            <input type="hidden" name="filter" value="new">
            <button type="submit" class="tab"><i class="fa-solid fa-calendar-days icon"></i></i>Нове</button>
        </form>

        <form method="get" style="display: inline;">
            <input type="hidden" name="album" value="Сингл">
            <button type="submit" class="tab"><i class="fa-solid fa-microphone-lines icon"></i></i>Сингли</button>
        </form>
        
        <label class="tab" for="genres-toggle"><i class="fa-solid fa-podcast icon"></i></i>Жанри <i>(у розробці)</i></label>
        <input type="checkbox" id="genres-toggle" class="submenu-toggle">
        <div class="submenu" >
            <button class="tab">Поп</button>
            <button class="tab">Рок</button>
            <button class="tab">Реп</button>
            <button class="tab">Рок-н-ролл</button>
        </div>

        <label class="tab" for="categories-toggle"><i class="fa-solid fa-list icon"></i>Категорії <i>(у розробці)</i></label>
        <input type="checkbox" id="categories-toggle" class="submenu-toggle">
        <div class="submenu">
            <button class="tab">Веселі</button>
            <button class="tab">Сумні</button>
            <button class="tab">Спокійні</button>
            <button class="tab">Агресивні</button>
        </div>

        <label for="settings-toggle" class="tab menu-icon"><i class="fa-solid fa-gear icon"></i>Налаштування</label>

        <div class="menu-inform">
            <p>What's new?</p>
            <p class="header-item"><a href="changelog/changelog.php" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square icon"></i> read more</a></p>
        </div>
    </div>
</div>