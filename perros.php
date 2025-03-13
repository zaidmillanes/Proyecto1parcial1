<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: index.php");
    exit;
}
$username = $_SESSION['username'];

$usersFile = 'users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];
$currentUser = null;
foreach($users as $user){
    if($user['username'] === $username){
        $currentUser = $user;
        break;
    }
}
$perros = isset($currentUser['perros']) ? $currentUser['perros'] : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Perros</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Gestión de Perros</h1>
  <button onclick="window.location.href='logout.php'">Cerrar Sesión</button>

  <h2>Agregar Perro</h2>
  <form action="addDog.php" method="POST">
    <input type="text" name="nombre" placeholder="Nombre del perro" required>
    <textarea name="descripcion" placeholder="Descripción" required></textarea>
    <button type="submit">Agregar Perro</button>
  </form>

  <h2>Mis Perros</h2>
  <?php if(count($perros) > 0): ?>
    <?php foreach($perros as $index => $perro): ?>
      <div class="post">
        <h3><?php echo htmlspecialchars($perro['nombre']); ?></h3>
        <p><?php echo htmlspecialchars($perro['descripcion']); ?></p>
        <img src="<?php echo htmlspecialchars($perro['imagen']); ?>" width="200" alt="Imagen del perro">
        <form action="deleteDog.php" method="GET" style="display:inline;">
          <input type="hidden" name="index" value="<?php echo $index; ?>">
          <button type="submit">Eliminar</button>
        </form>
        <button onclick="window.location.href='editDog.php?index=<?php echo $index; ?>'">Editar</button>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>No hay perros registrados.</p>
  <?php endif; ?>
</body>
</html>
