<?php
include('conexion_de_bd.php');
//Verifica que todos los campos se hayan llenado.
if(isset($_POST['registro'])){
    if($_POST['nombre'] > 1 || $_POST['apellidos'] > 1 || $_POST['correo_electronico'] > 1 || $_POST['nombre_de_usuario'] > 1 || $_POST['contraseña'] > 1){
        $nom = trim($_POST['nombre']);
        $ape = trim($_POST['apellidos']);
        $correo = trim($_POST['correo_electronico']);
        $nom_usu = trim($_POST['nombre_de_usuario']);
        $contra = trim($_POST['contraseña']);
        $hash = password_hash($contra, PASSWORD_DEFAULT);
        //Asigna los valores a los campos de la tabla de la base de datos y los carga
        $consulta = "INSERT INTO registrodeusuarios(nombre, apellidos, correo_electronico, usuario, contraseña) VALUES ('$nom', '$ape', '$correo', '$nom_usu', '$hash')";
        $cargar_datos = mysqli_query($conexion, $consulta);
        
        //Verificar si se cargaron los datos.
        if($cargar_datos){
            ?>
            <h3>EL REGISTRO SE REALIZÓ CORRECTAMENTE.</h3>
            <?php
        }else{
            ?>
            <h3>Hubo un error.</h3>
            <?php
        }
    }
    else{
        ?>
        <h3>"Favor de llenar todos los campos solicitados."</h3>
        <?php
    }
}
?>