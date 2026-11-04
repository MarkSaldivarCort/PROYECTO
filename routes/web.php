<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroUsuarios;
use App\Http\Controllers\Login;
use App\Models\Registro;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuarios;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\SuricataController;
use phpseclib4\Net\SSH2;
use App\Http\Controllers\AlertaSuricataController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ExportacionController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\PruebaSeguridadController;


Route::get('/', function () {
    return view('welcome');
});


// Route::get('/registro', function(){
//     return view('registro');
// });
Route::get('/registro',[RegistroUsuarios::class, 'mostrar']);
Route::post('/registro', [RegistroUsuarios::class, 'cargarBD']);

Route::get('/login',[Login::class, 'mostrar'])->name('login');
Route::post('/login',[Login::class, 'ingresar']);

Route::get('/eliminar/{id}', [RegistroUsuarios::class, 'eliminarUsuario']);

Route::get('/prueba-correo', function () {

    Mail::raw('Prueba de correo desde Laravel', function ($mensaje) {
        $mensaje->to('markisaldivar@gmail.com');
        $mensaje->subject('Prueba Laravel');
    });

    //return 'Correo enviado';
});

// Route::get('/email/verificar/{id}/{hash}', function (
//     EmailVerificationRequest $request
// ) {
//      $request->fulfill();
    
//      return view('verificado');
// })->middleware(['auth','signed'])->name('verification.verify');


Route::get('/email/verificar/{id}/{hash}', function ($id, $hash) {

    $usuario = Usuarios::findOrFail($id);

    if (! hash_equals(
        sha1($usuario->getEmailForVerification()),
        $hash
    )) {
        abort(403);
    }

    if (! $usuario->hasVerifiedEmail()) {
        $usuario->markEmailAsVerified();
    }

    return view('verificado');

})->middleware(['signed'])->name('verification.verify');

Route::get('/email/verificar/{id}/{token}', function ($id, $token) {

    $usuario = Usuarios::findOrFail($id);

    // Enlace ya utilizado
    if ($usuario->verification_token === null) {
        return view('correo_ya_verificado');
    }

    // Token incorrecto
    if ($usuario->verification_token !== $token) {
        abort(403);
    }

    // Verificar correo
    $usuario->markEmailAsVerified();

    // Invalidar el enlace
    $usuario->verification_token = null;
    $usuario->save();

    return view('verificado');
});

Route::get('/email/verificar', function () {
    return view('verifica_correo');
})->name('verification.notice');



// Route::post('/registro', function(Request $request) {
//     $nombre = $request -> input('nombre');
//     $apellidos = $request -> input('apellidos');
//     $correo = $request -> input('correo_electronico');
//     $usuario = $request -> input('nombre_de_usuario');
//     $password = $request -> input('contraseña');
//     return view('registro');
// });



Route::get('/suricata', [SuricataController::class, 'eventos']);




Route::get('/empleados', [AlertaSuricataController::class, 'index'])
    ->name('empleados.index');


// Módulo de Recursos Humanos
Route::get('/empleados', [EmpleadoController::class, 'index']);

Route::get('/empleado.php', [EmpleadoController::class, 'show']);

Route::get('/buscar-empleados', [EmpleadoController::class, 'buscar']);

// Exportación
Route::get('/export.php', [ExportacionController::class, 'exportar']);

// Prueba de respuesta con RFC ficticios
Route::get('/prueba-rfc', [PruebaSeguridadController::class, 'rfc']);

// Auditoría
Route::get('/auditoria', [AuditoriaController::class, 'index']);