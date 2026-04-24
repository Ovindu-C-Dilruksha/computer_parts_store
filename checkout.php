<?php
$pageTitle = 'Checkout';
require_once 'config.php';
require_once 'inc/header.php';

if(empty($_SESSION['cart'])) redirect(SITE_URL . 'cart.php');

$total = 0;
$ids = implode(',', array_keys($_SESSION['cart']));
$stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
$products = $stmt->fetchAll();
foreach($products as $p) {
    $total += $p['price'] * $_SESSION['cart'][$p['id']];
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    
    $pdo->beginTransaction();
    $orderStmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_email, customer_address, total_amount) VALUES (?,?,?,?)");
    $orderStmt->execute([$name, $email, $address, $total]);
    $orderId = $pdo->lastInsertId();
    
    $itemStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?,?,?,?)");
    foreach($products as $p) {
        $qty = $_SESSION['cart'][$p['id']];
        $itemStmt->execute([$orderId, $p['id'], $qty, $p['price']]);
    }
    $pdo->commit();
    unset($_SESSION['cart']);
    echo "<div class='container'><h2>Order placed successfully!</h2><p>Thank you for your purchase.</p><a href='products.php' class='btn'>Continue Shopping</a></div>";
    require_once 'inc/footer.php';
    exit;
}
?>

<section class="checkout-form">
    <div class="container">
        <h1>Checkout</h1>
        <form method="post">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <textarea name="address" placeholder="Delivery Address" required></textarea>
            <p><strong>Total: LKR <?php echo number_format($total,2); ?></strong></p>
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>