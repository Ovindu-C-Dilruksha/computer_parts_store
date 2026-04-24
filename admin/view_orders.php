<?php
session_start();
require_once '../config.php';
if(!isAdminLoggedIn()) redirect('login.php');
$orders = $pdo->query("SELECT * FROM orders ORDER BY order_date DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Orders</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="admin-container">
    <h1>Customer Orders</h1>
    <?php foreach($orders as $order): ?>
        <div class="order-card">
            <p><strong>Order #<?php echo $order['id']; ?></strong> - <?php echo $order['customer_name']; ?> (<?php echo $order['customer_email']; ?>)</p>
            <p>Address: <?php echo $order['customer_address']; ?></p>
            <p>Total: LKR <?php echo number_format($order['total_amount'],2); ?> | Date: <?php echo $order['order_date']; ?></p>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>