<?php mgAddMeta('components/countdown/countdown.js'); ?>
<?php mgAddMeta('components/countdown/countdown.css'); ?>

<div class="a-countdown js-countdown" data-date-until="<?php echo $data ?>">
    <div class="a-countdown__item">
        <span class="a-countdown__num js-countdown-days">0</span>
        дней
    </div>
    <div class="a-countdown__item">
        <span class="a-countdown__num js-countdown-hours">0</span>
        часов
    </div>
    <div class="a-countdown__item">
        <span class="a-countdown__num js-countdown-minutes">0</span>
        минут
    </div>
    <div class="a-countdown__item">
        <span class="a-countdown__num js-countdown-seconds">0</span>
        секунд
    </div>
</div>
