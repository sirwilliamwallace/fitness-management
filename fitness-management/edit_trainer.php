<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'Admin') {
    header("Location: dashboard.php");
    exit();
}

// Get trainer data
if (isset($_GET['id'])) {
    $trainerID = $_GET['id'];
    $sql = "SELECT * FROM Trainers WHERE TrainerID = $trainerID";
    $result = $conn->query($sql);
    $trainer = $result->fetch_assoc();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trainerID = $_POST['id'];
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];

    $sql = "UPDATE Trainers SET Name='$name', Specialization='$specialization' WHERE TrainerID=$trainerID";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Trainer updated successfully! <a href='trainers.php'>Go back</a></div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Trainer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include 'navbar.php'; ?>
    <h2>Edit Trainer</h2>
    <form method="post" class="border p-4 shadow-lg rounded">
        <input type="hidden" name="id" value="<?= $trainer['TrainerID'] ?>">

        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input type="text" name="name" class="form-control" value="<?= $trainer['Name'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Specialization:</label>
            <input type="text" name="specialization" class="form-control" value="<?= $trainer['Specialization'] ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Trainer</button>
        <a href="trainers.php" class="btn btn-secondary">Back</a>
    </form>
</body>
</html>
