<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TVController;
use Illuminate\Support\Facades\Route;

Route::get('/',[MovieController::class, 'index'])->name('movie.index');
Route::get('/movie/{id}',[MovieController::class, 'show'])->name('movie.show');
Route::get('/tv',[TVController::class, 'index'])->name('tv.index');
Route::get('/tv/{id}',[TVController::class, 'show'])->name('tv.show');

Route::get('/actors',[ActorController::class, 'index'])->name('actors.index');
Route::get('/actors/page/{page?}',[ActorController::class, 'index']);
Route::get('/actors/{id}',[ActorController::class, 'show'])->name('actors.show');