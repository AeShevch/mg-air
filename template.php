<?php /*
Template Name: Air
Author: Shevchenko
Version: 0.0.1
*/ ?>

<!DOCTYPE html>

<html <?php getHtmlAttributes(); ?>>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <?php
    /**
     * Добавляем предзагрузку файла стилей
     * @link https://developer.mozilla.org/ru/docs/Web/HTML/Preloading_content
     * */
    $mainStyleUrl = getMainStyleLink();
    if ($mainStyleUrl !== '') { ?>
    <link rel="preload" href="<?php echo $mainStyleUrl ?>" as="style">
    <?php } ?>

    <?php
    // Полифил для css-переменных
    mgAddMeta('lib/css-vars-ponyfill.js'); ?>

    <?php
    // Выводим метатеги страницы, стили шаблона и плагинов, подключенные через mgAddMeta,
    // а также jquery из mg-core/scripts
    mgMeta("meta", "css", "jquery"); ?>
</head>
<body class="<?php MG::addBodyClass('a-'); ?>" <?php backgroundSite(); ?>">

<?php
// SVG-иконки
component('svg-icons');
?>

<?php
// Шапка сайта
// layout/layout_header.php
layout('header', $data);
?>
<?php
// Проверяем подключен ли плагин слайдера и выводим его шорткод
if (class_exists('Slider')) { ?>
    <section class="a-slider <?php echo MG::get('templateParams')['SLIDER']['sliderFullScreen'] !== 'true' ? 'a-slider_width_full container' : ''; ?>">
        [mgslider id="<?php echo MG::get('templateParams')['SLIDER']['sliderId']; ?>"]
    </section>
<?php } ?>

<?php
// Главный контейнер с контентом страницы
// layout/layout_page.php
layout('page'); ?>

<?php
// Шапка сайта
// layout/layout_footer.php
layout('footer');
?>

<?php
// Подключение общего скрипта шаблона
mgAddMeta('js/bundle.js'); ?>

<?php
// Подключение всех js-скриптов движка, плагинов, компонентов
// а также всех скриптов, подключенных через функции addScript и mgAddMeta
mgMeta('js'); ?>
</body>
</html>


