<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>REGISTRO.</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="login-box">
        <form method="post" action="/registro">
            @csrf 
            <h1>Registro de usuario.</h1>

            <label for="nombre">Nombre(s):</label>
            <input type="text" id="nombre" name="nombre" 
                required maxlength="25" value="{{old('nombre')}}">

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" 
                required maxlength="30" value="{{old('apellidos')}}">

            <label for="correo">Correo electrónico:</label>
            <input type="text" id="correo" name="correo_electronico" 
                required maxlength="50" value="{{$errors->has('correo_electronico') ? '': old('correo_electronico')}}">
            @error('correo_electronico')
                <p>{{ $message }}</p>
            @enderror

            <label for="tel">Teléfono:</label>
            <input type="text" id="tel" name="telefono" 
                required maxlength="12" value="{{$errors->has('telefono') ? '': old('telefono')}}">
            @error('telefono')
                <p>{{ $message }}</p>
            @enderror

            <label for="nom_usuario">Nombre de usuario:</label>
            <input type="text" id="nom_usuario" name="nombre_de_usuario" 
                required maxlength="15" value="{{$errors->has('nombre_de_usuario') ? '': old('nombre_de_usuario')}}">
            @error('nombre_de_usuario')
                <p>{{ $message }}</p>
            @enderror

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required minlength="8">
            @error('password')
                <p>{{ $message }}</p>
            @enderror

            <label for="passw_confirmacion">Confirmar contraseña:</label>
            <input type="password" id="passw_confirmacion" name="password_confirmation" required minlength="8">

            <input type="submit" value="REGISTRARSE" name="registro">
        </form>
    </div>
</body>
</html>
