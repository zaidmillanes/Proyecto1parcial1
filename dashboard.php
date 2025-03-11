<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: index.html");
    exit;
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Bienvenido, <?php echo htmlspecialchars($username); ?></h1>
  <button onclick="window.location.href='logout.php'">Cerrar Sesión</button>
  <button onclick="window.location.href='perros.php'">Gestionar Perros</button>
</body>
</html>
