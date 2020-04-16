<?php mgAddMeta('components/groups/groups.css'); ?>
<section class="a-groups">
    <div class="container">
        <div class="a-groups__inner row">
            <?php foreach($data as $group) : ?>
            <div class="col-sm-6 col-md-4 a-groups__item a-product-column">
                <h2 class="a-product-column__title">
                    <?php echo $group['title']; ?>
                </h2>
                <div class="a-product-column__inner">
                    <?php foreach($group['products'] as $item) {
                        component('catalog/item', $item, 'item_mini');
                    }
                    ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
