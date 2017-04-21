<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_category_products($parent_category, $child_category = NULL, $child2_category = NULL)
    {
        $model = new Common_model();
        $custom_model = new Custom_model();

//        Defining limit for products
        $limit = "0, " . PAGINATION_LIMIT;
        if ($this->input->get("page"))
        {
            $page_num = $this->input->get("page");
            $limit_start = (($page_num - 1) * PAGINATION_LIMIT) + 1;
            $limit_end = (($page_num - 1) * PAGINATION_LIMIT) + PAGINATION_LIMIT;
            $limit = $limit_start . ", " . $limit_end;
        }

//        Defining orderby for product
        $order_by = get_orderby_for_category_listing($this->input->get("sort"));

        // fetching category_ids from their category_url_key
        $where_cond = array("category_status" => 1, "category_url_key" => $parent_category);
        $category_data = $model->fetchSelectedData("category_id, category_name", TABLE_CATEGORIES, $where_cond);
        if ($child_category != NULL)
        {
            $where_cond["category_url_key"] = $child_category;
            $where_cond["category_parent_id"] = $category_data[0]["category_id"];
            $category_data = $model->fetchSelectedData("category_id, category_name", TABLE_CATEGORIES, $where_cond);
        }
        if ($child2_category != NULL)
        {
            $where_cond["category_url_key"] = $child2_category;
            $where_cond["category_parent_id"] = $category_data[0]["category_id"];
            $category_data = $model->fetchSelectedData("category_id, category_name", TABLE_CATEGORIES, $where_cond);
        }
        $breadcrumb = $custom_model->create_breadcrumb($category_data[0]["category_id"], "category");

        // fetching products with status 1 and other relevant where condition
        $category_name_arr = array();
        $product_category_arr = array();
        foreach ($category_data as $value)
        {
            $cat_arr = $custom_model->get_all_lowest_level_category_ids($value["category_id"]);
            $product_category_arr = array_merge($product_category_arr, $cat_arr);
            $category_name_arr[] = stripslashes($value["category_name"]);
        }

        $product_data = array();
        $total_products_count = 0;
        if (!empty($product_category_arr))
        {
            $where_str = "product_status = 1 AND product_category_id IN (" . implode(", ", $product_category_arr) . ")";
            $product_data = $custom_model->get_all_products_and_data("p.*, count(pviews.ps_id) as ps_views, count(pclicks.ps_id) as ps_clicks", $where_str, $order_by, $limit);
            $total_products_count = $custom_model->get_total_products_count($where_str);
        }

        // now we render the data here
        $data = array();
        $page_title = implode(" - ", $category_name_arr) . " - " . SITE_NAME;
        $data["page_title"] = $page_title;
        $data['meta_title'] = $data["page_title"];
        $data['breadcrumb'] = $breadcrumb;
        $data['product_data'] = $product_data;
        $data['total_products_count'] = $total_products_count;
        $this->template->write_view("content", "pages/products/listing", $data);
        $this->template->render();
    }

    public function get_product_details($product_url_key)
    {
        $model = new Common_model();
        $custom_model = new Custom_model();
        // fetching products with status 1 and other relevant where condition
        $fetch_fields = "product_id, product_image_url, product_title, product_price_min, product_images_json, product_unique_code, product_description, product_url_key, product_category_id,product_type, product_wishlist_url";
        $product_where_cond = array("product_status" => 1, "category_status" => 1, "product_url_key" => $product_url_key);
        $product_data = $model->getAllDataFromJoin($fetch_fields, TABLE_PRODUCTS . " as p", array(TABLE_CATEGORIES . " as c" => "c.category_id = p.product_category_id"), "INNER", $product_where_cond);
        if (!empty($product_data))
        {
            // now we render the data here
            $data = array();
            $product_data = $product_data[0];
            $breadcrumb = $custom_model->create_breadcrumb($product_data['product_id']);
            $meta_description = getNWordsFromString(preg_replace('/\s+/', ' ', trim(strip_tags($product_data["product_description"]))), 50);
            $meta_description = str_replace("Product Description", "", $meta_description);

            $fetch_fields = "product_id, product_image_url, product_title, product_price_min, product_url_key, product_type";
            $related_products = $model->fetchSelectedData($fetch_fields, TABLE_PRODUCTS, array("product_status" => 1, "product_id !=" => $product_data["product_id"], "product_category_id" => $product_data["product_category_id"]), "rand()", "rand()", "0,8");

            $page_title = stripslashes($product_data["product_title"]) . " - " . SITE_NAME;
            $data["page_title"] = $page_title;
            $data['meta_title'] = $data["page_title"];
            $data['breadcrumb'] = $breadcrumb;
            $data['meta_description'] = $meta_description;
            $data['meta_og_type'] = "product";
            $data['meta_price_amount'] = $product_data["product_price_min"];
            $data['meta_logo_image'] = $product_data["product_image_url"];
            $data['product_data'] = $product_data;
            $data['related_products'] = $related_products;
            $this->template->write_view("content", "pages/products/detail", $data);
            $this->template->render();
        }
        else
        {
            display_404_page();
        }
    }

    public function search()
    {
        if ($this->input->get("q"))
        {
            $custom_model = new Custom_model();
            $keyword = $this->input->get("q");
            $product_data = $custom_model->search_keyword($keyword);

            // now we render the data here
            $data = array();
            $page_title = "Search for '" . $keyword . "' - " . SITE_NAME;
            $data["page_title"] = $page_title;
            $data['meta_title'] = $data["page_title"];
            $data['product_data'] = $product_data;
            $this->template->write_view("content", "pages/products/listing", $data);
            $this->template->render();
        }
        else
        {
            display_404_page();
        }
    }

    public function buynow($product_url_key)
    {
        echo '<p style="width:100%;margin-top:50px;font-family:sans-serif;font-size:20px;text-align:center;">Loading....</p>';
        $model = new Common_model();
        $product_data = $model->fetchSelectedData("product_id, product_url_long", TABLE_PRODUCTS, array("product_url_key" => $product_url_key));
        if (!empty($product_data))
        {
            if (!isset($this->session->userdata["admin_id"]))
            {
                $product_id = $product_data[0]["product_id"];
                $autorun_helper = new AutorunHelper();
                $autorun_helper->store_product_clicks($product_id);
            }

            redirect($product_data[0]["product_url_long"]);
        }
        else
        {
            display_404_page();
        }
    }

}
