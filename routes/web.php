<?php

use App\Http\Controllers\GestionnaireController;
use App\Http\Controllers\InfrastructureController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Mail\TestMail;
use App\Models\Infrastructure;
use Illuminate\Support\Facades\Mail;
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

Route::get('/mail', function () {
    Mail::to('rami242003@gmail.com')->send(new TestMail());
    return 'Email was sent';
})->name('mail');

Route::get('/test', function () {
    return view('mails.test');
});

Route::get('/', function () {
    return view('welcome');
})->name('root');

Route::get('/contact', function () {
    return view('contact_us');
})->name('contact');

Route::get('/about', function () {
    return view('about');
})->name('about');


// Notification routes
Route::get('/notifications', [NotificationController::class,'index'])->name('notifications')->middleware('auth','verified'); 
Route::patch('/notifications/{id}', [NotificationController::class,'markAsRead'])->name('notifications.markAsRead')->middleware('auth','verified');
Route::patch('/notifications', [NotificationController::class,'markAllAsRead'])->name('notifications.markAllAsRead')->middleware('auth','verified');
Route::patch('/notifications/{id}/unread', [NotificationController::class,'markAsUnread'])->name('notifications.markAsUnread')->middleware('auth','verified');
Route::delete('/notifications/{id}', [NotificationController::class,'destroy'])->name('notifications.destroy')->middleware('auth','verified');




//----------------- Routes for the Admin Panel -------------------

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['admin','auth', 'verified'])->name('dashboard');


Route::prefix('admin/gestionnaires')->middleware('admin','auth','verified')->group(function () {
    Route::get('requests', [GestionnaireController::class, 'requests'])->name('admin.gestionnaires.requests');
    Route::post('requests/{id}/accept', [GestionnaireController::class, 'accept'])->name('admin.gestionnaires.accept');
    Route::delete('requests/{id}/reject', [GestionnaireController::class, 'reject'])->name('admin.gestionnaires.reject');
});
Route::resource("admin/gestionnaires", GestionnaireController::class)->middleware('admin','auth','verified')
    ->name('index','admin.gestionnaires.index')->name('create','admin.gestionnaires.create')
    ->name('store','admin.gestionnaires.store')->name('show','admin.gestionnaires.show')
    ->name('edit','admin.gestionnaires.edit')->name('update','admin.gestionnaires.update')
    ->name('destroy','admin.gestionnaires.destroy');


//------------------- Routes for the Gestionnaire Panel -------------------

// Route::get('/gestionnaire', function () {
//     return view('dashboard');//Temporary
// })->middleware(['gestionnaire','auth', 'verified'])->name('gestionnaire.dashboard');

Route::prefix('gestionnaire/reservations')->middleware('gestionnaire','auth','verified')->group(function(){
    Route::get('requests', [ReservationController::class, 'requests'])->name('gestionnaire.reservations.requests');
    Route::post('requests/{id}/accept', [ReservationController::class, 'accept'])->name('gestionnaire.reservations.accept');
    Route::post('requests/{id}/reject', [ReservationController::class, 'reject'])->name('gestionnaire.reservations.reject');

}); 

Route::get('gestionnaire/infrastructure',[InfrastructureController::class,'gestionnaireIndex'])
    ->middleware('gestionnaire','auth','verified')
    ->name('gestionnaire.infrastructure.index');

    //search and filter infrastructure routes for gestionnaire
Route::get('/gestionnaire/infrastructure/search', [InfrastructureController::class, 'searchGestionnaire'])->middleware(['gestionnaire','auth', 'verified'])
->name('gestionnaire.infrastructure.search');
Route::get('/gestionnaire/infrastructure/filter', [InfrastructureController::class, 'filterGestionnaire'])->middleware(['gestionnaire','auth', 'verified'])
->name('gestionnaire.infrastructure.filter');

Route::resource("gestionnaire/infrastructure", InfrastructureController::class)->middleware('gestionnaire','auth','verified')
    ->except(['index'])
    ->name('create','gestionnaire.infrastructure.create')
    ->name('store','gestionnaire.infrastructure.store')->name('show','gestionnaire.infrastructure.show')
    ->name('edit','gestionnaire.infrastructure.edit')->name('update','gestionnaire.infrastructure.update')
    ->name('destroy','gestionnaire.infrastructure.destroy');

Route::post('/upload', [InfrastructureController::class, 'upload'])->name('upload');


//------------------- Routes for the Client Panel -------------------


Route::get('/infarstructures', [InfrastructureController::class, 'index'])->middleware(['client','auth', 'verified'])
->name('infrastructure.index');
Route::get('/infarstructures/{infrastructure}', [InfrastructureController::class, 'details'])->middleware(['client','auth', 'verified'])
->name('infrastructure.details');


Route::get('/infrastructure/search', [InfrastructureController::class, 'search'])->middleware(['client','auth', 'verified'])
->name('infrastructure.search');
Route::get('/infrastructure/filter', [InfrastructureController::class, 'filter'])->middleware(['client','auth', 'verified'])
->name('infrastructure.filter');

Route::resource("reservations", ReservationController::class)->middleware('client','auth','verified')
    ->name('index','reservations.index')->name('create','reservations.create')
    ->name('store','reservations.store')->name('show','reservations.show')
    ->name('edit','reservations.edit')->name('update','reservations.update')
    ->name('destroy','reservations.destroy');


//------------------- Routes for the Authentification -------------------

Route::get('/gestionnaire/register', [GestionnaireController::class,'requestRegister'])->name('register.gestionnaire');
Route::post('/gestionnaire/register', [GestionnaireController::class,'storeRequest'])->name('register.gestionnaire.store');
Route::get('/gestionnaire/password/{id}', [GestionnaireController::class,'passwordView'])->name('gestionnaire.password');
Route::post('/gestionnaire/password/store/{id}', [GestionnaireController::class,'setPassword'])->name('gestionnaire.password.set');

//------------------- General Routes ------------------------------------


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
