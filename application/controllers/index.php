<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = array();
        $model = new Common_model();
        $custom_model = new Custom_model();

        $home_decor_products = $custom_model->get_all_products_for_category(10);
        $most_viewed = $model->getAllDataFromJoin("p.*", TABLE_PRODUCTS . " as p", array(TABLE_PRODUCTS_STATS . " as ps" => "p.product_id = ps.ps_product_id"), "INNER", array("product_status" => 1), "ps_views, ps_clicks", "DESC", "0,12");
        $featured_products = $model->fetchSelectedData("*", TABLE_PRODUCTS, array("product_status" => 1, "product_featured" => 1), "rand()", "rand()", "0,12");

        $page_title = "Home - " . SITE_NAME;
        $data["page_title"] = $page_title;
        $data['meta_title'] = $data["page_title"];
        $data['home_decor_products'] = $home_decor_products;
        $data['most_viewed'] = $most_viewed;
        $data['featured_products'] = $featured_products;
        $this->template->write_view("content", "pages/index/index", $data);
        $this->template->render();
    }

    public function pagenotfound()
    {
        $data = array();

        $data['meta_title'] = 'Page Not Found - ' . SITE_NAME;
        $this->template->write_view("content", "pages/index/page-not-found", $data);
        $this->template->render();
    }

}
