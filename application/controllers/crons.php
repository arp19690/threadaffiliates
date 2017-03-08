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

}
