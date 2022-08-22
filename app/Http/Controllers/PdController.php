<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\Enregistrement;
use App\Models\Procedure;
use App\Models\Processus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PdController extends Controller
{
    // GO to Cartographie
    public function cartographie(){
        if(check_session() =='no')
            return redirect('/'); 
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_qhse.cartographie");
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }


/******************************************************************************************* */
/******************************************************************************************* */
//                              PROCESSUS
/******************************************************************************************* */
/******************************************************************************************* */


    // GO TO Processus
    public function processus(){
        if(check_session() =='no')
            return redirect('/'); 
        
        $processuss = Processus::all();//->where('actif',1);
        $string = "SELECT processuses.*, directions.libelle as direction_nom, p.libelle as postepilote, (SELECT libelle FROM postes WHERE postes.id = copilote)  as postecopilote 
        FROM processuses, 
                postes p , 
                directions 
        WHERE p.id = pilote 
            AND directions.code = processuses.direction_code 
            AND processuses.statut = 1";
        $processuss = DB::select($string);
        $directions = Direction::pluck( 'libelle', 'code');

        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_qhse.processus")->with('processuss', $processuss)->with('directions', $directions);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }


            //**--------------------------------------------------------------- */


    public function save_add_processus(Request $request)
    {
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $code = strtoupper($request->code);
        $request->code =  strtoupper('FIP.'.$request->code);
        $request->libelle =  strtoupper($request->libelle);
        if( !isset($request->copilote) || $request->copilote == "AUCUN"){
            $request->copilote = 0;
        }

        $check1 = DB::select("SELECT count(id) as nbr FROM processuses WHERE code = ? ", [$request->code])[0]->nbr;
        $check2 = DB::select("SELECT count(id) as nbr FROM processuses WHERE libelle = ? ", [$request->libelle])[0]->nbr;
        //$check3 = DB::select("SELECT count(id) as nbr FROM processuses WHERE fichier = ? ", [$request->fichier])[0]->nbr;

        if($check1 > 0 || $check2 > 0 /*|| $check3 > 0*/){
            session()->put('warning',custom_warning('W030'));
            return redirect("/documentaire/processus");
        }

        if(isset($request->fichier)){
            //  Pièce d'identité
            $fichier = $request->fichier;
            $fichier = get_file_name_to_store($request,'fichier', config('app.DOSSIER_PROCESSUS'). $request->code, 'FIP.'.$request->version, '' );
        }else{
            session()->put('warning',custom_warning('W029'));
            return redirect("/documentaire/processus");
        }
        
        try {
            $insert = DB::insert("INSERT INTO `processuses` (`id`, `code`, `libelle`, `direction_code`, abreviation ,nbr_procedure, `pilote`, `copilote`, `version`, `fichier`, `created_at`, `updated_at`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW());", [$request->code, $request->libelle,  $request->direction,  $code,  $request->nbr_procedure,  $request->pilote,  $request->copilote,  $request->version,  $fichier]);
        } catch (\Exception $e) {
            session()->put('error',custom_error($e->getMessage()));
        }

        afficherSuccess(custom_success(999));
        return redirect("/documentaire/processus");
    }

            //**--------------------------------------------------------------- */

    public function save_edit_processus(Request $request)
    {
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $request->code_ed =  strtoupper($request->code_ed);
        $abreviation = $request->code_ed ;
        $request->code_ed = strtoupper($request->start)."".$request->code_ed;
        $request->libelle_ed =  strtoupper($request->libelle_ed);

                    /*  CHECKING CONFORMITE   */

        if( !isset($request->copilote_ed) || $request->copilote_ed == "AUCUN"){
            //$request->copilote_ed = config('app.CODE_ADMINISTRATEUR');
            $request->copilote_ed = 0;
        }
        $check1 = DB::select("SELECT count(id) as nbr FROM processuses WHERE code = ? AND id != ?", [$request->code_ed, $request->id])[0]->nbr;
        $check2 = DB::select("SELECT count(id) as nbr FROM processuses WHERE libelle = ? AND id != ?", [$request->libelle_ed, $request->id])[0]->nbr;

        if($check1 > 0 || $check2 > 0 ){
            session()->put('warning',custom_warning('W030'));
            return redirect("/documentaire/processus");
        }

                    /*  CHECKING  LOGIQUE APP  */
        $processus_old = Processus::find($request->id);

        if( $processus_old->nbr_procedure > $request->nbr_procedure_ed  ){
            $sesprocessus = DB::select("SELECT COUNT(id) as nbr FROM procedures WHERE processuses_id = ? AND statut=1", [$request->id]);
            if( $sesprocessus[0]->nbr >  $request->nbr_procedure_ed){
                session()->put('warning',custom_warning('W036'));
                return redirect("/documentaire/processus");
            }
        }

        if(isset($request->fichier_ed)){
            if($request->version_ed == $processus_old->version){
                session()->put('warning',custom_warning('W031'));
                return redirect("/documentaire/processus");
            }

                    /*  ARCHIVAGE DU OLD FICHIER */
            $insertArchive = DB::insert("INSERT INTO archives(type_archive, id_element, version, fichier, created_at, updated_at ) VALUES((SELECT id FROM type_archives WHERE libelle='Processus'), ?, ?, ?, NOW(), NOW())", [ $processus_old->id, $processus_old->version, $processus_old->fichier]);

            $fichier_ed = $request->fichier_ed;
            $fichier_ed = get_file_name_to_store($request,'fichier_ed', config('app.DOSSIER_PROCESSUS'). $request->code_ed, 'FIP.'.$request->version_ed, '' );
        }else{
            if($request->version_ed != $processus_old->version){
                session()->put('warning',custom_warning('W032'));
                return redirect("/documentaire/processus");
            }
        }
                    /*  TOUT EST BON, ON ENREGISTRE LES MODIFS */
        $processus_old->code = $request->code_ed;
        $processus_old->libelle = $request->libelle_ed;
        $processus_old->direction_code = $request->direction_ed;
        $processus_old->pilote = $request->pilote_ed;
        $processus_old->copilote = $request->copilote_ed;
        $processus_old->version = $request->version_ed;
        
        $processus_old->abreviation = $abreviation;
        $processus_old->nbr_procedure = $request->nbr_procedure_ed;
        if(isset($request->fichier_ed)){
            $processus_old->fichier = $fichier_ed;
        }
        //try {
            $processus_old->save();
        /*} catch (\Exception $e) {
            session()->put('error',custom_error($e->getMessage()));
        }*/

        afficherSuccess(custom_success(999));
        return redirect("/documentaire/processus");
    }


            //**--------------------------------------------------------------- */


    public function save_delete_processus(Request $request)
    {
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $now = get_date_from_now_to_DB();

        $processus_old = Processus::find($request->id);

        /*  ARCHIVAGE DU LAST FICHIER */
        try{
            $insertArchive = DB::insert("INSERT INTO archives(type_archive, id_element, version, fichier, created_at, updated_at ) VALUES((SELECT id FROM type_archives WHERE libelle='Processus'), ?, ?, ?, ?, ?)", [ $processus_old->id, $processus_old->version, $processus_old->fichier, $now, $now]);
        }catch(Exception $e){
            session()->put('error',custom_error('E022'));
            return redirect("/documentaire/processus");
        }

        /*  ARCHIVAGE DES PROCESSUS */
        //$processus = DB::select("SELECT * FROM procedures WHERE processuses_id = ?");



        /*  TOUT EST BON, ON SUPPRIME */
        try {
            $update = DB::update("UPDATE processuses set statut=0, updated_at=? WHERE id=?", [$now, $request->id]);
            /*
            $processus_old->statut = 0;
            $processus_old->save();
            */
        } catch (\Exception $e) {
            session()->put('error',custom_error('E021'));
        }

        afficherSuccess(custom_success(999));
        return redirect("/documentaire/processus");
    }


            //**--------------------------------------------------------------- */
        
    

/******************************************************************************************* */
/******************************************************************************************* */
//                              PROCEDURES
/******************************************************************************************* */
/******************************************************************************************* */

    // GO TO Procédures
    public function procedure(){
        if(check_session() =='no')
            return redirect('/'); 
        
        $procedures = DB::select("SELECT procedures.*, processuses.id as process_id, processuses.libelle as process_libelle, processuses.code as process_code, processuses.direction_code as direction_code FROM processuses, procedures WHERE procedures.statut = 1 AND procedures.processuses_id = processuses.id"); 

        //$processuss = Processus::all()->where('statut', 1);
        $processuss = DB::select("SELECT processuses.*, directions.code as direction, directions.libelle as direction_libelle FROM processuses, directions WHERE directions.code = processuses.direction_code ");
        $directions = Direction::all();
            
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_qhse.procedure")->with('procedures', $procedures)->with('processuss', $processuss)->with('directions', $directions);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }

               //**--------------------------------------------------------------- */


    public function save_add_procedure(Request $request)
    {
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $request->code =  strtoupper($request->code);
        $request->libelle =  strtoupper($request->libelle);
        $request->abreviation =  strtoupper($request->abreviation);

        /*  CHECkER */
        $decontruit = explode(".", $request->code);

        if( count($decontruit) != 4){
            session()->put('warning',custom_warning('W039'));
            return redirect("/documentaire/procedures");
        }
        

        $check1 = DB::select("SELECT count(id) as nbr FROM procedures WHERE code = ? ", [$request->code])[0]->nbr;
        $check2 = DB::select("SELECT count(id) as nbr FROM procedures WHERE libelle = ? ", [$request->libelle])[0]->nbr;
        $check3 = DB::select("SELECT count(id) as nbr FROM procedures WHERE abreviation = ? ", [$request->abreviation])[0]->nbr;

        if($check1 > 0 ){
            session()->put('warning',custom_warning('W033'));
            return redirect("/documentaire/procedures");
        }elseif($check2 > 0  ){
            session()->put('warning',custom_warning('W037'));
            return redirect("/documentaire/procedures");
        }elseif($check3 > 0 ){
            session()->put('warning',custom_warning('W038'));
            return redirect("/documentaire/procedures");
        }

        if(!isset($request->fichier)){
            session()->put('warning',custom_warning('W029'));
            return redirect("/documentaire/procedures");
        }

        /*  END CHECKER */
        
        //  FICHIER PROCEDURE
        $code_process = Processus::find( $request->processus );
        $fichier = $request->fichier;
        $fichier = get_file_name_to_store($request,'fichier', config('app.DOSSIER_PROCESSUS'). $code_process->code.'/'. $request->code, 'PR.'.$request->version, '' );
        
        try {
            $insert = DB::insert("INSERT INTO `procedures` (`id`, `processuses_id`, `code`, `libelle`, `version`, `fichier`,abreviation, nbr_enregistrement, `created_at`, `updated_at`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW());", [$request->processus, $request->code, $request->libelle, $request->version,  $fichier, $request->abreviation, $request->nbr_enregistrement]);
        } catch (\Exception $e) {
            //Storage::delete(config('app.DOSSIER_PROCESSUS'). $code_process->code.'/'. $request->code.'/'.$fichier);
            Storage::deleteDirectory(config('app.DOSSIER_PROCESSUS'). $code_process->code.'/'. $request->code);
            session()->put('error',custom_error($e->getMessage()));
        }

        afficherSuccess(custom_success(999));
        return redirect("/documentaire/procedures");
    }



/******************************************************************************************* */
/******************************************************************************************* */
//                              ENREGISTREMENT
/******************************************************************************************* */
/******************************************************************************************* */

    // GO TO Procédures
    public function enregistrements(){
        if(check_session() =='no')
            return redirect('/'); 

        
        $enregistrements = DB::select("SELECT enregistrements.*, procedures.id as procedure_id, procedures.libelle as procedure_libelle, procedures.code as procedure_code, processuses.id as process_id, processuses.code as process_code FROM enregistrements, procedures, processuses WHERE enregistrements.statut = 1 AND enregistrements.procedure_id = procedures.id AND procedures.processuses_id = processuses.id");

        $procedures = Procedure::all()->where('statut', 1);

        
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_qhse.enregistrements")->with('enregistrements', $enregistrements)->with('procedures', $procedures);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }


    //**--------------------------------------------------------------- */


    public function save_add_enregistrement(Request $request)
    {
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $request->code =  strtoupper($request->code);
        $request->libelle =  strtoupper($request->libelle);

        $check1 = DB::select("SELECT count(id) as nbr FROM enregistrements WHERE code = ? ", [$request->code])[0]->nbr;
        $check2 = DB::select("SELECT count(id) as nbr FROM enregistrements WHERE libelle = ? ", [$request->libelle])[0]->nbr;

        if($check1 > 0 || $check2 > 0 ){
            session()->put('warning',custom_warning('W033'));
            return redirect("/documentaire/enregistrements");
        }

        if(isset($request->fichier)){
            $code_procedure = Procedure::find( $request->procedure );
            $code_process = Processus::find( $code_procedure->processuses_id );
            $fichier = $request->fichier;
            $fichier = get_file_name_to_store($request,'fichier', config('app.DOSSIER_PROCESSUS'). $code_process->code.'/'. $code_procedure->code, 'ENR.'.$request->version, '' );
        }else{
            session()->put('warning',custom_warning('W029'));
            return redirect("/documentaire/enregistrements");
        }
        
        try {
            $insert = DB::insert("INSERT INTO `enregistrements` (`id`, `procedure_id`, `code`, `libelle`, `version`, `fichier`, `created_at`, `updated_at`) VALUES (NULL, ?, ?, ?, ?, ?, NOW(), NOW());", [$request->procedure, $request->code, $request->libelle, $request->version,  $fichier]);
        } catch (\Exception $e) {
            session()->put('error',custom_error($e->getMessage()));
        }

        afficherSuccess(custom_success(999));
        return redirect("/documentaire/enregistrements");
    }




/******************************************************************************************* */
/******************************************************************************************* */
//                              ARCHIVAGE
/******************************************************************************************* */
/******************************************************************************************* */

    // GO TO ARCHIVAGE
    public function archivage(){
        if(check_session() =='no')
            return redirect('/'); 
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_qhse.archivage");
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }









/******************************************************************************************* */
/******************************************************************************************* */
//                              OTHER
/******************************************************************************************* */
/******************************************************************************************* */
/******************************************************************************************* */

    public function get_employe_of_direction(Request $request){

        if(check_session() =='no')
            return redirect('/'); 

        $employes = DB::select("SELECT employes.code, CONCAT(nom,' ',prenom) as nom_complet
        FROM employes, directions, employe_postes, postes 
        where employe_postes.code_emp = employes.code 
            AND employe_postes.statut = 'actif'
            AND postes.id = employe_postes.poste_id
            AND postes.direction_code =  directions.code
            AND directions.code = ?", [$request->direction]);
        return $employes;
    }


    public function get_pilotes_of_procedussus(Request $request){

        if(check_session() =='no')
            return redirect('/'); 

        $postes = DB::select("SELECT postes.id as code, postes.libelle as nom_complet
        FROM postes, directions, hierarchies
        where postes.direction_code =  directions.code
            AND hierarchie_id = hierarchies.id 
            AND (hierarchies.niveau = 3 OR hierarchies.niveau = 1)
            AND directions.code = ?", [$request->direction]);
        return $postes;
    }

    public function get_poste_of_direction(Request $request){

        if(check_session() =='no')
            return redirect('/'); 

        $postes = DB::select("SELECT postes.id as code, postes.libelle as nom_complet
        FROM postes, directions
        where postes.direction_code =  directions.code
            AND directions.code = ?", [$request->direction]);
        return $postes;
    }

    public function get_nbr_procedures_of_processus(Request $request){

        if(check_session() =='no')
            return redirect('/'); 

        $nbrProcedure = DB::select("SELECT COUNT(id) as nbr FROM procedures WHERE processuses_id = ? AND statut=1", [$request->id]);
        return $nbrProcedure;
    }

    public function get_processuses_of_direction(Request $request){

        if(check_session() =='no')
            return redirect('/'); 

        $processuses = DB::select("SELECT processuses.id as code, processuses.libelle as nom_complet, processuses.abreviation as abreviation
        FROM processuses
        where processuses.direction_code = ? AND statut=1", [$request->direction]);
        return $processuses;
    }

    public function get_data_for_this_procedure(Request $request){

        if(check_session() =='no')
            return redirect('/'); 

        $reference = $request->reference_actuel;
        $decontruit = explode(".", $reference);
        $finalNbrprocedure = "";
        $finalAbreviation = "";
        $retourner = [];

        $directionProcedure = DB::select("SELECT direction_code FROM processuses WHERE id = ?", [$request->data]);

        $typeProcedure = $this->get_typeprocedure_of_direction2($directionProcedure[0]->direction_code);

        $abreviationProcedure = DB::select("SELECT processuses.abreviation as abreviation FROM processuses WHERE id = ?", [$request->data]);
        
        $nbr_procedure = DB::select("SELECT nbr_procedure FROM processuses WHERE id = ?", [$request->data])[0]->nbr_procedure ;
        $nbrProcedureActuelle = DB::select("SELECT COUNT(id) as nbr FROM procedures WHERE processuses_id = ? AND statut=1", [$request->data])[0]->nbr ;

        if( $nbr_procedure == $nbrProcedureActuelle ){
            //$finalNbrprocedure == "";
            //return false;

            //$retourner['val'] = $decontruit[0].".".$decontruit[1].".".$decontruit[2];
            //$retourner['val'] = $decontruit[0].".".$decontruit[1];
            $retourner['val'] = $decontruit[0].'.';
            $retourner['success'] = 0;
            return $retourner;
            exit;
        }elseif( $nbr_procedure> $nbrProcedureActuelle){
            if($nbrProcedureActuelle < 10)
                $finalNbrprocedure = "0".($nbrProcedureActuelle+1);
            else
                $finalNbrprocedure = $nbrProcedureActuelle+1;
        }

        $finalAbreviation = $abreviationProcedure[0]->abreviation;
        
        /*  CREER LA REFERENCE NEW  */
        //if( count($decontruit) == 3 ){
        if( count($decontruit) == 2 ){

            if($finalNbrprocedure != ""){
                $retourner['val'] = $reference.$typeProcedure.".".$finalAbreviation.".". $finalNbrprocedure;
            }else{
                $retourner['val'] = $reference.$finalAbreviation;
            }
            $retourner['success'] = 1;

            return $retourner;
        //}elseif( count($decontruit) > 3 ){
        }elseif( count($decontruit) > 2 ){
            $ref = [];
            //for($i = 0; $i < 3; $i++ ){
            for($i = 0; $i < 2; $i++ ){
                if($i == 1){
                    $ref[$i] = $typeProcedure;
                }else{
                    $ref[$i] = $decontruit[$i];
                }
                
            }
            $List = implode('.', $ref);
            if($finalNbrprocedure != ""){
                $retourner['val'] = $List.".".$finalAbreviation.".". $finalNbrprocedure;
            }else{
                $retourner['val'] = $List.".".$finalAbreviation;
            }
            $retourner['success'] = 1;

            return $retourner;
        }
        
    }

    public function get_typeprocedure_of_direction(Request $request){

        if(check_session() =='no')
            return redirect('/'); 

        $type = DB::select("SELECT type_procedures.abreviation as type FROM type_procedures, directions WHERE directions.type_procedure = type_procedures.id AND directions.code = ?", [$request->direction]);
        if(isset($type)){
            return $type[0]->type;
        }
    }

    public function get_typeprocedure_of_direction2($val){

        if(check_session() =='no')
            return redirect('/'); 

        $type = DB::select("SELECT type_procedures.abreviation as type FROM type_procedures, directions WHERE directions.type_procedure = type_procedures.id AND directions.code = ?", [$val]);
        if(isset($type)){
            return $type[0]->type;
        }
    }
    
}
