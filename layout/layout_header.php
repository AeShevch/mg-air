<header class="a-header">
    <section class="a-header__top a-header-top">
        <div class="container">
            <div class="container_top">
                <div class="a-header-top__nav">
                    <?php
                    // Верхнее меню
                    component(
                      'mega-menu',
                      [
                        'id' => 'pages-nav',
                        'items' => $data['menuPages']
                      ],
                      'simple-menu'
                    ); ?>
                </div>

                <?php
                // Поиск
                component('search');
                ?>

                <?php
                // Настройка языка/валюты
                component('shop-settings', $data); ?>
            </div>
        </div>
    </section>
    <section class="a-header__middle">
        <div class="container">
            <?php
            // Логотип
            component('logo'); ?>

            <div class="a-header__contacts">
                <?php
                // Контакты
                component('contacts'); ?>
            </div>

            <div class="a-header__icons">
                <div class="a-header__auth">
                    <?php
                    // Авторизация/Регистрация
                    component('auth'); ?>
                </div>

                <div class="a-header__icon-link a-header__icon-link_compare">
                    <?php
                    // Ссылка на страницу сравнения
                    component(
                      'icon-link',
                      [
                        'link' => SITE . '/compare',
                        'title' => lang('compareCompare'),
                        'iconId' => '#icon_compare'
                      ]
                    ); ?>
                </div>

                <div class="a-header__icon-link a-header__icon-link_favourites">
                    <?php
                    // Ссылка на страницу избранных товаров
                    component(
                      'icon-link',
                      [
                        'link' => SITE . '/favourites',
                        'title' => lang('favoriteTitle'),
                        'iconId' => '#icon_heart'
                      ]
                    ); ?>
                </div>

                <div class="a-header__icon-link a-header__icon-link_cart">
                    <?php
                    // Ссылка на корзину
                    component(
                      'icon-link',
                      [
                        'link' => SITE . '/cart',
                        'title' => lang('cartCart'),
                        'iconId' => '#icon_cart'
                      ]
                    ); ?>
                </div>
            </div>
        </div>
    </section>
    <section class="a-header__bottom">
        <div class="container">
            <?php
            // Меню категорий
//            component('menu/categories', $data['menuCategories'] ); ?>
        </div>
            <?php
            // Меню категорий
            component('mega-menu', $data['menuCategories'] ); ?>
    </section>
</header>
