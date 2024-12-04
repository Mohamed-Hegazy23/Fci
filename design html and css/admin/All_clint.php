<?php

include 'config.php'


?>
<!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Clint</title>


      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
      <link rel="stylesheet" href="../admin/Css/search.css">


      
    </head>

    <body>
      <!-- nav bar -->
      <header class="header bg-dark text-light py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Electronics Shop</h1>
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link font-weight-bold" href="index.php"><i class="fa fa-home"></i> Home</a></li>
                   
                    </ul>
                </nav>
            </div>
        </div>
    </header>

      <form action="" method="post">
        <input type="text" name="search" id="" placeholder="Search Data" class="lab">
        <button class="" name="submit">Search</button>
      </form>
      
      <!-- show data search -->
      
        <div class="container my-5">
        <table class="table">
          <?php

          if(isset($_POST['submit'])){
            $search=$_POST['search'];
            $sql="SELECT * FROM `clint` WHERE name like '%$search%'  or address ='$search'  ";
            $result=mysqli_query($con,$sql);
            if($result){
              if(mysqli_num_rows($result) > 0){
                echo '
                <thead>
                <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Adress</th>
                <th>Email</th>
                </tr>
                </thead>
                ';
                while($row=mysqli_fetch_assoc($result)){

                echo '
                <tbody>
                <tr>
              
                <td>'.$row['name'].'</a> </td>
                <td>'.$row['phone'].'</td>
                <td>'.$row['address'].'</td>
                <td>'.$row['email'].'</td>
                </tr>
                </tbody>';
              }
              }
              else{
                echo '<h2 class="text-danger"> Data Not Found</h2>';
                header('All_clint.php');
              }
            }
          }else{ $result = mysqli_query($con, "SELECT * FROM clint");
           
            echo '
            <thead>
            <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Adress</th>
            <th>Email</th>
            </tr>
            </thead>
            ';
 while($row = mysqli_fetch_array($result)){

            echo '
            <tbody>
            <tr>
          
            <td>'.$row['name'].'</a> </td>
            <td>'.$row['phone'].'</td>
            <td>'.$row['address'].'</td>
            <td>'.$row['email'].'</td>
            </tr>
            </tbody>';}
          }
          ?>
 </table>
      </div>
    </div>
</body>
</html>