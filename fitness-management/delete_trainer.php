<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Delete Trainer</title>
</head>

<?php
include 'db.php';

if (isset($_GET['id'])) {
    $trainerID = $_GET['id'];

    // Check if the trainer is assigned to any workouts
    $checkSql = "SELECT COUNT(*) AS count FROM Workouts WHERE TrainerID = $trainerID";
    $result = $conn->query($checkSql);
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        // bootstrap
        echo "<div class='alert alert-danger'>Error: Cannot delete trainer as they have assigned workouts. Please remove associated workouts first. <a href='trainers.php'>Go back</a></div>";
    } else {
        $sql = "DELETE FROM Trainers WHERE TrainerID = $trainerID";

        if ($conn->query($sql) === TRUE) {
            echo "Trainer deleted successfully! <a href='trainers.php'>Go back</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
