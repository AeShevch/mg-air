<div itemscope itemtype="http://schema.org/Organization" area-hidden="true" >
	<meta itemprop="URL" content="<?php echo SITE; ?>">
	<meta itemprop="name" content="<?php echo MG::getSetting('shopName'); ?>">
	<?php $phones = explode(', ', MG::getSetting('shopPhone'));
    foreach ($phones as $phone) { ?>
          <meta itemprop="telephone" content="<?php echo $phone; ?>">
    <?php }; ?>
	<meta itemprop="address" content="<?php echo MG::getSetting('shopAddress');?>">
	<link itemprop="logo" href="<?php echo SITE; ?><?php echo MG::getSetting('shopLogo'); ?>">
</div>