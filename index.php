<?php
session_start();

// Si el usuario no ha iniciado sesión, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio - Mi Web</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <h1>Bienvenido <?php echo $_SESSION['usuario']; ?></h1>
  <p>Has iniciado sesión correctamente.</p>

  <nav>
    <a href="perfil.php">Mi perfil</a> |
    <a href="logout.php">Cerrar sesión</a>
  </nav>
</body>
</html>
