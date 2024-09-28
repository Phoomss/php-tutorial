<?php
require_once 'Product.php';
$product = new Product();
$products = $product->read();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Product Management</title>
</head>

<body>
    <h2>Product Management</h2>
    <button id="addProductBtn">Add Product</button>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td>
                        <button class="editBtn" data-id="<?php echo $product['id']; ?>">Edit</button>
                        <button class="deleteBtn" data-id="<?php echo $product['id']; ?>">Delete</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            // Add product
            $('#addProductBtn').click(function() {
                let name = prompt("Enter product name:");
                let price = prompt("Enter product price:");
                let description = prompt("Enter product description:");

                $.ajax({
                    url: 'product_actions.php', // เรียกไปที่ product_actions.php
                    method: 'POST',
                    data: {
                        action: 'create', // ส่ง action ไปด้วยเพื่อระบุว่าเป็นการสร้าง
                        name: name,
                        price: price,
                        description: description
                    },
                    success: function(response) {
                        alert(response);
                        location.reload();
                    }
                });
            });

            // Delete product
            $('.deleteBtn').click(function() {
                let id = $(this).data('id');

                $.ajax({
                    url: 'product_actions.php', // เรียกไปที่ product_actions.php
                    method: 'POST',
                    data: {
                        action: 'delete', // ส่ง action ไปด้วยเพื่อระบุว่าเป็นการลบ
                        id: id
                    },
                    success: function(response) {
                        alert(response);
                        location.reload();
                    }
                });
            });

            // Update product
            $('.editBtn').click(function() {
                let id = $(this).data('id');
                let name = prompt("Enter new product name:");
                let price = prompt("Enter new product price:");
                let description = prompt("Enter new product description:");

                $.ajax({
                    url: 'product_actions.php', // เรียกไปที่ product_actions.php
                    method: 'POST',
                    data: {
                        action: 'update', // ส่ง action ไปด้วยเพื่อระบุว่าเป็นการแก้ไข
                        id: id,
                        name: name,
                        price: price,
                        description: description
                    },
                    success: function(response) {
                        alert(response);
                        location.reload();
                    }
                });
            });
        });
    </script>

</body>

</html>