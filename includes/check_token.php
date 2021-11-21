<?php

// Use Query and SELECT statement to get shop info
$query = "SELECT * FROM shops WHERE shop_url='" . $parameters['shop'] . "' LIMIT 1"; // get shop data from DB
$result = $mysql->query($query);


//Check if # of rows is < 1, if it's less than 1, then that means we need to redirect the merchants,
// to the installation page.

if( $result->num_rows < 1) { // if no shop data install the app
    header("Location: install.php?shop=" . $_GET['shop']);
    exit();  
}


//Else use fetch assoc function to get the records

$store_data = $result->fetch_assoc();

// echo print_r($store_data); 
// set URL and access token for API
$shopify->set_url($parameters['shop']); // set url obtained from $_GET variable. 
$shopify->set_token($store_data['access_token']); // set token

// echo $shopify->get_url();
// echo '<br />';
// echo $shopify->get_token();

// API
// $products = $shopify->rest_api('/admin/api/2021-04/products.json', array(), 'GET'); // endpoint to get the products from shopify. defaults to 50, can set limit to 250
$shop = $shopify->rest_api('/admin/api/2021-04/shop.json', array(), 'GET');

// echo print_r($products['body']); // print out products to see.
// convert to associative array using json decode
$response = json_decode($shop['body'], true); 

if(array_key_exists('errors', $response)) {
    // echo '<br />';
    // echo 'Sorry, but I think there\'s an error in your API call. Specifically this: ' . $response['errors'];
    header("Location: install.php?shop=" . $_GET['shop']);
    exit();  
}