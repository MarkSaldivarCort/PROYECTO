<?php

include("conexion_de_bd.php");
session_start();

$usuario = trim($_POST['usuario']);
$password = $_POST['clave'];

$sql = "SELECT * FROM registrodeusuarios WHERE usuario = ?";

$stmt = mysqli_prepare($conexion, $sql);    

mysqli_stmt_bind_param($stmt, "s", $usuario);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if ($fila = mysqli_fetch_assoc($resultado)) {

    // Comprobar la contraseña
    if (password_verify($password, $fila['contraseña'])) {

        // Contraseña correcta
        $_SESSION['id'] = $fila['id'];
        $_SESSION['usuario'] = $fila['usuario'];

        header("Location: index.php");
        exit();

    } else {

        echo "Contraseña incorrecta.";

    }

} else {

    echo "El usuario no existe.";

}


?>