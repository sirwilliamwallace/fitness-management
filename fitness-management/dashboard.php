<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];
$userRole = $_SESSION['user_role'];

$stats = [];

// Fetch statistics for Admin
if ($userRole == "Admin") {
    $stats['totalUsers'] = $conn->query("SELECT COUNT(*) AS count FROM Users")->fetch_assoc()['count'];
    $stats['totalTrainers'] = $conn->query("SELECT COUNT(*) AS count FROM Trainers")->fetch_assoc()['count'];
    $stats['totalWorkouts'] = $conn->query("SELECT COUNT(*) AS count FROM Workouts")->fetch_assoc()['count'];
}

// Fetch user-specific stats
if ($userRole == "User" || $userRole == "Trainer") {
    $stats['totalWorkoutsLogged'] = $conn->query("SELECT COUNT(*) AS count FROM Workouts WHERE UserID = $userID")->fetch_assoc()['count'];
    $stats['mostRecentWorkout'] = $conn->query("SELECT Date FROM Workouts WHERE UserID = $userID ORDER BY Date DESC LIMIT 1")->fetch_assoc()['Date'] ?? 'No workouts logged';
    $stats['mostUsedWorkoutType'] = $conn->query("SELECT WorkoutTypes.WorkoutType, COUNT(*) AS count 
        FROM Workouts 
        JOIN WorkoutTypes ON Workouts.WorkoutTypeID = WorkoutTypes.WorkoutTypeID 
        WHERE UserID = $userID 
        GROUP BY Workouts.WorkoutTypeID 
        ORDER BY count DESC 
        LIMIT 1")->fetch_assoc()['WorkoutType'] ?? 'No workouts logged';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include 'navbar.php'; ?>

    <h2 class="mb-4">Welcome, <?= $_SESSION['user_name'] ?>!</h2>

    <div class="row">
        <?php if ($userRole == "Admin"): ?>
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Users</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $stats['totalUsers'] ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Trainers</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $stats['totalTrainers'] ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Total Workouts Logged</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $stats['totalWorkouts'] ?></h5>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Workouts Logged</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $stats['totalWorkoutsLogged'] ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Most Recent Workout</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $stats['mostRecentWorkout'] ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Most Used Workout Type</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $stats['mostUsedWorkoutType'] ?></h5>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
