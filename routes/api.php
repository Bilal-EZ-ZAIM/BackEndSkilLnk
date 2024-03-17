<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillsUserController;
use App\Http\Controllers\UplodImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/', [UserController::class, 'regester']);

Route::post('/profile/upload-image',  [UplodImageController::class, 'store']);
Route::get('/profile/upload-image',  [UplodImageController::class, 'getImage']);

Route::middleware('auth:sanctum')->put('/update/{id}', [ProfileController::class, 'update']);

Route::middleware('auth:sanctum')->get('/token', [UserController::class, 'getUserFromToken']);


Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->post('/profile', [ProfileController::class, 'store']);

Route::middleware('auth:sanctum')->get('/logout', [UserController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getAllUser']);

Route::middleware('auth:sanctum')->get('/profile/competons', [ProfileController::class, 'getCompetoncesUser']);

Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'getProjectUser']);


Route::get('images', [UplodImageController::class, 'index'])->name('images');
Route::middleware('auth:sanctum')->post('upload/image', [UserController::class, 'upload']);


Route::middleware('auth:sanctum')->post('ajouter/competonce', [SkillsUserController::class, 'store']);

Route::middleware('auth:sanctum')->post('ajouter/project', [ProjectController::class, 'store']);
