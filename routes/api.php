<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\CompetonceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DeveloperTypeController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\NotificaationController;
use App\Http\Controllers\OfferDeEmploiController;
use App\Http\Controllers\PostileController;
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

//start user

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/token', [UserController::class, 'getUserFromToken']);
Route::post('/', [UserController::class, 'regester']);
Route::middleware('auth:sanctum')->get('/logout', [UserController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getAllUser']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->post('upload/image', [UserController::class, 'upload']);

// end user

// Route::post('/profile/upload-image',  [UplodImageController::class, 'store']);
// Route::get('/profile/upload-image',  [UplodImageController::class, 'getImage']);

// Route::middleware('auth:sanctum')->put('/update/{id}', [ProfileController::class, 'update']);

Route::middleware('auth:sanctum')->post('profile', [ProfileController::class, 'store']);
Route::middleware('auth:sanctum')->get('profile/competons', [ProfileController::class, 'getCompetoncesUser']);


// start compentons
Route::middleware('auth:sanctum')->get('getAll/commpetonce', [CompetonceController::class, 'index']);


// end commpetons


Route::get('images', [UplodImageController::class, 'index'])->name('images');

// start skills
Route::middleware('auth:sanctum')->post('ajouter/competonce', [SkillsUserController::class, 'store']);
Route::middleware('auth:sanctum')->get('get/competonce', [SkillsUserController::class, 'index']);
Route::middleware('auth:sanctum')->delete('suppermer/competonce/{id}', [SkillsUserController::class, 'destroy']);

//end skils

// start project
Route::middleware('auth:sanctum')->post('ajouter/project', [ProjectController::class, 'store']);
Route::middleware('auth:sanctum')->get('project', [ProjectController::class, 'getProjectUser']);
// end project

// start education
Route::middleware('auth:sanctum')->post('ajouter/education', [EducationController::class, 'store']);
Route::middleware('auth:sanctum')->get('get/education', [EducationController::class, 'index']);
// end education

// start commentaire
Route::middleware('auth:sanctum')->post('ajouter/commentaire/{id}', [CommentaireController::class, 'store']);
Route::middleware('auth:sanctum')->get('profile/commentaires', [CommentaireController::class, 'getCommentaireUser']);
// end commentaire

// start offerDePlois
Route::middleware('auth:sanctum')->post('ajouter/offerDePlois', [OfferDeEmploiController::class, 'store']);
Route::middleware('auth:sanctum')->get('offerDePlois', [OfferDeEmploiController::class, 'index']);
// end offerDePlois

// start postile
Route::middleware('auth:sanctum')->post('postile/{id}', [PostileController::class, 'store']);
Route::middleware('auth:sanctum')->get('postiles', [PostileController::class, 'index']);
// end postile

// start notification
Route::middleware('auth:sanctum')->get('notification/{id}/{idOfferDemploi}', [NotificaationController::class, 'store']);
// end notification

// start conatct
Route::middleware('auth:sanctum')->post('ajouter/contact', [ContactController::class, 'store']);
// end conatct

// start DeveloperType
Route::middleware('auth:sanctum')->get('DeveloperType', [DeveloperTypeController::class, 'index']);
// end DeveloperType


// start ende ploint de client 

// get Profile de Clientes




// end ende ploint de client 
