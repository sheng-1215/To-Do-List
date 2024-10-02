<?php
// session_start();
// echo $_SESSION['user'];
include_once('db.php');

$result = null;

if (!isset($_SESSION['user'])) {
    $qry = $conn->prepare("SELECT * FROM tasks INNER JOIN task_user
                           ON tasks.u_id = task_user.id
                           ORDER BY tasks.created_at DESC");
    if ($qry) {
        $qry->execute();
        $result = $qry->get_result();
    } else {
        echo "Failed to prepare query";
    }
} else {
    $id = $_SESSION['id'];
    $qry = $conn->prepare("SELECT * FROM tasks INNER JOIN task_user
                           ON tasks.u_id = task_user.id
                           WHERE tasks.u_id = ?
                           ORDER BY tasks.created_at DESC");

    if ($qry) {
        $qry->bind_param("i", $id);
        $qry->execute();
        $result = $qry->get_result();
    } else {
        echo "Failed to prepare query";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome To-Do List</h1>

        <form action="add_tasks.php" method="POST" class="task-input">
            <div class="input-group">
                <input type="text" name="task" class="form-control" placeholder="Add a new task..." required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Add Task</button>
                </div>
            </div>
        </form>

        <?php if (isset($_SESSION['user'])) { ?>
            <div class="logout-section">
                <form method="POST" action="logout.php">
                    <button type="submit" name="logout" class="btn logout-btn">Logout</button>
                </form>
            </div>
        <?php } ?>

        <h2 class="mt-4">Your Tasks</h2>
        <ul class="list-group">
            <?php if ($result && $result->num_rows > 0) { ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?php echo htmlspecialchars($row['task']); ?></span>
                        <div>
                            <?php if (!isset($_SESSION['user'])) { ?>
                                <span class="badge badge-secondary"><?php echo htmlspecialchars($row['user_name']); ?></span>
                            <?php } else { ?>
                                <?php if (!$row['completed']) { ?>
                                    <a href="complete_tasks.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Complete</a>
                                <?php } else { ?>
                                    <span class="badge badge-success">Completed</span>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </li>
                <?php } ?>
            <?php } else { ?>
                <li class="list-group-item no-tasks">No tasks available.</li>
            <?php } ?>
        </ul>

        <div class="footer">
            <p>&copy; <?= date("Y") ?> &nbsp;To-Do List of NG WEI SHENG. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
