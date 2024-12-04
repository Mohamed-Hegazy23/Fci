<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>change pass</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../shoping/assest/css/changepass.css">

</head>

<body>
   
<!-- nav bar -->
<div class="navbar">
   <div class="logo">
   <img src="../shoping/assest/images/logo.png" alt="photo" height="80" width="80">
   </div>
   <div class="contain">
    <a href="index.php">Home</a>
    <a href="shop.php">Shop</a>
    <a href="#">Blog</a>
    <a href="#">Contact</a>
    </div>
</div>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Change password</h3>
      <input type="email" name="email" required placeholder="enter email" class="box">
      <input type="password" name="new password" required placeholder="enter new password" class="box">
      <input type="password" name="comfirm new password" required placeholder="comfirm new password" class="box">
      <input type="submit" name="submit" class="btn" value="Change password">
      <p>don't have an account? <a href="register.php">register now</a></p>
   </form>
  <!--footer-->


</div>
<div class="footer">
    <p>&copy;  Shop Name. All rights reserved.</p>
    <p>Address: 123 Main Street, Cityville, Country</p>
    <p>Email: info@yourshop.com | Phone: +1 (123) 456-7890</p>
</div>

</body>
</html>