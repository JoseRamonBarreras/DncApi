<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Cia;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login','Auth\\LoginController@login');
Route::post('logout','Auth\\LogoutController@logout');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum','role:SISTEMAS')->group(function () {
    Route::get('users/logs','Admin\\UserController@logs');
    Route::get('users/roles','Admin\\UserController@roles');
    Route::get('users/usuarios','Admin\\UserController@index');
    Route::get('users/usuario/{user}','Admin\\UserController@show');
    Route::post('users/usuario/store','Admin\\UserController@store');
    Route::put('users/usuario/update/{usuario}','Admin\\UserController@update');
    Route::delete('users/usuario/delete','Admin\\UserController@destroy');
    Route::put('users/usuario/reset_password','Admin\\UserController@resetPassword');
});

Route::middleware('auth:sanctum','role:ADMINISTRADOR')->group(function () {
    Route::get('ajustes/{id}','Cliente\\AjusteController@ajustes');
    Route::post('ajustes/logo','Cliente\\AjusteController@storeLogo');
    Route::post('ajustes/portada','Cliente\\AjusteController@storePortada');
    Route::post('ajustes/nombre','Cliente\\AjusteController@storeNombre');

    Route::get('datos/{id}','Cliente\\DatosController@datos');
    Route::post('datos/direccion','Cliente\\DatosController@storeDireccion');
    Route::post('datos/whatsapp','Cliente\\DatosController@storeWhatsapp');

    Route::get('puestos/{id}','Cliente\\PuestoController@puestos');
    Route::post('puestos/puesto','Cliente\\PuestoController@storePuesto');
    Route::put('puestos/puesto/{id}','Cliente\\PuestoController@updatePuesto');
    Route::delete('puestos/puesto/{id}','Cliente\\PuestoController@deletePuesto');

    Route::get('usuarios/{id}','Cliente\\UsuarioController@index');
    Route::post('usuarios/usuario','Cliente\\UsuarioController@store');
    Route::put('usuarios/usuario/{id}','Cliente\\UsuarioController@update');
    Route::delete('usuarios/usuario/{id}','Cliente\\UsuarioController@delete');
});

// Route::middleware('auth:sanctum','role:SISTEMAS|USUARIO')->group(function () {
   
//     //Mascotas
//     Route::get('mascotas', 'Admin\\MascotaController@index');
//     Route::get('mascotas/especies', 'Admin\\MascotaController@especies');
//     Route::post('mascotas', 'Admin\\MascotaController@store');
    
//     Route::put('mascotas/{id}', 'Admin\\MascotaController@update');
//     Route::delete("mascotas/{id}", 'Admin\\MascotaController@destroy');
//     Route::get('mascotas/descargar/qr/{id}', 'Admin\\MascotaController@descargarQr');

//     //UserProfile
//     Route::get('user_profile/{id}','Admin\\DashboardController@usuario');
//     Route::post('user_profile','Admin\\DashboardController@updateProfile');
//     Route::put('user_profile/privacy_control','Admin\\DashboardController@switchControl');


// });

Route::get('ajustes/view/qr/{id}', 'Cliente\\AjusteController@viewQr');
// Route::get("mascotas/{id}", 'Admin\\MascotaController@show');
