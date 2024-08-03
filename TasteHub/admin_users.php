<?php
session_start();
require 'db_connection.php'; // Include your database connection file

$conn = openConnection(); // Open the database connection

// Handle delete request
if (isset($_GET['delete'])) {
    $userId = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM tblogin WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
    header('Location: admin_users.php');
    exit;
}

// Handle update request
if (isset($_POST['update'])) {
    $userId = intval($_POST['id']);
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    $stmt = $conn->prepare("UPDATE tblogin SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $email, $userId);
    $stmt->execute();
    $stmt->close();
    header('Location: admin_users.php');
    exit;
}

// Fetch users
$sql = "SELECT * FROM tblogin";
$result = $conn->query($sql);
$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
closeConnection($conn); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Users - TASTELOGIC</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 80%;
      margin: auto;
      overflow: hidden;
    }

    header {
      background-color: #ffd700;
      padding: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    nav a {
      color: #333;
      text-decoration: none;
      font-weight: bold;
      padding: 0.5rem 1rem;
    }

    nav a:hover {
      background-color: #fff176;
      border-radius: 5px;
    }

    .button {
      background-color: #00796b;
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 25px;
      text-decoration: none;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }

    .button:hover {
      background-color: #004d40;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }

    table, th, td {
      border: 1px solid #ddd;
    }

    th, td {
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    .action-buttons a, .action-buttons button {
      margin-right: 10px;
    }

    .edit-form {
      display: flex;
      flex-direction: column;
    }

    .edit-form label {
      margin-top: 10px;
    }

    .edit-form input {
      margin-bottom: 10px;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .edit-form button {
      align-self: flex-end;
      margin: 7px;
    }
  </style>
</head>
<body>
<header>
    <div class="header-left">
        <div class="text-3xl font-bold text-teal-600 mr-4">TASTELOGIC</div>
    </div>
    <nav>
        <a href="admin_dashboard.php">Dashboard</a>
    </nav>
</header>

<div class="container">
    <h2>Manage Users</h2>
    
    <!-- Display user list -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td class="action-buttons">
                    <!-- Edit button -->
                    <button class="button" onclick="showEditForm('<?php echo $user['id']; ?>')">Edit</button>
                    
                    <!-- Delete button -->
                    <a href="?delete=<?php echo $user['id']; ?>" class="button" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>

            <!-- Inline Edit Form -->
            <tr id="edit-row-<?php echo $user['id']; ?>" style="display: none;">
                <td colspan="4">
                    <form method="post" class="edit-form">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        <label for="username-<?php echo $user['id']; ?>">Username:</label>
                        <input type="text" id="username-<?php echo $user['id']; ?>" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        <label for="email-<?php echo $user['id']; ?>">Email:</label>
                        <input type="email" id="email-<?php echo $user['id']; ?>" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        <button type="submit" name="update" class="button">Update</button>
                        <button type="button" class="button" onclick="hideEditForm('<?php echo $user['id']; ?>')">Cancel</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function showEditForm(userId) {
    document.getElementById('edit-row-' + userId).style.display = 'table-row';
}

function hideEditForm(userId) {
    document.getElementById('edit-row-' + userId).style.display = 'none';
}
</script>

</body>
</html>
