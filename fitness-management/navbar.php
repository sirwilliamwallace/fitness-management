<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Fitness Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="workouts.php">View Workouts</a></li>

                    <?php if ($_SESSION['user_role'] == 'User'): ?>
                        <li class="nav-item"><a class="nav-link" href="log_workout.php">Log Workout</a></li>
                    <?php endif; ?>

                    <?php if ($_SESSION['user_role'] == 'Trainer'): ?>
                        <li class="nav-item"><a class="nav-link" href="add_workout.php">Assign Workouts</a></li>
                    <?php endif; ?>

                    <?php if ($_SESSION['user_role'] == 'Admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="users.php">Manage Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="trainers.php">Manage Trainers</a></li>
                    <?php endif; ?>

                    <li class="nav-item"><a class="nav-link btn btn-danger text-white px-3" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link btn btn-primary text-white px-3" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-success text-white px-3" href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
