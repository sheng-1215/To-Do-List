<?php
include_once('db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $qry = $conn->prepare("UPDATE tasks SET completed = 1 WHERE id = ?");
    if ($qry) {
        $qry->bind_param("i", $id);
        if ($qry->execute()) {
            if ($qry->affected_rows > 0) {
                header('Location: index.php');
                exit();
            } else {
                echo "Task not found or already completed.";
            }
        } else {
            echo "Failed to execute query.";
        }
    } else {
        echo "Failed to prepare query.";
    }
} else {
    echo "No task ID provided.";
}
?>
