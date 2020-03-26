<div class="a-simple-menu__sub-menu a-sub-menu">
    <div class="row">
        <ul class="a-sub-menu__list">
            <?php foreach ($data as $page) : ?>
                <?php if ($page['invisible'] === '1') continue; ?>
                <li class="a-sub-menu__list-item">
                    <a class="a-sub-menu__link <?php echo isActivePage($page['link']) ? 'a-sub-menu__link_active' : ''; ?>"
                       href="<?php echo $page['link']; ?>"
                       title="<?php echo $page['title']; ?>">
                        <?php echo $page['title']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

