<?php
// Отключаем стандартные стили плагина
mgExcludeMeta(
  array(
    '/mg-plugins/mg-brand/css/brand.css',
    '/mg-plugins/mg-brand/css/owl.carousel.css',
    '/mg-plugins/mg-brand/js/myowl.carousel.js'
  )
);

// Подключаем стили компонента
mgAddMeta('components/brands-grid/brands-grid.css');

// Получаем бренды из базы
$result = DB::query("SELECT * FROM `" . PREFIX . "mg-brand`");
while ($brand = DB::fetchAssoc($result)) {
    $brands[] = $brand;
}

// Сортируем бренды по полю sort
usort($brands, function($a, $b) {
    return $a['sort'] - $b['sort'];
});

// Собираем фоновые изображения брендов из настроек
$brandItemsCount = MG::get('templateParams')['BRANDS_GRID']['maxCount'];
$brandsBgs = [];
for ($i = 1; $i <= $brandItemsCount; $i++) {
    $brandsBgs[] = MG::get('templateParams')['BRANDS_GRID']['img_brandBg_' . $i];
}

// для отладки:
//console_log($brands);
?>
<section class="a-brands-grid">
    <div class="container">
        <h2 class="a-brands-grid__title">
            <?php echo MG::get('templateParams')['BRANDS_GRID']['title']; ?>
        </h2>
        <h3 class="a-brands-grid__subtitle">
            <?php echo MG::get('templateParams')['BRANDS_GRID']['subtitle']; ?>
        </h3>
        <div class="a-brands-grid__inner row">
            <?php foreach($brands as $key => $brandItem) : ?>
                <?php if ($brandItem['invisible'] === 0) continue; ?>
            <article class="col-6 col-md-3 col-12-440width">
                <a class="a-brands-grid__item a-brand"
                   style="background-image: url)"
                   title="<?php echo $brandItem['title']; ?>"
                   href="<?php echo $brandItem['full_url'] ?>">
                    <img class="a-brand__bg"
                         src="<?php echo SITE . '/' . $brandsBgs[$key]; ?>"
                         loading="lazy" width="280" height="200"
                         alt="<?php echo $brandItem['title']; ?>">
                    <div class="a-brand__inner">
                        <img class="a-brand__logo"
                             src="<?php echo $brandItem['url'] ?>"
                             width="182" height="102" loading="lazy"
                             alt="<?php echo $brandItem['title']; ?>">
                    </div>
                </a>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
