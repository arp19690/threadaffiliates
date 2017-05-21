<div class="home-content">
    <?php
    // $this->load->view("pages/index/homepage/slider");

    if (!empty($featured_products))
    {
        ?>
        <div class="shopify-section">
            <section class="section-products new-products">
                <div class="container">
                    <div class="slider-products-title">
                        <h3 class="title">
                            <span>Featured</span>
                        </h3>
                    </div>
                    <div class="new-products-carousel coll-prod-carousel">
                        <?php
                        foreach ($featured_products as $value)
                        {
                            ?>
                            <div class="item">
                                <div class="product-preview clearfix">
                                    <div class="preview">
                                        <a href="<?php echo base_url("p/" . stripslashes($value["product_url_key"])); ?>">
                                            <img src="<?php echo $value['product_image_url']; ?>" data-original="<?php echo $value['product_image_url']; ?>" alt="<?php echo stripslashes($value["product_title"]); ?>" class=" img-responsive lazy">
                                        </a>
                                        <div class="wrapper-label <?php echo strtolower($value["product_type"]); ?>"><?php echo get_affiliate_name($value["product_type"]); ?></div>
                                    </div> 
                                    <div class="product-info clearfix">
                                        <a class="product-title" href="<?php echo base_url("p/" . stripslashes($value["product_url_key"])); ?>"><?php echo stripslashes($value["product_title"]); ?></a>
                                        <div class="content_price"><span class="price"><span class="money"><?php echo get_currency_symbol($value["product_currency"]) . number_format($value["product_price_min"], 2); ?></span></span></div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>
        <?php
    }
    ?>

    <div class="shopify-section">
        <div class="section-banners">
            <div class="container">
                <div class="row">
                    <div class="layout-column col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="addon-box">
                            <div class="jms-banner">
                                <img src="<?php echo IMAGES_PATH; ?>/banner1.jpg" data-original="<?php echo IMAGES_PATH; ?>/banner1.jpg" alt="Men" class="banner__image lazy" />
                                <div class="text">
                                    <div class="banner-heading" ><span>SHOP FOR</span></div>
                                    <div class="banner-subheading" ><h3>MEN</h3></div>
                                    <div class="banner-btn"><a href="<?php echo base_url("c/apparels/men"); ?>">SHOP NOW <span class="jmsf jmsf-arrows-right-2"></span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layout-column col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="addon-box">
                            <div class="jms-banner">
                                <img src="<?php echo IMAGES_PATH; ?>/banner2.jpg" data-original="<?php echo IMAGES_PATH; ?>/banner2.jpg" alt="Women" class="banner__image lazy" />
                                <div class="text">
                                    <div class="banner-heading" ><span>SHOP FOR</span></div>
                                    <div class="banner-subheading" ><h3>WOMEN</h3></div>
                                    <div class="banner-btn"><a href="<?php echo base_url("c/apparels/women"); ?>">SHOP NOW <span class="jmsf jmsf-arrows-right-2"></span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layout-column col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="addon-box">
                            <div class="jms-banner">
                                <img src="<?php echo IMAGES_PATH; ?>/banner3.jpg" data-original="<?php echo IMAGES_PATH; ?>/banner3.jpg" alt="Kids" class="banner__image lazy" />
                                <div class="text">
                                    <div class="banner-heading" ><span>SHOP FOR</span></div>
                                    <div class="banner-subheading" ><h3>KIDS</h3></div>
                                    <div class="banner-btn"><a href="<?php echo base_url("c/apparels/kids"); ?>">SHOP NOW <span class="jmsf jmsf-arrows-right-2"></span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="shopify-section">
        <div class="section-products productfilter-section">
            <div class="container">
                <div class="home-row row fullwidth">  
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12"> 
                        <div class="home-block">
                            <div class="block-content">
                                <div class="jms-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="active"><a href="#women-fashion" data-toggle="tab" class="button">Women Fashion</a></li>
                                    </ul>  
                                    <span class="small-star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                                </div> 
                                <div class="tab-content">
                                    <div id="women-fashion" class="tab-pane active" role="tabpanel">      
                                        <div class="product-tab-carousel">
                                            <?php
                                            foreach ($women_apparels_products as $value)
                                            {
                                                ?>
                                                <div class="item">
                                                    <div class="product-preview  clearfix">
                                                        <div class="preview">
                                                            <a href="<?php echo base_url("p/" . stripslashes($value["product_url_key"])); ?>">
                                                                <img src="<?php echo $value['product_image_url']; ?>" data-original="<?php echo $value['product_image_url']; ?>" alt="<?php echo stripslashes($value["product_title"]); ?>" class="first-image img-responsive lazy">
                                                                <img src="<?php echo $value['product_image_url']; ?>" data-original="<?php echo $value['product_image_url']; ?>" alt="<?php echo stripslashes($value["product_title"]); ?>" class="second-img img-responsive lazy" />
                                                            </a>
                                                            <div class="wrapper-label <?php echo strtolower($value["product_type"]); ?>"><?php echo get_affiliate_name($value["product_type"]); ?></div>
                                                        </div> 

                                                        <div class="product-info clearfix">
                                                            <a class="product-title" href="<?php echo base_url("p/" . stripslashes($value["product_url_key"])); ?>"><?php echo stripslashes($value["product_title"]); ?></a>
                                                            <div class="content_price"><span class="price"><span class="money"><?php echo get_currency_symbol($value["product_currency"]) . number_format($value["product_price_min"], 2); ?></span></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-products productfilter-section">
            <div class="container">
                <div class="home-row row fullwidth">  
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12"> 
                        <div class="home-block">
                            <div class="block-content">
                                <div class="jms-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="active"><a href="#smartphones" data-toggle="tab" class="button">Smartphones</a></li>
                                    </ul>  
                                    <span class="small-star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                                </div> 
                                <div class="tab-content">
                                    <div id="smartphones" class="tab-pane active" role="tabpanel">      
                                        <div class="product-tab-carousel">
                                            <?php
                                            foreach ($smartphone_products as $value)
                                            {
                                                ?>
                                                <div class="item">
                                                    <div class="product-preview  clearfix">
                                                        <div class="preview">
                                                            <a href="<?php echo base_url("p/" . stripslashes($value["product_url_key"])); ?>">
                                                                <img src="<?php echo $value['product_image_url']; ?>" data-original="<?php echo $value['product_image_url']; ?>" alt="<?php echo stripslashes($value["product_title"]); ?>" class="first-image img-responsive lazy">
                                                                <img src="<?php echo $value['product_image_url']; ?>" data-original="<?php echo $value['product_image_url']; ?>" alt="<?php echo stripslashes($value["product_title"]); ?>" class="second-img img-responsive lazy" />
                                                            </a>
                                                            <div class="wrapper-label <?php echo strtolower($value["product_type"]); ?>"><?php echo get_affiliate_name($value["product_type"]); ?></div>
                                                        </div> 

                                                        <div class="product-info clearfix">
                                                            <a class="product-title" href="<?php echo base_url("p/" . stripslashes($value["product_url_key"])); ?>"><?php echo stripslashes($value["product_title"]); ?></a>
                                                            <div class="content_price"><span class="price"><span class="money"><?php echo get_currency_symbol($value["product_currency"]) . number_format($value["product_price_min"], 2); ?></span></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-products productfilter-section">
            <div class="container">
                <div class="home-row row fullwidth">  
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12"> 
                        <div class="home-block">
                            <div class="block-content">
                                <div class="jms-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="active"><a href="#cameras" data-toggle="tab" class="button">Cameras</a></li>
                                    </ul>  
                                    <span class="small-star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                                </div> 
                                <div class="tab-content">
                                    <div id="cameras" class="tab-pane active" role="tabpanel">      
                                        <div class="product-tab-carousel">
                                            <?php
                                            foreach ($camera_products as $value)
                                            {
                                                ?>
                                                <div class="item">
                                                    <div class="product-preview  clearfix">
                                                        <div class="preview">
                                                            <a href="<?php echo base_url("p/" . stripslashes($value["product_url_key"])); ?>">
                                                                <img src="<?php echo $value['product_image_url']; ?>" data-original="<?php echo $value['product_image_url']; ?>" alt="<?php echo stripslashes($value["product_title"]); ?>" class="first-image img-responsive lazy">
                                                                <img src="<?php echo $value['product_image_url']; ?>" data-original="<?php echo $value['product_image_url']; ?>" alt="<?php echo stripslashes($value["product_title"]); ?>" class="second-img img-responsive lazy" />
                                                            </a>
                                                            <div class="wrapper-label <?php echo strtolower($value["product_type"]); ?>"><?php echo get_affiliate_name($value["product_type"]); ?></div>
                                                        </div> 

                                                        <div class="product-info clearfix">
                                                            <a class="product-title" href="<?php echo base_url("p/" . stripslashes($value["product_url_key"])); ?>"><?php echo stripslashes($value["product_title"]); ?></a>
                                                            <div class="content_price"><span class="price"><span class="money"><?php echo get_currency_symbol($value["product_currency"]) . number_format($value["product_price_min"], 2); ?></span></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-products productfilter-section">
            <div class="container">
                <div class="home-row row fullwidth">  
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12"> 
                        <div class="home-block">
                            <div class="block-content">
                                <div class="jms-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="active"><a href="#home-decor" data-toggle="tab" class="button">Home Decor</a></li>
                                    </ul>  
                                    <span class="small-star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                                </div> 
                                <div class="tab-content">
                                    <div id="home-decor" class="tab-pane active" role="tabpanel">      
                                        <div class="product-tab-carousel">
                                            <?php
                                            foreach ($home_decor_products as $value)
                                            {
                                                ?>
                                                <div class="item">
                                                    <div class="product-preview  clearfix">
                                                        <div class="preview">
                                                            <a href="<?php echo base_url("p/" . stripslashes($value["product_url_key"])); ?>">
                                                                <img src="<?php echo $value['product_image_url']; ?>" data-original="<?php echo $value['product_image_url']; ?>" alt="<?php echo stripslashes($value["product_title"]); ?>" class="first-image img-responsive lazy">
                                                                <img src="<?php echo $value['product_image_url']; ?>" data-original="<?php echo $value['product_image_url']; ?>" alt="<?php echo stripslashes($value["product_title"]); ?>" class="second-img img-responsive lazy" />
                                                            </a>
                                                            <div class="wrapper-label <?php echo strtolower($value["product_type"]); ?>"><?php echo get_affiliate_name($value["product_type"]); ?></div>
                                                        </div> 

                                                        <div class="product-info clearfix">
                                                            <a class="product-title" href="<?php echo base_url("p/" . stripslashes($value["product_url_key"])); ?>"><?php echo stripslashes($value["product_title"]); ?></a>
                                                            <div class="content_price"><span class="price"><span class="money"><?php echo get_currency_symbol($value["product_currency"]) . number_format($value["product_price_min"], 2); ?></span></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(function ($) {
        "use strict";
        var productCarousel = $(".coll-prod-carousel, .product-tab-carousel");
        if (productCarousel.length > 0)
            productCarousel.each(function () {
                var items = 5,
                        itemsDesktop = 4,
                        itemsDesktopSmall = 3,
                        itemsTablet = 2,
                        itemsMobile = 1;
                var rtl = false;
                if ($("body").hasClass("rtl"))
                    rtl = true;
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
                    loop: true,
                    rewindNav: true,
                    navigationText: ["", ""],
                    scrollPerPage: false,
                    slideSpeed: 500,
                    margin: 30
                })
            });
    });
</script>