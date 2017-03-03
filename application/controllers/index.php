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

        $best_sellers = $model->fetchSelectedData("*", TABLE_PRODUCTS, array("product_status" => 1), "product_id", "rand()", "0,12");
        $featured_products = $model->fetchSelectedData("*", TABLE_PRODUCTS, array("product_status" => 1, "product_featured" => 1), "product_id", "rand()", "0,12");

        $page_title = "Home - " . SITE_NAME;
        $data["page_title"] = $page_title;
        $data['meta_title'] = $data["page_title"];
        $data['best_sellers'] = $best_sellers;
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

    public function runcron()
    {
        try
        {
            $amzon_helper = new AmazonHelper();
            $amzon_helper->auto_populate();

            $flipkart_helper = new FlipkartHelper();
            $flipkart_helper->auto_populate();
            echo 'done';
        } catch (Exception $e)
        {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

}
