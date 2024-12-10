  <?php
  include 'init.php';
  include 'config.php'; 
  include 'detect.php';
  include 'add_to_cart.php';



  if (isset($_POST['submit'])) {
      $search = $_POST['search'];
      $query = "SELECT * FROM `products` WHERE name LIKE '%$search%'";
      $result = mysqli_query($conn, $query);

  }


  if (isset($message)) {
      foreach ($message as $msg) {
          echo '<div class="message" onclick="this.remove();">' . $msg . '</div>';
      }
  }

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
    <link rel="stylesheet" href="./CSS/searchh.css">
    <link rel="stylesheet" href="./CSS/message.css">







  </head>

  <body style=" background-image: url(./images/BG.jpg);
    background-size: cover;
    pading: top 20px;
    background-repeat: no-repeat; ">

    <div class="bgImage">
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

      <div class="container my-5">
        <h1 class="text-center mb-4">Search Results</h1>
        <form action="" method="post" class="d-flex mb-4">
          <input type="text" name="search" placeholder="Search Products" class="form-control" required>
          <button class="btn btn-dark ms-2" name="submit">Search</button>
        </form>
        
        <?php if (isset($result) && mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td><img src="./images/' . $row['image'] . '" alt="' . $row['name'] . '" width="80" height="80"></td>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>' . $row['description'] . '</td>';
                echo '<td>$' . $row['price'] . '</td>';
                echo '<td>
                  <form action="search.php" method="post" >
                    <input type="hidden" name="product_id" value="' . $row['product_id'] . '">
                    <input type="hidden" name="product_name" value="' . $row['name'] . '">
                    <input type="hidden" name="product_price" value="' . $row['price'] . '">
                    <input type="hidden" name="product_image" value="' . $row['image'] . '">
                    <input type="hidden" name="product_description" value="' . $row['description'] . '">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                  </form>
                </td>';
                echo '</tr>';
              }
            ?>
          </tbody>
        </table>
        <?php else: ?>
          <h3 class="text-danger text-center w-100">No products found.</h3>
        <?php endif; ?>
      </div>
    </div>
  </body>

  </html>
