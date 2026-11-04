<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>REGISTRO.</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="login-box">
        <form method="post"> 
            <h1>Registro de usuario.</h1>
            <label for="nombre">Nombre(s):</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" required>
            <label for="correo">Correo electrónico:</label>
            <input type="text" id="correo" name="correo_electronico" required>
            <label for="nom_usuario">Nombre de usuario:</label>
            <input type="text" id="nom_usuario" name="nombre_de_usuario" required>
            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required>
            <input type="submit" value="REGISTRARSE" name="registro">
        </form>
    </div>
  
    <?php
    include("validar_registro.php");
    ?>
</body>
</html>