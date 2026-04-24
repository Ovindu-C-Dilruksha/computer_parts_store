<?php
require_once 'config.php';
require_once 'inc/header.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect(SITE_URL);
}
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if(!$product) {
    echo "<div class='container'><p>Product not found.</p></div>";
    require_once 'inc/footer.php';
    exit;
}
$pageTitle = $product['name'];
?>

<section class="product-detail">
    <div class="container">
        <div class="detail-wrapper">
            <div class="detail-image">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo $product['name']; ?>">
            </div>
            <div class="detail-info">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="price-large">LKR <?php echo number_format($product['price'], 2); ?></p>
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <a href="add_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>