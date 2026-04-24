<?php
session_start();
require_once '../config.php';
if(!isAdminLoggedIn()) redirect('login.php');

$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Manage Products</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="admin-container">
    <h1>Products</h1>
    <a href="edit_product.php" class="btn">+ Add New Product</a>
    <table class="admin-table">
        <tr><th>ID</th><th>Image</th><th>Name</th><th>Price</th><th>Actions</th></tr>
        <?php foreach($products as $p): ?>
        <tr>
            <td><?php echo $p['id']; ?></td>
            <td><img src="../<?php echo $p['image']; ?>" width="50"></td>
            <td><?php echo htmlspecialchars($p['name']); ?></td>
            <td><?php echo number_format($p['price'],2); ?></td>
            <td><a href="edit_product.php?id=<?php echo $p['id']; ?>">Edit</a> | <a href="delete_product.php?id=<?php echo $p['id']; ?>" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>