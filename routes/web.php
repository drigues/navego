<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuiaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\PrestadorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ServicoController;
use Illuminate\Support\Facades\Route;

// --- Páginas públicas ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/servicos', [ServicoController::class, 'index'])->name('servicos.index');
Route::get('/servicos/{slug}', [ServicoController::class, 'show'])->name('servicos.show');
Route::get('/guias', [GuiaController::class, 'index'])->name('guias.index');
Route::get('/guias/{slug}', [GuiaController::class, 'show'])->name('guias.show');
Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
Route::get('/noticias/{slug}', [NoticiaController::class, 'show'])->name('noticias.show');
Route::get('/sobre', fn () => view('sobre'))->name('sobre');

// --- Orçamentos (requer autenticação) ---
Route::middleware('auth')->group(function () {
    Route::post('/orcamentos', [QuoteController::class, 'store'])->name('orcamentos.store');
});

// --- Dashboards (Breeze + roles) ---
Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Prestadores
        Route::get('/prestadores', [AdminController::class, 'prestadores'])->name('prestadores');
        Route::get('/prestadores/{provider}', [AdminController::class, 'showPrestador'])->name('prestadores.show');
        Route::post('/prestadores/{provider}/verify', [AdminController::class, 'toggleVerification'])->name('prestadores.verify');
        Route::post('/prestadores/{provider}/toggle-active', [AdminController::class, 'toggleActive'])->name('prestadores.toggle-active');

        // Categorias
        Route::get('/categorias', [AdminController::class, 'categorias'])->name('categorias');
        Route::post('/categorias', [AdminController::class, 'storeCategoria'])->name('categorias.store');
        Route::put('/categorias/{category}', [AdminController::class, 'updateCategoria'])->name('categorias.update');
        Route::delete('/categorias/{category}', [AdminController::class, 'destroyCategoria'])->name('categorias.destroy');

        // Guias
        Route::get('/guias', [AdminController::class, 'guias'])->name('guias');
        Route::get('/guias/create', [AdminController::class, 'createGuia'])->name('guias.create');
        Route::post('/guias', [AdminController::class, 'storeGuia'])->name('guias.store');
        Route::get('/guias/{guide}/edit', [AdminController::class, 'editGuia'])->name('guias.edit');
        Route::put('/guias/{guide}', [AdminController::class, 'updateGuia'])->name('guias.update');
        Route::delete('/guias/{guide}', [AdminController::class, 'destroyGuia'])->name('guias.destroy');

        // Notícias
        Route::get('/noticias', [AdminController::class, 'noticias'])->name('noticias');
        Route::get('/noticias/create', [AdminController::class, 'createNoticia'])->name('noticias.create');
        Route::post('/noticias', [AdminController::class, 'storeNoticia'])->name('noticias.store');
        Route::get('/noticias/{noticia}/edit', [AdminController::class, 'editNoticia'])->name('noticias.edit');
        Route::put('/noticias/{noticia}', [AdminController::class, 'updateNoticia'])->name('noticias.update');
        Route::delete('/noticias/{noticia}', [AdminController::class, 'destroyNoticia'])->name('noticias.destroy');

        // Planos
        Route::get('/planos', [AdminController::class, 'planos'])->name('planos');
        Route::post('/planos/{provider}', [AdminController::class, 'updatePlano'])->name('planos.update');
    });

Route::middleware(['auth', 'verified', 'role:provider'])
    ->prefix('prestador')->name('prestador.')
    ->group(function () {
        Route::get('/dashboard', [PrestadorController::class, 'dashboard'])->name('dashboard');
        Route::get('/perfil', [PrestadorController::class, 'editPerfil'])->name('perfil');
        Route::post('/perfil', [PrestadorController::class, 'updatePerfil'])->name('perfil.update');
        Route::get('/orcamentos', [PrestadorController::class, 'orcamentos'])->name('orcamentos');
        Route::get('/orcamentos/{quote}', [PrestadorController::class, 'showOrcamento'])->name('orcamentos.show');
        Route::post('/orcamentos/{quote}', [PrestadorController::class, 'updateOrcamento'])->name('orcamentos.update');
        Route::get('/plano', [PrestadorController::class, 'plano'])->name('plano');
        Route::post('/plano/upgrade', [PrestadorController::class, 'upgradePlano'])->name('plano.upgrade');
    });

// --- Perfil ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
