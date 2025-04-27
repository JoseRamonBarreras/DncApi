<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/limpia-cache', function () {
    Artisan::call('optimize:clear');
    return "Se Limpio El Cache";
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return "Se Creo el enlace simbolico";
});


