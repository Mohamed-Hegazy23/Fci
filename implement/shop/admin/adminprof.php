<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit(); // Stop further execution
}

// Retrieve user_id from session
$user_id = $_SESSION['user_id'];

$servername = "localhost";  
$username = "root";
$password = "";
$database = "shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute query to get user data by user_id
$query = "SELECT * FROM admin_table WHERE id = '$user_id'"; // Assuming 'id' is the correct column for user ID
$result = $conn->query($query);

// Check if any record is found
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Fetch the data from the result
  
} else {
    echo "No user found!";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Data</title>
    <link rel="stylesheet" href="admincss\adminprof.css">
</head>

<body> 
<nav>
   <button class="Home"><a href="index.php">HOME</a></button>
    
</nav>
    
    <?php
        echo "
        <div class='col-md-3'>
            <div class='card'>
                <img src='{$row['photo']}' class='card-img-top' alt='Product Image'>
                <div class='card-body' >
                <p class='card-text'>Email: " . htmlspecialchars($row['username']) . "</p>
                    <p class='card-text'>Email: " . htmlspecialchars($row['email']) . "</p>
                    <p class='card-text'>Password: " . htmlspecialchars($row['password']) . "</p>
                    <p class='card-text'>Phone: " . htmlspecialchars($row['phone']) . "</p>
                    <form action='' method='post'>
                        <input type='hidden' name='product_id' value='" . htmlspecialchars($row['id']) . "'>
                        <a href='updateinfo.php?id={$row['id']}' class='btn btn-primary'>UPDATE</a>
                    </form>
                </div>
            </div>
        </div>";
    ?>
    
</body>
</html>
