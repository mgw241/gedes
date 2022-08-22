<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RhController;

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
Route::get('/rh/employes', [RhController::class,'employes']);
Route::post('/rh/employes/add', [RhController::class,'employes_add']);
Route::get('/rh/employes/add', [RhController::class,'employes_add']);
Route::post('/rh/employes/save_add', [RhController::class,'employes_save_add']);
Route::post('/rh/employes/get_sevices_of_departement', [RhController::class,'get_sevices_of_departement']);
Route::post('/rh/employes/get_poste_of_services', [RhController::class,'get_poste_of_services']);
Route::post('/rh/employes/get_postes_of_direction', [RhController::class,'get_postes_of_direction']);

Route::get('/rh/employes/{val}', [RhController::class,'employes_show']);
Route::get('/rh/employes/{val}/carriere', [RhController::class,'employes_show_carriere']);
Route::get('/rh/employes/{val}/salaire', [RhController::class,'employes_show_salaire']);
Route::get('/rh/employes/{val}/conge', [RhController::class,'employes_show_conge']);
Route::get('/rh/employes/{val}/abscence', [RhController::class,'employes_show_abscence']);
Route::get('/rh/employes/{val}/enfant', [RhController::class,'employes_show_enfant']);
Route::get('/rh/employes/{val}/mission', [RhController::class,'employes_show_mission']);
Route::get('/rh/employes/{val}/document', [RhController::class,'employes_show_document']);

Route::post('/rh/employes/save_affectation', [RhController::class,'save_affectation']);
Route::post('/rh/employes/save_enfant', [RhController::class,'save_enfant']);
Route::post('/rh/employes/save_edit_enfant', [RhController::class,'save_edit_enfant']);
Route::post('/employe_conge/save_add_old_conge', [RhController::class,'save_add_old_conge']);
Route::post('/rh/employes/save_add_documents', [RhController::class,'save_add_documents']);
Route::post('/rh/employes/save_delete_documents', [RhController::class,'save_delete_documents']);
Route::post('/rh/employes/save_edit_documents', [RhController::class,'save_edit_documents']);




//  ABSCENCE
Route::get('/rh/abscences_conges/abscences', [RhController::class,'abscence_conge']);
Route::get('/generer/emp_demande/abscence/{val}', [RhController::class,'generer_emp_demande_abscence']);

//  Conges
Route::get('/rh/abscences_conges/conges', [RhController::class,'conge_abscence']);

//  Missions
Route::get('/rh/missions', [RhController::class,'missions']);