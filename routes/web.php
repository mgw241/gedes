<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GedesController;
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

Route::get('/test', [GedesController::class,'test']);
//  Index
Route::get('/', [GedesController::class,'login']);

//  Se Loger
Route::post('/se_loger', [GedesController::class,'se_loger']);

//  Se Logout
Route::get('/logout', [GedesController::class,'se_logout']);

//  Accueil
Route::get('/home', [GedesController::class,'home']);

//  Groupes
Route::get('/access/groupes', [GedesController::class,'groupe']);
Route::post('/access/groupes/delete_group', [GedesController::class,'delete_group']);
Route::post('/access/groupes/add_group', [GedesController::class,'add_group']);
Route::get('/access/groupes/edit_group/{val}', [GedesController::class,'edit_group']);
Route::post('/access/groupes/saveeditgroup', [GedesController::class,'save_edit_group'])->name('saveeditgroup.post');

//  Users
Route::get('/access/utilisateurs', [GedesController::class,'utilisateur']);
Route::post('/access/utilisateurs/add_user', [GedesController::class,'add_user']);
Route::post('/access/utilisateurs/delete_user', [GedesController::class,'delete_user']);
Route::get('/access/utilisateurs/showuser/{var}', [GedesController::class,'showuser']);
Route::get('/access/utilisateurs/edituser/{val}', [GedesController::class,'edituser']);

Route::post('/access/utilisateurs/saveedituser', [GedesController::class,'saveedituser']);

//  NOTIFICATIONS
Route::get('/getnotificationtache', [GedesController::class,'getnotificationtache']);
Route::get('/getnotificationmessage', [GedesController::class,'getnotificationmessage']);


//  Config
Route::get('/configuration/configuration/', [GedesController::class,'configuration']);
Route::post('/configuration/save_add_direction', [GedesController::class,'save_add_direction']);
Route::post('/configuration/save_edit_direction', [GedesController::class,'save_edit_direction']);
Route::post('/configuration/save_delete_direction', [GedesController::class,'save_delete_direction']);

Route::get('/configuration/configuration/departement', [GedesController::class,'configuration_departement']);
Route::post('/configuration/save_add_departement', [GedesController::class,'save_add_departement']);
Route::post('/configuration/save_edit_departement', [GedesController::class,'save_edit_departement']);
Route::post('/configuration/save_delete_departement', [GedesController::class,'save_delete_departement']);


Route::get('/configuration/configuration/service', [GedesController::class,'configuration_service']);
Route::post('/configuration/save_add_service', [GedesController::class,'save_add_service']);
Route::post('/configuration/save_edit_service', [GedesController::class,'save_edit_service']);
Route::post('/configuration/save_delete_service', [GedesController::class,'save_delete_service']);

Route::get('/configuration/configuration/poste', [GedesController::class,'configuration_poste']);
Route::post('/configuration/save_add_poste', [GedesController::class,'save_add_poste']);
Route::post('/configuration/save_edit_poste', [GedesController::class,'save_edit_poste']);
Route::post('/configuration/save_delete_poste', [GedesController::class,'save_delete_poste']);

Route::get('/configuration/configuration/pays', [GedesController::class,'configuration_pays']);
Route::post('configuration/save_add_pays', [GedesController::class,'save_add_pays']);
Route::post('configuration/save_edit_pays', [GedesController::class,'save_edit_pays']);
Route::post('configuration/save_delete_pays', [GedesController::class,'save_delete_pays']);

Route::get('/configuration/configuration/ville', [GedesController::class,'configuration_ville']);
Route::post('/configuration/save_add_ville', [GedesController::class,'save_add_ville']);
Route::post('/configuration/save_edit_ville', [GedesController::class,'save_edit_ville']);
Route::post('/configuration/save_delete_ville', [GedesController::class,'save_delete_ville']);

Route::get('/configuration/configuration/type_document', [GedesController::class,'configuration_type_document']);
Route::post('/configuration/save_add_type_document', [GedesController::class,'save_add_type_document']);
Route::post('/configuration/save_edit_type_document', [GedesController::class,'save_edit_type_document']);
Route::post('/configuration/save_delete_type_document', [GedesController::class,'save_delete_type_document']);



Route::get('/configuration/configuration/civilite', [GedesController::class,'configuration_civilite']);

Route::get('/configuration/configuration/m_parc_auto', [GedesController::class,'configuration_m_parc_auto']);
Route::post('/configuration/save_add_m_parc_auto', [GedesController::class,'save_add_m_parc_auto']);
Route::post('/configuration/save_delete_m_parc_auto', [GedesController::class,'save_delete_m_parc_auto']);
//  GET X of Y
Route::post('/get_departements_of_direction', [GedesController::class,'get_departements_of_direction']);
Route::post('/get_service_of_departement', [GedesController::class,'get_service_of_departement']);
Route::post('/get_ville_of_pays', [GedesController::class,'get_ville_of_pays']);
Route::post('/get_hierarchies', [GedesController::class,'get_hierarchies']);
