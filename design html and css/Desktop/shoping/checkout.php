

<?php
include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $phone = mysqli_real_escape_string($conn, $_POST['phone']);
   $address = mysqli_real_escape_string($conn, $_POST['address']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $viacard = mysqli_real_escape_string($conn, md5($_POST['viacard']));
   $cviacard = mysqli_real_escape_string($conn, md5($_POST['cviacard']));

  //  $select = mysqli_query($conn, "SELECT * FROM `user_info` WHERE email = '$email' ") or die('query failed');

   if( $viacard==$cviacard){
     mysqli_query($conn, "INSERT INTO clint (name,phone,address, email, viacard) VALUES('$name','$phone','$address','$email', '$viacard')") or die('query failed');
      $message[] = 'The process is being executed!';
   }else{
    $message[] = 'Write A Correct visa card';  
//header('location:login.php');
   } 

   }
   
?>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Checkout</title>


        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        <link rel="shortcut icon" href="assest/imgs/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="../shoping/assest/css/check_out.css">
    </head>
    <body> 
<!-- nave bar -->
<div class="navbar">
   <div class="logo">
   <img src="../shoping/assest/images/logo.png" alt="photo" height="80" width="80">
   </div>
   <div class="contain">
    <a href="index.php">Home</a>
    <a href="shop.php">Shop</a>
    <a href="blog1.php">Blog</a>
    <a href="contact.php">Contact</a>
    </div>
</div>
  <!--Checkout-->
  <section class="my-5 py-5">
    <div class="container text-center my-3 pt-5"> 
      <h2 class="form-weight-bold">Check Out</h2>
      <hr class="mx-auto">
    </div>
  <div class="mx-auto container">
    <form id="checkout-form" method="post" action="">
      <div class="form-group checkout-small-element">

      <div class="form-group checkout-small-element">
        <label>Name</label>
        <input type="tel" class="form-control" id="checkout-name" name="name" placeholder="name" required>
      </div>


      <div class="form-group checkout-small-element">
          <label>Phone</label>
          <input type="number" class="form-control" id="checkout-phone" name="phone" placeholder="Phone" required maxlength="11">
        </div>


        <div class="form-group checkout-large-element">
            <label>Address</label>
            <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address"  required>
          </div>


          <div class="form-group checkout-large-element">
            <label>Email</label>
            <input type="email" class="form-control" id="checkout-email" name="email" placeholder="email@" required>
          </div>


          <div class="form-group checkout-large-element">
          <label for="via">Via-card</label>
          <input type="password" class="form-control" id="via"   name="viacard" placeholder="Viacard" required>
         </div>



         <div class="form-group checkout-large-element">
          <label for="via">confirm Via-card</label>
          <input type="password" class="form-control" id="via"   name="cviacard" placeholder="Viacard" required>
         </div>



          </div>
      <div class="form-group checkout-btn-container">
        <input type="submit" class="btn" id="checkout-btn" value="Checkout" name="submit">
      </div>
      
    </form>
  </div>
  </section>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> 
   <div class="footer">
    <p>&copy;  Shop Name. All rights reserved.</p>
    <p>Address: 123 Main Street, cityville, Country</p>
    <p>Email: info@yourshop.com | Phone: +1 (123) 456-7890</p>
</div>
    </body>
    </html>

    <!-- <label for="via">Via-card</label>
<input id="via" name="via" type="password" pattern="\d{4,4}" required /> -->