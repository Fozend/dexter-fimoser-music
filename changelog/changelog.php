<?php
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'uk';

$translations = [
    'en' => [
        'header' => "What's new?",
        'main_1' => "Implemented basic functionality of the main page, including:",
        'point_1_1' => "A list of music. Added the ability to listen to and download songs.",
        'point_1_2' => "Added the ability to sort songs.",
        'point_1_3' => "A menu has appeared.",
        'point_1_4' => "In the menu, you can filter songs by artist, album, new songs, and singles. The artist and album filters can be combined.",
        'point_1_5' => "Contact information added.",
        'point_1_6' => "Filters by genre and category have been added but do not work yet. Next to them is the label (in development).",
        'point_1_7' => "Song search implemented. So far, the search works only by title/album/year/artist. If you try to combine these, the search will fail.",
        'point_2_1' => "Removed contact information from the menu.",
        'point_2_2' => "Added icons to menu items.",
        'point_2_3' => "The menu now contains a link to this article with the change log.",
        'point_2_4' => "Added dynamic background change.",
        'point_2_5' => "Added page navigation.",
        'point_2_6' => "Fixed bug where success/error messages broke menu styling.",
        'point_2_7' => "Added a logo positioned next to the navigation.",
        'point_2_8' => "Adjusted music blocks to avoid conflict with the header by adding scroll to the song feed.",
        'point_2_9' => "Added a page with a map.",
        'point_2_10' => "Added an 'Interesting' page, currently empty.",
        'point_2_11' => "Settings added to the menu.",
 
        'point_3_1' => "The Map page now shows iconic locations from the show, pinned across Miami and the surrounding area. It's an interactive Google My Maps embed — zoom, pan, and click any marker for details, all without leaving the site.",
        'point_3_2' => "Added a music video page: for the selected track, the site automatically searches YouTube (by song title and artist) via the YouTube Data API and embeds the most relevant result found.",
        'point_3_3' => "From the home page, you can now open a track's video with a single click on its title — it plays in an embedded player right on the site, though you can still open it on YouTube directly from the player's own controls.",
        'point_3_4' => "The 'Interesting' page now features a chart of songs grouped by musical era (the '50s, '60s, '90s, 2020s, and other decades). It illustrates how musical taste in pop culture forms over time — the best songs of an era stay relevant for years, while newer tracks haven't been tested by time yet.",
        'point_3_5' => "If you disagree with the distribution built from the site's own song list, you can enter your own data (a year and how many songs you know from it) and instantly see your own version of the chart, without affecting the site's built-in statistics.",
        'point_3_6' => "Added a quote from Zhang Xin about the symbolic value of architecture, echoing the chart's underlying idea: a work's true value — whether a building or a song — only reveals itself with time.",
 
        'point_4_1' => "Added a page listing all registered user accounts.",
        'point_4_2' => "A new user can be added by entering a login and password (minimum 6 characters); the password is hashed immediately and is never stored or shown in plain text.",
        'point_4_3' => "Every record has a unique ID, a username, and a last-updated timestamp; the password itself is shown on screen only as a row of asterisks, never the real characters.",
        'point_4_4' => "Any record can be edited or deleted. Editing the login or password requires confirming the user's current password first — without it, no changes go through; a new login is also checked for uniqueness against the other accounts.",
        'point_4_5' => "Added a new Telegram page with the official Telegram widget embedded. For now it shows a single demo post from an unrelated channel, just to showcase the widget — real posts from the site's own themed channel will follow later.",
 
        'point_5_1' => "Removed a leftover, unreachable block of duplicate edit-row code from the user accounts admin panel.",
        'point_5_2' => "Fixed a chart legend sizing bug on the 'Interesting' page's decade diagram, where label width was measured incorrectly.",
        'point_5_3' => "Added a configuration template file for setting up the project on a new machine.",
 
        'point_6_1' => "Reorganized the entire project into feature folders (database logic, config/helpers, shared page layout, Telegram backend, changelog, fonts) instead of one flat folder.",
        'point_6_2' => "Extracted the shared page header, navigation, and settings panel into a single template reused by every page.",
        'point_6_3' => "Extracted the background-picker logic into a shared, reusable file.",
        'point_6_4' => "Replaced the single embedded Telegram post with a full infinite-scroll Telegram feed page, now pulling real posts from the site's own channel.",
        'point_6_5' => "Added server-side verification of Telegram posts before they're embedded, so deleted or missing posts are skipped instead of showing 'Post not found' cards.",
        'point_6_6' => "Added caching for the Telegram post checks so repeat visits don't re-verify the same posts.",
        'point_6_7' => "Fixed the sorting panel layout on the home page: the 'sort by' bar now stays fixed at the top while the song list scrolls beneath it, with a hidden scrollbar and a stable gap between them.",
        'point_6_8' => "Extracted functionality the accounts admin panel's into its own file.",
        'point_6_9' => "Removed the 'Sort by' button — songs are now sorted automatically as soon as a sorting criterion is selected.",
        'point_6_10' => "Redesigned the sorting panel.",
        'point_6_11' => "Completely redesigned the music player, including both its design and functionality. When switching from one song to another, the previous song is now paused instead of being stopped, so it can later be resumed from the same position.",
    ],
    'uk' => [
        'header' => "Що нового?",
        'main_1' => "Реалізовано основну функціональність головної сторінки, включаючи:",
        'point_1_1' => "Список музики. Додана можливість слухати та завантажувати пісні.",
        'point_1_2' => "Додано можливість сортування пісень.",
        'point_1_3' => "З'явилося меню.",
        'point_1_4' => "У меню можна фільтрувати пісні за артистом, альбомом, новими піснями та синглами. Фільтри за артистом і альбомом можна комбінувати.",
        'point_1_5' => "Додано контактну інформацію.",
        'point_1_6' => "Додані фільтри за жанром і категорією, але вони ще не працюють. Біля них є позначка (в розробці).",
        'point_1_7' => "Реалізовано пошук пісень. Поки що пошук працює тільки за назвою/альбомом/роком/артистом. Якщо спробувати поєднати ці критерії, пошук не вдасться.",
        'point_2_1' => "Видалено контактну інформацію з меню.",
        'point_2_2' => "Додано іконки до пунктів меню.",
        'point_2_3' => "Меню тепер містить посилання на цю статтю з журналом змін.",
        'point_2_4' => "Додано динамічну зміну фону.",
        'point_2_5' => "Додана навігація по сторінкам.",
        'point_2_6' => "Виправлено баг, що вивід повідомлення про успіх/помилку ламав стилі в меню.",
        'point_2_7' => "Додано логотип, який розміщується поряд з навігацією.",
        'point_2_8' => "Змінено розмір блоків з музикою, тепер, щоб не конфліктувати з хедером, до стрічки пісень додано прокрутку.",
        'point_2_9' => "Додано сторінку з мапою.",
        'point_2_10' => "Додано сторінку 'Цікаве', поки пуста.",
        'point_2_11' => "В меню додано налаштування.",
 
        'point_3_1' => "Сторінка з мапою тепер відображає культові локації серіалу на мапі Маямі та околиць. Це інтерактивна вбудована карта Google My Maps — можна наближати, панорамувати та клікати по мітках для деталей, не покидаючи сайт.",
        'point_3_2' => "Додано сторінку з відеокліпами: для обраної пісні сайт автоматично шукає відповідне відео на YouTube (за назвою пісні та виконавцем) через YouTube Data API і вбудовує найрелевантніший знайдений результат.",
        'point_3_3' => "З головної сторінки тепер можна перейти на відеокліп пісні одним кліком по її назві — відео відкривається вбудованим у сайт плеєром, але за бажанням його завжди можна відкрити безпосередньо на YouTube через елементи керування плеєра.",
        'point_3_4' => "Сторінка 'Цікаве' тепер містить діаграму розподілу пісень за музичними епохами (50-ті, 60-ті, 90-ті, 2020-ті та інші десятиліття). Вона наочно показує, як формується музичний смак у популярній культурі: найкращі пісні епохи залишаються актуальними роками, тоді як нові треки ще мають пройти це випробування часом.",
        'point_3_5' => "Якщо не погоджуєтесь із розподілом, побудованим на основі пісень з нашого сайту — можна ввести власні дані (рік і кількість відомих вам пісень цього року) і одразу побачити свій варіант діаграми, не змінюючи загальну статистику сайту.",
        'point_3_6' => "На сторінці додано цитату Zhang Xin про символічну цінність архітектури — вона перегукується з ідеєю діаграми: справжня цінність твору, будівлі чи пісні, розкривається лише з часом.",
 
        'point_4_1' => "Додано сторінку зі списком зареєстрованих облікових записів користувачів.",
        'point_4_2' => "Можна додати нового користувача, вказавши логін і пароль (мінімум 6 символів); пароль одразу хешується і ніколи не зберігається та не показується у відкритому вигляді.",
        'point_4_3' => "Кожен запис має унікальний ID, ім'я користувача та час останнього оновлення; на екрані пароль показано умовним рядом зірочок замість справжніх символів.",
        'point_4_4' => "Кожен запис можна відредагувати або видалити. Редагування логіна чи пароля вимагає спершу підтвердити поточний пароль користувача — без цього зміни не проходять; новий логін також перевіряється на унікальність серед інших записів.",
        'point_4_5' => "Додано нову сторінку Telegram з інтегрованим офіційним віджетом Telegram. Поки що там відображається лише один демонстраційний пост зі стороннього каналу — просто як приклад роботи віджета; реальні пости з власного тематичного каналу сайту з'являться пізніше.",
 
        'point_5_1' => "Видалено мертвий, недосяжний блок дублюючого коду редагування запису з адмін-панелі користувачів",
        'point_5_2' => "Виправлено баг у розрахунку ширини легенди діаграми на сторінці 'Цікаве' — ширина підписів рахувалась некоректно.",
        'point_5_3' => "Додано шаблонний конфігураційний файл для налаштування проекту.",
 
        'point_6_1' => "Весь проект реорганізовано у тематичні теки (логіка бази даних, конфіг/хелпери, спільна розмітка сторінок, Telegram-бекенд, чейнджлог, шрифти) замість однієї спільної теки.",
        'point_6_2' => "Спільний хедер сторінки, навігацію та панель налаштувань винесено в один шаблон, який використовують усі сторінки.",
        'point_6_3' => "Логіку вибору фону винесено в окремий спільний файл.",
        'point_6_4' => "Замість одного вбудованого поста Telegram додано повноцінну сторінку зі стрічкою постів і нескінченним скролом, яка тепер підтягує реальні пости з власного каналу сайту.",
        'point_6_5' => "Додано серверну перевірку постів Telegram перед вбудовуванням — видалені чи відсутні пости тепер пропускаються, замість показу карток 'Post not found'.",
        'point_6_6' => "Додано кешування перевірки постів Telegram, щоб повторні візити не перевіряли ті самі пости заново.",
        'point_6_7' => "Виправлено розкладку панелі сортування на головній сторінці: блок 'Сортувати за' тепер лишається зафіксованим зверху, поки список пісень прокручується під ним, зі схованим скролбаром і стабільним відступом між ними.",
        'point_6_8' => "Функціонал адмін-панелі користувачів винесено в окремий файл.",
        'point_6_9' => "Видалено кнопку «Сортувати за» — тепер пісні сортуються автоматично одразу після вибору критерію.",
        'point_6_10' => "Повністю перероблено дизайн панелі сортування.",
        'point_6_11' => "Повністю перероблено музичний плеєр — оновлено його дизайн і функціонал. При перемиканні на іншу пісню попередня тепер ставиться на паузу, тому її можна пізніше продовжити відтворювати з того самого місця.",
    ]
];
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change.log</title>
        <link rel="icon" type="image/png" href="../logo/logo.png">
    <link rel="stylesheet" href="changelog.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="changelog-header">
        <p><?php echo $translations[$lang]['header']; ?></p>
        
        <div class="lang">
            <i class="fa-solid fa-language"></i>
            <form method="get" style="display: inline;">
                <select name="lang" onchange="this.form.submit()">
                    <option value="uk" <?php if ($lang === 'uk') echo 'selected'; ?>>Українська</option>
                    <option value="en" <?php if ($lang === 'en') echo 'selected'; ?>>English</option>
                </select>
            </form>
        </div>
    </div>
    <div class="changelog">
        <p class="data">16.10.2024</p>
        <p class="version">alpha 1.0.0.1</p>
        <p class="main"><?php echo $translations[$lang]['main_1']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_1_1']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_1_2']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_1_3']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_1_4']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_1_5']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_1_6']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_1_7']; ?></p>
    </div>
    <div class="changelog">
        <p class="data">26.10.2024</p>
        <p class="version">alpha 1.0.0.2</p>
        <p class="point"><?php echo $translations[$lang]['point_2_1']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_2_2']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_2_3']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_2_4']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_2_5']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_2_6']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_2_7']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_2_8']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_2_9']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_2_10']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_2_11']; ?></p>
    </div>
    <div class="changelog">
        <p class="data">30.10.2024</p>
        <p class="version">alpha 1.0.0.3</p>
        <p class="point"><?php echo $translations[$lang]['point_3_1']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_3_2']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_3_3']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_3_4']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_3_5']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_3_6']; ?></p>
    </div>
    <div class="changelog">
        <p class="data">27.11.2024</p>
        <p class="version">alpha 1.0.0.4</p>
        <p class="point"><?php echo $translations[$lang]['point_4_1']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_4_2']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_4_3']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_4_4']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_4_5']; ?></p>
    </div>
    <div class="changelog">
        <p class="data">25.08.2026</p>
        <p class="version">alpha 1.1.0.1</p>
        <p class="point"><?php echo $translations[$lang]['point_5_1']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_5_2']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_5_3']; ?></p>
    </div>
    <div class="changelog">
        <p class="data">28.08.2026</p>
        <p class="version">alpha 1.1.0.2</p>
        <p class="point"><?php echo $translations[$lang]['point_6_1']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_6_2']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_6_3']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_6_4']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_6_5']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_6_6']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_6_7']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_6_8']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_6_9']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_6_10']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_6_11']; ?></p>
        <p class="point"><?php echo $translations[$lang]['point_6_12']; ?></p>
    </div>

</body>
</html>