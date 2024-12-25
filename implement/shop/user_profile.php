<?php
include 'config.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if `user_id` is in session
if (isset($_SESSION['user_id'])) {
    $userId = intval($_SESSION['user_id']);
} else {
    echo "<script>
            if (confirm('You are not logged in. Do you want to go to the login page?')) {
                window.location.href = 'login.php';  // Redirect to login page
            } else {
                window.location.href = 'index.php';  // Redirect to the index page
            }
          </script>";
    exit;
}

// Handle logout action
// if (isset($_POST['logout'])) {
//     // Destroy all session variables
//     session_unset();
//     session_destroy();
    
//     // Redirect to the login page after logging out
//     header("Location: login.php");
//     exit();
// }

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user data (excluding sensitive fields)
$query = "SELECT username, email, full_name, address, phone FROM users WHERE user_id = $userId";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $username = htmlspecialchars($user['username']);
    $email = htmlspecialchars($user['email']);
    $full_name = htmlspecialchars($user['full_name']);
    $address = htmlspecialchars($user['address']);
    $phone = htmlspecialchars($user['phone']);
} else {
    $username = "Guest";
    $email = "N/A";
    $full_name = "N/A";
    $address = "N/A";
    $phone = "N/A";
}

// Free result and close the connection
if ($result) {
    mysqli_free_result($result);
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./css/user_profile.css" />

    <style>
          footer {
    background-color: #2c3e50;
    color: white;
    text-align: center;
    padding: 20px;
    margin-top: 40px;
}

footer a {
    color: white;
    text-decoration: none;
}


    </style>
</head>

<body class="bg-light">
    <!-- Navbar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <img src="./images/logo.png" alt="Logo" height="80px" width="80px" style="margin-left: 30px;">
            <div class="container main-nav" style="padding-bottom: 0px; padding-left: 450px;">
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
                        <li class="nav-item"><a class="nav-link" href="user_profile.php"><i class="fas fa-user"
                                    title="Profile"></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-bag"
                                    title="Cart"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Profile Section -->
    <div class="container mt-5 pt-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="card shadow-sm mb-4 text-center">
                    <div class="card-body">
                        <img src="./images/user_placeholder.png" alt="User Image" class="img-fluid rounded-circle mb-3" style="width: 100px;">
                        <h5 class="card-title"><?php echo $username; ?></h5>
                        <p class="text-muted"><?php echo $full_name ? $full_name : 'Web Developer'; ?></p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="order_history.php"><i class="fa fa-history"></i> Order History</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Profile Section -->
            <div class="col-md-9">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="mb-3">Profile Overview</h5>
                        <p>Manage your personal information, orders, and settings here.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Username:</strong>
                                <p><?php echo $username; ?></p>
                            </div>
                            <div class="col-md-6">
                                <strong>Full Name:</strong>
                                <p><?php echo $full_name; ?></p>
                            </div>
                            <div class="col-md-6">
                                <strong>Email:</strong>
                                <p><?php echo $email; ?></p>
                            </div>
                            <div class="col-md-6">
                                <strong>Phone:</strong>
                                <p><?php echo $phone; ?></p>
                            </div>
                            <div class="col-md-6">
                                <strong>Address:</strong>
                                <p><?php echo $address; ?></p>
                            </div>
                        </div>
                        <a href="update_profile.php?user_id=<?php echo $_SESSION['user_id']; ?>">Edit Profile</a>
                        </div>

                </div>
            </div>
            <!-- <form method="POST">
                <button type="submit" name="logout" class="btn btn-danger">Logout</button>
            </form> -->
        </div>
    </div>

<footer>

    <p>&copy; 2024 Electronic Store. All rights reserved.</p>
    <p>Address: ElGalaa Street, Shibin El kom, Menofia</p>
    <p>Email: Elbasha@gmail.com | Phone: +201067568547</p>
</footer>
   

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
