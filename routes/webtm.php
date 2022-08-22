<?php

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
*                   TACHES ET ACTIONS
*/

Route::get('/taches/taches/taches/{val}', [TachesController::class,'taches']);  
Route::get('/taches/taches/actions/{val}', [TachesController::class,'actions']);  

Route::get('/taches/taches/analyser/abscences/{val}', [TachesController::class,'analyser_abscence']);  

Route::get('/taches/taches/analyser/conges/{val}', [TachesController::class,'analyser_conge']);  

Route::get('/taches/taches/analyser/missions/{val}', [TachesController::class,'analyser_mission']);  

Route::get('/testemail',[TachesController::class,'basic_email']);

Route::post('/taches/analyser/abscence/save',[TachesController::class,'save_tache_abscence']);
Route::post('/taches/analyser/mission/save',[TachesController::class,'save_tache_mission']);
Route::post('/taches/analyser/conge/save',[TachesController::class,'save_tache_conge']);

/*                  
*   ----------------------------------------------------    /
*   ----------------------------------------------------    /
*                       ANNUARE
*/
Route::get('/annuaire',[TachesController::class,'go_to_annuaire']);

/*                  
*   ----------------------------------------------------    /
*   ----------------------------------------------------    /
*                       MESSAGERIE
*/

Route::get('/messagerie', [MessController::class,'messagerie']);  

Route::get('/messagerie/users', [MessController::class,'get_users']);  
Route::get('/messagerie/search_user/{val}', [MessController::class,'search_user']);  
Route::get('/messagerie/messagerie/chat/{val}', [MessController::class,'chat_with']); 
 
Route::post('/messagerie/inserer_message', [MessController::class,'inserer_message']);
Route::get('/messagerie/inserer_message/{val1}/{val2}', [MessController::class,'inserer_message']); 

Route::post('/messagerie/get_chat', [MessController::class,'get_chat']);  
Route::get('/messagerie/get_chat/{val}', [MessController::class,'get_chat2']);  


