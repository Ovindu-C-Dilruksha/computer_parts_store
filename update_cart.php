<?php
require_once 'config.php';
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
    $id = $_POST['product_id'];
    $qty = (int)$_POST['quantity'];
    if($qty <= 0) unset($_SESSION['cart'][$id]);
    else $_SESSION['cart'][$id] = $qty;
} elseif(isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}
redirect(SITE_URL . 'cart.php');
?>