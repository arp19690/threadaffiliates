<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-list position-left"></i> <?php echo $page_heading;?></h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo base_url_admin('categories/add'); ?>" class="btn btn-link btn-float has-text"><i class="icon-plus-circle2 text-primary"></i><span>New Category</span></a>
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
                        <h5 class="panel-title"><?php echo $page_heading;?></h5>
                    </div>

                    <div class="panel-body">
                        <?php
                        if (!empty($data))
                        {
                            ?>
                            <table class="table  no-footer">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data as $key => $value)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo stripslashes($value["category_name"]); ?></td>
                                            <td>
                                                <p><a href="<?php echo base_url_admin("categories/list_children/" . $value["category_id"]) ?>" class="btn btn-success btn-xs">View Children</a></p>
                                                <p><a href="<?php echo base_url_admin("categories/edit/" . $value["category_id"]) ?>" class="btn btn-warning btn-xs">Edit</a></p>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        }
                        else
                        {
                            echo '<p class="text-center">No results found</p>';
                        }
                        ?>
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