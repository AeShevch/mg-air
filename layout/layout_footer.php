<?php
// Создаём массив категорий
$categoriesIds = explode(',', MG::get('templateParams')['FOOTER']['categoriesId']);
$categories = [];
foreach ($categoriesIds as $catId) {
    $categories[] = MG::get('category')->getCategoryById(intval(trim($catId)));
}
// Создаём массив страниц
$pagesIds = explode(',', MG::get('templateParams')['FOOTER']['categoriesId']);
$categories = [];
foreach ($categoriesIds as $catId) {
    $categories[] = MG::get('category')->getCategoryById(intval(trim($catId)));
}

$workTime = explode(',', MG::getSetting('timeWork'));
$workTimeDays = explode(',', MG::getSetting('timeWorkDays'));
?>
<footer class="a-footer">
    <div class="container">
        <div class="a-footer__main row">
            <div class="col-md-6 col-lg-2 col-xl-3">
                <nav class="a-footer__column a-footer-menu">
                    <h4 class="a-footer__title">
                        Категории
                    </h4>
                    <ul class="a-footer-menu__list">
                        <?php foreach($categories as $category) : ?>
                        <li class="a-footer-menu__item">
                            <a href="<?php echo SITE . '/' . $category['url'] ?>"
                               class="a-footer-menu__link">
                                <?php echo $category['title'] ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
            <div class="col-md-6 col-lg col-xl-3">
                <nav class="a-footer__column a-footer-menu">
                    <h4 class="a-footer__title">
                        Разделы сайта
                    </h4>
                    <ul class="a-footer-menu__list">
                        <?php foreach($data['menuPages'] as $page) : ?>
                        <li class="a-footer-menu__item">
                            <a href="<?php echo SITE . '/' . $page['url'] ?>"
                               class="a-footer-menu__link">
                                <?php echo $page['title'] ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
            <div class="col-md-6 col-lg col-xl-3">
                <div class="a-footer__column">
                    <h4 class="a-footer__title">Контакты</h4>
                    <div class="a-footer__text">
                        <p><span>Адрес:</span> <?php echo MG::getSetting('shopAddress');?></p>
                        <p><span>Телефон:</span> <?php echo MG::getSetting('shopPhone') ?></p>
                        <p>
                            <span>Время работы:</span>
                            <?php
                            foreach ($workTime as $key => $time) {
                                // День
                                echo !empty($workTimeDays[$key]) ? htmlspecialchars($workTimeDays[$key]) . ' ' : '';
                                // Время
                                echo htmlspecialchars($workTime[$key]) . ' ';
                            } ?>
                        </p>
                        <p>
                            <span>Email:</span>
                            <a href="mailTo:<?php echo MG::get('templateParams')['FOOTER']['email'] ?>">
                                <?php echo MG::get('templateParams')['FOOTER']['email'] ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <?php if (MG::get('templateParams')['SOCIALS']['checkbox_socialsShow'] === 'true'): ?>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="a-footer__column">
                    <h4 class="a-footer__title">Мы в соцсетях</h4>
                    <p class="a-footer__text">
                        Следите за нами в социальных сетях и вы всегда будете в курсе всех новинок и самых актуальных предложений.
                    </p>
                    <?php
                    // Ссылки на соцсети
                    component('socials'); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="a-footer__bottom">
        <div class="container a-footer__inner-bottom">
            <div class="a-footer__logo">
                <?php
                // Логотип
                component('logo'); ?>
            </div>

            <div class="a-footer__copy-right">
                <?php echo '© ' . date('Y') . ' ' . lang('copyright'); ?>
            </div>

            <div class="a-footer__copy-right a-footer__copy-right_moguta">
                <?php copyrightMoguta(); ?>
            </div>

            <div class="a-footer__payments">
                <?php
                // Иконки способов оплат
                component('payment-icons'); ?>
            </div>

            <div class="a-footer__widgets">
                <?php layout('widget'); ?>
            </div>
        </div>
    </div>
</footer>
