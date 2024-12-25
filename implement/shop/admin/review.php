<?php

$conn = new mysqli("localhost", "root", "", "shop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = $_GET['search'] ?? ''; 
$search = $conn->real_escape_string($search);

// Construct the query to get all reviews with a search condition
$query = "
    SELECT 
        review.user_id, 
        review.guest_id, 
        review.username, 
        review.phone, 
        review.email, 
        review.review, 
        review.created_at,
        review.id AS review_id
    FROM review
    WHERE review.username LIKE '%$search%' OR review.review LIKE '%$search%'
";

// Execute the query
$result = $conn->query($query);

// Handle review deletion if a delete request is made
if (isset($_POST['delete'])) {
    $review_id = $_POST['review_id'];
    $delete_query = "DELETE FROM review WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $review_id);
    if ($stmt->execute()) {
        echo "<script>alert('Review deleted successfully'); window.location.href = 'review.php';</script>";
    } else {
        echo "<script>alert('Failed to delete review'); window.location.href = 'review.php';</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer and Guest Reviews</title>
    <link rel="stylesheet" href="./admincss/All_client.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }
        .search-input {
            padding: 10px;
            font-size: 16px;
            width: 300px;
        }
        .search-button {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .search-button:hover {
            background-color: #0056b3;
        }
        h1 {
            text-align: center;
            color: #fff; 
            font-size: 36px; 
            font-weight: bold; 
            padding-top: 0px;
            margin-top: 0px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            text-align: left;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .delete-button {
          
            text-decoration: none;
        }
        .delete-button:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>All Reviews</h1>

<div class="search-container">
    <a href="index.php" class="home">Home Page</a>
    <form method="GET">
        <input type="text" name="search" class="search-input" placeholder="Search by Name"
               value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="search-button">Search</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>Guest ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Review</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['user_id'] ?? 'N/A'); ?></td>
                    <td><?= htmlspecialchars($row['guest_id'] ?? 'N/A'); ?></td>
                    <td><?= htmlspecialchars($row['username'] ?? $row['name']); ?></td>
                    <td><?= htmlspecialchars($row['phone']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['review']); ?></td>
                    <td><?= htmlspecialchars($row['created_at']); ?></td>
                    <td>
                        <!-- Delete Button -->
                        <form method="post" onsubmit="return confirm('Are you sure you want to delete this review?');">
                            <input type="hidden" name="review_id" value="<?= htmlspecialchars($row['review_id']); ?>">
                            <button type="submit" name="delete" class="delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No reviews found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php $conn->close(); ?>

</body>
</html>
