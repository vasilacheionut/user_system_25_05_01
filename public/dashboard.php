<?php
session_start();
ob_start(); // Start output buffering

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

echo "Welcome, " . htmlspecialchars($_SESSION['user']['email']) . "!";

echo "<a href='logout.php'>Logout</a><br>";
echo "<a href='user_logs.php'>View Logs</a><br>";

if ($_SESSION['user']['role'] === 'root') {
    echo "<a href='root_admin.php'>Root Admin Panel</a><br>";
}
?>

<h1>Dashboard</h1>
<p>Bine ai venit, <?= htmlspecialchars($_SESSION['user']['email'] ?? 'Vizitator'); ?>!</p>
<?php
$content = ob_get_clean(); // Capture content
$title = "Dashboard";
include 'template.php';
