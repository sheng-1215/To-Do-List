<?php
include_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    $qry = $conn->prepare("SELECT * FROM `task_user` WHERE `user_name` = ?");
    $qry->bind_param("s", $username);
    $qry->execute();
    $result = $qry->get_result();
    $row = $result -> fetch_assoc();

    if ($result->num_rows > 0) {
        $error = "This name already exists";
    } else {
        $insert_qry = $conn->prepare("INSERT INTO `task_user`(`user_name`) VALUES (?)");
        $insert_qry->bind_param("s", $username);
        
        if ($insert_qry) {
            $id = $row['id'];
            $_SESSION['id'] = $id;
            $_SESSION['user'] = $username;
            header('Location: index.php');
            exit();
        } else {
            echo "Registration failed";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Register</h1>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <div class="text-center mt-3">
            <p>Have an account? <a href="login.php">Login here</a>.</p>
        </div>
    </div>
</body>
</html>
