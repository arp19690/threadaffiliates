<?php
echo isset($breadcrumb) ? $breadcrumb : "";
?>  

<div class="container page-content">
    <div id="shopify-section-collection-left-sidebar" class="shopify-section">
        <div class="row">
            <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12 content-aside">  
                <?php $this->load->view("pages/products/left-sidebar"); ?>
            </div>
            <div class="col-sm-8 col-md-9 col-lg-9 col-xs-12 content-center">
                <div class="toolbar filters-panel">
                    <div class="sort-by hidden-xs pull-right">
                        <div class="fillter-row">
                            <label>Sort by</label>
                            <select name="SortBy" id="SortBy">
                                <option value="manual">Featured</option>
                                <option value="best-selling">Best Selling</option>
                                <option value="title-ascending">Alphabetically, A-Z</option>
                                <option value="title-descending">Alphabetically, Z-A</option>
                                <option value="price-ascending">Price, low to high</option>
                                <option value="price-descending">Price, high to low</option>
                                <option value="created-descending">Date, new to old</option>
                                <option value="created-ascending">Date, old to new</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="products-list" class="grid-mode row products-sidebar">
                    <?php
                    if (!empty($product_data))
                    {
                        foreach ($product_data as $value)
                        {
                            ?>
                            <div class="item">
                                <div class="product-preview clearfix">
                                    <div class="preview">
                                        <a href="<?php echo base_url("p/" . $value["product_url_key"]); ?>" title="<?php echo stripslashes($value["product_title"]); ?>">
                                            <img src="<?php echo $value["product_image_url"]; ?>" data-original="<?php echo $value["product_image_url"]; ?>" alt="<?php echo stripslashes($value["product_title"]); ?>" class="first-image img-responsive lazy">
                                            <img src="<?php echo $value["product_image_url"]; ?>" data-original="<?php echo $value["product_image_url"]; ?>" alt="<?php echo stripslashes($value["product_title"]); ?>" class="second-img img-responsive lazy" />
                                        </a>
                                        <div class="wrapper-label"></div>
                                    </div> 

                                    <div class="product-info clearfix">
                                        <a class="product-title" href="<?php echo base_url("p/" . $value["product_url_key"]); ?>"><?php echo stripslashes($value["product_title"]); ?></a>
                                        <div class="content_price">
                                            <span class="price"><span class="money">Rs. <?php echo number_format($value["product_price_min"], 2); ?></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    else
                    {
                        ?>
                        <h3 class="text-center">No results found</h3>
                        <div class="clearfix" style="margin-top: 30px;">
                            <?php echo get_google_ad(); ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /*============================================================================
     Inline JS because collection liquid object is only available
     on collection pages, and not external JS files
     ==============================================================================*/
    Threadcrafts.queryParams = {};
    if (location.search.length) {
        for (var aKeyValue, i = 0, aCouples = location.search.substr(1).split('&'); i < aCouples.length; i++) {
            aKeyValue = aCouples[i].split('=');
            if (aKeyValue.length > 1) {
                Threadcrafts.queryParams[decodeURIComponent(aKeyValue[0])] = decodeURIComponent(aKeyValue[1]);
            }
        }
    }

    $(function () {
        $('#SortBy')
                .val('title-ascending')
                .bind('change', function () {
                    Threadcrafts.queryParams.sort_by = jQuery(this).val();
                    location.search = jQuery.param(Threadcrafts.queryParams);
                }
                );
    });
</script>