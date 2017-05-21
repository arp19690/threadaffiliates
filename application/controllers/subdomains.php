<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subdomains extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($type = "usa")
    {
        switch ($type)
        {
            case "usa":
                $this->usa();
                break;
        }
    }

    public function usa($currency_code = "USD")
    {
        require_once APPPATH . "controllers/index.php";
        $index_controller = new Index();
        $index_controller->index($currency_code);
    }

}
