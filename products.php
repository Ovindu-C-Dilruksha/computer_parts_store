<?php
$pageTitle = 'All Products';
require_once 'config.php';
require_once 'inc/header.php';

// Get search query if any
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build the SQL query with search
if(!empty($search)) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ? ORDER BY name ASC");
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY name ASC");
}
$products = $stmt->fetchAll();
?>

<section class="products-page">
    <div class="container">
        <h1>All Computer Parts</h1>
        
        <!-- Search Bar -->
        <div class="search-container">
            <form method="get" action="products.php" class="search-form">
                <input type="text" name="search" placeholder="Search products by name or description..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit"><i class="fas fa-search"></i> Search</button>
                <?php if(!empty($search)): ?>
                    <a href="products.php" class="clear-search">Clear</a>
                <?php endif; ?>
            </form>
        </div>
        
        <!-- Results count -->
        <p class="results-count">Found <?php echo count($products); ?> product(s)</p>
        
        <div class="product-grid">
            <?php if(empty($products)): ?>
                <p class="no-results">No products found matching "<strong><?php echo htmlspecialchars($search); ?></strong>". Try different keywords.</p>
            <?php else: ?>
                <?php foreach($products as $product): ?>
                <div class="product-card">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo $product['name']; ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="price">LKR <?php echo number_format($product['price'], 2); ?></p>
                    <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-small">View</a>
                    <a href="add_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-cart">Add to Cart</a>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>