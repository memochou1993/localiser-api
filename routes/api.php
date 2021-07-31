<?php

use App\Http\Controllers\KeyController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValueController;
use Illuminate\Support\Facades\Route;

Route::post('tokens', [TokenController::class, 'store']);
Route::apiResource('users', UserController::class)->only(['store']);

Route::middleware([
    'auth:sanctum',
])->group(function () {
    Route::get('users/me', [UserController::class, 'show']);
    Route::patch('users/me', [UserController::class, 'update']);
    Route::delete('tokens', [TokenController::class, 'destroy']);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('projects.languages', LanguageController::class)->shallow();
    Route::apiResource('projects.keys', KeyController::class)->shallow();
    Route::apiResource('keys.values', ValueController::class)->shallow();
});
