$(document).ready(function() {

    // функция кликов по размерной сетке (страница товара и миникарточка)
    function sizeMapShow(id, search) {
        if (sizeMapObject == undefined) return false;

        var show = 'color';
        if (search == 'color') {
            show = 'size';
        }

        sizeMapObject.find('.' + show).hide();
        var toCheck = '';
        sizeMapObject.find('.variants-table .variant-tr').each(function() {
            if ($(this).data(search) == id) {
                if (sizeMapObject.find(this).data('size') != '') {
                    sizeMapObject.find('.' + show + '[data-id=' + sizeMapObject.find(this).data(show) + ']').show();
                    if ($(this).data('count') == 0) {
                        sizeMapObject.find('.' + show + '[data-id=' + sizeMapObject.find(this).data(show) + ']').addClass('inactive');
                    } else {
                        sizeMapObject.find('.' + show + '[data-id=' + sizeMapObject.find(this).data(show) + ']').removeClass('inactive');
                    }
                    if (toCheck == '') {
                        toCheck = sizeMapObject.find('.' + show + '[data-id=' + sizeMapObject.find(this).data(show) + ']');
                    }
                }
            }
        });
        if (toCheck != '') {
            toCheck.click();
        }
    }

    // функция выбора варианта после клика по размерной сетке (страница товара и миникарточка)
    function choseVariant() {
        if (sizeMapObject == undefined) return false;
        var color = '';
        var size = '';
        if (sizeMapObject.find('.color').length != 0) {
            color = '[data-color=' + sizeMapObject.find('.color.active').data('id') + ']';
        }
        if (sizeMapObject.find('.size').length != 0) {
            size = '[data-size=' + sizeMapObject.find('.size.active').data('id') + ']';
        }
        sizeMapObject.find('.variants-table .variant-tr' + color + size + ' input[type=radio]').click();
    }

    var sizeMapObject = undefined;


    $(document.body).on('change', '.block-variants input[type=radio]', function(e) {
        //подстановка картинки варианта вместо картинки товара (страница товара и миникарточка)
        changeMainImgToVariant($(this));

        $(this).parents('tbody').find('tr label').removeClass('active');
        $(this).parents('tr').find('label').addClass('active');

        if (!$('.mg-product-slides').length) {
            var obj = $(this).parents('.js-catalog-item');
            var count = $(this).data('count');
            if (!obj.length) {
                obj = $(this).parents('.mg-compare-product');
            }

            var form = $(this).parents('form');

            if (form.hasClass('actionView')) {
                return false;
            }

            var buttonbuy = $(obj).find('.js-product-controls a:visible').hasClass('js-add-to-cart');

            if (count != '0' && !buttonbuy) {
                if ('false' == window.actionInCatalog) {
                    $(obj).find('.js-product-more').show();
                    $(obj).find('.js-add-to-cart').hide();
                } else {
                    $(obj).find('.js-product-more').hide();
                    $(obj).find('.js-add-to-cart').show();
                }
            } else if (count == '0' && buttonbuy == true) {
                $(obj).find('.js-product-more').show();
                $(obj).find('.js-add-to-cart').hide();
            }
        }
    });


    // делает активными нужные элементы размерной сетки при изменении варианта товара (страница товара и миникарточка)
    $(document.body).on('click', '.variants-table tr input[type=radio]', function() {
        sizeMapObject = $(this).closest('form');
        sizeMapObject.find('.color').removeClass('active');
        sizeMapObject.find('.size').removeClass('active');

        var tmp = $(this).closest('tr').data('color');
        if (tmp != undefined && tmp != '') {
            sizeMapObject.find('.color[data-id=' + $(this).closest('tr').data('color') + ']').addClass('active');
        }
        tmp = $(this).closest('tr').data('size');
        if (tmp != undefined && tmp != '') {
            sizeMapObject.find('.size[data-id=' + $(this).closest('tr').data('size') + ']').addClass('active');
        }
    });

    // обработчик кликов по размерной сетке (страница товара и миникарточка)
    $(document.body).on('click', '.color', function() {
        sizeMapObject = $(this).parents('form');
        if (sizeMapMod !== 'size') {
            sizeMapShow($(this).data('id'), 'color');
        }
        sizeMapObject.find('.color').removeClass('active');
        $(this).addClass('active');
        choseVariant();
    });

    $(document.body).on('click', '.size', function() {
        sizeMapObject = $(this).parents('form');
        if (sizeMapMod === 'size') {
            sizeMapShow($(this).data('id'), 'size');
        }
        sizeMapObject.find('.size').removeClass('active');
        $(this).addClass('active');
        choseVariant();
    });

    // делает активными нужные элементы размерной сетки (страница товара и миникарточка)
    $('.variants-table').each(function() {
        var tmp = $(this).find('tr:eq(0)').data('color');
        if (tmp != undefined && tmp != '') {
            $(this).parents('form').find('.color[data-id=' + tmp + ']').addClass('active');
        }
        tmp = $(this).find('tr:eq(0)').data('size');
        if (tmp != undefined && tmp != '') {
            $(this).parents('form').find('.size[data-id=' + tmp + ']').addClass('active');
        }
    });

    // выбор первого цвета при загрузке страницы (страница товара и миникарточка)
    $('.color-block .color.active').click();

    // костыль для верстки чекбокса выбранного варианта в таблице вариантов товара без размерной сетки (страница товара и миникарточка)
    $('.c-variant__column input[name=variant][checked=checked]').each(function() {
        $(this).parents('.c-form').addClass('active');
    });

    // для выбора варианта по якорю
    if (varHashProduct === 'true' || varHashProduct === true) {
        if (location.hash != '') {
            code = location.hash.replace('#', '');
            code = decodeURI(code);
            if (sizeMapMod == 'size' && $('[data-code="' + code + '"]:eq(0)').closest('tr[data-size!=\'\']').length) {
                size = $('[data-code="' + code + '"]:eq(0)').closest('tr').data('size');
                $('.size[data-id=' + size + ']').trigger('click');
            } else if ($('[data-code="' + code + '"]:eq(0)').closest('tr[data-color!=\'\']').length) {
                color = $('[data-code="' + code + '"]:eq(0)').closest('tr').data('color');
                $('.color[data-id=' + color + ']').trigger('click');
            }
            $('[data-code="' + code + '"]:eq(0)').click();
        }

        // подстановка якоря в url
        $(document.body).on('click', '.variants-table tr input[type=radio]', function() {
            data = $(this).data('code');
            if (data != undefined) location.hash = data;
        });
    }

});


// Функция получает изображение варианта и подменяет его в карусели
function changeMainImgToVariant(elem) {
    var form = elem.parents('.js-product-form');
    var request = form.formSerialize();
    var productId = form.data('product-id');
    var secondarySlider = $('.js-secondary-img-slider');
    var activeLink = $('.js-main-img-slider .active .js-images-link');
    var firstSlide = secondarySlider.find('[data-slide-index=0]');

    // Пересчет цены
    $.ajax({
        type: 'POST',
        url: mgBaseDir + '/product/',
        data: 'getVariantImages=1&productId=' + productId + '&' + request,
        dataType: 'json',
        cache: false,
        success: function(response) {
            // Если пришла не заглушка, то продолжаем
            if (response.data.image_orig !== '' && !response.data.image_orig.includes('no-img.jpg')) {

                // Если это миникарточка
                if (elem.parents('.js-catalog-item').length) {
                    // Находим изображение товара в миникарточке
                    var itemImg = elem.parents('.js-catalog-item').find('.js-catalog-item-image');

                    // Заменяем его
                    changeImgSrc(
                        itemImg,
                        '30',
                        response.data.image_thumbs,
                    );
                }

                // Если это страница товара
                else {
                    // Меняем изображение в ссылке на fancybox
                    activeLink.attr('href', response.data.image_orig);

                    // Меняем изображение показыващееся при наведении на основное (лупа)
                    activeLink.find('.js-zoom-img')
                        .attr('style', 'background-image: url(' + response.data.image_orig + ')');

                    // Если у товара не одно изображение
                    if (secondarySlider.length) {
                        // Открываем первый слайд
                        firstSlide.click();

                        // меняем первое изображение товара в карусели миниатюр
                        changeImgSrc(
                            firstSlide.find('.js-img-preview'),
                            '30',
                            response.data.image_thumbs,
                        );

                        // Меняем первое изображение товара в основном слайдере
                        changeImgSrc(
                            activeLink.find('.js-product-img'),
                            '70',
                            response.data.image_thumbs,
                        );

                    } else {
                        // Меняем единственное изображение товара
                        changeImgSrc(
                            $('.js-product-img'),
                            '70',
                            response.data.image_thumbs,
                        );
                    }
                }
            }
        },
    });
}

// Минифункция меняющая src и srcset у тега img
function changeImgSrc(imgElem, size, thumbsArr) {
    imgElem.attr('src', thumbsArr[size])
        .attr('srcset', thumbsArr['2x' + size] + ' 2x');
}
