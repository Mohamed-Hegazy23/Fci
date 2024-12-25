<?php
include 'config.php'; // Include database connection

session_start(); // Start session

// Check if user_id exists in session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Get user_id from session
    
    // Use procedural MySQLi to delete the cart for the user
    $delete_guest_cart_query = "DELETE FROM `cart` WHERE user_id = '$user_id'";

    // Execute the query
    if (mysqli_query($conn, $delete_guest_cart_query)) {
        // Query was successful
        // Proceed to logout
        session_unset(); // Clear session variables
        session_destroy(); // Destroy the session

        // Use JavaScript to show alert and redirect
        echo "<script>
            alert('Logout successful! Your cart has been cleared.');
            window.location.href='index.php';
        </script>";
    } else {
        // Handle error if query fails
        echo "<script>
            alert('Error clearing cart.');
            window.location.href='index.php';
        </script>";
    }
} else {
    // If user_id is not set in the session
    echo "<script>
        alert('No user session found.');
        window.location.href='index.php';
    </script>";
}

exit();
?>
