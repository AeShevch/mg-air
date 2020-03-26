<?php mgAddMeta('components/menu/categories/categories.css'); ?>
<nav class="a-categories-menu">
    <ul class="a-categories-menu__list mobile-offcanvas navbar navbar-expand-lg navbar-dark">
        <?php
        // Для отладки
        // console_log($data);
        foreach($data as $category) : ?>
            <li class="a-categories-menu__item a-category-item dropdown megamenu">
                <a class="a-category-item__link" href="<?php echo $category['link'] ?>">
                    <?php
                    // Если это svg, то выводим его напрямую, чтобы мы молги меняеть его цвет
                    if (!empty($category['menu_icon']) && strpos($category['menu_icon'], '.svg') !== false) : ?>
                        <?php echo file_get_contents(SITE . $category['menu_icon']); ?>
                    <?php else: ?>
                        <img class="a-category-item__icon"
                             src="<?php echo SITE . (!empty($category['menu_icon']) ? $category['menu_icon'] : '/uploads/no-img.jpg'); ?>"
                             alt="<?php echo !empty($category['menu_seo_alt']) ? $category['menu_seo_alt']: $category['title']; ?>"
                             title="<?php echo !empty($category['menu_seo_title']) ? $category['menu_seo_title']: $category['title']; ?>">
                    <?php endif; ?>
                    <span class="a-category-item__title">
                        <?php echo $category['title']; ?>
                    </span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

