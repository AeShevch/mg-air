"use strict";

$(document).ready(function () {
  //  Применённые фильтры
  var ajaxUpdate = !$('.apply-filter-form').data('print-res');

  if (!ajaxUpdate && location.search.indexOf("applyFilter") > 0) {
    var destination = $('form.apply-filter-form').offset().top;
    $('html, body').animate({
      scrollTop: destination
    }, 500);
  }

  $("body").on('click', '.removeFilter', function (evt) {
    evt.preventDefault();
    onRemoveAppliedFilterItem($(this));
  });

  function onRemoveAppliedFilterItem(object) {
    var parent = object.parents(".apply-filter-item-value");

    if (!parent.html() || !parent.siblings().length) {
      parent = object.parents(".apply-filter-item");
    }

    parent.remove();
    var packedData = $('.js-applied-form').serialize();

    if (ajaxUpdate) {
      var uri = $('form.apply-filter-form').prop('action');
      history.replaceState(packedData, "", uri + '?' + packedData);
      $.ajax({
        type: "GET",
        url: uri,
        data: packedData + '&filter=1',
        dataType: 'html',
        success: function success(response) {
          $('.a-filter-head .filter-preview').fadeOut();
          var productContainer = $(response).find('.js-products-list').html();
          $('.js-products-list').fadeOut();

          if ($(response).find('.js-product-item').length == 0) {
            $('.js-products-list').html('<div class="a-filter-empty"><span>' + locale.filterNone + '</span></div>').fadeIn();
          } else {
            $('.js-products-list').html(productContainer).fadeIn();
          }

          var filterForm = $(response).find('.js-filter-form').html();
          $('.js-filter-form').fadeOut();
          $('.js-filter-form').html(filterForm).fadeIn();
          mgInitFilter();
        },
        complete: function complete() {
          // выполнение стека отложенных функций после AJAX вызова
          if (AJAX_CALLBACK_FILTER) {
            //debugger;
            AJAX_CALLBACK_FILTER.forEach(function (element, index, arr) {
              eval(element.callback).apply(this, element.param);
            });
          }
        }
      });
    } else {
      $('.js-applied-form').submit();
    }
  }
});