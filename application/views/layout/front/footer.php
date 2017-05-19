<div id="shopify-section-footer" class="shopify-section"><footer>
        <div class="footer-block footer--logo">
            <div class="container">
                <div class="row">
                    <div class="layout-column col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <div class="addon-box">
                            <a href="/" class="logo-wrapper">
                                <img src="<?php echo IMAGES_PATH . "/logo.png" ?>" data-original="<?php echo IMAGES_PATH . "/logo.png" ?>" alt="<?php echo SITE_NAME; ?>" class="lazy" width="150">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-block footer--social-icons">
            <div class="container">
                <div class="row">
                    <div class="layout-column col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="addon-box">
                            <div id="social_block">
                                <ul class="find-us">
                                    <li class="divider facebook">
                                        <a href="https://www.facebook.com/ThreadCraftsIn" title="<?php echo SITE_NAME; ?> on Facebook" target="_blank">
                                            <span class="fa fa-facebook"></span>
                                        </a>
                                    </li>

                                    <li class="divider twitter">
                                        <a href="https://twitter.com/ThreadCrafts" title="<?php echo SITE_NAME; ?> on Twitter" target="_blank">
                                            <span class="fa fa-twitter"></span>
                                        </a>
                                    </li>

                                    <li class="divider google-plus">
                                        <a href="https://plus.google.com/+ThreadCraftsJodhpur" title="<?php echo SITE_NAME; ?> on Google Plus" target="_blank" rel="publisher">
                                            <span class="fa fa-google-plus"></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer footer--copyright">
            <div class="container clearfix">
                <div class="row">
                    <div class="copyright col-xs-12">
                        <p>All Rights Reserved. &COPY; <?php echo date("Y") . " " . SITE_NAME; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
</div>
</div>
<script src="<?php echo JS_PATH; ?>/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/megamenu.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/mobile-menu.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/jquery.jcarousel.min.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/owl.carousel.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/jquery.bxslider.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/jmsfont-js.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/jquery.lazyload.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $("img.lazy").lazyload({
        threshold: 200
    });
</script>

<?php
if (USER_IP != "127.0.0.1")
{
    ?>
    <!-- Google Analytics -->
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-79425146-1', 'auto');
        ga('send', 'pageview');
    </script>

    <!-- Smartlook snippet -->
    <script type="text/javascript">
        window.smartlook||(function(d) {
        var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
        var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
        c.charset='utf-8';c.src='//rec.smartlook.com/recorder.js';h.appendChild(c);
        })(document);
        smartlook('init', '5f1e8a28ac2f9f36d4e9129d1dab8d13c99a2be1');
    </script>
    <?php
}
?>
</body>
</html>
