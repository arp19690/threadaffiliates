<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-list position-left"></i> <?php echo $page_title; ?></h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo base_url_admin('products/cron_add_product'); ?>" class="btn btn-link btn-float has-text"><i class="icon-plus-circle2 text-primary"></i><span>New Product</span></a>
                </div>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">

        <?php $this->load->view('layout/admin/notification-section'); ?>

        <!-- Collapsible lists -->
        <div class="row">
            <div class="col-md-12">

                <!-- Collapsible list -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title"><?php echo $page_title; ?></h5>
                    </div>

                    <div class="panel-body">
                        <table class="table datatable-pagination dataTable no-footer">
                            <thead>
                                <tr class="text-center">
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Brand</th>
                                    <th>Attributes</th>
                                    <th>Last Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $custom_model = new Custom_model();
                                foreach ($data as $key => $value)
                                {
                                    $category_path = str_replace("Home/", "", strip_tags($custom_model->create_breadcrumb($value["product_id"])));
                                    $category_path = str_replace("/" . stripslashes($value["product_title"]), "", $category_path);
                                    ?>
                                    <tr class="text-left">
                                        <td>
                                            <p style="margin: 0;"><?php echo $value["dc_product_unique_code"]; ?></p>
                                            <p style="margin: 0;"><small><strong><?php echo ucwords($value["dc_type"]); ?></strong></small></p>
                                        </td>
                                        <td style="max-width: 200px;">
                                            <?php
                                            if (!empty($value["product_url_key"]))
                                            {
                                                ?>
                                                <a href="<?php echo base_url("p/" . $value["product_url_key"]); ?>" target="_blank"><?php echo stripslashes($value["product_title"]); ?></a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <p class="text-danger"><small>Out of Stock / No Data Available</small></p>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td style="max-width: 200px;"><?php echo stripslashes($category_path); ?></td>
                                        <td><?php echo number_format($value["product_price_min"], 2); ?></td>
                                        <td><?php echo stripslashes($value["product_brand"]); ?></td>
                                        <td>
                                            <p><strong>Color: </strong><?php echo (!empty($value["product_color"]) ? stripslashes($value["product_color"]) : "NA"); ?></p>
                                            <p><strong>Size: </strong><?php echo (!empty($value["product_size"]) ? stripslashes($value["product_size"]) : "NA"); ?></p>
                                        </td>
                                        <td><?php echo $value["updated_on"]; ?></td>
                                        <td>
                                            <?php
                                            if (strtotime($value["updated_on"]) <= time() - (CRON_THRESHOLD_HOURS * 60 * 60) || empty($value["product_url_key"]))
                                            {
                                                ?>
                                                <p><a href="<?php echo base_url_admin("products/fetch_cron_product_info/" . $value["dc_id"]) ?>" class="btn btn-warning btn-xs">Fetch new info</a></p>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <p class="text-success">Info updated</p>
                                                <?php
                                            }
                                            ?>
                                            <p><a href="<?php echo base_url_admin("products/cron_edit_product/" . $value["product_id"]) ?>" class="btn btn-success btn-xs">Edit</a></p>
                                            <p><a href="<?php echo base_url_admin("products/delete_product/" . $value["dc_product_unique_code"]) ?>" class="text-danger" onclick="return confirm('Sure you want to delete?');">Delete</a></p>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
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