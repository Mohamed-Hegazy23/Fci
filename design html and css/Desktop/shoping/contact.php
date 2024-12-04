

<?php
include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $phone = mysqli_real_escape_string($conn, $_POST['phone']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $message = mysqli_real_escape_string($conn, $_POST['message']);

   mysqli_query($conn, "INSERT INTO user_message (name,email,message,phone) VALUES('$name','$email', '$message','$phone')") or die('query failed');
//   $message[] = 'The process is being executed!';

}
?>


<!-- <?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?> -->










<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Electronics Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../shoping/assest/css/contact.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
        <div class="container">
            <a class="navbar-brand" href="#">Electronics Shop</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php"><i class="fa fa-laptop"></i> Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="blog1.php"><i class="fa fa-rss"></i> Blog</a></li>
                    <li class="nav-item active"><a class="nav-link" href="contact.php"><i class="fa fa-envelope"></i> Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid contact-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card transparent-card">
                    <div class="card-body">
                        <h1 class="text-center mb-4">Contact Us</h1>

                        <ul class="list-unstyled contact-info">
                            <li><i class="fa fa-envelope contact-icons"></i> info@electronicsshop.com</li>
                            <li><i class="fa fa-phone contact-icons"></i> +1 (555) 123-4567</li>
                            <li><i class="fa fa-whatsapp contact-icons"></i> WhatsApp: +1 (555) 987-6543</li>
                            <li><i class="fa fa-facebook contact-icons"></i> Facebook: ElectronicsShop</li>
                            <!-- Add more contact options as needed -->
                        </ul>

                        <div class="contact-form">
                            <form method="post" action="">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Name" name="name" >
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your phone" name="phone" >
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Your Email" name="email">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" placeholder="Your Message" name="message"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg custom-btn" name="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>