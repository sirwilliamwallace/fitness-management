<?php
include 'db.php';

// Fetch Users, Trainers, and WorkoutTypes for dropdowns
$users = $conn->query("SELECT UserID, Name FROM Users");
$trainers = $conn->query("SELECT TrainerID, Name FROM Trainers");
$workoutTypes = $conn->query("SELECT WorkoutTypeID, WorkoutType FROM WorkoutTypes");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['userID'];
    $trainerID = $_POST['trainerID'];
    $workoutTypeID = $_POST['workoutTypeID'];
    $date = $_POST['date'];

    $sql = "INSERT INTO Workouts (UserID, TrainerID, WorkoutTypeID, Date) VALUES ('$userID', '$trainerID', '$workoutTypeID', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Workout added successfully! <a href='workouts.php'>Go back</a></div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Workout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Assign a New Workout</h2>
    <form method="post" class="border p-3">
        <div class="mb-3">
            <label class="form-label">User:</label>
            <select name="userID" class="form-select">
                <?php while ($user = $users->fetch_assoc()): ?>
                    <option value="<?= $user['UserID'] ?>"><?= $user['Name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Trainer:</label>
            <select name="trainerID" class="form-select">
                <?php while ($trainer = $trainers->fetch_assoc()): ?>
                    <option value="<?= $trainer['TrainerID'] ?>"><?= $trainer['Name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Workout Type:</label>
            <select name="workoutTypeID" class="form-select">
                <?php while ($type = $workoutTypes->fetch_assoc()): ?>
                    <option value="<?= $type['WorkoutTypeID'] ?>"><?= $type['WorkoutType'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Date:</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Assign Workout</button>
        <a href="workouts.php" class="btn btn-secondary">Back</a>
    </form>
</body>
</html>
