<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subdomains extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($type = "international")
    {
        switch ($type)
        {
            case "international":
                $this->international();
                break;
        }
    }

    public function international($currency_code = "USD")
    {
        require_once APPPATH . "controllers/index.php";
        $index_controller = new Index();
        $index_controller->index($currency_code);
    }

}
