<?php
include_once("includes/mysql_connect.php"); // DB connections
include_once("includes/shopify.php"); // for our APIs graphql and REST, built in OOP

/**
 * ================================================================================
 *                      CREATE THE VARIABLES:
 *                       - $shopify
 *                       - $parameters
 *  ================================================================================
 */

// instantiate class
$shopify = new Shopify(); 


$parameters = $_GET;

/**
 * ================================================================================
 *                      CHECKING SHOPIFY STORE
 *  ================================================================================
 */

include_once("includes/check_token.php");

/**
 * ================================================================================
 *                      DISPLAY STORE
 *  ================================================================================
 */

// echo print_r($response); // check response

// API https://shopify.dev/api/admin-rest/2021-10/resources/accessscope
//$access_scopes = $shopify->rest_api('/admin/oauth/access_scopes.json', array(), 'GET');

// convert to associative array using json decode
//$response = json_decode($access_scopes['body'], true); 

//echo print_r($access_scopes);


?>

<?php include_once("header.php") ?>

<!-- CONTENT -->
<!-- https://www.uptowncss.com/#gettingstarted - uptown.css requires you to make the main, header, section, and footer tag -->

    <!-- Removing header will remove the gray background of the div alert <header></header> -->
    <section>
        <!-- https://www.uptowncss.com/#alerts -->
        <div class="alert columns twelve"> <!-- columns 1-12. 12 full size --> 
            <dl>
                <dt>
                    <p>Welcome to Cylana Shopify App!</p>
                </dt>
            </dl>
        </div>
    </section>
    <footer></footer>



<?php include_once("footer.php") ?>