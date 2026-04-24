<?php
$pageTitle = 'Home - Computer Parts Store';
require_once 'config.php';
require_once 'inc/header.php';
?>

<section class="hero">
    <div class="container">
        <h1>Build Your Dream PC</h1>
        <p>High-performance computer parts at unbeatable prices</p>
        <a href="products.php" class="btn btn-primary">Shop Now <i class="fas fa-arrow-right"></i></a>
    </div>
</section>

<section class="featured-products">
    <div class="container">
        <h2>🔥 Featured Components</h2>
        <div class="product-grid">
            <?php
            $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 6");
            while($product = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
            <div class="product-card">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p class="price">LKR <?php echo number_format($product['price'], 2); ?></p>
                <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-small">View Details</a>
                <a href="add_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-cart">Add to Cart</a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>