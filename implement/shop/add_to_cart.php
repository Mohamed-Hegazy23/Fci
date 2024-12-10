<?php
include 'init.php'; // Centralized session management (ensures session is active)
include 'config.php'; // Database connection setup (required for database queries)
include 'detect.php'; // User/guest detection logic (relies on session and database)


// Get the active ID (user_id or guest_id)
$active_id = $_SESSION['active_id'];
$is_guest = $_SESSION['is_guest'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    // Product details from POST
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if ($is_guest) {
        // Guest handling
        handleGuestCart($active_id, $product_id, $product_name, $product_price, $product_image, $quantity);
    } else {
        // User handling
        handleUserCart($active_id, $product_id, $product_name, $product_price, $product_image, $quantity);
    }
}

// Function to handle cart operations for guests
function handleGuestCart($guest_id, $product_id, $product_name, $product_price, $product_image, $quantity)
{
    global $conn;
    // Check if product is already in the cart
    $query = "SELECT * FROM cart WHERE guest_id = '$guest_id' AND product_id = '$product_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $GLOBALS['message'][] = 'Product already exists in the cart!';
    } else {
        // Insert into guest cart
        $insert_cart = "INSERT INTO cart (guest_id, product_id, product_name, price, image, quantity) 
                        VALUES ('$guest_id', '$product_id', '$product_name', '$product_price', '$product_image', '$quantity')";
        mysqli_query($conn, $insert_cart);

        // Insert into guest_product
        $insert_product = "INSERT INTO guest_product (guest_id, product_id, product_name, price, image, quantity) 
                           VALUES ('$guest_id', '$product_id', '$product_name', '$product_price', '$product_image', '$quantity')";
        mysqli_query($conn, $insert_product);

        $GLOBALS['message'][] = 'Product added successfully to guest cart!';
    }
}

// Function to handle cart operations for logged-in users
function handleUserCart($user_id, $product_id, $product_name, $product_price, $product_image, $quantity)
{
    global $conn;
    // Check if product is already in the cart
    $query = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $GLOBALS['message'][] = 'Product already exists in the cart!';
    } else {
        // Insert into user cart
        $insert_cart = "INSERT INTO cart (user_id, product_id, product_name, price, image, quantity) 
                        VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$product_image', '$quantity')";
        mysqli_query($conn, $insert_cart);

        // Insert into user_product
        $insert_product = "INSERT INTO user_product (user_id, product_id, product_name, price, image, quantity) 
                           VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$product_image', '$quantity')";
        mysqli_query($conn, $insert_product);

        $GLOBALS['message'][] = 'Product added successfully to user cart!';
    }
}
?>

<!-- Display messages -->
<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<div class="message" onclick="this.remove();">' . $msg . '</div>';
    }
}
?>