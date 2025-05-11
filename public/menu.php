<?php
$user = $_SESSION['user'] ?? null;
?>

<div class="navbar">
    <div class="left">
        <a href="dashboard.php">Home</a>
        <?php if ($user): ?>
            <a href="user_logs.php">Logs</a>
            <?php if ($user['role'] === 'root'): ?>
                <a href="root_admin.php">Root Panel</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="right">
        <?php if ($user): ?>
            <span><?= htmlspecialchars($user['email']) ?> (<?= $user['role'] ?>)</span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</div>


<?php
/* 
if (!isset($_SESSION['user'])) {
    echo "<p><a href='login.php'>Login</a> | <a href='register.php'>Register</a></p>";
    return;
}

$user = $_SESSION['user'];
echo "<p>Logged in as: <strong>" . htmlspecialchars($user['email']) . "</strong> (" . $user['role'] . ")</p>";

echo "<nav>";
echo "<a href='dashboard.php'>Dashboard</a> | ";
echo "<a href='user_logs.php'>Logs</a> | ";

if ($user['role'] === 'root') {
    echo "<a href='root_admin.php'>Root Admin</a> | ";
}

echo "<a href='logout.php'>Logout</a>";
echo "</nav><hr>";
 */