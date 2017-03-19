<div class="pagination-section">
    <div class="toolbar toolbar-bottom">
        <ul class="pagination-page">
            <li class="disabled"><span class="jmsf jmsf-arrows-left-1"></span></li>
            <?php
            $j = 1;
            for ($i = 1; $i <= $total_products_count; $i = $i + PAGINATION_LIMIT)
            {
                $new_url = add_get_parameter("page", $j, current_url());
                if (current_url() == $new_url && $j == 1)
                {
                    echo '<li class="active"><span>' . $j . '</span></li>';
                }
                else
                {
                    echo '<li><a href="' . $new_url . '">' . $j . '</a></li>';
                }
                $j++;
            }
            ?>
            <li class="disabled"><span class="jmsf jmsf-arrows-right-1"></span></li>
        </ul>
    </div>
</div>