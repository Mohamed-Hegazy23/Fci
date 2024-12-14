<?php
    $servername = "localhost";  
    $username = "root";
    $password = "";
    $database = "online_shop";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT * FROM admin_table");
    $row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Data</title>
    <link rel="stylesheet" href="admincss\adminprof.css">
</head>

<body> 
<nav>
   <button class="Home"><a href="index.php">HOME</a></button>
    
</nav>
    
    <?php
        echo "
        <div class='col-md-3'>
            <div class='card'>
                <img src='{$row['photo']}' class='card-img-top' alt='Product Image'>
                <div class='card-body'>
                    <p class='card-text'>Email: " . htmlspecialchars($row['email']) . "</p>
                    <p class='card-text'>Password: " . htmlspecialchars($row['password']) . "</p>
                    <p class='card-text'>Phone: " . htmlspecialchars($row['phone']) . "</p>
                    <form action='' method='post'>
                        <input type='hidden' name='product_id' value='" . htmlspecialchars($row['id']) . "'>
                        <a href='updateinfo.php?id={$row['id']}' class='btn btn-primary'>UPDATE</a>
                    </form>
                </div>
            </div>
        </div>";
    ?>
    
</body>
</html>
