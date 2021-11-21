<?php
// products page appears on STORE.myshopify.com/admin/apps/cylana . it is configured by going to partners.shopifycom > Apps > App Setup > scroll down to embedded app > manage
include_once("includes/mysql_connect.php");
include_once("includes/shopify.php");

$shopify = new Shopify();
$parameters = $_GET;

include_once("includes/check_token.php");

$scriptTags = $shopify->rest_api('/admin/api/2021-04/script_tags.json', array(), 'GET');

// set to true for associative array
$scriptTags = json_decode($scriptTags['body'], true);

echo print_r($scriptTags); // will get error if $scoeps in install.php does not have read_script_tags / write_script_tags