<?php
$servername = "localhost";  
$username = "root";
$password = "";
$database = "online_shop";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Fetch product details for the given ID
$ID = $_GET['id'];
$up = mysqli_query($conn, "SELECT * FROM inventory WHERE product_id = $ID");
$data = mysqli_fetch_array($up);

// Handle form submission
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image_name = $data['photo']; // Default to existing image if no new image is uploaded

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $new_image_name = $_FILES['image']['name'];
        $image_folder = "images/" . $new_image_name;

        // Move the uploaded file to the `image` directory
        if (move_uploaded_file($image_tmp, $image_folder)) {
            $image_name = $image_folder; // Update image path if upload is successful
        } else {
            echo "<script>alert('Failed to upload the new image.');</script>";
        }
    }

    // Update the product in the database
    $update_query = "UPDATE inventory SET product_name = '$name', price = '$price', photo = '$image_name' WHERE product_id = $ID";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Product updated successfully!');</script>";
        header('Location: products.php'); // Redirect to products page after update
        exit();
    } else {
        echo "<script>alert('Failed to update product.');</script>";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri&family=Cairo:wght@200&family=Poppins:wght@100;200;300&family=Tajawal:wght@300&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="admincss\update.css">
</head>
<body>
    <div class="main-container">
        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <h2>Update Product</h2>

                <!-- Hidden Product ID -->
                <input type="hidden" name="id" value="<?php echo $data['product_id']; ?>">

                <!-- Product Name -->
                <div class="input-group">
                    <label for="name">New Product Name</label>
                    <input type="text" id="name" name="name" required value="<?php echo $data['product_name']; ?>">
                </div>

                <!-- Product Price -->
                <div class="input-group">
                    <label for="price">New Product Price</label>
                    <input type="text" id="price" name="price" required value="<?php echo $data['price']; ?>">
                </div>

                <!-- Image Upload -->
                <div class="input-group">
                    <label for="file" class="file-label">Update Image</label>
                    <input type="file" id="file" name="image" hidden>
                </div>

                <!-- Submit Button -->
                <div class="input-group">
                    <button name="update" type="submit" class="update-btn">Update</button>
                </div>

                <!-- Back Link -->
                <a href="products.php" class="back-link">View All Products</a>
            </form>
        </div>
    </div>

 
    <script>
        function validateForm() {
            const name = document.getElementById("name").value;
            const price = document.getElementById("price").value;
            if (name === "" || price === "") {
                alert("Please fill in all fields before submitting!");
                return false; 
            }
            alert("Product updated! 🎉");
            return true; 
        }
    </script>
</body>
</html>
