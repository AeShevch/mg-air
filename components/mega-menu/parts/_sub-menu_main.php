<?php foreach ($data as $categoryLevel2) : ?>
    <?php if ($categoryLevel2['activity'] !== '1' || $categoryLevel2['invisible'] === '1') continue; ?>
    <div class="col-md-3 col-6 pb-3">
        <div class="a-mega-menu-submenu__item col-megamenu">
            <a class="a-mega-menu-submenu__link"
               href="<?php echo $categoryLevel2['link']; ?>">
                <?php echo !empty($categoryLevel2['menu_title']) ? $categoryLevel2['menu_title'] : $categoryLevel2['title']; ?>
            </a>

            <?php if (!empty($categoryLevel2['image_url'])): ?>
                <a class="a-mega-menu-submenu__image-wrap"
                   href="<?php echo $categoryLevel2['link']; ?>">
                    <img class="a-mega-menu-submenu__image"
                         src="<?php echo SITE . $categoryLevel2['image_url']; ?>"
                         alt="<?php echo !empty($categoryLevel2['seo_alt']) ? $categoryLevel2['seo_alt'] : $categoryLevel2['title']; ?>"
                         title="<?php echo !empty($categoryLevel2['seo_title']) ? $categoryLevel2['seo_title'] : $categoryLevel2['title']; ?>">
                </a>
            <?php endif; ?>

            <?php if (isset($categoryLevel2['child'])) {
                // Подменю выше второго уровня рекурсивно
                component(
                  'mega-menu/parts',
                  [
                    'child' => $categoryLevel2['child'],
                    'dropdown' => false
                  ],
                  '_sub-menu_list'
                );
            } ?>
        </div>
    </div>
<?php endforeach; ?>





