<?php
session_start();
require_once '../config.php';
if(!isAdminLoggedIn()) redirect('login.php');
$msgs = $pdo->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Messages</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="admin-container">
    <h1>Contact Messages</h1>
    <?php foreach($msgs as $msg): ?>
        <div class="msg-card"><strong><?php echo htmlspecialchars($msg['name']); ?></strong> (<?php echo $msg['email']; ?>)<p><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p><small><?php echo $msg['submitted_at']; ?></small></div>
    <?php endforeach; ?>
</div>
</body>
</html>