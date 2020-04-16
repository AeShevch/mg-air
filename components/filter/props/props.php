<?php
if (!empty($data['props'])) : ?>
<?php foreach ($data['props'] as $prop) : ?>
<?php
$viewCount = MG::getSetting('filterCountProp');
$counter = 0;
if (empty($prop)) continue; ?>

<div class="a-filter__item a-filter-property js-filter-item-toggle"
     style="<?php echo $prop['style'] ?>">
    <button class="a-filter-property__title a-toogle-option" type="button"
            data-toggle="collapse" data-target="#collapse-<?php echo $prop['idProp'] ?>"
            aria-expanded="true" aria-controls="collapse-<?php echo $prop['idProp'] ?>">
        <?php if (!empty($prop['description'])) : ?>
        <span class="a-toogle-option__tooltip"
              data-toggle="tooltip" data-placement="right"
              data-original-title="<?php echo $prop['description'] ?>">
        <?php endif; ?>
            <span class="a-toogle-option__title">
                <?php echo $prop['name'] ?>
            </span>
        <?php if (!empty($prop['description'])) : ?>
        </span>
        <?php endif; ?>

    </button>
    <div class="a-filter-property__content collapse show" id="collapse-<?php echo $prop['idProp'] ?>">
        <ul class="a-filter-property__list">
            <?php if (!empty($prop['data'])) : ?>
                <?php if ($prop['type'] == 'select') : ?>
                <li class="dropdown bootstrap-select dropup">
                    <select name="<?php echo 'prop[' . $prop['idProp'] . '][]' ?>"
                            class="a-filter-prop-select selectpicker dropup"
                            data-header="<?php echo $prop['name'] ?>">
                        <option value="">
                            <?php echo lang('filterNotSelected') ?>
                        </option>
                        <?php foreach ($prop['data'] as $propData) { ?>
                        <option value="<?php echo $propData['value_id'] . '|' . $propData['value_type'] ?>" <?php echo $propData['selected'] ?>>
                            <?php echo $propData['value_name'] ?>
                        </option>
                        <?php } ?>
                    </select>
                </li>
                <?php else : ?>
                    <?php foreach ($prop['data'] as $propData) : ?>
                        <?php if (isset($propData['value_name']) && $propData['value_name'] == '') continue;
                        $counter++;
                        switch ($propData['type']) {
                            case 'active': ?>
                                <li style="<?php echo $counter > $viewCount ? 'display:none;' : '' ?>">
                                    <label <?php echo $propData['active'] ?>>
                                        <?php echo $color; ?>
                                        <input type="checkbox" <?php echo $propData['checked'] ?>
                                               name="<?php echo 'prop[' . $prop['idProp'] . '][]' ?>"
                                               value="<?php echo $propData['value_id'] . '|' . $propData['value_type'] ?>"
                                               class="a-filter-prop-checkbox">
                                        <?php echo $propData['value_name'] ?>
                                        <span class="cbox"></span>&nbsp;
                                        <span class="unit"><?php echo $propData['value_unit'] ?></span>
                                    </label>
                                </li>
                                <?php break;
                            case 'normal':
                                $color = isset($color) ? $color : null;
                                if ($propData['img'] != '') { ?>

                                    <li title="<?php echo $propData['value_name'] ?>"
                                        class="<?php echo !empty($propData['color']) ? ' color-filter' : ''; ?>"
                                        style="<?php echo $counter > $viewCount ? 'display:none;' : ''; ?>">
                                        <label>
                                            <?php echo $color ?>
                                            <input type="checkbox" <?php echo $propData['checked'] ?>
                                                   class="a-filter-prop-checkbox"
                                                   name="<?php echo 'prop[' . $prop['idProp'] . '][]' ?>"
                                                   value="<?php echo $propData['value_id'] . '|' . $propData['value_type'] ?>">
                                            <span class="value-name">
                                                <?php echo $propData['value_name'] ?>
                                            </span>
                                            <span class="cbox" style="background: url(<?php echo SITE . '/' . $propData['img']; ?>);background-size:cover;"></span>&nbsp;
                                            <span class="unit"><?php echo $propData['value_unit'] ?></span>
                                        </label>
                                    </li>

                                <?php } else { ?>

                                    <li title="<?php echo $propData['value_name'] ?>"
                                        class="custom-control custom-checkbox <?php echo !empty($propData['color']) ? 'color-filter' : '' ?>"
                                        style="<?php echo $counter > $viewCount ? 'display:none;' : '' ?>">
                                        <input type="checkbox" <?php echo $propData['checked'] ?>
                                               name="<?php echo 'prop[' . $prop['idProp'] . '][]' ?>"
                                               id="prop-<?php echo $prop['idProp'] . '_' . $propData['value_id'] ?>"
                                               value="<?php echo $propData['value_id'] . '|' . $propData['value_type'] ?>"
                                               class="a-filter-prop-checkbox custom-control-input">
                                        <label class="custom-control-label"
                                               for="prop-<?php echo $prop['idProp'] . '_' . $propData['value_id'] ?>">
                                            <?php echo $color ?>
                                            <span class="value-name"><?php echo $propData['value_name'] ?></span>
                                            <span class="cbox" style="background-color: <?php echo $propData['color'] ?>"></span>&nbsp;
                                            <span class="unit"><?php echo $propData['value_unit'] ?></span>
                                        </label>
                                    </li>
                                <?php }
                                break;
                            case 'slider|easy':
                            case 'slider|hard': ?>

                                <li>
                                    <div class="wrapper-field range-field">
                                        <div class="price-slider-wrapper">
                                            <input type="hidden"
                                                   name="<?php echo 'prop[' . $prop['idProp'] . '][0]' ?>"
                                                   value="<?php echo $propData['type'] ?>">
                                            <div class="price-slider-list">
                                                <div class="form-group">
                                                    <input type="text" id="<?php echo 'Prop' . $prop['idProp'] . '-min' ?>"
                                                           aria-describedby="priceFromHelp"
                                                           class="price-input start-<?php echo $prop['class'] ?> numericProtection price-input form-control"
                                                           data-fact-min="<?php echo $propData['min'] ?>"
                                                           name="<?php echo 'prop[' . $prop['idProp'] . '][1]' ?>"
                                                           value="<?php echo $propData['fMin'] ?>">
                                                    <small id="priceFromHelp" class="form-text text-muted">
                                                        От
                                                    </small>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" id="<?php echo 'Prop' . $prop['idProp'] . '-max' ?>"
                                                           aria-describedby="priceToHelp"
                                                           class="price-input end-price numericProtection price-input form-control"
                                                           data-fact-max="<?php echo $propData['max'] ?>"
                                                           name="<?php echo 'prop[' . $prop['idProp'] . '][2]' ?>"
                                                           value="<?php echo $propData['fMax'] ?>">
                                                    <small id="priceToHelp" class="form-text text-muted">
                                                        До
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="a-filter-prop-slider__wrap">
                                                <div name="<?php echo 'prop[' . $prop['idProp'] . '][]' ?>"
                                                     class="a-filter-prop-slider"
                                                     data-id="<?php echo $prop['idProp'] ?>"
                                                     data-min="<?php echo $propData['min'] ?>"
                                                     data-max="<?php echo $propData['max'] ?>"
                                                     data-factmin="<?php echo $propData['fMin'] ?>"
                                                     data-factmax="<?php echo $propData['fMax'] ?>"></div>
                                                <input type="hidden"
                                                       name="<?php echo 'prop[' . $prop['idProp'] . '][min]' ?>"
                                                       value="<?php echo $propData['min'] ?>">
                                                <input type="hidden"
                                                       name="<?php echo 'prop[' . $prop['idProp'] . '][max]' ?>"
                                                       value="<?php echo $propData['max'] ?>">
                                            </div>

                                        </div>
                                    </div>
                                </li>
                                <?php break;
                            default:
                                if ($propData['img'] != '') { ?>

                                    <li title="<?php echo $propData['value_name'] ?>"
                                        class="<?php echo !empty($propData['color']) ? 'color-filter disabled' : '' ?>"
                                        style="<?php echo $counter > $viewCount ? 'display:none;' : '' ?>">
                                        <label class="disabled-prop">
                                            <?php echo $color ?>
                                            <input disabled
                                                   type="checkbox" <?php echo $propData['checked'] ?>
                                                   name="<?php echo 'prop[' . $prop['idProp'] . '][]' ?>"
                                                   value="<?php echo $propData['value_id'] . '|' . $propData['value_type'] ?>"
                                                   class="a-filter-prop-checkbox">
                                            <span class="value-name"><?php echo $propData['value_name'] ?></span>
                                            <span class="cbox"
                                                  style="background: url(<?php echo SITE . '/' . $propData['img'] ?>);background-size:cover;"></span>&nbsp;
                                            <span class="unit"><?php echo $propData['value_unit'] ?></span>
                                        </label>
                                    </li>

                                <?php } else { ?>

                                    <li title="<?php echo $propData['value_name'] ?>"
                                        class="<?php echo !empty($propData['color']) ? 'color-filter disabled' : '' ?>"
                                        style="<?php echo $counter > $viewCount ? 'display:none;' : '' ?>">
                                        <label class="disabled-prop">
                                            <?php echo $color ?>
                                            <input disabled
                                                   type="checkbox" <?php echo $propData['checked'] ?>
                                                   name="<?php echo 'prop[' . $prop['idProp'] . '][]' ?>"
                                                   value="<?php echo $propData['value_id'] . '|' . $propData['value_type'] ?>"
                                                   class="a-filter-prop-checkbox">
                                            <span class="value-name"><?php echo $propData['value_name'] ?></span>
                                            <span class="cbox"
                                                  style="background-color: <?php echo $propData['color'] ?>"></span>
                                            <span class="unit"><?php echo $propData['value_unit'] ?></span>
                                        </label>
                                    </li>

                                <?php }
                                break;
                        }
                    endforeach ?>
                <?php endif; ?>
            <?php endif; ?>
        </ul>

        <?php if ($counter > $viewCount) : ?>
        <button class="a-viewfilter a-button-link js-show-property-items">
            <?php echo lang('viewFilterAll') ?>
        </button>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>
<?php if (!empty($data['allFilter'])) : ?>
<button class="a-viewfilter-all">
    <span class="a-viewfilter-all__title">
        <?php echo lang('filterShowAll') ?>
    </span>
</button>
<?php endif; ?>
