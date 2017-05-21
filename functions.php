<?php

function get_affiliate_name($type = "amazon")
{
    $output = "Amazon IN";
    switch ($type)
    {
        case "amazon_usa":
            $output = "Amazon USA";
            break;
        case "flipkart":
            $output = "Flipkart";
            break;
    }
    return $output;
}

function get_currency_symbol($currency_code)
{
    $output = "Rs. ";
    switch ($currency_code)
    {
        case "USD":
            $output = "$";
            break;
    }
    return $output;
}

function add_get_parameter($arg, $value, $current_url)
{
    $get_params = $_GET;
    $get_params[$arg] = $value;
    $new_get_params_str = http_build_query($get_params);

    $explode_current_url = explode("?", $current_url);
    $new_url = $explode_current_url[0] . "?" . $new_get_params_str;
    return $new_url;
}

function get_orderby_for_category_listing($case)
{
    $orderby = "rand()";
    switch ($case)
    {
        case "random":
            $orderby = "rand()";
            break;
        case "alpha-asc":
            $orderby = "product_title ASC";
            break;
        case "alpha-desc":
            $orderby = "product_title DESC";
            break;
        case "price-asc":
            $orderby = "product_price_min ASC";
            break;
        case "price-desc":
            $orderby = "product_price_min DESC";
            break;
        default :
            $orderby = "rand()";
            break;
    }
    return $orderby;
}

function clean_string($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

function create_category_select_option($data, $i = 0, $selected_category_id = NULL)
{
    $str = "";
    foreach ($data as $value)
    {
        $tmpstr = str_repeat("-- ", $i);
        $selected = ($selected_category_id == $value["category_id"] ? "selected='selected'" : "");
        $str.="<option value='" . $value["category_id"] . "' " . $selected . ">" . $tmpstr . stripslashes($value["category_name"]) . "</option>";
        if (isset($value["children"]) && !empty($value["children"]))
        {
            $str.=create_category_select_option($value["children"], $i + 1, $selected_category_id);
        }
    }
    return $str;
}

function custom_parse_url($url, $append = UTM_SOURCE_CODE)
{
    $parsed_url = parse_url($url);

    if (isset($parsed_url['query']))
    {
        // Has query params
        $url = $url . '&' . $append;
    }
    else
    {
        // Has no query params
        $url = $url . '?' . $append;
    }
    return $url;
}

function get_google_ad($type = "responsive")
{
    if (USER_IP != '127.0.0.1')
    {
        switch ($type)
        {
            case "responsive":
                $str = '<div style="margin: 20px 0;"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                            <!-- ThreadAffiliates Responsive -->
                            <ins class="adsbygoogle"
                                 style="display:block"
                                 data-ad-client="ca-pub-7594968339633253"
                                 data-ad-slot="6340911725"
                                 data-ad-format="auto"></ins>
                            <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                            </script></div>';
                break;
            case "square":
                $str = '<div style="margin: 20px 0;"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                            <!-- Threadcrafts Square -->
                            <ins class="adsbygoogle"
                                 style="display:inline-block;width:300px;height:250px"
                                 data-ad-client="ca-pub-7594968339633253"
                                 data-ad-slot="4001805724"></ins>
                            <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                            </script></div>';
                break;
        }
    }
    else
    {
        $str = "<p class='text-center'><code>Google ad here</code></p>";
    }
    return $str;
}

function get_unique_product_url_key($product_name)
{
    require_once APPPATH . 'models/common_model.php';
    $model = new Common_model();

    $product_url_key = str_replace(' ', '-', $product_name);
    $product_url_key = preg_replace('/[^A-Za-z0-9\-]/', '', $product_url_key);
    $product_url_key = preg_replace('/-+/', '-', $product_url_key);
    $is_exists = $model->fetchSelectedData("product_id", TABLE_PRODUCTS, array("product_url_key" => $product_url_key));
    if (!empty($is_exists))
    {
        $product_url_key = get_unique_product_url_key($product_url_key . "-" . rand(111, 999));
    }
    return $product_url_key;
}

function display_404_page()
{
    require_once APPPATH . 'controllers/index.php';
    $index_controller = new Index();
    $index_controller->pagenotfound();
}

function get_breadcrumbs($input_arr)
{
    $i = 1;
    $str = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">';
    foreach ($input_arr as $url => $title)
    {
        if (count($input_arr) > $i)
        {
            $str.='<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            $str.='<a itemprop="item" href="' . $url . '"><span itemprop="name">' . $title . '</span></a>';
            $str.= '<meta itemprop="position" content="' . $i . '" />';
            $str.='</span>';
            $str.=' / ';
        }
        else
        {
            $str.='<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            $str.='<span itemprop="name">' . $title . '</span>';
            $str.= '<meta itemprop="position" content="' . $i . '" />';
            $str.='</span>';
        }
        $i++;
    }
    $str.='</div>';
    return $str;
}

function goBack($steps = '1')
{
    return 'javascript:history.go(-' . $steps . ');';
}

function getNWordsFromString($text, $numberOfWords = 50)
{
    if ($text != null)
    {
        $textArray = explode(" ", $text);
        if (count($textArray) > $numberOfWords)
        {
            return implode(" ", array_slice($textArray, 0, $numberOfWords)) . "...";
        }
        return $text;
    }
    return "";
}

function pr($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function prd($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
    die;
}
