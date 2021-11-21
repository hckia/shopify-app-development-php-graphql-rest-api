<?php 
include_once("includes/mysql_connect.php");
include_once("local_token.php")

$parameters = $_GET;
$hmac = $parameters['hmac'];
// get rid of hmac from $_GET
$parameters = array_diff_key($parameters, array('hmac' => ''));
$shop_url = $parameters['shop'];
/* echo print_r($parameters); */ // removes hmac ^
// Array ( [code] => cb3c84b659f519b6e07827086dc0279c [host] => Y3lsYW5hLWRldmVsb3BtZW50LXN0b3JlLm15c2hvcGlmeS5jb20vYWRtaW4 [shop] => cylana-development-store.myshopify.com [state] => f414945a675fb0ee6c76111f [timestamp] => 1637039729 ) 1

ksort($parameters);

// create new hmac using sha256 encryption, common for passwords.
$new_hmac = hash_hmac('sha256', http_build_query($parameters), $secret_key);

if( hash_equals($hmac, $new_hmac) ) {
    // echo 'This is coming from shopify it\'s legit';
    $access_token_endpoint = 'https://' . $shop_url . '/admin/oauth/access_token';
    $var = array(
        "client_id" => $api_key,
        "client_secret" => $secret_key,
        "code" => $parameters['code']
    );
  
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $access_token_endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, count($var));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($var));
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);

    //echo print_r($response);
/* response from echo...
Array ( [access_token] => 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 [scope] => write_products,write_orders [expires_in] => 86398 [associated_user_scope] => write_products,write_orders [session] => [account_number] => [associated_user] => Array ( [id] => 78822277340 [first_name] => Cylana Development Store [last_name] => Admin [email] => hcyruskia@gmail.com [account_owner] => 1 [locale] => en-US [collaborator] => [email_verified] => ) ) 1
*/
    $query = "INSERT INTO shops (shop_url, access_token, install_date) VALUES ('" . $parameters['shop'] . "','" . $response['access_token'] . "', NOW()) ON DUPLICATE KEY UPDATE access_token='" . $response['access_token'] . "'";
    if($mysql->query($query)) {
        echo "<script>top.window.location = 'https://" . $shop_url . "/admin/apps'</script>";
        die;
    }
} else {
    echo 'This is not coming from Shopify and probably is hacking!';
}