
<?php

include('config.php');
if(isset($_GET['delete_all_p'])){
    mysqli_query($con, "DELETE FROM products;") or die('query failed');
    $message[] = 'All products delete successfully!';
    //  header('location:index.php');
 }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri&family=Cairo:wght@200&family=Poppins:wght@100;200;300&family=Tajawal:wght@300&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products </title>
    <style>

nav{
    background-color: aliceblue;
    /* margin-bottom: 10px; */
}
button {
    margin-top: 15px;
margin-bottom: 15px;
margin-left: 50px;
 font-size: 17px;
 padding: 0.5em 2em;
 border: transparent;
 box-shadow: 2px 2px 4px rgba(0,0,0,0.4);
 background: #74c2f6;
 color: white;
 border-radius: 4px;
 
}

button:hover {
 background: #3498db;
 /* background: linear-gradient(90deg, rgba(30,144,255,1) 0%, rgba(0,212,255,1) 100%); */
}

button:active {
 transform: translate(0em, 0.2em);                                                                                                                  
        }
        h3{
            padding-right: 25px;
            padding-top: 20px;
            font-family: 'Cairo', sans-serif;
            font-weight: bolder;
        }
        .card{
            padding-top: 30px;
            border-style: solid;
            border-color: #74c2f6;
            border-radius: 10px;
            float: right;
            margin-top: 20px;
            margin-left: 52px;
            margin-right: 10px;
        }
        .card img{
            margin-bottom: 50px;
            width: 100%;
            height: 200px;
        }
        main{
            height: 100%;
            width: 80%;
        }
        .des{
            color: black;
            font-size: large;
            font-weight: bolder;
            font-style: oblique;
        }
    </style>
</head>
<nav>
<a href="index.php"><button style="margin-left:35% ;" style="margin-top:10;">Add product</button></a>
<a href="products.php?delete_all_p" onclick="return confirm('delete all ?');" class="delete"><button >Delete all</button></a>
</nav>
<body>
    <center>
        <h3>Admin Dashboard</h3>
    </center>
    <?php
    include('config.php');
    $result = mysqli_query($con, "SELECT * FROM products");
    while($row = mysqli_fetch_array($result)){
        echo "
        <center>
        <main>
            <div class='card' style='width: 15rem;'>
                <img src='$row[image]' class='card-img-top'>
                <div class='card-body'>

                    <h5  class='card-title' style='font-weight:700;'>$row[name]</h5>
                    <p class='card-text' style='font-weight:500;font-size: large;'>$row[price] $</p>
                    <p class='des' style='font-weight: 600;'>$row[description]  </p>
                    <a href='delete.php? id=$row[id]' class='btn btn-danger'>Delete</a>
                    <a href='update.php? id=$row[id]' class='btn btn-primary'>Ubdate </a>
                </div>
            </div>
        </main>
        <center>
        ";
    }
    ?>
</body>
</html>






