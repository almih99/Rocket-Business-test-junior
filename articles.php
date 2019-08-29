<?php

$baseUrl = 'articles.php';
$page_size = 6;

// db connection options on almih99.OOOwebhost.com
// /*
$dbname = 'id10700845_rocket_business_test_junior';
$user = 'id10700845_rocketbusiness';
$pwd = '123654a.';
// */

// db connection options on localhost
/*
$dbname = 'rocket_business_test_junior';
$user = 'rocketbusiness';
$pwd = '123654a.';
*/

// establish conntction to db
$db = new PDO(  "mysql:host=localhost;dbname=$dbname",
                $user, $pwd);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

// get amount of records
$res = $db->query('SELECT count(*) from articles');
if($res!==false) {
    $count=$res->fetch()[0];
} else {
    $count=0;
    echo "<br> can't get amount of records in database </br>";
}

// get current page
$page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
$page = max(1, $page);

/////////////////////////////////////////////////////////////////////
// inserts one pagination button with aproupriated style
function instertPaginationItem($index, $currentPage, $maxPage) {
    global $baseUrl;
    $currentPageMark = ($index==$currentPage) ? 'pager__item_active' : '';
    echo "<li class='pager__item $currentPageMark'>
            <a href='$baseUrl?page=$index' class='pager__link'>$index</a>
          </li>";
}

/////////////////////////////////////////////////////////////////////
// inserts ellipses
function insertPaginationEllepsis() {
    echo "<li class='pager__item'>
            <span class='pager__span'>...</span>
          </li>";
}

/////////////////////////////////////////////////////////////////////
// inserts pagination system in a point
function insertPagination($currentPage, $maxPage) {
    // list as whole
    echo "<ul class='pager main__top-pager'>";
        instertPaginationItem(1, $currentPage, $maxPage); // the first item - show always
        // show ellipses if it is necessary
        if($currentPage >= 4 && $maxPage > 4) {
            insertPaginationEllepsis();
        }
        for($i=2; $i<$maxPage; $i++) { // center items
            if(abs($currentPage-$i)<2
                    || ($currentPage<3 && $i <= 4)
                    || ($maxPage-$currentPage<3 && $i> $maxPage-4)) {
                instertPaginationItem($i, $currentPage, $maxPage);
            }
        }
        // show ellipses if it is necessary
        if($maxPage - $currentPage >= 3 && $maxPage > 4) {
            insertPaginationEllepsis();
        }
        // the last item - show always, except there is only one page
        if($maxPage>1) {
            instertPaginationItem($maxPage, $currentPage, $maxPage);
        }
    echo '</ul>';
}
/////////////////////////////////////////////////////////////////////
// inserts list of articles
function insertArticles ($db, $page) {
    global $page_size;
    // prepare and make query
    $query = $db->prepare(" SELECT `header`, `text`, `image_url`, `link_url`
    FROM `articles` LIMIT :pagesize OFFSET :ofs");
    if(! $query->execute(['pagesize' => $page_size,'ofs' => ($page-1) * $page_size])) {
        $err = $query->errorInfo();
        print_r($err);
        die("<br>Problem with acess to database<br>");
    }
    // for each entry
    while($entry = $query->fetch()) {
        ?>
        <article class="article articles-list__entry">
            <a href="<?= $entry["link_url"] ?>" class="article__link">
                <h2 class="article__header"><?= $entry["header"] ?></h2>
                <img src="img/previews/<?= $entry["image_url"] ?>" alt="random image" class="article__image">
                <div class="article__body">
                    <p class="article__para"><?= $entry["text"] ?></p>
                </div>
            </a>
        </article>
        <?php
    } 
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Статьи</title>
    <link rel="stylesheet" href="main.css">
</head>
<body class="article-page">

    <header class="header article-page__header">

        <nav class="navbar">
            <button type="button" class="main-menu__button" onclick="document.querySelector('.main-menu').classList.toggle('main-menu_expanded');">
                <span class="main-menu__button-line">&nbsp;</span>
                <span class="main-menu__button-line">&nbsp;</span>
                <span class="main-menu__button-line">&nbsp;</span>
            </button>
            <ul class="main-menu">
                <li class="main-menu__menu-item"><a class="main-menu__link" href="#">О компании</a></li>
                <li class="main-menu__menu-item"><a class="main-menu__link" href="#">Доставка</a></li>
                <li class="main-menu__menu-item"><a class="main-menu__link" href="#">Оплата</a></li>
                <li class="main-menu__menu-item"><a class="main-menu__link" href="#">Сервис</a></li>
                <li class="main-menu__menu-item"><a class="main-menu__link" href="#">Возврат</a></li>
                <li class="main-menu__menu-item"><a class="main-menu__link" href="#">Статьи</a></li>
                <li class="main-menu__menu-item"><a class="main-menu__link" href="#">Контакты</a></li>
            </ul>

        </nav>

        <div class="control-panel">
            <a href="#" class="site-logo control-panel__logo"></a>
            <div class="search-field control-panel__search-field">
                <div class="search-field__icon"></div>
                <input type="text" placeholder="Поиск по товарам" class="search-field__input">
                <input type="button" value="go" class="search-field__button">
            </div>
            <div class="control-panel__strut"></div>
            <div class="work-hour control-panel__work-hour">
                <div class="work-hour__phone">8 (800) 707-99-24</div>
                <div class="work-hour__time-span">9.00 - 20.00 ежедневно</div>
            </div>
            <div class="signs-panel">
                <a href="#" class="signs-panel__item signs-panel__item_type_chart signs-panel__item_muted">0</a>
                <a href="#" class="signs-panel__item signs-panel__item_type_likes">6</a>
                <a href="#" class="signs-panel__item signs-panel__item_type_basket">17</a>
            </div>
        </div>

        <ul class="production-selector">
            <li class="production-selector__item">
                <a href="javascript:document.querySelector('.production-selector').classList.toggle('production-selector_expanded');void(0);" class="production-selector__link production-selector__link_main">Продукция<br><div class="production-selector__link-logo"></div></a>
            </li>
            <li class="production-selector__item">
                    <a href="#" class="production-selector__link">Стабилизаторы 220В</a>
            </li>
            <li class="production-selector__item">
                    <a href="#" class="production-selector__link">Стабилизаторы 380В</a>
            </li>
            <li class="production-selector__item">
                    <a href="#" class="production-selector__link">Генераторы 220В</a>
            </li>
            <li class="production-selector__item">
                    <a href="#" class="production-selector__link">Генераторы 380В</a>
            </li>
            <li class="production-selector__item">
                    <a href="#" class="production-selector__link">ИБП и батареи</a>
            </li>
            <li class="production-selector__item">
                    <a href="#" class="production-selector__link">Прочая техника</a>
            </li>
            <li class="production-selector__item">
                    <a href="#" class="production-selector__link">Услуги</a>
            </li>
            <li class="production-selector__item">
                    <a href="#" class="production-selector__link production-selector__link_inviting">Акции</a>
            </li>
        </ul>

        <ul class="breadcramb">
            <li class="breadcramb__item"><a href="#" class="breadcramb__link">Главная</a></li>
            <li class="breadcramb__item"><a href="#" class="breadcramb__link">Статьи</a></li>
        </ul>
    </header>

    <main class="main article-page__main">
        <h1 class="level-1-header main__level-1-header">Полезная информация</h1>

        <?php insertPagination($page, ceil( $count / $page_size)) ?>

        <div class="articles-list">
            <?php insertArticles($db, $page); ?>
        </div>

        <?php insertPagination($page, ceil( $count / $page_size)) ?>

    </main>

    <footer class="footer article-page__footer">

        <div class="address-block footer__address">
            <address class="address-block__addr">121471, г. Москва ул. Рябиновая 55 стр. 28</address>
            <a href="mailto:prestizh06@mail.ru" class="address-block__email">prestizh06@mail.ru</a>
            <div class="address-block__phone">8(800)707-99-24</div>
            <a href="#" class="address-block__link">контакты</a>
        </div>

        <div class="operating-schedule footer__operating-schedule">
            <div class="operating-schedule__header">Режим работы:</div>
            <div class="operating-schedule__item">Пн&ndash;чт c 8.00 до 19.00</div>
            <div class="operating-schedule__item">Пт c 8.00 до 17.00</div>
            <div class="operating-schedule__item">Сб c 10.00 до 15.00</div>
            <div class="operating-schedule__item">Вс (по предварительной договоренности).</div>
        </div>

        <div class="footer-links footer__footer-links">
            <a href="#" class="footer-links__item">О компании</a>
            <a href="#" class="footer-links__item">Оплата</a>
            <a href="#" class="footer-links__item">Акции</a>
            <a href="#" class="footer-links__item">Сервис</a>
            <a href="#" class="footer-links__item">Доставка</a>
            <a href="#" class="footer-links__item">Возврат</a>
            <a href="#" class="footer-links__item footer-links__item_long">Политика обработки персональных данных</a>  
        </div>

        <a href="#" class="rocket-business-logo footer__logo">Разработка<br> и продвижение сайта</a>

    </footer>
    
</body>
</html>