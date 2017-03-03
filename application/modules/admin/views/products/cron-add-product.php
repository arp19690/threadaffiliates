<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-users position-left"></i> Add a new Product Code</h4>
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
                        <h5 class="panel-title">Add a new Product Code</h5>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="" method="post">
                            <fieldset class="content-group">

                                <div class="form-group">
                                    <label class="control-label col-lg-2">Category</label>
                                    <div class="col-lg-10">
                                        <select name="category_id" class="form-control" required="required">
                                            <?php
                                            echo create_category_select_option($categories);
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-2">From Website?</label>
                                    <div class="col-lg-10">
                                        <select name="dc_type" class="form-control" required="required">
                                            <option value=""></option>
                                            <option value="amazon">Amazon</option>
                                            <option value="flipkart">Flipkart</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-2">Product Code</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="product_code" class="form-control" required="required"/>
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