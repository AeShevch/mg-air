<?php
/**
 *  Файл представления Catalog - выводит сгенерированную движком информацию на странице сайта с каталогом товаров.
 *  В этом  файле доступны следующие данные:
 *   <code>
 *    $data['items'] => Массив товаров,
 *    $data['titleCategory'] => Название открытой категории,
 *    $data['cat_desc'] => Описание открытой категории,
 *    $data['pager'] => html верстка  для навигации страниц,
 *    $data['searchData'] => Результат поисковой выдачи,
 *    $data['meta_title'] => Значение meta тега для страницы,
 *    $data['meta_keywords'] => Значение meta_keywords тега для страницы,
 *    $data['meta_desc'] => Значение meta_desc тега для страницы,
 *    $data['currency'] => Текущая валюта магазина,
 *    $data['actionButton'] => Тип кнопки в мини карточке товара,
 *    $data['cat_desc_seo'] => SEO описание каталога,
 *    $data['seo_alt'] => Алтернативное подпись изображение категории,
 *    $data['seo_title'] => Title изображения категории
 *   </code>
 *
 *   Получить подробную информацию о каждом элементе массива $data, можно вставив следующую строку кода в верстку файла.
 *   <code>
 *    <?php viewData($data['items']); ?>
 *   </code>
 *
 *   Вывести содержание элементов массива $data, можно вставив следующую строку кода в верстку файла.
 *   <code>
 *    <?php echo $data['items']; ?>
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

<?php if (class_exists('BreadCrumbs')): ?>
<div class="a-bread-crumbs">
    <div class="container">
        [brcr]
    </div>
</div>
<?php endif; ?>

<?php
if (!isSearch() && MG::getSetting('picturesCategory') == 'true') {
// Подкатегории
    component('categories-grid', $data['cat_id']);
}
?>

<div class="a-catalog">
    <div class="container">
        <div class="a-catalog__inner row">
            <aside class="a-catalog__side a-catalog__side_position_left col-md-4 col-lg-3 col-xl-3">
                <?php if (!isSearch()): ?>
                <?php
                // Применённые фильтры
                component(
                  'filter/applied',
                  $data['applyFilter']
                );

                // Компонент фильтра
                component('filter');
                ?>
                <?php endif; ?>
            </aside>
            <main class="a-catalog__main a-catalog-main col-md-12 col-lg-9 col-xl-9">
                <div class="a-catalog-main__options a-catalog-options">
                    <h1 class="a-catalog-main__title">
                    <?php if (!isSearch()): ?>
                        <?php echo $data['titleCategory'] . ' ' . '(' . $data['totalCountItems'] . ')'?>
                    <?php else: ?>
                        <?php echo lang('search1'); ?>
                        <b class="c-title__search">
                            «<?php echo $data['searchData']['keyword'] ?>»
                        </b>
                        <?php echo lang('search2'); ?>
                        <b class="c-title__search">
                            <?php
                            echo mgDeclensionNum(
                              $data['searchData']['count'],
                              array(
                                lang('search3-1'),
                                lang('search3-2'),
                                lang('search3-3')
                              )
                            );
                            ?>
                        </b>
                    <?php endif; ?>
                    </h1>
                    <div class="a-catalog-options__inner">
                        <div class="a-catalog-main__sort">
                            <?php
                            // Сортировка товаров
                            component('duplicative-sort'); ?>
                        </div>
                        <div class="a-catalog-main__grid-set d-none d-sm-block">
                            <?php
                            // Перключатель количества товаров на строку
                            component('grid-switcher'); ?>
                        </div>
                    </div>
                </div>

                <?php if (!empty($data['cat_desc'])): ?>
                <div class="a-catalog-main__desc">
                    <p><?php echo $data['cat_desc'] ?></p>
                </div>
                <?php endif; ?>

                <div class="a-catalog-main__list a-catalog-products row js-products-list">
                    <?php foreach ($data['items'] as $item) { ?>
                    <div class="col-6 <?php echo isset($_COOKIE['grid']) ? $_COOKIE['grid'] : 'col-md-4'; ?>">
                        <?php
                        // Миникарточка товара
                        component(
                          'catalog/item',
                          $item
                        ); ?>
                    </div>
                    <?php } ?>
                </div>

                <?php if (!empty($data['pager'])): ?>
                <div class="a-pagination">
                    <?php component('pagination', $data['pager']); ?>
                </div>
                <?php endif; ?>

                <?php if ($data['cat_desc_seo']) { ?>
                 <div class="a-catalog-main__desc a-catalog-main__desc_bottom">
                     <?php echo $data['cat_desc_seo'] ?>
                 </div>
                <?php } ?>
            </main>
        </div>
    </div>
</div>
