<?php
session_start();
include "config.php";

// Remove item
if (isset($_GET['remove'])) {
    $key = $_GET['remove'];
    unset($_SESSION['cart'][$key]);
    header("Location: cart.php");
}

// Clear cart
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
}

// Buy / Checkout
if (isset($_GET['buy'])) {
    unset($_SESSION['cart']); // clear cart
    echo "<script>alert('✅ Order placed successfully!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Your Cart</title>

<style>
body {
    font-family: Arial;
    background: #f5f5f5;
    text-align: center;
}

.container {
    width: 70%;
    margin: auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
}

h1 {
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

th {
    background: #28a745;
    color: white;
}

button {
    padding: 5px 10px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.remove-btn {
    background: red;
    color: white;
}

.clear-btn {
    background: black;
    color: white;
    margin-top: 10px;
}

.buy-btn {
    background: green;
    color: white;
    margin-top: 10px;
    padding: 10px 15px;
}

.buy-btn:hover {
    background: darkgreen;
}

.back-btn {
    display: inline-block;
    margin-top: 15px;
    padding: 10px;
    background: blue;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}
</style>

</head>
<body>

<div class="container">
<h1>🧺 Your Cart</h1>

<?php
if (!empty($_SESSION['cart'])) {

    $total = 0;

    echo "<table>";
    echo "<tr>
            <th>Item</th>
            <th>Price</th>
            <th>Action</th>
          </tr>";

    foreach ($_SESSION['cart'] as $key => $id) {

        $query = "SELECT * FROM products WHERE id=$id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>₹" . $row['price'] . "</td>";
        echo "<td>
                <a href='cart.php?remove=$key'>
                    <button class='remove-btn'>Remove</button>
                </a>
              </td>";
        echo "</tr>";

        $total += $row['price'];
    }

    echo "</table>";

    echo "<h2>Total: ₹$total</h2>";

    echo "<a href='cart.php?buy=true'>
            <button class='buy-btn'>Buy Now</button>
          </a>";

    echo "<br>";

    echo "<a href='cart.php?clear=true'>
            <button class='clear-btn'>Clear Cart</button>
          </a>";

} else {
    echo "<p>Cart is empty 😢</p>";
}
?>

<a href="products.php" class="back-btn">← Back to Products</a>

</div>

</body>
</html>