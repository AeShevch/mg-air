<ul class="a-mega-menu-submenu__submenu a-mega-menu-submenu-level-deep js-submenu list-unstyled <?php echo !empty($data['dropdown']) ? 'dropdown-menu' : ''; ?>">
    <?php foreach($data['child'] as $item) : ?>
        <?php
        if ((isset($item['activity']) && $item['activity'] !== '1') || $item['invisible'] === '1') continue;
        $hasSubmenu = isset($item['child']); ?>
        <li class="a-mega-menu-submenu-level-deep__item">
            <a class="a-mega-menu-submenu-level-deep__link <?php echo $data['dropdown'] ? 'dropdown-item' : ''; ?> <?php echo $hasSubmenu ? 'dropdown-toggle' : ''; ?>" <?php echo $hasSubmenu ? 'data-toggle="dropdown"' : ''; ?> href="<?php echo $item['link']; ?>">
                <?php echo !empty($item['menu_title']) ? $item['menu_title'] : $item['title']; ?>
            </a>
            <?php if ($hasSubmenu): ?>
                <button class="a-mega-menu-item__btn js-menu-open"></button>
                <?php
                // Подменю выше второго уровня рекурсивно
                component(
                  'mega-menu/parts',
                  [
                    'child' => $item['child'],
                    'dropdown' => true
                  ],
                  '_sub-menu_list'
                ); ?>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
