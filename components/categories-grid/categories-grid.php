<?php
mgAddMeta('components/categories-grid/categories-grid.css');

// Получаем категории и сортируем их
$categories = MG::get('category')->getArrayCategory();
function cmp_function($a, $b) {
    return ($a['sort'] > $b['sort']);
}
uasort($categories, 'cmp_function');

// Для отладки
//console_log($categories); ?>

<section class="a-categories-grid">
    <div class="container">
        <nav class="a-categories-grid__inner row a-products-grid">
            <?php
            $counter = 0;
            $defaultCatsCount = 4;
            $itemsPerRow = !empty(MG::get('templateParams')['CATEGORIES_GRID']['itemsPerRow']) ? MG::get('templateParams')['CATEGORIES_GRID']['itemsPerRow'] : '2';
            $colClassMd = 'col-md-' . (12 / intval($itemsPerRow));
            $maxCategoriesToShow = !empty(MG::get('templateParams')['CATEGORIES_GRID']['maxCategoriesToShow']) ? MG::get('templateParams')['CATEGORIES_GRID']['maxCategoriesToShow'] : $defaultCatsCount;
            $itemsHeight = !empty(MG::get('templateParams')['CATEGORIES_GRID']['itemsHeight']) ? MG::get('templateParams')['CATEGORIES_GRID']['itemsHeight'] : '240';
            foreach ($categories as $category): ?>
            <?php
            if ($category['activity'] === '0' || $category['level'] !== '1' ) continue;
            $counter++;
            if ($counter > $maxCategoriesToShow) break;
            ?>
            <a class="a-categories-grid__item a-category-banner col-sm-6 <?php echo $colClassMd; ?> col-12-440width"
               title="<?php echo $category['title']; ?>"
               href="<?php echo $category['link']; ?>">
                <div class="a-category-banner__inner" style="height:<?php echo $itemsHeight; ?>px">
                    <img class="a-category-banner__img"
                         width="580" height="<?php echo $itemsHeight; ?>"
                         loading="lazy"
                         src="<?php echo (!empty($category['image_url']) ? SITE . $category['image_url'] : PATH_SITE_TEMPLATE . '/images/nopic.jpg'); ?>"
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
