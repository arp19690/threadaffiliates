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
        $this->ci->load->database();
        $this->ci->load->model('Common_model');
        $this->ci->load->helper("URLShortener");
        $this->URLShortener = new URLShortener();

        require APPPATH . 'libraries/affiliates/amazon/lib/AmazonECS.class.php';
        $amazonEcs = new AmazonECS(AWS_API_KEY, AWS_API_SECRET_KEY, 'in', AWS_ASSOCIATE_TAG);
        $amazonEcs->associateTag(AWS_ASSOCIATE_TAG);
        $this->amazon_ecs = $amazonEcs;
    }

    public function auto_populate($extra_where_arr = array())
    {
        $model = new Common_model();
        $where_cond_arr = array("dc_type" => "amazon", "updated_on <=" => date("Y-m-d H:i:s", time() - (CRON_THRESHOLD_HOURS * 60 * 60)));
        $where_cond_arr = array_merge($where_cond_arr, $extra_where_arr);
        $amazon_asins = $model->fetchSelectedData("dc_id, dc_product_unique_code, dc_category_id", TABLE_DAILY_CRON, $where_cond_arr, "updated_on");
        foreach ($amazon_asins as $value)
        {
            $product_category_id = $value["dc_category_id"];
            $product_unique_code = trim($value["dc_product_unique_code"]);
            $product_info = $this->get_product_info($product_unique_code);
            if (isset($product_info->Items))
            {
                if (isset($product_info->Items->Item))
                {
                    $item_details = $product_info->Items->Item;

                    // If products stock availability is greater than 0
                    if ($item_details->OfferSummary->TotalNew > 0)
                    {
                        $product_url_long = $item_details->DetailPageURL;
                        $product_display_image = $item_details->LargeImage->URL;
                        $product_other_images = array();
                        foreach ($item_details->ImageSets->ImageSet as $img_value)
                        {
                            $product_other_images[] = $img_value->LargeImage->URL;
                        }
                        $product_price_min = $item_details->OfferSummary->LowestNewPrice->Amount / 100;
                        $product_price_max = $item_details->ItemAttributes->ListPrice->Amount / 100;
                        $product_discount_percent = $item_details->Offers->Offer->OfferListing->PercentageSaved;
                        $product_title = $item_details->ItemAttributes->Title;
                        $product_size = $item_details->ItemAttributes->Size;
                        $product_brand = $item_details->ItemAttributes->Brand;
                        $product_color = $item_details->ItemAttributes->Color;
                        $product_url_key = strtolower(get_unique_product_url_key($product_title));

                        $insert_arr = array(
                            "product_category_id" => $product_category_id,
                            "product_unique_code" => $product_unique_code,
                            "product_title" => addslashes($product_title),
                            "product_size" => empty($product_size) ? NULL : addslashes($product_size),
                            "product_brand" => empty($product_brand) ? NULL : addslashes($product_brand),
                            "product_color" => empty($product_color) ? NULL : addslashes($product_color),
                            "product_price_min" => floatval($product_price_min),
                            "product_price_max" => floatval($product_price_max),
                            "product_discount_percent" => floatval($product_discount_percent),
                            "product_url_long" => addslashes($product_url_long),
                            "product_image_url" => addslashes($product_display_image),
                            "product_images_json" => empty($product_other_images) ? NULL : json_encode($product_other_images),
                            "product_url_key" => $product_url_key,
                            "product_type" => "amazon"
                        );

                        // If product exists, then update it else insert a new
                        $is_exists = $model->is_exists("product_id", TABLE_PRODUCTS, array("product_unique_code" => $product_unique_code));
                        if (empty($is_exists))
                        {
                            // Now let's shorten the URL
                            $shortened_url = $this->URLShortener->shorten($product_url_long);
                            $insert_arr["product_url_short"] = $shortened_url;

                            $model->insertData(TABLE_PRODUCTS, $insert_arr);
                        }
                        else
                        {
                            $model->updateData(TABLE_PRODUCTS, $insert_arr, array("product_unique_code" => $product_unique_code, "product_type" => "amazon"));
                        }

                        // now updating the daily cron table
                        $model->updateData(TABLE_DAILY_CRON, array("updated_on" => date("Y-m-d H:i:s")), array("dc_id" => $value["dc_id"]));
                    }
                    else
                    {
                        $this->ci->session->set_flashdata("warning", "This product is currently Out of Stock");
                    }
                }
                else
                {
                    $this->ci->session->set_flashdata("error", $product_info->Items->Request->Errors->Error->Message);
                }
            }
            
//            Adding a sleep of 2 seconds
            sleep(2);
        }
        return TRUE;
    }

    public function get_product_info($product_asin)
    {
        $response = $this->amazon_ecs->responseGroup('Large')->optionalParameters(array('Condition' => 'New'))->lookup($product_asin);
        return $response;
    }

}
