<?php
// Отключаем стандартные стили плагина
mgExcludeMeta('/mg-plugins/trigger-guarantee/css/style.css');
// Подключаем иконки из плагина
mgAddMeta('<link rel="stylesheet" href="' . SITE. '/mg-plugins/trigger-guarantee/css/font-awesome.min.css">');
// Подключаем стили компонентв
mgAddMeta('/components/triggers/triggers.css');

$triggerId = MG::get('templateParams')['TRIGGERS']['id'];

// Получаем настройки триггеров из базы
$triggerInfo = DB::fetchAssoc(DB::query("SELECT * FROM `" . PREFIX . "trigger-guarantee` WHERE id=" . DB::quote($triggerId)));
$triggerInfo['settings'] = unserialize(stripslashes($triggerInfo['settings']));

// Получаем элементы триггеров из базы
$result = DB::query("SELECT * FROM `" . PREFIX . "trigger-guarantee-elements` WHERE parent=" . DB::quote($triggerId));
while ($trigger = DB::fetchAssoc($result)) {
    $triggers[] = $trigger;
}
// Сортируем по полю sort
usort($triggers, function($a, $b) {
    return $a['sort'] - $b['sort'];
});

// Для отладки
//console_log($triggerInfo);
//console_log($triggers);

?>
<section class="a-triggers">
    <style>
        .a-trigger__icon i {
<?php if (!empty($triggerInfo['settings']['color_icon'])) : ?>
            color: <?php echo '#' . $triggerInfo['settings']['color_icon'] ?>;
<?php endif; ?>
<?php if (!empty($triggerInfo['settings']['color_icon'])) : ?>
            font-size: <?php echo $triggerInfo['settings']['fontSize']. 'em' ?>;
<?php endif; ?>
        }
    </style>
    <div class="container">
        <div class="a-triggers__inner row">
            <?php foreach($triggers as $trigger) : ?>
            <article class="a-triggers__item a-trigger a-trigger_icon_<?php echo $triggerInfo['settings']['place'] ?> col-xs-12 col-md-6 col-lg-4">
                <div class="a-trigger__icon">
                    <?php echo $trigger['icon'] ?>
                </div>
                <div class="a-trigger__text-content">
                    <?php echo htmlspecialchars_decode($trigger['text']) ?>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

