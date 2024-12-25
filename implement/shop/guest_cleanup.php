<?php
include 'init.php';
include 'config.php'; 

if (isset($_SESSION['guest_id'])) {
    $guest_id = $_SESSION['guest_id'];

    // Use prepared statement to prevent SQL injection
    $query = "DELETE FROM guests WHERE guest_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $guest_id); // 'i' indicates an integer type
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt); // Close statement

    // End session
    session_destroy();
}

mysqli_close($conn); // Close connection
?>
