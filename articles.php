<?php

$page_size = 6;

// conntction to db
$db = new PDO('mysql:host=localhost;dbname=rocket_business_test_junior', 'rocketbusiness', '123654a.');
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

// amount of records
$count = $db->query('SELECT count(*) from articles')->fetch()[0];

// get current page
$page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
$page = max(1, $page);

function insertPagination($currentPage, $maxPage) {
    $baseUrl = 'articles.php';
    // list as whole
    echo "<ul class='pager main__top-pager'>";
        // the first item - show always
        $currentPageMark = (1==$currentPage) ? 'pager__item_active' : '';
        echo "<li class='pager__item $currentPageMark'>
                <a href='$baseUrl?page=1' class='pager__link'>1</a>
            </li>";
        // show ellipses if it is necessary
        if($currentPage >= 4) {
            echo "<li class='pager__item'>
                    <span class='pager__span'>...</span>
                </li>";
        }
        // center items
        for($i=2; $i<$maxPage; $i++) {
            if(abs($currentPage-$i)<2
                || ($currentPage<3 && $i <= 4)
                || ($maxPage-$currentPage<3 && $i> $maxPage-4)) {
                $currentPageMark = ($i==$currentPage) ? 'pager__item_active' : '';
                echo "<li class='pager__item $currentPageMark'>
                        <a href='$baseUrl?page=$i' class='pager__link'>$i</a>
                    </li>";
            }
        }
        // show ellipses if it is necessary
        if($maxPage - $currentPage >= 3) {
            echo "<li class='pager__item'>
                    <span class='pager__span'>...</span>
                </li>";
        }
        // the last item - show always
        $currentPageMark = ($maxPage==$currentPage) ? 'pager__item_active' : '';
        echo "<li class='pager__item $currentPageMark'>
                <a href='$baseUrl?page=$maxPage' class='pager__link'>$maxPage</a>
            </li>";

    echo '</ul>';
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

        <?php insertPagination($page, 10) ?>

        <ul class="pager main__top-pager">
            <li class="pager__item pager__item_active"><a href="#" class="pager__link">1</a></li>
            <li class="pager__item pager__item_hidden"><span class="pager__span">...</span></li>
            <li class="pager__item"><a href="#" class="pager__link">2</a></li>
            <li class="pager__item"><a href="#" class="pager__link">3</a></li>
            <li class="pager__item"><a href="#" class="pager__link">4</a></li>
            <li class="pager__item"><span class="pager__span">...</span></li>
            <li class="pager__item"><a href="#" class="pager__link">10</a></li>
        </ul>

        <div class="articles-list">

            <?php
                // prepare query
                $query = $db->prepare(" SELECT `header`, `text`, `image_url`, `link_url`
                                        FROM `articles` LIMIT 6 OFFSET :ofs");
                if(! $query->execute(['ofs' => ($page-1) * $page_size])) {
                    $err = $query->errorInfo();
                    print_r($err);
                    die("<br>Problem with acess to database<br>");
                }

                while($line = $query->fetch()) { ?>
                    <article class="article articles-list__entry">
                        <a href="<?= $line["link_url"] ?>" class="article__link">
                            <h2 class="article__header"><?= $line["header"] ?></h2>
                            <img src="img/previews/<?= $line["image_url"] ?>" alt="какая-то картинка" class="article__image">
                            <div class="article__body">
                                <p class="article__para"><?= $line["text"] ?></p>
                            </div>
                        </a>
                    </article>
            <?php
                } ?>

        </div>

        <ul class="pager main__bottom-pager">
            <li class="pager__item pager__item_active"><a href="#" class="pager__link">1</a></li>
            <li class="pager__item pager__item_hidden"><span class="pager__span">...</span></li>
            <li class="pager__item"><a href="#" class="pager__link">2</a></li>
            <li class="pager__item"><a href="#" class="pager__link">3</a></li>
            <li class="pager__item"><a href="#" class="pager__link">4</a></li>
            <li class="pager__item"><span class="pager__span">...</span></li>
            <li class="pager__item"><a href="#" class="pager__link">10</a></li>
        </ul>  

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