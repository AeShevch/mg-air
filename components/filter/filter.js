// список отложенных функций, выполняемых после фильтрации аяксом.
// Пример использования в сторонних JS:
// AJAX_CALLBACK_FILTER = [
//        {callback: 'settings.closeAllTab', param: null},
//        {callback: 'settings.openTab', param: ['tab-system']},
// ];
var AJAX_CALLBACK_FILTER = [];
var VIEW_ALL_FILTER = -1;

$(document).ready(function () {

    function mgInitFilter() {
        var step = 10;
        if (typeof productFilterPriceSliderStep != 'undefined') {
            step = productFilterPriceSliderStep;
        }
        $("#price-slider").slider({
            min: $("input#minCost").data("fact-min"),
            max: $("input#maxCost").data("fact-max"),
            values: [$("input#minCost").val(), $("input#maxCost").val()],
            step: step,
            range: true,
            stop: function (event, ui) {
                $("input#minCost").val($("#price-slider").slider("values", 0));
                $("input#maxCost").val($("#price-slider").slider("values", 1));
                getFilteredItems($('.js-filter-form #maxCost'));
            },
            slide: function (event, ui) {
                $("input#minCost").val($("#price-slider").slider("values", 0));
                $("input#maxCost").val($("#price-slider").slider("values", 1));
            }
        });

        $("input#minCost").change(function () {
            var value1 = $("input#minCost").val();
            var value2 = $("input#maxCost").val();

            if (parseInt(value1) > parseInt(value2)) {
                value1 = value2;
                $("input#minCost").val(value1);
            }
            $("#price-slider").slider("values", 0, value1);
        });

        $("input#maxCost").change(function () {
            var value1 = $("input#minCost").val();
            var value2 = $("input#maxCost").val();

            if (parseInt(value1) > parseInt(value2)) {
                value2 = value1;
                $("input#maxCost").val(value2);
            }

            $("#price-slider").slider("values", 1, value2);
        });

        $("input#maxCost").change(function () {
            var value = $("input#maxCost").val();

            if (value == '') {
                $("input#maxCost").val($("input#maxCost").data("fact-max"));
            }
        });


        // Собираем слайдер с ползунками для всех характеристик
        $(".js-filter-item-toggle .a-filter-prop-slider").each(function (i) {

            var min = parseInt($(this).data("min"));
            var max = parseInt($(this).data("max"));

            var fMin = (parseInt($(this).data("factmin"))) ? parseInt($(this).data("factmin")) : min;
            var fMax = (parseInt($(this).data("factmax"))) ? parseInt($(this).data("factmax")) : max;

            var sliderEl = $(this);
            var minInput = $("input#Prop" + $(this).data("id") + "-min");
            var maxInput = $("input#Prop" + $(this).data("id") + "-max");
            var step = max / 10;

            // Создаем ползунок
            $(this).slider({
                min: min,
                max: max,
                values: [fMin, fMax],
                step: 1,
                range: true,
                stop: function (event, ui) {
                    minInput.val(sliderEl.slider("values", 0));
                    maxInput.val(sliderEl.slider("values", 1));
                    getFilteredItems(maxInput);
                },
                slide: function (event, ui) {
                    minInput.val(sliderEl.slider("values", 0));
                    maxInput.val(sliderEl.slider("values", 1));
                }
            });

            // Создаем крючок для ввода из полей
            minInput.change(function () {
                var value1 = minInput.val();
                var value2 = maxInput.val();

                // Если значение ускакало за пределы
                if (parseInt(value1) > parseInt(value2)) {
                    value1 = value2;
                    minInput.val(value1);
                }
                sliderEl.slider("values", 0, value1);
                getFilteredItems(maxInput);
            });

            maxInput.change(function () {
                var value1 = minInput.val();
                var value2 = maxInput.val();

                if (parseInt(value1) > parseInt(value2)) {
                    value2 = value1;
                    maxInput.val(value2);
                }
                sliderEl.slider("values", 1, value2);
                getFilteredItems(maxInput);
            });
        });

    }

    mgInitFilter();

    $('body').on('click', '.js-show-property-items', function (evt) {
        evt.preventDefault();
        $(this).parent().find('li').fadeIn();
        $(this).hide();
    });

    $('body').on('click', '.a-viewfilter-all', function (evt) {
        evt.preventDefault();
        $(this).hide();
        $('.js-filter-item-toggle').fadeIn();
        VIEW_ALL_FILTER = -1 * VIEW_ALL_FILTER;
    });

    $('body').on('click', '.js-filter-item-toggle input[type=checkbox]', function () {
        getFilteredItems($(this));
    });

    $('body').on('change', '.js-filter-item-toggle select', function () {
        getFilteredItems($(this));
    });

    $('body').on('change', '.js-filter-form #maxCost', function () {
        getFilteredItems($(this));
    });

    $('body').on('change', '.js-filter-form #minCost', function () {
        getFilteredItems($(this));
    });

    $('body').on('change', '.js-filter-form select[name=sorter]', function () {
        $('.js-filter-form').submit();
    });

    /**
     *
     * @param {type} object - объект который инициировал новый поиск, нужен для расчета офсета
     * @param {type} page - страница
     * @returns {undefined}
     */
    function getFilteredItems(object, page, sort) {
        var uri = $('form.js-filter-form').attr('action');

        var printToLeft = true; // установить в false если нужно выводить внутри блока

        var offset = object.offset();

        var leftMargin = $('.a-filter-head').css('width').slice(0, -2);
        var blockLeft = $('.a-filter-head').offset().left;
        leftMargin = blockLeft + leftMargin * 1;

        if (!printToLeft)
            leftMargin = leftMargin - $('.a-filter-head').css('width').slice(0, -2);

        $('.a-filter-head .filter-preview').css('left', leftMargin + 'px');
        //
        $('.a-filter-head .filter-preview span').hide();
        $('.a-filter-head .filter-preview .loader-search').fadeIn();
        $('.a-filter-head .filter-preview').show();
        $('.a-filter-head .filter-preview').css('top', offset.top + 'px');
        $('.a-filter-head .filter-preview .loader-search').fadeOut();
        $('.a-filter-head .filter-preview span').html(locale.productSearch).fadeIn();
        //
        var autoUpdate = $('.js-filter-form').data('print-res');

        if (!autoUpdate &&
            (parseFloat($('.js-filter-form .start-price').val()) - 1) <= $('.js-filter-form .start-price').data('fact-min') &&
            (parseFloat($('.js-filter-form .end-price').val()) + 1) >= $('.js-filter-form .end-price').data('fact-max')
        ) {
            $('.js-filter-form .start-price').prop('disabled', true);
            $('.js-filter-form .end-price').prop('disabled', true);
        }

        var packedData = $('.js-filter-form').serialize();
        if (!autoUpdate) {
            history.replaceState(packedData, "", uri + '?' + packedData);
            $.ajax({
                type: "GET",
                url: uri,
                data: packedData + '&filter=1',
                dataType: 'html',
                success: function (response) {
                    // $('.a-filter-head .filter-preview span').hide();
                    // $('.a-filter-head .filter-preview .loader-search').fadeIn();
                    // $('.a-filter-head .filter-preview').show();
                    // $('.a-filter-head .filter-preview').css('top', offset.top + 'px');

                    // $('.a-filter-head .filter-preview').fadeOut();
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
                    $('.apply-filter-form').html($(response).find('.apply-filter-form').html());
                    if ($('.apply-filter-form .apply-filter-item').length > 0) {
                        $('.apply-filter-form').fadeIn();
                        $('.apply-filter-title').fadeIn();
                    } else {
                        $('.apply-filter-form').fadeOut();
                        $('.apply-filter-title').fadeOut();
                    }
                    mgInitFilter();
                    if (VIEW_ALL_FILTER == 1) {
                        $('.a-viewfilter-all').hide();
                        $('.js-filter-item-toggle').fadeIn();
                    }

                },
                complete: function () {
                    // выполнение стека отложенных функций после AJAX вызова
                    if (AJAX_CALLBACK_FILTER) {
                        //debugger;
                        AJAX_CALLBACK_FILTER.forEach(function (element, index, arr) {
                            eval(element.callback).apply(this, element.param);
                        });

                    }

                    $('.variants-table').each(function () {
                        $(this).find('[type=radio]:eq(0)').click().trigger('change');
                    });

                    $('.color-block .color.active').click();
                }
            });
        } else {
            $.ajax({
                type: "GET",
                url: uri,
                data: packedData + '&filter=1&getcount=1',
                dataType: 'json',
                success: function (response) {
                    state = $('.a-viewfilter-all').is(':visible');
                    if (response.htmlProp != 'false') {
                        if ($('.filterTmpDiv').html() == undefined) {
                            $('body').append('<div class="filterTmpDiv" style="display:none;"></div>');
                        }
                        $('.filterTmpDiv').html(response.htmlProp);
                        $('form[name=filter] .a-filter:last').html($('.filterTmpDiv .a-filter').html());
                        mgInitFilter();
                    }

                    if (!state) $('.a-viewfilter-all').click();

                    // $('.a-filter-head .filter-preview span').hide();
                    // $('.a-filter-head .filter-preview .loader-search').fadeIn();
                    // $('.a-filter-head .filter-preview').show();
                    // $('.a-filter-head .filter-preview').css('top', offset.top + 'px');
                    var html = response.lang.product + ': ' + response.count + ' ' + response.lang.unit;
                    if (response.count > 0) {
                        html += ' <a href="' + uri + '?' + packedData + '&filter=1">' + response.lang.show + '</a>';
                    }

                    // $('.a-filter-head .filter-preview .loader-search').fadeOut();
                    $('.a-filter-head .filter-preview span').html(html).fadeIn();
                }
            });
        }
    }

    // клик вне блока с количеством найденных товаров
    $(document).mousedown(function (e) {
        var container = $('.a-filter-head .filter-preview');
        if (container.has(e.target).length === 0) {
            container.hide();
        }
    });

    $(".price-slider-list input[type=text]").change(function () {
        if (isNaN(parseFloat($(this).val()))) {
            $(this).val('1');
        }
    });


    // сброс фильтров (используется в каталоге в форме фильтров)
    $('body').on('click', '.refreshFilter', function() {
        location.href = $(this).data('url');
    });

});

