<?php
// login.php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $usersFile = 'users.json';
    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit;
        }
    }
    echo "Usuario o contraseña incorrectos. <a href='index.html'>Volver</a>";
    exit;
} else {
    header("Location: index.html");
    exit;
}
?>
