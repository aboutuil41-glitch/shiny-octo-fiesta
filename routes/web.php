<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvitationController;
use App\Livewire\Accommondation;
use App\Livewire\AccommondationForm;
use App\Livewire\AccommondationList;
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

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', Dashboard::class)->name('admin.dashboard');
    });

    Route::get('/home', Home::class)->name('Home');
    Route::get('/create/room', AccommondationForm::class)->name('add.Accommondation');
    Route::get('/list', AccommondationList::class)->name('view.Accommondations');
    Route::get('/view/{id}', Accommondation::class)->name('view.Accommondation');

    Route::get('/invitation/{token}', [InvitationController::class, 'show'])->name('invitation.show');
    Route::post('/invitation/{token}/accept', [InvitationController::class, 'accept'])->name('invitation.accept');
    Route::post('/invitation/{token}/decline', [InvitationController::class, 'decline'])->name('invitation.decline');
    Route::get('/404', function(){
        return view('errors.404', ['exception' => new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('you get one BOY!')]);
    })->name('404-page');
    
});

require __DIR__.'/auth.php';