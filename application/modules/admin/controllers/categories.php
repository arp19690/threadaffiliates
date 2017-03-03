<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories extends CI_Controller
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
        $model = new Common_model();
        $result = $model->fetchSelectedData("*", TABLE_CATEGORIES, array("category_parent_id" => NULL));

        $data = array(
            "page_heading" => "All Categories",
            "data" => $result
        );
        $this->template->write_view("content", "categories/list", $data);
        $this->template->render();
    }

    public function list_children($category_id)
    {
        $model = new Common_model();
        $category_info = $model->fetchSelectedData("*", TABLE_CATEGORIES, array("category_id" => $category_id));
        $children = $model->fetchSelectedData("*", TABLE_CATEGORIES, array("category_parent_id" => $category_id));

        $data = array(
            "page_heading" => stripslashes($category_info[0]["category_name"]),
            "data" => $children
        );
        $this->template->write_view("content", "categories/list", $data);
        $this->template->render();
    }

    public function add()
    {
        if ($this->input->post())
        {
            $this->save_category_info($this->input->post());
            $this->session->set_flashdata("success", "Category added successfully");
            redirect(base_url_admin("categories"));
        }
        else
        {
            $custom_model = new Custom_model();
            $categories = $custom_model->create_menu();
            $categories_option_html = create_category_select_option($categories);

            $data = array("categories_option_html" => $categories_option_html, "page_title" => "Add Category");
            $this->template->write_view("content", "categories/add", $data);
            $this->template->render();
        }
    }

    function save_category_info($data, $category_id = NULL)
    {
        $model = new Common_model();
        $data_arr = array(
            "category_name" => addslashes($data["category_name"]),
            "category_url_key" => strtolower(clean_string($data["category_name"])),
            "category_parent_id" => empty($data["parent_category_id"]) ? NULL : $data["parent_category_id"],
        );

        if ($category_id == NULL)
        {
            return $model->insertData(TABLE_CATEGORIES, $data_arr);
        }
        else
        {
            if ($data_arr["category_parent_id"] != $category_id)
            {
                return $model->updateData(TABLE_CATEGORIES, $data_arr, array("category_id" => $category_id));
            }
            else
            {
                $this->session->set_flashdata("error", "Category and it's Parent Category cannot be same");
                return FALSE;
            }
        }
    }

    public function edit($category_id)
    {
        $model = new Common_model();
        if ($this->input->post())
        {
            $this->save_category_info($this->input->post(), $category_id);
            $this->session->set_flashdata("success", "Category updated successfully");
            redirect(base_url_admin("categories"));
        }
        else
        {
            $custom_model = new Custom_model();
            $category_info = $model->fetchSelectedData("*", TABLE_CATEGORIES, array("category_id" => $category_id));
            if (!empty($category_info))
            {
                $categories = $custom_model->create_menu();
                $categories_option_html = create_category_select_option($categories, 0, $category_info[0]["category_parent_id"]);

                $data = array("categories_option_html" => $categories_option_html, "data" => $category_info[0], "page_title" => "Edit Category");
                $this->template->write_view("content", "categories/add", $data);
                $this->template->render();
            }
            else
            {
                display_404_page();
            }
        }
    }

}
