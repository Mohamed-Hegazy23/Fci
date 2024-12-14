<?php
session_start();
include 'init.php'; // Session management
include 'config.php'; // Database connection
include 'detect.php'; // User/guest detection logic

$message = []; // Initialize the message array

// Get the active ID and user status
$active_id = isset($_SESSION['active_id']) ? $_SESSION['active_id'] : null;
$is_guest = isset($_SESSION['is_guest']) ? $_SESSION['is_guest'] : false;

echo "Active ID: " . (isset($active_id) ? $active_id : "No active user.") . "<br>"; // Display active_id when the checkout page is opened


if (isset($_POST['submit'])) {
    // Sanitize and collect input data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $visa_card = mysqli_real_escape_string($conn, md5($_POST['viacard']));
    $confirm_visa_card = mysqli_real_escape_string($conn, md5($_POST['cviacard']));

    // Validate Visa card number format (Visa cards start with 4 and are between 13 and 19 digits)
    if (!preg_match('/^4[0-9]{5,18}$/', $_POST['viacard'])) {
        $message[] = 'Invalid Visa card number! It must start with 4 and contain 13 to 19 digits.';
    }

    // Check if Visa card and confirm Visa card match
    if ($visa_card !== $confirm_visa_card) {
        $message[] = 'Visa card numbers do not match! Please try again.';
    }

    // Check if user session is set correctly
    if (empty($message)) {
        if ($active_id !== null) {
            // User is logged in
            $user_id = $active_id;
            $guest_id = NULL;
        } elseif ($is_guest) {
            // User is a guest
            $user_id = NULL;
            $guest_id = $_SESSION['guest_id'];  // Use guest_id for guest users
        } else {
            $message[] = 'User session is not set! Please log in or continue as a guest.';
        }
    }

    // Insert data into checkout_data table
    if (empty($message)) {
        $query = "INSERT INTO checkout_data (name, phone, address, email, visa_card, user_id, guest_id) 
                  VALUES ('$name', '$phone', '$address', '$email', '$visa_card', '$user_id', '$guest_id')";

        if (mysqli_query($conn, $query)) {
            // Clear the cart in the database for both user and guest
            if ($user_id !== NULL) {
                // Clear cart for logged-in user
                $clear_cart_query = "DELETE FROM cart WHERE user_id = '$user_id'";
            } elseif ($guest_id !== NULL) {
                // Clear cart for guest
                $clear_cart_query = "DELETE FROM cart WHERE guest_id = '$guest_id'";
            }

            // Execute the cart deletion query
            if (mysqli_query($conn, $clear_cart_query)) {
                $message[] = 'Thank you for your trust! Your order will be delivered soon, and your cart has been cleared.';
            } else {
                $message[] = 'Error clearing the cart: ' . mysqli_error($conn);  // Added debugging
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
        echo '<div class="message" onclick="this.remove();" style="margin-top: 80px">'.$msg.'</div>';
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
            <li class="nav-item"><a class="nav-link" href="search.php"><i class="fa fa-search"></i> Search</a></li>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>

