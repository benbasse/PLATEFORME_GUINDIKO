<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SessionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Pour les sessions 
Route::get('session', [SessionController::class, 'index']);
Route::get('session/show', [SessionController::class, 'show']);
Route::post('session/create', [SessionController::class, 'store']);
Route::delete('session/{session}', [SessionController::class, 'destroy']);
Route::put('session/edit/{session}', [SessionController::class, 'update']);
Route::get('session/filtrer', [SessionController::class, 'filtrerSession']);
Route::put('session/archive/{session}', [SessionController::class, 'archive']);
Route::get('session/sessionArchive', [SessionController::class, 'sessionArchive']);
Route::get('session/sessionNonArchive', [SessionController::class, 'sessionNonArchive']);