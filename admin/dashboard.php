<?php
session_start();
require_once '../config.php';
if(!isAdminLoggedIn()) redirect('login.php');
$productCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$orderCount = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$messageCount = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="admin-container">
    <h1>Admin Dashboard</h1>
    <nav class="admin-nav">
        <a href="manage_products.php">Manage Products</a>
        <a href="view_orders.php">Orders (<?php echo $orderCount; ?>)</a>
        <a href="view_contacts.php">Messages (<?php echo $messageCount; ?>)</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="stats">
        <div>Products: <?php echo $productCount; ?></div>
        <div>Orders: <?php echo $orderCount; ?></div>
        <div>Messages: <?php echo $messageCount; ?></div>
    </div>
</div>
</body>
</html>