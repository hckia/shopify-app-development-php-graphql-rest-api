<?php
// products page appears on STORE.myshopify.com/admin/apps/cylana . it is configured by going to partners.shopifycom > Apps > App Setup > scroll down to embedded app > manage
include_once("includes/mysql_connect.php");
include_once("includes/shopify.php");

$shopify = new Shopify();
$parameters = $_GET;

include_once("includes/check_token.php");

// https://shopify.dev/api/admin-rest/2021-10/resources/product#[get]/admin/api/2021-10/products.json 
$products = $shopify->rest_api('/admin/api/2021-04/products.json', array('limit' => 2), 'GET'); // limit can be up to 250

// set to true for associative array
$products = json_decode($products['body'], true);

// echo print_r($products);

?>

<?php include_once('header.php'); ?>

<!-- Tables: https://www.uptowncss.com/#table -->
<section>
    <table>
        <thead>
            <tr>
                <th colspan="2">Product</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($products as $product) {
                    foreach($product as $key => $value) {
                        // if the count is greater than 0 there's an image, and we're going to grab the first images source
                        // otherwise, provide an empty string.
                        $image = count($value['images']) > 0 ? $value['images'][0]['src'] : ""; 
                        ?> <!-- cannot add html from php -->
                            <tr>
                                <td><img width="35" height="35" src="<?php echo $image; ?>"></td>
                                <!-- https://shopify.dev/api/admin-rest/2021-10/resources/product#resource_object -->
                                <td><?php echo $value['title']; ?></td>
                                <td><?php echo $value['status']; ?></td>
                                <!-- class - https://www.uptowncss.com/#buttons secondary class
                                    icon trash can be found here - https://www.uptowncss.com/#icons
                                -->
                                <td><button class="secondary icon-trash"></button></td>
                            </tr>
                        <?php
                    }
                }
            ?>
        </tbody>
    </table>
</section>


<?php include_once('footer.php'); ?>