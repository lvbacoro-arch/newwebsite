<?php
session_start();
include("connect.php");

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch user info
$stmt = $conn->prepare("SELECT firstName, lastName FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 10%; }
        .cart-items { margin-top: 30px; }
        .options a {
            display: inline-block;
            margin: 10px;
            padding: 12px 20px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .options a:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars($user['firstName']); ?>’s Cart 🛒</h1>
    
    <div class="cart-items">
        <p>Your cart is currently empty.</p>
        <!-- Later you can loop through items stored in session or database -->
    </div>

    <div class="options">
        <a href="homepage.php">🏠 Back to Homepage</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
</body>
</html>
