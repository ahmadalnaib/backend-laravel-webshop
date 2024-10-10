<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return UserResource::make($request->user());
 })->middleware('auth:sanctum');


 Route::get('/users',function(){
    return User::all();
 });




 
 Route::post('/products', [ProductController::class, 'getProductData']);