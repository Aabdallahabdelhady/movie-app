<?php

use Illuminate\Support\Facades\Route;

Route::view('/','index');
Route::view('/movies','show')->name('movie.show');