<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AgregarController;
use App\Http\Controllers\AñadirusuarioController;
use App\Http\Controllers\MarcaController;
// use App\Http\Controllers\ChatController;
use App\Http\Controllers\VisualizarMarcaController;
use App\Http\Controllers\RealizarCompraController;
use App\Http\Controllers\RealizaventaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ReporteVentasController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\RolAccesoController;
use App\Http\Controllers\GestionRolAccesoController;
// use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\AsignarRolController;
use App\Http\Controllers\BilleteraController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\VerSucursalesController;
use App\Http\Controllers\FavoriteController;



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


// Ruta para el dashboard protegida por autenticación
Route::get('/', function () {
    return view('dashboard');
})->name('/')->middleware('auth');

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Route::get('/notifications', [NotificationController::class, 'fetchNotifications'])
// ->name('notifications.fetch');
// Rutas protegidas por autenticación usando el middleware 'auth'

Route::middleware('auth')->group(function () {


    Route::middleware(['check.acceso:ProductoController'])->group(function () {
        $productoRoutes = [
            ['method' => 'get', 'uri' => '/productos', 'action' => 'index', 'name' => 'ProductoController.index'],
            ['method' => 'post', 'uri' => '/productos', 'action' => 'store', 'name' => 'productos.store'],
            ['method' => 'get', 'uri' => '/productos/{id}', 'action' => 'show', 'name' => 'productos.show'],
            ['method' => 'put', 'uri' => '/productos/{id}', 'action' => 'update', 'name' => 'productos.update'],
            ['method' => 'delete', 'uri' => '/productos/{id}', 'action' => 'destroy', 'name' => 'productos.destroy'],
        ];

        // Iterar sobre el arreglo para definir las rutas
        foreach ($productoRoutes as $route) {
            Route::{$route['method']}($route['uri'], [ProductoController::class, $route['action']])->name($route['name']);
        }
    });



    Route::middleware(['check.acceso:AgregarController'])->group(function () {
        Route::get('/agregar', [AgregarController::class, 'index'])->name('AgregarController.index');
    });



    // Rutas de MarcaController
    Route::middleware(['check.acceso:MarcaController'])->group(function () {
        $marcaRoutes = [
            ['method' => 'get', 'uri' => '/marca', 'action' => 'create', 'name' => 'MarcaController.index'],
            ['method' => 'post', 'uri' => '/marca', 'action' => 'store', 'name' => 'marcas.store'],
            ['method' => 'put', 'uri' => '/marcas/{id}', 'action' => 'update', 'name' => 'marcas.update'],
            ['method' => 'get', 'uri' => '/marcas', 'action' => 'index', 'name' => 'marcas.index'],
            ['method' => 'get', 'uri' => '/marcas/{id}', 'action' => 'show', 'name' => 'marcas.show'],
        ];
        foreach ($marcaRoutes as $route) {
            Route::{$route['method']}($route['uri'], [MarcaController::class, $route['action']])->name($route['name']);
        }
    });


    // Rutas de UsuariosController
    Route::middleware(['check.acceso:UsuariosController'])->group(function () {
        $usuarioRoutes = [
            ['method' => 'get', 'uri' => '/usuarios', 'action' => 'index', 'name' => 'UsuariosController.index'],
            ['method' => 'get', 'uri' => '/usuarios/create', 'action' => 'create', 'name' => 'usuarios.create'],
            ['method' => 'post', 'uri' => '/usuarios', 'action' => 'store', 'name' => 'usuarios.store'],
            ['method' => 'post', 'uri' => '/usuarios/update-foto', 'action' => 'updateFoto', 'name' => 'usuarios.updateFoto'],
            ['method' => 'put', 'uri' => '/profile/update', 'action' => 'update', 'name' => 'profile.update'],
        ];
        foreach ($usuarioRoutes as $route) {
            Route::{$route['method']}($route['uri'], [UsuariosController::class, $route['action']])->name($route['name']);
        }
    });

    Route::middleware(['check.acceso:VisualizarMarcaController'])->group(function () {
        // Rutas de VisualizarMarcaController
        Route::get('/visualizarmarca', [VisualizarMarcaController::class, 'index'])->name('VisualizarMarcaController.index');
    });


    // Rutas de RealizaventaController
    Route::middleware(['check.acceso:RealizaventaController'])->group(function () {
        $realizaVentaRoutes = [
            ['method' => 'get', 'uri' => 'realizaventas', 'action' => 'index', 'name' => 'RealizaventaController.index'],
            ['method' => 'get', 'uri' => 'realizaventas/buscar-usuarios', 'action' => 'buscarUsuarios', 'name' => 'realizaventas.buscarUsuarios'],
            ['method' => 'get', 'uri' => 'realizaventas/buscar-productos', 'action' => 'buscarProductos', 'name' => 'realizaventas.buscarProductos'],
            ['method' => 'post', 'uri' => 'realizaventas/guardar-venta', 'action' => 'guardarVenta', 'name' => 'realizaventas.guardarVenta'],
            ['method' => 'post', 'uri' => 'realizaventas/guardar-cliente', 'action' => 'guardarCliente', 'name' => 'realizaventas.guardarCliente'],
        ];
        foreach ($realizaVentaRoutes as $route) {
            Route::{$route['method']}($route['uri'], [RealizaventaController::class, $route['action']])->name($route['name']);
        }
    });


    Route::middleware(['check.acceso:RealizarCompraController'])->group(function () {

        // Rutas de RealizarCompraController
        $realizaCompraRoutes = [
            ['method' => 'get', 'uri' => '/realizacompras', 'action' => 'index', 'name' => 'RealizarCompraController.index'],
            ['method' => 'post', 'uri' => '/realizacompras', 'action' => 'guardarCompra', 'name' => 'realizacompras.guardarCompra'],
            ['method' => 'get', 'uri' => '/realizacompras/buscarProductos', 'action' => 'buscarProductos', 'name' => 'realizacompras.buscarProductos'],
            ['method' => 'get', 'uri' => '/realizacompras/buscarUsuarios', 'action' => 'buscarProveedores', 'name' => 'realizacompras.buscarProveedores'],
            ['method' => 'post', 'uri' => '/realizacompras/store', 'action' => 'store', 'name' => 'realizacompras.store'],
        ];
        foreach ($realizaCompraRoutes as $route) {
            Route::{$route['method']}($route['uri'], [RealizarCompraController::class, $route['action']])->name($route['name']);
        }
    });


    // Rutas de HistorialController
    Route::middleware(['check.acceso:HistorialController'])->group(function () {
        $historialRoutes = [
            ['method' => 'get', 'uri' => '/historial', 'action' => 'index', 'name' => 'HistorialController.index'],
            ['method' => 'get', 'uri' => 'historial/detalles/{id}', 'action' => 'detalles', 'name' => 'historial.detalles'],
            ['method' => 'get', 'uri' => '/historial/filtrar', 'action' => 'filtrar', 'name' => 'historial.filtrar'],
        ];
        foreach ($historialRoutes as $route) {
            Route::{$route['method']}($route['uri'], [HistorialController::class, $route['action']])->name($route['name']);
        }
    });

    Route::middleware(['check.acceso:StockController'])->group(function () {

        // Rutas de StockController
        $stockRoutes = [
            ['method' => 'get', 'uri' => '/stock', 'action' => 'index', 'name' => 'StockController.index'],
            ['method' => 'post', 'uri' => '/operacionesstock/update', 'action' => 'update', 'name' => 'operacionesstock.update'],
            ['method' => 'get', 'uri' => '/productos/search', 'action' => 'search', 'name' => 'productos.search'],
            ['method' => 'get', 'uri' => '/operacionesstock/search', 'action' => 'search', 'name' => 'operacionesstock.search'],
            ['method' => 'post', 'uri' => '/operacionesstock/update', 'action' => 'update', 'name' => 'operacionesstock.update'],
        ];
        foreach ($stockRoutes as $route) {
            Route::{$route['method']}($route['uri'], [StockController::class, $route['action']])->name($route['name']);
        }
    });



    // Rutas de ReporteVentasController
    Route::middleware(['check.acceso:ReporteVentasController'])->group(function () {
        $reporteVentasRoutes = [
            ['method' => 'get', 'uri' => '/reportesventas', 'action' => 'index', 'name' => 'ReporteVentasController.index'],
            ['method' => 'post', 'uri' => '/reportesventas/filtrar', 'action' => 'filtrar', 'name' => 'reportes.ventas.filtrar'],
            ['method' => 'post', 'uri' => '/reportesventas/buscar', 'action' => 'buscar', 'name' => 'reportes.ventas.buscar'],
            ['method' => 'get', 'uri' => '/ventas-por-mes', 'action' => 'ventasPorMes', 'name' => 'ventas.por_mes'],
        ];
        foreach ($reporteVentasRoutes as $route) {
            Route::{$route['method']}($route['uri'], [ReporteVentasController::class, $route['action']])->name($route['name']);
        }
    });

    // Route::middleware(['check.acceso:RolAccesoController'])->group(function () {

        // Rutas de RolAccesoController
        $rolAccesoRoutes = [
            ['method' => 'get', 'uri' => '/crear-rol-acceso', 'action' => 'index', 'name' => 'RolAccesoController.index'],
            ['method' => 'post', 'uri' => 'store-rol', 'action' => 'storeRol', 'name' => 'roles.store'],
            ['method' => 'get', 'uri' => 'create', 'action' => 'create', 'name' => 'roles.create'],
            ['method' => 'post', 'uri' => 'store-acceso', 'action' => 'storeAcceso', 'name' => 'accesos.store'],
            ['method' => 'post', 'uri' => 'store-rol-modal', 'action' => 'storeRolModal', 'name' => 'rolesModal.store'],
            ['method' => 'post', 'uri' => 'store-acceso-modal', 'action' => 'storeAccesoModal', 'name' => 'accesosModal.store'],
        ];

        foreach ($rolAccesoRoutes as $route) {
            Route::{$route['method']}($route['uri'], [RolAccesoController::class, $route['action']])->name($route['name']);
        }
    // });


    Route::get('/buscar-controladores', [RolAccesoController::class, 'buscarControladores'])->name('buscar.controladores');

    // Route::middleware(['check.acceso:GestionRolAccesoController'])->group(function () {
        $gestionRolAccesoRoutes = [
            ['method' => 'get', 'uri' => '/gestion-rol-acceso', 'action' => 'index', 'name' => 'GestionRolAccesoController.index'],
            ['method' => 'get', 'uri' => 'create-gestion', 'action' => 'create', 'name' => 'gestion-rol-acceso.create'],
            ['method' => 'post', 'uri' => 'store-gestion', 'action' => 'store', 'name' => 'gestion-rol-acceso.store'],
            ['method' => 'delete', 'uri' => 'destroy/{id}', 'action' => 'destroy', 'name' => 'gestion-rol-acceso.destroy'],
            ['method' => 'put', 'uri' => 'update/{id}', 'action' => 'update', 'name' => 'gestion-rol-acceso.update']


        ];
        foreach ($gestionRolAccesoRoutes as $route) {
            Route::{$route['method']}($route['uri'], [GestionRolAccesoController::class, $route['action']])->name($route['name']);
        }
    // });

    Route::middleware(['check.acceso:TiendaController'])->group(function () {
        // Rutas de TiendaController
        $tiendaRoutes = [
            ['method' => 'get', 'uri' => 'sucursales', 'action' => 'index', 'name' => 'TiendaController.index'],
            // ['method' => 'get', 'uri' => 'ver-sucursales', 'action' => 'vistasucursales', 'name' => 'TiendaController.vistasucursales'],
            ['method' => 'post', 'uri' => 'sucursales', 'action' => 'store', 'name' => 'sucursales.store'],
            // ['method' => 'get', 'uri' => 'sucursales/show', 'action' => 'show', 'name' => 'sucursales.show'],
            // ['method' => 'put', 'uri' => 'sucursales/{id}', 'action' => 'update', 'name' => 'sucursales.update'],
            // ['method' => 'delete', 'uri' => 'sucursales/{id}', 'action' => 'destroy', 'name' => 'sucursales.destroy'],
            // ['method' => 'get', 'uri' => 'ubigeo/{id}', 'action' => 'getUbigeo', 'name' => 'ubigeo.get'],
        ];
        foreach ($tiendaRoutes as $route) {
            Route::{$route['method']}($route['uri'], [TiendaController::class, $route['action']])->name($route['name']);
        }
    });

    Route::middleware(['check.acceso:VerSucursalesController'])->group(function () {
        //Ver sucursales
        $tiendaRoutes = [
            ['method' => 'get', 'uri' => 'ver-sucursales', 'action' => 'index', 'name' => 'VerSucursalesController.index'],
            ['method' => 'get', 'uri' => 'sucursales/show', 'action' => 'show', 'name' => 'sucursales.show'],
            ['method' => 'put', 'uri' => 'sucursales/{id}', 'action' => 'update', 'name' => 'sucursales.update'],
            ['method' => 'delete', 'uri' => 'sucursales/{id}', 'action' => 'destroy', 'name' => 'sucursales.destroy'],
            ['method' => 'get', 'uri' => 'ubigeo/{id}', 'action' => 'getUbigeo', 'name' => 'ubigeo.get'],
        ];
        foreach ($tiendaRoutes as $route) {
            Route::{$route['method']}($route['uri'], [VerSucursalesController::class, $route['action']])->name($route['name']);
        }
    });




    Route::get('/billetera', [BilleteraController::class, 'index'])->name('billetera.index');
    Route::post('/billetera/depositar', [BilleteraController::class, 'depositar'])->name('billetera.depositar');
    Route::post('/billetera/retirar', [BilleteraController::class, 'retirar'])->name('billetera.retirar');


    Route::middleware(['check.acceso:AsignarRolController'])->group(function () {

        // Rutas de AsignarRolController
        Route::get('/asignar-rol', [AsignarRolController::class, 'index'])->name('AsignarRolController.index');
        Route::post('/asignar-rol', [AsignarRolController::class, 'store'])->name('asignar-rol.store');
    });


    // Ruta para mostrar la vista de configuración
    Route::get('/configuracion', [ConfigController::class, 'index'])->name('configuracion.index');

    // Ruta para reenviar el correo de verificación
    Route::post('/configuracion/verify-email', [ConfigController::class, 'sendVerificationEmail'])->name('configuracion.verify-email');

    // Ruta para actualizar la contraseña
    Route::post('/configuracion/update-password', [ConfigController::class, 'updatePassword'])->name('configuracion.update-password');

    // Ruta para verificar el correo electrónico (debe coincidir con el patrón usado en el correo enviado)
    // Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    //     $request->fulfill();
    //     return redirect('/home'); // Redirige al usuario después de la verificación
    // })->middleware(['auth', 'signed'])->name('verification.verify');

    // Ruta para mostrar el aviso de verificación de correo electrónico
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware(['auth'])->name('verification.notice');

    // Ruta para reenviar el correo de verificación
    Route::post('/email/verification-notification', [ConfigController::class, 'sendVerificationEmail'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.send');
});

// $accesos = Acceso::whereNotNull('controlador')->get();

// foreach ($accesos as $acceso){
//     if(class_exists($acceso->controller)){
//         Route::middleware(['auth','check.acceso'.$acceso->name])
//             ->get($acceso->controlador)
//             ->name($acceso->name);
//     } else{
//         \Log::error("Ruta o controlador invalido: {$acceso->name}");
//     }
// }