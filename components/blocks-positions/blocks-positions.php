<?php
mgAddMeta('components/blocks-positions/blocks-positions.css');

// Массив блоков для позиционирования
$sections = [
  'a-header' => [
    'activity' => MG::get('templateParams')['HEADER']['activity'],
    'position' => !empty(MG::get('templateParams')['HEADER']['position']) ? intval(MG::get('templateParams')['HEADER']['position']) : '',
  ],
  'a-slider' => [
    'activity' => MG::get('templateParams')['SLIDER']['activity'] === 'true' && class_exists('Slider') ? 'true' : 'false',
    'position' => !empty(MG::get('templateParams')['SLIDER']['position']) ? intval(MG::get('templateParams')['SLIDER']['position']) : '',
  ],
  'a-categories-grid' => [
    'activity' => MG::get('templateParams')['CATEGORIES_GRID']['activity'],
    'position' => !empty(MG::get('templateParams')['CATEGORIES_GRID']['position']) ? intval(MG::get('templateParams')['CATEGORIES_GRID']['position']) : '',
  ],
  'a-groups' => [
    'activity' => MG::get('templateParams')['PRODUCT_GROUPS']['activity'],
    'position' => !empty(MG::get('templateParams')['PRODUCT_GROUPS']['position']) ? intval(MG::get('templateParams')['PRODUCT_GROUPS']['position']) : '',
  ],
  'a-brands-grid' => [
    'activity' => MG::get('templateParams')['BRANDS_GRID']['activity'] === 'true' && class_exists('Brands') ? 'true' : 'false',
    'position' => !empty(MG::get('templateParams')['BRANDS_GRID']['position']) ? intval(MG::get('templateParams')['BRANDS_GRID']['position']) : '',
  ],
  'a-page-description' => [
    'activity' => MG::get('templateParams')['SITE_DESCRIPTION']['activity'],
    'position' => !empty(MG::get('templateParams')['SITE_DESCRIPTION']['position']) ? intval(MG::get('templateParams')['SITE_DESCRIPTION']['position']) : '',
  ],
  'a-footer' => [
    'activity' => MG::get('templateParams')['FOOTER']['activity'],
    'position' => !empty(MG::get('templateParams')['FOOTER']['position']) ? intval(MG::get('templateParams')['FOOTER']['position']) : '',
  ],
];
?>
<style>
<?php
foreach ($sections as $class => $section) {
    if ($section['activity'] === 'false' || empty($section['position'])) continue;
    ?>
    .<?php echo $class ?> {
        order: <?php echo $section['position']; ?>;
        -webkit-box-ordinal-group: <?php echo $section['position'] + 1; ?>;
    }
<?php } ?>
    </style>
