<?php
// Include necessary files
include 'init.php';
include 'config.php';
include 'detect.php';  // This will manage session and detection logic

$message = []; // Initialize the message array

// Get the user or guest ID using the detect functions
$id = get_user_or_guest_id();  // This will return user_id or guest_id based on session

// Ensure we have a valid ID to query the cart
if ($id) {
    // Fetch cart items based on user_id or guest_id
    if (check_user_login()) {
        // If logged in, query using user_id
        $query = "SELECT * FROM cart WHERE user_id = '$id'";
    } elseif (check_guest_id()) {
        // If guest, query using guest_id
        $query = "SELECT * FROM cart WHERE guest_id = '$id'";
    }

    // Execute the query
    $result = mysqli_query($conn, $query);
} else {
    echo '<script>alert("No valid session found. Please log in or continue as a guest."); window.location.href="login.php";</script>';
    exit;
}
?>
<?php
// Function to get the user or guest ID
function get_user_or_guest_id() {
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        return $_SESSION['user_id'];  // Return the logged-in user's ID
    } elseif (isset($_SESSION['guest_id'])) {
        return $_SESSION['guest_id'];  // Return the guest ID if not logged in
    }
    return null;  // Return null if no user or guest ID exists
}

// Function to check if the user is logged in
function check_user_login() {
    return isset($_SESSION['user_id']);
}

// Function to check if the guest ID is set
function check_guest_id() {
    return isset($_SESSION['guest_id']);
}
?>

<?php 



// Remove individual item from cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    if (mysqli_query($conn, "DELETE FROM `cart` WHERE product_id = '$remove_id'")) {
    }
    header('Location: cart.php');
    exit();
}


// Clear all items from the cart
if (isset($_GET['delete_all'])) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    } else {
        
        $cart_id = $id; 
        mysqli_query($conn, "DELETE FROM `cart` WHERE guest_id = '$cart_id'") or die('query failed');
    }

    header('Location: cart.php');
    exit();
}


if (isset($_POST['update_cart'])) {
    $update_quantity = $_POST['cart_quantity'];
    $update_id = $_POST['cart_id'];

    // Sanitize and constrain the quantity
    $update_quantity = max(1, min(10, (int)$update_quantity));

    // Fetch product price
    $price_query = "SELECT price FROM products WHERE product_id = '$update_id'";
    $price_result = mysqli_query($conn, $price_query);

    if ($price_row = mysqli_fetch_assoc($price_result)) {
        $product_price = $price_row['price'];
        $total_price = $product_price * $update_quantity;
    } else {
        $message[] = 'Failed to fetch product price.';
    }

    // Update cart with new quantity and total price
    $update_query = "UPDATE `cart` SET quantity = '$update_quantity', total_price = '$total_price' WHERE product_id = '$update_id'";
    
    if (mysqli_query($conn, $update_query)) {
        $message[] = 'Cart quantity and total price updated successfully!';
    } else {
        $message[] = 'Failed to update cart quantity and total price.';
    }

    header("Location: cart.php");
    exit();
}

// Display messages, if any
if (!empty($message)) {
    foreach ($message as $msg) {
        echo '<div class="message" onclick="this.remove();" style="margin-top: 80px;">' . htmlspecialchars($msg) . '</div>';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./CSS/cart.css" />
    <link rel="stylesheet" href="./CSS/messagee.css">

</head>
<body>

<!-- Navbar -->
     <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      <div class="container main-nav" style="padding-bottom: 0px;">
        <img src="./images/logo.png" alt="Logo" height="80px" width="80px">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
          aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link" href="shop.php"><i class="fa fa-laptop"></i> Products</a></li>
            <li class="nav-item"><a class="nav-link" href="blog1.php"><i class="fa fa-rss"></i> Blog</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fa fa-envelope"></i> Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="user_profile.php"><i class="fas fa-user"
                  title="Profile"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-bag"
                  title="Cart"></i></a></li>

        </div>
      </div>
    </nav>
  </header>
<!-- Cart Section -->
<section class="my-5 py-5">
    <div class="container text-center my-3 pt-5"> 
        <h2 class="form-weight-bold"><b>Shopping Cart</b></h2>
        <hr class="mx-auto">
    </div>

    <div class="container cart-table">
        <table class="table table-striped" >
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
             $grand_total = 0;
             if ($result && mysqli_num_rows($result) > 0) {
                 while ($row = mysqli_fetch_assoc($result)) {
                     $total = $row['price'] * $row['quantity'];
                     $grand_total += $total;
                     echo '<tr>';
                     echo '<td><img src="./images/' . htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8') . '" style="width: 70px; height: 70px;"></td>';
                     echo '<td>' . htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8') . '</td>';
                     echo '<td>$' . number_format($row['price'], 2) . '</td>';
             
                     // Form for updating quantity
                     echo '<form action="cart.php" method="POST">';
                     echo '<td><input type="number" name="cart_quantity" value="' . htmlspecialchars($row['quantity'], ENT_QUOTES, 'UTF-8') . '" min="1" max="10"></td>';
                     echo '<td>$' . number_format($total, 2) . '</td>';
                     
                     // Remove button
                     echo '<td>
                             <a href="cart.php?remove=' . htmlspecialchars($row['product_id'], ENT_QUOTES, 'UTF-8') . '" 
                                class="btn btn-danger delete-btn" 
                                onclick="return confirm(\'Remove item from cart?\');">Remove</a>
               
                
                             <input type="hidden" name="cart_id" value="' . htmlspecialchars($row['product_id'], ENT_QUOTES, 'UTF-8') . '">
                             <button type="submit" name="update_cart" class="btn btn-warning">Update Quantity</button>
                           </td>';
                     echo '</form>';
                     echo '</tr>';
                 }
             } else {
                 echo '<tr><td colspan="7" class="text-center">Your cart is empty.</td></tr>';
             }
             
              
                ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between mt-4">
    <div>
        <h4>Total: $<?php echo number_format($grand_total, 2); ?></h4>
        <form action="checkout_handler.php" method="POST">
    <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
</form>

    </div>
    <div class="text-center mt-3" style="
    padding-top: 15px;
">
        <a href="cart.php?delete_all=true" 
           class="btn btn-danger" 
           onclick="return confirm('Are you sure you want to delete all items from the cart?');">
           Delete All
        </a>
    </div>
</div>


    </div>
    </section>

<!-- Footer -->
<div class="footer">
    <p>&copy; 2024 El-Basha Store. All rights reserved.</p>
    <p>Address: Shiben El Kome , El Glaa Street</p>
    <p>Email: El-Basha.Store@gmail.com | Phone: +201097534045</p>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>
