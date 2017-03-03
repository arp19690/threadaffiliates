jQuery(function ($) {
    "use strict";
    if ($(".products-widget").length > 0) {
        $(".products-widget").jcarousel({
            vertical: true,
            items: 'ul.slides li',
            scroll: 3,
            buttonNextHTML: '<a></a>',
            buttonPrevHTML: '<a></a>'
        });
    }
});
function viewAs() {
    var viewGrid = $(".view-grid"),
            viewList = $(".view-list"),
            productList = $("#products-list");
    viewGrid.click(function (e) {
        productList.removeClass("list-mode");
        productList.addClass("grid-mode");
        $(this).addClass('active');
        viewList.removeClass("active");
        e.preventDefault();
    });

    viewList.click(function (e) {
        productList.removeClass("grid-mode");
        productList.addClass("list-mode");
        viewGrid.removeClass("active");
        $(this).addClass('active');
        e.preventDefault();
    })
}
jQuery(function ($) {
    "use strict";
    viewAs();
});
function showLoading() {
    $('.loading-modal').show();
}
function hideLoading() {
    $('.loading-modal').hide();
}
function AjaxAddToCart(variant_id, quantity, title, image) {
    $.ajax({
        type: "post",
        url: "/cart/add.js",
        data: 'quantity=' + quantity + '&id=' + variant_id,
        dataType: 'json',
        beforeSend: function () {
            showLoading();
        },
        success: function (msg) {
            hideLoading();
            $('.ajax-success-modal').find('.ajax-product-title').html(title);
            $('.ajax-success-modal').find('.ajax-product-image').attr('src', image);
            $('.ajax-success-modal').find('.btn-go-to-wishlist').hide();
            $('.ajax-success-modal').find('.btn-go-to-cart').show();
            showModal('.ajax-success-modal');
            updateDropdownCart();
        },
        error: function (xhr, text) {
            hideLoading();
            $('.ajax-error-message').text($.parseJSON(xhr.responseText).description);
            showModal('.ajax-error-modal');
        }
    });
}
function checkItemsInDropdownCart() {
    if ($('.shoppingcart-box .cart-products').children().length > 0) {
        //Has item in dropdown cart
        $('.shoppingcart-box .no-items').hide();
        $('.shoppingcart-box .has-items').show();
    } else {
        //No item in dropdown cart                
        $('.shoppingcart-box .has-items').hide();
        $('.shoppingcart-box .no-items').show();
    }
}
function doUpdateDropdownCart(cart) {
    var template = '<li class="item" id="cart-item-{ID}"><a href="{URL}" title="{TITLE}" class="product-image"><img src="{IMAGE}" alt="{TITLE}"></a><div class="product-details"><p class="product-name"><a href="{URL}">{TITLE}</a></p><div class="cart-collateral"><span class="price cart-collateral__price">{PRICE}</span> <span class="cart-collateral__qty pull-right">x{QUANTITY}</span></div><a href="javascript:void(0)" title="Remove This Item" class="btn-remove"><i class="jmsf jmsf-arrows-remove-1"></i></a></div></li>';
    $('.ajax_cart_quantity').text(cart.item_count);
    $('.shoppingcart-box .summary .price').html(Shopify.formatMoney(cart.total_price, window.money_format));
    $('#cart_block .cartinfo .total').html(Shopify.formatMoney(cart.total_price, window.money_format));
    $('.shoppingcart-box .cart-products').html('');
    if (cart.item_count > 0) {
        for (var i = 0; i < cart.items.length; i++) {
            var item = template;
            item = item.replace(/\{ID\}/g, cart.items[i].id);
            item = item.replace(/\{URL\}/g, cart.items[i].url);
            item = item.replace(/\{TITLE\}/g, cart.items[i].title);
            item = item.replace(/\{QUANTITY\}/g, cart.items[i].quantity);
            item = item.replace(/\{IMAGE\}/g, Shopify.resizeImage(cart.items[i].image, 'small'));
            item = item.replace(/\{PRICE\}/g, Shopify.formatMoney(cart.items[i].price, window.money_format));
            $('.shoppingcart-box .cart-products').append(item);
        }
        $('.shoppingcart-box .btn-remove').click(function (event) {
            event.preventDefault();
            var productId = $(this).parents('.item').attr('id');
            productId = productId.match(/\d+/g);
            Shopify.removeItem(productId, function (cart) {
                doUpdateDropdownCart(cart);
            });
            return false;
        });
    }
    checkItemsInDropdownCart();
}
function updateDropdownCart() {
    Shopify.getCart(function (cart) {
        doUpdateDropdownCart(cart);
    });
}
function showModal(selector) {
    $(selector).fadeIn(500)
    setTimeout(function () {
        $(selector).fadeOut(500);
    }, 3000);
}
function updatePricingQuickview() {
    //try pattern one before pattern 2
    var regex = /([0-9]+[.|,][0-9]+[.|,][0-9]+)/g;
    var unitPriceTextMatch = $('.quickview-box .price').text().match(regex);
    if (!unitPriceTextMatch) {
        regex = /([0-9]+[.|,][0-9]+)/g;
        unitPriceTextMatch = $('.quickview-box .price').text().match(regex);
    }
    if (unitPriceTextMatch) {
        var unitPriceText = unitPriceTextMatch[0];
        var unitPrice = unitPriceText.replace(/[.|,]/g, '');
        var quantity = parseInt($('.quickview-box input[name=quantity]').val());
        var totalPrice = unitPrice * quantity;
        var totalPriceText = Shopify.formatMoney(totalPrice, window.money_format);
        regex = /([0-9]+[.|,][0-9]+[.|,][0-9]+)/g;
        if (!totalPriceText.match(regex)) {
            regex = /([0-9]+[.|,][0-9]+)/g;
        }
        totalPriceText = totalPriceText.match(regex)[0];
        var regInput = new RegExp(unitPriceText, "g");
        var totalPriceHtml = $('.quickview-box .price').html().replace(regInput, totalPriceText);
        $('.quickview-box .total-price span').html(totalPriceHtml);
    }
}
function updatePricing() {
    //try pattern one before pattern 2
    var regex = /([0-9]+[.|,][0-9]+[.|,][0-9]+)/g;
    var unitPriceTextMatch = $('.product-shop .price').text().match(regex);
    if (!unitPriceTextMatch) {
        regex = /([0-9]+[.|,][0-9]+)/g;
        unitPriceTextMatch = $('.product-shop .price').text().match(regex);
    }
    if (unitPriceTextMatch) {
        var unitPriceText = unitPriceTextMatch[0];
        var unitPrice = unitPriceText.replace(/[.|,]/g, '');
        var quantity = parseInt($('.product-shop input[name=quantity]').val());
        var totalPrice = unitPrice * quantity;
        var totalPriceText = Shopify.formatMoney(totalPrice, window.money_format);
        regex = /([0-9]+[.|,][0-9]+[.|,][0-9]+)/g;
        if (!totalPriceText.match(regex)) {
            regex = /([0-9]+[.|,][0-9]+)/g;
        }
        totalPriceText = totalPriceText.match(regex)[0];
        var regInput = new RegExp(unitPriceText, "g");
        var totalPriceHtml = $('.product-shop .price').html().replace(regInput, totalPriceText);
        $('.product-shop .total-price span').html(totalPriceHtml);
    }
}
function createQuickViewVariants(product, quickviewTemplate) {
    if (product.variants.length > 1) { //multiple variants
        for (var i = 0; i < product.variants.length; i++) {
            var variant = product.variants[i];
            var option = '<option value="' + variant.id + '">' + variant.title + '</option>';
            quickviewTemplate.find('form.variants > select').append(option);
        }
        new Shopify.OptionSelectors("product-select-" + product.id, {
            product: product,
            onVariantSelected: selectCallbackQuickview
        });
        if (product.options.length == 1) {
            $('.selector-wrapper:eq(0)').prepend('<label>' + product.options[0].name + '</label>');
            for (var text = product.variants, r = 0; r < text.length; r++) {
                var s = text[r];
                if (!s.available) {
                    jQuery('.single-option-selector option').filter(function () {
                        return jQuery(this).html() === s.title
                    }).remove();
                }
            }
            ;
        }
        $('.quickview-box .selectize-input input').attr("disabled", "disabled");
        quickviewTemplate.find('form.variants .selector-wrapper label').each(function (i, v) {
            $(this).html(product.options[i].name);
        });
    } else {
        quickviewTemplate.find('form.variants > select').remove();
        var variant_field = '<input type="hidden" name="id" value="' + product.variants[0].id + '">';
        quickviewTemplate.find('form.variants').append(variant_field);
    }
}
function convertToSlug(text) {
    return text
            .toLowerCase()
            .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
}
function createQuickViewVariantsSwatch(product, quickviewTemplate) {
    if (product.variants.length > 1) { //multiple variants
        for (var i = 0; i < product.variants.length; i++) {
            var variant = product.variants[i];
            var option = '<option value="' + variant.id + '">' + variant.title + '</option>';
            quickviewTemplate.find('form.variants > select').append(option);
        }
        new Shopify.OptionSelectors("product-select-" + product.id, {
            product: product,
            onVariantSelected: selectCallbackQuickview
        });
        //start of quickview variant;
        var assetUrl = window.asset_url.substring(0, window.asset_url.lastIndexOf('mark.jpg'));
        var options = "";
        for (var i = 0; i < product.options.length; i++) {
            options += '<div class="swatch clearfix" data-option-index="' + i + '">';
            options += '<div class="header">' + product.options[i].name + '</div>';
            var is_color = false;
            if (/Color|Colour/i.test(product.options[i].name)) {
                is_color = true;
            }
            var optionValues = new Array();
            for (var j = 0; j < product.variants.length; j++) {
                var variant = product.variants[j];
                var value = variant.options[i];
                var valueHandle = convertToSlug(value);
                var forText = 'swatch-' + i + '-' + valueHandle;
                if (optionValues.indexOf(value) < 0) {
                    //not yet inserted
                    options += '<div data-value="' + value + '" class="swatch-element ' + (is_color ? "color color-" : "") + valueHandle + (variant.available ? ' available ' : ' soldout ') + (j == 0 ? ' color-active ' : '') + '">';
                    if (is_color) {

                        options += '<div class="tooltip">' + value + '</div>';
                    }
                    options += '<input id="' + forText + '" type="radio" name="option-' + i + '" value="' + value + '" ' + (j == 0 ? ' checked ' : '') + (variant.available ? '' : ' disabled') + ' />';

                    if (is_color) {
                        options += '<label for="' + forText + '" style="background-color: ' + valueHandle + '; background-image: url(' + assetUrl + valueHandle + '.jpg)"><img class="crossed-out" src="' + assetUrl + 'soldout.png" /></label>';

                    } else {
                        options += '<label for="' + forText + '">' + value + '<img class="crossed-out" src="' + assetUrl + 'soldout.png" /></label>';
                    }
                    options += '</div>';
                    if (variant.available) {
                        $('.quick-view .swatch[data-option-index="' + i + '"] .' + valueHandle).removeClass('soldout').addClass('available').find(':radio').removeAttr('disabled');
                    }
                    optionValues.push(value);
                }
            }
            options += '</div>';
        }
        quickviewTemplate.find('form.variants > select').after(options);
        quickviewTemplate.find('.swatch :radio').change(function () {
            var optionIndex = $(this).closest('.swatch').attr('data-option-index');
            var optionValue = $(this).val();
            $(this)
                    .closest('form')
                    .find('.single-option-selector')
                    .eq(optionIndex)
                    .val(optionValue)
                    .trigger('change');
        });
        if (product.available) {
            Shopify.optionsMap = {};
            Shopify.linkOptionSelectors(product);
        }
        //end of quickview variant
    } else { //single variant
        quickviewTemplate.find('form.variants > select').remove();
        var variant_field = '<input type="hidden" name="id" value="' + product.variants[0].id + '">';
        quickviewTemplate.find('form.variants').append(variant_field);
    }
}
function loadQuickViewSlider(product, quickviewTemplate) {
    var featuredImage = Shopify.resizeImage(product.featured_image, 'grande');
    quickviewTemplate.find('.quickview-featured-image').append('<a href="' + product.url + '"><img class="img-responsive" src="' + featuredImage + '" title="' + product.title + '"/><div style="height: 100%; width: 100%; top:0; left:0 z-index: 2000; position: absolute; display: none; background: url(' + window.loading_url + ') 50% 50% no-repeat;"></div></a>');
    if (product.images.length > 1) {
        var quickViewCarousel = quickviewTemplate.find('.thumb-carousel');
        var count = 0;
        for (i in product.images) {
            if (count < product.images.length) {
                var grande = Shopify.resizeImage(product.images[i], 'grande');
                var compact = Shopify.resizeImage(product.images[i], 'compact');
                var item = '<div class="img-thumb"><a href="javascript:void(0)" data-image="' + grande + '"><img class="img-responsive" src="' + compact + '"  /></a></div>'
                quickViewCarousel.append(item);
                count = count + 1;
            }
        }
        quickViewCarousel.find('a').click(function () {
            var quickViewFeatureImage = quickviewTemplate.find('.quickview-featured-image img');
            var quickViewFeatureLoading = quickviewTemplate.find('.quickview-featured-image div');
            if (quickViewFeatureImage.attr('src') != $(this).attr('data-image')) {
                quickViewFeatureImage.attr('src', $(this).attr('data-image'));
                quickViewFeatureLoading.show();
                quickViewFeatureImage.load(function (e) {
                    quickViewFeatureLoading.hide();
                    $(this).unbind('load');
                    quickViewFeatureLoading.hide();
                });
            }
        });

    }
}

function initQuickview() {
    $('.quick-view').click(function () {
        var product_handle = $(this).attr('data-id');
        Shopify.getProduct(product_handle, function (product) {
            var template = $('#quickview-tpl').html();
            $('.quickview-box').html(template);
            var quickview = $('.quickview-box');
            quickview.find('.product-title a').html(product.title);
            quickview.find('.product-title a').attr('href', product.url);
            if (quickview.find('.product-vendor span').length > 0) {
                quickview.find('.product-vendor span').text(product.vendor);
            }
            if (quickview.find('.product-type span').length > 0) {
                quickview.find('.product-type span').text(product.type);
            }
            if (quickview.find('.product-inventory span').length > 0) {
                var variant = product.variants[0];
                var inventoryInfo = quickview.find('.product-inventory span');
                if (variant.available) {
                    if (variant.inventory_management != null) {
                        inventoryInfo.text(variant.inventory_quantity + " " + window.inventory_text.in_stock);
                    } else {
                        inventoryInfo.text(window.inventory_text.many_in_stock);
                    }
                } else {
                    inventoryInfo.text(window.inventory_text.out_of_stock);
                }
            }
            //countdown for quickview
            if (product.description.indexOf("[countdown]") > 0) {
                var countdownTime = product.description.match(/\[countdown\](.*)\[\/countdown\]/);
                if (countdownTime && countdownTime.length > 0) {
                    quickview.find(".countdown").show();
                    quickview.find(".quickview-clock").countdown(countdownTime[1], function (event) {
                        $(this).html(event.strftime('%Dd %H:%M:%S'));
                    });
                }
            }

            if (quickview.find('.product-description').length > 0) {
                var description = product.description.replace(/(<([^>]+)>)/ig, "");
                var description = description.replace(/\[countdown\](.*)\[\/countdown\]/g, "");
                description = description.split(" ").splice(0, 20).join(" ") + "...";
                quickview.find('.product-description').text(description);
            } else {
                quickview.find('.product-description').remove();
            }
            quickview.find('.price').html(Shopify.formatMoney(product.price, window.money_format));
            quickview.find('.product-item').attr('id', 'product-' + product.id);
            quickview.find('.variants').attr('id', 'product-actions-' + product.id);
            quickview.find('.variants select').attr('id', 'product-select-' + product.id);

            //if has compare price
            if (product.compare_at_price > product.price) {
                quickview.find('.compare-price').html(Shopify.formatMoney(product.compare_at_price_max, window.money_format)).show();
                quickview.find('.price').addClass('on-sale');
            } else {
                quickview.find('.compare-price').html('');
                quickview.find('.price').removeClass('on-sale');
            }

            //out of stock
            if (!product.available) {
                quickview.find("select, input, .total-price, .dec, .inc, .variants label").remove();
                quickview.find(".add-to-cart-btn").text(window.inventory_text.unavailable).addClass('disabled').attr("disabled", "disabled");
                ;
            } else {
                quickview.find('.total-price span').html(Shopify.formatMoney(product.price, window.money_format));
                if (window.use_color_swatch) {
                    createQuickViewVariantsSwatch(product, quickview);
                } else {
                    createQuickViewVariants(product, quickview);
                }
            }

            //quantity
            quickview.find(".button").on("click", function () {
                var oldValue = quickview.find(".quantity").val(),
                        newVal = 1;
                if ($(this).text() == "+") {
                    newVal = parseInt(oldValue) + 1;
                } else if (oldValue > 1) {
                    newVal = parseInt(oldValue) - 1;
                }
                quickview.find(".quantity").val(newVal);
                if (quickview.find(".total-price").length > 0) {
                    updatePricingQuickview();
                }
            });
            if (window.enable_multiple_currencies) {
                Currency.convertAll(window.shop_currency, jQuery(".selected-currency").html(), 'span.money', 'money_format');
            }
            loadQuickViewSlider(product, quickview);
            // init add to cart 
            if ($('.quickview-box .add-to-cart-btn').length > 0) {
                $('.quickview-box .add-to-cart-btn').click(function () {
                    var variant_id = $('.quickview-box select[name=id]').val();
                    if (!variant_id) {
                        variant_id = $('.quickview-box input[name=id]').val();
                    }
                    var quantity = $('.quickview-box input[name=quantity]').val();
                    if (!quantity) {
                        quantity = 1;
                    }
                    var title = $('.quickview-box a.product-title').html();
                    var image = $('.quickview-box .quickview-featured-image img').attr('src');
                    AjaxAddToCart(variant_id, quantity, title, image);
                    $('.quickview-box').fadeOut(500);
                });
            }
            $('.quickview-box').fadeIn(500);
            if ($('.quickview-box .total-price').length > 0) {
                $('.quickview-box input[name=quantity]').on('change', updatePricingQuickview);
            }
            quickview.find('.thumb-carousel').owlCarousel({
                items: 3,
                dots: false,
                nav: true,
                rewindNav: true
            })
        });
        return false;
    });
    $('.quickview-box .overlay, .close-window').click(function () {
        $('.quickview-box').fadeOut(500);
        return false;
    });
}
function initAddToCart() {
    $('.ajax_add_to_cart_button').click(function (event) {
        event.preventDefault();
        var productId = $(this).attr('data-productid');
        var productwrap = $(this).parents('.product-preview');
        var variant_id = $(productwrap).find('.product-actions-' + productId + ' select[name=id]').val();
        if (!variant_id) {
            variant_id = $(productwrap).find('.product-actions-' + productId + ' input[name=id]').val();
        }
        var quantity = $(productwrap).find('.product-actions-' + productId + ' input[name=quantity]').val();
        if (!quantity) {
            quantity = 1;
        }
        if (variant_id) {
            var title = $(productwrap).find('.product-title').html();
            var image = $(productwrap).find('.preview img').attr('src');
            AjaxAddToCart(variant_id, quantity, title, image);
        } else {
            var btn = $(productwrap).find('.product-actions-' + productId + ' input[class="btn"]');
            btn.click();
        }
        return false;
    });
}
jQuery(function ($) {
    "use strict";
    $('.continue-shopping').click(function () {
        $('.ajax-success-modal').fadeOut(500);
    });
    $('.close-modal, .overlay').click(function () {
        $('.ajax-success-modal').fadeOut(500);
    });
    $('.shoppingcart-box .btn-remove').click(function (event) {
        event.preventDefault();
        var productId = $(this).parents('.item').attr('id');
        productId = productId.match(/\d+/g);
        Shopify.removeItem(productId, function (cart) {
            doUpdateDropdownCart(cart);
        });
        return false;
    });
    $('.search-bar input').click(function () {
        return false;
    });
    //quantity
    $(".quantity-cart .button").on("click", function () {
        var oldValue = $(".quantity-cart .quantity").val(),
                newVal = 1;
        if ($(this).text() == "+") {
            newVal = parseInt(oldValue) + 1;
        } else if (oldValue > 1) {
            newVal = parseInt(oldValue) - 1;
        }
        $(".quantity-cart .quantity").val(newVal);
        if ($(".product-shop .total-price").length > 0) {
            updatePricing();
        }
    });
    $('.add-to-cart-btn').click(function (event) {
        event.preventDefault();
        var productId = $(this).attr('data-productid');
        var variant_id = $('#product-actions-' + productId + ' select[name=id]').val();
        if (!variant_id) {
            variant_id = $('#product-actions-' + productId + ' input[name=id]').val();
        }
        var quantity = $('#product-actions-' + productId + ' input[name=quantity]').val();
        if (!quantity) {
            quantity = 1;
        }
        if (variant_id) {
            var title = $('.product-shop .product-title').html();
            var image = $('#ProductPhoto img').attr('src');
            AjaxAddToCart(variant_id, quantity, title, image);
        } else {
            var btn = $('#product-actions-' + productId + ' input[class="btn"]');
            btn.click();
        }
        return false;
    });
});
$(window).load(function () {
    checkItemsInDropdownCart();
    initQuickview();
    initAddToCart();
    if (window.enable_multiple_currencies && window.shop_currency != jQuery(".selected-currency").html()) {
        Currency.convertAll(window.shop_currency, jQuery(".selected-currency").html(), 'span.money', 'money_format');
    }
});
$(document).on('click', '.overlay, .close-window', function () {
    $('.quickview-box').fadeOut(500);
    return false;
});
$('.swatch :radio').change(function () {
    var optionIndex = $(this).closest('.swatch').attr('data-option-index');
    var optionValue = $(this).val();
    $(this)
            .closest('form')
            .find('.single-option-selector')
            .eq(optionIndex)
            .val(optionValue)
            .trigger('change');
});

// (c) Copyright 2014 Caroline Schnapp. All Rights Reserved. Contact: mllegeorgesand@gmail.com
// See http://docs.shopify.com/manual/configuration/store-customization/advanced-navigation/linked-product-options

Shopify.optionsMap = {};

Shopify.updateOptionsInSelector = function (selectorIndex) {

    switch (selectorIndex) {
        case 0:
            var key = 'root';
            var selector = $('.single-option-selector:eq(0)');
            break;
        case 1:
            var key = $('.single-option-selector:eq(0)').val();
            var selector = $('.single-option-selector:eq(1)');
            break;
        case 2:
            var key = $('.single-option-selector:eq(0)').val();
            key += ' / ' + $('.single-option-selector:eq(1)').val();
            var selector = $('.single-option-selector:eq(2)');
    }

    var initialValue = selector.val();
    selector.empty();
    var availableOptions = Shopify.optionsMap[key];
    if (availableOptions && availableOptions.length) {
        for (var i = 0; i < availableOptions.length; i++) {
            var option = availableOptions[i];
            var newOption = $('<option></option>').val(option).html(option);
            selector.append(newOption);
        }
        $('.swatch[data-option-index="' + selectorIndex + '"] .swatch-element').each(function () {
            if ($.inArray($(this).attr('data-value'), availableOptions) !== -1) {
                $(this).removeClass('soldout').show().find(':radio').removeAttr('disabled', 'disabled').removeAttr('checked');
            } else {
                $(this).addClass('soldout').hide().find(':radio').removeAttr('checked').attr('disabled', 'disabled');
            }
        });
        if ($.inArray(initialValue, availableOptions) !== -1) {
            selector.val(initialValue);
        }
        selector.trigger('change');
    }
};

Shopify.linkOptionSelectors = function (product) {
    // Building our mapping object.
    for (var i = 0; i < product.variants.length; i++) {
        var variant = product.variants[i];
        if (variant.available) {
            // Gathering values for the 1st drop-down.
            Shopify.optionsMap['root'] = Shopify.optionsMap['root'] || [];
            Shopify.optionsMap['root'].push(variant.option1);
            Shopify.optionsMap['root'] = Shopify.uniq(Shopify.optionsMap['root']);
            // Gathering values for the 2nd drop-down.
            if (product.options.length > 1) {
                var key = variant.option1;
                Shopify.optionsMap[key] = Shopify.optionsMap[key] || [];
                Shopify.optionsMap[key].push(variant.option2);
                Shopify.optionsMap[key] = Shopify.uniq(Shopify.optionsMap[key]);
            }
            // Gathering values for the 3rd drop-down.
            if (product.options.length === 3) {
                var key = variant.option1 + ' / ' + variant.option2;
                Shopify.optionsMap[key] = Shopify.optionsMap[key] || [];
                Shopify.optionsMap[key].push(variant.option3);
                Shopify.optionsMap[key] = Shopify.uniq(Shopify.optionsMap[key]);
            }
        }
    }
    // Update options right away.
    Shopify.updateOptionsInSelector(0);
    if (product.options.length > 1)
        Shopify.updateOptionsInSelector(1);
    if (product.options.length === 3)
        Shopify.updateOptionsInSelector(2);
    // When there is an update in the first dropdown.
    $(".single-option-selector:eq(0)").change(function () {
        Shopify.updateOptionsInSelector(1);
        if (product.options.length === 3)
            Shopify.updateOptionsInSelector(2);
        return true;
    });
    // When there is an update in the second dropdown.
    $(".single-option-selector:eq(1)").change(function () {
        if (product.options.length === 3)
            Shopify.updateOptionsInSelector(2);
        return true;
    });

};

jQuery(function ($) {
    "use strict";
    var productCarousel = $(".about-carousel");
    if (productCarousel.length > 0)
        productCarousel.each(function () {
            var items = 1,
                    itemsDesktop = 1,
                    itemsDesktopSmall = 1,
                    itemsTablet = 1,
                    itemsMobile = 1;
            var rtl = false;
            if ($("body").hasClass("rtl"))
                rtl = true;
            $(this).owlCarousel({
                responsiveClass: true,
                responsive: {
                    1550: {
                        items: items
                    },
                    1199: {
                        items: itemsDesktop
                    },
                    991: {
                        items: itemsDesktopSmall
                    },
                    767: {
                        items: itemsTablet
                    },
                    318: {
                        items: itemsMobile
                    }
                },
                rtl: rtl,
                autoPlay: false,
                nav: true,
                dots: false,
                pagination: false
            })
        });
});
