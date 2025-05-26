<?php

use App\Http\Controllers\StatistikController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;

Route::get('/', [StatistikController::class, 'home'])->name('home');
Route::get('/survey', [SurveyController::class, 'index'])->name('survey.index');
Route::post('/survey/start', [SurveyController::class, 'start'])->name('survey.start');

Route::get('/survey/questions', [SurveyController::class, 'questions'])->name('survey.questions');
Route::post('/survey/questions', [SurveyController::class, 'submit'])->name('survey.submit');
Route::get('/get-services/{unit_id}', [SurveyController::class, 'getServices']);

Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik.index');
Route::get('/testing', [StatistikController::class, 'test'])->name('testing.indexs');
