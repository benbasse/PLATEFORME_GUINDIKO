<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MentorController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\EvenementController;
use App\Http\Controllers\Api\MentoratController;

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

//Pour les sessions (CRUD ET ARCHIVE)
Route::get('session', [SessionController::class, 'index']);
Route::get('session/show', [SessionController::class, 'show']);
Route::post('session/create', [SessionController::class, 'store']);
Route::delete('session/{session}', [SessionController::class, 'destroy']);
Route::get('session/filtre', [SessionController::class, 'filtrerSession']);
Route::put('session/edit/{session}', [SessionController::class, 'update']);
Route::put('session/archive/{session}', [SessionController::class, 'archive']);
Route::get('session/sessionArchive', [SessionController::class, 'sessionArchive']);


//Pour les événements (ARCHIVER ET CRUD)
Route::get('evenement', [EvenementController::class, 'index']);
Route::post('evenement/create', [EvenementController::class, 'store']);
Route::get('evenement/show/{evenement}', [EvenementController::class, 'show']);
Route::delete('evenement/{evenement}', [EvenementController::class, 'destroy']);
Route::put('evenement/edit/{evenement}', [EvenementController::class, 'update']);
Route::get('evenement/filtre', [EvenementController::class, 'filtrerEvenements']);
Route::put('evenement/archive/{evenement}', [EvenementController::class, 'archive']);
Route::get('evenement/EvenementArchive', [EvenementController::class, 'EvenementArchive']);
Route::get('evenement/EvenementNonArchive', [EvenementController::class, 'EvenemenNontArchive']);

//Pour les articles(ARCHIVER ET CRUD)
Route::get('articles', [ArticleController::class, 'index']);
Route::post('articles/create', [ArticleController::class, 'store']);
Route::get('articles/show/{article}', [ArticleController::class, 'show']);
Route::delete('articles/{article}', [ArticleController::class, 'destroy']);
Route::put('articles/edit/{article}', [ArticleController::class, 'update']);
Route::get('articles/filtre', [ArticleController::class, 'filtrerArticles']);
Route::put('articles/archives/{article}', [ArticleController::class, 'archive']);
Route::get('articles/articlesArchives', [ArticleController::class, 'articlesArchives']);
Route::get('articles/articlesNonArchives', [ArticleController::class, 'articlesNonArchives']);



// Pour les mentors (CRUD ET ARCHIVE)
Route::get('mentor', [MentorController::class, 'index']);
Route::get('mentor/nonArchive', [MentorController::class, 'non_archive']);
Route::get('mentor/estArchive', [MentorController::class, 'est_archive']);
Route::put('mentor/archive/{mentor}', [MentorController::class, 'archive']);
Route::put('mentor/archive/{mentor}', [MentorController::class, 'archive']);
Route::get('mentor/nombreMentor', [MentorController::class, 'nombre_mentor']);
Route::get('mentor/nombreMentorAtteint', [MentorController::class, 'nombre_mentor_atteint']);

//Pour les mentorats (CRUD)
Route::post('mentorat/create', [MentoratController::class, 'store']);
Route::get('mentorat/show', [MentoratController::class, 'show']);
Route::get('mentorat/index', [MentoratController::class, 'index']);

//Route d'inscription et de connexion pour les users
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

//ROute d'inscription, connexion et de deconnexion des mentors
Route::post('login', [MentorController::class, 'login']);
Route::post('registerMentor', [MentorController::class, 'registerMentor']);



Route::middleware(['auth:sanctum', 'acces:mentor'])->group(function () {
    /*routes d'acces pour mentors*/
Route::post('logout', [MentorController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'acces:user'])->group(function () {
    /*routes d'acces pour mentorés*/
    Route::post('logoutUser', [UserController::class, 'logoutUser']);
});

Route::middleware(['auth:sanctum', 'acces:admin'])->group(function () {
    /*routes d'acces pour admin*/
});

