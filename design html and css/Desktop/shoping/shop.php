  

<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:shop.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($select_cart) > 0){
     
      $message[] = 'product already added to cart!';
       
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
      
      $message[] = 'product added to cart!';
     
   }

};
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

      <link rel="shortcut icon" href="../shoping/assest/images/logo.png" type="image/x-icon">
      <link rel="stylesheet" href="../shoping/assest/css/shoop.css">
      
      

     </head>
  
    <body>
      <!-- nav bar -->
      <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top ">
          <div class="container">
          <div class="main-nav">           
              
            <!-- <img src="../shoping/assest/images/logo.png" alt="photo" height="80" width="80"> -->



            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse nav-button" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">


                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>


                <li class="nav-item">
                  <a class="nav-link" href="Shop.php">Shop</a>
                </li>


                <li class="nav-item">
                  <a class="nav-link" href="blog1.php">Blog</a>
                </li>


                <li class="nav-item">
                  <a class="nav-link" href="contact.php">Contact </a>
                </li>

 <li class="nav-item">
                  <a class="nav-link" href="search.php">Search </a>
                </li>
                

                <li class="nav-item">
                  <a href="user_profile.php"><i class="fas fa-user" title="Profile"></i></a>
                </li>

                <li class="nav-item">
                  <a href="cart.php"><i class="fas fa-shopping-bag" title="Cart"></i></a>
                </li>

                <!-- <li class="search">
                  <a href="login.php">
                    <button class="btn btn-outline-dark" type="submit">Login</button>
                  </a>
                </li> -->

                
               

              </ul>
            </div>

            </div>
          </div>
          </div>
        </nav>
      </header>

   <!-- <div class="container-fluid"> -->
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();" style="padding-top: 15px;top: 100px;">'.$message.'</div>';
   }
}

?>
<!-- <section> -->
<div class="container">

<div class="products">

   <h1 class="heading">latest products</h1>

   <div class="box-container">

   <?php
      $select_product = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
      if(mysqli_num_rows($select_product) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_product)){
   ?>
      <form method="post" class="box" action="">
      <img src="../shoping/admin/image/<?php echo $fetch_product['image']; ?>" height="200" alt="">
         <div class="name"><?php echo $fetch_product['name']; ?></div>
         <div class="price"><?php echo $fetch_product['price']; ?>$</div>
         <div class="description"><?php echo $fetch_product['description']; ?></div>
         <input type="number" min="1" name="product_quantity" value="1">
         <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
         <input type="hidden" name="description" value="<?php echo $fetch_product['description']; ?>">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
   <?php
      };
   };
   ?>

   </div>

</div>
</div>
<!-- </section> -->
   <!-- </div> -->
</body>
</html>