<?php

use App\Http\Controllers\KeyController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::apiResource('projects', ProjectController::class);
Route::apiResource('projects.languages', LanguageController::class)->shallow();
Route::apiResource('projects.keys', KeyController::class)->shallow();
