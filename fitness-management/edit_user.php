<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'Admin') {
    header("Location: dashboard.php");
    exit();
}

// Get user data
if (isset($_GET['id'])) {
    $userID = $_GET['id'];
    $sql = "SELECT * FROM Users WHERE UserID = $userID";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $sql = "UPDATE Users SET Name='$name', Email='$email', Role='$role' WHERE UserID=$userID";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>User updated successfully! <a href='users.php'>Go back</a></div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include 'navbar.php'; ?>
    <h2>Edit User</h2>
    <form method="post" class="border p-4 shadow-lg rounded">
        <input type="hidden" name="id" value="<?= $user['UserID'] ?>">
        
        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input type="text" name="name" class="form-control" value="<?= $user['Name'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="<?= $user['Email'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Role:</label>
            <select name="role" class="form-select">
                <option value="User" <?= ($user['Role'] == 'User') ? 'selected' : '' ?>>User</option>
                <option value="Trainer" <?= ($user['Role'] == 'Trainer') ? 'selected' : '' ?>>Trainer</option>
                <option value="Admin" <?= ($user['Role'] == 'Admin') ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="users.php" class="btn btn-secondary">Back</a>
    </form>
</body>
</html>
