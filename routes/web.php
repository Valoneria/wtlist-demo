<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [VehicleController::class,"index"])->name('vehicle.index');


Route::get('/vehicle', function () {
    return redirect(
        "/"
    );
});


Route::get('/vehicle/import', [VehicleController::class,"import"])->name('vehicle.import');
Route::get('/vehicle/import/form', [VehicleController::class,"importForm"])->name('vehicle.import_form');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
