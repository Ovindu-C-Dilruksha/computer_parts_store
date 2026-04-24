<?php
session_start();
require_once '../config.php';
if(isAdminLoggedIn()) redirect(SITE_URL . 'admin/dashboard.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$user]);
    $admin = $stmt->fetch();
    if($admin && password_verify($pass, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $admin['username'];
        redirect('dashboard.php');
    } else $error = "Invalid credentials";
}
?>
<!DOCTYPE html>
<html>
<head><title>Admin Login</title><link rel="stylesheet" href="../css/style.css"></head>
<body class="admin-login">
<div class="login-box">
    <h2>Admin Panel Login</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>