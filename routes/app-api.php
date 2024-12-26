<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DatabaseController;
use App\Http\Controllers\Api\TechnologyController;
use App\Http\Controllers\Api\ConnectionController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\ConnectionTypeController;
use App\Http\Controllers\Api\TechnologyVersionController;
use App\Http\Controllers\Api\DatabasesApplicationController;
use App\Http\Controllers\Api\ApplicationsConnectionController;
use App\Http\Controllers\Api\ConnectionTypesConnectionController;
use App\Http\Controllers\Api\TechnologyVersionsApplicationController;
use App\Http\Controllers\Api\TechnologiesApplicationController;
use App\Http\Controllers\Api\TechnologiesTechnologyVersionController;
use App\Http\Controllers\Api\UsersDatabaseController;
use App\Http\Controllers\Api\UsersConnectionController;
use App\Http\Controllers\Api\UsersApplicationController;


Route::name('api.')
    ->prefix('api')
    ->group(function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');

        Route::middleware('auth:sanctum')->group(function () {
            // Resource Routes
            Route::apiResource('users', UserController::class);
            Route::apiResource('technologies', TechnologyController::class);
            Route::apiResource('technology-versions', TechnologyVersionController::class);
            Route::apiResource('databases', DatabaseController::class);
            Route::apiResource('applications', ApplicationController::class);
            Route::apiResource('connection-types', ConnectionTypeController::class);
            Route::apiResource('connections', ConnectionController::class);
        });
    });
