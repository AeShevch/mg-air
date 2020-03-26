<?php
mgAddMeta('components/groups/groups.css');
// Для отладки
// console_log($data); ?>

<section class="a-groups">
    <div class="container">
        <ul class="a-groups__links nav justify-content-center" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Акции</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Новинки</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Популярные</a>
            </li>
        </ul>
        <div class="a-groups__contents tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="tab-pane__inner row">
                <?php
                // Товары со скидкой
                foreach ($data['saleProducts'] as $item) { ?>
                    <div class="col-6 col-md-3">
                        <?php // Миникарточка товара
                        component('catalog/item', $item); ?>
                    </div>
                <?php } ?>
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="tab-pane__inner row">
                <?php
                // Новинки
                foreach ($data['newProducts'] as $item) { ?>
                    <div class="col-6 col-md-3">
                        <?php // Миникарточка товара
                        component('catalog/item', $item); ?>
                    </div>
                <?php } ?>
                </div>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="tab-pane__inner row">
                <?php
                // Популярные товары
                foreach ($data['recommendProducts'] as $item) { ?>
                    <div class="col-6 col-md-3">
                        <?php // Миникарточка товара
                        component('catalog/item', $item); ?>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
