<?php

namespace App\Http\Controllers;

use App\Models\Abscence;
use App\Models\Conge;
use App\Models\Mission;
use App\Models\Direction;
use App\Models\Employe;
use App\Models\Employe_enfants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class EmpController extends Controller
{
    
    //  Go to Show Detail Employe
    public function employes_show(){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 
        $val = (session()->get('user'))->code_user;

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

        //dd($employes);
        if(empty($employes)){
            session()->put('warning',custom_warning('W022'));
            return back()->withInput();
        }

        $permiss = DB::select("SELECT permis_conduires.type FROM permis_conduires, employe_permis WHERE employe_permis.code_emp = ?  AND permis_conduires.id = employe_permis.permis_type", [$val]);

        reresh_perssion(session()->get('user'), request()->url());
        return view("layouts_emp.employe_show_generalite")->with('employes', $employes)->with('employePoste', $employePoste)->with('permiss', $permiss);
        //dd($employes);
    }

            
    /******************************************************************************************* */
    /******************************************************************************************* */


    //  Go to Show Carrière Employe
    public function employes_show_carriere(){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 

        $val = (session()->get('user'))->code_user;
        $directions = Direction::all('libelle', 'code');

        $employes = DB::select("SELECT * FROM employes WHERE employes.code=?", [$val]);

        $employePoste = DB::select("SELECT postes.libelle as poste, departements.libelle as departement, departements.code as code_dep, services.libelle as service, directions.libelle as direction, employe_postes.debut FROM `employe_postes`, employes, postes, departements, services, directions

        WHERE employe_postes.code_emp = employes.code AND employes.code =? AND employe_postes.poste_id = postes.id AND employe_postes.statut='actif'  AND departements.code = postes.departement_code AND services.id = postes.service_id AND directions.code = postes.direction_code ",[$val]);

        $affectations = DB::select("SELECT employe_postes.debut, postes.libelle as poste, employe_postes.fin, contrat_employes.fichier, postes.libelle
        FROM employe_postes, contrat_employes, postes 
        WHERE employe_postes.code_emp =? AND contrat_employes.code_emp = employe_postes.code_emp AND contrat_employes.date = employe_postes.debut AND postes.id = employe_postes.poste_id",[$val]);

        //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);
        reresh_perssion(session()->get('user'), request()->url());
        return view("layouts_emp.employe_show_carriere")->with('employes', $employes)->with('employePoste', $employePoste)->with('directions', $directions)->with('affectations', $affectations);
        //dd($employes);
    }


    /******************************************************************************************* */
    /******************************************************************************************* */



    //  Go to Show Salaire Employe
    public function employes_show_salaire(){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 
        $val = (session()->get('user'))->code_user;

        $directions = Direction::all('libelle', 'code');

        $employes = DB::select("SELECT * FROM employes WHERE employes.code=?", [$val]);

        $employePoste = DB::select("SELECT postes.libelle as poste, departements.libelle as departement, departements.code as code_dep, services.libelle as service, directions.libelle as direction, employe_postes.debut FROM `employe_postes`, employes, postes, departements, services, directions

        WHERE employe_postes.code_emp = employes.code AND employes.code =? AND employe_postes.poste_id = postes.id AND employe_postes.statut='actif'  AND departements.code = postes.departement_code AND services.id = postes.service_id AND directions.code = postes.direction_code ",[$val]);

        $affectations = DB::select("SELECT employe_postes.debut, postes.libelle as poste, employe_postes.fin, contrat_employes.fichier, postes.libelle
        FROM employe_postes, contrat_employes, postes 
        WHERE employe_postes.code_emp =? AND contrat_employes.code_emp = employe_postes.code_emp AND contrat_employes.date = employe_postes.debut AND postes.id = employe_postes.poste_id",[$val]);

        //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);
        reresh_perssion(session()->get('user'), request()->url());
        return view("layouts_emp.employe_show_salaire")->with('employes', $employes)->with('employePoste', $employePoste)->with('directions', $directions)->with('affectations', $affectations);
        //dd($employes);
    }

    /******************************************************************************************* */
    /******************************************************************************************* */


    //  Go to Show Congés Employe
    public function employes_show_conge(){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 

        $val = (session()->get('user'))->code_user;
        $directions = Direction::all('libelle', 'code');

        $employes = DB::select("SELECT employes.*,employe_postes.debut FROM employes, employe_postes WHERE employes.code=? AND employe_postes.debut = (SELECT MIN(employe_postes.debut) from employe_postes, employes WHERE employe_postes.code_emp = employes.code AND employes.code =? )", [$val, $val]);

        $conges = DB::select("SELECT C1.*, IFNULL( TOTAL_DAYS_NO_WEEK(C1.date_fin, C1.date_debut) , 0) AS nbrJ FROM conges C1 WHERE C1.code_emp =? ", [$val]);//AND C1.statut=1

        $congeAcquisEnCours = DB::select("SELECT `CalculConges`(?) AS `congeAcquisEnCours`;", [$val]);
        $nbrJoursCongeMere2 = DB::select("SELECT `nbrJoursCongeMere2`(?) AS `nbrJoursCongeMere2`;", [$val]);
        $nbrJoursCongeDejaPris = DB::select("SELECT `nbrJoursCongeDejaPris`(?) AS `nbrJoursCongeDejaPris`;", [$val]);
        $nbrJoursCongeAcquisDepuisFonction = DB::select("SELECT `nbrJoursCongeAcquisDepuisFonction`(?) AS `nbrJoursCongeAcquisDepuisFonction`;", [$val]);
        $nbrJoursCongeAnciennete = DB::select("SELECT `nbrJoursCongeAnciennete`(?) AS `nbrJoursCongeAnciennete`;", [$val]);
        $nbrJoursCongeAnneeEnCours = DB::select("SELECT `nbrJoursCongeAnneeEnCours`(?) AS `nbrJoursCongeAnneeEnCours`;", [$val]);

        //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);
        reresh_perssion(session()->get('user'), request()->url());
        return view("layouts_emp.employe_show_conge")
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


    //  Go to Show Abscences Employe
    public function employes_show_abscence(){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 
        $val = (session()->get('user'))->code_user;

        $directions = Direction::all('libelle', 'code');

        $employes = DB::select("SELECT * FROM employes WHERE employes.code=?", [$val]);

        $abscences = Abscence::all()->where('code_emp',$val);//->where('statut','=',1);
        //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);

        reresh_perssion(session()->get('user'), request()->url());
        return view("layouts_emp.employe_show_abscence")->with('employes', $employes)->with('directions', $directions)->with('abscences', $abscences);
        //dd($employes);
    }


    /******************************************************************************************* */
    /******************************************************************************************* */


    //  Go to Show ENFANTS Employe
    public function employes_show_enfant(){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 

        $val = (session()->get('user'))->code_user;
        $enfants = Employe_enfants::all()->where('code_emp',$val);

        $employes = DB::select("SELECT * FROM employes WHERE employes.code=?", [$val]);
        //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);
        reresh_perssion(session()->get('user'), request()->url());
        return view("layouts_emp.employe_show_enfant")->with('employes', $employes)->with('enfants', $enfants);
        //dd($employes);
    }

    /******************************************************************************************* */
    /******************************************************************************************* */


    //  Go to Show MISSION Employe
    public function employes_show_mission(){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 

        $val = (session()->get('user'))->code_user;
        $missions = Mission::all()->where('code_emp',$val);//->where('statut','=',1);

        $employes = DB::select("SELECT * FROM employes WHERE employes.code=?", [$val]);
        //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);
        reresh_perssion(session()->get('user'), request()->url());
        return view("layouts_emp.employe_show_mission")->with('employes', $employes)->with('missions', $missions);
        //dd($employes);
    }


    /******************************************************************************************* */
    /******************************************************************************************* */


    //  Go to Show DOCUMENTS Employe
    public function employes_show_document(){

        //  SEND 
        if(check_session() =='no'){
            return redirect('/');
        } 

        $val = (session()->get('user'))->code_user;

        $employes = DB::select("SELECT * FROM employes WHERE employes.code=?", [$val]);

        $sesdocuments = DB::select("SELECT document_employes.type_id, document_employes.code_emp, document_employes.fichier, document_employe_types.libelle, document_employes.created_at, document_employes.updated_at  FROM document_employes, document_employe_types WHERE document_employes.type_id = document_employe_types.id AND document_employes.code_emp=? ORDER BY document_employes.updated_at DESC, document_employe_types.libelle ASC", [$val]);

        //config(['app.DOSSIER_EMPLOYES_storage' => 'aa']);
        reresh_perssion(session()->get('user'), request()->url());
        return view("layouts_emp.employe_show_document")->with('employes', $employes)->with('sesdocuments', $sesdocuments);
        //dd($employes);
    }



/******************************************************************************************* */
/******************************************************************************************* */
    
    //  GO TO ABSCENCES    
    public function mes_abscences(){
        if(check_session() =='no')
            return redirect('/'); 

        $employes = DB::table('employe_postes')->where('code_emp', (session()->get('user'))->code_user)->first();
        if(empty($employes)){
            session()->put('warning',custom_warning('W022'));
            return back()->withInput();
        }
        
        $abscences =DB::select("SELECT abscences.*, workflows.commentaire, workflows.commentairem, workflows.date_attrib, workflows.statut_w, employes.nom, employes.prenom, postes.libelle as poste, directions.code as direction, departements.libelle as departements, services.libelle as service
        FROM abscences, workflows, workflow_types, employes, postes, directions, departements, employe_postes, services
        WHERE workflows.action_id = abscences.id 
            AND abscences.code_emp = ? 
            AND employes.code = abscences.code_emp
            AND workflows.type_id = workflow_types.id 
            AND workflow_types.libelle = 'abscences'
            AND employe_postes.code_emp = abscences.code_emp
            AND employe_postes.statut='actif' 
            AND employe_postes.poste_id = postes.id
            AND postes.direction_code = directions.code
            AND postes.departement_code = departements.code
            AND postes.service_id = services.id", [session()->get('user')->code_user]);
        //Abscence::all()->where('code_emp', session()->get('user')->code_user);
        reresh_perssion(session()->get('user'), request()->url());
        return view("layouts_emp.employe_abscence")->with("abscences", $abscences);
        //return view("layouts.configuration");
        //dd($employes);
    }

/******************************************************************************************* */
/******************************************************************************************* */

    //  GO TO CONGES    
    public function mes_conges(){
        if(check_session() =='no')
            return redirect('/'); 
        
        $employes = DB::table('employe_postes')->where('code_emp', (session()->get('user'))->code_user)->first();
        if(empty($employes)){
            session()->put('warning',custom_warning('W022'));
            return back()->withInput();
        }
        $conges = DB::select("SELECT conges.*, workflows.commentaire, workflows.commentairem, workflows.date_attrib, workflows.statut_w, employes.nom, employes.prenom, postes.libelle as poste, directions.code as direction, departements.libelle as departements, services.libelle as service
        FROM conges, workflows, workflow_types, employes, postes, directions, departements, employe_postes, services
        WHERE workflows.action_id = conges.id 
            AND conges.code_emp = ? 
            AND employes.code = conges.code_emp
            AND workflows.type_id = workflow_types.id 
            AND workflow_types.libelle = 'conges'
            AND employe_postes.code_emp = conges.code_emp
            AND employe_postes.statut='actif' 
            AND employe_postes.poste_id = postes.id
            AND postes.direction_code = directions.code
            AND postes.departement_code = departements.code
            AND postes.service_id = services.id", [session()->get('user')->code_user]);
        //Conge::all()->where('code_emp', session()->get('user')->code_user);
        reresh_perssion(session()->get('user'), request()->url());
        return view("layouts_emp.employe_conge")->with("conges", $conges);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }

/******************************************************************************************* */
/******************************************************************************************* */

    //  GO TO MISSIONS    
    public function mes_missions(){
        if(check_session() =='no')
            return redirect('/'); 
        
        $employes = DB::table('employe_postes')->where('code_emp', (session()->get('user'))->code_user)->first();
        $pays = DB::table("pays")->get();

        if(empty($employes)){
            session()->put('warning',custom_warning('W022'));
            return back()->withInput();
        }

        $missions = DB::select("SELECT missions.*, workflows.commentaire, workflows.commentairem, workflows.date_attrib, workflows.statut_w, employes.nom, employes.prenom, postes.libelle as poste, directions.code as direction, departements.libelle as departements, services.libelle as service
        FROM missions, workflows, workflow_types, employes, postes, directions, departements, employe_postes, services
        WHERE workflows.action_id = missions.id 
            AND missions.code_emp = ? 
            AND employes.code = missions.code_emp
            AND workflows.type_id = workflow_types.id 
            AND workflow_types.libelle = 'missions'
            AND employe_postes.code_emp = missions.code_emp
            AND employe_postes.statut='actif' 
            AND employe_postes.poste_id = postes.id
            AND postes.direction_code = directions.code
            AND postes.departement_code = departements.code
            AND postes.service_id = services.id", [session()->get('user')->code_user]);
        //Mission::all()->where('code_emp', session()->get('user')->code_user);
        reresh_perssion(session()->get('user'), request()->url());
        return view("layouts_emp.employe_mission")->with("missions", $missions)->with("pays", $pays);
    }



/******************************************************************************************* */
/******************************************************************************************* */

    //  SAVE ABSCENCES    
    public function save_add_abscence(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        
        if(check_analyse_exist() =='no'){
            session()->put('warning',("Vous n'avez pas encorre de Worklow! Contacter l'administrateur"));
            return back()->withInput(); 
        }

        /*  CHECK IF PERIODE EST DISPONBLE  */
        if(check_disponibilite_action(session()->get('user')->code_user, $request->date_debut_abs) > 0){
            session()->put('warning',custom_warning('W023'));
            return back()->withInput(); 
        }

        try {
            $insertion = DB::insert("CALL `insertDemandeAbscence`(?, ?, ?, ?);", [session()->get('user')->code_user, $request->motif, $request->date_debut_abs, $request->nbrJ_abscence, ]);
            //$id = Abscence::insertGetId(['code_emp' => session()->get('user')->code_user]);
            //$id = DB::getPdo()->lastInsertId();
            
            $abs = DB::select("SELECT id FROM abscences WHERE code_emp = ? AND date_depart = ? AND motif=? AND nbrJ_demande=?", [session()->get('user')->code_user, $request->date_debut_abs, $request->motif, $request->nbrJ_abscence]);

            $arrayWorkflowAnalyse = get_list_employe_workflow(session()->get('user')->code_user);

            $insertion2 = DB::insert("CALL `insertWORKFLOW`(?, ?, ?, ?, ?, ?, ?);", [$abs[0]->id, "abscences", session()->get('user')->code_user , $arrayWorkflowAnalyse[1], $arrayWorkflowAnalyse[2], (count($arrayWorkflowAnalyse)-1), get_employe_workflow(session()->get('user')->code_user)]);


            if($insertion && $insertion2){
                $abscences = DB::select("SELECT abscences.*, employes.nom, employes.prenom, postes.libelle, departements.code as dept, services.libelle as service FROM abscences, employes, employe_postes EP1, postes, services, departements
                WHERE abscences.code_emp = employes.code AND abscences.id = ? AND employes.code = EP1.code_emp AND EP1.poste_id = postes.id AND postes.departement_code = departements.code AND services.id = postes.service_id AND EP1.debut = (SELECT MIN(EP2.debut) FROM employes E2, employe_postes EP2 WHERE EP2.code_emp = E2.code AND E2.code = EP1.code_emp)", [$abs[0]->id]);
                
                try {
                    $pdfFile = pdf_employe_demande_abscence($abscences);
                } catch (\Exception $e) {
                    session()->put('error',custom_error('E016'));
                    return redirect('/mes_abscences');
                }
                

                $abscenceR = Abscence::find($abs[0]->id);
                $abscenceR->fichier_demande = $pdfFile;
                $abscenceR->save();

            }
            
        
        }  catch (\Exception $e) {
            session()->put('error',$e->getMessage());//custom_error('E012')
            return redirect('/mes_abscences');
        }
        
        reresh_perssion(session()->get('user'), request()->url());
        afficherSuccess(custom_success(999));
        return redirect('/mes_abscences');
    }


    //  SAVE EDIT JUSTIFICATIF    
    public function save_edit_justificatif(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        
        
        $code_emloye = session()->get('user')->code_user;

        $abscence = Abscence::find($request->id_abs);
        
        if(isset($request->justificatif)){
            //  Pièce d'identité
            $justificatif = $request->justificatif;
            $justificatif = get_file_name_to_store($request,'justificatif', env('DOSSIER_EMPLOYES').$code_emloye,'abscenceJ-'.$code_emloye.'-'.$abscence->created_at,'' );
            try {
                $updateAbs = DB::update('UPDATE abscences set fichier_justification = ?, justifier = ? WHERE id = ?', [$justificatif, 1, $request->id_abs]);
            }  catch (\Exception $e) {
                session()->put('error',custom_error('E015'));
                return redirect('/mes_abscences');
            }
        }else{
            session()->put('warning',custom_warning('W002'));
            return redirect('/mes_abscences');
        }
        
        
        reresh_perssion(session()->get('user'), request()->url());
        afficherSuccess(custom_success(999));
        return redirect('/mes_abscences');
    }

/******************************************************************************************* */
/******************************************************************************************* */

    //  SAVE CONGE    
    public function save_add_conge(Request $request){
        if(check_session() =='no')
            return redirect('/'); 

        if(check_analyse_exist() =='no'){
            session()->put('warning',("Vous n'avez pas encorre de Worklow! Contacter l'administrateur"));
            return back()->withInput(); 
        }
        /*  CHECK IF PERIODE EST DISPONBLE  */
        if(check_disponibilite_action(session()->get('user')->code_user, $request->date_debut_conge) > 0){
            session()->put('warning',custom_warning('W023'));
            return back()->withInput(); 
        }

        $code_emloye = session()->get('user')->code_user;

        /*   CHECK ELLIGIBILITE   */
        $congeAcquisEnCours = DB::select("SELECT `CalculConges`(?) AS `congeAcquisEnCours`;", [$code_emloye])[0];
        $nbrJ_demande = DB::select("SELECT TOTAL_DAYS_NO_WEEK(?, ?) AS nbrJpris",[ $request->date_fin_conge, $request->date_debut_conge])[0];
        
        if($congeAcquisEnCours->congeAcquisEnCours < $nbrJ_demande->nbrJpris){
            session()->put('warning',custom_warning('W004'));
            return redirect('/mes_conges');
        }

        /*  LES FICHIERS    */

        if(isset($request->justificatif)){
            //  Pièce d'identité
            $justificatif = $request->justificatif;
            $justificatif = get_file_name_to_store($request,'justificatif', env('DOSSIER_EMPLOYES').$code_emloye,'congeJ-'.$code_emloye.'-'.date('d-m-y_h:i:s'),'' );
        }else{
            $justificatif = "";
        }

        try {
            $insertion = DB::insert("CALL `insertDemandeConge`(?, ?, ?, ?, ?);", [$code_emloye, $request->motif, $request->date_debut_conge, $request->date_fin_conge, $justificatif]);

        }  catch (\Exception $e) {
            session()->put('error',custom_error('E013'));
            return redirect('/mes_conges');
        }

        try {
            
            $cng = DB::select("SELECT id FROM conges WHERE code_emp = ? AND motif=? AND date_debut = ? AND date_fin=?", [$code_emloye, $request->motif, $request->date_debut_conge, $request->date_fin_conge]);

            $arrayWorkflowAnalyse = get_list_employe_workflow($code_emloye);

            $insertion2 = DB::insert("CALL `insertWORKFLOW`(?, ?, ?, ?, ?, ?, ?);", [$cng[0]->id, "conges", $code_emloye , $arrayWorkflowAnalyse[1], $arrayWorkflowAnalyse[2], (count($arrayWorkflowAnalyse)-1), get_employe_workflow($code_emloye)]);
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());//custom_error('E017'));
            return redirect('/mes_conges');
        }
        
        reresh_perssion(session()->get('user'), request()->url());
        afficherSuccess(custom_success(999));
        return redirect('/mes_conges');
    }


    
/******************************************************************************************* */
/******************************************************************************************* */

    //  SAVE MISSION    
    public function save_add_mission(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        
        if(check_analyse_exist() =='no'){
            session()->put('warning',custom_warning('W007'));
            return back()->withInput(); 
        }
        /*   CHECK VALUES    */
        if($request->date_depart > $request->date_retour){
            session()->put('warning',custom_warning('W006'));
            return redirect('/mes_missions');
        }
        /*  CHECK IF PERIODE EST DISPONBLE  */
        if(check_disponibilite_action(session()->get('user')->code_user, $request->date_depart) > 0){
            session()->put('warning',custom_warning('W023'));
            return back()->withInput(); 
        }
        /*      GO          */
        $code_emloye = session()->get('user')->code_user;
        try {
            $insertion = DB::insert("CALL `insertDemandeMission`(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", [session()->get('user')->code_user, $request->objet, $request->pays, $request->ville, $request->date_depart, $request->date_retour, $request->transport, $request->telephone, $request->mot, $request->autre ]);
        }  catch (\Exception $e) {
            session()->put('error',custom_error('E014'));
            return redirect('/mes_missions');
        }

        
        try {
            
            $miss = DB::select("SELECT id FROM missions WHERE code_emp = ? AND objet=? AND date_debut = ? AND date_retour=? AND pays=? AND ville=?", [$code_emloye, $request->objet, $request->date_depart, $request->date_retour, $request->pays, $request->ville]);

            $arrayWorkflowAnalyse = get_list_employe_workflow($code_emloye);
            
            $insertion2 = DB::insert("CALL `insertWORKFLOW`(?, ?, ?, ?, ?, ?, ?);", [$miss[0]->id, "missions", $code_emloye, $arrayWorkflowAnalyse[1], $arrayWorkflowAnalyse[2], (count($arrayWorkflowAnalyse)-1), get_employe_workflow($code_emloye)]);
        } catch (\Exception $e) {
            session()->put('error',custom_error('E017'));
            return redirect('/mes_conges');
        }

        /*  GENERER PDF DEMANDE MISSION */
        if($insertion && $insertion2){
            /*$abscences = DB::select("SELECT abscences.*, employes.nom, employes.prenom, postes.libelle, departements.code as dept, services.libelle as service FROM abscences, employes, employe_postes EP1, postes, services, departements
            WHERE abscences.code_emp = employes.code AND abscences.id = ? AND employes.code = EP1.code_emp AND EP1.poste_id = postes.id AND postes.departement_code = departements.code AND services.id = postes.service_id AND EP1.debut = (SELECT MIN(EP2.debut) FROM employes E2, employe_postes EP2 WHERE EP2.code_emp = E2.code AND E2.code = EP1.code_emp)", [$abs[0]->id]);
            
            try {
                $pdfFile = pdf_employe_demande_abscence($abscences);
            } catch (\Exception $e) {
                session()->put('error',custom_error('E016'));
                return redirect('/mes_abscences');
            }
            

            $abscenceR = Abscence::find($abs[0]->id);
            $abscenceR->fichier_demande = $pdfFile;
            $abscenceR->save();
            */
        }
        
        reresh_perssion(session()->get('user'), request()->url());
        afficherSuccess(custom_success(999));
        return redirect('/mes_missions');
        
    }



    /******************************************************************************************* */
/******************************************************************************************* */

    //  SHOW ETAT WORKFLOW ABSCENCE    
    public function show_etat_workflow_abscence($val){
        if(check_session() =='no')
            return redirect('/'); 
        
        $employePoste = DB::select("SELECT postes.libelle as poste, departements.libelle as departement, departements.code as code_dep, services.libelle as service, directions.libelle as direction FROM `employe_postes`, employes, postes, departements, services, directions

        WHERE employe_postes.code_emp = employes.code AND employes.code =? AND employe_postes.poste_id = postes.id AND employe_postes.statut='actif'  AND departements.code = postes.departement_code AND services.id = postes.service_id AND directions.code = postes.direction_code ",[$val]);
    
        reresh_perssion(session()->get('user'), request()->url());
        return view('/mes_missions');
    }


    

}
