<?php
$custom_model = new Custom_model();
$menu_data = $custom_model->create_menu();

switch ($type)
{
    case "mobile":
        ?>
        <div class="menu-wrap hidden-lg hidden-md">
            <nav id="off-canvas-menu">
                <div id="off-canvas-menu-title"><span class="close-button" id="close-button"></span></div>
                <ul class="nav nav-pills nav-stacked level0">
                    <li class="mega  active"><a href="<?php echo base_url(); ?>">Home</a></li>
                    <?php
                    foreach ($menu_data as $value)
                    {
                        echo '<li class="mega">';
                        echo '<a href="' . base_url("c/" . stripslashes($value["category_url_key"])) . '" class="">' . stripslashes($value["category_name"]) . (empty($value["children"]) ? '' : '<em class="fa fa-angle-right"></em>') . '</a>';
                        if (!empty($value["children"]))
                        {
                            echo '<ul class="dropdown-menu">';
                            foreach ($value["children"] as $child_value)
                            {
                                echo '<li class="group"><a href="' . base_url("c/" . stripslashes($value["category_url_key"])) . "/" . stripslashes($child_value["category_url_key"]) . '">' . stripslashes($child_value["category_name"]) . '</a></li>';
                                if (!empty($child_value["children"]))
                                {
                                    foreach ($child_value["children"] as $child2_value)
                                    {
                                        echo '<li><a href="' . base_url("c/" . stripslashes($value["category_url_key"])) . "/" . stripslashes($child_value["category_url_key"]) . "/" . stripslashes($child2_value["category_url_key"]) . '" class="">' . stripslashes($child2_value["category_name"]) . '</a></li>';
                                    }
                                }
                            }
                            echo '</ul>';
                        }
                        echo '</li>';
                    }
                    ?>
                </ul>
            </nav>
        </div> 
        <?php
        break;
    case "desktop":
        ?>
        <a href="#" id="open-button" class="open-button hidden-lg hidden-md">
            <i class="jmsf jmsf-menu-1"></i>
        </a>
        <div class="jms-megamenu">
            <ul class="nav level0 clearfix">
                <li class="mega  active mega-align-left"><a href="<?php echo base_url(); ?>">Home</a></li>
                <?php
                foreach ($menu_data as $value)
                {
                    echo '<li class="mega mega-align-right ">';
                    echo '<a href="' . base_url("c/" . stripslashes($value["category_url_key"])) . '" class="">' . stripslashes($value["category_name"]) . (empty($value["children"]) ? '' : '<em class="caret"></em>') . '</a>';
                    if (!empty($value["children"]))
                    {
                        echo '<div class="dropdown-menu" style="width:992px;"><div class="mega-dropdown-inner"><div class="row">';
                        if (!empty($value["children"]))
                        {
                            foreach ($value["children"] as $child_value)
                            {
                                ?>
                                <div class="mega-col-nav col-sm-4">
                                    <div class="mega-inner">
                                        <ul class="mega-nav">
                                            <li class="group"><a href="<?php echo base_url("c/" . stripslashes($value["category_url_key"])) . "/" . stripslashes($child_value["category_url_key"]); ?>"><?php echo stripslashes($child_value["category_name"]); ?></a></li>
                                                <?php
                                                if (!empty($child_value["children"]))
                                                {
                                                    foreach ($child_value["children"] as $child2_value)
                                                    {
                                                        echo '<li><a href="' . base_url("c/" . stripslashes($value["category_url_key"])) . "/" . stripslashes($child_value["category_url_key"]) . "/" . stripslashes($child2_value["category_url_key"]) . '" class="">' . stripslashes($child2_value["category_name"]) . '</a></li>';
                                                    }
                                                }
                                                ?>
                                        </ul>  
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        echo '</div><div class="row"></div></div></div>';
                    }
                    echo '</li>';
                }
                ?>
            </ul>
        </div>  
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                jQuery('.jms-megamenu').jmsMegaMenu({
                    event: 'hover',
                    duration: 500
                });
            });
        </script>
        <?php
        break;
}