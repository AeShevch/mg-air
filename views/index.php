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
} ?>

<?php
// Вкладки с товарами
if (MG::get('templateParams')['PRODUCT_TABS']['activity'] === 'true') {
    component('product-tabs');
} ?>

<?php
// Товар с видео
if (MG::get('templateParams')['VIDEO_PRODUCT_1']['activity'] === 'true') {
    $videoBlockId = 1;
    component(
      'video-product',
      [
        'videoBlockId' => $videoBlockId,
        'video' => [
          'url' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['videoUrl'],
          'title' => [
            'text' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['videoTitle'],
            'color' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['color_videoTitleColor'],
            'size' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['videoTitleSize']
          ],
          'desc' => [
            'text' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['videoDesc'],
            'color' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['color_videoDescColor'],
            'size' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['videoDescSize'],
          ],
          'poster' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['videoPoster'],
        ],
        'productCode' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['productCode'],
        'position' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['select_position']
      ]
    );
} ?>

<?php
// Товар с видео
if (MG::get('templateParams')['VIDEO_PRODUCT_1']['activity'] === 'true') {
    $videoBlockId = 2;
    component(
      'video-product',
      [
        'videoBlockId' => $videoBlockId,
        'video' => [
          'url' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['videoUrl'],
          'title' => [
            'text' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['videoTitle'],
            'color' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['color_videoTitleColor'],
            'size' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['videoTitleSize']
          ],
          'desc' => [
            'text' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['videoDesc'],
            'color' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['color_videoDescColor'],
            'size' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['videoDescSize'],
          ],
          'poster' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['img_videoPoster'],
        ],
        'productCode' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['productCode'],
        'position' => MG::get('templateParams')['VIDEO_PRODUCT_' . $videoBlockId ]['select_position']
      ]
    );
} ?>

<?php
// Группы товаров
if (MG::get('templateParams')['GROUPS']['activity'] === 'true') {
    component(
      'groups',
      [
        1 => [
          'title' => 'Популярное',
          'products' => $data['recommendProducts']
        ],
        2 => [
          'title' => 'Новые поступления',
          'products' => $data['newProducts']
        ],
        3 => [
          'title' => 'Снижаем цены',
          'products' => $data['saleProducts']
        ]
      ]
    );
} ?>

<?php
// Если включен плагин брендов, то выводим его
if (class_exists('Brands') && MG::get('templateParams')['BRANDS_GRID']['activity'] === 'true') {
    component('brands-grid');
} ?>

<?php
// Если включен плагин «Продающие триггеры», то выводим его
if (class_exists('trigger') && MG::get('templateParams')['TRIGGERS']['activity'] === 'true') {
    component('triggers');
} ?>

<?php
// Если заполнено описание страницы, то выводим его
if (!empty($data['cat_desc'] ) && MG::get('templateParams')['SITE_DESCRIPTION']['activity'] === 'true'): ?>
<section class="a-page-description">
    <div class="container a-page-description__inner">
        <?php echo $data['cat_desc'] ?>
    </div>
</section>
<?php endif; ?>
