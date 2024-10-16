<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;



Route::get('/', [RegistrationController::class, 'index'])->name('registration');
