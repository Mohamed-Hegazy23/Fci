<?php
include 'init.php';
include 'config.php'; 
include 'detect.php';
include 'add_to_cart.php';

?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E_Business</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="shortcut icon" href="../shoping/assest/images/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="./CSS/shoop.css">
  <link rel="stylesheet" href="./CSS/message.css">
   
  <style> 
  body{
        background-image: url(./images/you.jpg);
  }
  </style>
</head>
<body >

  <!-- nav bar -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      <div class="container main-nav" style="padding-bottom: 0px;">
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
            <li class="nav-item"><a class="nav-link" href="search.php"><i class="fa fa-search"></i> Search</a></li>
            <li class="nav-item"><a class="nav-link" href="user_profile.php"><i class="fas fa-user" title="Profile"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-bag" title="Cart"></i></a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <div class="container">
    <div class="products">
      <h1 class="heading">Latest Products</h1>

      <div class="row justify-content-center">
        <?php
            // Fetch products from the database using MySQLi
            $select_product = mysqli_query($conn, "SELECT * FROM `products`");
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
        <div class="card p-3 shadow-lg m-3 text-center position-relative">
          <form method="post" action="">
            <div class="price"><?php echo $fetch_product['price']; ?>$</div>
            <div class="img">
              <img src="./images/<?php echo $fetch_product['image']; ?>" alt="Product Image">
            </div>
            <h3><?php echo $fetch_product['name']; ?></h3>
            <p class="description mb-3"><?php echo $fetch_product['description']; ?></p>
            <input type="hidden" name="product_id" value="<?php echo $fetch_product['product_id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
            <input type="hidden" name="quantity" value="1" min="1">
            <button type="submit" name="add_to_cart" class="btn btn-primary w-100">Add to Cart</button>
          </form>
        </div>
        <?php
                }
            }
            ?>
      </div>
    </div>
  </div>

  <!-- Footer Section -->
  <footer>
    <p>&copy; 2024 El-Basha Store. All rights reserved.</p>
    <p>Address: Shiben El Kome, El Glaa Street</p>
    <p>Email: El-Basha.Store@gmail.com | Phone: +201097534045</p>
  </footer>

  <script src="message.js"></script>
</body>
</html>
