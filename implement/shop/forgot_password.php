<?php
    include 'config.php'; // Database connection

    if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['email']));
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

 // Check if passwords match
 if ($password !== $cpassword) {
    echo "<script>alert('Passwords do not match.');</script>";
} else {
       // Check if the email already exists in the database
       $email_check_query = "SELECT * FROM users WHERE email = '$email'";
       $result_email = mysqli_query($conn, $email_check_query);

       if (mysqli_num_rows($result_email) > 0) {
          $query ="UPDATE users SET  password = '$password' where email='$email' ";
           if (mysqli_query($conn, $query)) {
            echo "<script>alert('password update successful! Please,login now..');</script>";
           } else {
               $messages[] = "Error: " . mysqli_error($conn);
           }
       } else {
               echo "<script>alert('Email not exists. Please check your email.');</script>";
        
      
       }
   }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./CSS/forgot_pass.css" />
    <link rel="stylesheet" href="./assest/css/forgot_pass.css" />
    <link rel="stylesheet" href="./CSS/messagee.css">



</head>

<body>
    <div class="form-container">
        <form action="forgot_password.php" method="post">
            <h3>Reset Your Password</h3>
            <p>Enter your email address and new password.</p>
            <input type="email" name="email" required placeholder="Enter Your Email" class="box">
            <input type="password" name="password" required placeholder="Enter New password" class="box">
            <input type="password" name="cpassword" required placeholder="Confirm New password" class="box">

            <input type="submit" name="submit" class="btn" value="Change">
            <p><a href="login.php" class="back-to-login">Back to Login</a></p>

        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>