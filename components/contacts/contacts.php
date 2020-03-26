<?php mgAddMeta('components/contacts/contacts.css'); ?>
<div class="a-contacts">
    <span class="a-contacts__phone">
        <?php echo lang('Call us'); ?>:
        <a class="a-contacts__link" title="<?php echo lang('Call us'); ?>"
           href="tel:<?php echo MG::getSetting('shopPhone'); ?>">
            <?php echo MG::getSetting('shopPhone'); ?>
        </a>
    </span>
    <span class="a-contacts__time">
        <?php
        $workTime = explode(',', MG::getSetting('timeWork'));
        $workTimeDays = explode(',', MG::getSetting('timeWorkDays'));
        foreach ($workTime as $key => $time) {
            // День
            echo !empty($workTimeDays[$key]) ? htmlspecialchars($workTimeDays[$key]) . ' ' : '';
            // Время
            echo htmlspecialchars($workTime[$key]) . ' ';
        } ?>
    </span>
</div>
