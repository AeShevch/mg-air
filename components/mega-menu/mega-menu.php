<?php mgAddMeta('components/mega-menu/mega-menu.css'); ?>
<?php mgAddMeta('components/mega-menu/bootstrap/bootstrap.bundle.min.js'); ?>
<?php mgAddMeta('components/mega-menu/mega-menu.js'); ?>
<?php mgAddMeta('components/mega-menu/init.js'); ?>

<?php
// Добавляем в массив категорий страницу Акций, если разрешено в настройках шаблона
if (MG::get('templateParams')['MENU_CATEGORIES']['checkbox_showSalesInMenu'] === 'true') {
    $data[] = [
      'link' => SITE . '/group?sale',
      'title' => lang('indexSale'),
      'menu_icon' => '/' . str_replace(SITE, '', PATH_TEMPLATE) . '/images/groups-icons/sale.svg',
      'activity' =>  '1',
      'invisible' => '0'
    ];
}
// Добавляем в массив категорий страницу Рекомендаций, если разрешено в настройках шаблона
if (MG::get('templateParams')['MENU_CATEGORIES']['checkbox_showRecommendsInMenu'] === 'true') {
    $data[] = [
      'link' => SITE . '/group?type=recommend',
      'title' => lang('indexHit'),
      'menu_icon' => '/' . str_replace(SITE, '', PATH_TEMPLATE) . '/images/groups-icons/recommend.svg',
      'activity' =>  '1',
      'invisible' => '0'
    ];
}
// Добавляем в массив категорий страницу Новинок, если разрешено в настройках шаблона
if (MG::get('templateParams')['MENU_CATEGORIES']['checkbox_showNewInMenu'] === 'true') {
    $data[] = [
      'link' => SITE . '/group?type=latest',
      'title' => lang('indexNew'),
      'menu_icon' => '/' . str_replace(SITE, '', PATH_TEMPLATE) . '/images/groups-icons/new.svg',
      'activity' =>  '1',
      'invisible' => '0'
    ];
}
// Отладка. Выводит массив категорий в консоль браузера
// console_log($data);

// Счётчик. Используется для вывода баннеров
$counter = 0;
?>
<div class="screen-overlay"></div>
<nav class="a-mega-menu navbar <?php echo MG::get('templateParams')['MENU_CATEGORIES']['checkbox_openMenuByClick'] === 'true' ? '' : 'navbar-hover'; ?> navbar-expand-lg navbar-dark">
    <div class="container" style="position: relative;">
        <button class="a-mega-menu__mobile-open navbar-toggler" type="button" data-toggle="collapse" data-trigger="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="a-mega-menu__inner navbar-collapse" id="main_nav">
            <div class="a-mega-menu__btns offcanvas-header mt-3">
                <button class="a-mega-menu__btn a-mega-menu__btn_close js-menu-close">Закрыть</button>
                <button class="a-mega-menu__btn a-mega-menu__btn_hidden a-mega-menu__btn_back js-menu-back">Назад</button>
            </div>
            <ul class="a-mega-menu__list navbar-nav">
                <?php
                // Корневые категории
                foreach($data as $category) : ?>

                <?php
                // Пропускаем категорию, если она неактивна или не должна показываться в меню
                if ($category['activity'] !== '1' || $category['invisible'] === '1') continue;

                // Флаг наличия подкатегорий
                $hasSubmenu = isset($category['child']);

                // Получаем информацию о наличии подкатегорий у подкатегорий (Категорий 3-его уровня)
                // Флаг наличия категорий 3-его уровня
                $level3Exists = false;
                $level2IconsExists = false;
                if ($hasSubmenu && MG::get('templateParams')['MENU_CATEGORIES']['option_menuType'] === 'megaMenu') {
                    foreach ($category['child'] as $child) {
                        // Пропускаем категорию, если она неактивна или не должна показываться в меню
                        if ($child['activity'] !== '1' || $child['invisible'] === '1') continue;
                        if (isset($child['child'])) {
                            $level3Exists = true;
                        }

                        if (!empty($child['menu_icon'])) {
                            $level2IconsExists = true;
                        }

                        if ($level3Exists && $level2IconsExists) break;
                    }
                }

                // Тип подменю
                $submenuType = MG::get('templateParams')['MENU_CATEGORIES']['option_menuType'];
                // Выводим мегаменю, если у категорий есть подкатегории или картинка для меню и оно включено в настройках шаблона
                $isMegaMenu = $submenuType === 'megaMenu' && ($level3Exists || $level2IconsExists);
                $isListMenu = !$isMegaMenu || $submenuType === 'list';

                // Заполняем классы для nav-item
                $navItemClasses = $hasSubmenu ? 'dropdown' : '';
                $navItemClasses.= ($isMegaMenu) ? ' has-megamenu' : '';
                $navItemClasses.= MG::get('templateParams')['MENU_CATEGORIES']['checkbox_hasDimmer'] === 'true' ? ' has-dimmer' : '';
                $navItemClasses.= MG::get('templateParams')['MENU_CATEGORIES']['checkbox_menuItemsStretch'] === 'true' ? ' a-mega-menu-item_stretch' : '';
                $navItemClasses = trim($navItemClasses);
                ?>

                <li class="a-mega-menu__item a-mega-menu-item nav-item <?php echo $navItemClasses; ?>">
                    <a class="a-mega-menu-item__link nav-link" href="<?php echo $category['link']; ?>" <?php echo $hasSubmenu ? 'data-toggle="dropdown"' : '';?>>
                    <?php
                    // Выводим иконки меню, если разрешено в шаблоне
                    if (MG::get('templateParams')['MENU_CATEGORIES']['checkbox_useIconsInMenu'] === 'true') {
                        // Если это svg, то выводим его напрямую, чтобы иметь возможность меняеть его цвет через css
                        if (!empty($category['menu_icon']) && strpos($category['menu_icon'], '.svg') !== false) {
                            echo file_get_contents(SITE . $category['menu_icon']);
                        } else { ?>
                        <img class="a-mega-menu-item__icon"
                             src="<?php echo SITE . (!empty($category['menu_icon']) ? $category['menu_icon'] : '/uploads/no-img.jpg'); ?>"
                             alt="<?php echo !empty($category['menu_seo_alt']) ? $category['menu_seo_alt']: $category['title']; ?>"
                             title="<?php echo !empty($category['menu_seo_title']) ? $category['menu_seo_title']: $category['title']; ?>">
                    <?php }
                    } ?>
                        <span class="a-mega-menu-item__title">
                            <?php echo !empty($category['menu_title']) ? $category['menu_title'] : $category['title']; ?>
                        </span>
                    </a>
                    <?php
                    // Подменю
                    $counter++;
                    if ($hasSubmenu) : ?>
                        <button class="a-mega-menu-item__btn js-menu-open"></button>
                        <?php if ($isMegaMenu): ?>
                        <div class="a-mega-menu-item__submenu a-mega-menu-submenu dropdown-menu animate fade-down <?php echo $isMegaMenu ? 'megamenu' : ''; ?>" role="menu">
                            <div class="row">
                                <?php
                                // Мегаменю
                                component('mega-menu/parts', $category['child'], '_sub-menu_main');
                                // Баннер из настроек шаблона
                                if (MG::get('templateParams')['MENU_CATEGORIES']['checkbox_showBannerInSubmenu'] === 'true' && !empty(MG::get('templateParams')['MENU_CATEGORIES']['img_submenuBannerImgUrl_' . $counter])) : ?>
                                <?php $bannerPosition = !empty(MG::get('templateParams')['MENU_CATEGORIES']['bannerPosition_' . $counter]) ? MG::get('templateParams')['MENU_CATEGORIES']['bannerPosition_' . $counter] : 'right'; ?>
                                <div class="a-mega-menu-submenu__banner <?php echo 'a-mega-menu-submenu__banner_position_' . $bannerPosition; ?> a-banner-category col-md-3 col-6">
                                    <div class="col-megamenu">
                                        <a class="a-banner-category__link"
                                           href="<?php echo SITE . MG::get('templateParams')['MENU_CATEGORIES']['submenuBannerLink_' . $counter]; ?>">
                                            <img class="a-banner-category__img"
                                                 src="<?php echo SITE . MG::get('templateParams')['MENU_CATEGORIES']['img_submenuBannerImgUrl_' . $counter]; ?>"
                                                 alt="<?php echo $category['title']; ?>">
                                        </a>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                        // Меню списком
                        elseif ($isListMenu):
                            component(
                              'mega-menu/parts',
                              [
                                'child' => $category['child'],
                                'dropdown' => true
                              ],
                              '_sub-menu_list'
                            );
                        endif; ?>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>

