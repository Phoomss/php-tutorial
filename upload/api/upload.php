<?php
require_once '../Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = new Product();

    // Process product data
    $data = [
        'product_name' => $_POST['product_name'],
        'product_description' => $_POST['product_description'],
        'price' => $_POST['price']
    ];

    // Process images
    $images = [];
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $image_name = $_FILES['images']['name'][$key];
            $target_dir = "../uploads/product"; // Ensure this directory exists and is writable
            $target_file = $target_dir . basename($image_name);
            
            // Check if the file was uploaded without errors
            if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                if (move_uploaded_file($tmp_name, $target_file)) {
                    $images[] = $target_file; // Store image path
                } else {
                    echo "Error uploading file: " . htmlspecialchars($image_name);
                }
            } else {
                echo "Error with file upload: " . htmlspecialchars($image_name);
            }
        }
    }

    // Create product and images
    $response = $product->create($data, $images);
    echo $response;
}
?>
