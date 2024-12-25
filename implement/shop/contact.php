<?php
include 'config.php';  // Database connection
include_once 'init.php';  // Start session and other necessary initializations

// Initialize messages
$messages = [];

// Check if session exists
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['submit'])) {
    // Collect and sanitize input
    $name = mysqli_real_escape_string($conn, htmlspecialchars($_POST['name']));
    $phone = mysqli_real_escape_string($conn, htmlspecialchars($_POST['phone']));
    $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['email']));
    $review_content = mysqli_real_escape_string($conn, htmlspecialchars($_POST['message']));

    // Determine if it's a user or guest submitting the review
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $guest_id = isset($_SESSION['guest_id']) ? $_SESSION['guest_id'] : null;
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : $name;  // For guest, use the entered name
    $phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : $phone;  // For guest, use the entered phone
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : $email;  // For guest, use the entered email

    // Insert review into the database
    if ($user_id) {
        $query = "INSERT INTO review (user_id, username, phone, email, review) 
                  VALUES ('$user_id', '$username', '$phone', '$email', '$review_content')";
    } else {
        $query = "INSERT INTO review (guest_id, username, phone, email, review) 
                  VALUES ('$guest_id', '$username', '$phone', '$email', '$review_content')";
    }

    // Execute the query and check if successful
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Your review has been submitted successfully!');
                window.location.href = '" . $_SERVER['PHP_SELF'] . "';
              </script>";
        exit();
    } else {
        $messages[] = "An error occurred while submitting your review. Please try again later.";
    }
}
?>

<?php
// Display messages
if (!empty($messages)) {
    foreach ($messages as $message) {
        echo '<div class="alert alert-info" onclick="this.remove();" style="margin-top: 80px;">' . htmlspecialchars($message) . '</div>';
    }
}
?>

 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Electronics Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./css/contact.css" />
    <link rel="stylesheet" href="./CSS/messagee.css">



</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <img src="./images/logo.png" alt="Logo" height="80px" width="80px" style=" margin-left:30px ;">
            <div class="container main-nav" style="padding-bottom: 0px; padding-left:450px ;">


                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="shop.php"><i class="fa fa-laptop"></i>
                                Products</a></li>
                        <li class="nav-item"><a class="nav-link" href="blog1.php"><i class="fa fa-rss"></i> Blog</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fa fa-envelope"></i>
                                Contact</a></li>



                        <li class="nav-item"><a class="nav-link" href="user_profile.php"><i class="fas fa-user"
                                    title="Profile"></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-bag"
                                    title="Cart"></i></a></li>

                </div>
            </div>
        </nav>
    </header>

    <!-- Contact Us Section -->
    <div id="contact" class="container-fluid contact-container">
        <div class="row justify-content-center">
            <div class="col-md-6 st" style="margin-top: 150px;">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center mb-4">Contact Us</h1>

                        <!-- Contact Information -->
                        <div class="social-contact">
                            <ul>
                                <li class="facebook-link">
                                    <i class="fab fa-facebook"></i>
                                    <a href="https://www.facebook.com/yourpage" target="_blank">ًEl Basha Store</a>
                                </li>
                                <li class="whatsapp-link">
                                    <i class="fab fa-whatsapp"></i>
                                    <a href="https://wa.me/yourwhatsappnumber" target="_blank">+201097534045</a>
                                </li>
                                <li class="gmail-link">
                                    <i class="fab fa-google"></i>
                                    <a href="mailto:your-email@gmail.com" target="_blank">ElBasha@gmail.com</a>
                                </li>
                            </ul>
                        </div>


                        <!-- Contact Form -->
                        <div class="contact-form">
                            <form method="post" action="#">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Name" name="name"
                                        required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Phone" name="phone"
                                        required>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Your Email" name="email"
                                        required>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" placeholder="Your Message" name="message"
                                        required></textarea>
                                </div>
                                <button class="btn btn-dark btn-sm" name="submit">submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Electronics Shop. All rights reserved.</p>
        <p><a href="#privacy">Privacy Policy</a> | <a href="#terms">Terms of Service</a></p>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>