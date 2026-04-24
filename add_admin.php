<?php
require_once 'config.php';

$username = 'admin';
$plainPassword = 'admin';

// Generate a proper bcrypt hash
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

try {
    // Remove any existing admin with the same username
    $stmt = $pdo->prepare("DELETE FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    
    // Insert the new admin
    $stmt = $pdo->prepare("INSERT INTO admin_users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hashedPassword]);
    
    echo "<h2>✅ Admin user created successfully!</h2>";
    echo "<p><strong>Username:</strong> admin</p>";
    echo "<p><strong>Password:</strong> admin</p>";
    echo "<a href='admin/login.php'>Go to Admin Login</a>";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>