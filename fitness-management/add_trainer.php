<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];

    $sql = "INSERT INTO Trainers (Name, Specialization) VALUES ('$name', '$specialization')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Trainer added successfully! <a href='trainers.php'>Go back</a></div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Trainer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Add a New Trainer</h2>
    <form method="post" class="border p-3">
        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Specialization:</label>
            <input type="text" name="specialization" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Trainer</button>
        <a href="trainers.php" class="btn btn-secondary">Back</a>
    </form>
</body>
</html>
