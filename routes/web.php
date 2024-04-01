<?php

use App\Http\Controllers\GestionnaireController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


Route::prefix('admin/gestionnaires')->middleware('auth','verified')->group(function () {
    Route::get('requests', [GestionnaireController::class, 'requests'])->name('admin.gestionnaires.requests');
    Route::post('requests/{id}/accept', [GestionnaireController::class, 'accept'])->name('admin.gestionnaires.accept');
    Route::delete('requests/{id}/reject', [GestionnaireController::class, 'reject'])->name('admin.gestionnaires.reject');
});
Route::resource("admin/gestionnaires", GestionnaireController::class)->middleware('auth','verified')
    ->name('index','admin.gestionnaires.index')->name('create','admin.gestionnaires.create')
    ->name('store','admin.gestionnaires.store')->name('show','admin.gestionnaires.show')
    ->name('edit','admin.gestionnaires.edit')->name('update','admin.gestionnaires.update')
    ->name('destroy','admin.gestionnaires.destroy');


/* Route::prefix('admin/gestionnaires')->middleware('auth','verified')->group(function () {
    // Define custom routes
    Route::get('requests', [GestionnaireController::class, 'requests'])->name('admin.gestionnaires.requests');
    Route::get('requests/{id}/accept', [GestionnaireController::class, 'accept'])->name('acceptgestionnaire');
    Route::get('requests/{id}/reject', [GestionnaireController::class, 'reject'])->name('deletegestionnaire');
    
    // Define resourceful routes
    Route::get('/', [GestionnaireController::class, 'index'])->name('admin.gestionnaires.index');
    Route::get('create', [GestionnaireController::class, 'create'])->name('admin.gestionnaires.create');
    Route::post('/', [GestionnaireController::class, 'store'])->name('admin.gestionnaires.store');
    Route::get('{gestionnaire}', [GestionnaireController::class, 'show'])->name('admin.gestionnaires.show');
    Route::get('{gestionnaire}/edit', [GestionnaireController::class, 'edit'])->name('admin.gestionnaires.edit');
    Route::put('{gestionnaire}', [GestionnaireController::class, 'update'])->name('admin.gestionnaires.update');
    Route::delete('{gestionnaire}', [GestionnaireController::class, 'destroy'])->name('admin.gestionnaires.destroy');

}); */




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
