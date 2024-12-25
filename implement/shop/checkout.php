<?php
session_start();
include 'init.php'; // Session management
include 'config.php'; // Database connection

$message = []; // Initialize the message array

// Get the active session IDs
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$guest_id = isset($_SESSION['guest_id']) ? $_SESSION['guest_id'] : null;

if (isset($_POST['submit'])) {
    // Sanitize and collect input data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $visa_card = mysqli_real_escape_string($conn, md5($_POST['viacard']));
    $confirm_visa_card = mysqli_real_escape_string($conn, md5($_POST['cviacard']));

    // Validate Visa card number format (Visa cards start with 4 and are between 13 and 19 digits)
    if (!preg_match('/^4[0-9]{12}(?:[0-9]{3})?(?:[0-9]{3})?$/', $_POST['viacard'])) {
        $message[] = 'Invalid Visa card number! It must start with 4 and contain 13 to 19 digits.';
    }

    // Check if Visa card and confirm Visa card match
    if ($visa_card !== $confirm_visa_card) {
        $message[] = 'Visa card numbers do not match! Please try again.';
    }

    // Ensure at least one session ID is set
    if (empty($message)) {
        if ($user_id !== null) {
            // User is logged in
            $guest_id = null; // Reset guest ID for logged-in users
        } elseif ($guest_id === null) {
            $message[] = 'Session error: Please log in or continue as a guest.';
        }
    }

    // Insert data into `checkout_data` table
    if (empty($message)) {
        $query = "INSERT INTO checkout_data (name, phone, address, email, visa_card, user_id, guest_id) 
                  VALUES ('$name', '$phone', '$address', '$email', '$visa_card', " . 
                  ($user_id !== null ? "'$user_id'" : "NULL") . ", " . 
                  ($guest_id !== null ? "'$guest_id'" : "NULL") . ")";

        if (mysqli_query($conn, $query)) {
            // Clear the cart in the database
            $clear_cart_query = $user_id !== null 
                ? "DELETE FROM cart WHERE user_id = '$user_id'" 
                : "DELETE FROM cart WHERE guest_id = '$guest_id'";

            if (mysqli_query($conn, $clear_cart_query)) {
                $message[] = 'Thank you for your trust! Your order will be delivered soon, and your cart has been cleared.';
            } else {
                $message[] = 'Error clearing the cart: ' . mysqli_error($conn);
            }
        } else {
            // Handle database error
            $message[] = 'Error: Could not process your order. Please try again later.';
        }
    }
}

// Display messages
if (!empty($message)) {
    foreach ($message as $msg) {
        echo '<div class="message" onclick="this.remove();" style="margin-top: 80px">' . htmlspecialchars($msg) . '</div>';
    }
}
?>




    



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="shortcut icon" href="../shoping/assest/images/logo.png" type="image/x-icon">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./CSS/checkout.css">
    <link rel="stylesheet" href="./CSS/messagee.css">
</head>
<body>

<!-- Navbar -->
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      <div class="container main-nav" style="padding-bottom: 0px;">
        <img src="./images/logo.png" alt="Logo" height="80px" width="80px">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link" href="shop.php"><i class="fa fa-laptop"></i> Products</a></li>
            <li class="nav-item"><a class="nav-link" href="blog1.php"><i class="fa fa-rss"></i> Blog</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fa fa-envelope"></i> Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="user_profile.php"><i class="fas fa-user" title="Profile"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-bag dark" title="Cart"></i></a></li>
          </ul>
        </div>
      </div>
    </nav>
</header>

<!-- Checkout Section -->
<section class="my-5 py-5">
    <div class="container text-center my-3 pt-5"> 
        <h2 class="form-weight-bold"><B>Check Out</B></h2>
        <hr class="mx-auto" style="width: 50px; height: 3px; background-color: #005F73;">
    </div>
    
    <div class="checkout-form-container">
    <form id="checkout-form" method="post" action="">
        <!-- Name -->
        <div class="form-group checkout-small-element">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Name" required>
        </div>

        <!-- Phone -->
        <div class="form-group checkout-small-element">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" name="phone" placeholder="Phone" required maxlength="11">
        </div>

        <!-- Address -->
        <div class="form-group checkout-large-element">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" placeholder="Address" required>
        </div>

        <!-- Email -->
        <div class="form-group checkout-large-element">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>

        <!-- Visa-card -->
        <div class="form-group checkout-large-element">
            <label for="via">Visa Card</label>
            <input type="password" class="form-control" name="viacard" placeholder="Visa Card" required>
        </div>

        <!-- Confirm Visa-card -->
        <div class="form-group checkout-large-element">
            <label for="cviacard">Confirm Visa Card</label>
            <input type="password" class="form-control" name="cviacard" placeholder="Confirm Visa Card" required>
        </div>

        <!-- Submit Button -->
        <div class="form-group checkout-btn-container">
            <input type="submit" class="btn" value="Checkout" name="submit">
        </div>
    </form>
</div>

</section>

<!-- Footer -->
<div class="footer">
    <p>&copy; 2024 Electronic Store. All rights reserved.</p>
    <p>Address: ElGalaa Street, Shibin El kom, Menofia</p>
    <p>Email: Elbasha@gmail.com | Phone: +201067568547</p>
</div>

<!-- Bootstrap JS -->.
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>

