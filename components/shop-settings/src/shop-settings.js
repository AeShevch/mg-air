"use strict";
(function () {

  document.querySelectorAll(".js-curr-select").forEach((currencyBtn) => {
    currencyBtn.addEventListener("click", function () {
      $.ajax({
        type: "GET",
        url: mgBaseDir + "/ajaxrequest",
        data: {
          userCustomCurrency: currencyBtn.dataset.currency,
        },
        success: function () {
          window.location.reload();
        },
      });
    });
  });
})();
