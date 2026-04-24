<?php
require_once 'config.php';
if(!isset($_GET['id'])) redirect(SITE_URL);
$id = $_GET['id'];

if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if(isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;
} else {
    $_SESSION['cart'][$id] = 1;
}
redirect(SITE_URL . 'cart.php');
?>