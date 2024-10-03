<?php
require_once 'Product.php';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $product = new Product();

    // First, get all images associated with the product
    $images = $product->getImagesByProductId($product_id);

    // Delete the product and its images
    $response = $product->delete($product_id, $images);
    echo $response;
}
?>
