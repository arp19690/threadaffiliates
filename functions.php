<?php

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
            $str.=create_category_select_option($value["children"], $i + 1);
        }
    }
    return $str;
}

function custom_parse_url($url, $utm_source_code = UTM_SOURCE_CODE)
{
    $parsed_url = parse_url($url);

    if (isset($parsed_url['query']))
    {
        // Has query params
        $url = $parsed_url . '&' . $utm_source_code;
    }
    else
    {
        // Has no query params
        $url = $parsed_url . '?' . $utm_source_code;
    }
    return $url;
}

function get_google_ad()
{
    if (USER_IP != '127.0.0.1')
    {
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

function getNWordsFromString($text, $numberOfWords = 20)
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
