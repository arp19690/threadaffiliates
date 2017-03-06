<?php
$custom_model = new Custom_model();
$menu_data = $custom_model->create_menu();
?>

<div class="">
    <div class="banner-left-sidebar hidden-xs"><?php echo get_google_ad(); ?></div>

    <div class="block categories-block hidden-xs">
        <h3 class="block-title">Categories<span class="layered_close"></span></h3>
        <div class="block-content">
            <ul>
                <?php
                foreach ($menu_data as $value)
                {
                    ?>
                    <li><a href="<?php echo base_url("c/" . $value["category_url_key"]); ?>"><span><?php echo stripslashes($value["category_name"]); ?></span></a></li>
                    <?php
                    foreach ($value["children"] as $cvalue)
                    {
                        ?>
                        <li><a href="<?php echo base_url("c/" . $value["category_url_key"] . "/" . $cvalue["category_url_key"]); ?>" style="padding-left: 20px;"><span><?php echo stripslashes($cvalue["category_name"]); ?></span></a></li>
                        <?php
                    }
                }
                ?>
            </ul>    
        </div> 	
    </div>

    <!--    <div class="filter-block block">
            <div id="layer-price" class="sidebar-custom sidebar-tag">
                <div class="widget-title">
                    <h3 class="block-title">
                        Price 
                        <a href="javascript:void(0)" class="clear" style="display:none">
                            Clear
                        </a>
                    </h3>
                </div>
                <div class="widget-content block-content">
                    <ul>
                        <li>          
                            <input type="checkbox" value="101-200"/>
                            <label>$101 - $200</label>          
                        </li>
                        <li>          
                            <input type="checkbox" value="201-300"/>
                            <label>$201 - $300</label>          
                        </li>
                        <li>          
                            <input type="checkbox" value="301-400"/>
                            <label>$301 - $400</label>          
                        </li>
                        <li>          
                            <input type="checkbox" value="501-600"/>
                            <label>$501 - $600</label>          
                        </li>
                    </ul>
                </div>
            </div>
    
            <div class="sidebar-custom sidebar-tag">
                <div class="widget-title">
                    <h3 class="block-title">
                        Brands   
                        <a href="javascript:void(0)" class="clear" style="display:none">
                            Clear
                        </a>
                    </h3>
                </div>
                <div class="widget-content block-content">
                    <ul>
                        <li>          
                            <input type="checkbox" value="haute-hippie"/>
                            <label>Haute Hippie</label>          
                        </li> 
                        <li>          
                            <input type="checkbox" value="calvin-klein"/>
                            <label>Calvin Klein</label>          
                        </li> 
                        <li>          
                            <input type="checkbox" value="columbia"/>
                            <label>Columbia</label>          
                        </li> 
                    </ul>
                </div>
            </div>
        </div>-->

    <div class="banner-left-sidebar"><?php echo get_google_ad(); ?></div>
</div>