<?php

$servername = "localhost";  
$username = "root";
$password = "";
$database = "online_shop";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if(isset($_POST['submit'])){
   
   $email = trim($_POST['email']);
   $pass = trim($_POST['password']);

   $query = "SELECT email, password FROM admin_table WHERE email ='$email' AND password ='$pass' ";
   $res = mysqli_query($conn,$query);

   
   if (mysqli_num_rows($res) > 0) {
      
      echo "<script>alert('login successful!');</script>";
      header('location: index.php');
   } else{
      echo "<script>alert('Error: Could not execute query.');</script>";
      header('location: login.php');

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
   <title>login</title>

   <link rel="stylesheet" href="admincss\login.css">
</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>login now</h3>

      <input type="email" name="email" required placeholder="enter email" class="box">
      <input type="password" name="password" required placeholder="enter password" class="box">
      <p>don't have an account?  <a href="register.php">register now</a></p>
      <br>
      <button name='submit' type="submit" class ="butt">login now </button>

   </form>

</div>

</body>
</html>