<?php
require_once 'Product.php';

$product = new Product();
$products = $product->getAll();

echo '<div class="container">';
echo '<h2>All Products</h2>';
echo '<table class="table table-bordered">';
echo '<thead>';
echo '<tr>';
echo '<th>Product Name</th>';
echo '<th>Description</th>';
echo '<th>Price</th>';
echo '<th>Images</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
foreach ($products as $product) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($product['product_name']) . '</td>';
    echo '<td>' . htmlspecialchars($product['product_description']) . '</td>';
    echo '<td>' . htmlspecialchars(number_format($product['price'], 2)) . '</td>';
    echo '<td>';
    foreach ($product['images'] as $image) {
        echo '<img src="' . htmlspecialchars($image) . '" style="max-width: 100px; max-height: 100px; margin-right: 5px;" />';
    }
    echo '</td>';
    echo '<td>';
    echo '<button class="btn btn-warning edit-product" data-id="' . $product['product_id'] . '">Edit</button>';
    echo '<button class="btn btn-danger delete-product" data-id="' . $product['product_id'] . '">Delete</button>';
    echo '</td>';

    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
echo '</div>';
