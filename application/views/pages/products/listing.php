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
                            <label>Sort by :</label>
                            <select name="sort" id="SortBy">
                                <option value="<?php echo add_get_parameter("sort", "random", current_url()); ?>">Random</option>
                                <option value="<?php echo add_get_parameter("sort", "alpha-asc", current_url()); ?>">Alphabetically, A-Z</option>
                                <option value="<?php echo add_get_parameter("sort", "alpha-desc", current_url()); ?>">Alphabetically, Z-A</option>
                                <option value="<?php echo add_get_parameter("sort", "price-asc", current_url()); ?>">Price, low to high</option>
                                <option value="<?php echo add_get_parameter("sort", "price-desc", current_url()); ?>">Price, high to low</option>
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
                                        <div class="wrapper-label <?php echo strtolower($value["product_type"]); ?>"><?php echo ucwords($value["product_type"]); ?></div>
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

                <?php $this->load->view("pages/products/pagination"); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#SortBy').change(function () {
        var new_url = $(this).val();
        window.location.href = new_url;
    });

    $(document).ready(function () {
        var current_url = '<?php echo current_url(); ?>';
        $('#SortBy option[value="' + current_url + '"]').attr("selected", "selected");
    });
</script>