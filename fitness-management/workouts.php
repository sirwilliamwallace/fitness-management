<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];
$userRole = $_SESSION['user_role'];

// Fetch workouts based on role
if ($userRole == "Admin") {
    $sql = "SELECT Workouts.WorkoutID, Users.Name AS UserName, Trainers.Name AS TrainerName, WorkoutTypes.WorkoutType, Workouts.Date
            FROM Workouts
            JOIN Users ON Workouts.UserID = Users.UserID
            JOIN Trainers ON Workouts.TrainerID = Trainers.TrainerID
            JOIN WorkoutTypes ON Workouts.WorkoutTypeID = WorkoutTypes.WorkoutTypeID";
} else {
    $sql = "SELECT Workouts.WorkoutID, Trainers.Name AS TrainerName, WorkoutTypes.WorkoutType, Workouts.Date
            FROM Workouts
            JOIN Trainers ON Workouts.TrainerID = Trainers.TrainerID
            JOIN WorkoutTypes ON Workouts.WorkoutTypeID = WorkoutTypes.WorkoutTypeID
            WHERE Workouts.UserID = $userID";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Workouts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include 'navbar.php'; ?>
    <h2 class="mb-3">Workout Records</h2>

    <a href="log_workout.php" class="btn btn-success mb-3">Log a New Workout</a>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-striped table-bordered">
            <tr>
                <th>ID</th>
                <?php if ($userRole == "Admin") echo "<th>User</th>"; ?>
                <th>Trainer</th>
                <th>Workout Type</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['WorkoutID'] ?></td>
                    <?php if ($userRole == "Admin") echo "<td>{$row['UserName']}</td>"; ?>
                    <td><?= $row['TrainerName'] ?></td>
                    <td><?= $row['WorkoutType'] ?></td>
                    <td><?= $row['Date'] ?></td>
                    <td>
                        <a href="edit_workout.php?id=<?= $row['WorkoutID'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_workout.php?id=<?= $row['WorkoutID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this workout?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No workouts found.</div>
    <?php endif; ?>
</body>
</html>
