<div class="pagination-section">
    <div class="toolbar toolbar-bottom">
        <ul class="pagination-page">
            <li class="disabled"><span class="jmsf jmsf-arrows-left-1"></span></li>
            <?php
            $j = 1;
            for ($i = 1; $i <= $total_products_count; $i = $i + PAGINATION_LIMIT)
            {
                $parsed_url = parse_url(current_url());
                $new_url = $parsed_url["scheme"] . "://" . $parsed_url["host"] . $parsed_url["path"];

                $exploded_query = array();
                if (isset($parsed_url["query"]))
                {
                    $exploded_query = explode("&", $parsed_url["query"]);
                    foreach ($exploded_query as $ekey => $evalue)
                    {
                        $tmpexplode = explode("=", $evalue);
                        if ($tmpexplode[0] == "page")
                        {
                            unset($exploded_query[$ekey]);
                        }
                    }
                }
                array_push($exploded_query, "page=" . $j);
                $new_url .= "?" . implode("&", $exploded_query);

                if (current_url() == $new_url || (current_url() == $parsed_url["scheme"] . "://" . $parsed_url["host"] . $parsed_url["path"] && $j == 1))
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