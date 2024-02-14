<?php

use App\Http\Controllers\NoteApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/notes',[NoteApiController::class,'store']);
Route::get('/notes',[NoteApiController::class,'index']);
Route::get('/notes/{id}',[NoteApiController::class,'show']);
Route::put('/notes/{id}',[NoteApiController::class,'update']);
