<?php

$servername = "localhost";  
$username = "root";
$password = "";
$database = "online_shop";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

 $ID = $_GET['id'];
 mysqli_query($conn,"DELETE FROM inventory WHERE product_id =$ID");
 header('location:products.php');

?>