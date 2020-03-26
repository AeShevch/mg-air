<?php mgAddMeta('components/logo/logo.css'); ?>
<?php $shopName = htmlspecialchars(MG::getSetting('shopName')); ?>
<div class="a-logo" itemscope="" itemtype="http://schema.org/Organization">
    <a class="a-logo__link" itemprop="url"
       title="<?php echo URL::isSection(null) ? 'javascript:void(0)' : $shopName ?>"
       href="<?php echo SITE ?>">
        <img src="<?php echo SITE . MG::getSetting('shopLogo') ?>"
             itemprop="logo"
             alt="<?php echo $shopName; ?>"
             title="<?php echo $shopName; ?>">
    </a>
</div>
