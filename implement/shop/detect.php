<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include dependencies
include_once 'init.php';
include_once 'config.php';

// Declare the createGuestSession() function
if (!function_exists('createGuestSession')) {
    function createGuestSession()
    {
        global $conn;
        if (!isset($_SESSION['guest_id'])) {
            $session_id = session_id();
            $guest_query = "INSERT INTO guests (session_id) VALUES ('$session_id')";
            mysqli_query($conn, $guest_query);
            $_SESSION['guest_id'] = mysqli_insert_id($conn);
        }
        $_SESSION['is_guest'] = true;
        $_SESSION['active_id'] = $_SESSION['guest_id'];
    }
}

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Verify the user exists in the database
    $check_user_query = "SELECT * FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $check_user_query);

    if (mysqli_num_rows($result) == 0) {
        // Invalid user, create a guest session instead
        unset($_SESSION['user_id']);
        createGuestSession();
    } else {
        $_SESSION['is_guest'] = false;
        $_SESSION['active_id'] = $user_id;
    }
} else {
    // Not logged in, create a guest session
    createGuestSession();
}

?>