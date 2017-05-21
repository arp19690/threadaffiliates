<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-users position-left"></i> <?php echo $page_title; ?></h4>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">

        <?php $this->load->view('layout/admin/notification-section'); ?>

        <!-- Collapsible lists -->
        <div class="row">
            <div class="col-md-6">

                <!-- Collapsible list -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title"><?php echo $page_title; ?></h5>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="" method="post">
                            <fieldset class="content-group">

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Product Code</label>
                                    <div class="col-lg-8">
                                        <p><strong><?php echo $product_data["product_unique_code"]; ?></strong></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Category</label>
                                    <div class="col-lg-8">
                                        <select name="category_id" class="form-control" required="required">
                                            <?php
                                            echo $categories_option_html;
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">From Website?</label>
                                    <div class="col-lg-8">
                                        <select name="dc_type" class="form-control" required="required">
                                            <option value=""></option>
                                            <option value="amazon" <?php echo $product_data["product_type"] == "amazon" ? "selected='selected'" : ""; ?>>Amazon India</option>
                                            <option value="amazon_usa" <?php echo $product_data["product_type"] == "amazon_usa" ? "selected='selected'" : ""; ?>>Amazon USA</option>
                                            <option value="flipkart" <?php echo $product_data["product_type"] == "flipkart" ? "selected='selected'" : ""; ?>>Flipkart</option>
                                        </select>
                                    </div>
                                </div>

                            </fieldset>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /collapsible list -->

            </div>
        </div>
        <!-- /collapsible lists -->

    </div>
    <!-- /content area -->

</div>
<!-- /main content -->