<?php mgAddMeta('components/mega-menu/simple-menu.css'); ?>

<nav class="a-simple-menu navbar-hover navbar-expand-lg navbar-dark">
   <button class="a-simple-menu__mobile-toggler a-simple-menu-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#<?php echo $data['id'] ?>" aria-expanded="false" aria-label="Toggle navigation">
       <svg class="a-simple-menu-toggler__icon">
           <use xlink:href="#icon_dots"></use>
       </svg>
   </button>
   <div class="a-simple-menu__inner navbar-collapse" id="<?php echo $data['id'] ?>">
            <div class="a-mega-menu__btns offcanvas-header mt-3">
                <button class="a-mega-menu__btn a-mega-menu__btn_close js-menu-close">Закрыть</button>
                <button class="a-mega-menu__btn a-mega-menu__btn_hidden a-mega-menu__btn_back js-menu-back">Назад</button>
            </div>
            <ul class="a-simple-menu__list navbar-nav">
                <?php
                foreach($data['items'] as $page) : ?>
                <?php
                    if (isset($page['invisible']) && $page['invisible'] === '1') continue;
                    // Флаг вложенного меню
                    $hasSubmenu = isset($page['child']) || isset($page['content']);
                    ?>
                    <li class="nav-item a-simple-menu__item <?php echo $hasSubmenu ? 'dropdown' : ''; ?>">
                        <a class="a-simple-menu__link nav-link <?php echo $hasSubmenu ? 'dropdown-toggle' : ''; ?>"
                           href="<?php echo $page['link']; ?>"
                          <?php echo $hasSubmenu ? 'data-toggle="dropdown"' : ''; ?>>
                            <?php echo $page['title'] ?>
                        </a>
                        <?php if (isset($page['child'])): ?>
                        <button class="a-mega-menu-item__btn js-menu-open"></button>
                            <?php
                            component(
                              'mega-menu/parts',
                              [
                                'child' => $page['child'],
                                'dropdown' => true
                              ],
                              '_sub-menu_list'
                            );
                            ?>
                        <?php elseif (isset($page['content'])): ?>
                        <?php
                        // Компонент настроек магазина
                        component('shop-settings/parts', $page['content'], '_content' ); ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
</nav>
