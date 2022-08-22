<?php

use App\Http\Controllers\EmpController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//  EMPLOYE
Route::get('/profil', [EmpController::class,'employes_show']);
Route::get('/profil/carriere', [EmpController::class,'employes_show_carriere']);
Route::get('/profil/salaire', [EmpController::class,'employes_show_salaire']);
Route::get('/profil/conge', [EmpController::class,'employes_show_conge']);
Route::get('/profil/abscence', [EmpController::class,'employes_show_abscence']);
Route::get('/profil/enfant', [EmpController::class,'employes_show_enfant']);
Route::get('/profil/mission', [EmpController::class,'employes_show_mission']);
Route::get('/profil/document', [EmpController::class,'employes_show_document']);

// ABSCENCES
Route::get('/mes_abscences', [EmpController::class,'mes_abscences']);
Route::post('/mes_abscences/save_add', [EmpController::class,'save_add_abscence']);
Route::post('/mes_abscences/save_edit_justificatif', [EmpController::class,'save_edit_justificatif']);
Route::post('/etat/workflow/abscence/{val}', [EmpController::class,'show_etat_workflow_abscence']);

// CONGES
Route::get('/mes_conges', [EmpController::class,'mes_conges']);
Route::post('/mes_conges/save_add', [EmpController::class,'save_add_conge']);
// MISSIONS
Route::get('/mes_missions', [EmpController::class,'mes_missions']);
Route::post('/mes_missions/save_add', [EmpController::class,'save_add_mission']);

