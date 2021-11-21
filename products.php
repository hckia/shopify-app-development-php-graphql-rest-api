<?php
// products page appears on STORE.myshopify.com/admin/apps/cylana . it is configured by going to partners.shopifycom > Apps > App Setup > scroll down to embedded app > manage
include_once("includes/mysql_connect.php");
include_once("includes/shopify.php");

$shopify = new Shopify();
$parameters = $_GET;

include_once("includes/check_token.php");


if($_SERVER['REQUEST_METHOD'] == "POST" ) {
    // create: https://shopify.dev/api/admin-rest/2021-10/resources/product#[post]/admin/api/2021-10/products.json
    // consider the Product properties - https://shopify.dev/api/admin-rest/2021-10/resources/product#resource_object
    // we can set all of these above (except the read-only, those are in the response)
    if(isset($_POST['product_title']) && isset($_POST['product_body_html']) && $_POST['action_type'] == 'create_product') {
        $product_data = array(
            "product" => array(
                "title" => $_POST['product_title'],
                "body_html" => $_POST['product_body_html']
            )
        );
        $create_product = $shopify->rest_api('/admin/api/2021-10/products.json', $product_data, 'POST'); // limit can be up to 250 arr
        // set to true for associative array
        $create_product = json_decode($create_product['body'], true);
        echo print_r($create_product);
    }
    // delete https://shopify.dev/api/admin-rest/2021-10/resources/product#[delete]/admin/api/2021-10/products/{product_id}.json
    if(isset($_POST['delete_id']) && $_POST['action_type'] == 'delete') {
        $delete = $shopify->rest_api('/admin/api/2021-10/products/' . $_POST['delete_id'] . '.json', array(), 'DELETE'); // limit can be up to 250 arr
        // set to true for associative array
        $delete = json_decode($delete['body'], true);
    }
    // update https://shopify.dev/api/admin-rest/2021-10/resources/product#[put]/admin/api/2021-10/products/{product_id}.json
    if(isset($_POST['update_id']) && $_POST['action_type'] == 'update') {
        $update_data = array(
            "product" => array(
                "id"=> $_POST['update_id'],
                "title"=> $_POST['update_name']
            )
            );
        $update = $shopify->rest_api('/admin/api/2021-10/products/' . $_POST['update_id'] . '.json', $update_data, 'PUT'); // limit can be up to 250 arr
        // set to true for associative array
        $update = json_decode($update['body'], true);
        echo print_r($update);
    }
}

// https://shopify.dev/api/admin-rest/2021-10/resources/product#[get]/admin/api/2021-10/products.json 
$products = $shopify->rest_api('/admin/api/2021-04/products.json', array(), 'GET'); // limit can be up to 250 array('limit' => 250)

// set to true for associative array
$products = json_decode($products['body'], true);

// echo print_r($products);

?>

<?php include_once('header.php'); ?>


<section>
    <!-- https://www.uptowncss.com/#layouts -->
    <aside>
        <h2>Create new product</h2>
        <p>Fill out the following form and click the submit button to create a new product</p>
    </aside>
    <article>
        <div class="card">
            <form action="" method="post">
                <input type="hidden" name="action_type" value="create_product">
                <div class="row">
                    <label for="productTitle">Title</label>
                    <input type="text" name="product_title" id="producTitle">
                </div>
                <div class="row">
                    <label for="productDescription">Description</label>
                    <textarea name="product_body_html" id="producDescription"></textarea>
                </div>
                <div class="row">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </article>
</section>

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
                                <td>
                                    <!-- https://www.uptowncss.com/#formfields -->
                                    <form action="" method="POST" class="row side-elements">
                                        <!-- https://shopify.dev/api/admin-rest/2021-10/resources/product#[put]/admin/api/2021-10/products/{product_id}.json -->
                                        <input type="hidden" name="update_id" value="<?php echo $value['id']; ?>">
                                        <input type="text" name="update_name" value="<?php echo $value['title']; ?>">
                                        <input type="hidden" name="action_type" value="update"> <!-- differentiate between update and delete -->
                                        <button type="submit" class="secondary icon-checkmark"></button>
                                    </form>
                                </td>
                                <!-- https://shopify.dev/api/admin-rest/2021-10/resources/product#resource_object -->
                                <td><?php echo $value['title']; ?></td>
                                <td><?php echo $value['status']; ?></td>
                                <!-- class - https://www.uptowncss.com/#buttons secondary class
                                    icon trash can be found here - https://www.uptowncss.com/#icons
                                -->
                                <td>
                                    <form action="" method="POST">
                                        <!-- Delete API: https://shopify.dev/api/admin-rest/2021-10/resources/product#[delete]/admin/api/2021-10/products/{product_id}.json -->
                                        <input type="hidden" name="delete_id" value="<?php echo $value['id']; ?>"> <!-- need input, but can be hidden -->
                                        <input type="hidden" name="action_type" value="delete"> <!-- differentiate between update and delete -->
                                        <button type="submit" class="secondary icon-trash"></button> <!-- button must be set to submit in this case (non ajax) -->
                                    </form> <!-- action empty so it stays on the same page, but method must be POST to work -->
                                    </td>
                            </tr>
                        <?php
                    }
                }
            ?>
        </tbody>
    </table>
</section>


<?php include_once('footer.php'); ?>