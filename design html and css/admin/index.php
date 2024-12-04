
<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};
if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
};
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri&family=Cairo:wght@200&family=Poppins:wght@100;200;300&family=Tajawal:wght@300&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop online</title>
    <link rel="stylesheet" href="../admin/Css/stylee.css">


</head>
<header>
   <a href="All_clint.php"><button style="margin-left:35% ;width:200px">All Cliant</button></a>
   <a href="Message.php"><button style="margin-right:30% ;width:200px;">Message</button></a>
</header>
<body>
    <center>
        <div class="main">
            <form action="insert.php" method="post" enctype="multipart/form-data">
                <h2>ADD PRODUCTS TO SHOP</h2>
                <img src="logo.png" alt="logo" width="450px">
                <input type="text" name='name' placeholder="product name" required  autofocus>
                <br>
                <input type="text" name='price' placeholder="product price" required >
                <br>
                <input type="text" name='description' placeholder="description" required >
                <br>
                <input type="file" id="file" name='image' style='display:none;'>
                <label for="file"> Add photo</label>
                <button name='upload'>ADD ✅</button>
                <br><br>
                <a href="products.php" >All products</a>
            </form>
        </div>
     
    </center>

<aside>

<div class="user-profile">

   <?php
      $select_user = mysqli_query($con, "SELECT * FROM `admin_info` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_user) > 0){
         $fetch_user = mysqli_fetch_assoc($select_user);
      };
   ?>


   <p> id : <span><?php echo $fetch_user['id']; ?></span> </p>
   <p> username : <span><?php echo $fetch_user['name']; ?></span> </p>
   <p> email : <span><?php echo $fetch_user['email']; ?></span> </p>
   <div class="flex">
      <a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm('are your sure you want to logout?');" class="delete-btn">logout</a>
   </div>

</div>
</aside>

</body>
</html>