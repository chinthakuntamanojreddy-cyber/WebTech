<?php
// Initialize variables
$name = $email = $message = "";
$success = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get values safely
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validation
    if (!empty($name) && !empty($email) && !empty($message)) {
        $success = "Message sent successfully!";
    } else {
        $success = "Please fill all fields!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Website - Contact</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <h1>Contact Me</h1>
</header>

<nav>
    <a href="index.html">Home</a>
    <a href="about.html">About</a>
    <a href="education.html">Education</a>
    <a href="contact.php">Contact</a>
</nav>

<hr>

<main>
<section>

<h2>Get In Touch</h2>
<p>Feel free to contact me for any inquiries.</p>

<!-- Show message -->
<p style="color: green; font-weight: bold;">
    <?php echo $success; ?>
</p>

<h3>Contact Form</h3>

<form method="post" action="contact.php">
    
    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo $name; ?>"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo $email; ?>"><br><br>

    <label>Message:</label><br>
    <textarea name="message"><?php echo $message; ?></textarea><br><br>

    <button type="submit">Send Message</button>

</form>

</section>
</main>

<hr>

<footer>
    <p>Contact Page</p>
</footer>

</body>
</html>