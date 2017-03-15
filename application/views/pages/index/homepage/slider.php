<script src="<?php echo JS_PATH; ?>/jquery.fractionslider.js" type="text/javascript"></script>
<link href="<?php echo CSS_PATH; ?>/fractionslider.css" rel="stylesheet" type="text/css" media="all" />

<div id="shopify-section-1479870870856" class="shopify-section index-section index-section--flush">
    <div data-section-id="1479870870856" data-section-type="slideshow-section" class="slideshow-section">
        <div class="slideshow-inner">
            <div class="jms-slider-wrapper">
                <div class="responisve-container">
                    <div class="slider" >
                        <div class="fs_loader"></div>
                        <div class="slide slideshow__slide slideshow__slide--1479870870856-0" style="background:url(<?php echo IMAGES_PATH; ?>/sliders/1.jpg) no-repeat left top;background-size:cover;">
                            <div class="jms-slide-content slide-heading" 					
                                 data-position="355,190" 
                                 data-fontsize = "70"					
                                 data-in="bottom" 
                                 data-out="fade" 
                                 data-delay="2000" 
                                 data-ease-in="linear" 
                                 data-ease-out="linear" 
                                 data-step="0" 
                                 data-special="0"
                                 data-time = "2500"
                                 style="font-size:70px; color:#ffffff;"					
                                 >
                            </div>

                            <div class="jms-slide-content slide-text slide-text-1" 					
                                 data-position="290,200" 
                                 data-fontsize = "25"					
                                 data-in="bottom" 
                                 data-out="fade" 
                                 data-delay="2000" 
                                 data-ease-in="" 
                                 data-ease-out="" 
                                 data-step="0" 
                                 data-special="0"
                                 data-time = "2000"
                                 style="font-size:25px; color:#ffffff;"					
                                 >
                            </div>
                        </div> 

                        <div class="slide slideshow__slide slideshow__slide--1479870870856-1" style="background:url(<?php echo IMAGES_PATH; ?>/sliders/2.jpg) no-repeat left top;background-size:cover;">
                            <div class="jms-slide-content slide-heading" 					
                                 data-position="355,1060" 
                                 data-fontsize = "70"					
                                 data-in="bottom" 
                                 data-out="fade" 
                                 data-delay="2000" 
                                 data-ease-in="linear" 
                                 data-ease-out="linear" 
                                 data-step="0" 
                                 data-special="0"
                                 data-time = "2500"
                                 style="font-size:70px; color:#ffffff;"					
                                 >2017 Special
                            </div>

                            <div class="jms-slide-content slide-text slide-text-1" 					
                                 data-position="290,1300" 
                                 data-fontsize = "25"					
                                 data-in="bottom" 
                                 data-out="fade" 
                                 data-delay="2000" 
                                 data-ease-in="" 
                                 data-ease-out="" 
                                 data-step="0" 
                                 data-special="0"
                                 data-time = "2000"
                                 style="font-size:25px; color:#ffffff;"					
                                 >FASHION TRENDS
                            </div>
                        </div> 
                    </div>
                </div>
            </div>  
        </div>
    </div>  

    <script type="text/javascript">
        $(window).load(function () {
            $('.slider').fractionSlider({
                'slideTransition': 'fade', // default slide transition
                'slideEndAnimation': true, // if set true, objects will transition out before next slide moves in      
                'transitionIn': 'left', // default in - transition
                'transitionOut': 'left', // default out - transition
                'fullWidth': true, // transition over the full width of the window
                'delay': 1000, // default delay for elements
                'timeout': 4000, // default timeout before switching slides
                'speedIn': 300, // default in - transition speed
                'speedOut': 0, // default out - transition speed
                'easeIn': 'linear', // default easing in
                'easeOut': 'linear', // default easing out

                'controls': true, // controls on/off
                'pager': true, // pager inside of the slider on/off OR $('someselector') for a pager outside of the slider
                'autoChange': true, // auto change slides
                'pauseOnHover': true, // Pauses slider on hover (current step will still be completed)

                'backgroundAnimation': true, // background animation
                'backgroundElement': null, // element to animate | default fractionSlider element
                'backgroundX': 500, // background animation x distance
                'backgroundY': 500, // background animation y distance
                'backgroundSpeed': 2500, // default background animation speed
                'backgroundEase': 'easeOutCubic', // default background animation easing

                'responsive': true, // responsive slider (see below for some implementation tipps)
                'increase': false,
                'dimensions': "1920,808",
            });
        });
    </script>
</div>