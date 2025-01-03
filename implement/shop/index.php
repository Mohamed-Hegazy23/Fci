<?php
session_start();
include 'init.php';
include 'config.php'; 
include 'detect.php';
// include 'logout.php';
?>

<!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>E_Busniss</title>


      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

      <link rel="shortcut icon" href="../shoping/assest/image/logo.png" type="image/x-icon">
      <link rel="stylesheet" href="./CSS/home.css">

      <link rel="stylesheet" href="./assest/css/home.css">

      
    </head>
  
    <body>
      <!-- nav bar -->
      <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container main-nav">
                <img src="./images/logo.png" alt="Logo" height="80px" width="80px">
    
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="shop.php"><i class="fa fa-laptop"></i> Products</a></li>
                        <li class="nav-item"><a class="nav-link" href="blog1.php"><i class="fa fa-rss"></i> Blog</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fa fa-envelope"></i> Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="user_profile.php"><i class="fas fa-user" title="Profile"></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-bag" title="Cart"></i></a></li>
                        <li class="nav-item">
    <?php if (isset($_SESSION['user_id'])) : ?>
        <!-- If the user is logged in, show Logout -->
        <a href="logout.php" class="btn btn-outline-dark">Logout</a>
    <?php else : ?>
        <!-- If the user is NOT logged in, show Login and Sign Up -->
        <a href="login.php" class="btn btn-outline-dark">Login</a>
        <a href="register.php" class="btn btn-outline-dark ms-2">Sign Up</a>
    <?php endif; ?>
</li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
      <!-- Home -->
      <section id="Home">
        <div class="container">
          <h5>NEW ARRIVAL</h5>
          <h1>ALL COLLECTION</h1>
          <p>We Have The Best Collection </p>
          <a href="shop.php">
          <button>SHOP NOW</button>
         </a>
       
        </div>
      </section>
      <!-- Brand -->
      <section id="Brand" class="container">
        <div class="row">
          <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="./images/Dell_Logo.jpg" alt="Dell_Logo" title="Dell">
          <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="./images/hp_logo.jpg" alt="HP_Logo" title="HP">
          <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="./images/iPhone.jpg" alt="I Phone_Logo" title="I Phone">
          <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="./images/samsung-logo.jpg" alt="Samsung_logo" title="Samsung">

        </div>
      </section>
       <!-- Footer Section -->
    <footer>
      <p>&copy; 2024 Electronics Shop. All rights reserved.</p>
      <p><a href="#privacy">Privacy Policy</a> | <a href="#terms">Terms of Service</a></p>
  </footer>
 
<script>
// Send request to delete guest data only when the tab or browser window is closed
window.addEventListener("beforeunload", function (event) {
    if (!event.persisted) { // Check if the page is being closed (not cached or navigated)
        navigator.sendBeacon('guest_cleanup.php'); // Calls PHP script to delete guest
    }
});
</script>


</body>
</html>