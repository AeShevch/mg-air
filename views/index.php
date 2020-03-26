<?php
/**
 *  Файл представления Index - выводит сгенерированную движком информацию на главной странице магазина.
 *  В этом файле доступны следующие данные:
 *   <code>
 *    $data['recommendProducts'] => Массив рекомендуемых товаров
 *    $data['newProducts'] => Массив товаров новинок
 *    $data['saleProducts'] => Массив товаров распродажи
 *    $data['titleCategory'] => Название категории
 *    $data['cat_desc'] => Описание категории
 *    $data['meta_title'] => Значение meta тега для страницы
 *    $data['meta_keywords'] => Значение meta_keywords тега для страницы
 *    $data['meta_desc'] => Значение meta_desc тега для страницы
 *    $data['currency'] => Текущая валюта магазина
 *    $data['actionButton'] => тип кнопки в мини карточке товара
 *   </code>
 *
 *   Получить подробную информацию о каждом элементе массива $data, можно вставив следующую строку кода в верстку файла.
 *   <code>
 *    <?php viewData($data['saleProducts']); ?>
 *   </code>
 *
 *   Вывести содержание элементов массива $data, можно вставив следующую строку кода в верстку файла.
 *   <code>
 *    <?php echo $data['saleProducts']; ?>
 *   </code>
 *
 *   <b>Внимание!</b> Файл предназначен только для форматированного вывода данных на страницу магазина. Категорически не рекомендуется выполнять в нем запросы к БД сайта или реализовывать сложную программную логику логику.
 * @author Авдеев Марк <mark-avdeev@mail.ru>
 * @package moguta.cms
 * @subpackage Views
 */
// Установка значений в метатеги title, keywords, description.
mgSEO($data);
?>

<?php
// Для отладки
// console_log($data); ?>

<?php
// Проверяем подключен ли плагин слайдера и выводим его шорткод
if (class_exists('Slider') && MG::get('templateParams')['SLIDER']['activity'] === 'true') { ?>
<section class="a-slider <?php echo MG::get('templateParams')['SLIDER']['sliderFullScreen'] !== 'true' ? 'a-slider_width_full container' : ''; ?>">
    [mgslider id="<?php echo MG::get('templateParams')['SLIDER']['sliderId']; ?>"]
</section>
<?php } ?>

<?php
// Плитка категорий
if (MG::get('templateParams')['CATEGORIES_GRID']['activity'] === 'true') {
    component('categories-grid');
}
?>

<?php
// Группы товаров
if (MG::get('templateParams')['PRODUCT_GROUPS']['activity'] === 'true') {
    component('groups', $data);
}
?>

<?php
// Если включен плагин брендов, то выводим его
if (class_exists('Brands') && MG::get('templateParams')['BRANDS_GRID']['activity'] === 'true'): ?>
<section class="a-brands-grid">
    [mg-brand]
</section>
<?php endif; ?>


<?php
// Если заполнено описание страницы, то выводим его
if (!empty($data['cat_desc'] ) && MG::get('templateParams')['SITE_DESCRIPTION']['activity'] === 'true'): ?>
<section class="a-page-description">
    <?php echo $data['cat_desc'] ?>
</section>
<?php endif; ?>
