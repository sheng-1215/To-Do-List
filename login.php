<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    $qry = $conn->prepare("SELECT * FROM `task_user` WHERE `user_name` = ?");
    $qry->bind_param("s", $username);
    $qry->execute();
    $result = $qry->get_result();
    $row = $result -> fetch_assoc();

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $username;
        $_SESSION['id'] = $row['id'];
        header('Location: index.php');
        exit();
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Login</h1>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
            <?php endif; ?>
        </form>
        <div class="text-center mt-3">
            <p>Don't have an account? <a href="register.php">Register here</a>.</p>
        </div>
    </div>
</body>
</html>
