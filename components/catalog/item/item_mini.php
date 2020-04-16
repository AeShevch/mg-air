<?php
mgAddMeta('components/catalog/item/item_mini.css');
$productUrl = SITE . '/' . $data['category_url'] . $data['product_url'];
$thumbsArr = getThumbsFromUrl(explode('|', $data['image_url'])[0], $data['id']);

// Для отладки
//console_log($data); ?>
<article class="a-catalog-item-mini">
    <a href="<?php echo $productUrl ?>"
       class="a-catalog-item-mini__img-link">
        <img class="a-catalog-item-mini__img"
             src="<?php echo $thumbsArr[30]['main'] ?>" srcset="<?php echo $thumbsArr[30]['2x'] ?> 2x"
             alt="<?php echo $data['images_alt'][0] ?>" title="<?php echo $data['images_title'][0] ?>"
             loading="lazy" width="100" height="125">
    </a>
    <div class="a-catalog-item-mini__desc">
        <?php if (class_exists('ProductCommentsRating')): ?>
        [mg-product-rating id="<?php echo $data['id'] ?>"]
        <?php endif; ?>
        <a class="a-catalog-item-mini__category"
           href="<?php echo SITE . '/' . $data['category_url'] ?>">
           Категория
        </a>
        <h4 class="a-catalog-item-mini__title">
            <a class="a-catalog-item-mini__link"
               href="<?php echo $productUrl ?>">
                <?php echo $data['title'] ?>
            </a>
        </h4>
        <div class="a-catalog-item-mini__prices">
            <span class="a-catalog-item-mini__price">
                <?php echo $data['price'] . ' ' . $data['currency'] ?>
            </span>
            <?php if (!empty($data['old_price'])): ?>
            <span class="a-catalog-item-mini__price a-catalog-item-mini__price_old">
                <?php echo $data['old_price'] . ' ' . $data['currency'] ?>
            </span>
            <?php endif; ?>
        </div>
    </div>
</article>
