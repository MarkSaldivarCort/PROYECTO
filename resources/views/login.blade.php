<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio de sesión</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
   @if(session('success'))
            <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
  <div class="login-box">
    <h2>Acceso de usuarios</h2>
    <form method="POST" action="/login">
        @csrf
        <label for="nombre_de_usuario">Nombre de usuario:</label>
        <input type="text" name="nombre_de_usuario" required value="{{old('nombre_de_usuario')}}">
        @if(session('error'))
            <p>{{ session('error') }}</p>
        @endif
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
      
        <input type="submit" value="Entrar">
    </form>
  </div>

</body>
</html>