<?php
// Include database connection (config.php)
include 'config.php';

// Initialize message variable
$messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input data
    $fullName = mysqli_real_escape_string($conn, htmlspecialchars($_POST['fullName']));
    $userName = mysqli_real_escape_string($conn, htmlspecialchars($_POST['name']));
    $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['email']));
    $address = mysqli_real_escape_string($conn, htmlspecialchars($_POST['address']));
    $phone = mysqli_real_escape_string($conn, htmlspecialchars($_POST['number']));
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

    // Check if passwords match
    if ($password !== $cpassword) {
        $messages[] = "Passwords do not match!";
    } else {
        // Check if the username already exists in the database
        $username_check_query = "SELECT * FROM users WHERE username = '$userName'";
        $result_username = mysqli_query($conn, $username_check_query);

        if (mysqli_num_rows($result_username) > 0) {
            $messages[] = "Username already exists. Please choose a different one.";
        } else {
            // Check if the email already exists in the database
            $email_check_query = "SELECT * FROM users WHERE email = '$email'";
            $result_email = mysqli_query($conn, $email_check_query);

            if (mysqli_num_rows($result_email) > 0) {
                $messages[] = "Email already exists. Please use a different email.";
            } else {
                // Hash the password securely
               

                // Insert user into the database
                $query = "INSERT INTO users (username, full_name, email, address, phone, password) 
                          VALUES ('$userName', '$fullName', '$email', '$address', '$phone', '$password')";

                if (mysqli_query($conn, $query)) {
                    $messages[] = "Registration successful! Please <a href='login.php'>login now</a>.";
                } else {
                    $messages[] = "Error: " . mysqli_error($conn);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- Custom CSS -->
   <link rel="stylesheet" href="./CSS/registar.css" />
</head>
<body>

<div class="form-container">
    <!-- Display messages -->
    <?php if (!empty($messages)) : ?>
        <?php foreach ($messages as $message) : ?>
            <div class="alert alert-info" style="margin-top: 20px;">
                <?php echo $message; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="POST" action="">
        <h3>Register Now</h3>
        <input type="text" name="fullName" required placeholder="Full Name" class="box">
        <input type="text" name="name" required placeholder="Username" class="box">
        <input type="email" name="email" required placeholder="Email" class="box">
        <input type="text" name="address" required placeholder="Address" class="box">
        <input type="phone" name="number" required placeholder="Phone" class="box">
        <input type="password" name="password" required placeholder="Password" class="box">
        <input type="password" name="cpassword" required placeholder="Confirm Password" class="box">
        <button type="submit" class="btn">Register</button>
        <p>Already have an account? <a href="login.html">Login Now</a></p>
    </form>
</div>

</body>
</html>
