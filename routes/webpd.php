<?php

use App\Http\Controllers\PdController;
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

//  Cartographie
Route::get('/documentaire/cartographie', [PdController::class,'cartographie']);

//  Processus
Route::get('/documentaire/processus', [PdController::class,'processus']);
Route::post('/documentaire/save_add_processus', [PdController::class,'save_add_processus']);
Route::post('/documentaire/save_edit_processus', [PdController::class,'save_edit_processus']);
Route::post('/documentaire/save_delete_processus', [PdController::class,'save_delete_processus']);

//  Procédures
Route::get('/documentaire/procedures', [PdController::class,'procedure']);
Route::post('/documentaire/save_add_procedure', [PdController::class,'save_add_procedure']);
Route::post('/documentaire/save_edit_procedure', [PdController::class,'save_edit_procedure']);
Route::post('/documentaire/save_delete_procedure', [PdController::class,'save_delete_procedure']);

//  Archivage
Route::get('/documentaire/archivage', [PdController::class,'archivage']);

//  Enregistrements
Route::get('/documentaire/enregistrements', [PdController::class,'enregistrements']);
Route::post('/documentaire/save_add_enregistrement', [PdController::class,'save_add_enregistrement']);
Route::post('/documentaire/save_edit_enregistrement', [PdController::class,'save_edit_enregistrement']);
Route::post('/documentaire/save_delete_enregistrement', [PdController::class,'save_delete_enregistrement']);


Route::post('/get_employe_of_direction', [PdController::class,'get_employe_of_direction']);
Route::post('/get_pilotes_of_procedussus', [PdController::class,'get_pilotes_of_procedussus']);
Route::post('/get_poste_of_direction', [PdController::class,'get_poste_of_direction']);
Route::post('/get_nbr_procedures_of_processus', [PdController::class,'get_nbr_procedures_of_processus']);
Route::post('/get_processuses_of_direction', [PdController::class,'get_processuses_of_direction']);
Route::post('/get_data_for_this_procedure', [PdController::class,'get_data_for_this_procedure']);
Route::post('/get_typeprocedure_of_direction', [PdController::class,'get_typeprocedure_of_direction']);
