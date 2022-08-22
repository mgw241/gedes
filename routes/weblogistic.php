<?php

use App\Http\Controllers\LogisticController;
use App\Http\Controllers\MessController;
use App\Http\Controllers\PdController;
use App\Http\Controllers\TachesController;
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

/*                  
*   ----------------------------------------------------    /
*   ----------------------------------------------------    /
*                   PARC AUTOMOBILE
*/

Route::get('/logistique_securite/parc_automobile', [LogisticController::class,'parc_automobile']);  
Route::post('/logistique_securite/save_add_vehicule',[LogisticController::class,'save_add_vehicule']);

Route::get('/logistique_securite/parc_automobile/{val}/identification',[LogisticController::class,'vehicule_show_identification']);
Route::get('/logistique_securite/parc_automobile/{val}/affectation',[LogisticController::class,'vehicule_show_affectation']);
Route::get('/logistique_securite/parc_automobile/{val}/vidange',[LogisticController::class,'vehicule_show_vidange']);
Route::get('/logistique_securite/parc_automobile/{val}/visite_technique',[LogisticController::class,'vehicule_show_visite_technique']);
Route::get('/logistique_securite/parc_automobile/{val}/extincteur',[LogisticController::class,'vehicule_show_extincteur']);
Route::get('/logistique_securite/parc_automobile/{val}/outillage',[LogisticController::class,'vehicule_show_outillage']);

//  ADD
Route::post('/logistique_securite/vehicule/add_affectation',[LogisticController::class,'vehicule_add_affectation']);
Route::post('/logistique_securite/vehicule/add_vidange',[LogisticController::class,'vehicule_add_vidange']);
Route::post('/logistique_securite/vehicule/add_visite_technique',[LogisticController::class,'vehicule_add_visite_technique']);
Route::post('/logistique_securite/vehicule/add_extincteur',[LogisticController::class,'vehicule_add_extincteur']);

//  EDIT
Route::post('/logistique_securite/vehicule/edit_outillage',[LogisticController::class,'vehicule_edit_outillage']);
Route::post('/logistique_securite/vehicule/edit_identification',[LogisticController::class,'vehicule_edit_identification']);
Route::post('/logistique_securite/vehicule/edit_vidange',[LogisticController::class,'vehicule_edit_vidange']);
Route::post('/logistique_securite/vehicule/edit_visite_technique',[LogisticController::class,'vehicule_edit_visite_technique']);
Route::post('/logistique_securite/vehicule/edit_extincteur',[LogisticController::class,'vehicule_edit_extincteur']);

//  CRON EXPIRATION EMAIL
Route::get('/logistique_securite/sendEmailExpirations',[LogisticController::class,'sendEmailExpirations']);


/*                  
*   ----------------------------------------------------    /
*   ----------------------------------------------------    /
*                       LOGISTIQUE 
*/
Route::get('/logistique_securite/logistique', [LogisticController::class,'logistique']); 


//Route::get('/logistique_securite/logistique', [LogisticController::class,'logistique']);  



