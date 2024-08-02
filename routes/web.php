<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AgregarController;
use App\Http\Controllers\AñadirusuarioController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\VisualizarMarcaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\RealizarCompraController;
use App\Http\Controllers\RealizaventaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ReporteVentasController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\RolAccesoController;
use App\Http\Controllers\GestionRolAccesoController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\AsignarRolController;
use App\Http\Controllers\BilleteraController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


// Ruta para el dashboard protegida por autenticación
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Route::get('/notifications', [NotificationController::class, 'fetchNotifications'])
// ->name('notifications.fetch');
// Rutas protegidas por autenticación usando el middleware 'auth'

Route::middleware('auth')->group(function () {

    $productoRoutes = [
        ['method' => 'get', 'uri' => '/productos', 'action' => 'index', 'name' => 'producto'],
        ['method' => 'post', 'uri' => '/productos', 'action' => 'store', 'name' => 'productos.store'],
        ['method' => 'get', 'uri' => '/productos/{id}', 'action' => 'show', 'name' => 'productos.show'],
        ['method' => 'put', 'uri' => '/productos/{id}', 'action' => 'update', 'name' => 'productos.update'],
        ['method' => 'delete', 'uri' => '/productos/{id}', 'action' => 'destroy', 'name' => 'productos.destroy'],
    ];

    // Iterar sobre el arreglo para definir las rutas
    foreach ($productoRoutes as $route) {
        Route::{$route['method']}($route['uri'], [ProductoController::class, $route['action']])->name($route['name']);
    }

    Route::get('/agregar', [AgregarController::class, 'index'])->name('agregar');

    // Rutas de MarcaController
    $marcaRoutes = [
        ['method' => 'get', 'uri' => '/marca', 'action' => 'create', 'name' => 'marca'],
        ['method' => 'post', 'uri' => '/marca', 'action' => 'store', 'name' => 'marcas.store'],
        ['method' => 'put', 'uri' => '/marcas/{id}', 'action' => 'update', 'name' => 'marcas.update'],
        ['method' => 'get', 'uri' => '/marcas', 'action' => 'index', 'name' => 'marcas.index'],
        ['method' => 'get', 'uri' => '/marcas/{id}', 'action' => 'show', 'name' => 'marcas.show'],
    ];
    foreach ($marcaRoutes as $route) {
        Route::{$route['method']}($route['uri'], [MarcaController::class, $route['action']])->name($route['name']);
    }

    // Rutas de UsuariosController
    $usuarioRoutes = [
        ['method' => 'get', 'uri' => '/usuarios', 'action' => 'index', 'name' => 'usuarios.index'],
        ['method' => 'get', 'uri' => '/usuarios/create', 'action' => 'create', 'name' => 'usuarios.create'],
        ['method' => 'post', 'uri' => '/usuarios', 'action' => 'store', 'name' => 'usuarios.store'],
        ['method' => 'post', 'uri' => '/usuarios/update-foto', 'action' => 'updateFoto', 'name' => 'usuarios.updateFoto'],
        ['method' => 'put', 'uri' => '/profile/update', 'action' => 'update', 'name' => 'profile.update'],
    ];
    foreach ($usuarioRoutes as $route) {
        Route::{$route['method']}($route['uri'], [UsuariosController::class, $route['action']])->name($route['name']);
    }

    // Rutas de VisualizarMarcaController
    Route::get('/visualizarmarca', [VisualizarMarcaController::class, 'index'])->name('visualizarmarca');

    // Rutas de AñadirusuarioController
    Route::get('/Añadirususario', [AñadirusuarioController::class, 'index'])->name('Añadirusuario');

    // Rutas de RealizaventaController
    $realizaVentaRoutes = [
        ['method' => 'get', 'uri' => 'realizaventas', 'action' => 'index', 'name' => 'realizaventas'],
        ['method' => 'get', 'uri' => 'realizaventas/buscar-usuarios', 'action' => 'buscarUsuarios', 'name' => 'realizaventas.buscarUsuarios'],
        ['method' => 'get', 'uri' => 'realizaventas/buscar-productos', 'action' => 'buscarProductos', 'name' => 'realizaventas.buscarProductos'],
        ['method' => 'post', 'uri' => 'realizaventas/guardar-venta', 'action' => 'guardarVenta', 'name' => 'realizaventas.guardarVenta'],
    ];
    foreach ($realizaVentaRoutes as $route) {
        Route::{$route['method']}($route['uri'], [RealizaventaController::class, $route['action']])->name($route['name']);
    }

    // Rutas de RealizarCompraController
    $realizaCompraRoutes = [
        ['method' => 'get', 'uri' => '/realizacompras', 'action' => 'index', 'name' => 'realizacompras.index'],
        ['method' => 'post', 'uri' => '/realizacompras', 'action' => 'guardarCompra', 'name' => 'realizacompras.guardarCompra'],
        ['method' => 'get', 'uri' => '/realizacompras/buscarProductos', 'action' => 'buscarProductos', 'name' => 'realizacompras.buscarProductos'],
        ['method' => 'get', 'uri' => '/realizacompras/buscarUsuarios', 'action' => 'buscarProveedores', 'name' => 'realizacompras.buscarProveedores'],
        ['method' => 'post', 'uri' => '/realizacompras/store', 'action' => 'store', 'name' => 'realizacompras.store'],
    ];
    foreach ($realizaCompraRoutes as $route) {
        Route::{$route['method']}($route['uri'], [RealizarCompraController::class, $route['action']])->name($route['name']);
    }

    // Rutas de HistorialController
    $historialRoutes = [
        ['method' => 'get', 'uri' => '/historial', 'action' => 'index', 'name' => 'historial.index'],
        ['method' => 'get', 'uri' => 'historial/detalles/{id}', 'action' => 'detalles', 'name' => 'historial.detalles'],
        ['method' => 'get', 'uri' => '/historial/filtrar', 'action' => 'filtrar', 'name' => 'historial.filtrar'],
    ];
    foreach ($historialRoutes as $route) {
        Route::{$route['method']}($route['uri'], [HistorialController::class, $route['action']])->name($route['name']);
    }

    // Rutas de StockController
    $stockRoutes = [
        ['method' => 'get', 'uri' => '/stock', 'action' => 'index', 'name' => 'operacionesstock.index'],
        ['method' => 'post', 'uri' => '/operacionesstock/update', 'action' => 'update', 'name' => 'operacionesstock.update'],
        ['method' => 'get', 'uri' => '/productos/search', 'action' => 'search', 'name' => 'productos.search'],
        ['method' => 'get', 'uri' => '/operacionesstock/search', 'action' => 'search', 'name' => 'operacionesstock.search'],
        ['method' => 'post', 'uri' => '/operacionesstock/update', 'action' => 'update', 'name' => 'operacionesstock.update'],
    ];
    foreach ($stockRoutes as $route) {
        Route::{$route['method']}($route['uri'], [StockController::class, $route['action']])->name($route['name']);
    }

    // Rutas de ReporteVentasController
    $reporteVentasRoutes = [
        ['method' => 'get', 'uri' => '/reportesventas', 'action' => 'index', 'name' => 'reporteventas'],
        ['method' => 'post', 'uri' => '/reportesventas/filtrar', 'action' => 'filtrar', 'name' => 'reportes.ventas.filtrar'],
        ['method' => 'post', 'uri' => '/reportesventas/buscar', 'action' => 'buscar', 'name' => 'reportes.ventas.buscar'],
        ['method' => 'get', 'uri' => '/ventas-por-mes', 'action' => 'ventasPorMes', 'name' => 'ventas.por_mes'],
    ];
    foreach ($reporteVentasRoutes as $route) {
        Route::{$route['method']}($route['uri'], [ReporteVentasController::class, $route['action']])->name($route['name']);
    }

    // Rutas de RolAccesoController
    $rolAccesoRoutes = [
        ['method' => 'get', 'uri' => '/crear-rol-acceso', 'action' => 'index', 'name' => 'rol-accesos.index'],
        ['method' => 'post', 'uri' => 'store-rol', 'action' => 'storeRol', 'name' => 'roles.store'],
        ['method' => 'get', 'uri' => 'create', 'action' => 'create', 'name' => 'roles.create'],
        ['method' => 'post', 'uri' => 'store-acceso', 'action' => 'storeAcceso', 'name' => 'accesos.store'],
        ['method' => 'post', 'uri' => 'store-rol-modal', 'action' => 'storeRolModal', 'name' => 'rolesModal.store'],
        ['method' => 'post', 'uri' => 'store-acceso-modal', 'action' => 'storeAccesoModal', 'name' => 'accesosModal.store'],
    ];

    foreach ($rolAccesoRoutes as $route) {
        Route::{$route['method']}($route['uri'], [RolAccesoController::class, $route['action']])->name($route['name']);
    }

    $gestionRolAccesoRoutes = [
        ['method' => 'get', 'uri' => '/gestion-rol-acceso', 'action' => 'index', 'name' => 'gestion-rol-acceso.index'],
        ['method' => 'get', 'uri' => 'create-gestion', 'action' => 'create', 'name' => 'gestion-rol-acceso.create'],
        ['method' => 'post', 'uri' => 'store-gestion', 'action' => 'store', 'name' => 'gestion-rol-acceso.store'],
        ['method' => 'delete', 'uri' => 'destroy/{id}', 'action' => 'destroy', 'name' => 'gestion-rol-acceso.destroy'],
        ['method' => 'put', 'uri' => 'update/{id}', 'action' => 'update', 'name' => 'gestion-rol-acceso.update']


    ];
    foreach ($gestionRolAccesoRoutes as $route) {
        Route::{$route['method']}($route['uri'], [GestionRolAccesoController::class, $route['action']])->name($route['name']);
    }

    // Rutas de TiendaController
    $tiendaRoutes = [
        ['method' => 'get', 'uri' => 'sucursales', 'action' => 'index', 'name' => 'sucursales.index'],
        ['method' => 'get', 'uri' => 'ver-sucursales', 'action' => 'vistasucursales', 'name' => 'versucursales'],
        ['method' => 'post', 'uri' => 'sucursales', 'action' => 'store', 'name' => 'sucursales.store'],
        ['method' => 'get', 'uri' => 'sucursales/show', 'action' => 'show', 'name' => 'sucursales.show'],
        ['method' => 'put', 'uri' => 'sucursales/{id}', 'action' => 'update', 'name' => 'sucursales.update'],
        ['method' => 'delete', 'uri' => 'sucursales/{id}', 'action' => 'destroy', 'name' => 'sucursales.destroy'],
        ['method' => 'get', 'uri' => 'ubigeo/{id}', 'action' => 'getUbigeo', 'name' => 'ubigeo.get'],
    ];
    foreach ($tiendaRoutes as $route) {
        Route::{$route['method']}($route['uri'], [TiendaController::class, $route['action']])->name($route['name']);
    }

    Route::get('/billetera', [BilleteraController::class, 'index'])->name('billetera.index');
    Route::post('/billetera/depositar', [BilleteraController::class, 'depositar'])->name('billetera.depositar');
    Route::post('/billetera/retirar', [BilleteraController::class, 'retirar'])->name('billetera.retirar');


    // Rutas de AsignarRolController
    Route::get('/asignar-rol', [AsignarRolController::class, 'index'])->name('asignar-rol.index');
    Route::post('/asignar-rol', [AsignarRolController::class, 'store'])->name('asignar-rol.store');
});
