<?php
include_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    } else {
        $task = $_POST['task'];
        $userId = $_SESSION['id'];

        $qry = $conn->prepare("INSERT INTO `tasks` (`task`, `u_id`) VALUES (?, ?)");
        $qry->bind_param("si", $task, $userId);
        $qry->execute();

        header('Location: index.php');
        exit();
    }  
}
?>
