<?php
include 'db.php';

if (isset($_GET['id'])) {
    $workoutID = $_GET['id'];

    // Delete workout record
    $sql = "DELETE FROM Workouts WHERE WorkoutID = $workoutID";

    if ($conn->query($sql) === TRUE) {
        echo "Workout deleted successfully! <a href='workouts.php'>Go back</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
