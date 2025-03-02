<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Delete User</title>
</head>
<?php
include 'db.php';

if (isset($_GET['id'])) {
    $userID = $_GET['id'];

    // Check if the user is assigned to any workouts
    $checkSql = "SELECT COUNT(*) AS count FROM Workouts WHERE UserID = $userID";
    $result = $conn->query($checkSql);
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo "<div class='alert alert-danger'>Error: Cannot delete user as they have assigned workouts. Please remove associated workouts first. <a href='users.php'>Go back</a></div>";
    } else {
        $sql = "DELETE FROM Users WHERE UserID = $userID";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>User deleted successfully! <a href='users.php'>Go back</a></div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}
?>
