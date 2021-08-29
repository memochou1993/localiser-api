<?php

use App\Http\Controllers\KeyController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectUserController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValueController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('tokens', [TokenController::class, 'store']);

Route::prefix('projects/{project}')->group(function () {
    Route::get('locales', [LocaleController::class, 'index']);
    Route::delete('locales', [LocaleController::class, 'destroy']);
    Route::get('messages', [MessageController::class, 'index']);
    Route::delete('messages', [MessageController::class, 'destroy']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user', function (Request $r) { return new UserResource($r->user()); });
    Route::delete('tokens', [TokenController::class, 'destroy']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('projects.languages', LanguageController::class)->shallow();
    Route::apiResource('projects.keys', KeyController::class)->shallow();
    Route::apiResource('keys.values', ValueController::class)->shallow();
    Route::apiResource('projects.users', ProjectUserController::class)->only('store', 'destroy');
});
