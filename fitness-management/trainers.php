<?php
include 'db.php';
$sql = "SELECT * FROM Trainers";
$result = $conn->query($sql);
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'Admin') {
    header("Location: dashboard.php");
    exit();
}
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Trainers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-3">Trainers List</h2>
    <table class="table table-striped table-bordered">
        <tr><th>ID</th><th>Name</th><th>Specialization</th><th>Actions</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['TrainerID'] ?></td>
                <td><?= $row['Name'] ?></td>
                <td><?= $row['Specialization'] ?></td>
                <td>
                    <a href="edit_trainer.php?id=<?= $row['TrainerID'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_trainer.php?id=<?= $row['TrainerID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="add_trainer.php" class="btn btn-primary">Add New Trainer</a>
    <a href="index.php" class="btn btn-secondary">Back to Home</a>
</body>
</html>
