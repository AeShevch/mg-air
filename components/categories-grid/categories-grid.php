<?php
mgAddMeta('components/categories-grid/categories-grid.css');

$itemsFromCatalogData = true;
$ITEMS_PER_ROW = !empty(MG::get('templateParams')['CATEGORIES_GRID']['itemsPerRow']) ? MG::get('templateParams')['CATEGORIES_GRID']['itemsPerRow'] : '2';
$COL_MD_CLASS = 'col-md-' . (12 / intval($ITEMS_PER_ROW));
$MAX_CATEGORIES_COUNT = !empty(MG::get('templateParams')['CATEGORIES_GRID']['maxCategoriesToShow']) ? MG::get('templateParams')['CATEGORIES_GRID']['maxCategoriesToShow'] : 4;
$ITEMS_HEIGHT = !empty(MG::get('templateParams')['CATEGORIES_GRID']['itemsHeight']) ? MG::get('templateParams')['CATEGORIES_GRID']['itemsHeight'] : '240';

if (!empty($data)) $categories = MG::get('category')->getHierarchyCategory($data, true);

// В адресах картинок категорий, получаемых из getArrayCategory() есть папка /uploads/,
// а в массиве в каталоге нет
$imgAdditionalPath = '/uploads/';

if (empty($data)) {
    $itemsFromCatalogData = false;
    $imgAdditionalPath = '';
    $counter = 0;
    // Получаем категории и сортируем их
    $categories = MG::get('category')->getArrayCategory();
    function cmp_function($a, $b) {
        return ($a['sort'] > $b['sort']);
    }
    uasort($categories, 'cmp_function');
}

// Для отладки
//console_log($categories); ?>

<section class="a-categories-grid">
    <div class="container">
        <nav class="a-categories-grid__inner row a-products-grid">
            <?php
            foreach ($categories as $category): ?>
            <?php
            if ($category['activity'] === '0') continue;
            if (!$itemsFromCatalogData) {
                $counter++;
                if ($category['level'] !== '1') continue;
                if ($counter > $MAX_CATEGORIES_COUNT) break;
            }
            ?>
            <a class="a-categories-grid__item a-category-banner col-6 <?php echo $COL_MD_CLASS; ?> col-12-440width"
               title="<?php echo $category['title']; ?>"
               href="<?php echo $category['link']; ?>">
                <div class="a-category-banner__inner" style="height:<?php echo $ITEMS_HEIGHT; ?>px">
                    <img class="a-category-banner__img"
                         width="580" height="<?php echo $ITEMS_HEIGHT; ?>"
                         loading="lazy"
                         src="<?php echo (!empty($category['image_url']) ? SITE . $imgAdditionalPath . $category['image_url'] : PATH_SITE_TEMPLATE . '/images/nopic.jpg'); ?>"
                         alt="<?php echo $category['title']; ?>">
                    <span class="a-category-banner__title">
                        <?php echo $category['title']; ?>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </nav>
    </div>
</section>
