<?php

$conn = new mysqli("localhost", "root", "", "online_shop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM review WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
   
}


$search = $_GET['search'] ?? ''; 
$search = $conn->real_escape_string($search);

// Construct the query
$query = "
    SELECT client_table.username, client_table.email, review.review, review.id 
    FROM client_table 
    INNER JOIN review ON client_table.id = review.id
    WHERE client_table.username LIKE '%$search%'
";

// Execute the query
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Management</title>
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
            color: red;
            text-decoration: none;
        }
        .delete-button:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="search-container">
    <a href="index.php" class="home">Home Page</a>
    <form method="GET">
        <input type="text" name="search" class="search-input" placeholder="Enter Username" 
               value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="search-button">Search</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Review</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['username']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['review']); ?></td>
                    <td>
                        <a href="?delete_id=<?= $row['id']; ?>" class="delete-button" 
                           onclick="return confirm('Are you sure you want to delete this customer?');">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No results found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php $conn->close(); ?>

</body>
</html>
