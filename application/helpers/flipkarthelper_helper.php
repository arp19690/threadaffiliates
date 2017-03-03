<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FlipkartHelper
{

    public function __construct()
    {
        $this->ci = & get_instance();
    }

    public function get_product_info($productId, $api_url = FLIPKART_PRODUCT_API_URL)
    {
        // Create cURL
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $api_url . "?id=" . $productId);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Fk-Affiliate-Id:" . FLIPKART_AFFILIATE_ID, "Fk-Affiliate-Token:" . FLIPKART_API_TOKEN));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        // Execute the post
        $result = curl_exec($ch);
        // Close the connection
        curl_close($ch);
        // Return the result
        $output_data = json_decode($result, true);
        return $output_data;
    }

}
