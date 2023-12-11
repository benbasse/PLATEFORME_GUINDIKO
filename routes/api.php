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
use App\Http\Controllers\Api\Newsletter;

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

Route::get('session/filtre', [SessionController::class, 'filtrerSession']);

//Pour les événements (ARCHIVER ET CRUD)

Route::get('evenement/filtre', [EvenementController::class, 'filtrerEvenements']);

//Pour les articles(ARCHIVER ET CRUD)
Route::get('articles', [ArticleController::class, 'index']);
Route::get('articles/show/{article}', [ArticleController::class, 'show']);
Route::get('articles/filtre', [ArticleController::class, 'filtrerArticles']);


// Pour les mentors (CRUD ET ARCHIVE)
Route::get('mentor', [MentorController::class, 'index']);
Route::get('mentor/nombreMentor', [MentorController::class, 'nombre_mentor']);
//Route pour les newsletter
Route::post('ajouterNewsletter', [Newsletter::class, 'store']);
//Route d'inscription et de connexion pour les users
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
//ROute d'inscription, connexion et de deconnexion des mentors
Route::post('login', [MentorController::class, 'login']);
Route::post('registerMentor', [MentorController::class, 'registerMentor']);
/*filtrage mentors*/
Route::get('filterMentorsByName', [MentorController::class, 'filterMentorsByName']);

/*routes d'acces pour mentors*/
Route::middleware(['auth:sanctum', 'acces:mentor'])->group(function () {
    //les sessions
    Route::get('session', [SessionController::class, 'index']);
    Route::get('session/show/{session}', [SessionController::class, 'show']);
    Route::post('session/create', [SessionController::class, 'store']);
    Route::delete('session/{session}', [SessionController::class, 'destroy']);
    Route::put('session/edit/{session}', [SessionController::class, 'update']);
    Route::get('session/sessionNonArchive', [SessionController::class, 'sessionNonArchive']);
    Route::get('session/sessionArchive', [SessionController::class, 'sessionArchive']);
    Route::get('mentor/nombreMentorAtteint', [MentorController::class, 'nombre_mentor_atteint']);
    Route::post('verifMail/mentor', [MentorController::class, 'verifMailMentor']);
    Route::post('resetPassword/mentor/{mentor}', [MentorController::class, 'resetPasswordMentor']);
    /*routes d'acces pour mentors*/
    Route::post('logout', [MentorController::class, 'logout']);
    Route::put('session/archive/{session}', [SessionController::class, 'archive']);

    // Route::post('mentorat/create', [MentoratController::class, 'store']);

    Route::get('mentor/listes_sessions/{mentor}', [MentorController::class, 'listesSessions']);
});
// Route::post('session/create', [SessionController::class, 'store']);


// Route::post('logout', [MentorController::class, 'logout']);

//Pour les mentorats (CRUD)
Route::get('mentorats/index', [MentoratController::class, 'index']);
Route::get('mentorats/show/{mentorat}', [MentoratController::class, 'show']);

/*routes d'acces pour mentorés*/
Route::middleware(['auth:sanctum', 'acces:user'])->group(function () {
    Route::post('logoutUser', [UserController::class, 'logoutUser']);
    Route::get('user/selectionne', [UserController::class, 'selectionneMentor']);
    Route::get('user/index', [UserController::class, 'index']);
    /*filtrage users*/
    Route::post('verifMail/user', [UserController::class, 'verifMailUser']);
    Route::get('user/filterUsersByName', [UserController::class, 'filterUsersByName']);
    Route::get('user/mentoreNonArchive', [UserController::class, 'mentoreNonArchive']);
    Route::post('resetPassword/user/{user}', [UserController::class, 'resetPasswordUser']);
});

/*routes d'acces pour admin*/
Route::middleware(['auth:sanctum', 'acces:admin'])->group(function () {
    Route::get('evenement', [EvenementController::class, 'index']);
    Route::post('evenement/create', [EvenementController::class, 'store']);
    Route::get('evenement/show/{evenement}', [EvenementController::class, 'show']);
    Route::delete('evenement/{evenement}', [EvenementController::class, 'destroy']);
    Route::put('evenement/edit/{evenement}', [EvenementController::class, 'update']);

    Route::get('evenement/EvenementArchive', [EvenementController::class, 'EvenementArchive']);
    Route::get('evenement/EvenementNonArchive', [EvenementController::class, 'EvenemenNontArchive']);
    Route::put('evenement/archive/{evenement}', [EvenementController::class, 'archive']);

    Route::delete('articles/{article}', [ArticleController::class, 'destroy']);
    Route::put('articles/edit/{article}', [ArticleController::class, 'update']);
    Route::post('articles/create', [ArticleController::class, 'store']);
    Route::put('articles/archives/{article}', [ArticleController::class, 'archive']);
    Route::get('articles/articlesArchives', [ArticleController::class, 'articlesArchives']);
    Route::get('articles/articlesNonArchives', [ArticleController::class, 'articlesNonArchives']);
    Route::get('mentor/nonArchive', [MentorController::class, 'non_archive']);
    Route::get('mentor/estArchive', [MentorController::class, 'est_archive']);
    Route::put('mentor/archive/{mentor}', [MentorController::class, 'archive']);

    Route::put('user/archive/{user}', [UserController::class, 'archive']);
    Route::get('user/mentoreArchive', [UserController::class, 'mentoreArchive']);
});
