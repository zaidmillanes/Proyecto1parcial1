<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
$username = $_SESSION['username'];
$usersFile = 'users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

$currentUserIndex = null;
$currentUser = null;
foreach ($users as $key => $user) {
    if ($user['username'] === $username) {
        $currentUserIndex = $key;
        $currentUser = $user;
        break;
    }
}

if(!$currentUser) {
    header("Location: dashboard.php");
    exit;
}

if (!isset($_GET['index'])) {
    header("Location: perros.php");
    exit;
}

$dogIndex = intval($_GET['index']);
if (!isset($currentUser['perros'][$dogIndex])) {
    header("Location: perros.php");
    exit;
}
$dog = $currentUser['perros'][$dogIndex];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newNombre = trim($_POST['nombre']);
    $newDescripcion = $_POST['descripcion'];
    
    $users[$currentUserIndex]['perros'][$dogIndex]['nombre'] = $newNombre;
    $users[$currentUserIndex]['perros'][$dogIndex]['descripcion'] = $newDescripcion;
    
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
    header("Location: perros.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Perro</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Editar Perro</h1>
  <form method="POST">
    <input type="text" name="nombre" placeholder="Nombre del perro" value="<?php echo htmlspecialchars($dog['nombre']); ?>" required>
    <textarea name="descripcion" placeholder="Descripción" required><?php echo htmlspecialchars($dog['descripcion']); ?></textarea>
    <button type="submit">Guardar Cambios</button>
  </form>
  <button onclick="window.location.href='perros.php'">Cancelar</button>
</body>
</html>
