<?php
session_start();
$host = 'localhost';
$db = 'todolist';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

?>
