<?php

use AkioSarkiz\Openapi\Tests\TestApp\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
