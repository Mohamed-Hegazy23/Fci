<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri&family=Cairo:wght@200&family=Poppins:wght@100;200;300&family=Tajawal:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./Css/product.css">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="admincss\products.css">
    <title>Products</title>
</head>

<nav >
        
            <a href="index.php"><button class="btn btn-success">Add Product</button></a>

            <form action="" method="post" style="display:inline;">
                <button type="submit" name="delete_all" class="btn btn-danger">Delete All</button>
            </form>
            <br>

            <form action="" method="get" class ="sform">
                <input class="sinput" type="search" name="search" placeholder="Search by name" aria-label="Search">
                <button class="sbutt" type="submit">Search</button>
            </form>
  
    </nav>

<body>
    
    <?php
    $servername = "localhost";  
    $username = "root";
    $password = "";
    $database = "online_shop";
    
    $conn = new mysqli($servername, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['delete_all'])) {
        $deleteAllQuery = "DELETE FROM inventory";
        if ($conn->query($deleteAllQuery) === TRUE) {
            echo "<script>alert('All products deleted successfully');</script>";
        } else {
            echo "<script>alert('Failed to delete all products');</script>";
        }
    }

    if (isset($_POST['delete'])) {
        $productId = $_POST['product_id'];
        $query = $conn->prepare("DELETE FROM inventory WHERE product_id = ?");
        $query->bind_param("i", $productId);
        if ($query->execute()) {
            echo "<script>alert('Product deleted successfully');</script>";
        } else {
            echo "<script>alert('Failed to delete product');</script>";
        }
        $query->close();
    }

    $searchTerm = "";
    if (isset($_GET['search'])) {
        $searchTerm = $conn->real_escape_string($_GET['search']);
        $result = $conn->query("SELECT * FROM inventory WHERE product_name LIKE '%$searchTerm%'");
    } else {
        $result = $conn->query("SELECT * FROM inventory");
    }

    echo "<div class='container mt-5'><div class='row'>";
    while ($row = mysqli_fetch_array($result)) {
        echo "
        <div class='col-md-3'>
            <div class='card' style='width: 18rem;'>
                <img src='{$row['photo']}' class='card-img-top' alt='Product Image'>
                <div class='card-body'>
                    <h5 class='card-title'>" . htmlspecialchars($row['product_name']) . "</h5>
                    <p class='card-text'>Price: $" . htmlspecialchars($row['price']) . "</p>
                    <p class='card-text'>Description: " . htmlspecialchars($row['description']) . "</p>
                    <p class='card-text'>Amount: " . htmlspecialchars($row['amount']) . "</p>
                    
                    <form action='' method='post'>
                        <input type='hidden' name='product_id' value='" . htmlspecialchars($row['product_id']) . "'>
                        <a href='delete.php?id={$row['product_id']}' class='btn btn-danger'>DELETE</a>
                        <a href='update.php?id={$row['product_id']}' class='btn btn-primary'>UPDATE</a>
                    </form>
                </div>
            </div>
        </div>";
    }
    echo "</div></div>";

    $conn->close();
    ?>
</body>
</html>