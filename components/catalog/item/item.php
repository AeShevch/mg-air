<?php
// Для отладки
 console_log($data);
 ?>
<?php mgAddMeta('components/catalog/item/item.css'); ?>
<article class="a-catalog-item">
    <header class="a-catalog-item__img-block a-image-box">
        <!--   Стикеры товаров   -->
        <div class="a-image-box__sticker a-stickers">
            <?php
            if (!empty($data['old_price'])) {
                $price = floatval(MG::numberDeFormat($data['price']));
                $oldprice = floatval(MG::numberDeFormat($data['old_price']));
                if ($oldprice > $price) {
                    $calculate = ($oldprice - $price) / ($oldprice / 100);
                    $result = "" . round($calculate) . " %";
                    echo '<div class="a-stickers__item a-stickers__item_sale"> Sale ' . $result . ' </div>';
                }
            }
            echo $data['new'] ? '<div class="a-stickers__item a-stickers__item_new">' . lang('stickerNew') . '</div>' : '';
            echo $data['recommend'] ? '<div class="a-stickers__item a-stickers__item_hit">' . lang('stickerHit') . '</div>' : '';
            ?>
        </div>
        <!--   Стикеры товаров - конец  -->

        <!-- Изображение товара -->
        <?php
        // Получаем массив миниатюр
        $thumbsArr = getThumbsFromUrl(explode('|', $data['image_url'])[0], $data['id']); ?>
        <a href="<?php echo $data['link'] ?>" class="a-image-box__link" title="<?php echo $data['title'] ?>">
            <img class="a-image-box__img js-catalog-item-image"
                 src="<?php echo $thumbsArr[30]['main'] ?>"
                 srcset="<?php echo $thumbsArr[30]['2x'] ?> 2x"
                 alt="<?php echo $data['images_alt'][0] ?>"
                 title="<?php echo $data['images_title'][0] ?>"
                 data-transfer="true"
                 data-product-id="<?php echo $data['id'] ?>"
                 loading="lazy"
                 width="200"
                 height="200">
        </a>
        <!--   Изображение товара – конец   -->

        <nav class="a-image-box__btns a-product-btns">
            <button class="a-product-btns__item a-product-btns__item js-open-quick-view"
                    data-toggle="tooltip" data-placement="left" title="Быстрый просмотр">
                <i class="a-product-btns__icon a-product-btns__icon_quick-view a-icon" aria-hidden="true"></i>
            </button>
            <button class="a-product-btns__item a-product-btns__item js-add-to-favourites"
                    data-toggle="tooltip" data-placement="left" title="В избранные товары">
                <svg class="a-product-btns__svg">
                    <use xlink:href="#icon_heart"></use>
                </svg>
            </button>
            <button class="a-product-btns__item a-product-btns__item js-add-to-compare"
                    data-toggle="tooltip" data-placement="left" title="Добавить к сравнению">
                <svg class="a-product-btns__svg">
                    <use xlink:href="#icon_compare"></use>
                </svg>
            </button>
        </nav>

    </header>
    <section class="a-catalog-item__info a-product-info">
        <span class="a-product-info__brand">
            <?php echo $data['thisUserFields'][MG::get('templateParams')['MINI_PRODUCT']['brandPropId']]['value']; ?>
        </span>

        <?php if (class_exists('ProductCommentsRating')): ?>
        [mg-product-rating id="<?php echo $data['id'] ?>"]
        <?php endif; ?>

        <h4>
            <a class="a-product-info__title" href="<?php echo $data['link'] ?>" title="<?php echo $data['title'] ?>">
                <?php echo $data['title']; ?>
            </a>
        </h4>

        <div class="a-product-info__prices">
            <span class="a-product-info__price <?php echo !empty($data['old_price']) ? 'a-product-info__price_accent' : ''; ?>">
                <?php echo $data['price'] . ' ' . $data['currency']; ?>
            </span>
            <?php if (!empty($data['old_price'])): ?>
            <span class="a-product-info__price a-product-info__price_old">
                <?php echo $data['old_price'] . ' ' . $data['currency']; ?>
            </span>
            <?php endif; ?>
        </div>

        <?php
        // Варианты товара, если разрешены в настройках
        if (MG::getSetting('printVariantsInMini') == 'true' && !empty($data['variants'])) { ?>
        <div class="a-product-info__variants">
            <?php component('product/variants', $data); ?>
        </div>
        <?php }
        ?>

        <footer class="a-product-info__footer">
            <?php
            //
            component('cart/buy-btn', $data); ?>
        </footer>

    </section>
</article>
