<ul class="a-mega-menu-submenu__submenu a-mega-menu-submenu-level-deep js-submenu list-unstyled <?php echo $data['dropdown'] ? 'dropdown-menu' : ''; ?>">
    <?php foreach($data['child'] as $category) : ?>
        <?php
        if ($category['activity'] !== '1' || $category['invisible'] === '1') continue;
        $hasSubmenu = isset($category['child']); ?>
        <li class="a-mega-menu-submenu-level-deep__item">
            <a class="a-mega-menu-submenu-level-deep__link <?php echo $data['dropdown'] ? 'dropdown-item' : ''; ?> <?php echo $hasSubmenu ? 'dropdown-toggle' : ''; ?>" <?php echo $hasSubmenu ? 'data-toggle="dropdown"' : ''; ?> href="<?php echo $category['link']; ?>">
                <?php echo !empty($category['menu_title']) ? $category['menu_title'] : $category['title']; ?>
            </a>
            <?php if (isset($category['child'])): ?>
                <?php
                // Подменю выше второго уровня рекурсивно
                component(
                  'mega-menu/parts',
                  [
                    'child' => $category['child'],
                    'dropdown' => true
                  ],
                  '_sub-menu_deep'
                ); ?>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
