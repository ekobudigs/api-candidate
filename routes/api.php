<?php

use App\Http\Controllers\API\CandidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\JobController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\SkillController;
use App\Http\Controllers\API\SkillSetController;
use App\Http\Controllers\API\SkillSetSetController;

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

Route::get('/skill', [SkillController::class, 'fetch'])->middleware('auth:sanctum');
Route::post('/skill', [SkillController::class, 'create'])->middleware('auth:sanctum')->name('create');
Route::post('/skill/update/{id}', [SkillController::class, 'update'])->middleware('auth:sanctum')->name('update');
Route::delete('/skill/{id}', [SkillController::class, 'destroy'])->middleware('auth:sanctum')->name('delete');


Route::get('/job', [JobController::class, 'fetch'])->middleware('auth:sanctum');
Route::post('/job', [JobController::class, 'create'])->middleware('auth:sanctum')->name('create');
Route::post('/job/update/{id}', [JobController::class, 'update'])->middleware('auth:sanctum')->name('update');
Route::delete('/job/{id}', [JobController::class, 'destroy'])->middleware('auth:sanctum')->name('delete');


Route::get('/skill-set', [SkillSetController::class, 'fetch'])->middleware('auth:sanctum');
Route::post('/skill-set', [SkillSetController::class, 'create'])->middleware('auth:sanctum')->name('create');
Route::post('/skill-set/update/{id}', [SkillSetController::class, 'update'])->middleware('auth:sanctum')->name('update');
Route::delete('/skill-set/{id}', [SkillSetController::class, 'destroy'])->middleware('auth:sanctum')->name('delete');


Route::get('/candidate', [CandidateController::class, 'fetch'])->middleware('auth:sanctum');
Route::post('/candidate', [CandidateController::class, 'create'])->middleware('auth:sanctum')->name('create');
Route::post('/candidate/update/{id}', [CandidateController::class, 'update'])->middleware('auth:sanctum')->name('update');
Route::delete('/candidate/{id}', [CandidateController::class, 'destroy'])->middleware('auth:sanctum')->name('delete');



Route::name('auth.')->group(function () {
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('register', [UserController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [UserController::class, 'logout'])->name('logout');
    });
});