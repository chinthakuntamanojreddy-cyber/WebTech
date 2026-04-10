<?php
session_start();
include "config.php";

// Add to cart
if (isset($_GET['add'])) {
    $id = $_GET['add'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][] = $id;

    header("Location: cart.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Products</title>

<style>
body {
    font-family: Arial;
    background: #f4f6f8;
    margin: 0;
    padding: 0;
}

/* Header */
.header {
    background: #28a745;
    color: white;
    padding: 15px;
    text-align: center;
    font-size: 24px;
}

/* Grid Layout */
.container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    padding: 20px;
}

/* Product Card */
.card {
    background: white;
    border-radius: 12px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: 0.3s;
}

.card:hover {
    transform: scale(1.05);
}

/* Image */
.card img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 10px;
}

/* Title */
.card h3 {
    margin: 10px 0;
}

/* Price */
.price {
    color: #28a745;
    font-weight: bold;
    margin-bottom: 10px;
}

/* Button */
.btn {
    background: #007bff;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.btn:hover {
    background: #0056b3;
}

/* Cart link */
.cart-link {
    display: block;
    text-align: center;
    margin: 20px;
    font-size: 18px;
    text-decoration: none;
    color: #333;
}
</style>

</head>
<body>

<div class="header">
    🛍️ FreshMart Products
</div>

<div class="container">

<?php
$result = mysqli_query($conn, "SELECT * FROM products");

while ($row = mysqli_fetch_assoc($result)) {
?>
    <div class="card">
        <img src="<?php echo $row['image']; ?>">
        <h3><?php echo $row['name']; ?></h3>
        <p class="price">₹<?php echo $row['price']; ?></p>

        <a href="products.php?add=<?php echo $row['id']; ?>">
            <button class="btn">Add to Cart 🛒</button>
        </a>
    </div>
<?php
}
?>

</div>

<a href="cart.php" class="cart-link">🧺 Go to Cart</a>

</body>
</html>