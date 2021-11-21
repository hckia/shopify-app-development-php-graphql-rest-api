<?php
/* 
Everytime you restart your project, you're going to have to create a new ngrok url
Follow these steps... 
open cmd (command prompt)
type/enter  ngrok http 80
go to developers.shopify.com > login > apps > App setup >
Update App URL (keeping cylana)
update install.php and token.php (keeping cylana)
*/

$_API_KEY = '400ec5021987e3f652a913611570bb76';
$_NGROK_URL = 'https://7935-76-87-212-134.ngrok.io';

$shop = $_GET['shop']; # $_GET['shop'] is example.myshopify.com
/* 
https://shopify.dev/api/usage/access-scopes
read_files, write_files

*/ 
$scopes = 'read_products, write_products,read_orders,write_orders, read_script_tags, write_script_tags';
$redirect_uri = $_NGROK_URL . '/cylana/token.php';
$nonce = bin2hex(random_bytes( 12 ));
/*per-user: online, empty: ofline */
$access_mode = 'per-user'; 

// https://{shop}.myshopify.com/admin/oauth/authorize?client_id={api_key}&scope={scopes}&redirect_uri={redirect_uri}&state={nonce}&grant_options[]={access_mode}
$oauth_url = 'https://' . $shop . '/admin/oauth/authorize?client_id=' . $_API_KEY . '&scope=' . $scopes . '&redirect_uri=' . urlencode($redirect_uri) . '&state=' . $nonce . '&grant_options[]=' . $access_mode;
/* when we install at developer.shopify.com it would echo out cylana-development-store.myshopify.com  */
/* echo $shop; */

header("Location: " . $oauth_url);
exit();