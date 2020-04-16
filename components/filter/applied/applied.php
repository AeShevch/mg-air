<?php
mgAddMeta('components/filter/applied/applied.css');
mgAddMeta('components/filter/applied/applied.js');

if (empty($data)) {
    $style = ' style="display:none"';
} else {
    $style = '';
} ?>

<section class="a-apply apply-filter-line">
    <form action="?" class="a-apply__form apply-filter-form js-applied-form"
          data-print-res="<?php echo MG::getSetting('printFilterResult') ?>" <?php echo $style ?>>
        <ul class="a-apply__tags a-filter-tags">
            <?php foreach ($data as $property) {
            $cellCount = 0;
            ?>
            <li class="a-filter-tags__item apply-filter-item">
                <span class="a-filter-tags__name filter-property-name">
                    <?php echo $property['name'] . ": "; ?>
                </span>

                <?php if (in_array($property['values'][0], array('slider|easy', 'slider|hard', 'slider'))) {?>
                <span class="a-filter-tags__value filter-price-range">
                    <?php echo lang('filterFrom') . " " . $property['values'][1] . " " . lang('filterTo') . " " . $property['values'][2]; ?>
                    <button type="button" class="a-filter-tags__remove removeFilter" aria-label="Remove filter"></button>
                </span>

                 <?php if ($property['code'] != "price_course"): ?>
                 <input name="<?php echo $property['code'] . "[" . $cellCount . "]" ?>"
                        value="<?php echo $property['values'][0] ?>"
                        type="hidden">
                 <?php $cellCount++; ?>
                 <?php endif; ?>

                 <input name="<?php echo $property['code'] . "[" . $cellCount . "]" ?>"
                        value="<?php echo $property['values'][1] ?>"
                        type="hidden">
                 <input name="<?php echo $property['code'] . "[" . ($cellCount + 1) . "]" ?>"
                        value="<?php echo $property['values'][2] ?>"
                        type="hidden">
                <?php } else { ?>
                <ul class="a-filter-tags__values filter-values">
                    <?php foreach ($property['values'] as $cell => $value) { ?>
                    <li class="a-filter-tags__value apply-filter-item-value">
                        <?php echo $value['name']; ?>
                        <button class="a-filter-tags__remove removeFilter"
                                type="button" aria-label="Remove filter"></button>
                        <input name="<?php echo $property['code'] . "[" . $cell . "]" ?>"
                               value="<?php echo $property['values'][$cell]['val'] ?>"
                               type="hidden">
                    </li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </li>
            <?php } ?>
        </ul>
        <div class="a-apply__refresh">
            <a href="<?php echo SITE . URL::getClearUri() ?>"
               class="a-button-link refreshFilter">
                <?php echo lang('filterReset'); ?>
            </a>
        </div>
        <input type="hidden" name="applyFilter" value="1"/>
    </form>
</section>
