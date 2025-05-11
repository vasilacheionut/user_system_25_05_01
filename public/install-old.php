<?php
$host = 'localhost';
$db = 'user_system';
$user = 'root';
$pass = 'Pogimamoru1@';
$charset = 'utf8mb4';

try {
    // Conectare fără nume DB pentru a crea baza de date
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Creare DB dacă nu există
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET $charset COLLATE utf8mb4_general_ci");

    echo "Database '$db' checked/created.<br>";

    // Conectare la DB
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tabelul users
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('user', 'admin', 'root') NOT NULL DEFAULT 'user'
        )
    ");
    echo "Table 'users' created.<br>";

    // Tabelul user_logs
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS user_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            action TEXT NOT NULL,
            log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )
    ");
    echo "Table 'user_logs' created.<br>";

    // Adaugă root admin dacă nu există
    $check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'root'");
    $check->execute();
    if ($check->fetchColumn() == 0) {
        $email = 'root@admin.com';
        $password = password_hash('rootpass', PASSWORD_DEFAULT);
        $insert = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, 'root')");
        $insert->execute([$email, $password]);
        echo "Root user added: <strong>$email / rootpass</strong><br>";
    } else {
        echo "Root user already exists.<br>";
    }

    echo "<br><strong>Installation complete!</strong>";

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
