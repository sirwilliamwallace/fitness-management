<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];
$userRole = $_SESSION['user_role'];

// Get workout data
if (isset($_GET['id'])) {
    $workoutID = $_GET['id'];

    // Ensure the user owns this workout or is an admin
    if ($userRole == "Admin") {
        $sql = "SELECT * FROM Workouts WHERE WorkoutID = $workoutID";
    } else {
        $sql = "SELECT * FROM Workouts WHERE WorkoutID = $workoutID AND UserID = $userID";
    }

    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        die("<div class='alert alert-danger'>You are not authorized to edit this workout. <a href='workouts.php'>Go back</a></div>");
    }

    $workout = $result->fetch_assoc();
}

// Fetch available Workout Types and Trainers
$workoutTypes = $conn->query("SELECT WorkoutTypeID, WorkoutType FROM WorkoutTypes");
$trainers = $conn->query("SELECT TrainerID, Name FROM Trainers");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newWorkoutTypeID = $_POST['workoutTypeID'];
    $newTrainerID = !empty($_POST['trainerID']) ? $_POST['trainerID'] : "NULL";
    $newDate = $_POST['date'];

    $sql = "UPDATE Workouts SET WorkoutTypeID='$newWorkoutTypeID', TrainerID=$newTrainerID, Date='$newDate' WHERE WorkoutID=$workoutID AND UserID=$userID";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Workout updated successfully! <a href='workouts.php'>Go back</a></div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Workout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include 'navbar.php'; ?>
    <h2>Edit Workout</h2>
    <form method="post" class="border p-4 shadow-lg rounded">
        <div class="mb-3">
            <label class="form-label">Workout Type:</label>
            <select name="workoutTypeID" class="form-select" required>
                <?php while ($type = $workoutTypes->fetch_assoc()): ?>
                    <option value="<?= $type['WorkoutTypeID'] ?>" <?= ($workout['WorkoutTypeID'] == $type['WorkoutTypeID']) ? 'selected' : '' ?>><?= $type['WorkoutType'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Trainer (Optional):</label>
            <select name="trainerID" class="form-select">
                <option value="">No Trainer</option>
                <?php while ($trainer = $trainers->fetch_assoc()): ?>
                    <option value="<?= $trainer['TrainerID'] ?>" <?= ($workout['TrainerID'] == $trainer['TrainerID']) ? 'selected' : '' ?>><?= $trainer['Name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Date:</label>
            <input type="date" name="date" class="form-control" value="<?= $workout['Date'] ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Workout</button>
        <a href="workouts.php" class="btn btn-secondary">Back</a>
    </form>
</body>
</html>
