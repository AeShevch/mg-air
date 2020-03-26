<?php mgAddMeta('components/product/variants/sizemap/sizemap.css'); ?>

<?php
// Для отладки
// console_log($data);
if (!empty($data['sizeMap'])) {
  $color = $colorFull = $sizeFull = $size = '';
  $countColor = 0;

  foreach ($data['sizeMap'] as $item) {
    MG::loadLocaleData($item['id'], LANG, 'property_data', $item);
    foreach ($data['variants'] as $variant) {
        if ($variant['color'] === $item['id'] && !empty($variant['image'])) {

            $item['img'] = mgImageProductPath($variant['image'], $variant['product_id'], 'small');
            break;
        }
    }

    if ($item['type'] == 'color') {
      $countColor++;
      if (!empty($item['img'])) {
        ob_start(); ?>
          <button type="button" class="a-color-block__item color"
                  data-id="<?php echo $item['id'] ?>"
                  style="background: url(<?php echo $item['img']; ?>);background-size:cover;"
                  data-toggle="tooltip" data-placement="top"
                  title="<?php echo $item['name'] ?>"></button>
        <?php
        $color .= ob_get_clean();
      } else {
        ob_start(); ?>
          <button type="button" class="a-color-block__item color"
                  data-id="<?php echo $item['id'] ?>"
                  style="background-color:<?php echo $item['color'] ?>"
                  data-toggle="tooltip" data-placement="top"
                  title="<?php echo $item['name'] ?>"></button>
        <?php
        $color .= ob_get_clean();
      }
      $colorName = $item['pName'];
    }
    if ($item['type'] == 'size') {
      ob_start(); ?>
      <button type="button" class="a-sizes-n-colors__size size" data-id="<?php echo $item['id']?>">
        <span><?php echo $item['name']?></span>
      </button>
      <?php
      $size .= ob_get_clean();
      $sizeName = $item['pName'];
    }
  }

  if ($color && ($countColor > 1 || MG::getSetting('printOneColor') == 'true')) {
    $colorFull = '<div class="color-block a-color-block"><span class="a-color-block__title">' . $colorName . ':</span>' . $color . '</div>';
  }
  if ($size) {
    $sizeFull = '<div class="size-block a-size-block"><span class="a-size-block__title">' . $sizeName . ':</span>' . $size . '</div>';
  }

  if (MG::getSetting('sizeMapMod') == 'size') {
    $sizeMap = $sizeFull.$colorFull;
  } else {
    $sizeMap = $colorFull.$sizeFull;
  }
  ?>
  <div class="sizeMap-row a-sizes-n-colors">
    <?php echo $sizeMap?>
  </div>
<?php } ?>
