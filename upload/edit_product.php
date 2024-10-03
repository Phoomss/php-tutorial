<?php
require_once 'Product.php';

$product = new Product();

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $product_data = $product->getById($product_id); // Create this method to fetch product details
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <h2>Edit Product</h2>
        <form id="updateForm" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <input type="hidden" name="images_to_delete[]" value="<?php echo $existing_image_url; ?>"> <!-- For each existing image -->
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product_data['product_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_description">Description:</label>
                <textarea class="form-control" id="product_description" name="product_description"><?php echo $product_data['product_description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo $product_data['price']; ?>" required>
            </div>
            <div class="form-group">
                <label for="images">Current Images:</label>
                <div id="currentImages">
                    <?php foreach ($product_data['images'] as $image): ?>
                        <div>
                            <img src="<?php echo htmlspecialchars($image); ?>" style="max-width: 100px; max-height: 100px; margin-right: 5px;" />
                            <input type="checkbox" name="images_to_delete[]" value="<?php echo htmlspecialchars($image); ?>"> Delete
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="new_images">Upload New Images:</label>
                <input type="file" class="form-control" id="new_images" name="new_images[]" multiple accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $("#updateForm").submit(function(e) {
                e.preventDefault(); // Prevent default form submission
                let formData = new FormData(this); // Create FormData object

                $.ajax({
                    url: 'update_product.php', // PHP script to handle the update
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                       window.location.href="index.php"
                    },
                    error: function(xhr, status, error) {
                        console.error(error); // Handle error response
                    }
                });
            });
        });
    </script>
</body>

</html>