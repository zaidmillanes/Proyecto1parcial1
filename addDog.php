<?php
// addDog.php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $descripcion = $_POST['descripcion'];

    // Obtener imagen desde la API de Dog CEO
    $apiUrl = 'https://dog.ceo/api/breeds/image/random';
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);
    $imagen = isset($data['message']) ? $data['message'] : 'https://via.placeholder.com/200';

    $usersFile = 'users.json';
    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

    // Actualizar el usuario actual
    foreach ($users as &$user) {
        if ($user['username'] === $_SESSION['username']) {
            if (!isset($user['perros'])) {
                $user['perros'] = [];
            }
            $user['perros'][] = [
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'imagen' => $imagen
            ];
            break;
        }
    }
    unset($user);
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
    header("Location: perros.php");
    exit;
} else {
    header("Location: perros.php");
    exit;
}
?>
