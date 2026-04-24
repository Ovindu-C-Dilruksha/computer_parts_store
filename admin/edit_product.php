<?php
session_start();
require_once '../config.php';
if(!isAdminLoggedIn()) redirect('login.php');

$id = $_GET['id'] ?? null;
$product = null;
if($id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
}

// Handle form submission
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    
    // Image upload handling
    $imagePath = $product['image'] ?? 'placeholder.jpg'; // keep old if no new upload
    
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;
        
        // Allowed file types
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if(in_array($imageFileType, $allowedTypes)) {
            if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                // Delete old image if exists and not default
                if($product && $product['image'] !== 'placeholder.jpg' && file_exists('../' . $product['image'])) {
                    unlink('../' . $product['image']);
                }
                $imagePath = 'uploads/' . $fileName;
            } else {
                $error = "Failed to upload image.";
            }
        } else {
            $error = "Only JPG, JPEG, PNG, GIF, WEBP allowed.";
        }
    }
    
    if(!isset($error)) {
        if($id) {
            $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, price=?, image=? WHERE id=?");
            $stmt->execute([$name, $desc, $price, $imagePath, $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image) VALUES (?,?,?,?)");
            $stmt->execute([$name, $desc, $price, $imagePath]);
        }
        redirect('manage_products.php');
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Product</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="admin-container">
    <h1><?php echo $id ? 'Edit' : 'Add'; ?> Product</h1>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" placeholder="Product Name" required>
        <textarea name="description" placeholder="Description"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
        <input type="number" step="0.01" name="price" value="<?php echo $product['price'] ?? ''; ?>" placeholder="Price" required>
        
        <label>Current Image:</label>
        <?php if($product && $product['image'] && $product['image'] !== 'placeholder.jpg'): ?>
            <img src="../<?php echo $product['image']; ?>" width="100" style="display:block; margin:10px 0;">
        <?php else: ?>
            <p>No image uploaded yet.</p>
        <?php endif; ?>
        
        <label>Upload New Image (leave empty to keep current):</label>
        <input type="file" name="image" accept="image/*">
        
        <button type="submit">Save Product</button>
    </form>
</div>
</body>
</html>