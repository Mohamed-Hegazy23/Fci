<?php
include 'config.php';
session_start();
$message = []; // Initialize the message array

// Check if the user is already logged in, if so, redirect
if (isset($_SESSION['user_id'])) {
    header('location: index.php');
    exit();
}

// If the form is submitted
if (isset($_POST['submit'])) {

    // Get the email and password from POST and sanitize
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn,md5 ($_POST['password'])); // Ensure password is hashed as md5

    // Check the database for a user with the provided email and password
    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        // User found, fetch user data
        $row = mysqli_fetch_assoc($select);

        // Start the session for the logged-in user
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['email'] = $row['email']; // Store email in session

        // If the user was previously a guest, transition from guest to user
        if (isset($_SESSION['guest_id'])) {
            // Link guest session to the user (if needed)
            $guest_id = $_SESSION['guest_id'];
            $update_guest_query = "UPDATE guests SET user_id = '" . $_SESSION['user_id'] . "' WHERE guest_id = '$guest_id'";
            mysqli_query($conn, $update_guest_query);

            // Delete guest's products from the cart
            $delete_guest_cart_query = "DELETE FROM cart WHERE guest_id = '$guest_id'";
            mysqli_query($conn, $delete_guest_cart_query);

            // Remove guest session data
            unset($_SESSION['guest_id']);
        }

        // Redirect to the homepage or dashboard after login
        $message[]='login done';
        exit();
    } else {
        // If no matching user, set an error message
        echo "<script>alert('un correct email or password!')</script>";
    }
}

?>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();"style="
    margin-top: 80px;">'.$message.'</div>';

   }
}
?> 


<!-- HTML Part -->
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
   <!-- Custom CSS -->
   <link rel="stylesheet" href="./css/login.css">
   <link rel="stylesheet" href="./css/message.css">

</head>

<body>

    <!-- Navbar -->
    <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
          <img src="./images/logo.png" alt="Logo" height="80px" width="80px" style=" margin-left:30px ;">
          <div class="container main-nav" style="padding-bottom: 0px; padding-left:450px ;">

              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                  aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarContent">
                  <ul class="navbar-nav ms-auto">
                      <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a>
                      </li>
                      <li class="nav-item"><a class="nav-link" href="shop.php"><i class="fa fa-laptop"></i>
                              Products</a></li>
                      <li class="nav-item"><a class="nav-link" href="blog1.php"><i class="fa fa-rss"></i> Blog</a>
                      </li>
                      <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fa fa-envelope"></i>
                              Contact</a></li>
                      <li class="nav-item"><a class="nav-link" href="user_profile.php"><i class="fas fa-user"
                                  title="Profile"></i></a></li>
                      <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-bag"
                                  title="Cart"></i></a></li>

              </div>
          </div>
      </nav>
  </header>

   <div class="form-container">
      <form action="" method="post">
         <h3>Login Now</h3>
         <input type="email" name="email" required placeholder="Enter Email" class="box">
         <input type="password" name="password" required placeholder="Enter Password" class="box">
         <input type="submit" name="submit" class="btn" value="Login Now">
         <div class="text-center mt-2">
            <p><a href="forgot_password.php">Forgot Password?</a></p>
            <p>Don't have an account? <a href="register.php">Register Now</a></p>
         </div>
      </form>
   </div>

   <!-- Bootstrap JS -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
