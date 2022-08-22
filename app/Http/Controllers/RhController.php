<?php

namespace App\Http\Controllers;

use App\Models\Abscence;
use App\Models\Civilite;
use App\Models\Conge;
use App\Models\Contrat_type;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\Employe;
use App\Models\Employe_enfants;
use App\Models\Employe_poste;
use App\Models\Etat_matrimonial;
use App\Models\Groupe;
use App\Models\Logement_societe;
use App\Models\Permis_conduire;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use setasign\Fpdi\Fpdi;

class RhController extends Controller
{

/******************************************************************************************* */
/******************************************************************************************* */
    

//  Go to EMPLOYES
    public function employes(){
        if(check_session() =='no')
            return redirect('/'); 

        //$employes = Employe::all();
        //$affectation = DB::select();
        $employes =DB::select("SELECT employes.*, departements.code as libelle_dept, directions.code as libelle_direct, postes.libelle as libelle_post FROM `employes`,departements,services,postes, directions, employe_postes WHERE employes.code = employe_postes.code_emp AND employe_postes.poste_id=postes.id AND departements.code=postes.departement_code AND services.id=postes.service_id AND employe_postes.statut='actif' AND directions.code = departements.direction_code");

        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts.employes")
            ->with('employes', $employes);
    }

/******************************************************************************************* */
/******************************************************************************************* */
    

//  GET Services of DEPARTEMMENTS
    public function get_sevices_of_departement(Request $request){
        
        $services = DB::select('SELECT services.libelle,id FROM services,departements WHERE departement_code=code AND code=?',[$request->code]);
        
        //echo $sexes['libelle'];
        //return view("layouts.employes_add")->with('sexes',$sexes);
        return $services;
    }
/******************************************************************************************* */
/******************************************************************************************* */
    

//  GET POSTES of SERVICES
    public function get_poste_of_services(Request $request){
        
        $postes = DB::select('SELECT postes.libelle,postes.id FROM services,postes WHERE service_id=services.id AND services.id=?',[$request->id]);
        return $postes;
    }
/******************************************************************************************* */
/******************************************************************************************* */
    

// GET POSTE OF DIRECTION 
    public function get_postes_of_direction(Request $request){
            
        $postes = DB::select('SELECT postes.libelle,postes.id FROM directions,postes WHERE directions.code=postes.direction_code AND directions.code=?',[$request->code]);
        return $postes;
    }
/******************************************************************************************* */
/******************************************************************************************* */
    

//  Go to ADD EMPLOYES
    public function employes_add(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        
        //$etat_matrimonials = DB::table('etat_matrimonials')->pluck('libelle','id');
        $etat_matrimonials = Etat_matrimonial::all('libelle','id');
        //dd ($etat_matrimonials);
        $sexes = Civilite::all('libelle','id');
        $permiss = Permis_conduire::all('type','id');
        $contrats = Contrat_type::all('type','id');
        $departements = Departement::all('libelle','code');
        $directions = Direction::all('libelle', 'code');
        $logements = Logement_societe::all('adresse','id');

        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check("layouts.employes_add", 'add')
            ->with('etat_matrimonials',$etat_matrimonials)
            ->with('sexes',$sexes)
            ->with('permiss',$permiss)
            ->with('contrats',$contrats)
            ->with('departements',$departements)
            ->with('directions',$directions)
            ->with('logements',$logements);
    }
/******************************************************************************************* */
/******************************************************************************************* */
    

//  Go to SAVE EMPLOYES
    public function employes_save_add(Request $request){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $code_emloyeA = DB::select('SELECT COUNT(*) as nbr FROM employes');
        $code_emloye = 'STR_'.($code_emloyeA[0]->nbr+1);

        $_email = DB::select('SELECT COUNT(*) as nbr FROM employes WHERE email=?', [$request->email]);
        if($_email[0]->nbr > 0){
            session()->put('error',custom_error('E004'));
            return redirect("/rh/employes/add");
        }

        /*  LES FICHIERS    */
        //trim($str, "Hir")
        $libelle_piece = str_replace(' ', '', DB::select("SELECT libelle FROM document_employe_types WHERE id = ?", [$request->piece_id])[0]->libelle);
        //  Pièce d'identité
        $piece_file = $request->piece_file;
        $piece_file = get_file_name_to_store($request,'piece_file', env('DOSSIER_EMPLOYES').$code_emloye,$libelle_piece.'-'.$code_emloye,'AUCUN' );
        //  CV
        $cv = $request->cv;
        $cv = get_file_name_to_store($request,'cv', env('DOSSIER_EMPLOYES').$code_emloye,'CURRICULUMVITAE-'.$code_emloye,'AUCUN' );
        //  CONTRAT
        $contrat_emp = $request->contrat_emp;
        $contrat_emp = get_file_name_to_store($request,'contrat_emp', env('DOSSIER_EMPLOYES').$code_emloye,$request->type_contrat.'-'.$code_emloye.'-'.$request->date_embauche,'AUCUN' );
        //  PHOTO
        $photo = $request->photo;
        $photo = get_file_name_to_store($request,'photo', env('DOSSIER_EMPLOYES').$code_emloye,'PHOTO-'.$code_emloye,'no-user.jpg' );


        /*  LES INSERTS          */ 

        try {
            $employe = DB::statement("INSERT INTO `employes` (`code`, `nom`, `prenom`, `sexe`, `date_naiss`, `adresse`, `image`, `nationalite`, `email`, `telephone1`, `telephone2`, `telephone_travail`, `etat_matrimonial`, `enfant`, `numero_identite`, `numero_cnss`, `numero_cnamgs`, `numero_nif`, `logement_societe`, `etat_activite`, `motif_depart`, `salaire`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 'actif', ?, ?, NOW(), NOW() )",
            [$code_emloye, $request->nom, $request->prenom, $request->sexe, $request->date_naiss, $request->adresse, $photo, $request->nationalite, $request->email, $request->telephone1, $request->telephone2, $request->flotte, $request->etat_matrimonial, $request->nbr_enfant, $request->piece_id, $request->cnss, $request->cnamgs, $request->nif, NULL, $request->salaire]);
        } catch(\Exception $e){
            session()->put('error',custom_error('E005'));
            return redirect("/rh/employes/add");
        }
        

        /*  LES FK          */
        //  PEMIS
        if ($request->permis == 'OUI' && !empty($request->perm)) {
            foreach($request->perm as $permisT){
                try {
                    $employe_permis = DB::statement("INSERT INTO `employe_permis` ( `code_emp`, `permis_type`, `created_at`, `updated_at`) VALUES (?, ?, NOW(), NOW())",
                    [$code_emloye, $permisT]);
                } catch(\Exception $e){
                    session()->put('error',custom_error('E008'));
                    return redirect("/rh/employes/add");
                }
            }
        }  

        // DOCUMENTS
        try {
            $documentPiece = DB::statement("INSERT INTO `document_employes` (`code_emp`, `type_id`, `fichier`, `created_at`, `updated_at`) VALUES (?, ?, ?,NOW(), NOW())", [$code_emloye, intval($request->piece_id), $piece_file]);

            
            $documentCV = DB::table('document_employe_types')->where('libelle','Curriculum Vitae')->first();
            $saveCV = DB::statement("INSERT INTO `document_employes` (`code_emp`, `type_id`, `fichier`, `created_at`, `updated_at`) VALUES (?, ?, ?,NOW(), NOW())", [$code_emloye, $documentCV->id, $cv]);

            $documentContrat = DB::table('contrat_types')->where('type',$request->type_contrat)->first();
            $saveContrat = DB::insert("INSERT INTO `contrat_employes` (`code_emp`, `type_id`, `fichier`, `date`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, NOW(), NOW())", [$code_emloye, $documentContrat->id, $contrat_emp, $request->date_embauche]);


        } catch(\Exception $e){
            session()->put('error',custom_error('E006'));
            return redirect("/rh/employes/add");
        }

        //  POSTES
        try {
            /*$dept_service = DB::select("SELECT postes.departement_code, postes.service_id FROM `postes` WHERE id=?",([$request->sel_poste ]))*/

            $poste = DB::statement("INSERT INTO `employe_postes` (`code_emp`, `poste_id`, `debut`, `statut`, `created_at`, `updated_at`) VALUES ( ?, ?, ?, 'actif', NOW(), NOW())", [$code_emloye,$request->sel_poste , $request->date_embauche]);

        } catch(\Exception $e){
            session()->put('error',custom_error('E007'));
            return redirect("/rh/employes/add");
        }

        //  URGENCES
        try {
            $urgences = DB::statement("INSERT INTO `urgence_employes` (`code_emp`, `nom`, `lien`, `telephone1`, `telephone2`, `adresse`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())", [$code_emloye,$request->urgence_nom , $request->urgence_lien, $request->urgence_number1, $request->urgence_number2, $request->urgence_adresse]);
        } catch(\Exception $e){
            session()->put('error',$e->getMessage());
            return redirect("/rh/employes/add");
        }
       
        //$documentContrat = DB::table('contrat_types')->where('type',$request->type_contrat)->first();
        //printf($request->sel_poste);
        //dd($documentContrat);
        afficherSuccess(custom_success(999));
        return redirect("/rh/employes");
        
    }
    
/******************************************************************************************* */
/******************************************************************************************* */
    

//  Go to Show Detail Employe
    public function employes_show($val){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 

        $employes = DB::select("SELECT employes.*, departements.code as libelle_dept, postes.libelle as libelle_post, etat_matrimonials.libelle as etat_matrimonial, document_employes.fichier as cv, civilites.libelle as genre, logement_societes.adresse as logementL, 

        (SELECT document_employes.fichier FROM document_employes, employes WHERE document_employes.type_id = employes.numero_identite AND document_employes.code_emp = employes.code AND  employes.code = ? ) as piece, 
        
        (SELECT contrat_employes.fichier FROM contrat_employes, employes WHERE contrat_employes.code_emp = employes.code AND contrat_employes.date = (SELECT MAX(contrat_employes.date) from contrat_employes, employes WHERE contrat_employes.code_emp = employes.code AND employes.code = ? ) ) as contrat, 
        
        (SELECT contrat_types.type  FROM contrat_employes, employes, contrat_types WHERE contrat_employes.code_emp = employes.code AND contrat_types.id = contrat_employes.type_id AND contrat_employes.date = (SELECT MAX(contrat_employes.date) from contrat_employes, employes WHERE contrat_employes.code_emp = employes.code AND employes.code = ?) ) as type_contrat,
        
        ( SELECT MIN(employe_postes.debut) from employe_postes, employes WHERE employe_postes.code_emp = employes.code AND employes.code = ?) as date_debut,

        ( SELECT MAX(employe_postes.fin) from employe_postes, employes WHERE employe_postes.code_emp = employes.code AND employes.code = ? AND (SELECT COUNT(epc.id) FROM employe_postes epc WHERE epc.statut='fin' AND epc.code_emp= employe_postes.code_emp)<1 ) as date_depart,

        (SELECT DATE_FORMAT( FROM_DAYS( DATEDIFF(CURRENT_DATE, (SELECT MIN(employe_postes.debut) from employe_postes, employes WHERE employe_postes.code_emp = employes.code AND employes.code = ?)) ), '%y an(s) et %m mois' )) AS anciennete
        
                FROM `employes`,departements,services,postes,employe_postes,etat_matrimonials, document_employes, document_employe_types, civilites, logement_societes
                
                WHERE logement_societes.id = employes.logement_societe AND employes.code = employe_postes.code_emp AND employe_postes.poste_id=postes.id AND departements.code=services.departement_code AND services.id=postes.service_id AND etat_matrimonials.id = employes.etat_matrimonial AND document_employes.code_emp = employes.code AND document_employes.type_id = document_employe_types.id AND document_employe_types.libelle='Curriculum Vitae' AND employe_postes.statut='actif' AND employes.sexe = civilites.id AND  employes.code=?", [$val, $val, $val, $val, $val, $val, $val]);

        $employePoste = DB::select("SELECT postes.libelle as poste, departements.libelle as departement, departements.code as code_dep, services.libelle as service, directions.libelle as direction FROM `employe_postes`, employes, postes, departements, services, directions

        WHERE employe_postes.code_emp = employes.code AND employes.code =? AND employe_postes.poste_id = postes.id AND employe_postes.statut='actif'  AND departements.code = postes.departement_code AND services.id = postes.service_id AND directions.code = postes.direction_code ",[$val]);

        $permiss = DB::select("SELECT permis_conduires.type FROM permis_conduires, employe_permis WHERE employe_permis.code_emp = ?  AND permis_conduires.id = employe_permis.permis_type", [$val]);

        /*$anciennete = DB::select("SELECT 
        DATE_FORMAT(
            FROM_DAYS(
                DATEDIFF(CURRENT_DATE, 
                             (SELECT MIN(employe_postes.debut) from employe_postes, employes WHERE employe_postes.code_emp = employes.code AND employes.code = 'EMP_1'))
            ),
            '%y année(s) %m Mois %d jours'
        ) AS ancienneté");*/
        
        //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts.employe_show_generalite")->with('employes', $employes)->with('employePoste', $employePoste)->with('permiss', $permiss);
        //dd($employes);
    }

            
/******************************************************************************************* */
/******************************************************************************************* */
    

    //  Go to Show Carrière Employe
    public function employes_show_carriere($val){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 

        $directions = Direction::all('libelle', 'code');

        $employes = DB::select("SELECT * FROM employes WHERE employes.code=?", [$val]);

        $employePoste = DB::select("SELECT postes.libelle as poste, departements.libelle as departement, departements.code as code_dep, services.libelle as service, directions.libelle as direction, employe_postes.debut FROM `employe_postes`, employes, postes, departements, services, directions

        WHERE employe_postes.code_emp = employes.code AND employes.code =? AND employe_postes.poste_id = postes.id AND employe_postes.statut='actif'  AND departements.code = postes.departement_code AND services.id = postes.service_id AND directions.code = postes.direction_code ",[$val]);

        $affectations = DB::select("SELECT employe_postes.debut, postes.libelle as poste, employe_postes.fin, contrat_employes.fichier, postes.libelle
        FROM employe_postes, contrat_employes, postes 
        WHERE employe_postes.code_emp =? AND contrat_employes.code_emp = employe_postes.code_emp AND contrat_employes.date = employe_postes.debut AND postes.id = employe_postes.poste_id",[$val]);


        $contrats = Contrat_type::all('type','id');
        //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts.employe_show_carriere")->with('employes', $employes)->with('employePoste', $employePoste)->with('directions', $directions)->with('affectations', $affectations)->with('contrats', $contrats);
        //dd($employes);
    }

/******************************************************************************************* */
/******************************************************************************************* */
    

    //  Go TO Save Affectation
    function save_affectation(Request $request){
        //$request->type_contrat

        $code_emloye = $request->employe;
        //  
        try {
            $nbr = DB::select("SELECT COUNT(id)+1 as ct FROM employe_postes WHERE employe_postes.code_emp=?", [$code_emloye])[0]->ct;
            $documentContrat = DB::table('contrat_types')->where('type',$request->type_contrat)->first();

            //  CONTRAT
            $contrat_emp = $request->contrat_emp;
            $contrat_emp = get_file_name_to_store($request,'contrat_emp', env('DOSSIER_EMPLOYES').$code_emloye, $request->type_contrat.'-'.$code_emloye.'-'.$nbr,'AUCUN' );

            //  DESACTIVE LES AUTRES
            $desactive = DB::update("UPDATE employe_postes SET statut = 'fin', fin=NOW() WHERE code_emp = ? AND statut = 'actif'",[$code_emloye]);
            //  SAVE
            $employePoste = new Employe_poste();
            $employePoste->code_emp = $code_emloye;
            $employePoste->debut = $request->date_affect;
            $employePoste->poste_id = $request->sel_poste;
            $employePoste->statut = "actif";
            $employePoste->save();

            $saveContrat = DB::insert("INSERT INTO `contrat_employes` (`code_emp`, `type_id`, `fichier`, `date`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, NOW(), NOW())", [$code_emloye, $documentContrat->id, $contrat_emp, $request->date_affect]);

        } catch(\Exception $e){
            session()->put('error',$e->getMessage());
            return redirect("/rh/employes/".$code_emloye."/carriere");
        }
   

        afficherSuccess(custom_success(999));
        return redirect("/rh/employes/".$code_emloye."/carriere");
    }

/******************************************************************************************* */
/******************************************************************************************* */
    


    //  Go to Show Salaire Employe
    public function employes_show_salaire($val){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 

        $directions = Direction::all('libelle', 'code');

        $employes = DB::select("SELECT * FROM employes WHERE employes.code=?", [$val]);

        $employePoste = DB::select("SELECT postes.libelle as poste, departements.libelle as departement, departements.code as code_dep, services.libelle as service, directions.libelle as direction, employe_postes.debut FROM `employe_postes`, employes, postes, departements, services, directions

        WHERE employe_postes.code_emp = employes.code AND employes.code =? AND employe_postes.poste_id = postes.id AND employe_postes.statut='actif'  AND departements.code = postes.departement_code AND services.id = postes.service_id AND directions.code = postes.direction_code ",[$val]);

        $affectations = DB::select("SELECT employe_postes.debut, postes.libelle as poste, employe_postes.fin, contrat_employes.fichier, postes.libelle
        FROM employe_postes, contrat_employes, postes 
        WHERE employe_postes.code_emp =? AND contrat_employes.code_emp = employe_postes.code_emp AND contrat_employes.date = employe_postes.debut AND postes.id = employe_postes.poste_id",[$val]);

        //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts.employe_show_salaire")->with('employes', $employes)->with('employePoste', $employePoste)->with('directions', $directions)->with('affectations', $affectations);
        //dd($employes);
    }

/******************************************************************************************* */
/******************************************************************************************* */
    

    //  Go to Show Congés Employe
    public function employes_show_conge($val){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 

        $directions = Direction::all('libelle', 'code');

        $employes = DB::select("SELECT employes.*,employe_postes.debut FROM employes, employe_postes WHERE employes.code=? AND employe_postes.debut = (SELECT MIN(employe_postes.debut) from employe_postes, employes WHERE employe_postes.code_emp = employes.code AND employes.code =? )", [$val, $val]);

        $conges = DB::select("SELECT C1.*, IFNULL( TOTAL_DAYS_NO_WEEK(C1.date_fin, C1.date_debut) , 0) AS nbrJ FROM conges C1 WHERE C1.code_emp =? ", [$val]);

        $congeAcquisEnCours = DB::select("SELECT `CalculConges`(?) AS `congeAcquisEnCours`;", [$val]);
        $nbrJoursCongeMere2 = DB::select("SELECT `nbrJoursCongeMere2`(?) AS `nbrJoursCongeMere2`;", [$val]);
        $nbrJoursCongeDejaPris = DB::select("SELECT `nbrJoursCongeDejaPris`(?) AS `nbrJoursCongeDejaPris`;", [$val]);
        $nbrJoursCongeAcquisDepuisFonction = DB::select("SELECT `nbrJoursCongeAcquisDepuisFonction`(?) AS `nbrJoursCongeAcquisDepuisFonction`;", [$val]);
        $nbrJoursCongeAnciennete = DB::select("SELECT `nbrJoursCongeAnciennete`(?) AS `nbrJoursCongeAnciennete`;", [$val]);
        $nbrJoursCongeAnneeEnCours = DB::select("SELECT `nbrJoursCongeAnneeEnCours`(?) AS `nbrJoursCongeAnneeEnCours`;", [$val]);

        //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts.employe_show_conge")
        ->with('employes', $employes)
        ->with('congeAcquisEnCours', $congeAcquisEnCours)
        ->with('nbrJoursCongeMere2', $nbrJoursCongeMere2)
        ->with('nbrJoursCongeDejaPris', $nbrJoursCongeDejaPris)
        ->with('nbrJoursCongeAcquisDepuisFonction', $nbrJoursCongeAcquisDepuisFonction)
        ->with('nbrJoursCongeAnciennete', $nbrJoursCongeAnciennete)
        ->with('nbrJoursCongeAnneeEnCours', $nbrJoursCongeAnneeEnCours)
        ->with('conges', $conges);
        //dd($employes);
    }

/******************************************************************************************* */
/******************************************************************************************* */

    //  SAVE OLD CONGE    
    public function save_add_old_conge(Request $request){
        if(check_session() =='no')
            return redirect('/'); 

        
        $code_emloye = $request->employe;

        /*   CHECK ELLIGIBILITE   */
        $congeAcquisEnCours = DB::select("SELECT `CalculConges`(?) AS `congeAcquisEnCours`;", [$code_emloye])[0];
        $nbrJ_demande = DB::select("SELECT TOTAL_DAYS_NO_WEEK(?, ?) AS nbrJpris",[ $request->date_fin_conge, $request->date_debut_conge])[0];
        
        if($congeAcquisEnCours->congeAcquisEnCours < $nbrJ_demande->nbrJpris){
            session()->put('warning',custom_warning('W004'));
            return redirect('/rh/employes/'.$code_emloye.'/conge');
        }

        /*  CODE DATE DU DEBUT CONGE    */
        $date = str_replace(' ', '', $request->date_debut_conge);
        $date = str_replace(':', '',$date);
        $date = str_replace('-', '',$date);
        /*  LES FICHIERS    */

        if(isset($request->justificatif)){
            //  Pièce d'identité
            $justificatif = $request->justificatif;
            $justificatif = get_file_name_to_store($request,'justificatif', env('DOSSIER_EMPLOYES').$code_emloye,'congeJ-'.$code_emloye.'-'.$date,'' );
        }else{
            $justificatif = "";
        }

        if(isset($request->autorisation_conge)){
            //  Pièce d'identité
            $autorisation_conge = $request->autorisation_conge;
            $autorisation_conge = get_file_name_to_store($request,'autorisation_conge', env('DOSSIER_EMPLOYES').$code_emloye,'congeA-'.$code_emloye.'-'.$date,'' );
        }else{
            $autorisation_conge = "";
        }

        try {
            $conge = new Conge();
            $conge->code_emp = $code_emloye;
            $conge->date_debut = $request->date_debut_conge;
            $conge->date_fin = $request->date_fin_conge;
            $conge->motif = $request->motif;
            $conge->fichier_justification = $justificatif;
            $conge->statut = 1;
            $conge->fichier_demande = $autorisation_conge;
            $conge->save();

        }  catch (\Exception $e) {
            session()->put('error',custom_error('E013'));
            return redirect('/rh/employes/'.$code_emloye.'/conge');
        }

        reresh_perssion(session()->get('user'), request()->url());
        afficherSuccess(custom_success(999));
        return redirect('/rh/employes/'.$code_emloye.'/conge');
    }



/******************************************************************************************* */
/******************************************************************************************* */
    

    //  Go to Show Abscences Employe
    public function employes_show_abscence($val){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 

        $directions = Direction::all('libelle', 'code');

        $employes = DB::select("SELECT * FROM employes WHERE employes.code=?", [$val]);

        $abscences =DB::select("SELECT abscences.*, workflows.commentaire, workflows.date_attrib, workflows.statut_w FROM abscences, workflows, workflow_types WHERE workflows.action_id = abscences.id AND abscences.code_emp = ? AND workflows.type_id = workflow_types.id AND workflow_types.libelle = 'abscences'", [$val]);

        //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts.employe_show_abscence")->with('employes', $employes)->with('abscences', $abscences)->with('directions', $directions);
        //dd($employes);
    }

/******************************************************************************************* */
/******************************************************************************************* */
    

    //  Go to Show Mission Employe
    public function employes_show_mission($val){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 


        $employes = DB::select("SELECT * FROM employes WHERE employes.code=?", [$val]);

        $missions = DB::select("SELECT missions.* FROM missions WHERE code_emp = ? ",[$val]);

        $affectations = DB::select("SELECT employe_postes.debut, postes.libelle as poste, employe_postes.fin, contrat_employes.fichier, postes.libelle
        FROM employe_postes, contrat_employes, postes 
        WHERE employe_postes.code_emp =? AND contrat_employes.code_emp = employe_postes.code_emp AND contrat_employes.date = employe_postes.debut AND postes.id = employe_postes.poste_id",[$val]);

        //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts.employe_show_mission")->with('employes', $employes)->with('missions', $missions);
        //dd($employes);
    }


    /******************************************************************************************* */
    /******************************************************************************************* */
        
    
        //  Go to Show ENFANTS Employe
        public function employes_show_enfant($val){
    
            //  SEND 
            if(check_session() =='no'){
                return redirect('/');
            } 
    
            $enfants = Employe_enfants::all()->where('code_emp',$val);
    
            $employes = DB::select("SELECT * FROM employes WHERE employes.code=?", [$val]);
            //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);
            reresh_perssion(session()->get('user'), request()->url());
            return return_view_after_check_read("layouts.employe_show_enfant")->with('employes', $employes)->with('enfants', $enfants);
            //dd($employes);
        }
    
        //  Save Employe Enfants
        public function save_enfant(Request $request){
    
            //  SEND 
            if(check_session() =='no'){
                return redirect('/');
            } 
    
            try {
                $enfants = new Employe_enfants();
                $enfants->nom = $request->nom;
                $enfants->prenom = $request->prenom;
                $enfants->date_naissance = $request->date_naiss;
                $enfants->scolarite = $request->scolarite;
                $enfants->nom_conjoint = $request->nom_conjoint;
                $enfants->profession_conjoint = $request->profession_conjoint;
                $enfants->telephone = $request->telephone_conjoint;
                $enfants->code_emp = $request->employe;
                $enfants->save();
            } catch(\Exception $e){
                session()->put('error',custom_error('E010'));
                return redirect('/rh/employes/'.$request->employe.'/enfant');
            }
            
            afficherSuccess(custom_success(999));
            return redirect('/rh/employes/'.$request->employe.'/enfant');
            //dd($employes);
        }
    
        //  Save Edit Employe Enfants
        public function save_edit_enfant(Request $request){
    
            //  SEND 
            if(check_session() =='no'){
                return redirect('/');
            } 
    
            try {
                $enfants = Employe_enfants::find($request->id_enfant);
                $enfants->nom = $request->nom_edit;
                $enfants->prenom = $request->prenom_edit;
                $enfants->date_naissance = $request->date_naiss_edit;
                $enfants->scolarite = $request->scolarite_edit;
                $enfants->nom_conjoint = $request->nom_conjoint_edit;
                $enfants->profession_conjoint = $request->profession_conjoint_edit;
                $enfants->telephone = $request->telephone_conjoint_edit;
                $enfants->code_emp = $request->employe;
                $enfants->save();
            } catch(\Exception $e){
                session()->put('error',custom_error('E011'));
                return redirect('/rh/employes/'.$request->employe.'/enfant');
            }
            
            afficherSuccess(custom_success(999));
            return redirect('/rh/employes/'.$request->employe.'/enfant');
            //dd($employes);
        }



/******************************************************************************************* */
/******************************************************************************************* */
    

    //  Go to Show DOCUMENTS Employe
    public function employes_show_document($val){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 

        $employes = DB::select("SELECT * FROM employes WHERE employes.code=?", [$val]);
        
        $documents = DB::select("SELECT * FROM document_employe_types");

        $sesdocuments = DB::select("SELECT document_employes.type_id, document_employes.code_emp, document_employes.fichier, document_employe_types.libelle, document_employes.created_at, document_employes.updated_at  FROM document_employes, document_employe_types WHERE document_employes.type_id = document_employe_types.id AND document_employes.code_emp=? ORDER BY document_employes.updated_at DESC, document_employe_types.libelle ASC", [$val]);
        //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts.employe_show_document")->with('employes', $employes)->with('documents', $documents)->with('sesdocuments', $sesdocuments);
        //dd($employes);
    }


    //  Save Employe Enfants
    public function save_add_documents(Request $request){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 

        $libelle_document = str_replace(' ', '', DB::select("SELECT libelle FROM document_employe_types WHERE id = ?", [$request->document_type])[0]->libelle);

        $check1 = DB::select("SELECT count(code_emp) as nbr FROM document_employes WHERE code_emp = ? AND type_id = ?", [$request->employe, $request->document_type])[0]->nbr;
        if($check1 > 0){
            session()->put('warning',custom_warning('W048'));
            return redirect("/rh/employes/".$request->employe."/document");
        }
        
        //  Pièce d'identité
        $document_file = $request->document_file;
        $document_file = get_file_name_to_store($request,'document_file', env('DOSSIER_EMPLOYES').$request->employe, $libelle_document.'-'.$request->employe,'' );

        $document  = DB::insert("INSERT INTO document_employes VALUES(?, ?, ?, NOW(), NOW())", [$request->employe, $request->document_type, $document_file ]);
        
        afficherSuccess(custom_success(999));
        return redirect('/rh/employes/'.$request->employe.'/document');
        //dd($employes);
    }

    //  Save DELETE Employe DOCUMENTS
    public function save_delete_documents(Request $request){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 

        try {
            $fichier = DB::select("SELECT fichier FROM document_employes WHERE type_id = ? AND code_emp = ?", [$request->idModal, $request->employe])[0]->fichier;
            $document = DB::delete("DELETE FROM document_employes WHERE type_id = ? AND code_emp = ?", [$request->idModal, $request->employe]);
            if(\Illuminate\Support\Facades\Storage::exists(env('DOSSIER_EMPLOYES').$request->employe."/".$fichier)){
                \Illuminate\Support\Facades\Storage::delete(env('DOSSIER_EMPLOYES').$request->employe."/".$fichier);
              }

        } catch(\Exception $e){
            session()->put('error',custom_error('E024'));
            return redirect('/rh/employes/'.$request->employe.'/document');
        }
        
        afficherSuccess(custom_success(999));
        return redirect('/rh/employes/'.$request->employe.'/document');
        //dd($employes);
    }

    //  Save Edit Employe Enfants
    public function save_edit_documents(Request $request){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 

        $libelle_document = DB::select("SELECT fichier FROM document_employes WHERE type_id = ? AND code_emp = ?", [$request->id_edit, $request->employe])[0]->fichier;
        try {
            $document_file = get_file_name_to_store_With_Extension_inName($request,'document_file', env('DOSSIER_EMPLOYES').$request->employe, $libelle_document,'' );            
            /*if(\Illuminate\Support\Facades\Storage::exists(env('DOSSIER_EMPLOYES').$request->employe."/".$fichier)){
                \Illuminate\Support\Facades\Storage::delete(env('DOSSIER_EMPLOYES').$request->employe."/".$fichier);
            }*/

        } catch(\Exception $e){
            session()->put('error',custom_error('E024'));
            return redirect('/rh/employes/'.$request->employe.'/document');
        }
        
        afficherSuccess(custom_success(999));
        return redirect('/rh/employes/'.$request->employe.'/document');
        //dd($employes);
    }



/******************************************************************************************* */
/******************************************************************************************* */
    
//  GO TO Abscences    
public function abscence_conge(){
    if(check_session() =='no')
        return redirect('/');
    
    $abscences = DB::select("SELECT abscences.*, workflows.commentaire, workflows.commentairem, workflows.date_attrib, workflows.statut_w, employes.nom, employes.prenom, postes.libelle as poste, directions.code as direction, departements.libelle as departements, services.libelle as service
    FROM abscences, workflows, workflow_types, employes, postes, directions, departements, employe_postes, services
    WHERE workflows.action_id = abscences.id 
        AND employes.code = abscences.code_emp
        AND workflows.type_id = workflow_types.id 
        AND workflow_types.libelle = 'abscences'
        AND employe_postes.code_emp = abscences.code_emp
        AND employe_postes.statut='actif' 
        AND employe_postes.poste_id = postes.id
        AND postes.direction_code = directions.code
        AND postes.departement_code = departements.code
        AND postes.service_id = services.id");

    reresh_perssion(session()->get('user'), request()->url());
    return return_view_after_check_read("layouts.employe_abscence")->with('abscences', $abscences);
    //return view("layouts.configuration");
    //dd(session()->get('permission'));
}

/******************************************************************************************* */
/******************************************************************************************* */
    
//  GO TO CONGES    
    public function conge_abscence(){
        if(check_session() =='no')
            return redirect('/'); 

        $conges = DB::select("SELECT conges.*, workflows.commentaire, workflows.commentairem, workflows.date_attrib, workflows.statut_w, employes.nom, employes.prenom, postes.libelle as poste, directions.code as direction, departements.libelle as departements, services.libelle as service
        FROM conges, workflows, workflow_types, employes, postes, directions, departements, employe_postes, services
        WHERE workflows.action_id = conges.id 
            AND employes.code = conges.code_emp
            AND workflows.type_id = workflow_types.id 
            AND workflow_types.libelle = 'conges'
            AND employe_postes.code_emp = conges.code_emp
            AND employe_postes.statut='actif' 
            AND employe_postes.poste_id = postes.id
            AND postes.direction_code = directions.code
            AND postes.departement_code = departements.code
            AND postes.service_id = services.id");
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts.employe_conge")->with('conges', $conges);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }


/******************************************************************************************* */
/******************************************************************************************* */
    
//  GO TO MISSIONS    
    public function missions(){
        if(check_session() =='no')
            return redirect('/'); 

        $missions = DB::select("SELECT missions.*, workflows.commentaire, workflows.commentairem, workflows.date_attrib, workflows.statut_w, employes.nom, employes.prenom, postes.libelle as poste, directions.code as direction, departements.libelle as departements, services.libelle as service
        FROM missions, workflows, workflow_types, employes, postes, directions, departements, employe_postes, services
        WHERE workflows.action_id = missions.id 
            AND employes.code = missions.code_emp
            AND workflows.type_id = workflow_types.id 
            AND workflow_types.libelle = 'missions'
            AND employe_postes.code_emp = missions.code_emp
            AND employe_postes.statut='actif' 
            AND employe_postes.poste_id = postes.id
            AND postes.direction_code = directions.code
            AND postes.departement_code = departements.code
            AND postes.service_id = services.id");

        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts.employe_mission")->with('missions', $missions);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }



/******************************************************************************************* */
/******************************************************************************************* */
    
    public function generer_emp_demande_abscence($val){

        $abscences = DB::select("SELECT abscences.*, employes.nom, employes.prenom, postes.libelle, departements.code as dept, services.libelle as service FROM abscences, employes, employe_postes EP1, postes, services, departements
        WHERE abscences.code_emp = employes.code AND abscences.id = ? AND employes.code = EP1.code_emp AND EP1.poste_id = postes.id AND postes.departement_code = departements.code AND services.id = postes.service_id AND EP1.debut = (SELECT MIN(EP2.debut) FROM employes E2, employe_postes EP2 WHERE EP2.code_emp = E2.code AND E2.code = EP1.code_emp)", [$val]);

        $pdfFile = pdf_employe_demande_abscence($abscences);
        print($pdfFile);
    }

}
