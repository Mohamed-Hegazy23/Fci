<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

// if(isset($_GET['logout'])){
//    unset($user_id);
//    session_destroy();
//    header('location:login.php');
// };

if(isset($_POST['update_cart'])){
   $update_quantity = $_POST['cart_quantity'];
   $update_id = $_POST['cart_id'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
   $message[] = 'cart quantity updated successfully!';
}

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
   $message[] = 'cart quantity remove successfully!';

   //  header('location:cart.php');
}
  
if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   $message[] = 'cart empty successfully!';
   //  header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../shoping/assest/css/cart_s.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<style>
   .continer{
      justify-content: flex-start;
   }
   nav{
      padding-bottom: 90px;
      background-color: aliceblue;
      justify-items: flex-start;
      display: flex;
   }
   .home{
      margin-left: 90px;
   }
   .shop{
      padding-bottom: 20px;
   }
</style>   

</head>
<body>
   
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>





<!-- <<<<<<<<<<<<<<<<<<<<<<product>>>>>>>>>>>>>>>>>>>>>>>>>>> -->

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


                


 



<!-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<shopping cart>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->

<div class="container">

<div class="shopping-cart">

   <h1 class="heading">shopping cart</h1>

   <table>
      <thead>
         <th>image</th>
         <th>name</th>
         <th>price</th>
         <th>quantity</th>
         <th>total price</th>
         <th>action</th>
      </thead>
      <tbody>
      <?php
         $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         $grand_total = 0;
         if(mysqli_num_rows($cart_query) > 0){
            while($fetch_cart = mysqli_fetch_assoc($cart_query)){
      ?>
         <tr>
            <td><img src="../shoping/admin/image/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td>$<?php echo $fetch_cart['price']; ?>/-</td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                  <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                  <input type="submit" name="update_cart" value="update" class="option-btn">
               </form>
            </td>
            <td><?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>$</td> 

            <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('remove item from cart?');">remove</a></td>
         </tr>
      <?php
         $grand_total += $sub_total;
            }
         }else{
            echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
         }
      ?>
      <tr class="table-bottom">
         <td colspan="4">grand total :</td>
         <td>$<?php echo $grand_total; ?>/-</td>
         <td><a href="cart.php?delete_all" onclick="return confirm('delete all from cart?');" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">delete all</a></td>
      </tr>
   </tbody>
   </table>

   <div class="cart-btn">  
      <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
   </div>

</div>

</div>

</body>
</html>