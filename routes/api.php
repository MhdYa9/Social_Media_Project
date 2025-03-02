<?php

use App\Actions\Auth\CreateUser;
use App\Actions\Auth\LoginUser;
use App\Actions\Auth\LogoutUser;
use Illuminate\Support\Facades\Route;


//Route::get('/users', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

//------------------------------------------------Auth----------------------------------------
Route::post('/register',CreateUser::class )->middleware('guest:sanctum');
Route::post('/login',LoginUser::class );
Route::post('/logout',LogoutUser::class)->middleware('auth:sanctum');

Route::fallback(function(){
    return response()->json(['message' => 'No Such Route.'], 404);
});
