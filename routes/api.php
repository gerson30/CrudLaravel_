<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Models\Productos;
use App\Http\Controllers\ProductosController;
use App\Models\Productos as ModelsProductos;
use App\Resources\ProductosResource;





//Get all Productos
Route::get('/productos', [ProductosController::class, 'getProductos']);
//Get detalles de solo un id en especifico
Route::get('/productos/{id}', [ProductosController::class, 'getProductosById']);
// agrrgar producto
Route::post('/addProductos', [ProductosController::class, 'addProductos']);

// Actualizar Productos
Route::put('/updateProductos/{id}', [ProductosController::class, 'updateProductos']);

// Eliminar Producto
Route::delete('/deleteProductos/{id}', [ProductosController::class, 'deleteProductos']);




Route::middleware('auth:sactum')->get('/user', function (Request $request){
    return $request->user();
});