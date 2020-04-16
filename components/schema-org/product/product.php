<?php 
$brandIsExists = !empty(MG::get('templateParams')['PRODUCT']['brandId']);

if($brandIsExists) {
    $brandId = MG::get('templateParams')['PRODUCT']['brandId'];
    $brandsDataIsExists = !empty($data['thisUserFields'][$brandId]['data']);
    if($brandsDataIsExists) {
        $brandName = $data['thisUserFields'][$brandId]['data']['name'];   
    }
}
?>  
<div itemscope itemtype="http://schema.org/Product" aria-hidden="true">
    <meta itemprop="name" content="<?php echo $data['title'] ?>">
    <meta itemprop="description" content="<?php echo $data['description'] ?>">
    <meta itemprop="productID" content="<?php echo $data['id'] ?>">
    <meta itemprop="sku" content="<?php echo $data['code'] ?>">
    <meta itemprop="seller" content="<?php echo MG::getSetting('shopName') ?>">

    <?php if ($brandIsExists && $brandsDataExists) { ?>
        <meta itemprop="brand" content="<?php echo $brandName; ?>">
    <?php } ?>

    <?php
        foreach($data['images_product'] as $image) { ?>
            <link itemprop="image" href="<?php echo SITE . '/uploads/' . $image ?>">
      <?php  }
    ?>


    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
        <meta itemprop="price" content="<?php echo MG::numberDeFormat($data['price']); ?>">
        <link itemprop="url" href="<?php echo SITE.URL::getClearUri() ?>">
        <meta itemprop="priceCurrency" content="<?php echo $data['currency_iso']; ?>">
        <link itemprop="availability" href="http://schema.org/<?php echo ($data['count'] === 0 || $data['count'] === '0') ? "OutOfStock" : "InStock" ?>">
    </div>
</div>