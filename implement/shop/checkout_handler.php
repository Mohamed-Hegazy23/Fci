<?php
include 'init.php'; // Session management
include 'config.php'; // Database connection
include 'detect.php'; // User/guest detection logic

// Get the active ID and user status
$active_id = $_SESSION['active_id'];
$is_guest = $_SESSION['is_guest'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle guest or user products
    if ($is_guest) {
        copyGuestProducts($active_id);
    } else {
        copyUserProducts($active_id);
    }

    // Redirect to checkout form
    header('Location: checkout.php');
    exit();
}

// Function to copy products for guests
function copyGuestProducts($guest_id)
{
    global $conn;

    // Fetch all cart items for the guest
    $query = "SELECT * FROM cart WHERE guest_id = '$guest_id'";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $price = $row['price'];
        $image = $row['image'];
        $quantity = $row['quantity'];

        // Check if the product already exists in guest_product
        $check_query = "SELECT * FROM guest_product WHERE guest_id = '$guest_id' AND product_id = '$product_id'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Update the quantity if the product exists
            $update_product = "UPDATE guest_product 
                               SET quantity =  $quantity 
                               WHERE guest_id = '$guest_id' AND product_id = '$product_id'";
            mysqli_query($conn, $update_product);
        } else {
            // Insert the product if it doesn't already exist
            $insert_product = "INSERT INTO guest_product (guest_id, product_id, product_name, price, image, quantity) 
                               VALUES ('$guest_id', '$product_id', '$product_name', '$price', '$image', '$quantity')";
            mysqli_query($conn, $insert_product);
        }
    }
}

// Function to copy products for users
function copyUserProducts($user_id)
{
    global $conn;

    // Fetch all cart items for the user
    $query = "SELECT * FROM cart WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $price = $row['price'];
        $image = $row['image'];
        $quantity = $row['quantity'];

        // Check if the product already exists in user_product
        $check_query = "SELECT * FROM user_product WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Update the quantity if the product exists
            $update_product = "UPDATE user_product 
                               SET quantity =  $quantity 
                               WHERE user_id = '$user_id' AND product_id = '$product_id'";
            mysqli_query($conn, $update_product);
        } else {
            // Insert the product if it doesn't already exist
            $insert_product = "INSERT INTO user_product (user_id, product_id, product_name, price, image, quantity) 
                               VALUES ('$user_id', '$product_id', '$product_name', '$price', '$image', '$quantity')";
            mysqli_query($conn, $insert_product);
        }
    }
}
?>