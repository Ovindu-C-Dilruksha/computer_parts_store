<?php
session_start();
require_once '../config.php';
if(!isAdminLoggedIn()) redirect('login.php');
if(isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}
redirect('manage_products.php');
?>