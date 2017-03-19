<style>
    .quantity-cart .actions{margin: 0;}
    .product-type{display: none; color: #bcbcbc;}
    .actions:hover .product-type{display: block;}
    .img-responsive{width: auto;margin: auto;}
    .add-to-cart-btn{color: #000000;}
    .g-ad{margin-top: 40px;}
    .slides>li>a>img{border: 1px solid #f4f2f2;}
    .quantity-cart .actions{float: none;}
    .quantity-cart .actions > a{min-width: 170px;}
    .quantity-cart .actions:first-of-type{margin-bottom: 10px;}
    .quantity-cart{min-height: 150px;}
    .content-aside{padding-right: 45px;}
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
                <div class="product-img-box nosidebar-page col-xs-12 col-sm-6 col-md-6 col-lg-6 clearfix">  
                    <div class="more-view-wrapper thumb-widget"> 
                        <div class="bx-wrapper">
                            <div class="bx-viewport">
                                <ul class="slides" id="ProductThumbs">
                                    <?php
                                    $i = 1;
                                    $images_arr = array_unique(json_decode($product_data["product_images_json"]));
                                    foreach ($images_arr as $imgval)
                                    {
                                        ?>
                                        <li class="img-thumb thumb_products bx-clone">
                                            <a data-image-id="<?php echo $product_data["product_unique_code"] . "-" . $i; ?>" data-image="<?php echo $imgval; ?>" href="<?php echo $imgval; ?>" class="product-thumb-img lazy" rel="product-gallery">
                                                <img class="img-responsive" src="<?php echo $imgval; ?>" alt="<?php echo stripslashes($product_data["product_title"]); ?>">
                                            </a>
                                        </li>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>  	
                    </div>

                    <div class="product-photo-container" id="ProductPhoto">
                        <img class="img-responsive lazy" id="ProductPhotoImg" src="<?php echo $product_data["product_image_url"]; ?>" data-original="<?php echo $product_data["product_image_url"]; ?>" data-zoom="<?php echo $product_data["product_image_url"]; ?>" data-image-id="<?php echo $product_data["product_unique_code"]; ?>" alt="<?php echo stripslashes($product_data["product_title"]); ?>">
                    </div>
                </div>

                <div class="product-shop pb-right-column col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="product-item">
                        <h1 class="product-title" itemprop="name" content="<?php echo stripslashes($product_data["product_title"]); ?>"><?php echo stripslashes($product_data["product_title"]); ?></h1>
                        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                            <meta itemprop="priceCurrency" content="INR">
                            <link itemprop="availability" href="http://schema.org/In Stock">
                            <div class="prices">              
                                <span id="ProductPrice" class="price money" itemprop="price" content="<?php echo number_format($product_data["product_price_min"], 2); ?>">Rs. <?php echo number_format($product_data["product_price_min"], 2); ?></span>
                            </div> 
                            <div class="short-description"><p><?php echo stripslashes($product_data["product_description"]); ?></p></div>
                            <div class="quantity-cart">
                                <div class="actions">
                                    <a rel="nofollow" href="<?php echo base_url("buy-now/" . $product_data["product_url_key"]); ?>" target="_blank" class="btn add-to-cart-btn cart-button">View Details</a>
                                </div>
                                <br/>
                                <div class="actions">
                                    <a rel="nofollow" href="<?php echo base_url("buy-now/" . $product_data["product_url_key"]); ?>" target="_blank" class="btn add-to-cart-btn cart-button">Add to cart</a>
                                    <p class="product-type text-center"><small>on <?php echo ucwords($product_data["product_type"]); ?></small></p>
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

            <div class="clearfix g-ad"><?php echo get_google_ad(); ?></div>

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
                                            <img src="<?php echo $rvalue["product_image_url"]; ?>" data-original="<?php echo $rvalue["product_image_url"]; ?>" alt="<?php echo stripslashes($rvalue["product_title"]); ?>" class="first-image img-responsive lazy">
                                            <img src="<?php echo $rvalue["product_image_url"]; ?>" data-original="<?php echo $rvalue["product_image_url"]; ?>" alt="<?php echo stripslashes($rvalue["product_title"]); ?>" class="second-img img-responsive lazy" />
                                        </a>
                                        <div class="wrapper-label <?php echo strtolower($rvalue["product_type"]); ?>"><?php echo ucwords($rvalue["product_type"]); ?></div>
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
                jQuery(function ($) {
                    var num_slides = 3;
                    if ($(window).width() <= 1199)
                        num_slides = 3;
                    if ($(window).width() <= 991)
                        num_slides = 3;
                    if ($(window).width() <= 768)
                        num_slides = 3;
                    if ($(window).width() <= 480)
                        num_slides = 2;
                    if ($(window).width() <= 400)
                        num_slides = 1;
                    $('.thumb-widget .slides').bxSlider({
                        mode: 'vertical',
                        minSlides: num_slides,
                        maxSlides: num_slides,
                        pager: false,
                        controls: true,
                        slideMargin: 10
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

<?php
if (USER_IP != "127.0.0.1" && !isset($this->session->userdata["admin_id"]))
{
// Updating product views counter
    $autorun_helper = new AutorunHelper();
    $autorun_helper->store_product_views($product_data["product_id"]);
}
