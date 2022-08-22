<?php

use App\Models\Abscence;
use App\Models\Conge;
use App\Models\Groupe_form;
use App\Models\Mission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;
//	Voir _START_ sur _END_ des _TOTAL_ entrée(s)

	//	**************************************************	//
	//						TTRE DES PAGES
	//	**************************************************	//
if (!function_exists('page_title')) {

		function page_title(?string $titre = null): string{	
			/*if ($titre == null){
				return config('app.name');
			} else {
				return $titre.' # '.config('app.name');
			}*/

			return $titre ? $titre.' | '.config('app.name') : config('app.name');
		}

	} 
	/*if (!function_exists('darylGetImageToStore')) {

		function darylGetImageToStore(Input $image){	
			$fileNameWithExtension = $image->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $storeNameImage = $fileName.''.time().'.'.$extension;
		}

	} */


	//	**************************************************	//
	//					CONEXION LDAP SERVER
	//	**************************************************	//

	//	Il aut autoloader le fichier dans composer.json 

	if (!function_exists('connection_ad')) {
		//
		function connection_ad($ip,$port,$user,$pwd){
			$correct=false;
			$connection=ldap_connect($ip,$port) ;  
			ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
			
			if(!$connection){
				echo "Probleme connection au serveur AD<br/>";
				exit;
			}
			else{
			
				$liaison=ldap_bind($connection,$user,$pwd);
				if($liaison){
					$correct=true;
					
				}		
			}
			ldap_close($connection);
			return $correct;
		}
	}

	if(!function_exists('connexion_adds')){
		function connexion_adds($user, $pass)
		{
			$ldap = ldap_connect(config('app.LDAPSERVER')); // env('LDAPSERVER')
			$username = $user;
			$password = $pass;

			$ldaprdn = strip_tags($username) .'@'. config('app.DOMAIN_FQDN'); // env('DOMAIN_FQDN')//'lab.ga' . "\\" . $username;

			ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

			$bind = @ldap_bind($ldap, $ldaprdn, $password);
			return $bind;
			// STR0/ darryl.m@str.local / strafrica / 107
			//return true;//
		}

	}

	//	**************************************************	//
	//						ERRORS
	//	**************************************************	//
/*
	if(!function_exists('custom_error')){
		function custom_error($nuero_error)
		{
			$message = '';
			switch ($nuero_error) {
				case 0:
					$message = '00: Erreur de connexon <br/> Email ou Mot de passe incorrect';
					break;
				case 1:
					$message = '01: Cette opération ne peut pas être éffectuée car ce groupe contient des utilisateurs';
					break;
				case 2:
					$message = "02: Vous n'avez pas le droit d'acceder à cette section !";
					break;
			
				default:
					# code...
					break;
			}
			return $message;
		}

	}
*/
	//	**************************************************	//
	//					PERSSION OF VIEW
	//	**************************************************	//
	
	if(!function_exists('perission_user_of_view')){
		function perission_user_of_view($idUser, $form, $node)
		{
			$pession = new Groupe_form();
			$pession = DB::select('SELECT groupe_forms.*, utilisateurs.actif
									FROM groupe_forms, utilisateurs, forms, groupes
									WHERE forms.nom = ?
									AND forms.node = ?
									AND utilisateurs.id=?
									AND groupes.id=utilisateurs.groupe_id 
									AND groupe_forms.form_id=forms.id
									AND groupe_forms.group_id=groupes.id',
									[$form, $node, $idUser]);
			return $pession;
		}

	}

	//	**************************************************	//
	//					RERESH PERMISSION 
	//	**************************************************	//

	if(!function_exists('reresh_perssion')){
		//function reresh_perssion($user, $form, $node)
		function reresh_perssion($user, $url)
		{
			try{
				if( sizeof(explode('/',$url)) >= 5){	// CE N'est PAS UN NODE SEUL
					$nodeOfUrl = strtoupper( (explode('/',$url))[3] );
					$formOfUrl = ucfirst( (explode('/',$url))[4] );
	
					$user = session()->get('user');
					$permission = perission_user_of_view($user->id, $formOfUrl, $nodeOfUrl);
				}else{
					$nodeOfUrl = strtoupper( (explode('/',$url))[3] );
					$formOfUrl = $nodeOfUrl;

					$user = session()->get('user');
					$permission = perission_user_of_view($user->id, $formOfUrl, $nodeOfUrl);
				}
				
				//session(['permission' => $permission]);
				session()->put('permission',$permission);
			}catch(\Exception $e){
				session()->put('error',$e->getMessage());
			}
			
		}

	}

	
	//	**************************************************	//
	//		RETURNER UNE VIEW AFTER CHECK PERMISSION READ
	//	**************************************************	//

	if(!function_exists('return_view_after_check_read')){
		function return_view_after_check_read($viewpath)
		{
			if(!isset(session()->get('permission')[0])){
					session()->put('warning',custom_warning('W028'));
					return back()->withInput();
			}
			if(session()->get('permission')[0]->actif == '0'){
				return redirect('/');
			}
			if( session()->get('permission') != null ){
				if (session()->get('permission')[0]->read == '1')
					return view($viewpath);
				else{
					session()->put('warning',custom_warning('W000'));
					return back()->withInput();
				}
			}else{
				//return redirect('/');
				session()->put('warning',custom_warning('W000'));
				return back()->withInput();
			}
			
				
		}
	}

	if(!function_exists('return_view_after_check')){
		function return_view_after_check($viewpath,$action)
		{
			switch ($action) {
				case 'read':
					if(session()->get('permission')[0]->actif == '0'){
						return redirect('/');
					}
					if( session()->get('permission') != null ){
						if (session()->get('permission')[0]->read == '1')
							return view($viewpath);
						else{
							session()->put('warning',custom_warning('W000'));
							return back()->withInput();
						}
					}else{
						//return redirect('/');
						session()->put('warning',custom_warning('W000'));
						return back()->withInput();
					}
					break;
				case 'add':
					if(session()->get('permission')[0]->actif == '0'){
						return redirect('/');
					}
					if( session()->get('permission') != null ){
						if (session()->get('permission')[0]->add == '1')
							return view($viewpath);
						else{
							session()->put('warning',custom_warning('W000'));
							return back()->withInput();
						}
					}else{
						//return redirect('/');
						session()->put('warning',custom_warning('W000'));
						return back()->withInput();
					}
					break;
				case 'delete':
					if(session()->get('permission')[0]->actif == '0'){
						return redirect('/');
					}
					if( session()->get('permission') != null ){
						if (session()->get('permission')[0]->delete == '1')
							return view($viewpath);
						else{
							session()->put('warning',custom_warning('W000'));
							return back()->withInput();
						}
					}else{
						//return redirect('/');
						session()->put('warning',custom_warning('W000'));
						return back()->withInput();
					}
					break;
				case 'export':
					# code...
					break;
				default:
					# code...
					break;
			}
				
		}
	}

	//	**************************************************	//
	//		VERIFIER SI LA VUE EST READABLE
	//	**************************************************	//

	if(!function_exists('is_readable_view')){
		function is_readable_view($form, $node, $idUser)
		{
			$resultat = 0;
			//$pession = new Groupe_form();
			$nouveau = DB::select('SELECT COUNT(groupe_forms.group_id) as nbr
			FROM groupe_forms, utilisateurs, forms, groupes
			WHERE forms.nom = ?
			AND forms.node = ?
			AND utilisateurs.id=?
			AND groupes.id=utilisateurs.groupe_id 
			AND groupe_forms.form_id=forms.id
			AND groupe_forms.group_id=groupes.id',
			[$form, $node, $idUser]);

			if( $nouveau[0]->nbr == 0 ){
				$resultat =  0;
			}else{

				$pession = DB::select('SELECT groupe_forms.read
				FROM groupe_forms, utilisateurs, forms, groupes
				WHERE forms.nom = ?
				AND forms.node = ?
				AND utilisateurs.id=?
				AND groupes.id=utilisateurs.groupe_id 
				AND groupe_forms.form_id=forms.id
				AND groupe_forms.group_id=groupes.id',
				[$form, $node, $idUser]);
				$resultat =  ($pession[0]->read);
			}
			return $resultat;
		}
	}

	//	**************************************************	//
	//		CHECK SESSION
	//	**************************************************	//

	if(!function_exists('check_session')){
		function check_session()
		{
			if( session()->get('user') == null ){
				return 'no';
			}
				
		}
	}

	//	**************************************************	//
	//		CHECK IF ANALYSE ID EXIST
	//	**************************************************	//

	if(!function_exists('check_analyse_exist')){
		function check_analyse_exist()
		{
			$val = DB::select("SELECT * FROM workflow_analyses WHERE code_emp=?",[session()->get('user')->code_user]);
			if( $val == null ){
				return 'no';
			}
				
		}
	}


	//	**************************************************	//
	//		Get File Name to Store
	//	**************************************************	//

	if(!function_exists('get_file_name_to_store')){
		function get_file_name_to_store($request, $image_dans_request, $storageLocal, $debut_imagge_dans_storage, $image_pardefaut)
		{
			if ($request->hasFile($image_dans_request)) {
				$fileNameWithExtension = $request->file($image_dans_request)->getClientOriginalName();
				$fileName = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);
				$extension = $request->file($image_dans_request)->getClientOriginalExtension();
				$fileNameToStore = $debut_imagge_dans_storage.'.'.$extension;
				
				//  Stocker : Storage/app/public/
				$path = $request->file($image_dans_request)->storeAs($storageLocal, $fileNameToStore);
				//->storeAs($storageLocal, $fileNameToStore, 'custom_disk');
				return $fileNameToStore;
			}else{
				$fileNameToStore = $image_pardefaut;
				return $fileNameToStore;
			}
				
		}
	}

	if(!function_exists('get_file_name_to_store_With_Extension_inName')){
		function get_file_name_to_store_With_Extension_inName($request, $image_dans_request, $storageLocal, $debut_imagge_dans_storage, $image_pardefaut)
		{
			if ($request->hasFile($image_dans_request)) {
				$fileNameWithExtension = $request->file($image_dans_request)->getClientOriginalName();
				$fileName = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);
				$extension = $request->file($image_dans_request)->getClientOriginalExtension();
				$fileNameToStore = $debut_imagge_dans_storage;
				
				//  Stocker : Storage/app/public/
				$path = $request->file($image_dans_request)->storeAs($storageLocal, $fileNameToStore);
				//->storeAs($storageLocal, $fileNameToStore, 'custom_disk');
				return $fileNameToStore;
			}else{
				$fileNameToStore = $image_pardefaut;
				return $fileNameToStore;
			}
				
		}
	}

	if(!function_exists('get_file_name_to_store_SameName')){
		function get_file_name_to_store_SameName($request, $image_dans_request, $storageLocal)
		{
			$fileNameWithExtension = $request->file($image_dans_request)->getClientOriginalName();
			$fileName = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);
			$extension = $request->file($image_dans_request)->getClientOriginalExtension();
			$fileNameToStore = $fileName.'.'.$extension;
			
			//  Stocker : Storage/app/public/
			$path = $request->file($image_dans_request)->storeAs($storageLocal, $fileNameToStore);
			//->storeAs($storageLocal, $fileNameToStore, 'custom_disk');
			return $fileNameToStore;
			
				
		}
	}

	if(!function_exists('get_file_name_to_store_witTime')){
		function get_file_name_to_store_witTime($request, $image_dans_request, $storageLocal, $debut_imagge_dans_storage, $image_pardefaut)
		{
			if ($request->hasFile($image_dans_request)) {
				$fileNameWithExtension = $request->file($image_dans_request)->getClientOriginalName();
				$fileName = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);
				$extension = $request->file($image_dans_request)->getClientOriginalExtension();
				$fileNameToStore = $debut_imagge_dans_storage.''.time().'.'.$extension;
				
				//  Sotcker : Storage/app/public/
				$path = $request->file($image_dans_request)->storeAs($storageLocal, $fileNameToStore);
		
			}else{
				$fileNameToStore = $image_pardefaut;
			}
				
		}
	}

	//	**************************************************	//
	//		AFFICHAGE DU STATUT DES WORKLOWS : ACTION
	//	**************************************************	//

	if(!function_exists('show_statut_worklow_action')){
		function show_statut_worklow_action($tatut_w, $statu_taction, $messageToPrint)
		{
			switch ($tatut_w) {
				case 0:
					switch ($statu_taction) {
						case 2:
							echo '<span style="color: rgb(255, 110, 25);">
											<i class="nav-icon fas fa-play fa-sm" >
											Attente validation</i>
									</span>
							';//'.$messageToPrint.'
							break;
						case 5:
							echo '<span style="color: #17a2b8"><i class="nav-icon fas fa-pause-circle fa-sm" > Suspendu: </i></span>';//'.$messageToPrint.'
							break;
						default:
							# code...
							break;
					}
					break;
				case 1:
					switch ($statu_taction) {
						case 1:
							echo '<span style="color: rgb(33, 150, 29)"><i class="nav-icon fas fa-check-circle fa-sm" > Accordé</i></span>';
							break;
						case 0:
							echo '<span style="color: rgb(209, 53, 14)"><i class="nav-icon fas fa-times-circle fa-sm" > Rejeté</i></span>';
							break;
					}
				break;

				default:
					# code...
					break;
			}
				
		}
	}

	//	**************************************************	//
	//		AFFICHAGE DU STATUT DES WORKLOWS : POP-PUP
	//	**************************************************	//

	if(!function_exists('show_statut_worklow_action_popup')){
		function show_statut_worklow_action_popup($tatut_w, $statu_taction, $messageToPrint)
		{
			switch ($tatut_w) {
				case 0:
					switch ($statu_taction) {
						case 2:
							echo '<span style="color: rgb(255, 110, 25);">
											<i class="nav-icon fas fa-play fa-sm" >
											Attente de validation du '.$messageToPrint.'</i>
									</span>
							';//'.$messageToPrint.'
							break;
						case 5:
							echo '<span style="color: #17a2b8"><i class="nav-icon fas fa-pause-circle fa-sm" >'.$messageToPrint.'</i></span>';//'.$messageToPrint.'
							break;
						
						default:
							# code...
							break;
					}
					break;
				case 1:
					switch ($statu_taction) {
						case 1:
							echo '<span style="color: rgb(33, 150, 29)"><i class="nav-icon fas fa-check-circle fa-sm" > Accordé</i></span>';
							break;
						case 0:
							echo '<span style="color: rgb(209, 53, 14)"><i class="nav-icon fas fa-times-circle fa-sm" > '.$messageToPrint.'</i></span>';
							break;
					}
				break;

				default:
					# code...
					break;
			}
				
		}
	}



	//	**************************************************	//
	//		AFFICHAGE DU STATUT DES TACHES
	//	**************************************************	//

	if(!function_exists('show_statut_taches')){
		function show_statut_taches($tatut_wl)
		{
			switch ($tatut_wl) {
				case 1:
					echo '<span style="color: rgb(33, 150, 29)"><i class="nav-icon fas fa-check-circle fa-thumbs-up fa-sm" > Accordé</i></span>';
							break;
					break;
				case 5:
					echo '<span style="color: #17a2b8"><i class="nav-icon fas fa-pause-circle fa-sm" > Suspendu</i></span>';
					break;
				case 0:
					echo '<span style="color: rgb(209, 53, 14)"><i class="nav-icon fas fa-times-circle fa-sm" > Rejeté</i></span>';
					break;
				case 2:
					echo '<span style="color: rgb(255, 110, 25)"><i class="nav-icon fas fa-cog fa-sm" > non traité</i></span>';
					break;
				default:
					# code...
					break;
			}
				
		}
	}


	//	**************************************************	//
	//		GET LISTE EMPLOYE WORKFLOW
	//	**************************************************	//

	if(!function_exists('get_list_employe_workflow')){
		function get_list_employe_workflow($code_employe)
		{
			$stringDuorkflowBD = DB::select("SELECT workflow_analyses.ordre_analyse_code_emp
				FROM `workflow_analyses` 
				WHERE workflow_analyses.code_emp = ?",[$code_employe])[0]->ordre_analyse_code_emp;
			$arrayResultat = explode("-", $stringDuorkflowBD);
			return $arrayResultat;
				
		}
	}
	//	**************************************************	//
	//		GET EMPLOYE WORKFLOW
	//	**************************************************	//

	if(!function_exists('get_employe_workflow')){
		function get_employe_workflow($code_employe)
		{
			$stringDuorkflowBD = DB::select("SELECT workflow_analyses.ordre_analyse_code_emp
				FROM `workflow_analyses` 
				WHERE workflow_analyses.code_emp = ?",[$code_employe])[0]->ordre_analyse_code_emp;
			return $stringDuorkflowBD;
				
		}
	}

	//	**************************************************	//
	//		GET EMPLOYE WORKFLOW
	//	**************************************************	//

	if(!function_exists('get_employe_workflow_encours_position')){
		function get_employe_workflow_encours_position($id_workflow_log, $position)
		{
			$stringDuorkflowBD = DB::select("SELECT workflows.parcoursw
				FROM `workflows`, workflow_logs 
				WHERE workflow_logs.workflow_id =  workflows.id AND workflow_logs.id = ?",[$id_workflow_log])[0]->parcoursw;

			$arrayResultat = explode("-", $stringDuorkflowBD);

			if($position > (COUNT($arrayResultat)-1) ){
				$resultat = $arrayResultat[$position-1];
			}else{
				$resultat = $arrayResultat[$position];
			}
			return $resultat;
				
		}
	}

	//	**************************************************	//
	//		GET POSITION ACTUELLE WORKFLOW
	//	**************************************************	//

	if(!function_exists('get_position_actuelle_workflow')){
		function get_position_actuelle_workflow($id_workflow_log)
		{
			$position = DB::select("SELECT workflows.position
				FROM `workflows`, `workflow_logs` 
				WHERE workflows.id = workflow_logs.workflow_id
					AND workflow_logs.id = ?",[$id_workflow_log])[0]->position;

			return $position;
				
		}
	}

	//	**************************************************	//
	//		GET LONGUEUR WORKFLOW
	//	**************************************************	//

	if(!function_exists('get_longueur_workflow')){
		function get_longueur_workflow($id_workflow_log)
		{
			$longeur = DB::select("SELECT workflows.longeur
				FROM `workflows`, `workflow_logs` 
				WHERE workflows.id = workflow_logs.workflow_id
					AND workflow_logs.id = ?",[$id_workflow_log])[0]->longeur;

			return $longeur;
				
		}
	}

	//	**************************************************	//
	//	 GENERER DERNIERE DEMANDE D'ABSCENCE
	//	**************************************************	//

	if(!function_exists('generer_demande_abscenceLast')){
		function generer_demande_abscenceLast($id_workflow_log)
		{
			$id_abscence = DB::select("SELECT action_id 
				FROM workflow_logs, workflows 
				WHERE workflows.id = workflow_logs.workflow_id 
					AND workflow_logs.id =?", [$id_workflow_log])[0]->action_id;
			$code_emp = DB::select("SELECT code_emp 
			FROM abscences 
			WHERE id=?", [$id_abscence])[0]->code_emp;

			$abscences = DB::select("SELECT abscences.*, employes.nom, employes.prenom, postes.libelle, departements.code as dept, services.libelle as service FROM abscences, employes, employe_postes EP1, postes, services, departements
                WHERE abscences.code_emp = employes.code AND abscences.id = ? AND employes.code = EP1.code_emp AND EP1.poste_id = postes.id AND postes.departement_code = departements.code AND services.id = postes.service_id AND EP1.debut = (SELECT MIN(EP2.debut) FROM employes E2, employe_postes EP2 WHERE EP2.code_emp = E2.code AND E2.code = EP1.code_emp)", [$id_abscence]);
                
			
			$pdfFile = pdf_employe_demande_abscence($abscences);
			

			$abscenceR = Abscence::find($id_abscence);
			Storage::delete("employes/".$code_emp.$abscenceR->fichier_demande);
			$abscenceR->fichier_demande = $pdfFile;
			$abscenceR->save();
				
		}
	}

	//	**************************************************	//
	//	 GENERER  ATTESTATION CONGES
	//	**************************************************	//

	if(!function_exists('generer_attestation_congeLast')){
		function generer_attestation_congeLast($id_workflow_log)
		{
			$id_conge = DB::select("SELECT action_id 
				FROM workflow_logs, workflows 
				WHERE workflows.id = workflow_logs.workflow_id 
					AND workflow_logs.id =?", [$id_workflow_log])[0]->action_id;
			$code_emp = DB::select("SELECT code_emp 
			FROM conges 
			WHERE id=?", [$id_conge])[0]->code_emp;

			$conges = DB::select("SELECT conges.*, DATE_SUB(conges.date_fin, INTERVAL 1 DAY) as date_fin_avant, NOW() as date_of_day, employes.nom, employes.prenom, postes.libelle as poste, departements.code as dept, services.libelle as service FROM conges, employes, employe_postes EP1, postes, services, departements
			WHERE conges.code_emp = employes.code AND conges.id = ? AND employes.code = EP1.code_emp AND EP1.poste_id = postes.id AND postes.departement_code = departements.code AND services.id = postes.service_id AND EP1.statut='actif' ", [$id_conge]);
                
			
			$pdfFile = pdf_employe_attestation_conge($conges);
			

			$congeR = Conge::find($id_conge);
			//Storage::delete("employes/".$code_emp.$congeR->fichier_demande);
			$congeR->fichier_demande = $pdfFile;
			$congeR->save();
				
		}
	}


	//	**************************************************	//
	//	 GENERER  ATTESTATION MISSIONS
	//	**************************************************	//

	if(!function_exists('generer_frais_mission')){
		function generer_frais_mission($id_workflow_log)
		{
			$id_mission = DB::select("SELECT action_id 
				FROM workflow_logs, workflows 
				WHERE workflows.id = workflow_logs.workflow_id 
					AND workflow_logs.id =?", [$id_workflow_log])[0]->action_id;
			$code_emp = DB::select("SELECT code_emp 
			FROM missions 
			WHERE id=?", [$id_mission])[0]->code_emp;

			$mission = DB::select("SELECT missions.*, NOW() as date_of_day, employes.nom, employes.prenom, postes.libelle as poste, departements.code as dept, directions.code as direct, services.libelle as service FROM missions, employes, employe_postes EP1, postes, services, departements, directions
			WHERE directions.code = departements.direction_code AND missions.code_emp = employes.code AND missions.id = ? AND employes.code = EP1.code_emp AND EP1.poste_id = postes.id AND postes.departement_code = departements.code AND services.id = postes.service_id AND EP1.statut='actif' ", [$id_mission]);
                
			$frais = DB::select("SELECT tarif_missions.* 
			FROM 
				tarif_missions, employes, employe_postes, postes 
			WHERE 
				employe_postes.code_emp = employes.code AND employe_postes.statut = 'actif' AND employe_postes.poste_id = postes.id AND tarif_missions.categorie_code = postes.categorie_code AND employes.code = ? ", [$code_emp]);
			
			$pdfFile = pdf_frais_mission($mission, $frais);
			
			$missionR = Mission::find($id_mission);
			
			$missionR->fichier_frais = $pdfFile;
			$missionR->save();
				
		}
	}

	//	**************************************************	//
	//	 GENERER  ATTESTATION MISSIONS
	//	**************************************************	//

	if(!function_exists('generer_ordre_mission')){
		function generer_ordre_mission($id_workflow_log)
		{
			$id_mission = DB::select("SELECT action_id 
				FROM workflow_logs, workflows 
				WHERE workflows.id = workflow_logs.workflow_id 
					AND workflow_logs.id =?", [$id_workflow_log])[0]->action_id;
			$code_emp = DB::select("SELECT code_emp 
			FROM missions 
			WHERE id=?", [$id_mission])[0]->code_emp;

			$mission = DB::select("SELECT missions.*, NOW() as date_of_day, employes.nom, employes.prenom, civilites.libelle as genre, postes.libelle as poste, departements.code as dept, directions.code as direct, services.libelle as service FROM missions, employes, employe_postes EP1, postes, services, departements, directions, civilites
			WHERE directions.code = departements.direction_code AND missions.code_emp = employes.code AND missions.id = ? AND employes.code = EP1.code_emp AND EP1.poste_id = postes.id AND postes.departement_code = departements.code AND services.id = postes.service_id AND EP1.statut='actif' AND civilites.id = employes.sexe", [$id_mission]);
                
			$frais = DB::select("SELECT tarif_missions.* 
			FROM 
				tarif_missions, employes, employe_postes, postes 
			WHERE 
				employe_postes.code_emp = employes.code AND employe_postes.statut = 'actif' AND employe_postes.poste_id = postes.id AND tarif_missions.categorie_code = postes.categorie_code AND employes.code = ? ", [$code_emp]);
			
			$pdfFile = pdf_ordre_mission($mission);
			
			$missionR = Mission::find($id_mission);
			
			$missionR->fichier_ordre = $pdfFile;
			$missionR->save();
				
		}
	}


	//	**************************************************	//
	//		GET ET PRINT NOTIFICATION
	//	**************************************************	//

	if(!function_exists('get_and_print_nbr_notification')){
		function get_and_print_nbr_notification()
		{
			$TacheTraiter = DB::select("SELECT COUNT(workflow_logs.id) as tache FROM workflow_logs WHERE workflow_logs.decision = 2 AND workflow_logs.code_emp_respo = ?",[session()->get('user')->code_user] )[0]->tache;
			if($TacheTraiter > 0 ){
				echo $TacheTraiter;
			}
				
		}
	}
	//	**************************************************	//
	//		GET ET PRINT NOTIFICATION MESSAGE
	//	**************************************************	//

	if(!function_exists('get_and_print_nbr_message')){
		function get_and_print_nbr_message()
		{
			$MessageTraiter = DB::select("SELECT COUNT(messages.id) as message FROM messages WHERE emp_getter = ? AND lecture = 0",[session()->get('user')->code_user] )[0]->message;
			if($MessageTraiter > 0 ){
				echo $MessageTraiter;
			}
				
		}
	}
	

	//	**************************************************	//
	//		CHECK LA DISPONIBILITE DES ACTION DURANT LA PERIEODE
	//	**************************************************	//

	if(!function_exists('check_disponibilite_action')){
		function check_disponibilite_action($code_emp, $date_debut)
		{
			$checker = 0;

			//	CONGES
			$co = DB::select("SELECT COUNT(id) as nbr FROM conges WHERE date_debut <= ? AND date_fin >= ? AND statut > 0 AND code_emp = ?", [$date_debut, $date_debut, $code_emp])[0]->nbr;
			//	ABSCENCE
			$ab = DB::select("SELECT COUNT(id) as nbr FROM abscences WHERE date_depart <= ? AND date_reprise >= ? AND statut > 0 AND code_emp = ?", [$date_debut, $date_debut, $code_emp])[0]->nbr;
			//	MISSIONS
			$mi = DB::select("SELECT COUNT(id) as nbr FROM missions WHERE date_debut <= ? AND date_retour >= ?  AND statut > 0 AND code_emp = ?", [$date_debut, $date_debut, $code_emp])[0]->nbr;

			$checker = $co + $ab + $mi;

			return $checker;	
		}
	}

	//	**************************************************	//
	//		PRINT IMAGE EMPLOYE
	//	**************************************************	//

	if(!function_exists('print_image_emp')){
		function print_image_emp($code_emp, $image)
		{
			$val = "";
			if ($image == "no-user.jpg" || $image == null || $image =='') {
				$val =  '/storage/users/images/no-user.jpg';
			} else {
				$val =  '/storage/employes/'.$code_emp.'/'.$image;
			}

			return $val;
			
		}
	}


	//	**************************************************	//
	//		GET DATE NOW FROM BD
	//	**************************************************	//

	if(!function_exists('get_date_from_now_to_DB')){
		function get_date_from_now_to_DB()
		{
			date_default_timezone_set("Africa/Libreville");
			$date = date("Y-m-d H:i:s");
			return $date;
		}
	}
	
	

?>