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
        try
        {
            $autorun_helper = new AutorunHelper();
            switch ($type)
            {
                case "amazon":
                    $autorun_helper->auto_populate(array("dc_type" => "amazon"));
                    break;

                case "flipkart":
                    $autorun_helper->auto_populate(array("dc_type" => "flipkart"));
                    break;
            }
            echo 'done';
        } catch (Exception $e)
        {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function update_sitemap()
    {
        $model = new Common_model();

        $xml = '<?xml version = "1.0" encoding = "UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";
        $xml .= '<url><loc>' . base_url() . '</loc><lastmod>' . date('Y-m-d') . 'T' . date('H:i:s') . '+00:00</lastmod><changefreq>daily</changefreq><priority>1.00</priority></url>' . "\n";

        // all the active products
        $product_records = $model->fetchSelectedData('product_url_key', TABLE_PRODUCTS, array('product_status' => '1'));
        foreach ($product_records as $pValue)
        {
            $product_url = getTripUrl($pValue['product_url_key']);
            $xml .= '<url><loc>' . $product_url . '</loc><lastmod>' . date('Y-m-d') . 'T' . date('H:i:s') . '+00:00</lastmod><changefreq>daily</changefreq><priority>0.85</priority></url>' . "\n";
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
