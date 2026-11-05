<?php

use App\Http\Controllers\SedeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/sedes');

Route::resource('sedes', SedeController::class);
