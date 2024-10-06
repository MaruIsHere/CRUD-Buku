<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BukuController;
/**
 * route resource posts
 */

 Route::get('login',[UserController::class,'logindisplay'])->name('login');
Route::post('login',[UserController::class,'login'])->name('login.ajax');
Route::get('/logout',[UserController::class,'logout'])->name('/logout');  

Route::middleware('auth')->group(function (){

Route::get('/databuku',[BukuController::class,'index'])->name('/databuku');
Route::get('/datauser',[UserController::class,'index'])->name('/datauser');

// web.php or api.php
Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');


Route::resource('/buku', App\Http\Controllers\BukuController::class);
Route::resource('/user', App\Http\Controllers\UserController::class);
});
