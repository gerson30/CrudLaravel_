<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

/*Route::get('/productos', function () {
    return view('productos.index');
});

//acceder al controlador que se encuentra en la rutahttp/controllers/productosController, y se llama la clase con el metodo create
Route::get('/productos/create',[ProductosController::class,'create']);*/

//para ingresar a todas las rutas se llama el controlador mas la clase
Route::resource('productos',ProductosController::class)->middleware('auth');// aqui se respetara la autenticación o si no no podra ingresar al sistema con "middleware('auth')"..recordemos que esto se hace por temas de seguridad

//ocultar en la autenticacion el boton de registrar y de restablecer contraseña
Auth::routes(['register'=>false,'reset'=>false]);

Route::get('/home', [\HomeController::class, 'index'])->name('home');

// redireccion para cuando el usuaraio se loguee, usara la autenticacion y seguira al controlador productoscontroller y el metodo index
Route::group(['middleware' => 'auth'], function (){
Route::get('/home', [ProductosController::class, 'index'])->name('home');


});

