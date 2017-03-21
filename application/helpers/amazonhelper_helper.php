<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AmazonHelper
{

    public function __construct()
    {
        $this->ci = & get_instance();
        require APPPATH . 'libraries/affiliates/amazon/lib/AmazonECS.class.php';
        $amazonEcs = new AmazonECS(AWS_API_KEY, AWS_API_SECRET_KEY, 'in', AWS_ASSOCIATE_TAG);
        $amazonEcs->associateTag(AWS_ASSOCIATE_TAG);
        $this->amazonEcs = $amazonEcs;
    }

    public function get_product_info($product_asin)
    {
        $response = $this->amazonEcs->responseGroup('Large')->optionalParameters(array('Condition' => 'New'))->lookup($product_asin);
        return $response;
    }

    public function get_product_description($product_unique_code)
    {
        require_once(APPPATH . "libraries/simple_html_dom.php");
        $html = new simple_html_dom();
        $content = file_get_contents("http://www.amazon.in/dp/" . $product_unique_code);
        $html->load($content);

        $element = $html->find("div#descriptionAndDetails #productDescription", 0);
        $description = trim($element->innertext);
        return $description;
    }

}
