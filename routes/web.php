 <?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DispositivoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\WebhookController;

Route::get('/styles.css', function () {
    $css = file_get_contents(resource_path('css/app.css'));
    $css = preg_replace('/^\s*@import.*$/m', '', $css);
    $css = preg_replace('/^\s*@source.*$/m', '', $css);
    $css = preg_replace('/^\s*@theme\s*\{\s*/', '', $css);
    $css = preg_replace('/\}\s*$/', '', $css);

    return response($css, 200)
        ->header('Content-Type', 'text/css');
});

// Páginas estáticas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/loja', [HomeController::class, 'loja'])->name('loja');

// Painéis com dados do banco (protegidos via cookie/middleware)
Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(CheckRole::class.':admin')
    ->name('admin');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(CheckRole::class.':user')
    ->name('dashboard');

// API Pública de Auth
Route::post('/api/login', [AuthController::class, 'login']);

// API de Usuários (CRUD)
Route::prefix('api')->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index']);
    Route::post('/usuarios', [UsuarioController::class, 'store']);
    Route::post('/admins', [AdminController::class, 'store']);
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

    // Cuidadores de um usuário
    Route::post('/usuarios/{usuarioId}/cuidadores', [UsuarioController::class, 'storeCuidador']);
    Route::get('/usuarios/{usuarioId}/cuidadores/{cuidadorId}', [UsuarioController::class, 'showCuidador']);
    Route::put('/usuarios/{usuarioId}/cuidadores/{cuidadorId}', [UsuarioController::class, 'updateCuidador']);
    Route::delete('/usuarios/{usuarioId}/cuidadores/{cuidadorId}', [UsuarioController::class, 'destroyCuidador']);

    // Tickets (CRUD)
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/{id}', [TicketController::class, 'show']);
    Route::put('/tickets/{id}', [TicketController::class, 'update']);
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy']);

    // Pedidos
    Route::get('/pedidos', [PedidoController::class, 'index']);
    Route::get('/pedidos/{id}', [PedidoController::class, 'show']);
    Route::put('/pedidos/{id}', [PedidoController::class, 'update']);

    // Dispositivos (CRUD completo)
    Route::get('/dispositivos', [DispositivoController::class, 'index']);
    Route::post('/dispositivos', [DispositivoController::class, 'store']);
    Route::get('/dispositivos/{id}', [DispositivoController::class, 'show']);
    Route::put('/dispositivos/{id}', [DispositivoController::class, 'update']);
    Route::delete('/dispositivos/{id}', [DispositivoController::class, 'destroy']);

    // Sensores (ingestão de dados do colete)
    Route::post('/sensores/ingest', [SensorController::class, 'ingest']);
    // Receber webhooks externos
    Route::post('/webhook', [WebhookController::class, 'handle']);
    Route::get('/sensores/{dispositivoId}/ultimas', [SensorController::class, 'ultimas']);
});

