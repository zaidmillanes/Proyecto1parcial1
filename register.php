<?php
// register.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password']; // Se guarda sin encriptar

    $usersFile = 'users.json';
    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

    // Verificar si el usuario ya existe
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            echo "El usuario ya existe. <a href='index.html'>Volver</a>";
            exit;
        }
    }

    $users[] = [
        'username' => $username,
        'password' => $password,
        'perros' => []
    ];

    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

    session_start();
    $_SESSION['username'] = $username;
    header("Location: dashboard.php");
    exit;
} else {
    header("Location: index.html");
    exit;
}
?>
