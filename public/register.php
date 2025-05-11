<?php
require_once '../app/Core/Database.php';
include_once __DIR__ . '/../app/Core/SessionHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = Database::connect();

    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        flash('error', 'Email already registered.');
        header('Location: login.php');        
    }

    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->execute([$email, $password]);

    $user_id = $pdo->lastInsertId();
    $log = $pdo->prepare("INSERT INTO user_logs (user_id, action) VALUES (?, ?)");
    $log->execute([$user_id, 'User registered']);

    flash('success', 'Registration successful.');
    header("Location: login.php");
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include '../app/Views/register_form.php';
    include 'menu.php';
    $content = ob_get_clean(); // Capture content
    $title = "Register";
    include 'template.php';    
    exit;
}
?>
