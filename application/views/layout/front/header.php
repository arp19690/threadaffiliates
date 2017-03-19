<?php
if (!isset($meta_title))
    $meta_title = SITE_TITLE;

if (!isset($meta_keywords))
    $meta_keywords = SEO_KEYWORDS;

if (!isset($meta_description))
    $meta_description = SEO_DESCRIPTION;

if (!isset($meta_logo_image))
{
    $meta_logo_image = IMAGES_PATH . "/logo-name.png";
    $og_image_arr = array(
        IMAGES_PATH . "/og-images/og-image1.jpg",
        IMAGES_PATH . "/og-images/og-image2.jpg",
        IMAGES_PATH . "/og-images/og-image3.jpg",
        IMAGES_PATH . "/og-images/og-image4.jpg",
        IMAGES_PATH . "/og-images/og-image5.jpg",
        IMAGES_PATH . "/og-images/og-image6.jpg",
    );
}
else
{
    $og_image_arr = array($meta_logo_image);
}

//clearstatcache();
//$this->output->set_header('Expires: Tue, 01 Jan 2000 00:00:00 GMT');
//$this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
//$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
//$this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
//$this->output->set_header('Pragma: no-cache');
//    prd($meta_logo_image);

$controller = $this->router->fetch_class();
$action = $this->router->fetch_method();
$path = $controller . "/" . $action;
?>
<!doctype html>
<!--[if IE 9 ]><html class="ie9 no-js" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <meta charset="utf-8">
        <link rel="canonical" href="<?php echo current_url(); ?>">
        <meta name="theme-color" content="#f45b4f">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title><?php echo $meta_title; ?></title>

        <!-- Social meta ================================================== -->
        <meta property="og:type" content="<?php echo isset($meta_og_type) ? $meta_og_type : "website"; ?>">
        <meta property="og:title" content="<?php echo $meta_title; ?>">
        <meta property="og:url" content="<?php echo current_url(); ?>">
        <meta property="og:description" content="<?php echo $meta_description; ?>">
        <meta property="og:site_name" content="<?php echo SITE_TITLE; ?>">
        <meta property="fb:app_id" content="<?php echo FACEBOOK_APP_ID; ?>">

        <?php
        foreach ($og_image_arr as $value)
        {
            echo '<meta property="og:image" content="' . $value . '">';
        }

        if (isset($meta_price_amount))
        {
            echo '<meta property="og:price:amount" content="' . round($meta_price_amount, 2) . '">';
            echo '<meta property="og:price:currency" content="INR">';
        }

        if (isset($meta_logo_image))
        {
            echo '<meta name="twitter:image" content="' . $meta_logo_image . '">';
        }
        ?>

        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="<?php echo $meta_title; ?>">
        <meta name="twitter:description" content="<?php echo $meta_description; ?>">

        <link href="<?php echo IMAGES_PATH; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <!-- CSS ================================================== -->
        <link href="<?php echo CSS_PATH; ?>/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />  
        <link href="<?php echo CSS_PATH; ?>/font-awesome.css" rel="stylesheet" type="text/css" media="all" /> 
        <link href="<?php echo CSS_PATH; ?>/menu.css" rel="stylesheet" type="text/css" media="all" /> 
        <link href="<?php echo CSS_PATH; ?>/Linearicons-Free.css" rel="stylesheet" type="text/css" media="all" /> 
        <link href="<?php echo CSS_PATH; ?>/mobile-menu.css" rel="stylesheet" type="text/css" media="all" />  
        <link href="<?php echo CSS_PATH; ?>/owl.carousel.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo CSS_PATH; ?>/owl.theme.css" rel="stylesheet" type="text/css" media="all" />  	
        <link href="<?php echo CSS_PATH; ?>/theme.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo CSS_PATH; ?>/theme-responsive.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo CSS_PATH; ?>/product.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo CSS_PATH; ?>/jquery.bxslider.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo CSS_PATH; ?>/jmsfont-style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo CSS_PATH; ?>/custom.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo CSS_PATH; ?>/theme-skin.scss.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo CSS_PATH; ?>/customcss.scss.css" rel="stylesheet" type="text/css" media="all" />
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js" type="text/javascript"></script>
        <script src="<?php echo JS_PATH; ?>/respond.min.js" type="text/javascript"></script>
        <link href="<?php echo JS_PATH; ?>/respond-proxy.html" id="respond-proxy" rel="respond-proxy" />
        <link href="search/index-q=38ce042c6e3c556eb9dc128d8668e2e8.html" id="respond-redirect" rel="respond-redirect" />
        <script src="search/index-q=38ce042c6e3c556eb9dc128d8668e2e8.html" type="text/javascript"></script>
        <![endif]-->

        <script src="<?php echo JS_PATH; ?>/jquery.min.js" type="text/javascript"></script>
    </head>

    <body id="jms-minimal" class=" template-index" >
        <?php
        $this->load->view("layout/front/navigation", array("type" => "mobile"));
        ?>
        <div id="content-wrap">
            <div class="content">    
                <div id="shopify-section-header" class="shopify-section"><header>
                        <div class="headerbox">
                            <div class="container">
                                <div class="row">
                                    <div class="layout-column col-lg-2 col-md-2 col-sm-12 col-xs-12 navbar-logo pull-left">
                                        <div class="addon-box">
                                            <a href="<?php echo base_url(); ?>" class="logo-wrapper">
                                                <img src="<?php echo IMAGES_PATH; ?>/logo-name.png" alt="<?php echo SITE_NAME; ?>" width="180">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="layout-column col-lg-2 col-md-2 col-sm-12 col-xs-12 addons-box pull-right">
                                        <div class="addon-box">
                                            <div id="jms_ajax_search" class="btn-group compact-hidden">
                                                <a href="#"  class="btn-xs dropdown-toggle" data-toggle="dropdown">	
                                                    <i class="jmsf jmsf-search-3"></i>	
                                                </a>
                                                <div class="dropdown-menu search-box" role="menu">	
                                                    <form action="<?php echo base_url("search"); ?>" method="get" class="input-group search-bar" role="search">
                                                        <input type="search" name="q" value=""  class="input-group-field form-control" aria-label="Enter your keyword..." placeholder="Enter your keyword...">
                                                        <button type="submit" class="zmdi zmdi-search zmdi-hc-fw">	
                                                            <i class="jmsf jmsf-search-3"></i>
                                                        </button>
                                                    </form>
                                                </div>	
                                            </div>
                                            <script type="text/javascript">
                                                $(document).on('click', '#jms_ajax_search .dropdown-menu', function (e) {
                                                    e.stopPropagation();
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="layout-column col-lg-8 col-md-8 col-sm-12 col-xs-12 main-nav pull-right">
                                        <div class="addon-box">
                                            <?php
                                            $this->load->view("layout/front/navigation", array("type" => "desktop"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                </div>