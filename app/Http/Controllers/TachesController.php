<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Mail\SimpleEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TachesController extends Controller
{
    // GO TO Taches
    public function taches($myseachD){
        if(check_session() =='no')
            return redirect('/'); 
        /*
        $val = 'employes';
        $string = "SELECT * FROM ".$val." WHERE ".$val.".code = 'EMP_1'" ;
        $taches = DB::select($string);
        */

        $taches1 = DB::select("
        SELECT 
            workflow_logs.id as id_wl, workflows.id as id_w, workflow_types.libelle, workflows.action_id, workflow_logs.workflow_statut, workflow_logs.decision, workflow_logs.created_at
        FROM 
            workflow_logs, workflows, workflow_types
        WHERE 
            workflow_logs.workflow_id = workflows.id
        AND 
            workflow_types.id = workflows.type_id
        AND 
            workflow_logs.code_emp_respo = ?
        ", [session()->get('user')->code_user]);

        $tachesF = array();
        foreach($taches1 as $row){
            $val = $row->libelle;
            $query = "
            SELECT 
            CONCAT(employes.nom,' ',employes.prenom) as nom_complet
            FROM 
                employes,".$val." 
            WHERE 
                employes.code = ".$val.".code_emp";

            $row->nom_complet = (DB::select($query))[0]->nom_complet; 
            
            $tachesF[] = $row;
        }
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts2.taches")->with("tachesF", $tachesF)->with("myseachD", $myseachD);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }



    // GO TO ACTIONS
    public function actions($myseachD){
        if(check_session() =='no')
            return redirect('/'); 
        /*
        $val = 'employes';
        $string = "SELECT * FROM ".$val." WHERE ".$val.".code = 'EMP_1'" ;
        $taches = DB::select($string);
        */
        $user = DB::select("SELECT postes.libelle as poste, departements.libelle as departement, departements.code as code_dep, services.libelle as service, directions.code as direction, employes.nom, employes.prenom 
        FROM `employe_postes`, employes, postes, departements, services, directions

        WHERE employe_postes.code_emp = employes.code AND employes.code =? AND employe_postes.poste_id = postes.id AND employe_postes.statut='actif'  AND departements.code = postes.departement_code AND services.id = postes.service_id AND directions.code = postes.direction_code ",[session()->get('user')->code_user]);

        if(empty($user)){
            session()->put('warning',custom_warning('W022'));
            return back()->withInput();
        }
        $user = $user[0];

        $abscences = DB::select("SELECT 
        DISTINCT(workflows.id) as id_w, workflow_types.libelle, workflows.action_id, workflows.commentaire, workflows.statut_w, workflows.commentairem, workflows.created_at, workflows.updated_at, abscences.statut
            FROM 
                workflows, workflow_types, abscences
            WHERE 
                workflow_types.id = workflows.type_id
            AND 
                abscences.id = workflows.action_id
            AND
            	workflow_types.libelle = 'abscences'
            AND
                abscences.code_emp =?", [session()->get('user')->code_user]);
        
        $conges = DB::select("SELECT 
        DISTINCT(workflows.id) as id_w, workflow_types.libelle, workflows.action_id, workflows.commentaire, workflows.statut_w, workflows.commentairem, workflows.created_at, workflows.updated_at, conges.statut
            FROM 
                workflows, workflow_types, conges
            WHERE 
                workflow_types.id = workflows.type_id
            AND 
                conges.id = workflows.action_id
            AND
            	workflow_types.libelle = 'conges'
            AND
                conges.code_emp =?", [session()->get('user')->code_user]);
        
        $missions = DB::select("SELECT 
        DISTINCT(workflows.id) as id_w, workflow_types.libelle, workflows.action_id, workflows.commentaire, workflows.statut_w, workflows.commentairem, workflows.created_at, workflows.updated_at, missions.statut
            FROM 
                workflows, workflow_types, missions
            WHERE 
                workflow_types.id = workflows.type_id
            AND 
                missions.id = workflows.action_id
            AND
            	workflow_types.libelle = 'missions'
            AND
                missions.code_emp =?", [session()->get('user')->code_user]);

        $actionF = array();
        foreach($missions as $row){
            $actionF[] = $row;
        }
        foreach($conges as $row){
            $actionF[] = $row;
        }
        foreach($abscences as $row){
            $actionF[] = $row;
        }
        //ksort($actionF);

        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts2.actions")->with("actionF", $actionF)->with("user", $user)->with("myseachD", $myseachD);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }


    // GO TO ANALYSER ABSCENCE
    public function analyser_abscence($val){
        if(check_session() =='no')
            return redirect('/'); 
        

        $abscence = ( DB::select("
        SELECT 
            workflow_logs.id as id_wl, workflow_logs.decision, workflow_logs.workflow_statut, workflows.commentairem, workflows.id as id_w, abscences.*, CONCAT(employes.nom,' ',employes.prenom) as nom_complet
        FROM 
            workflow_logs, workflows, employes, abscences
        WHERE 
            workflow_logs.id = ?
        AND 
            workflows.id = workflow_logs.workflow_id
        AND 
            abscences.code_emp = employes.code
        AND
            abscences.id = workflows.action_id", [$val]) )[0];

        $poste = DB::select("SELECT 
        postes.libelle as poste, 
        departements.libelle as departement, 
        departements.code as code_dep, 
        services.libelle as service, 
        directions.libelle as direction 
        
        FROM `employe_postes`, employes, postes, departements, services, directions, abscences, workflow_logs, workflows
    
            WHERE employe_postes.code_emp = employes.code 
            AND employe_postes.poste_id = postes.id  
            AND departements.code = postes.departement_code 
            AND services.id = postes.service_id 
            AND directions.code = postes.direction_code 
            AND workflow_logs.workflow_id = workflows.id 
            AND employes.code = abscences.code_emp 
            AND workflows.action_id = abscences.id
            AND workflow_logs.id = ?", [$val]);

        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts2.tache_analyser_abscence")->with("abscence", $abscence)->with("poste", $poste);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }

    // GO TO ANALYSER CONGE
    public function analyser_conge($val){
        if(check_session() =='no')
            return redirect('/'); 
        

        $code_emp = DB::select("SELECT
        conges.code_emp
        
        FROM conges, workflow_logs, workflows
    
            WHERE workflow_logs.workflow_id = workflows.id 
            AND workflows.action_id = conges.id
            AND workflow_logs.id = ?", [$val])[0]->code_emp;
        $conge = ( DB::select("
        SELECT 
            workflow_logs.id as id_wl, workflow_logs.decision, workflows.commentairem,`workflow_logs`.`workflow_statut`, workflows.id as id_w, conges.*, CONCAT(employes.nom,' ',employes.prenom) as nom_complet
        FROM 
            workflow_logs, workflows, employes, conges
        WHERE 
            workflow_logs.id = ?
        AND 
            workflows.id = workflow_logs.workflow_id
        AND 
            conges.code_emp = employes.code
        AND
            conges.id = workflows.action_id", [$val]) )[0];

        $poste = DB::select("SELECT 
            postes.libelle as poste, 
            departements.libelle as departement, 
            departements.code as code_dep, 
            services.libelle as service, 
            directions.libelle as direction 
            
            FROM `employe_postes`, employes, postes, departements, services, directions, conges, workflow_logs, workflows
        
                WHERE employe_postes.code_emp = employes.code 
                AND employe_postes.poste_id = postes.id  
                AND departements.code = postes.departement_code 
                AND services.id = postes.service_id 
                AND directions.code = postes.direction_code 
                AND workflow_logs.workflow_id = workflows.id 
                AND employes.code = conges.code_emp 
                AND workflows.action_id = conges.id
                AND workflow_logs.id = ?", [$val]);
        
        $congeAcquisEnCours = DB::select("SELECT `CalculConges`(?) AS `congeAcquisEnCours`;", [$code_emp]);
 
        $nbrJpris = DB::select("SELECT TOTAL_DAYS_NO_WEEK(?, ?) AS nbrJpris",[$conge->date_fin, $conge->date_debut]);
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts2.tache_analyser_conge")->with("conge", $conge)->with("poste", $poste)->with("congeAcquisEnCours", $congeAcquisEnCours)->with("nbrJpris", $nbrJpris);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }

    // GO TO ANALYSER MISSION
    public function analyser_mission($val){
        if(check_session() =='no')
            return redirect('/'); 
        

        $code_emp = DB::select("SELECT
        missions.code_emp
        
        FROM missions, workflow_logs, workflows
    
            WHERE workflow_logs.workflow_id = workflows.id 
            AND workflows.action_id = missions.id
            AND workflow_logs.id = ?", [$val])[0]->code_emp;
        $missions = ( DB::select("
        SELECT 
            workflow_logs.id as id_wl, workflow_logs.decision, workflows.commentairem,`workflow_logs`.`workflow_statut`, workflows.id as id_w, missions.*, CONCAT(employes.nom,' ',employes.prenom) as nom_complet
        FROM 
            workflow_logs, workflows, employes, missions
        WHERE 
            workflow_logs.id = ?
        AND 
            workflows.id = workflow_logs.workflow_id
        AND 
            missions.code_emp = employes.code
        AND
            missions.id = workflows.action_id", [$val]) )[0];

        $poste = DB::select("SELECT 
            postes.libelle as poste, 
            departements.libelle as departement, 
            departements.code as code_dep, 
            services.libelle as service, 
            directions.libelle as direction 
            
            FROM `employe_postes`, employes, postes, departements, services, directions, missions, workflow_logs, workflows
        
                WHERE employe_postes.code_emp = employes.code 
                AND employe_postes.poste_id = postes.id  
                AND departements.code = postes.departement_code 
                AND services.id = postes.service_id 
                AND directions.code = postes.direction_code 
                AND workflow_logs.workflow_id = workflows.id 
                AND employes.code = missions.code_emp 
                AND workflows.action_id = missions.id
                AND workflow_logs.id = ?", [$val]);
        
        $congeAcquisEnCours = DB::select("SELECT `CalculConges`(?) AS `congeAcquisEnCours`;", [$code_emp]);
 
        //$nbrJpris = DB::select("SELECT TOTAL_DAYS_NO_WEEK(?, ?) AS nbrJpris",[$conge->date_fin, $conge->date_debut]);
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts2.tache_analyser_mission")->with("missions", $missions)->with("poste", $poste)->with("congeAcquisEnCours", $congeAcquisEnCours);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }

    //  BASIC EMAIL
    public function basic_email() {
        //Mail::to("darryl.m@strafrica.com")->send(new SendMail() );
        Mail::to("darryl.m@strafrica.com")->send(new SimpleEmail("Notification", "Recois cette notification man") );

        //  ->cc(['paul.yomi@domain.com','stack.overflow@domain.com','abc.xyz@domain.com','nigeria@domain.com'])
        
        /*  Email SendEmail
        $var = [];
        $var['to'] = "darrylmadoungou@gmail.com";
        $var['message'] = 'TOP';
        $var['sujet'] = 'Nouvelle Tache';
        Mail::to("darylmadoungou@gmail.com")->send(new SendMail($var) );    // ->send(new Contact($request->except('_token')));
        */
    }


    //     EDIT ABSCENCE TACHE
    public function save_tache_abscence(Request $request) {
        

        if(!isset($request->commentaire)){
            if(isset($request->rejeter)){
                session()->put('warning',custom_warning('W008'));
                return redirect("/taches/taches/analyser/abscences/".$request->id_workflow_log);
            }
            $comment = "";
        }else{
            $comment = $request->commentaire;
        }

        if (Session('permission')[0]->edit == 1) {
            if(!isset($request->nbrJ_accode) || !isset($request->nbrJ_ssolde)){
                session()->put('warning',custom_warning('W002'));
                return redirect("/taches/taches/analyser/abscences/".$request->id_workflow_log);
            }
            $actionid = DB::select("SELECT a.id as id
            FROM abscences a, workflows, workflow_logs 
            WHERE a.id = workflows.action_id 
            AND workflows.id = workflow_logs.workflow_id
            AND workflow_logs.id = ?", [$request->id_workflow_log])[0]->id;

            $enregistrer = DB::update("UPDATE abscences SET nbrJ_accord=? , nbrJ_accord_ssolde=? WHERE abscences.id = ? ", 
                [$request->nbrJ_accode, $request->nbrJ_ssolde, $actionid]);
        }


        if (isset($request->accepter)) {
            if( get_position_actuelle_workflow($request->id_workflow_log)+1 <= get_longueur_workflow($request->id_workflow_log) ){
                //  NEXTABLE

                $code_nouveau_res = get_employe_workflow_encours_position($request->id_workflow_log, get_position_actuelle_workflow($request->id_workflow_log)+1);

                $code_pro = get_employe_workflow_encours_position($request->id_workflow_log, get_position_actuelle_workflow($request->id_workflow_log)+2);

                try{
                    $update = DB::update("CALL `updateWorkflowNext`(?, ?, ?, ?, ?);", [$request->id_workflow_log, $code_nouveau_res, $code_pro, $comment, 1]);
                }catch (\Exception $e) {
                    session()->put('error',custom_error('E018'));
                    return redirect("/taches/taches/analyser/abscences/".$request->id_workflow_log);
                }

                //print($code_nouveau_res.' '.$code_pro.' - '.$comment);
            }else{
                //  FIN DU WORKFLOW
                try{
                    $update = DB::update("CALL `updateWorkflowEND`(?, ?, ?, ?);", [$request->id_workflow_log, "abscences", $comment, 1]);
                }catch (\Exception $e) {
                    session()->put('error',custom_error('E019'));
                    return redirect("/taches/taches/analyser/abscences/".$request->id_workflow_log);
                }
                //  GENERER FICHIER
                try{
                    generer_demande_abscenceLast($request->id_workflow_log);
                }catch (\Exception $e) {
                    session()->put('error',custom_error('E012'));
                    return redirect("/taches/taches/analyser/abscences/".$request->id_workflow_log);
                }
            }

            afficherSuccess(custom_success(999));
            return redirect("/taches/taches/analyser/abscences/".$request->id_workflow_log);
        }

        if (isset($request->rejeter)) {
            try{
                $update = DB::update("CALL `updateWorkflowEND`(?, ?, ?, ?);", [$request->id_workflow_log, "abscences", $comment, 0]);
            }catch (\Exception $e) {
                session()->put('error',custom_error('E019'));
                return redirect("/taches/taches/analyser/abscences/".$request->id_workflow_log);
            }
        }

        if (isset($request->suspendre)) {
            try{
                $update = DB::update("CALL `updateWorkflowSuspendu`(?, ?, ?);", [$request->id_workflow_log, "abscences", $comment]);
            }catch (\Exception $e) {
                session()->put('error',custom_error('E019'));
                return redirect("/taches/taches/analyser/abscences/".$request->id_workflow_log);
            }
        }

        if (isset($request->reactiver)) {
            try{
                $update = DB::update("CALL `updateWorkflowReactiver`(?, ?, ?, ?);", [$request->id_workflow_log, "abscences", $comment, session()->get('user')->code_user]);
            }catch (\Exception $e) {
                session()->put('error',custom_error('E019'));
                return redirect("/taches/taches/analyser/abscences/".$request->id_workflow_log);
            }
        }

        
        afficherSuccess(custom_success(999));
        return redirect("/taches/taches/analyser/abscences/".$request->id_workflow_log);
    }
 
    
    //     EDIT CONGE TACHE
    public function save_tache_conge(Request $request) {
        if(!isset($request->commentaire)){
            $comment = "";
            if(isset($request->rejeter)){
                session()->put('warning',custom_warning('W008'));
                return redirect("/taches/taches/analyser/conges/".$request->id_workflow_log);
            }
        }else{
            $comment = $request->commentaire;
        }

        if (isset($request->accepter)) {
            if( get_position_actuelle_workflow($request->id_workflow_log)+1 <= get_longueur_workflow($request->id_workflow_log) ){
                //  NEXTABLE

                $code_nouveau_res = get_employe_workflow_encours_position($request->id_workflow_log, get_position_actuelle_workflow($request->id_workflow_log)+1);

                $code_pro = get_employe_workflow_encours_position($request->id_workflow_log, get_position_actuelle_workflow($request->id_workflow_log)+2);

                try{
                    $update = DB::update("CALL `updateWorkflowNext`(?, ?, ?, ?, ?);", [$request->id_workflow_log, $code_nouveau_res, $code_pro, $comment, 1]);
                }catch (\Exception $e) {
                    session()->put('error',custom_error('E018'));
                    return redirect("/taches/taches/analyser/conges/".$request->id_workflow_log);
                }
                //print($code_nouveau_res.' '.$code_pro.' - '.$comment);
            }else{
                //  FIN DU WORKFLOW
                try{
                    $update = DB::update("CALL `updateWorkflowEND`(?, ?, ?, ?);", [$request->id_workflow_log, "conges", $comment, 1]);
                }catch (\Exception $e) {
                    session()->put('error',custom_error('E019'));
                    return redirect("/taches/taches/analyser/conges/".$request->id_workflow_log);
                }

                //  GENERER FICHIER
                try{
                    generer_attestation_congeLast($request->id_workflow_log);
                }catch (\Exception $e) {
                    session()->put('error',custom_error('E013'));
                    return redirect("/taches/taches/analyser/conges/".$request->id_workflow_log);
                }
            }

            afficherSuccess(custom_success(999));
            return redirect("/taches/taches/analyser/conges/".$request->id_workflow_log);
        }


        if (isset($request->rejeter)) {
            try{
                $update = DB::update("CALL `updateWorkflowEND`(?, ?, ?, ?);", [$request->id_workflow_log, "conges", $comment, 0]);
            }catch (\Exception $e) {
                session()->put('error',custom_error('E019'));
                return redirect("/taches/taches/analyser/conges/".$request->id_workflow_log);
            }
        }

        if (isset($request->suspendre)) {
            try{
                $update = DB::update("CALL `updateWorkflowSuspendu`(?, ?, ?);", [$request->id_workflow_log, "conges", $comment]);
            }catch (\Exception $e) {
                session()->put('error',custom_error('E019'));
                return redirect("/taches/taches/analyser/conges/".$request->id_workflow_log);
            }
        }

        if (isset($request->reactiver)) {
            try{
                $update = DB::update("CALL `updateWorkflowReactiver`(?, ?, ?, ?);", [$request->id_workflow_log, "conges", $comment, session()->get('user')->code_user]);
            }catch (\Exception $e) {
                session()->put('error',custom_error('E019'));
                return redirect("/taches/taches/analyser/conges/".$request->id_workflow_log);
            }
        }

        afficherSuccess(custom_success(999));
        return redirect("/taches/taches/analyser/conges/".$request->id_workflow_log);
    }

    
    //     EDIT MISSION TACHE
    public function save_tache_mission(Request $request) {

        if(!isset($request->commentaire)){
            $comment = "";
            if(isset($request->rejeter)){
                session()->put('warning',custom_warning('W008'));
                return redirect("/taches/taches/analyser/missions/".$request->id_workflow_log);
            }
        }else{
            $comment = $request->commentaire;
        }

        if (Session('permission')[0]->edit == 1) {
            if( !isset($request->repas) || !isset($request->hebergement) || !isset($request->transport) || !isset($request->telephone) || !isset($request->mot) || !isset($request->autre)){
                session()->put('warning',custom_warning('W002'));
                return redirect("/taches/taches/analyser/missions/".$request->id_workflow_log);
            }

            $actionid = DB::select("SELECT a.id as id
            FROM missions a, workflows, workflow_logs 
            WHERE a.id = workflows.action_id 
            AND workflows.id = workflow_logs.workflow_id
            AND workflow_logs.id = ?", [$request->id_workflow_log])[0]->id;

            $enregistrer = DB::update("UPDATE missions 
                SET nbrj_repas=? , nbrj_hebergement=? , transport=? , nbrj_telephone=? , nbrj_mot=? , nbrj_autre=? 
                    WHERE missions.id = ? ", 
                [$request->repas, $request->hebergement,$request->transport,$request->telephone,$request->mot,$request->autre, $actionid]);
        }


        if (isset($request->accepter)) {
            if( get_position_actuelle_workflow($request->id_workflow_log)+1 <= get_longueur_workflow($request->id_workflow_log) ){
                //  NEXTABLE

                $code_nouveau_res = get_employe_workflow_encours_position($request->id_workflow_log, get_position_actuelle_workflow($request->id_workflow_log)+1);

                $code_pro = get_employe_workflow_encours_position($request->id_workflow_log, get_position_actuelle_workflow($request->id_workflow_log)+2);

                try{
                    $update = DB::update("CALL `updateWorkflowNext`(?, ?, ?, ?, ?);", [$request->id_workflow_log, $code_nouveau_res, $code_pro, $comment, 1]);
                }catch (\Exception $e) {
                    session()->put('error',custom_error('E018'));
                    return redirect("/taches/taches/analyser/missions/".$request->id_workflow_log);
                }

                //print($code_nouveau_res.' '.$code_pro.' - '.$comment);
            }else{
                //  FIN DU WORKFLOW
                try{
                    $update = DB::update("CALL `updateWorkflowEND`(?, ?, ?, ?);", [$request->id_workflow_log, "missions", $comment, 1]);
                }catch (\Exception $e) {
                    session()->put('error',custom_error('E019'));
                    return redirect("/taches/taches/analyser/missions/".$request->id_workflow_log);
                }
                
                //  GENERER FICHIER
                try{
                    generer_frais_mission($request->id_workflow_log);
                }catch (\Exception $e) {
                    session()->put('error',custom_error('E014'));
                    return redirect("/taches/taches/analyser/missions/".$request->id_workflow_log);
                }
                try{
                    generer_ordre_mission($request->id_workflow_log);
                }catch (\Exception $e) {
                    session()->put('error',custom_error('E014'));
                    return redirect("/taches/taches/analyser/missions/".$request->id_workflow_log);
                }
            }

            afficherSuccess(custom_success(999));
            return redirect("/taches/taches/analyser/missions/".$request->id_workflow_log);
        }

        if (isset($request->rejeter)) {
            try{
                $update = DB::update("CALL `updateWorkflowEND`(?, ?, ?, ?);", [$request->id_workflow_log, "missions", $comment, 0]);
            }catch (\Exception $e) {
                session()->put('error',custom_error('E019'));
                return redirect("/taches/taches/analyser/missions/".$request->id_workflow_log);
            }
        }

        if (isset($request->suspendre)) {
            try{
                $update = DB::update("CALL `updateWorkflowSuspendu`(?, ?, ?);", [$request->id_workflow_log, "missions", $comment]);
            }catch (\Exception $e) {
                session()->put('error',custom_error('E019'));
                return redirect("/taches/taches/analyser/missions/".$request->id_workflow_log);
            }
        }

        if (isset($request->reactiver)) {
            try{
                $update = DB::update("CALL `updateWorkflowReactiver`(?, ?, ?, ?);", [$request->id_workflow_log, "missions", $comment, session()->get('user')->code_user]);
            }catch (\Exception $e) {
                session()->put('error',custom_error('E019'));
                return redirect("/taches/taches/analyser/missions/".$request->id_workflow_log);
            }
        }

        afficherSuccess(custom_success(999));
        return redirect("/taches/taches/analyser/missions/".$request->id_workflow_log);
    }

   

    // GO TO ANALYSER ABSCENCE
    public function go_to_annuaire(){
        if(check_session() =='no')
            return redirect('/'); 
        

        $annuaires = DB::select("
        SELECT 
            employes.nom, employes.prenom, employes.email, employes.telephone_travail as flotte, postes.libelle as poste, directions.code as direction
        FROM 
            employes, employe_postes, postes, directions
        WHERE
            employes.code = employe_postes.code_emp 
        AND
            employe_postes.statut = 'actif'
        AND
            postes.id = employe_postes.poste_id 
        AND
            postes.direction_code = directions.code 
        ORDER BY
            employes.prenom
        ");

        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts2.annuaire")->with("annuaires", $annuaires);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }
    


}
