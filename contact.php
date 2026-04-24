<?php
$pageTitle = 'Contact';
require_once 'config.php';
require_once 'inc/header.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $msg = $_POST['message'];
    $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?,?,?)");
    $stmt->execute([$name, $email, $msg]);
    $success = "Message sent successfully!";
}
?>
<section class="contact">
    <div class="container">
        <h1>Contact Us</h1>
        <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
        <form method="post">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>
</section>
<?php require_once 'inc/footer.php'; ?>