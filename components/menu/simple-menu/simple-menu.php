<?php mgAddMeta('components/menu/simple-menu/simple-menu.css'); ?>
<nav class="a-simple-menu"
     role="navigation"
     aria-label="pages menu">
    <ul class="a-simple-menu__list">
        <?php foreach ($data as $page) : ?>
            <?php if ($page['invisible'] === '1') continue; ?>
            <li class="a-simple-menu__item">
                <a class="a-simple-menu__link <?php echo isActivePage($page['link']) ? 'a-simple-menu__link_active' : ''; ?>"
                   href="<?php echo $page['link'] ?>"
                   title="<?php echo $page['title'] ?>">
                    <?php echo $page['title'] ?>
                </a>

                <?php
                if (isset($page['child'])): ?>

                    <?php
                    // Подменю
                    component(
                      'menu/simple-menu',
                      $page['child'],
                      'simple-menu__sub-menu'
                    ); ?>

                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
