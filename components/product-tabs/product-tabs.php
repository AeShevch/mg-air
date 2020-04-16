<?php
mgAddMeta('components/product-tabs/product-tabs.css');
$categoriesIds = explode(', ', MG::get('templateParams')['PRODUCT_TABS']['categoriesIds']);
$maxProductsCount = intval(MG::get('templateParams')['PRODUCT_TABS']['maxProductsCount']);
$products = [];
$menuItemsHtml = '';
$tabsHtml = '';
$counter = 0;

$catalog = new Models_Catalog;

foreach ($categoriesIds as $catId) {
    $catId = intval(trim($catId));
    // Получаем все вложенные категории
    $nestedCatsIds = MG::get('category')->getCategoryList($catId);
    // Добавляем текущую категорию
    $nestedCatsIds[] = $catId;
    // Получаем все товары найденных категорий
    $products = $catalog->getListByUserFilter($maxProductsCount, ' p.cat_id IN (' . DB::quoteIN($nestedCatsIds) . ')');
    // Получаем информацию о текущей категории
    $catInfo = MG::get('category')->getCategoryById($catId);

    // Создаём вёрстку табов
    $menuItemsHtml .= '
    <li class="a-tabs__item nav-item">
    <a class="a-tabs__link nav-link ' . ($counter === 0 ? 'active' : '') . '"
       id="' . $catInfo['url'] . '-tab"
       data-toggle="tab"
       href="#' . $catInfo['url'] . '"
       role="tab"
       aria-controls="' . $catInfo['url'] . '"
       aria-selected="true">' . $catInfo['title'] . '</a></li>';

    // Создаём вёрстку полученных товаров
    $productsHtml = '';
    foreach ($products['catalogItems'] as $product) {
        ob_start();
        component('catalog/item', $product);
        $productsHtml .= '<div class="col-6 col-md-4 col-lg-3">' . ob_get_clean() . '</div>';
    }

    // Создаём вёрстку контента табов
    $tabsHtml .= '
        <div class="tab-pane fade ' . ($counter === 0 ? 'show active' : '') . '" id="' . $catInfo['url'] . '" role="tabpanel" aria-labelledby="' . $catInfo['url'] . '-tab">
            <div class="tab-pane__inner row">' . $productsHtml . '</div>
        </div>';

    $counter++;
}

// Для отладки
// console_log($products);
?>

<section class="a-product-tabs">
    <div class="container">
        <ul class="product-tabs__links a-tabs nav justify-content-center" role="tablist">
            <?php echo $menuItemsHtml ?>
        </ul>
        <div class="product-tabs__contents tab-content">
            <?php echo $tabsHtml ?>
        </div>
    </div>
</section>
