<?php
require_once 'db_connection.php';

class Product {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conn;
    }

    public function create($data, $images) {
        try {
            $this->conn->beginTransaction();
    
            // Insert product data
            $stmt = $this->conn->prepare("INSERT INTO products (product_name, product_description, price) VALUES (:product_name, :product_description, :price)");
            $stmt->bindParam(':product_name', $data['product_name']);
            $stmt->bindParam(':product_description', $data['product_description']);
            $stmt->bindParam(':price', $data['price']);
            $stmt->execute();
    
            $product_id = $this->conn->lastInsertId(); // Get the last inserted product ID
    
            // Insert image data
            foreach ($images as $image_url) {
                $stmt = $this->conn->prepare("INSERT INTO product_images (product_id, image_url) VALUES (:product_id, :image_url)");
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':image_url', $image_url);
                $stmt->execute();
            }
    
            $this->conn->commit();
            return "Product created successfully with ID: " . $product_id;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return "Error: " . $e->getMessage();
        }
    }
    

    public function getAll() {
        try {
            $stmt = $this->conn->prepare("
                SELECT p.product_id, p.product_name, p.product_description, p.price, pi.image_url 
                FROM products p 
                LEFT JOIN product_images pi ON p.product_id = pi.product_id
            ");
            $stmt->execute();

            $products = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $product_id = $row['product_id'];
                if (!isset($products[$product_id])) {
                    $products[$product_id] = [
                        'product_id' => $product_id,
                        'product_name' => $row['product_name'],
                        'product_description' => $row['product_description'],
                        'price' => $row['price'],
                        'images' => []
                    ];
                }
                if ($row['image_url']) {
                    $products[$product_id]['images'][] = $row['image_url'];
                }
            }
            return $products;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getImagesByProductId($product_id) {
        try {
            $stmt = $this->conn->prepare("SELECT image_url FROM product_images WHERE product_id = :product_id");
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    public function delete($product_id, $images) {
        try {
            // Delete product images from the database
            $stmt = $this->conn->prepare("DELETE FROM product_images WHERE product_id = :product_id");
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
    
            // Delete images from the uploads directory
            foreach ($images as $image) {
                if (file_exists($image)) {
                    unlink($image); // Delete the image file
                }
            }
    
            // Finally, delete the product
            $stmt = $this->conn->prepare("DELETE FROM products WHERE product_id = :product_id");
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
    
            return "Product and associated images deleted successfully.";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function update($product_id, $product_name, $product_description, $price, $images_to_delete, $new_images) {
        try {
            // Start a transaction
            $this->conn->beginTransaction();
    
            // Update product details
            $stmt = $this->conn->prepare("UPDATE products SET product_name = :product_name, product_description = :product_description, price = :price WHERE product_id = :product_id");
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':product_description', $product_description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
    
            // Delete specified images
            if (!empty($images_to_delete)) {
                foreach ($images_to_delete as $image_url) {
                    // Delete from database
                    $stmt = $this->conn->prepare("DELETE FROM product_images WHERE product_id = :product_id AND image_url = :image_url");
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':image_url', $image_url);
                    $stmt->execute();
    
                    // Delete the file from the upload directory
                    $file_path = 'uploads/' . basename($image_url);
                    if (file_exists($file_path)) {
                        unlink($file_path); // Remove the file
                    }
                }
            }
    
            // Handle new images
            if (isset($new_images) && !empty($new_images['name'][0])) {
                foreach ($new_images['tmp_name'] as $key => $tmp_name) {
                    $imageName = basename($new_images['name'][$key]); // Get only the filename
                    $targetPath = 'uploads/' . $imageName;
    
                    // Check if the file already exists to avoid overwriting
                    if (!file_exists($targetPath)) {
                        if (move_uploaded_file($tmp_name, $targetPath)) {
                            // Save image URL to database
                            $stmt = $this->conn->prepare("INSERT INTO product_images (product_id, image_url) VALUES (:product_id, :image_url)");
                            $stmt->bindParam(':product_id', $product_id);
                            $stmt->bindParam(':image_url', $imageName);
                            $stmt->execute();
                        } else {
                            throw new Exception("Could not move uploaded file.");
                        }
                    } else {
                        throw new Exception("File already exists: " . $imageName);
                    }
                }
            }
    
            // Commit the transaction
            $this->conn->commit();
            return "Product updated successfully.";
        } catch (Exception $e) {
            // Rollback the transaction if something failed
            $this->conn->rollBack();
            return "Error: " . $e->getMessage();
        }
    }
    
    
    
    
    public function getById($product_id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM products WHERE product_id = :product_id");
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
    
            // Fetch the product details
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($product) {
                // Now fetch the associated images
                $stmt = $this->conn->prepare("SELECT image_url FROM product_images WHERE product_id = :product_id");
                $stmt->bindParam(':product_id', $product_id);
                $stmt->execute();
    
                // Fetch all images associated with the product
                $images = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
                // Add images to the product array
                $product['images'] = $images;
    
                return $product; // Return the product with images
            } else {
                return null; // Return null if no product found
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage(); // Return the error message
        }
    }
    
    
}
?>
