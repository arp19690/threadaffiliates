<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crons extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function fetch($type = "flipkart")
    {
        $autorun_helper = new AutorunHelper();
        try
        {
            $where_cond_arr = array("is_deleted" => 0, "updated_on <=" => date("Y-m-d H:i:s", time() - (CRON_THRESHOLD_HOURS * 60 * 60)));
            switch ($type)
            {
                case "amazon":
                    $where_cond_arr["dc_type"] = "amazon";
                    break;
                case "amazon_usa":
                    $where_cond_arr["dc_type"] = "amazon_usa";
                    break;
                case "flipkart":
                    $where_cond_arr["dc_type"] = "flipkart";
                    break;
                case "aliexpress":
                    $where_cond_arr["dc_type"] = "aliexpress";
                    break;
            }
            $autorun_helper->auto_populate($where_cond_arr);
            echo "Product details fetched and updated successfully.\n";
        } catch (Exception $e)
        {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }

        // now finding blank images and disabling the product
        $autorun_helper->find_blank_images();
    }

    public function update_sitemap()
    {
        $model = new Common_model();

        $xml = '<?xml version = "1.0" encoding = "UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";
        $xml .= '<url><loc>' . base_url() . '</loc><lastmod>' . date('Y-m-d') . 'T' . date('H:i:s') . '+00:00</lastmod><changefreq>daily</changefreq><priority>1.00</priority></url>' . "\n";

        // all the active categories
        $category_records = $model->fetchSelectedData("category_id, category_url_key", TABLE_CATEGORIES, array("category_status" => 1, "category_parent_id" => NULL));
        foreach ($category_records as $cvalue)
        {
            $c_url = base_url("c/" . $cvalue["category_url_key"]);
            $xml .= '<url><loc>' . $c_url . '</loc><lastmod>' . date('Y-m-d') . 'T' . date('H:i:s') . '+00:00</lastmod><changefreq>daily</changefreq><priority>0.90</priority></url>' . "\n";

            $child_data = $model->fetchSelectedData("category_id, category_url_key", TABLE_CATEGORIES, array("category_status" => 1, "category_parent_id" => $cvalue["category_id"]));
            foreach ($child_data as $cdvalue)
            {
                $cd_url = base_url("c/" . $cvalue["category_url_key"] . "/" . $cdvalue["category_url_key"]);
                $xml .= '<url><loc>' . $cd_url . '</loc><lastmod>' . date('Y-m-d') . 'T' . date('H:i:s') . '+00:00</lastmod><changefreq>daily</changefreq><priority>0.90</priority></url>' . "\n";

                $child2_data = $model->fetchSelectedData("category_id, category_url_key", TABLE_CATEGORIES, array("category_status" => 1, "category_parent_id" => $cdvalue["category_id"]));
                foreach ($child2_data as $c2dvalue)
                {
                    $c2d_url = base_url("c/" . $cvalue["category_url_key"] . "/" . $cdvalue["category_url_key"] . "/" . $c2dvalue["category_url_key"]);
                    $xml .= '<url><loc>' . $c2d_url . '</loc><lastmod>' . date('Y-m-d') . 'T' . date('H:i:s') . '+00:00</lastmod><changefreq>daily</changefreq><priority>0.90</priority></url>' . "\n";

                    $child3_data = $model->fetchSelectedData("category_id, category_url_key", TABLE_CATEGORIES, array("category_status" => 1, "category_parent_id" => $c2dvalue["category_id"]));
                    foreach ($child3_data as $c3dvalue)
                    {
                        $c3d_url = base_url("c/" . $cvalue["category_url_key"] . "/" . $cdvalue["category_url_key"] . "/" . $c2dvalue["category_url_key"] . "/" . $c3dvalue["category_url_key"]);
                        $xml .= '<url><loc>' . $c3d_url . '</loc><lastmod>' . date('Y-m-d') . 'T' . date('H:i:s') . '+00:00</lastmod><changefreq>daily</changefreq><priority>0.90</priority></url>' . "\n";
                    }
                }
            }
        }

        // all the active products
        $product_records = $model->fetchSelectedData('product_url_key', TABLE_PRODUCTS, array('product_status' => '1', 'product_currency' => CURRENCY_CODE));
        foreach ($product_records as $value)
        {
            $product_url = base_url("p/" . $value['product_url_key']);
            $xml .= '<url><loc>' . $product_url . '</loc><lastmod>' . date('Y-m-d') . 'T' . date('H:i:s') . '+00:00</lastmod><changefreq>daily</changefreq><priority>0.90</priority></url>' . "\n";
        }

        $xml .= '</urlset>';
//        prd($xml);

        $sitemap_filename = 'sitemap.xml';
        if (CURRENCY_CODE == "USD")
        {
            $sitemap_filename = 'usa-sitemap.xml';
        }
        $file = fopen((APPPATH . '/../' . $sitemap_filename), 'w');
        fwrite($file, $xml);
        fclose($file);
        echo "Sitemap generated successfully";
        die;
    }

    public function update_product_descriptions()
    {
        $autorun_helper = new AutorunHelper();
        $autorun_helper->find_blank_descriptions();
    }

}
