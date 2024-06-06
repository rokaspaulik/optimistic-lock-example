<?php

use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

Route::get('/', FormController::class);
Route::post('/', FormController::class);
