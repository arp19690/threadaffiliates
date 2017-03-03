<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class URLShortener
{

    // Constructor
    function __construct($key = URL_SHORTENER_API_KEY, $apiURL = URL_SHORTENER_API_URL)
    {
        // Keep the API Url
        $this->apiURL = $apiURL . '?key=' . $key;
    }

    // Shorten a URL
    function shorten($url)
    {
        $url = custom_parse_url($url);
        // Send information along
        $response = $this->send($url);
        // Return the result
        return isset($response['id']) ? $response['id'] : false;
    }

    // Expand a URL
    function expand($url)
    {
        // Send information along
        $response = $this->send($url, false);
        // Return the result
        return isset($response['longUrl']) ? $response['longUrl'] : false;
    }

    // Send information to Google
    function send($url, $shorten = true)
    {
        // Create cURL
        $ch = curl_init();
        // If we're shortening a URL...
        if ($shorten)
        {
            curl_setopt($ch, CURLOPT_URL, $this->apiURL);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("longUrl" => $url)));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        }
        else
        {
            curl_setopt($ch, CURLOPT_URL, $this->apiURL . '&shortUrl=' . $url);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Execute the post
        $result = curl_exec($ch);
        // Close the connection
        curl_close($ch);
        // Return the result
        return json_decode($result, true);
    }

}
