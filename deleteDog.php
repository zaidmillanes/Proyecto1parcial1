<?php
// deleteDog.php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit;
}

if (isset($_GET['index'])) {
    $index = intval($_GET['index']);
    $usersFile = 'users.json';
    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

    // Actualizar el usuario actual
    foreach ($users as &$user) {
        if ($user['username'] === $_SESSION['username']) {
            if (isset($user['perros'][$index])) {
                array_splice($user['perros'], $index, 1);
            }
            break;
        }
    }
    unset($user);
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
}
header("Location: perros.php");
exit;
?>
