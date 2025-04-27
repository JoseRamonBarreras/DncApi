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
    Route::get('dashboard/logs','Admin\\DashboardController@logs');
    Route::get('dashboard/roles','Admin\\DashboardController@roles');
    Route::post('dashboard/roles/guardar','Admin\\DashboardController@saveRol');
    Route::put('dashboard/roles/actualizar','Admin\\DashboardController@updateRol');
    Route::get('dashboard/usuarios','Admin\\DashboardController@usuarios');
    Route::get('dashboard/usuario/{id}','Admin\\DashboardController@usuario');
    Route::post('dashboard/usuario/guardar','Admin\\DashboardController@registerUsuario');
    Route::put('dashboard/usuario/actualizar/{usuario}','Admin\\DashboardController@updateUsuario');
    Route::delete('dashboard/usuario/eliminar','Admin\\DashboardController@deleteUsuario');
    Route::put('dashboard/usuario/reset_password','Admin\\DashboardController@resetPassword');
    Route::get('dashboard/usuario/profile/rh','Admin\\DashboardController@getProfileFromRH');
});

Route::middleware('auth:sanctum','role:SISTEMAS|USUARIO')->group(function () {
   
    //Mascotas
    Route::get('mascotas', 'Admin\\MascotaController@index');
    Route::get('mascotas/especies', 'Admin\\MascotaController@especies');
    Route::post('mascotas', 'Admin\\MascotaController@store');
    
    Route::put('mascotas/{id}', 'Admin\\MascotaController@update');
    Route::delete("mascotas/{id}", 'Admin\\MascotaController@destroy');
    Route::get('mascotas/descargar/qr/{id}', 'Admin\\MascotaController@descargarQr');


});

Route::get('mascotas/view/qr/{id}', 'Admin\\MascotaController@viewQr');
Route::get("mascotas/{id}", 'Admin\\MascotaController@show');
