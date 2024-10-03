<?php
require_once 'Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $price = $_POST['price'];
    $images_to_delete = isset($_POST['images_to_delete']) ? $_POST['images_to_delete'] : [];
    $new_images = $_FILES['new_images']; // Get the new images uploaded

    $product = new Product();

    // Update product details, including handling image deletions and uploads
    $response = $product->update($product_id, $product_name, $product_description, $price, $images_to_delete, $new_images);

    echo $response; // Send response back to the client
}
?>
