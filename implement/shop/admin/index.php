<?php
session_start(); // Start the session to manage session variables

// Check if user is logged in by verifying if the session variable 'user_id' is set
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login.php if not logged in
    exit(); // Ensure no further code is executed
}

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


if (isset($_POST['ADD'])) {
    $NAME = $_POST['Name'];
    $PRICE = $_POST['price']; // Price as a string, to be cast to decimal
    $IMAGE = $_FILES['image'];
    $image_location = $_FILES['image']['tmp_name'];
    $image_name = $_FILES['image']['name'];
    move_uploaded_file($image_location,'images/'. $image_name);
    $image_up = "". $image_name;
    $des = $_POST['description'];
    $amount = $_POST['amount']; // This should be numeric or string, based on database definition
    
    // Check if the "images" directory exists; create it if not
    if (!is_dir('images')) {
        mkdir('images', 0777, true);
    }

    // Validate price to ensure it's a valid decimal value
    if (!is_numeric($PRICE)) {
        echo "<script>alert('Please enter a valid price value!')</script>";
        exit();
    }

    // Insert query
    $insert = "INSERT INTO products (name, price, image, description, amount) 
               VALUES ('$NAME', '$PRICE', '$image_up', '$des', '$amount')";
    
    if (mysqli_query($conn, $insert)) {
        if (move_uploaded_file($image_location, $image_up)) {
            echo "<script>alert('The product was uploaded successfully!')</script>";
        } else {
            echo "<script>alert('Image upload failed!')</script>";
        }
    } else {
        echo "<script>alert('Failed to insert product into database')</script>";
    }

    header('Location: index.php');
    exit();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri&family=Cairo:wght@200&family=Poppins:wght@100;200;300&family=Tajawal:wght@300&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Online</title>
    <link rel="stylesheet" href="./admincss/index.css">
    <style>
        body {
            background-image: url("images/back 0.jpg");
            background-size: cover; 
            background-repeat: no-repeat;
            background-position: center center;
        }
    </style>
</head>
<header>
   <div class ="btn_div">
   <a href="All_clients.php"><button class ="btn">All Clients</button></a>
   <a href="review.php"><button  class ="btn">Messages</button></a>
   <a href="adminprof.php"><button  class ="btn">Profile Page</button></a>
    </div>
</header>
<body>
    <center>
        <div class="main">
            <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <h2>ADD PRODUCTS TO SHOP</h2>
                <img src="images/logo 0.jpg" alt="logo" width="450px">
                <input type="text" name="Name" placeholder="Product Name" required autofocus>
                <br>
                <input type="number" name="price" step="0.01" placeholder="Product Price" required>
                <br>
                <input type="text" name="description" placeholder="Description" required>
                <br>
                <input type="number" name="amount" placeholder="Amount" required>
                <br>
                <input type="file" id="file" name="image" style="display:none;" required>
                <label for="file">Add Photo</label>
                <button name="ADD" type="submit">ADD ✅</button>
                <br><br>
            </form>
            <a href="products.php"><button>All Products</button></a>
        </div>
    </center>

    <script>
        function validateForm() {
            const name = document.querySelector('input[name="Name"]').value;
            const price = document.querySelector('input[name="price"]').value;
            const description = document.querySelector('input[name="description"]').value;
            const amount = document.querySelector('input[name="amount"]').value;

            if (!name || !price || !description || !amount) {
                alert("Please fill in all fields before submitting!");
                return false; 
            }
            alert("Product added! 🎉");
            return true; 
        }
    </script>
</body>
</html>
