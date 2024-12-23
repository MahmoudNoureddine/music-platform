<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to Your Dashboard!</h1>
    <p>You are successfully logged in.</p>

    <!-- Logout -->
    <form action="../app/controllers/AuthController.php" method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>
</body>
</html>

