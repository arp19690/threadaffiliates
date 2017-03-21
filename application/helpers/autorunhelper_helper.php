<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AutorunHelper
{

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->database();
        $this->ci->load->model('Common_model');
    }

    public function auto_populate($where_cond_arr = array())
    {
        $model = new Common_model();
        if (empty($where_cond_arr))
        {
            $where_cond_arr = array("is_deleted" => 0, "updated_on <=" => date("Y-m-d H:i:s", time() - (CRON_THRESHOLD_HOURS * 60 * 60)));
        }
        $products_data = $model->fetchSelectedData("dc_id, dc_product_unique_code, dc_category_id, dc_type", TABLE_DAILY_CRON, $where_cond_arr, "updated_on");

        $amazon_helper = new AmazonHelper();
        $flipkart_helper = new FlipkartHelper();

        foreach ($products_data as $value)
        {
            $product_category_id = $value["dc_category_id"];
            $product_unique_code = trim($value["dc_product_unique_code"]);

            if ($value["dc_type"] == "amazon")
            {
                $product_info = $amazon_helper->get_product_info($product_unique_code);
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
                                if (isset($img_value->LargeImage))
                                {
                                    $product_other_images[] = $img_value->LargeImage->URL;
                                }
                            }
                            $product_price_min = $item_details->OfferSummary->LowestNewPrice->Amount / 100;
                            $product_price_max = $item_details->ItemAttributes->ListPrice->Amount / 100;
                            $product_discount_percent = $item_details->Offers->Offer->OfferListing->PercentageSaved;
                            $product_title = $item_details->ItemAttributes->Title;
                            $product_size = $item_details->ItemAttributes->Size;
                            $product_brand = $item_details->ItemAttributes->Brand;
                            $product_color = $item_details->ItemAttributes->Color;
                            $product_url_key = strtolower(get_unique_product_url_key($product_title));
                            $product_wishlist_url = $item_details->ItemLinks->ItemLink[0]->URL;

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
                                "product_images_json" => json_encode(empty($product_other_images) ? array($product_display_image) : array_unique($product_other_images)),
                                "product_url_key" => $product_url_key,
                                "product_wishlist_url" => $product_wishlist_url,
                                "product_status" => "1",
                                "product_type" => "amazon"
                            );

                            // If product exists, then update it else insert a new
                            $is_exists = $model->is_exists("product_id", TABLE_PRODUCTS, array("product_unique_code" => $product_unique_code));
                            if (empty($is_exists))
                            {
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
            }
            else if ($value["dc_type"] == "flipkart")
            {
                $product_info = $flipkart_helper->get_product_info($product_unique_code);
                if (isset($product_info['productBaseInfoV1']))
                {
                    $item_details = $product_info['productBaseInfoV1'];

                    // If products stock availability is greater than 0
                    if ($item_details['inStock'] == TRUE)
                    {
                        $product_url_long = $item_details['productUrl'];
                        $product_description = $item_details['productDescription'];
                        $product_display_image = $item_details['imageUrls']["unknown"];
                        $product_other_images = array();
                        foreach ($item_details['imageUrls'] as $img_key => $img_value)
                        {
                            $product_other_images[] = $img_value;
                        }
                        $product_price_min = $item_details['flipkartSpecialPrice']['amount'];
                        $product_price_max = $item_details['maximumRetailPrice']['amount'];
                        $product_title = $item_details['title'];
                        $product_size = $item_details['attributes']['size'];
                        $product_brand = $item_details['productBrand'];
                        $product_color = $item_details['attributes']['color'];
                        $product_offers = $item_details['offers'];
                        $product_discount_percent = $item_details['discountPercentage'];
                        $product_url_key = strtolower(get_unique_product_url_key($product_title));

                        $insert_arr = array(
                            "product_category_id" => $product_category_id,
                            "product_unique_code" => $product_unique_code,
                            "product_title" => addslashes($product_title),
                            "product_description" => empty($product_description) ? NULL : addslashes($product_description),
                            "product_size" => empty($product_size) ? NULL : addslashes($product_size),
                            "product_brand" => empty($product_brand) ? NULL : addslashes($product_brand),
                            "product_color" => empty($product_color) ? NULL : addslashes($product_color),
                            "product_price_min" => floatval($product_price_min),
                            "product_price_max" => floatval($product_price_max),
                            "product_discount_percent" => floatval($product_discount_percent),
                            "product_url_long" => addslashes($product_url_long),
                            "product_image_url" => addslashes($product_display_image),
                            "product_images_json" => empty($product_other_images) ? NULL : json_encode($product_other_images),
                            "product_offers_json" => empty($product_offers) ? NULL : json_encode($product_offers),
                            "product_url_key" => $product_url_key,
                            "product_status" => "1",
                            "product_type" => "flipkart"
                        );

                        // If product exists, then update it else insert a new
                        $is_exists = $model->is_exists("product_id", TABLE_PRODUCTS, array("product_unique_code" => $product_unique_code));
                        if (empty($is_exists))
                        {
                            $model->insertData(TABLE_PRODUCTS, $insert_arr);
                        }
                        else
                        {
                            $model->updateData(TABLE_PRODUCTS, $insert_arr, array("product_unique_code" => $product_unique_code, "product_type" => "flipkart"));
                        }

                        // now updating the daily cron table
                        $model->updateData(TABLE_DAILY_CRON, array("updated_on" => date("Y-m-d H:i:s")), array("dc_id" => $value["dc_id"]));
                    }
                    else
                    {
                        $this->ci->session->set_flashdata("warning", "This product is currently Out of Stock");
                    }
                }
            }

//            Adding a sleep of 2 seconds
            sleep(2);
        }
        return TRUE;
    }

    public function find_blank_images()
    {
        $model = new Common_model();
        $data = $model->fetchSelectedData("product_id, product_images_json", TABLE_PRODUCTS, array("product_image_url" => ""));
        foreach ($data as $value)
        {
            $data_arr = array("product_status" => "0");
            $product_images_json = json_decode($value["product_images_json"]);
            if (!empty($product_images_json))
            {
                if (!empty($product_images_json[0]))
                {
                    $data_arr = array("product_image_url" => stripslashes($product_images_json[0]), "product_status" => "1");
                }
            }
            $model->updateData(TABLE_PRODUCTS, $data_arr, array("product_id" => $value["product_id"]));
        }
        echo "Successfully disabled products with blank images.\n";
    }

    public function find_blank_descriptions()
    {
        $amazon_helper = new AmazonHelper();
        $model = new Common_model();
        $data = $model->fetchSelectedData("product_id, product_unique_code", TABLE_PRODUCTS, array("product_description" => NULL));
        foreach ($data as $value)
        {
            $description = addslashes($amazon_helper->get_product_description($value["product_unique_code"]));
            $model->updateData(TABLE_PRODUCTS, array("product_description" => $description), array("product_id" => $value["product_id"], "product_unique_code" => $value["product_unique_code"]));
        }
        echo "Successfully added descriptions for products.\n";
    }

    public function store_product_views($product_id)
    {
        $model = new Common_model();
        $is_exists = $model->fetchSelectedData("ps_id, ps_views", TABLE_PRODUCTS_STATS, array("ps_product_id" => $product_id));
        if (empty($is_exists))
        {
            $model->insertData(TABLE_PRODUCTS_STATS, array("ps_product_id" => $product_id, "ps_views" => "1"));
        }
        else
        {
            $model->updateData(TABLE_PRODUCTS_STATS, array("ps_views" => $is_exists[0]["ps_views"] + 1), array("ps_id" => $is_exists[0]["ps_id"]));
        }
        return TRUE;
    }

    public function store_product_clicks($product_id, $clicks)
    {
        $model = new Common_model();
        $is_exists = $model->fetchSelectedData("ps_id", TABLE_PRODUCTS_STATS, array("ps_product_id" => $product_id));
        if (empty($is_exists))
        {
            $model->insertData(TABLE_PRODUCTS_STATS, array("ps_product_id" => $product_id, "ps_clicks" => $clicks));
        }
        else
        {
            $model->updateData(TABLE_PRODUCTS_STATS, array("ps_clicks" => $clicks), array("ps_product_id" => $product_id, "ps_id" => $is_exists[0]["ps_id"]));
        }
        return TRUE;
    }

}
