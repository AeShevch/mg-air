'use strict';
(function () {
    const WRAPPER = document.querySelectorAll('.js-custom-submenu-wrapper');

    document.querySelectorAll('.js-curr-select').forEach((currencyBtn) => {
        currencyBtn.addEventListener('click',  function() {
            $.ajax({
                type: 'GET',
                url: mgBaseDir + '/ajaxrequest',
                data: {
                    userCustomCurrency: currencyBtn.dataset.currency,
                },
                success: function() {
                    window.location.reload();
                },
            });
        });
    });
})();
