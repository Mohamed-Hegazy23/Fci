<?php

$servername = "localhost";  
$username = "root";
$password = "";
$database = "shop";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if(isset($_POST['submit'])){

    $username = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);
    $confirm = trim($_POST['cpassword']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if ($pass === $confirm) {
      // Insert query
      $insert = "INSERT INTO admin_table (username, email , password , confirm , phone , address ) 
                 VALUES ('$username', '$email', '$pass', '$confirm' ,'$phone', '$address' )";
      if (mysqli_query($conn, $insert)) {
          echo "<script>alert('Registration successful!');</script>";
      } else {
          echo "<script>alert('Error: Could not execute query.');</script>";
      }
  } else {
      echo "<script>alert('Passwords do not match.');</script>";
   }
}



$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <link rel="stylesheet" href="admincss\register.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
    <h3>register now</h3>
    <input type="text" name="name" required placeholder="enter username" class="box">
    <input type="email" name="email" required placeholder="enter email" class="box">
    <input type="password" name="password" required placeholder="enter password" class="box">
    <input type="password" name="cpassword" required placeholder="confirm password" class="box">
    <input type="text" name="phone" required placeholder="enter phone number" class="box">
    <input type="text" name="address" required placeholder="enter address" class="box">
    <br>
    <button name='submit' type="submit" class ="butt">register </button>
    <br>
     <a href="login.php">login</a>

   </form>

</div>

</body>
</html>