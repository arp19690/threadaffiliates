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
//        $model = new Common_model();
        $custom_model = new Custom_model();

        $women_apparels_products = $custom_model->get_all_products_for_category(8);
        $home_decor_products = $custom_model->get_all_products_for_category(10);
        $smartphone_products = $custom_model->get_all_products_for_category(12);
        $camera_products = $custom_model->get_all_products_for_category(61);
//        $featured_products = $model->fetchSelectedData("*", TABLE_PRODUCTS, array("product_status" => 1, "product_featured" => 1), "rand()", "rand()", "0,12");

        $page_title = "Home - " . SITE_NAME;
        $data["page_title"] = $page_title;
        $data['meta_title'] = $data["page_title"];
        
        $data['women_apparels_products'] = $women_apparels_products;
        $data['home_decor_products'] = $home_decor_products;
        $data['smartphone_products'] = $smartphone_products;
        $data['camera_products'] = $camera_products;
//        $data['featured_products'] = $featured_products;
        
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
