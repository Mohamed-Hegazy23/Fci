<?php

include('config.php');

if(isset($_POST['upload'])){
    $NAME  = $_POST['name'];
    $DESCRIPTION  = $_POST['description'];
    $PRICE = $_POST['price'];
    $IMAGE = $_FILES['image'];
    $image_location = $_FILES['image']['tmp_name'];
    $image_name = $_FILES['image']['name'];
    move_uploaded_file($image_location,'image/'. $image_name);
    $image_up = "".$image_name;
    $insert = "INSERT INTO  products (name, price ,description,image) VALUES ('$NAME','$PRICE','$DESCRIPTION','$image_up'  )";
    mysqli_query($con, $insert)or die('query failed');
    header('location:index.php');
}
?>









<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>