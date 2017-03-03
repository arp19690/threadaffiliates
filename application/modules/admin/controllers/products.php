<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template->set_template('admin');
        $this->admin_id = $this->session->userdata("admin_id");
        if (!$this->session->userdata("admin_id"))
        {
            redirect(base_url_admin("logout"));
        }
    }

    public function index()
    {
        $this->cron_list_products();
    }

    public function cron_list_products()
    {
        $data = array();
        $model = new Common_model();
//        $result = $model->fetchSelectedData('*', TABLE_DAILY_CRON);
        $result = $model->getAllDataFromJoin("*", TABLE_DAILY_CRON . " as dc", array(TABLE_PRODUCTS . " as p" => "dc.dc_product_unique_code = p.product_unique_code"), "LEFT");

        $data["data"] = $result;
        $this->template->write_view("content", "products/cron-list-products", $data);
        $this->template->render();
    }

    public function cron_add_product()
    {
        if ($this->input->post())
        {
            $arr = $this->input->post();
            $model = new Common_model();
            $dc_id = $model->insertData(TABLE_DAILY_CRON, array("dc_category_id" => $arr["category_id"], "dc_product_unique_code" => trim($arr["product_code"]), "dc_type" => $arr["dc_type"]));
            $this->fetch_cron_product_info($dc_id);
        }
        else
        {
            $data = array();
            $custom_model = new Custom_model();
            $categories = $custom_model->create_menu();

            $data["categories"] = $categories;
            $this->template->write_view("content", "products/cron-add-product", $data);
            $this->template->render();
        }
    }

    public function fetch_cron_product_info($dc_id)
    {
        $amazon_helper = new AmazonHelper();
                    $amazon_helper->auto_populate();
        $model = new Common_model();
        $data = $model->fetchSelectedData("*", TABLE_DAILY_CRON, array("dc_id" => $dc_id));
        if (!empty($data))
        {
            $arr = $data[0];

            try
            {
                // updating the products info
                if ($arr["dc_type"] == "amazon")
                {
                    $amazon_helper = new AmazonHelper();
                    $amazon_helper->auto_populate(array("dc_id" => $dc_id));
                }
                else if ($arr["dc_type"] == "flipkart")
                {
                    $flipkart_helper = new FlipkartHelper();
                    $flipkart_helper->auto_populate(array("dc_id" => $dc_id));
                }

                $this->session->set_flashdata("success", "Product info updated successfully");
            } catch (Exception $e)
            {
                $this->session->set_flashdata("error", "Error: " . $e->getMessage());
            }
        }
        redirect(base_url_admin("products/cron_list_products"));
    }

}
