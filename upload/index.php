<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product Images</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .image-preview {
            display: flex;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .image-preview img {
            max-width: 100px;
            max-height: 100px;
            margin-right: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Upload Product Images</h2>
    <form id="uploadForm" enctype="multipart/form-data">
        <div class="form-group">
            <label for="product_name">Product Name:</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required>
        </div>
        <div class="form-group">
            <label for="product_description">Description:</label>
            <textarea class="form-control" id="product_description" name="product_description"></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="images">Upload Images:</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" required>
        </div>
        <div class="image-preview" id="imagePreview"></div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <hr>
    <h2>Existing Products</h2>
    <div id="productsContainer"></div> <!-- Container for displaying products -->
</div>

<script>
$(document).ready(function() {
    // Image preview functionality
    $("#images").change(function() {
        const files = $(this)[0].files;
        $("#imagePreview").empty();
        if (files) {
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = $("<img>").attr("src", event.target.result);
                    $("#imagePreview").append(img);
                }
                reader.readAsDataURL(file);
            }
        }
    });

    // Form submission
    $("#uploadForm").submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: 'upload.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response);
                loadProducts(); // Reload products after successful upload
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Load products function
    function loadProducts() {
        $.ajax({
            url: 'get_all_products.php',
            type: 'GET',
            success: function(data) {
                $("#productsContainer").html(data);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

     // Delete product functionality
     $(document).on('click', '.delete-product', function() {
        const productId = $(this).data('id');
        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                url: 'delete_product.php?product_id=' + productId,
                type: 'GET',
                success: function(response) {
                    alert(response);
                    loadProducts(); // Reload products after deletion
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

    // Edit product functionality
    $(document).on('click', '.edit-product', function() {
        const productId = $(this).data('id');
        window.location.href = 'edit_product.php?product_id=' + productId; // Redirect to edit page
    });;


    // Initial load of products
    loadProducts();
});
</script>
</body>
</html>
