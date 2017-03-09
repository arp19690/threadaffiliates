<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template->set_template('admin');
        $this->admin_id = $this->session->userdata["admin_id"];
        if (!$this->session->userdata["admin_id"])
        {
            redirect(base_url_admin("logout"));
        }
    }

    public function index()
    {
        $this->cron_list_products();
    }

    public function cron_list_products($type = NULL)
    {
        $data = array();
        $model = new Common_model();
        $where_cond_arr = array();
        $page_title = "All Products";

        switch ($type)
        {
            case "amazon":
                $where_cond_arr["dc_type"] = "amazon";
                $page_title = "Amazon Products";
                break;
            case "flipkart":
                $where_cond_arr["dc_type"] = "flipkart";
                $page_title = "Flipkart Products";
                break;
        }

        $result = $model->getAllDataFromJoin("dc.*, p.*, ps.ps_views, ps.ps_clicks", TABLE_DAILY_CRON . " as dc", array(TABLE_PRODUCTS . " as p" => "dc.dc_product_unique_code = p.product_unique_code", TABLE_PRODUCTS_STATS . " as ps" => "ps_product_id = p.product_id"), "LEFT", $where_cond_arr);

        $data["data"] = $result;
        $data["page_title"] = $page_title;
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

            // updating the products info
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

    public function cron_edit_product($product_id)
    {
        $model = new Common_model();
        if ($this->input->post())
        {
            $arr = $this->input->post();
            $model->updateData(TABLE_PRODUCTS, array("product_category_id" => $arr["category_id"]), array("product_id" => $product_id));
            $this->session->set_flashdata("success", "Product updated successfully");
            redirect(base_url_admin("products/cron_list_products"));
        }
        else
        {
            $data = array();
            $product_data = $model->fetchSelectedData("*", TABLE_PRODUCTS, array("product_id" => $product_id));
            if (!empty($product_data))
            {
                $custom_model = new Custom_model();
                $categories = $custom_model->create_menu();
                $categories_option_html = create_category_select_option($categories, 0, $product_data[0]["product_category_id"]);
                $data["page_title"] = stripslashes($product_data[0]["product_title"]);
                $data["categories_option_html"] = $categories_option_html;
                $data["product_data"] = $product_data[0];
                $this->template->write_view("content", "products/cron-edit-product", $data);
                $this->template->render();
            }
            else
            {
                display_404_page();
            }
        }
    }

    public function fetch_cron_product_info($dc_id)
    {
        try
        {
            // updating the products info
            $autorun_helper = new AutorunHelper();
            $autorun_helper->auto_populate(array("dc_id" => $dc_id));
            $this->session->set_flashdata("success", "Product info updated successfully");
        } catch (Exception $e)
        {
            $this->session->set_flashdata("error", "Error: " . $e->getMessage());
        }

        redirect(base_url_admin("products/cron_list_products"));
    }

    public function delete_product($product_unique_code)
    {
        $model = new Common_model();
        $model->updateData(TABLE_DAILY_CRON, array("is_deleted" => 1), array("dc_product_unique_code" => $product_unique_code));
        $model->updateData(TABLE_PRODUCTS, array("product_status" => 2), array("product_unique_code" => $product_unique_code));
        $this->session->set_flashdata("success", "Product deleted successfully");
        redirect(base_url_admin("products/cron_list_products"));
    }

}
