<?php
require_once 'Product.php';

$product = new Product();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'create') {
            // Create product
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            if ($product->create($name, $price, $description)) {
                echo "Product added successfully";
            } else {
                echo "Error adding product";
            }
        } elseif ($action == 'update') {
            // Update product
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            if ($product->update($id, $name, $price, $description)) {
                echo "Product updated successfully";
            } else {
                echo "Error updating product";
            }
        } elseif ($action == 'delete') {
            // Delete product
            $id = $_POST['id'];
            if ($product->delete($id)) {
                echo "Product deleted successfully";
            } else {
                echo "Error deleting product";
            }
        }
    }
}
?>
