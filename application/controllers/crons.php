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
                case "flipkart":
                    $where_cond_arr["dc_type"] = "flipkart";
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

    public function update_short_url_clicks()
    {
        $autorun_helper = new AutorunHelper();
        $autorun_helper->update_all_url_analytics();
        echo "All Short URL analytics have been updated.\n";
    }

    public function update_sitemap()
    {
        $model = new Common_model();

        $xml = '<?xml version = "1.0" encoding = "UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";
        $xml .= '<url><loc>' . base_url() . '</loc><lastmod>' . date('Y-m-d') . 'T' . date('H:i:s') . '+00:00</lastmod><changefreq>daily</changefreq><priority>1.00</priority></url>' . "\n";

        // all the active products
        $product_records = $model->fetchSelectedData('product_url_key', TABLE_PRODUCTS, array('product_status' => '1'));
        foreach ($product_records as $value)
        {
            $product_url = base_url("p/" . $value['product_url_key']);
            $xml .= '<url><loc>' . $product_url . '</loc><lastmod>' . date('Y-m-d') . 'T' . date('H:i:s') . '+00:00</lastmod><changefreq>daily</changefreq><priority>0.90</priority></url>' . "\n";
        }

        $xml .= '</urlset>';
//            prd($xml);

        $file = fopen((APPPATH . '/../sitemap.xml'), 'w');
        fwrite($file, $xml);
        fclose($file);
        echo "Sitemap generated successfully";
        die;
    }

}
