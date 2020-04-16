<?php
mgAddMeta('components/filter/filter.css');
mgAddMeta('components/filter/filter.js');
mgAddMeta('components/filter/lib/jquery.ui.slider.css');

$data = MG::get('catalogfilter');

$lang = MG::get('lang');
ob_start();
?>

<div class="a-filter-head">
    <div class="a-filter__preview filter-preview shadow" style="display:none;">
        <div class="loader-search"></div>
        <span></span>
    </div>

    <?php
    // Локали
    $data['property']['sorter']['option']['price_course|-1'] = lang('filterPrice_courseAsc');
    $data['property']['sorter']['option']['price_course|1'] = lang('filterPrice_courseDesc');
    $data['property']['sorter']['option']['id|1'] = lang('filterId');
    $data['property']['sorter']['option']['count_buy|1'] = lang('filterCount_buy');
    $data['property']['sorter']['option']['recommend|1'] = lang('filterRecommend');
    $data['property']['sorter']['option']['new|1'] = lang('filterNew');
    $data['property']['sorter']['option']['old_price|1'] = lang('filterOld_price');
    $data['property']['sorter']['option']['sort|-1'] = lang('filterSort');
    $data['property']['sorter']['option']['sort|1'] = lang('filterSortDesc');
    if (!MG::enabledStorage()) {
        $data['property']['sorter']['option']['count|1'] = lang('filterCountDesc');
        $data['property']['sorter']['option']['count|-1'] = lang('filterCountAsc');
    }
    $data['property']['sorter']['option']['title|-1'] = lang('filterTitleAsc');
    $data['property']['sorter']['option']['title|1'] = lang('filterTitleDesc');
    $data['property']['sorter']['label'] = lang('filterLabel1');
    $data['property']['price_course']['label1'] = lang('filterLabel2');
    $data['property']['price_course']['label2'] = lang('filterTo');
    ?>

    <?php
    // перебор характеристик и в зависимости от типа строится соответствующий html код
    foreach ($data['property'] as $name => $prop) {
        switch ($prop['type']) {
            case 'select':
            {
                if (!URL::isSection("mg-admin") && $name == 'sorter' && !empty($_SESSION['filters'])) {
                    $prop['selected'] = $_SESSION['filters'];
                    $prop['value'] = $_SESSION['filters'];
                } ?>

                <div class="wrapper-field">
                    <div class="filter-select">
                        <div style="display: none;">
                            <select id="<?php echo $name ?>"
                                    name="<?php echo $name ?>">
                                <?php foreach ($prop['option'] as $value => $text) {
                                    $selected = ($prop['selected'] === $value . "") ? 'selected="selected"' : ''; ?>
                                    <option value="<?php echo $value ?>" <?php echo $selected ?>>
                                        <?php echo $text ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <?php if ($name == 'cat_id') {
                            $checked = '';
                            if ($_POST['insideCat']) {
                                $checked = 'checked=checked';
                            } ?>
                            <div class="checkbox">
                                <?php echo $lang['FILTR_PRICE7'] ?>
                                <input type="checkbox"
                                       name="insideCat" <?php echo $checked ?> />
                            </div>
                        <?php } ?>

                    </div>
                </div>

                <?php break;
            }

            case 'between':
            {
                if (isset($prop['special']) && $prop['special'] == 'date') { ?>

                    <div class="wrapper-field">
                        <ul class="period-date">
                            <li class="form-group">
                                <label class="label-field" for="prop-<?php echo $name ?>">
                                    <?php echo $prop['label1'] ?>
                                </label>
                                <input class="from-<?php echo $prop['class'] ?> form-control"
                                       type="text"
                                       id="prop-<?php echo $name ?>"
                                       name="<?php echo $name ?>[]"
                                       value="<?php echo date('d.m.Y', strtotime($prop['min'])) ?>">
                            </li>
                            <li>
                                <span class="label-field">
                                    <?php echo $prop['label2'] ?>
                                </span>
                                <input class="to-<?php echo $prop['class'] ?>"
                                       type="text"
                                       name="<?php echo $name ?>[]"
                                       value="<?php echo date('d.m.Y', strtotime($prop['max'])) ?>">
                            </li>
                        </ul>
                    </div>

                <?php } else { ?>

                    <div class="wrapper-field range-field">
                        <div class="price-slider-wrapper a-filter-property">
                            <button class="a-filter-property__title" type="button"
                                    data-toggle="collapse" data-target="#collapse-price"
                                    aria-expanded="true" aria-controls="collapse-price">
                                Диапазон цен
                            </button>
                            <div class="a-filter-property__content collapse show" id="collapse-price">
                                <div class="price-slider-list">
                                    <div class="form-group">
                                        <input type="text" id="minCost"
                                               aria-describedby="priceFromHelp"
                                               class="price-input start-<?php echo $prop['class'] ?> price-input form-control"
                                               data-fact-min="<?php echo $prop['factMin'] ?>"
                                               name="<?php echo $name ?>[]" value="<?php echo $prop['min'] ?>">
                                        <small id="priceFromHelp" class="form-text text-muted">
                                            Цена от
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="maxCost"
                                               aria-describedby="priceToHelp"
                                               class="price-input end-<?php echo $prop['class'] ?> price-input form-control"
                                               data-fact-max="<?php echo $prop['factMax'] ?>"
                                               name="<?php echo $name ?>[]"
                                               value="<?php echo $prop['max'] ?>">
                                        <small id="priceToHelp" class="form-text text-muted">
                                            Цена до
                                        </small>
                                    </div>
                                </div>
                                <div class="a-filter-prop-slider__wrap">
                                    <div id="price-slider"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>

                <?php if (!empty($prop['special'])) { ?>

                <input type="hidden"
                       name="<?php echo $name ?>[]"
                       value="<?php echo $prop['special'] ?>"/>

            <?php } ?>
                <?php break;
            }

            case 'hidden':
            { ?>

                <input type="hidden"
                       name="<?php echo $name ?>"
                       value="<?php echo $prop['value'] ?>"
                       class="price-input"/>

                <?php break;
            }

            case 'text':
            {
                if (!empty($prop['special'])) { ?>

                    <div class="wrapper-field">
                        <span class="label-field">
                            <?php echo $prop['label'] ?>:
                        </span>
                        <input type="text"
                               name="<?php echo $name ?>[]"
                               value="<?php echo $prop['value'] ?>"
                               class="price-input"/>
                    </div>
                    <input type="hidden"
                           name="<?php echo $name ?>[]"
                           value="<?php echo $prop['special'] ?>"/>

                <?php } else { ?>

                    <div class="wrapper-field">
                        <span class="label-field">
                            <?php echo $prop['label'] ?>:
                        </span>
                        <input type="text"
                               name="<?php echo $name ?>"
                               value="<?php echo $prop['value'] ?>"
                               class="price-input"/>
                    </div>

                <?php }
                break;
            }

            default:
                break;
        }
    } ?>
</div>

<?php if (MG::getSetting('printSpecFilterBlock') == 'true') { ?>

<div class="a-filter-body">
    <div class="a-filter__item a-filter-property">
        <button class="a-filter-property__title" type="button"
                data-toggle="collapse" data-target="#collapse-special"
                aria-expanded="true" aria-controls="collapse-special">
            <?php echo lang('filterSpecS'); ?>
        </button>
        <div class="a-filter-property__content collapse show" id="collapse-special">
            <ul class="a-filter-property__list">
                <li class="custom-control custom-checkbox">
                    <input type="checkbox" name="sale" value="1" id="sale"
                           class="a-filter-prop-checkbox custom-control-input" <?php echo isset($_REQUEST['sale']) ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="sale">
                        <?php echo lang('filterSaleS'); ?>
                    </label>
                </li>
                <li class="custom-control custom-checkbox">
                    <input type="checkbox" name="new" value="1" id="new"
                           class="a-filter-prop-checkbox custom-control-input" <?php echo isset($_REQUEST['new']) ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="new">
                        <?php echo lang('filterNewS'); ?>
                    </label>
                </li>
                <li class="custom-control custom-checkbox">
                    <input type="checkbox" name="recommend" value="1" id="recommend"
                           class="a-filter-prop-checkbox custom-control-input" <?php echo isset($_REQUEST['recommend']) ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="recommend">
                        <?php echo lang('filterRecommendS'); ?>
                    </label>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php } ?>

<?php if (MG::get('controller') == 'controllers_catalog' ||
  (isset($_REQUEST['mguniqueurl']) && $_REQUEST['mguniqueurl'] == 'catalog.php')
) { ?>

<div class="a-filter-body">
    <?php
    // Характеристики
    component(
      'filter/props',
      $data['propertyFilter']
    );
    ?>
</div>

<?php } ?>

<?php if (MG::get('controller') == 'controllers_users' ||
  (isset($_REQUEST['mguniqueurl']) && $_REQUEST['mguniqueurl'] == 'users.php')) { ?>
<div class="a-filter-body"></div>
<?php } ?>


<div class="wrapper-field filter-buttons">
    <?php if ($data['submit']) { ?>
    <input type="submit"
           value="<?php echo lang('filter'); ?>"
           class="filter-btn a-button">
    <button class="refreshFilter a-button-link"
            type="button"
          data-url="<?php echo SITE . URL::getClearUri() ?>">
        <?php echo lang('filterReset'); ?>
    </button>
    <?php } else { ?>
    <button class="filter-now a-button">
        <span class="a-button__title">
            <?php echo lang('filter'); ?>
        </span>
    </button>
    <button class="refreshFilter a-button-link"
            type="button">
        <?php echo lang('filterReset'); ?>
    </button>
    <?php } ?>
</div>

<?php
$arReuestUrl = parse_url($_SERVER['REQUEST_URI']);
$html = ob_get_contents();
ob_end_clean();
?>
<section class="a-filter" onclick="">
    <button class="a-filter__btn_toggle a-button a-button_with-icon navbar-toggler d-lg-none" type="button"
            data-toggle="collapse" data-trigger="#a-filter"
            aria-expanded="false" aria-label="Toggle filter">
        <span class="a-button__title">Открыть фильтр</span>
    </button>
    <div id="a-filter" class="a-filter__content navbar-expand-lg navbar-dark navbar-collapse">
        <form name="filter"
              class="filter-form js-filter-form"
              action="<?php echo $arReuestUrl['path'] ?>"
              data-print-res="<?php echo MG::getSetting('printFilterResult') ?>">
            <?php echo str_replace(array('[', ']'), array('&#91;', '&#93;'), $html) ?>
        </form>
    </div>
</section>
