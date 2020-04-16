'use strict';
(function () {
    const productsContainer = document.querySelector('.js-products-list');
    const products = productsContainer.children;
    const onFormChange = (evt) => {
        document.cookie = 'grid=' + evt.target.value;
        for (const product of products ) {
            product.classList = 'col-6 ' + evt.target.value;
        }
    };
    document.forms.gridSwitcher.addEventListener('change', onFormChange);
})();
