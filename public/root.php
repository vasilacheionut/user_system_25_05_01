<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'root') {
    die("Access denied.");
}

echo "Welcome, Root Admin!";
?>

<?php
include 'menu.php';
?>

<h1>Admin</h1>