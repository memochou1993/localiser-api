<?php

use App\Http\Controllers\KeyController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('tokens', [TokenController::class, 'store']);
Route::apiResource('users', UserController::class)->only(['store']);

Route::middleware([
    'auth:sanctum',
])->group(function () {
    Route::delete('tokens', [TokenController::class, 'destroy']);
    Route::apiResource('users', UserController::class)->only(['update']);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('projects.languages', LanguageController::class)->shallow();
    Route::apiResource('projects.keys', KeyController::class)->shallow();
});
