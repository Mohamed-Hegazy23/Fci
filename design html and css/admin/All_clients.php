<!DOCTYPE html>
<html>
<head>
    <title>Customer Management</title>
     <link rel="stylesheet" href="./admincss/All_client.css">
</head>
<body>

    <?php
    // Database connection
    $conn = new mysqli("localhost", "root", "", "online_shop");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete record if delete_id is set
    if (isset($_GET['delete_id'])) {
        $delete_id = intval($_GET['delete_id']);
        $stmt = $conn->prepare("DELETE FROM client_table WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
        echo "<p style='color: green;'>Customer deleted successfully!</p>";
    }

    // Retrieve data
    $search = $_GET['search'] ?? '';
    $search = $conn->real_escape_string($search);
    $query = "SELECT id, username, email, phone, address FROM client_table WHERE username LIKE '%$search%'";
    $result = $conn->query($query);
    ?>

    <div class="search-container">

        <a href="index.php" class ="home">home page</a>

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
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['phone']); ?></td>
                        <td><?= htmlspecialchars($row['address']); ?></td>
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
                    <td colspan="5">No results found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>

</body>
</html>