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

    Route::get('/productos', [ProductoController::class, 'index'])->name('producto');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{id}', [ProductoController::class, 'show'])->name('productos.show');
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    Route::get('/agregar', [AgregarController::class, 'index'])->name('agregar');
    Route::get('/marca', [MarcaController::class, 'create'])->name('marca');
    Route::post('/marca', [MarcaController::class, 'store'])->name('marcas.store');
    Route::put('/marcas/{id}', [MarcaController::class, 'update'])->name('marcas.update');

    Route::get('/marcas', [MarcaController::class, 'index'])->name('marcas.index');
    Route::get('/marcas/{id}', [MarcaController::class, 'show'])->name('marcas.show');


    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/create', [UsuariosController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UsuariosController::class, 'store'])->name('usuarios.store');

    Route::get('/visualizarmarca', [VisualizarMarcaController::class, 'index'])->name('visualizarmarca');
    Route::get('/Añadirususario', [AñadirusuarioController::class, 'index'])->name('Añadirusuario');
    Route::get('/realizaventas', [RealizaventaController::class, 'index'])->name('realizaventas');


    Route::get('realizaventas', [RealizaventaController::class, 'index'])->name('realizaventas');
    Route::get('realizaventas/buscar-usuarios', [RealizaventaController::class, 'buscarUsuarios'])->name('realizaventas.buscarUsuarios');
    Route::get('realizaventas/buscar-productos', [RealizaventaController::class, 'buscarProductos'])->name('realizaventas.buscarProductos');
    Route::post('realizaventas/guardar-venta', [RealizaventaController::class, 'guardarVenta'])->name('realizaventas.guardarVenta');

    Route::get('/realizacompras', [RealizarCompraController::class, 'index'])->name('realizacompras.index'); 
    Route::post('/realizacompras', [RealizarCompraController::class, 'guardarCompra'])->name('realizacompras.guardarCompra');
    Route::get('/realizacompras/buscarProductos', [RealizarCompraController::class, 'buscarProductos'])->name('realizacompras.buscarProductos');
    Route::get('/realizacompras/buscarUsuarios', [RealizarCompraController::class, 'buscarProveedores'])->name('realizacompras.buscarProveedores');

    Route::post('/realizacompras/store', [RealizarCompraController::class, 'store'])->name('realizacompras.store');

    Route::get('/stock', [StockController::class, 'index'])->name('operacionesstock.index');

    Route::get('/historial', [HistorialController::class, 'index'])->name('historial.index');
    Route::get('historial/detalles/{id}', [HistorialController::class, 'detalles'])->name('historial.detalles');
    Route::get('/historial/filtrar', [HistorialController::class, 'filtrar'])->name('historial.filtrar');

    Route::post('/operacionesstock/update', [StockController::class, 'update'])->name('operacionesstock.update');
    Route::get('/productos/search', [StockController::class, 'search'])->name('productos.search');
    Route::get('/operacionesstock/search', [StockController::class, 'search'])->name('operacionesstock.search');
    Route::post('/operacionesstock/update', [StockController::class, 'update'])->name('operacionesstock.update');

    Route::get('/reportesventas', [ReporteVentasController::class, 'index'])->name('reporteventas');
    Route::post('/reportesventas/filtrar', [ReporteVentasController::class, 'filtrar'])->name('reportes.ventas.filtrar');
    Route::post('/reportesventas/buscar', [ReporteVentasController::class, 'buscar'])->name('reportes.ventas.buscar');
    Route::get('/ventas-por-mes', [ReporteVentasController::class, 'ventasPorMes'])->name('ventas.por_mes');

    // Route::post('/usuarios/update-foto', [UsuariosController::class, 'updateFoto'])->name('usuarios.updateFoto');

    Route::get('/crear-rol-acceso', [RolAccesoController::class, 'index'])->name('rol-accesos.index');
    Route::post('store-rol', [RolAccesoController::class, 'storeRol'])->name('roles.store');
    Route::get('create', [RolAccesoController::class, 'create'])->name('roles.create');
    Route::post('store-acceso', [RolAccesoController::class, 'storeAcceso'])->name('accesos.store');

    Route::post('store-rol-modal', [RolAccesoController::class, 'storeRolModal'])->name('rolesModal.store');
    Route::post('store-acceso-modal', [RolAccesoController::class, 'storeAccesoModal'])->name('accesosModal.store');

    Route::get('/gestion-rol-acceso', [GestionRolAccesoController::class, 'index'])->name('gestion-rol-acceso.index');
    Route::get('create-gestion', [GestionRolAccesoController::class, 'create'])->name('gestion-rol-acceso.create');
    Route::post('store-gestion', [GestionRolAccesoController::class, 'store'])->name('gestion-rol-acceso.store');

    Route::get('sucursales', [TiendaController::class, 'index'])->name('sucursales.index');
    Route::get('ver-sucursales', [TiendaController::class, 'vistasucursales'])->name('versucursales');

    Route::post('sucursales', [TiendaController::class, 'store'])->name('sucursales.store');
    Route::get('sucursales/show', [TiendaController::class, 'show'])->name('sucursales.show');
    Route::put('sucursales/{id}', [TiendaController::class, 'update'])->name('sucursales.update');
    Route::delete('sucursales/{id}', [TiendaController::class, 'destroy'])->name('sucursales.destroy');
    Route::get('ubigeo/{id}', [TiendaController::class, 'getUbigeo']);

    Route::put('/profile/update', [UsuariosController::class, 'update'])->name('profile.update');

    Route::get('/asignar-rol', [AsignarRolController::class, 'index'])->name('asignar-rol.index');
    Route::post('/asignar-rol', [AsignarRolController::class, 'store'])->name('asignar-rol.store');
    Route::post('/buscar-usuarios', [AsignarRolController::class, 'buscarUsuarios']);

    Route::get('/gestion-rol-acceso', [GestionRolAccesoController::class, 'index'])->name('gestion-rol-acceso.index');
    Route::post('/gestion-rol-acceso', [GestionRolAccesoController::class, 'store'])->name('gestion-rol-acceso.store');
    Route::get('/gestion-rol-acceso/{id}/edit', [GestionRolAccesoController::class, 'edit'])->name('gestion-rol-acceso.edit');
    Route::put('/gestion-rol-acceso/{id}', [GestionRolAccesoController::class, 'update'])->name('gestion-rol-acceso.update');
    Route::delete('/gestion-rol-acceso/{id}', [GestionRolAccesoController::class, 'destroy'])->name('gestion-rol-acceso.destroy');

    // Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
});
