<?php

use App\Http\Controllers\TareaController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/home', function () {
    return redirect()->route('tareas.index');
});

Route::get('/test-email', function() {
    $tarea = App\Models\Tarea::first();
    return new App\Mail\InvitacionTareaMail($tarea);
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Configuraciones
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Tareas
    Route::resource('tareas', TareaController::class)->middleware('auth');
    Route::post('tareas/{tarea}/invite', [TareaController::class, 'invite'])->name('tareas.invite');
    Route::resource('tareas.files', 'App\Http\Controllers\ArchivoController')->only(['store', 'destroy']);

    Route::redirect('/dashboard', '/tareas');
});

require __DIR__.'/auth.php';