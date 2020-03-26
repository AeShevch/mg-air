<?php
mgAddMeta('components/cart/btn/add/add.js');
?>

<?php
$remInfo = false;
$style = 'style="display:none;"';

if (MG::getSetting('printRemInfo') == "true") {
    $message = lang('countMsg1') . ' "' . str_replace("'", "&quot;", $data['title']) . '" ' . lang('countMsg2') . ' "' . $data['code'] . '"' . lang('countMsg3');
    $message = urlencode($message) . "&code=" . $data['code'];

    if ($data['count'] == '0') {
        $style = 'style="display:block;"';
    }
    $remInfo = $data['remInfo'] != 'false' ? true : false;
} ?>

<?php
if ($remInfo && MG::get('controller') == "controllers_product"): ?>
    <div class="c-product__message" <?php echo $style ?>>
        <a class="c-button"
           rel='nofollow'
           href='<?php echo SITE . "/feedback?message=" . str_replace(' ', '&#32;', $message) ?>'>
            <?php echo lang('countMessage'); ?>
        </a>
    </div>
<?php endif; ?>

<?php
if (!empty($data['variants'])) {
    $firstVar = array_shift($data['variants']);
    $styleToggle = ($firstVar['count'] == 0) ? 'style="display:none"' : '';
}

if (!$data['liteFormData']['noneButton'] || (MG::getProductCountOnStorage(0, $data['id'], 0, 'all') != 0)) { ?>
    <?php
    // Добавляем класс, на который вешается событие сlick из add.js
    $jsClass = 'js-add-to-cart';
    // Если это страница корзины или оформления, то нужно обновлять страницу, соответственно js не нужен
    if (URL::getClearUri() === '/cart' || URL::getClearUri() === '/order') {
        $jsClass = '';
    }
    $isAvailable = ($data['count'] !== 0 && $data['count'] !== '0') || $data['count'] === "много";
    $isProduct = MG::get('controller') === "controllers_product";
    if ($isAvailable && ($isProduct || MG::getSetting('actionInCatalog') === 'true')) {
        // Если это страница корзины или оформления, то нужно обновлять страницу, соответственно js не нужен
        if (URL::getClearUri() === '/cart' || URL::getClearUri() === '/order') $jsClass = ''; ?>
        <a href="<?php echo SITE . '/catalog?inCartProductId=' . $data["id"]; ?>"
           rel="nofollow"
          <?php echo !empty($styleToggle) ? $styleToggle : ''; ?>
           class="addToCart product-buy <?php echo $jsClass ?>"
           aria-label="<?php echo lang('buttonBuy'); ?>"
           data-item-id="<?php echo $data["id"]; ?>">
            <?php echo lang('buttonBuy'); ?>
        </a>

        <?php if (!empty($data['variant_exist'])) { ?>
            <a style="display:none"
               href="<?php echo SITE . '/' . ((MG::getSetting('shortLink') != 'true') && ($data["category_url"] == '') ? 'catalog/' : $data["category_url"]) . $data["product_url"]; ?>"
               class="js-product-more product-info action_buy_variant">
                <?php echo lang('buttonMore'); ?>
            </a>
        <?php } ?>

    <?php } elseif (MG::get('controller') === "controllers_catalog" || isIndex()) { ?>
        <a href="<?php echo SITE . '/' . ((MG::getSetting('shortLink') != 'true') && ($data["category_url"] == '') ? 'catalog/' : $data["category_url"]) . $data["product_url"]; ?>"
           class="product-info <?php echo $data['liteFormData']['classForButton'] ?>">
            <?php echo lang('buttonMore'); ?>
        </a>
    <?php } else { ?>
        <a href="<?php echo SITE . '/catalog?inCartProductId=' . $data["id"]; ?>"
           rel="nofollow"
          <?php echo $styleToggle; ?>
           class="addToCart product-buy <?php echo $jsClass ?>"
           aria-label="<?php echo lang('buttonBuy'); ?>"
           data-item-id="<?php echo $data["id"]; ?>">
            <?php echo lang('buttonBuy'); ?>
        </a>
    <?php } ?>
<?php } ?>


