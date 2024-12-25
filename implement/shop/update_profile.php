<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "shop";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user_id is passed in the URL
if (isset($_GET['user_id'])) {
    $ID = intval($_GET['user_id']); // Sanitize user_id from URL
} else {
    echo "<script>
            alert('User ID is missing.');
            window.location.href = 'user_profile.php'; // Redirect back to profile page
          </script>";
    exit;
}

// Fetch user details for the given ID
$query = "SELECT * FROM users WHERE user_id = $ID";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

$data = mysqli_fetch_array($result);

// Handle form submission for updating user profile
if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update query
    $update_query = "UPDATE users SET username = '$username', email = '$email', password = '$password', phone = '$phone', address = '$address' WHERE user_id = $ID";
    
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Profile updated successfully!'); window.location.href = 'user_profile.php';</script>";
    } else {
        echo "<script>alert('Failed to update profile.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="update_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./css/update_profile.css" />
</head>

<body>

    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container main-nav">
                <img src="./images/logo.png" alt="Logo" height="80px" width="80px">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
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
                        <li class="nav-item"><a href="login.php" class="btn btn-outline-dark">Login</a></li>
                        <li class="nav-item"><a href="register.php" class="btn btn-outline-dark ms-2">Sign Up</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Update Profile Form -->
    <div class="main-container">
        <div class="form-container">
            <form action="" method="post">
                <h2>Update Profile</h2>

                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo $data['username']; ?>" required>
                </div>

                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $data['email']; ?>" required>
                </div>

                <div class="input-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $data['phone']; ?>" required>
                </div>

                <div class="input-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?php echo $data['address']; ?>" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" value="<?php echo $data['password']; ?>" required>
                </div>

                <div class="input-group">
                    <button name="update" type="submit" class="update-btn">Update Info</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <footer>
      <p>&copy; 2024 Electronic Store. All rights reserved.</p>
    <p>Address: ElGalaa Street, Shibin El kom, Menofia</p>
    <p>Email: Elbasha@gmail.com | Phone: +201067568547</p>  
    </footer>
</body>

</html>
