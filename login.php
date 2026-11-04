<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio de sesión</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <div class="login-box">
    <h2>Acceso de usuarios</h2>
    <form method="POST" action="validar_login.php">
      <label for="usuario">Usuario:</label>
      <input type="text" name="usuario" required>
      
      <label for="clave">Contraseña:</label>
      <input type="password" name="clave" required>
      
      <input type="submit" value="Entrar">
    </form>
  </div>

</body>
</html>
