<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AliexpressHelper
{

    public function __construct()
    {
        $this->ci = & get_instance();
    }

    public function get_product_info($productId, $fields = NULL, $api_url = ALIEXPRESS_PRODUCT_API_URL)
    {
        if ($fields == NULL)
        {
            $fields = "imageUrl,productUrl,productTitle,volume,salePrice,discount,productId,validTime,allImageUrls";
        }
        $url = $api_url . "?localCurrency=USD&language=en&fields=" . $fields . "&productId=" . $productId;

        // Create cURL
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute the post
        $result = curl_exec($ch);
        // Close the connection
        curl_close($ch);
        // Return the result
        $output_data = json_decode($result, true);
        return $output_data;
    }

    public function get_promotion_link($product_url, $fields = "promotionUrls")
    {
        $api_url = "http://gw.api.alibaba.com/openapi/param2/2/portals.open/api.getPromotionLinks/" . ALIEXPRESS_APP_ID . "?fields=" . $fields . "&trackingId=" . ALIEXPRESS_TRACKING_ID . "&urls=" . $product_url;

        // Create cURL
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute the post
        $result = curl_exec($ch);
        // Close the connection
        curl_close($ch);
        // Return the result
        $output_data = json_decode($result, true);
        return $output_data;
    }

}
