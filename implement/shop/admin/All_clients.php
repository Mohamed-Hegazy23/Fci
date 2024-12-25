<!DOCTYPE html>
<html>
<head>
    <title>Customer Management</title>
    <link rel="stylesheet" href="./admincss/All_client.css">
</head>
<body>

    <?php
    // Database connection
    $conn = new mysqli("localhost", "root", "", "shop");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete record if delete_id is set
    if (isset($_GET['delete_id'])) {
        $delete_id = intval($_GET['delete_id']);
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Customer deleted successfully!');</script>";
    }

    // Retrieve data
    $search = $_GET['search'] ?? '';
    $search = $conn->real_escape_string($search);
    $query = "SELECT user_id, username, email, full_name, address, phone, created_at FROM users WHERE username LIKE '%$search%'";
    $result = $conn->query($query);
    ?>

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
                <th>Full Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['full_name']); ?></td>
                        <td><?= htmlspecialchars($row['phone']); ?></td>
                        <td><?= htmlspecialchars($row['address']); ?></td>
                        <td><?= htmlspecialchars($row['created_at']); ?></td>
                        <td>
                            <a href="?delete_id=<?= $row['user_id']; ?>" class="delete-button" 
                               onclick="return confirm('Are you sure you want to delete this customer?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No results found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>

</body>
</html>
