<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- Custom CSS -->

    <link rel="stylesheet" href="./CSS/cart.css" />
    <link rel="stylesheet" href="./assest/css/cart.css" />
</head>
<body>

<!-- Navbar -->
     <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      <div class="container main-nav" style="padding-bottom: 0px;">
        <img src="./images/logo.png" alt="Logo" height="80px" width="80px">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
          aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="index.html"><i class="fa fa-home"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link" href="shop.html"><i class="fa fa-laptop"></i> Products</a></li>
            <li class="nav-item"><a class="nav-link" href="blog1.html"><i class="fa fa-rss"></i> Blog</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.html"><i class="fa fa-envelope"></i> Contact</a></li>
       


            <li class="nav-item"><a class="nav-link" href="user_profile.html"><i class="fas fa-user"
                  title="Profile"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="cart.html"><i class="fas fa-shopping-bag"
                  title="Cart"></i></a></li>

        </div>
      </div>
    </nav>
  </header>
<!-- Cart Section -->
<section class="my-5 py-5">
    <div class="container text-center my-3 pt-5"> 
        <h2 class="form-weight-bold"><b>Shopping Cart</b></h2>
        <hr class="mx-auto">
    </div>

    <div class="container cart-table">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product Image</th> <!-- New column for product image -->
                    <th>Product Name</th> <!-- New column for product name -->
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Delete</th> <!-- Changed from Remove to Delete -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src="./images/Camera.png" alt="Camera HD" style="width: 70px; height: 70px;"></td> <!-- Product Image -->
                    <td>Camera HD</td>
                    <td>$500.00</td>
                    <td><input type="number" value="1" min="1" max="10"></td>
                    <td>$500.00</td>
                    <td><button class="btn">Delete</button></td> <!-- Replaced icon with 'Delete' -->
                </tr>
            </tbody>
        </table>
        <div class="text-right mt-4">
            <h4>Total: $500.00</h4>
          <a href="checkout.html">  <button class="btn">Proceed to Checkout</button></a> 
        </div>
    </div>
</section>

<!-- Footer -->
<div class="footer">
    <p>&copy; 2024 El-Basha Store. All rights reserved.</p>
    <p>Address: Shiben El Kome , El Glaa Street</p>
    <p>Email: El-Basha.Store@gmail.com | Phone: +201097534045</p>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>
