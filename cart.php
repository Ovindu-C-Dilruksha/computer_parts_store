<?php
$pageTitle = 'Shopping Cart';
require_once 'config.php';
require_once 'inc/header.php';

$cartItems = [];
$total = 0;
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
    $products = $stmt->fetchAll();
    foreach($products as $product) {
        $qty = $_SESSION['cart'][$product['id']];
        $subtotal = $product['price'] * $qty;
        $total += $subtotal;
        $cartItems[] = ['product' => $product, 'quantity' => $qty, 'subtotal' => $subtotal];
    }
}
?>

<section class="cart-section">
    <div class="container">
        <h1>Your Cart</h1>
        <?php if(empty($cartItems)): ?>
            <p>Your cart is empty. <a href="products.php">Continue shopping</a></p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th><th></th></tr>
                </thead>
                <tbody>
                <?php foreach($cartItems as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product']['name']); ?></td>
                        <td>
                            <form action="update_cart.php" method="post" style="display:flex; gap:5px;">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width:60px;">
                                <input type="hidden" name="product_id" value="<?php echo $item['product']['id']; ?>">
                                <button type="submit" class="btn-small">Update</button>
                            </form>
                        </td>
                        <td>LKR <?php echo number_format($item['product']['price'],2); ?></td>
                        <td>LKR <?php echo number_format($item['subtotal'],2); ?></td>
                        <td><a href="update_cart.php?remove=<?php echo $item['product']['id']; ?>" class="btn-remove">Remove</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr><td colspan="3"><strong>Total</strong></td><td><strong>LKR <?php echo number_format($total,2); ?></strong></td><td></td></tr>
                </tfoot>
            </table>
            <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>