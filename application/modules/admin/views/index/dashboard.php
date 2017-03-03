<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-home4 position-left"></i> Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">

        <?php $this->load->view('layout/admin/notification-section'); ?>

        <!-- Quick stats boxes -->
        <div class="row">
            <div class="col-lg-4">
                <div class="panel bg-teal-400">
                    <a href="<?php echo base_url_admin("products/cron_list_products"); ?>" class="text-white">
                        <div class="panel-body">
                            <h3 class="no-margin"><?php echo $total_products; ?></h3>
                            Total Products
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="panel bg-pink-400">
                    <a href="<?php echo base_url_admin("products/cron_list_products/amazon"); ?>" class="text-white">
                        <div class="panel-body">
                            <h3 class="no-margin"><?php echo $total_amazon_products; ?></h3>
                            Amazon Products
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="panel bg-blue-400">
                    <a href="<?php echo base_url_admin("products/cron_list_products/flipkart"); ?>" class="text-white">
                        <div class="panel-body">
                            <h3 class="no-margin"><?php echo $total_flipkart_products; ?></h3>
                            Flipkart Products
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- /quick stats boxes -->
    </div>
    <!-- /content area -->

</div>
<!-- /main content -->