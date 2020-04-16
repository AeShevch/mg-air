<?php mgAddMeta('/components/duplicative-sort/duplicative-sort.js'); ?>
<div class="dropdown bootstrap-select dropup">
    <select id="duplicative-sorter" class="last-items-dropdown selectpicker dropup" data-header="Сортировать товары">
        <option value="price_course|-1"
                selected="selected">
            по цене, сначала недорогие
        </option>
        <option value="price_course|1">
            по цене, сначала дорогие
        </option>
        <option value="id|1">
            по новизне
        </option>
        <option value="count_buy|1">
            по популярности
        </option>
        <option value="recommend|1">
            по сначала рекомендуемые
        </option>
        <option value="new|1">
            по сначала новинки
        </option>
        <option value="old_price|1">
            по сначала распродажа
        </option>
        <option value="sort|-1">
            по порядку
        </option>
        <option value="sort|1">
            по в обратном порядке
        </option>
        <option value="count|1">
            по наличию
        </option>
        <option value="count|-1">
            по возрастанию количества
        </option>
        <option value="title|-1">
            по наименованию А-Я
        </option>
        <option value="title|1">
            по наименованию Я-А
        </option>
    </select>
</div>
