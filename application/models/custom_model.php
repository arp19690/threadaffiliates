<?php

class Custom_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        // Load DB here
        $this->load->database();
    }

    public function get_all_products_for_category($category_id, $orderby = "rand()", $orderby_type = "rand()", $limit = "0,12")
    {
        $model = new Common_model();
        $cat_cat_id_arr = $this->get_all_lowest_level_category_ids($category_id);
        $cat_where_cond = array("product_status" => 1);
        foreach ($cat_cat_id_arr as $hdvalue)
        {
            $cat_where_cond["category_id"] = $hdvalue;
        }
        $cat_products = $model->getAllDataFromJoin("p.*", TABLE_PRODUCTS . " as p", array(TABLE_CATEGORIES . " as c" => "c.category_id = p.product_category_id"), "INNER", $cat_where_cond, $orderby, $orderby_type, $limit);
        return $cat_products;
    }

    public function get_parent_category_info($parent_category_id, $output_data)
    {
        $data = $this->get_menu_data(array("category_id" => $parent_category_id), "category_id");
        if (!empty($data))
        {
            $output_data[] = $data[0];
            $output_data = $this->get_parent_category_info($data[0]["category_parent_id"], $output_data);
        }
        return $output_data;
    }

    public function get_product_info($product_id)
    {
        $tmp_data = array();
        $model = new Common_model();
        $product_info = $model->fetchSelectedData("product_category_id, product_title", TABLE_PRODUCTS, array("product_id" => $product_id));
        if (!empty($product_info))
        {
            $menu_data = $this->get_menu_data(array("category_status" => 1, "category_id" => $product_info[0]["product_category_id"]), "category_id");
            if (!empty($menu_data))
            {
                if ($menu_data[0]["category_parent_id"] != NULL)
                {
                    $tmp_data = array_reverse($this->get_parent_category_info($menu_data[0]["category_parent_id"], array()));
                }
                $tmp_data[] = $menu_data[0];
            }
            $tmp_data[] = $product_info[0];
        }
        return $tmp_data;
    }

    public function create_breadcrumb($id, $type = "product")
    {
        switch ($type)
        {
            case "product":
                $data = $this->get_product_info($id);
                break;
            case "category":
                $data = array_reverse($this->get_parent_category_info($id, array()));
                break;
            default :
                $data = $this->get_product_info($id);
                break;
        }

        $str = "";
        if (!empty($data))
        {
            $str = '<div class="breadcrumbs-section">
                        <div class="breadcrumbs-block">
                            <div class="container">
                                <div class="breadcrumbs-content">
                                    <nav class="breadcrumbs" role="navigation" aria-label="breadcrumbs">
                                        <a href="' . base_url() . '" title="Back to the Homepage">Home</a>';

            $cat_arr = array();
            foreach ($data as $value)
            {
                $str.='<span aria-hidden="true" class="breadcrumb__sep">/</span>';
                if (isset($value["product_title"]))
                {
                    $str.='<span>' . stripslashes($value["product_title"]) . '</span>';
                }
                else
                {
                    $cat_arr[] = $value["category_url_key"];
                    $str.='<a href="' . base_url("c/" . implode("/", $cat_arr)) . '" title="">' . stripslashes($value["category_name"]) . '</a>';
                }
            }
            $str.='</nav></div></div></div></div>';
        }
        return $str;
    }

    public function create_menu($where_cond = array("category_parent_id" => NULL, "category_status" => 1), $order_by = "category_order_id")
    {
        $menu_data = $this->get_menu_data($where_cond, $order_by);
        foreach ($menu_data as $key => $value)
        {
            $menu_data[$key]["children"] = $this->create_menu(array("category_parent_id" => $value["category_id"], "category_status" => 1), $order_by);
        }
        return $menu_data;
    }

    public function traverse($arr)
    {
        $output_data = [];
        foreach ($arr as $tmp_value)
        {
            if (!empty($tmp_value["children"]))
            {
                $output_data = array_merge($output_data, $this->traverse($tmp_value["children"]));
            }
            else
            {
                $output_data[] = $tmp_value["category_id"];
            }
        }
        return $output_data;
    }

    public function get_all_lowest_level_category_ids($category_id)
    {
        $cat_id_arr = array($category_id);
        $tmp_data = $this->create_menu(array("category_id" => $category_id, "category_status" => 1));
        foreach ($tmp_data as $tmp_value)
        {
            if (!empty($tmp_value["children"]))
            {
                $cat_id_arr = $this->traverse($tmp_value["children"]);
            }
        }
        return $cat_id_arr;
    }

    public function get_menu_data($where_cond, $order_by)
    {
        $model = new Common_model();
        $menu_data = $model->fetchSelectedData("category_id, category_name, category_url_key, category_parent_id", TABLE_CATEGORIES, $where_cond, $order_by);
        return $menu_data;
    }

    public function get_products_list($fields = "p.*", $where_str = "product_status = 1", $order_by = "rand()", $limit = NULL)
    {
        $sql = "SELECT " . $fields . " FROM " . TABLE_PRODUCTS . " as p "
                . "INNER JOIN " . TABLE_CATEGORIES . " as c on c.category_id = p.product_category_id "
                . "WHERE " . $where_str . " ORDER BY " . $order_by;

        if ($limit != NULL)
        {
            $sql.=" LIMIT " . $limit;
        }
        $records = $this->db->query($sql)->result_array();
        return $records;
    }

    public function get_total_products_count($where_str)
    {
        $sql = "SELECT count(p.product_id) as totalcount FROM " . TABLE_PRODUCTS . " as p "
                . "INNER JOIN " . TABLE_CATEGORIES . " as c on c.category_id = p.product_category_id "
                . "WHERE " . $where_str;
        $records = $this->db->query($sql)->result_array();
        return $records[0]["totalcount"];
    }

    public function search_keyword($keyword)
    {
        $keyword = strtolower($keyword);
        $sql = "SELECT p.* FROM " . TABLE_PRODUCTS . " as p "
                . "RIGHT JOIN " . TABLE_CATEGORIES . " as c on c.category_id = p.product_category_id "
                . "WHERE LOWER(product_title) LIKE ('%" . $keyword . "%') "
                . "OR LOWER(product_description) LIKE ('%" . $keyword . "%') "
                . "OR LOWER(product_size) LIKE ('%" . $keyword . "%') "
                . "OR LOWER(product_color) LIKE ('%" . $keyword . "%') "
                . "OR LOWER(product_brand) LIKE ('%" . $keyword . "%') "
                . "OR LOWER(category_name) LIKE ('%" . $keyword . "%') "
                . "OR LOWER(product_unique_code) LIKE ('%" . $keyword . "%') "
        ;
        $records = $this->db->query($sql)->result_array();
        return $records;
    }

}
