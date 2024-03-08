<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RetseptController;
use App\Http\Controllers\IzohController;

//public url
Route::get('/',[RetseptController::class,'index'])->name('retsept-index');
Route::get('/show/{retsept}',[RetseptController::class,'show'])->name('retsept-show');
Route::get('/retsept-filter/{retsept}',[RetseptController::class,'filter'])->name('retsept-filter');
Route::post('/izoh',[IzohController::class,'store'])->name('izoh');
Route::get('/ball',[IzohController::class,'ball'])->name('ball');
Route::get('/users/{user}',[RetseptController::class,'user_profil'])->name('user-profil');


//private url
Route::middleware('auth')->group(function () {
    Route::get('/edit/{retsept}',[RetseptController::class,'edit'])->name('retsept-edit');
    Route::post('/edit/{retsept}',[RetseptController::class,'update'])->name('retsept-edit');
    Route::get('/create',[RetseptController::class,'create'])->name('retsept-create');
    Route::post('/create',[RetseptController::class,'store'])->name('retsept-create');
    Route::get('/retsept-delete/{retsept}',[RetseptController::class,'destroy'])->name('retsept-delete');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
