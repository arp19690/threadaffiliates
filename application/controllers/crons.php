<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crons extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function fetch($type=NULL)
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

}
