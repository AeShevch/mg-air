<div class="dropdown-menu dropdown-menu-right list-unstyled">
    <div class="a-custom-submenu__wrap dropdown-item js-custom-submenu-wrapper">
        <div class="a-custom-submenu">
            <?php
            $url = str_replace(url::getCutSection(), '', $_SERVER['REQUEST_URI']);
            foreach ($data as $block) : ?>
                <h4 class="a-custom-submenu__title">
                    <?php echo $block['title'] ?>
                </h4>
                <div class="a-custom-submenu__inner">
                <?php if ($block['type'] === 'lang'): ?>
                    <a class="a-custom-submenu__btn a-button <?php echo LANG === 'LANG' || LANG == '' ? '' : 'a-button_outline'; ?>"
                       href="<?php echo SITE.$url ?>">
                        <span class="a-button__title">
                            <?php echo lang('defaultLanguage') ?>
                        </span>
                    </a>
                    <?php foreach ($block['items'] as $item) : ?>
                    <a class="a-custom-submenu__btn a-button <?php echo LANG === $item['short'] ? '' : 'a-button_outline'; ?>"
                       href="<?php echo SITE . '/' . $item['short'] . $url ?>">
                        <span class="a-button__title">
                            <?php echo $item['title']; ?>
                        </span>
                    </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php foreach ($block['items'] as $key => $value) : ?>
                    <button class="a-custom-submenu__btn a-button <?php echo $block['items'][$key]['activity'] ? '' : 'a-button_outline'; ?> <?php echo $block['items'][$key]['class'] ?>"
                            data-currency="<?php echo $key ?>">
                        <span class="a-button__title">
                            <?php echo $block['items'][$key]['title']; ?>
                        </span>
                    </button>
                    <?php endforeach; ?>
                <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
