<?php
mgAddMeta('components/video-product/video-product.css');

// Получаем товар по артикулу
if (!empty($data['productCode'])) {
    $product = DB::fetchAssoc(DB::query("SELECT DISTINCT * FROM " . PREFIX . "product WHERE code=" . DB::quote($data['productCode'])));
    $product['currency'] = MG::getSetting('currencyShort')[$product['currency_iso']];
    // Получаем категорию по id
    $category = MG::get('category')->getCategoryById($product['cat_id']);
}

$videoUrl = !empty($data['video']['url']) ?
  $data['video']['url'] :
  PATH_SITE_TEMPLATE . '/video/demo-video.mp4';

$videoPoster = !empty($data['video']['poster']) ?
  $data['video']['poster'] :
  PATH_SITE_TEMPLATE . '/video/demo-video-poster.jpg';

$videoTitle = !empty($data['video']['title']['text']) ?
  $data['video']['title']['text'] :
  'Заголовок видео-блока';

$videoText = !empty($data['video']['desc']['text']) ?
  $data['video']['desc']['text'] :
  'Текст под заголовком';

$productUrl = SITE . '/' . $category['parent_url'] . $category['url'] . '/' . $product['url'];

?>

<section class="a-product-video a-product-video_id_<?php echo $data['videoBlockId']; ?>">
    <div class="container">
        <div class="a-product-video__inner a-product-video__inner_video_<?php echo $data['position']; ?> row align-items-center">
            <div class="col-12 col-lg-6">
                <article class="a-product-video__video-block a-video-block">
                    <video class="a-video-block__media"
                           poster="<?php echo $videoPoster; ?>"
                           src="<?php echo $videoUrl; ?>"
                           preload="auto" autoplay playsinline loop muted="muted"></video>
                    <div class="a-video-block__desc">
                        <h3 class="a-video-block__title"
                            style="color: <?php echo $data['video']['title']['color']; ?>; font-size: <?php echo $data['video']['title']['size']; ?>px">
                            <?php echo $videoTitle; ?>
                        </h3>
                        <p class="a-video-block__text"
                           style="color: <?php echo $data['video']['desc']['color']; ?>; font-size: <?php echo $data['video']['desc']['size']; ?>px">
                            <?php echo $videoText; ?>
                        </p>
                    </div>
                </article>
            </div>
            <div class="col-12 col-sm-3">
                <a class="a-product-video__img-link"
                   href="<?php echo $productUrl; ?>"
                   title="<?php echo $product['title'] ?>">
                    <?php
                    // Получаем массив миниатюр
                    $thumbsArr = getThumbsFromUrl(explode('|', $product['image_url'])[0], $product['id']); ?>
                    <img class="a-product-video__img"
                         src="<?php echo $thumbsArr[30]['main'] ?>"
                         srcset="<?php echo $thumbsArr[30]['2x'] ?> 2x"
                         alt="<?php echo $product['images_alt'][0] ?>"
                         title="<?php echo $product['images_title'][0] ?>"
                         data-transfer="true"
                         data-product-id="<?php echo $product['id'] ?>"
                         loading="lazy" width="280" height="350">
                </a>
            </div>
            <div class="col-12 col-sm-3">
                <div class="a-product-video__desc a-product-video-desc">
                    <a class="a-product-video-desc__category"
                       href="<?php echo SITE . '/' . $category['parent_url'] . $category['url']; ?>">
                        <?php echo $category['title']; ?>
                    </a>
                    <h2 class="a-product-video-desc__title">
                        <a class="a-product-video-desc__title-link"
                           href="<?php echo $productUrl; ?>">
                            <?php echo $product['title']; ?>
                        </a>
                    </h2>
                    <?php if (class_exists('ProductCommentsRating')): ?>
                    <div class="a-product-video-desc__rating">
                        [mg-product-rating id="<?php echo $product['id']; ?>"]
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($product['short_description'])): ?>
                    <p class="a-product-video-desc__text">
                        <?php echo $product['short_description']; ?>
                    </p>
                    <?php endif; ?>
                    <div class="a-product-video-desc__prices">
                        <span class="a-product-video-desc__price">
                            <?php echo $product['price'] . ' ' . $product['currency']; ?>
                        </span>
                        <?php if (!empty($product['old_price'])): ?>
                        <span class="a-product-video-desc__price a-product-video-desc__price_old">
                            <?php echo $product['old_price'] . ' ' . $product['currency']; ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    <?php
                    // Кнопка «Купить»
                    component('cart/buy-btn', $product); ?>
                </div>
            </div>
        </div>
    </div>
</section>
