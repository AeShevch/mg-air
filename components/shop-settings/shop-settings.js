'use strict';

(function () {
  var WRAPPER = document.querySelectorAll('.js-custom-submenu-wrapper');
  document.querySelectorAll('.js-curr-select').forEach(function (currencyBtn) {
    currencyBtn.addEventListener('click', function () {
      $.ajax({
        type: 'GET',
        url: mgBaseDir + '/ajaxrequest',
        data: {
          userCustomCurrency: currencyBtn.dataset.currency
        },
        success: function success() {
          window.location.reload();
        }
      });
    });
  });
})();