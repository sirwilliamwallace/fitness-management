<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];
    
    $sql = "INSERT INTO Users (Name, Email, Password, Role) VALUES ('$name', '$email', '$password', '$role')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Registration successful! <a href='login.php'>Login here</a></div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include 'navbar.php'; ?>
    <h2>Register</h2>
    <form method="post" class="border p-3">
        <div class="mb-3"><label>Name:</label><input type="text" name="name" class="form-control" required></div>
        <div class="mb-3"><label>Email:</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-3"><label>Password:</label><input type="password" name="password" class="form-control" required></div>
        <div class="mb-3">
            <label class="form-label
            ">Role:</label>

            <select name="role" class="form-select">
                <option value="User">User</option>
                <option value="Trainer">Trainer</option>
                <option value="Admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Register</button>
    </form>
</body>
</html>
