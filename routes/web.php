<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/instructeurs', [InstructorController::class, 'index'])
    ->name('instructors.index');

Route::get('/instructeurs/{instructor}/voertuigen', [InstructorController::class, 'vehicles'])
    ->whereNumber('instructor')
    ->name('instructors.vehicles');

Route::post('/instructeurs/{instructor}/voertuigen/{vehicle}/verwijderen', [InstructorController::class, 'removeVehicle'])
    ->whereNumber('instructor')
    ->whereNumber('vehicle')
    ->name('instructors.vehicles.remove');

Route::get('/voertuigen', [VehicleController::class, 'index'])
    ->name('vehicles.index');

Route::post('/voertuigen/{vehicle}/verwijderen', [VehicleController::class, 'remove'])
    ->whereNumber('vehicle')
    ->name('vehicles.remove');
