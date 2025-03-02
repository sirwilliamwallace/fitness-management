<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id']; 

$workoutTypes = $conn->query("SELECT WorkoutTypeID, WorkoutType FROM WorkoutTypes");

$trainers = $conn->query("SELECT TrainerID, Name FROM Trainers");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $workoutTypeID = $_POST['workoutTypeID'];
    $trainerID = !empty($_POST['trainerID']) ? $_POST['trainerID'] : "NULL"; // Optional trainer
    $date = $_POST['date'];

    $sql = "INSERT INTO Workouts (UserID, TrainerID, WorkoutTypeID, Date) VALUES ('$userID', $trainerID, '$workoutTypeID', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Workout logged successfully! <a href='workouts.php'>View Workouts</a></div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Log Workout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include 'navbar.php'; ?>
    <h2>Log Your Workout</h2>
    <form method="post" class="border p-4 shadow-lg rounded">
        <div class="mb-3">
            <label class="form-label">Workout Type:</label>
            <select name="workoutTypeID" class="form-select" required>
                <?php while ($type = $workoutTypes->fetch_assoc()): ?>
                    <option value="<?= $type['WorkoutTypeID'] ?>"><?= $type['WorkoutType'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Trainer (Optional):</label>
            <select name="trainerID" class="form-select">
                <option value="">No Trainer</option>
                <?php while ($trainer = $trainers->fetch_assoc()): ?>
                    <option value="<?= $trainer['TrainerID'] ?>"><?= $trainer['Name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Date:</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Log Workout</button>
        <a href="workouts.php" class="btn btn-secondary">Back</a>
    </form>
</body>
</html>
