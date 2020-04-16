<?php mgAddMeta('components/grid-switcher/grid-switcher.js'); ?>
<?php mgAddMeta('components/grid-switcher/grid-switcher.css'); ?>

<div class="a-grid-switcher">
    <form class="a-grid-switcher__form" name="gridSwitcher" aria-label="Changes product per row count">

        <input style="display: none;"
               class="a-grid-switcher__item"
               id="gridSwitcher-1"
               type="radio" name="grid-switcher-item"
               <?php echo isset($_COOKIE['grid']) && $_COOKIE['grid'] === 'col-md-12' ? 'checked' : ''; ?>
               value="col-md-12">
        <label class="a-grid-switcher__label a-grid-switcher__label_1"
               data-toggle="tooltip" data-placement="top"
               data-original-title="1 товар в строке"
               for="gridSwitcher-1"
               aria-label="1 products per row"></label>

        <input style="display: none;"
               class="a-grid-switcher__item"
               id="gridSwitcher-2"
               type="radio" name="grid-switcher-item"
          <?php echo isset($_COOKIE['grid']) && $_COOKIE['grid'] === 'col-md-6' ? 'checked' : ''; ?>
               value="col-md-6">
        <label class="a-grid-switcher__label a-grid-switcher__label_2"
               data-toggle="tooltip" data-placement="top"
               data-original-title="2 товара в строке"
               for="gridSwitcher-2"
               aria-label="2 products per row"></label>

        <input style="display: none;"
               class="a-grid-switcher__item"
               id="gridSwitcher-3"
               type="radio" name="grid-switcher-item"
          <?php echo (isset($_COOKIE['grid']) && $_COOKIE['grid'] === 'col-md-4') || !isset($_COOKIE['grid']) ? 'checked' : ''; ?>
               value="col-md-4">
        <label class="a-grid-switcher__label a-grid-switcher__label_3"
               data-toggle="tooltip" data-placement="top"
               data-original-title="3 товара в строке"
               for="gridSwitcher-3"
               aria-label="3 products per row"></label>

        <input style="display: none;"
               class="a-grid-switcher__item"
               id="gridSwitcher-4"
               type="radio" name="grid-switcher-item"
          <?php echo isset($_COOKIE['grid']) && $_COOKIE['grid'] === 'col-md-3' ? 'checked' : ''; ?>
               value="col-md-3">
        <label class="a-grid-switcher__label a-grid-switcher__label_4"
               data-toggle="tooltip" data-placement="top"
               data-original-title="4 товара в строке"
               for="gridSwitcher-4"
               aria-label="4 products per row"></label>

    </form>
</div>
