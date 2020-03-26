<?php mgAddMeta('components/search/search.js'); ?>
<?php mgAddMeta('components/search/search.css'); ?>

<form class="a-search js-search-form" method="GET" action="<?php echo SITE ?>/catalog">
    <div class="a-search__inner" role="search">
        <input class="a-search__input js-search-input"
               type="search" autocomplete="off"
               aria-label="<?php echo lang('searchPh'); ?>"
               placeholder="<?php echo lang('searchPh'); ?>"
               value="<?php if (isset($_GET['search'])) {echo $_GET['search'];} ?>">
        <button class="a-search__close a-search__close_hidden js-close-search"></button>
        <button class="a-search__button js-do-search" aria-label="<?php echo lang('search'); ?>">
            <svg class="a-search__icon">
                <use xlink:href="#icon_search"></use>
            </svg>
        </button>
        <nav class="a-search__results a-fast-results">
            <ul class="js-search-fast-results a-fast-results__list"></ul>
        </nav>
    </div>
</form>

<template id="search-fast-results-item">
    <li class="js-fast-result-item-template a-fast-results__item a-fast-result">
        <a class="a-fast-result__link js-fast-result-link" href="" title="">
            <div class="a-fast-result__img-wrap">
                <img src="" alt="" title="" class="a-fast-result__img js-fast-result-img">
            </div>
            <div class="a-fast-result__inner">
                <h4 class="a-fast-result__title js-fast-result-title"></h4>
                <span class="a-fast-result__category js-fast-result-category"></span>
                <span class="a-fast-result__price js-fast-result-price"></span>
            </div>
        </a>
    </li>
</template>
