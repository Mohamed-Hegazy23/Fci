<?php
include 'config.php';

// Start the session
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Get the user_id from the session

    // Fetch user-related data, like orders, from the database
    $query = "SELECT up.*, p.name, p.description, p.price, p.image
              FROM user_product up
              JOIN products p ON up.product_id = p.product_id
              WHERE up.user_id = $userId";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

} else {
    // If the user is not logged in, redirect to login page
    echo "<script>
            alert('You are not logged in. Please log in first.');
            window.location.href = 'login.php';
          </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Order History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./css/history.css"> 
    <style>
        .bg-light {
    background-color:rgb(49, 52, 58) !important;
}

         table, th, td {
            color: white; /* Set text color to white */
        }
    </style>
</head>
<body class="bg-light" style="margin-bottom: 50px;" >
    

    <!-- Navigation bar -->
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
                        <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="shop.php"><i class="fa fa-laptop"></i> Products</a></li>
                        <li class="nav-item"><a class="nav-link" href="blog1.php"><i class="fa fa-rss"></i> Blog</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fa fa-envelope"></i> Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="user_profile.php"><i class="fas fa-user" title="Profile"></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-bag" title="Cart"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- User's Order History Section -->
    <div class="container mt-5 pt-5">
        <h3>Your Order History</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Date Added</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display user's orders if the query is successful
                if (isset($result)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Check if essential fields are present
                        if (empty($row['name']) || empty($row['price'])) {
                            continue;
                        }

                        $image = $row['image'] ?? 'default.jpg';
                        $name = $row['name'];
                        $description = $row['description'] ?? 'No description available';
                        $price = $row['price'];
                        $quantity = $row['quantity'] ?? 1;
                        $order_date = $row['order_date'] ?? 'No date available';
                        $date_added = $row['date_added'] ?? 'No date available';

                        echo '<tr>';
                        echo '<td><img src="./images/' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($name) . '" width="80" height="80"></td>';
                        echo '<td>' . htmlspecialchars($name) . '</td>';
                        echo '<td>' . htmlspecialchars($description) . '</td>';
                        echo '<td>$' . htmlspecialchars($price) . '</td>';
                        echo '<td>' . htmlspecialchars($quantity) . '</td>';
                        echo '<td>' . htmlspecialchars($date_added) . '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
