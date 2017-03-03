<style>
    .quantity-cart .actions{margin: 0;}
    .product-type{display: none; color: #bcbcbc;}
    .actions:hover .product-type{display: block;}
    .img-responsive{width: auto;margin: auto;}
</style>

<?php
echo isset($breadcrumb) ? $breadcrumb : "";
?>

<div class="container page-content">
    <div class="row">
        <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12 content-aside">
            <?php $this->load->view("pages/products/left-sidebar"); ?>
        </div>
        <div class="col-sm-8 col-md-9 col-lg-9 col-xs-12 content-center">
            <meta itemprop="url" content="<?php echo current_url(); ?>">
            <meta itemprop="image" content="<?php echo $product_data["product_image_url"]; ?>">
            <div class="row">
                <div class="product-img-box pb-left-column col-xs-12 col-sm-5 ">     	
                    <div class="product-photo-container" id="ProductPhoto">
                        <img class="img-responsive" id="ProductPhotoImg" src="<?php echo $product_data["product_image_url"]; ?>" data-zoom="<?php echo $product_data["product_image_url"]; ?>" data-image-id="<?php echo $product_data["product_unique_code"]; ?>">
                    </div>
                </div>

                <div class="product-shop pb-right-column col-xs-12 col-sm-7">
                    <div class="product-item">
                        <h1 class="product-title" itemprop="name" content="<?php echo stripslashes($product_data["product_title"]); ?>"><?php echo stripslashes($product_data["product_title"]); ?></h1>
                        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                            <meta itemprop="priceCurrency" content="INR">
                            <link itemprop="availability" href="http://schema.org/In Stock">
                            <div class="prices">              
                                <span id="ProductPrice" class="price money" itemprop="price" content="<?php echo number_format($product_data["product_price_min"], 2); ?>">Rs. <?php echo number_format($product_data["product_price_min"], 2); ?></span>
                            </div> 
                            <div class="short-description"><p><?php echo stripslashes($product_data["product_description"]); ?></p></div>
                            <div class="quantity-cart" style="min-height: 100px;">
                                <div class="actions">
                                    <a rel="nofollow" href="<?php echo $product_data["product_url_short"]; ?>" target="_blank" class="btn add-to-cart-btn cart-button lnr lnr-cart">Buy Now</a>
                                    <p class="product-type text-center"><small>from <?php echo ucwords($product_data["product_type"]); ?></small></p>
                                </div>
                            </div>    

                            <div class="clearfix">
                                <div class="actions">
                                    <!-- AddToAny BEGIN -->
                                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                        <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                                        <a class="a2a_button_facebook"></a>
                                        <a class="a2a_button_twitter"></a>
                                        <a class="a2a_button_google_plus"></a>
                                        <a class="a2a_button_whatsapp"></a>
                                    </div>
                                    <script async src="https://static.addtoany.com/menu/page.js"></script>
                                    <!-- AddToAny END -->
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>   
            </div>

            <div class="clearfix"><?php echo get_google_ad(); ?></div>

            <?php
            if (!empty($related_products))
            {
                ?>
                <div class="related-block section-products">
                    <div class="slider-products-title">
                        <h3 class="title"><span>RELATED PRODUCTS</span></h3>
                    </div>
                    <div class="related-carousel">
                        <?php
                        foreach ($related_products as $rvalue)
                        {
                            ?>
                            <div class="item">	
                                <div class="product-preview  clearfix">
                                    <div class="preview">
                                        <a href="<?php echo base_url("p/" . $rvalue["product_url_key"]); ?>" title="<?php echo stripslashes($rvalue["product_title"]); ?>">
                                            <img src="<?php echo $rvalue["product_image_url"]; ?>" alt="<?php echo stripslashes($rvalue["product_title"]); ?>" class="first-image img-responsive">
                                            <img src="<?php echo $rvalue["product_image_url"]; ?>" alt="<?php echo stripslashes($rvalue["product_title"]); ?>" class="second-img img-responsive" />
                                        </a>
                                        <div class="wrapper-label"></div>
                                    </div> 

                                    <div class="product-info clearfix">
                                        <a class="product-title" href="<?php echo base_url("p/" . $rvalue["product_url_key"]); ?>"><?php echo stripslashes($rvalue["product_title"]); ?></a>
                                        <div class="content_price">
                                            <span class="price"><span class="money">Rs. <?php echo number_format($rvalue["product_price_min"], 2); ?></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>    
                </div>

                <script type="text/javascript">
                    jQuery(function ($) {
                        "use strict";
                        var items = 4;
                        var productCarousel = $(".related-carousel");
                        if (productCarousel.length > 0)
                            productCarousel.each(function () {
                                var itemsDesktop = 4,
                                        itemsDesktopSmall = 3,
                                        itemsTablet = 2,
                                        itemsMobile = 1;
                                var rtl = false;
                                if ($("body").hasClass("rtl"))
                                    rtl = true;
                                if ($(".content-center").hasClass("center-sidebar"))
                                    itemsDesktop = 4,
                                            itemsDesktopSmall = 3,
                                            itemsTablet = 2,
                                            itemsMobile = 1;
                                $(this).owlCarousel({
                                    responsiveClass: true,
                                    responsive: {
                                        1440: {
                                            items: items
                                        },
                                        1200: {
                                            items: itemsDesktop
                                        },
                                        992: {
                                            items: itemsDesktopSmall
                                        },
                                        768: {
                                            items: itemsTablet
                                        },
                                        481: {
                                            items: itemsTablet
                                        },
                                        320: {
                                            items: 1
                                        }
                                    },
                                    rtl: rtl,
                                    autoPlay: false,
                                    nav: true,
                                    dots: false,
                                    pagination: false,
                                    rewindNav: true,
                                    navigationText: ["", ""],
                                    scrollPerPage: false,
                                    margin: 30,
                                    slideSpeed: 500
                                })
                            });
                    });
                </script>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<script src="<?php echo JS_PATH; ?>/jquery.zoom.min.js" type="text/javascript"></script>
<script type="text/javascript">
                $(document).ready(function () {
                    thumbnails = $('img[src*="/products/"]').not(':first');
                    if (thumbnails.size()) {
                        thumbnails.bind('click', function () {
                            var image = $(this).attr('src').split('?')[0].replace(/(_[0-9x]+\.)|(_\d+x\.)|(_thumb\.)|(_small\.)|(_compact\.)|(_medium\.)|(_large\.)|(_grande\.)/, '.');
                            if (typeof variantImages[image] !== 'undefined') {
                                productOptions.forEach(function (value, i) {
                                    optionValue = variantImages[image]['option-' + i];
                                    if (optionValue !== null && $('.single-option-selector:eq(' + i + ') option').filter(function () {
                                        return $(this).text() === optionValue
                                    }).length) {
                                        $('.single-option-selector:eq(' + i + ')').val(optionValue).trigger('change');
                                    }
                                });
                            }
                        });
                    }
                });

                jQuery(function ($) {
                    var productCarousel = $(".thumb-carousel");
                    if (productCarousel.length > 0)
                        productCarousel.each(function () {
                            var items = 4,
                                    itemsDesktop = 4,
                                    itemsDesktopSmall = 3,
                                    itemsTablet = 3,
                                    itemsMobile = 3;
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
                                    481: {
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
                                loop: true,
                                pagination: false,
                                rewindNav: true,
                                navigationText: ["", ""],
                                scrollPerPage: false,
                                margin: 10,
                                slideSpeed: 500
                            })
                        });

                    $('.img-thumb > a').click(function (event) {
                        $('#ProductPhotoImg').attr('src', $(this).attr('data-image'));

                        $('.img-thumb > a').removeClass('shown');
                        $(this).addClass('shown');

                        $('#ProductPhotoImg').attr('data-zoom', $(this).attr('data-image'));
//                                $('#ProductPhoto').zoom({
//                                    url: $(this).find('#ProductPhotoImg').attr('data-zoom')
//                                });

                        event.preventDefault();
                    });

//                            $('#ProductPhoto').zoom({
//                                url: $(this).find('#ProductPhotoImg').attr('data-zoom')
//                            });

                });
</script> 