<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\AccommondationForm;
use App\Livewire\Dashboard;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', Dashboard::class)->name('admin.dashboard');
});
        Route::get('/home', Home::class)->name('Home');
        Route::get('/create/room', AccommondationForm::class)->name('add.Accommondation');
});
require __DIR__.'/auth.php';
