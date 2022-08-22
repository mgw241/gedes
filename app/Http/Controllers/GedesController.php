<?php

namespace App\Http\Controllers;

use App\Models\Categorie_poste;
use App\Models\Civilite;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\Employe;
use App\Models\Form;
use App\Models\Groupe;
use App\Models\Hierarchie;
use App\Models\Pays;
use App\Models\Service;
use App\Models\User;
use App\Models\Utilisateur;
use App\Models\Ville;
use App\Models\Workflow_analyse;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class GedesController extends Controller
{

    /*****************************************************/
    //  Go to test
    public function test(){
        return view("test");
    }


/******************************************************************************************* */
/******************************************************************************************* */
    //  Go to LOGIN
    public function login(){
        return view("index");
    }

/******************************************************************************************* */
/******************************************************************************************* */
    //  Se LOGOUT
    public function se_logout(){
        session()->forget('user');
        session()->forget('permission');
        session()->flush();
        return redirect("/");
    }


/******************************************************************************************* */
/******************************************************************************************* */

    //  Go to Accueil
    public function home(){
        if(session()->has('user')){
            /*  TACHES  */
            $tacheTraiter = DB::select("SELECT COUNT(workflow_logs.id) as tache FROM workflow_logs WHERE workflow_logs.decision = 2 AND workflow_logs.code_emp_respo = ?",[session()->get('user')->code_user] )[0]->tache;

            $tacheSuspendues = DB::select("SELECT COUNT(workflow_logs.id) as tache FROM workflow_logs WHERE workflow_logs.decision = 5 AND workflow_logs.code_emp_respo = ?",[session()->get('user')->code_user] )[0]->tache;
            
            $tacheValide = DB::select("SELECT COUNT(workflow_logs.id) as tache FROM workflow_logs WHERE workflow_logs.decision = 1 AND workflow_logs.code_emp_respo = ?",[session()->get('user')->code_user] )[0]->tache;

            $tacheRejete = DB::select("SELECT COUNT(workflow_logs.id) as tache FROM workflow_logs WHERE workflow_logs.decision = 0 AND workflow_logs.code_emp_respo = ?",[session()->get('user')->code_user] )[0]->tache;

            /*  ACTIONS */

            $actionAttente = DB::select("SELECT COUNT(workflows.id) as attente
            FROM workflow_logs , workflows
            WHERE
                workflow_logs.decision = 2 
            AND
                workflow_logs.workflow_id = workflows.id
            AND
                workflows.code_emp_action = ?",[session()->get('user')->code_user] )[0]->attente;

            $actionValide = DB::select("SELECT COUNT(workflows.id)  as valide
            FROM workflow_logs , workflows
            WHERE
                workflow_logs.decision = 1
            AND
                workflow_logs.workflow_id = workflows.id
            AND
                workflows.code_emp_action = ?
            AND
                workflows.statut_w = 1
            AND 
                workflow_logs.workflow_statut = 1",[session()->get('user')->code_user] )[0]->valide;

            $actionSuspendues = DB::select("SELECT COUNT(workflows.id)  as valide
            FROM workflow_logs , workflows
            WHERE
                workflow_logs.decision = 5
            AND
                workflow_logs.workflow_id = workflows.id
            AND
                workflows.code_emp_action = ?
            AND
                workflows.statut_w = 0
            AND 
                workflow_logs.workflow_statut = 0",[session()->get('user')->code_user] )[0]->valide;

            $actionRejete = DB::select("SELECT COUNT(workflows.id)  as valide
            FROM workflow_logs , workflows
            WHERE
                workflow_logs.decision = 0
            AND
                workflow_logs.workflow_id = workflows.id
            AND
                workflows.code_emp_action = ?
            AND
                workflows.statut_w = 1
            AND 
                workflow_logs.workflow_statut = 1",[session()->get('user')->code_user] )[0]->valide;


            return view("layouts.accueil")  
                ->with("tacheTraiter", $tacheTraiter)
                ->with("tacheSuspendues", $tacheSuspendues)
                ->with("tacheValide", $tacheValide)
                ->with("tacheRejete", $tacheRejete)
                ->with("actionAttente", $actionAttente)
                ->with("actionValide", $actionValide)
                ->with("actionSuspendues", $actionSuspendues)
                ->with("actionRejete", $actionRejete);
        }
        else
            return redirect("/");
    }
    
/******************************************************************************************* */
/******************************************************************************************* */
    // Se Loger
    public function se_loger(Request $request){
        $username = explode('@', $request->email);
        try {
            if(connexion_adds($username['0']."", $request->password)){
                /*      VERIFICATION EXISTANCE DE l'USER'   */
                $user = DB::table('utilisateurs')->where('email', $request->email)->first();
                if($user != null){
                    /*      CREATION SESSION UTLISATEUR  */
                    //session()->put('user',$user);
                    $employe = DB::table('employes')->where('email', $request->email)->first();
                    //$employe = DB::select("SELECT employes.*, postes.categorie_code, postes.id FROM `employes`, postes, employe_postes WHERE employes.code = employe_postes.code_emp AND employe_postes.poste_id = postes.id AND employes.email = ?;", [$request->email]);
                    $user->image = ( $employe->image == NULL || $employe->image == "" || !isset( $employe->image) ? "no-user.jpg" : $employe->image);
                    $user->code_user = $employe->code;
                    $user->nom = $employe->nom;
                    //$user->poste_user = $employe[0]->poste;
                    //$user->cat_user = $employe[0]->cat;
                    session(['user' => $user]);
                }else{
                    session()->put('error',custom_error(0));
                    return redirect("/");
                }

                

                //echo  $user->image;
                return redirect("/home");
            }else{
                session()->put('error',custom_error(0));
                return redirect("/");
            }
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
            return redirect("/");
        }
        
    }

/******************************************************************************************* */
/******************************************************************************************* */


    //  Go to Group
    public function groupe(){
        
        $groups = Groupe::all()->where('actif',1);

        //$user = session()->get('user');
        //reresh_perssion(session()->get('user'), 'Groupes', 'ACCES');
        
        if(check_session() == 'no')
            return redirect('/'); 
        reresh_perssion(session()->get('user'), request()->url()) ;
        return return_view_after_check_read("layouts.groupe")->with('groupes', $groups);
        //return view("layouts.groupe")->with('groupes', $groups);

        //dd(session()->get('permission'));
        //print($nodeOfUrl.''.$formOfUrl);
    }

    //  Add Group
    public function add_group(Request $request){

        $group = new Groupe();
        $group->libelle = $request->libelle;
        try {
            $group->save();
        } catch (\Exception $e) {
            session()->put('error',custom_error($e->getMessage()));
        }

        try {
            $forms = Form::all();
            foreach ($forms as $key) {
                $group_form = DB::insert("INSERT INTO groupe_forms(group_id, form_id, `read`, `add`, `edit`, `delete`, created_at, updated_at) VALUES (?, ?, '0', '0', '0','0', NOW(), NOW())", [$group->id, $key->id]);
            }
        } catch (\Exception $e) {
            session()->put('error',custom_error($e->getMessage()));
        }

        afficherSuccess(custom_success(0));
        return redirect("/access/groupes");
        //print(session()->get('error'));
    }

    //  Delete Group
    public function delete_group(Request $request){

        $user = Utilisateur::all()->where('groupe_id', $request->idModal);
        if ($user->count() > 0){
            session()->put('error',custom_error(1));
            return redirect("/access/groupes");
        }
        $group = Groupe::find($request->idModal);
        $group->actif = '0';
        $group->save();

        afficherSuccess(custom_success(999));
        return redirect("/access/groupes");
    }

    //  Go to Edit Group
    public function edit_group($val){
        $group = Groupe::find($val);
        $permissions = DB::select('SELECT groupe_forms.*, forms.* 
                                    FROM groupe_forms, forms, groupes 
                                    WHERE groupe_forms.group_id = groupes.id
                                    AND groupes.id = ? 
                                    AND groupe_forms.form_id = forms.id ',
                                     [$val]) ;
        //dd($permissions);
        if(check_session() =='no')
            return redirect('/'); 
        reresh_perssion(session()->get('user'), request()->url());
        
        $notpermissions = DB::select('SELECT forms.* 
            FROM forms
        WHERE forms.id NOT IN (SELECT groupe_forms.form_id FROM groupe_forms where groupe_forms.group_id = ?)', [$val]);

        return return_view_after_check_read("layouts.editergroupe")->with('groupe', $group)->with('permissions', $permissions)->with('notpermissions', $notpermissions);
        //return view("layouts.editergroupe")->with('groupe', $group)->with('permissions', $permissions);
    }

    //  Edit Group
    public function save_edit_group(Request $request){

        $group = Groupe::find($request->idG);
        $group->libelle = $request->libelle;
        $group->save();
        //$maTableArray = $request->maTable->All();
        
        // Unescape the string values in the JSON array
        //$dataArray = stripcslashes($request->maTable);
        $dataArray = $request->maTable;
        $dataArray = json_decode($dataArray);
        
        foreach ($dataArray as $mydata) {
            $fg = explode('@', $mydata->form);
            $gr = $fg[0];
            $form = $fg[1];

            $mydata->read = str_replace("'", "",$mydata->read);
            $mydata->add = str_replace("'", "",$mydata->add);
            $mydata->edit = str_replace("'", "",$mydata->edit);
            $mydata->delete = str_replace("'", "",$mydata->delete);

            DB::update('UPDATE groupe_forms SET groupe_forms.read=?, groupe_forms.add=?, groupe_forms.edit=?, groupe_forms.delete=? WHERE group_id=? AND form_id=?', [$mydata->read, $mydata->add, $mydata->edit, $mydata->delete, $gr, $form]);
            afficherSuccess(custom_success(999));
            
            /*DB::update('UPDATE groupe_forms SET groupe_forms.read="1", groupe_forms.add="1", groupe_forms.edit="1", groupe_forms.delete="1" WHERE group_id=2 AND form_id=1;');*/
            
        }
        foreach ($dataArray as $mydata) {
            $fg = explode('@', $mydata->form);
            $gr = $fg[0];
            $form = $fg[1];

            $mydata->read = str_replace("'", "",$mydata->read);
            $mydata->add = str_replace("'", "",$mydata->add);
            $mydata->edit = str_replace("'", "",$mydata->edit);
            $mydata->delete = str_replace("'", "",$mydata->delete);

            $check = DB::select("SELECT COUNT(groupe_forms.group_id) as nbr FROM groupe_forms WHERE groupe_forms.group_id = ? AND groupe_forms.form_id = ?  ", [$gr, $form])[0]->nbr;

            try {
                if($check <= 0){
                    DB::update('INSERT INTO groupe_forms VALUES( ?, ?, ?, ?, ?, ?, NOW(), NOW() )', [$gr, $form, $mydata->read, $mydata->add, $mydata->edit, $mydata->delete]);
                    afficherSuccess(custom_success(999));
                }
            } catch (Exception $e) {
                session()->put('error',$e->getMessage());
            }
            
            /*DB::update('UPDATE groupe_forms SET groupe_forms.read="1", groupe_forms.add="1", groupe_forms.edit="1", groupe_forms.delete="1" WHERE group_id=2 AND form_id=1;');*/
            
        }
        //dd($dataArray);

        /*return redirect("/access/groupes");
        $group = new Groupe();
        $group->libelle = 'TOP';
        try {
            $group->save();
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
        }*/
        
        //return redirect("/access/groupes");
    }


/******************************************************************************************* */
/******************************************************************************************* */

    //  Show User
    public function showuser($user){
        if(check_session() =='no')
            return redirect('/'); 
        reresh_perssion(session()->get('user'), request()->url());
        return view('layouts.showuser');
    }

    //  Go to utilisateurs
    public function utilisateur(){
        //$users = Utilisateur::all()->where('actif',1);
        $users = DB::select(' SELECT utilisateurs.*, groupes.libelle as groupe_libelle FROM utilisateurs,groupes WHERE utilisateurs.groupe_id = groupes.id  AND utilisateurs.actif="1" ');

        $groups = Groupe::all()->where('actif',1);
        /*try {
            if(connexion_adds('daryl',2580))
                return view("layouts.utilisateur")->with('users', $users);
        } catch (Exception $e) {
            printf($e);
        }*/

        if(check_session() =='no')
            return redirect('/'); 
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts.utilisateur")->with('users', $users)->with('groupes', $groups);
        //return view("layouts.utilisateur")->with('users', $users)->with('groupes', $groups);
        
    }

    //  Add User
    public function add_user(Request $request){
        $this->validate($request, ['email' => 'required|unique:utilisateurs', 'nom' => 'required', 'groupe' => 'required']);
        //, 'image' => 'image|nullable|max:1999']

        $user = new Utilisateur();
        $user->email = $request->email;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->groupe_id = $request->groupe;
        try {
            $user->save();
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
        }

        afficherSuccess(custom_success(999));
        return redirect("/access/utilisateurs");
    }


    //  Edit User
    public function edituser($val){
        $groups = DB::select("SELECT libelle, id FROM groupes WHERE actif='1' ");
        $user = Utilisateur::find($val);
        if(check_session() =='no')
            return redirect('/'); 
        
        try {
            $user_code_emp = (DB::table('employes')->where('email', $user->email)->pluck('code'))[0];
        } catch (\Exception $e) {
            session()->put('warning',custom_warning('W021'));
            return back()->withInput();
        }
       
        $employeChefService = DB::select("SELECT e1.code, concat(e1.nom, ' ',e1.prenom) as nom_c, p1.libelle
        FROM employes e, postes p, employe_postes ep, employes e1, postes p1, employe_postes ep1
        WHERE e.code = ep.code_emp
        AND ep.poste_id = p.id
        AND e.code = ?
        
        AND e1.code = ep1.code_emp
        AND ep1.poste_id = p1.id
        AND p1.service_id = p.service_id
        
        
        AND p1.hierarchie_id = 5", [$user_code_emp]);

        $employeRespoDepartement = DB::select("SELECT e1.code, concat(e1.nom, ' ',e1.prenom) as nom_c, p1.libelle
        FROM employes e, postes p, employe_postes ep, employes e1, postes p1, employe_postes ep1
        WHERE e.code = ep.code_emp
        AND ep.poste_id = p.id
        AND e.code = ?
        
        AND e1.code = ep1.code_emp
        AND ep1.poste_id = p1.id
        AND p1.departement_code = p.departement_code
        
        
        AND p1.hierarchie_id = 4", [$user_code_emp]);

        $employeDirecteur = DB::select("SELECT e1.code, concat(e1.nom, ' ',e1.prenom) as nom_c , p1.libelle
        FROM employes e, postes p, employe_postes ep, employes e1, postes p1, employe_postes ep1
        WHERE e.code = ep.code_emp
        AND ep.poste_id = p.id
        AND e.code = ?
        
        AND e1.code = ep1.code_emp
        AND ep1.poste_id = p1.id
        AND p1.direction_code = p.direction_code
        
        AND p1.categorie_code = 'CAT2' ", [$user_code_emp]);

        $employeDRH = DB::select("SELECT e.code, concat(e.nom, ' ',e.prenom) as nom_c, p.libelle FROM employes e, postes p, employe_postes ep WHERE e.code = ep.code_emp AND ep.poste_id = p.id AND p.direction_code = 'DRH' AND p.categorie_code ='CAT2' ");

        $employeDG = DB::select("SELECT e.code, concat(e.nom, ' ',e.prenom) as nom_c, p.libelle
        FROM employes e, postes p, employe_postes ep
        WHERE e.code = ep.code_emp
        AND ep.poste_id = p.id
        AND p.direction_code = 'DG' 
        AND p.libelle = 'DIRECTEUR GENERAL' ");


        //dd($employeDirecteur);
        reresh_perssion(session()->get('user'), request()->url());
        return view('layouts.edituser')
            ->with('user', $user)->with('groupes', $groups)
            ->with('employeChefService', $employeChefService)
            ->with('employeRespoDepartement', $employeRespoDepartement)
            ->with('employeDirecteur', $employeDirecteur)
            ->with('employeDRH', $employeDRH)
            ->with('employeDG', $employeDG);
    }

    
    //  Save Edit User
    public function saveedituser(Request $request){

        $user = Utilisateur::find($request->valid);

        $this->validate($request, ['nom' => 'required', 'groupe' => 'required']);//, 'image' => 'image|nullable|max:1999'

        if (!isset($request->worklowuser)) {
            session()->put('warning',custom_warning('W003'));
            return redirect("/access/utilisateurs/edituser/$request->valid");
        }

        if ($request->hasFile('image')) {
            $fileNameWithExtension = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $request->email.''.time().'.'.$extension;
            
            //  Sotcker : Storage/app/public/
            $path = $request->file('image')->storeAs('public/users/images', $fileNameToStore);

            if ( $user->image != 'no-user.jpg') {
                Storage::delete('public/users/images/'.$user->image);
            }

        }else{
            $fileNameToStore = $user->image;
        }

        
        
        $user->email = $request->email;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->groupe_id = $request->groupe;
        
        try {
            $user->save();
        } catch (\Exception $e) {
            session()->put('error',custom_error($e->getMessage()));
        }

        /*$worklowuserString = "";
        foreach ($request->worklowuser as $value) {
            $worklowuserString = $worklowuserString."-".$value;
            //print($value);
        }*/

        $c_emp = (DB::table('employes')->where('email', $user->email)->pluck('code'))[0];
       
        if( Workflow_analyse::where("code_emp", $c_emp)->first() != null){
            $workfloanalyse = Workflow_analyse::where("code_emp", $c_emp)->first();
            $workfloanalyse->ordre_analyse_code_emp = $request->stringW;//$worklowuserString
            $workfloanalyse->save();
        }else{
            $workfloanalyse = new Workflow_analyse();
            $workfloanalyse->code_emp = $c_emp;
            $workfloanalyse->ordre_analyse_code_emp = $request->stringW;// $worklowuserString
            $workfloanalyse->save();
        }
        
        afficherSuccess(custom_success(999));
        return redirect("/access/utilisateurs");
    }

    //  Delete User
    public function delete_user(Request $request){

        $user = Utilisateur::find($request->idModal);
        $user->actif = '0';
        $user->save();

        afficherSuccess(custom_success(999));
        return redirect("/access/utilisateurs");
    }

    
/******************************************************************************************* */
/******************************************************************************************* */


    //  Go to Config DIRECTION
    public function configuration(){
        if(check_session() =='no')
            return redirect('/'); 
        
        $directions = Direction::all();
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_config.direction")->with("directions",$directions);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }
    //  ADD DIRECTION
    public function save_add_direction(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        
        $request->code =  strtoupper($request->code);
        $request->libelle =  strtoupper($request->libelle);

        $check1 = DB::select("SELECT count(code) as nbr FROM directions WHERE code = ? ", [$request->code])[0]->nbr;
        $check2 = DB::select("SELECT count(libelle) as nbr FROM directions WHERE libelle = ? ", [$request->libelle])[0]->nbr;

        if($check1 > 0){
            session()->put('warning',custom_warning('W009'));
            return redirect("/configuration/configuration/");
        }
        if($check2 > 0){
            session()->put('warning',custom_warning('W010'));
            return redirect("/configuration/configuration/");
        }
        
        try {
            $insert = DB::insert("INSERT INTO `directions` (`code`, `libelle`, `created_at`, `updated_at`) VALUES (?, ?, NOW(), NOW());", [$request->code, $request->libelle]);
        } catch (\Exception $e) {
            session()->put('error',custom_error($e->getMessage()));
        }

        afficherSuccess(custom_success(999));
        return redirect("/configuration/configuration/");

    }

    //  EDIT DIRECTION
    public function save_edit_direction(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        
        
        $request->libelle_ed =  strtoupper($request->libelle_ed);
        $check2 = DB::select("SELECT count(libelle) as nbr FROM directions WHERE libelle = ? ", [$request->libelle_ed])[0]->nbr;

        if($check2 > 0){
            session()->put('warning',custom_warning('W010'));
            return redirect("/configuration/configuration/");
        }
        try {
            $item = DB::update("UPDATE directions SET libelle = ? WHERE code=?", [$request->libelle_ed, $request->code_ed]);
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
        }

        afficherSuccess(custom_success(999));
        return redirect("/configuration/configuration/");

    }

    //  DELETE DIRECTION
    public function save_delete_direction(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        
        //print($request->code_del);
        $check1 = DB::select("SELECT count(code) as nbr FROM departements WHERE direction_code = ? ", [$request->code_del])[0]->nbr;
        if($check1 > 0){
            session()->put('warning',custom_warning('W011'));
            return redirect("/configuration/configuration/");
        }

        try {
            $item = DB::update("DELETE FROM directions WHERE code=?", [$request->code_del]);
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
        } 
        
        afficherSuccess(custom_success(999));
        return redirect("/configuration/configuration/");
        
    }

/******************************************************************************************* */
/******************************************************************************************* */


    //  Go to Config DEPARTEMENT
    public function configuration_departement(){
        if(check_session() =='no')
            return redirect('/'); 
            
        $directions = Direction::pluck('code', 'libelle');;
        $departements = Departement::select("*")->orderByRaw("libelle")->get();
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_config.departement")->with("departements",$departements)->with("directions",$directions);
        
    }

        //  ADD DEPARTEMENT
        public function save_add_departement(Request $request){
            if(check_session() =='no')
                return redirect('/'); 
            
            $request->code =  strtoupper($request->code);
            //$request->libelle =  strtoupper($request->libelle);
    
            $check1 = DB::select("SELECT count(code) as nbr FROM departements WHERE code = ? ", [$request->code])[0]->nbr;
            $check2 = DB::select("SELECT count(libelle) as nbr FROM departements WHERE libelle = ? ", [$request->libelle])[0]->nbr;
    
            if($check1 > 0){
                session()->put('warning',custom_warning('W012'));
                return redirect("/configuration/configuration/departement");
            }
            if($check2 > 0){
                session()->put('warning',custom_warning('W013'));
                return redirect("/configuration/configuration/departement");
            }
            //print($request->code." ".$request->code_direction." ".$request->libelle);
            
            try {
                $insert = DB::insert("INSERT INTO `departements` (`code`, `libelle`, `direction_code`, `created_at`, `updated_at`) VALUES (?, ?, ?, NOW(), NOW());", [$request->code, $request->libelle, $request->code_direction]);
            } catch (\Exception $e) {
                session()->put('error',custom_error($e->getMessage()));
            }
    
            afficherSuccess(custom_success(999));
            return redirect("/configuration/configuration/departement");
    
        }
    
        //  EDIT DEPARTEMENT
        public function save_edit_departement(Request $request){
            if(check_session() =='no')
                return redirect('/'); 
            
            
            $request->libelle_ed =  strtoupper($request->libelle_ed);
            $check2 = DB::select("SELECT count(libelle) as nbr FROM departements WHERE libelle = ? ", [$request->libelle_ed])[0]->nbr;
    
            if($check2 > 0){
                session()->put('warning',custom_warning('W013'));
                return redirect("/configuration/configuration/departement");
            }
            try {
                $item = DB::update("UPDATE departements SET libelle = ? WHERE code=?", [$request->libelle_ed, $request->code_ed]);
            } catch (\Exception $e) {
                session()->put('error',$e->getMessage());
            }
    
            afficherSuccess(custom_success(999));
            return redirect("/configuration/configuration/departement");
    
        }
        
        //  DELETE DEPARTEMENT
        public function save_delete_departement(Request $request){
            if(check_session() =='no')
                return redirect('/'); 
            
            //print($request->code_del);
            $check1 = DB::select("SELECT count(id) as nbr FROM services WHERE departement_code = ? ", [$request->code_del])[0]->nbr;
            if($check1 > 0){
                session()->put('warning',custom_warning('W014'));
                return redirect("/configuration/configuration/departement");
            }
    
            try {
                $item = DB::update("DELETE FROM departements WHERE code=?", [$request->code_del]);
            } catch (\Exception $e) {
                session()->put('error',$e->getMessage());
            } 
            
            afficherSuccess(custom_success(999));
            return redirect("/configuration/configuration/departement");
            
        }
/******************************************************************************************* */
/******************************************************************************************* */


    //  Go to Config SERVICE
    public function configuration_service(){
        if(check_session() =='no')
            return redirect('/'); 
            
        $departements = Departement::pluck( 'libelle', 'code');
        $directions = Direction::pluck( 'libelle', 'code');
        $services = DB::select("SELECT services.id, services.departement_code, services.libelle, departements.libelle as lib_dep, directions.code as direction FROM services, departements, directions WHERE departements.code = services.departement_code AND directions.code = departements.direction_code ORDER BY services.libelle");// Service::select("*")->orderByRaw("libelle")->get();
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_config.service")->with("services",$services)->with("departements",$departements)->with("directions",$directions);
        
    }



        //  ADD SERVICE
        public function save_add_service(Request $request){
            if(check_session() =='no')
                return redirect('/'); 
            
            $request->code =  strtoupper($request->code);
            //$request->libelle =  strtoupper($request->libelle);
    
            $check2 = DB::select("SELECT count(libelle) as nbr FROM services WHERE libelle = ? AND departement_code = ? ", [$request->libelle, $request->departement])[0]->nbr;
    
            if($check2 > 0){
                session()->put('warning',custom_warning('W015'));
                return redirect("/configuration/configuration/service");
            }
            //print($request->code." ".$request->code_direction." ".$request->libelle);
            
            try {
                $insert = DB::insert("INSERT INTO `services` ( `libelle`, `departement_code`, `created_at`, `updated_at`) VALUES (?, ?, NOW(), NOW());", [$request->libelle, $request->departement]);
            } catch (\Exception $e) {
                session()->put('error',custom_error($e->getMessage()));
            }
    
            afficherSuccess(custom_success(999));
            return redirect("/configuration/configuration/service");
    
        }
    
        //  EDIT SERVICE
        public function save_edit_service(Request $request){
            if(check_session() =='no')
                return redirect('/'); 
            
            
            //$request->libelle_ed =  strtoupper($request->libelle_ed);
            $check2 = DB::select("SELECT count(libelle) as nbr FROM services WHERE libelle = ? ", [$request->libelle_ed])[0]->nbr;
    
            if($check2 > 0){
                session()->put('warning',custom_warning('W013'));
                return redirect("/configuration/configuration/service");
            }
            try {
                $item = DB::update("UPDATE services SET libelle = ? WHERE id=?", [$request->libelle_ed, $request->code_ed]);
            } catch (\Exception $e) {
                session()->put('error',$e->getMessage());
            }
    
            afficherSuccess(custom_success(999));
            return redirect("/configuration/configuration/service");
    
        }
        
        //  DELETE SERVICE
        public function save_delete_service(Request $request){
            if(check_session() =='no')
                return redirect('/'); 
            
            //print($request->code_del);
            $check1 = DB::select("SELECT count(id) as nbr FROM postes WHERE service_id = ? ", [$request->code_del])[0]->nbr;
            if($check1 > 0){
                session()->put('warning',custom_warning('W016'));
                return redirect("/configuration/configuration/service");
            }
    
            try {
                $item = DB::update("DELETE FROM services WHERE id=?", [$request->code_del]);
            } catch (\Exception $e) {
                session()->put('error',$e->getMessage());
            } 
            
            afficherSuccess(custom_success(999));
            return redirect("/configuration/configuration/service");
        }

/******************************************************************************************* */
/******************************************************************************************* */


    //  Go to Config POSTE
    public function configuration_poste(){
        if(check_session() =='no')
            return redirect('/'); 
            
        $directions = Direction::pluck( 'code', 'code');
        $hierarches = Hierarchie::pluck( 'libelle', 'id');
        $postes = DB::select("SELECT postes.*, services.libelle as service, departements.libelle as lib_dep, hierarchies.libelle as lib_hier 
            FROM postes, services, departements, directions, hierarchies
                WHERE departements.code = postes.departement_code AND directions.code = postes.direction_code AND postes.service_id = services.id AND hierarchies.id = postes.hierarchie_id ORDER BY `postes`.`libelle` ASC");
        $categories = Categorie_poste::pluck( 'code', 'code');
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_config.poste")->with("postes",$postes)->with("directions",$directions)->with("categories",$categories)->with("hierarches",$hierarches);
        
    }


        //  ADD POSTE
        public function save_add_poste(Request $request){
            if(check_session() =='no')
                return redirect('/'); 
            
            $request->code =  strtoupper($request->code);
            //$request->libelle =  strtoupper($request->libelle);
    
            $check2 = DB::select("SELECT count(libelle) as nbr FROM postes WHERE libelle = ?", [$request->libelle])[0]->nbr;
    
            if($check2 > 0){
                session()->put('warning',custom_warning('W017'));
                return redirect("/configuration/configuration/poste");
            }
            //print($request->code." ".$request->code_direction." ".$request->libelle);
            
            try {
                $insert = DB::insert("INSERT INTO `postes` (`libelle`, `direction_code`, `departement_code`, `service_id`, `description`, `categorie_code`, `hierarchie_id`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW());", [$request->libelle, $request->direction, $request->departement, $request->service, $request->description, $request->categorie, $request->hierarchie]);
            } catch (\Exception $e) {
                session()->put('error',custom_error($e->getMessage()));
            }
    
            afficherSuccess(custom_success(999));
            return redirect("/configuration/configuration/poste");
    
        }
    
        //  EDIT POSTE
        public function save_edit_poste(Request $request){
            if(check_session() =='no')
                return redirect('/'); 
            
            
            //$request->libelle_ed =  strtoupper($request->libelle_ed);
            $check2 = DB::select("SELECT count(libelle) as nbr FROM postes WHERE libelle = ? ", [$request->libelle_ed])[0]->nbr;
    
            if($check2 > 0){
                session()->put('warning',custom_warning('W017'));
                return redirect("/configuration/configuration/poste");
            }
            try {
                $item = DB::update("UPDATE postes SET libelle = ?, hierarchie_id=?,description=?, categorie_code=?  WHERE id=?", [$request->libelle_ed, $request->hierarchie_ed, $request->description_ed, $request->categorie_ed, $request->code_ed]);
            } catch (\Exception $e) {
                session()->put('error',$e->getMessage());
            }
    
            afficherSuccess(custom_success(999));
            return redirect("/configuration/configuration/poste");
    
    //print($request->hierarchie_ed);
        }
        
        //  DELETE POSTE
        public function save_delete_poste(Request $request){
            if(check_session() =='no')
                return redirect('/'); 
            
            //print($request->code_del);
            $check1 = DB::select("SELECT count(id) as nbr FROM employe_postes WHERE poste_id = ? ", [$request->code_del])[0]->nbr;
            if($check1 > 0){
                session()->put('warning',custom_warning('W018'));
                return redirect("/configuration/configuration/poste");
            }
    
            try {
                $item = DB::update("DELETE FROM postes WHERE id=?", [$request->code_del]);
            } catch (\Exception $e) {
                session()->put('error',$e->getMessage());
            } 
            
            afficherSuccess(custom_success(999));
            return redirect("/configuration/configuration/poste");
        }

/******************************************************************************************* */
/******************************************************************************************* */


    //  Go to Config PAYS
    public function configuration_pays(){
        if(check_session() =='no')
            return redirect('/'); 
        
        $pays = Pays::all();
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_config.pays")->with("Pays",$pays);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }

    //  ADD PAYS
    public function save_add_pays(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        
        $request->code =  strtoupper($request->code);
        $request->libelle =  ucfirst($request->libelle);

        $check1 = DB::select("SELECT count(code) as nbr FROM pays WHERE code = ? ", [$request->code])[0]->nbr;
        $check2 = DB::select("SELECT count(libelle) as nbr FROM pays WHERE libelle = ? ", [$request->libelle])[0]->nbr;

        if($check1 > 0){
            session()->put('warning',custom_warning('W024'));
            return redirect("/configuration/configuration/pays");
        }
        if($check2 > 0){
            session()->put('warning',custom_warning('W025'));
            return redirect("/configuration/configuration/pays");
        }
        
        try {
            $insert = DB::insert("INSERT INTO `pays` (`code`, `libelle`, `created_at`, `updated_at`) VALUES (?, ?, NOW(), NOW());", [$request->code, $request->libelle]);
        } catch (\Exception $e) {
            session()->put('error',custom_error($e->getMessage()));
        }

        afficherSuccess(custom_success(999));
        return redirect("/configuration/configuration/pays");

    }

    //  EDIT PAYS
    public function save_edit_pays(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        
        
        $request->libelle_ed =  ucfirst($request->libelle_ed);
        $request->code_ed =  strtoupper($request->code_ed);

        $check2 = DB::select("SELECT count(libelle) as nbr FROM pays WHERE libelle = ? ", [$request->libelle_ed])[0]->nbr;

        if($check2 > 0){
            session()->put('warning',custom_warning('W025'));
            return redirect("/configuration/configuration/pays");
        }
        try {
            $item = DB::update("UPDATE pays SET libelle = ?, code = ? WHERE libelle=?", [$request->libelle_ed, $request->code_ed, $request->libelle_ed_old]);
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
        }

        afficherSuccess(custom_success(999));
        return redirect("/configuration/configuration/pays");
        //echo $request->libelle_ed.' '.$request->code_ed;

    }

    //  DELETE PAYS
    public function save_delete_pays(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        

        try {
            $item = DB::update("DELETE FROM pays WHERE libelle=?", [$request->libelle_del]);
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
        } 
        
        afficherSuccess(custom_success(999));
        return redirect("/configuration/configuration/pays");
        
    }


/******************************************************************************************* */
/******************************************************************************************* */


    //  Go to Config VILLE
    public function configuration_ville(){
        if(check_session() =='no')
            return redirect('/'); 
        
        $pays = Pays::pluck('libelle', 'code');
        $villes = Ville::all();
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_config.ville")->with("pays",$pays)->with("villes",$villes);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }

    //  ADD VILLE
    public function save_add_ville(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        
        $request->pays =  ucfirst($request->pays);
        $request->libelle =  ucfirst($request->libelle);

        $check2 = DB::select("SELECT count(libelle) as nbr FROM pays WHERE libelle = ? ", [$request->libelle])[0]->nbr;

        if($check2 > 0){
            session()->put('warning',custom_warning('W027'));
            return redirect("/configuration/configuration/ville");
        }
        
        try {
            $insert = DB::insert("INSERT INTO `villes` (`libelle`,`pays`, `created_at`, `updated_at`) VALUES (?, ?, NOW(), NOW());", [$request->libelle, $request->pays]);
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
        }

        afficherSuccess(custom_success(999));
        return redirect("/configuration/configuration/ville");

    }

    //  EDIT VILLE
    public function save_edit_ville(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        
        
        $request->libelle_ed =  ucfirst($request->libelle_ed);
        $request->pays_ed =  strtoupper($request->pays_ed);

        $check2 = DB::select("SELECT count(libelle) as nbr FROM villes WHERE libelle = ? ", [$request->libelle_ed])[0]->nbr;

        if($check2 > 0){
            session()->put('warning',custom_warning('W025'));
            return redirect("/configuration/configuration/ville");
        }
        try {
            $item = DB::update("UPDATE villes SET libelle = ?, pays = ? WHERE id = ?", [$request->libelle_ed, $request->pays_ed, $request->id_ed]);
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
        }

        afficherSuccess(custom_success(999));
        return redirect("/configuration/configuration/ville");
        //echo $request->libelle_ed.' '.$request->code_ed;

    }

    //  DELETE VILLE
    public function save_delete_ville(Request $request){
        if(check_session() =='no')
            return redirect('/'); 

        try {
            $item = DB::delete("DELETE FROM villes WHERE id=?", [$request->id_del]);
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
        } 
        
        afficherSuccess(custom_success(999));
        return redirect("/configuration/configuration/ville");
        
    }


/* ****************************************************************************************** */
/* ****************************************************************************************** */


    //  Go to Config TYPE DOCUMENTS
    public function configuration_type_document(){
        if(check_session() =='no')
            return redirect('/'); 
        
        $type_documents = DB::select("SELECT * FROM document_employe_types");
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_config.type_document")->with("type_documents",$type_documents);
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }

    //  ADD VILLE
    public function save_add_type_document(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        
        $request->libelle =  ucfirst($request->libelle);

        $check2 = DB::select("SELECT count(libelle) as nbr FROM document_employe_types WHERE libelle = ? ", [$request->libelle])[0]->nbr;

        if($check2 > 0){
            session()->put('warning',custom_warning('W037'));
            return redirect("/configuration/configuration/type_document");
        }
        
        try {
            $insert = DB::insert("INSERT INTO `document_employe_types` (`libelle`, `created_at`, `updated_at`) VALUES (?, NOW(), NOW());", [$request->libelle]);
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
        }

        afficherSuccess(custom_success(999));
        return redirect("/configuration/configuration/type_document");

    }

    //  EDIT VILLE
    public function save_edit_type_document(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        
        
        $request->libelle_ed =  ucfirst($request->libelle_ed);

        $check2 = DB::select("SELECT count(libelle) as nbr FROM document_employe_types WHERE libelle = ? ", [$request->libelle_ed])[0]->nbr;

        if($check2 > 0){
            session()->put('warning',custom_warning('W037'));
            return redirect("/configuration/configuration/type_document");
        }
        try {
            $item = DB::update("UPDATE document_employe_types SET libelle = ? WHERE id = ?", [$request->libelle_ed, $request->id_ed]);
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
        }

        afficherSuccess(custom_success(999));
        return redirect("/configuration/configuration/type_document");
        //echo $request->libelle_ed.' '.$request->code_ed;

    }

    //  DELETE VILLE
    public function save_delete_type_document(Request $request){
        if(check_session() =='no')
            return redirect('/'); 

        $check2 = DB::select("SELECT count(*) as nbr FROM document_employes WHERE type_id = ? ", [$request->id_del])[0]->nbr;
        if($check2 > 0){
            session()->put('warning',custom_warning('W047'));
            return redirect("/configuration/configuration/type_document");
        }
        try {
            $item = DB::delete("DELETE FROM document_employe_types WHERE id=?", [$request->id_del]);
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
        } 
        
        afficherSuccess(custom_success(999));
        return redirect("/configuration/configuration/type_document");
        
    }


/******************************************************************************************* */
/******************************************************************************************* */


    //  Go to Config CIVILITE
    public function configuration_civilite(){
        if(check_session() =='no')
            return redirect('/'); 
            
        $civilites = Civilite::all();
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_config.civilite")->with("civilites",$civilites);
        
    }


/******************************************************************************************* */
/******************************************************************************************* */


    //  Go to Config MONITEURS PARC AUTOMOBILE
    public function configuration_m_parc_auto(){
        if(check_session() =='no')
            return redirect('/'); 
            
        $moniteurs = DB::select("SELECT moniteur_parc_autos.id, concat(employes.nom, ' ',employes.prenom) as nom_complet FROM employes, moniteur_parc_autos WHERE code_emp = code ");
        $employes = DB::select("SELECT concat(employes.nom, ' ',employes.prenom) as nom_complet, employes.code FROM employes WHERE etat_activite = 'actif' AND code != ? AND employes.code NOT IN (SELECT code_emp from moniteur_parc_autos)", [config('app.CODE_ADMINISTRATEUR')]);
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_config.m_parc_auto")->with("moniteurs",$moniteurs)->with("employes",$employes);
        
    }

    //  ADD MONITEURS PARC AUTOMOBILE
    public function save_add_m_parc_auto(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
        
        $check2 = DB::select("SELECT count(id) as nbr FROM moniteur_parc_autos WHERE code_emp = ? ", [$request->employe])[0]->nbr;

        if($check2 > 0){
            session()->put('warning',custom_warning('W047'));
            return redirect("/configuration/configuration/m_parc_auto");
        }
        
        try {
            $insert = DB::insert("INSERT INTO `moniteur_parc_autos` (`code_emp`,`created_at`, `updated_at`) VALUES (?, NOW(), NOW());", [$request->employe]);
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
        }

        afficherSuccess(custom_success(999));
        return redirect("/configuration/configuration/m_parc_auto");

    }

    //  DELETE MONITEURS PARC AUTOMOBILE
    public function save_delete_m_parc_auto(Request $request){
        if(check_session() =='no')
            return redirect('/'); 

        try {
            $item = DB::delete("DELETE FROM moniteur_parc_autos WHERE id=?", [$request->id_del]);
        } catch (\Exception $e) {
            session()->put('error',$e->getMessage());
        } 
        
        afficherSuccess(custom_success(999));
        return redirect("/configuration/configuration/m_parc_auto");
        
    }

    
/******************************************************************************************* */
/******************************************************************************************* */


    //  GET DEPT OF DIRECTION
    public function get_departements_of_direction(Request $request){
        if(check_session() =='no')
            return redirect('/'); 
            
        $departements = DB::select('SELECT departements.libelle,departements.code FROM departements WHERE direction_code=?',[$request->code]);
        return $departements;
        
    }


/******************************************************************************************* */
/******************************************************************************************* */

public function get_service_of_departement(Request $request){
    if(check_session() =='no')
        return redirect('/'); 

    $services = DB::select('SELECT services.libelle,services.id FROM services WHERE services.departement_code=?',[$request->code]);
    return $services;
}
/******************************************************************************************* */
/******************************************************************************************* */

    public function getnotificationtache(){

        if(session()->has('user')){
            $TacheTraiter = DB::select("SELECT COUNT(workflow_logs.id) as tache FROM workflow_logs WHERE workflow_logs.decision = 2 AND workflow_logs.code_emp_respo = ?",[session()->get('user')->code_user] )[0]->tache;
            $data =  $TacheTraiter;   
            header('Content-type: application/json');
            echo json_encode($data);
        }else
            return redirect("/");
    }
    public function getnotificationmessage(){

        if(session()->has('user')){
            $MessageTraiter = DB::select("SELECT COUNT(messages.id) as message FROM messages WHERE emp_getter = ? AND lecture = 0",[session()->get('user')->code_user] )[0]->message;
            $data =  $MessageTraiter;   
            header('Content-type: application/json');
            echo json_encode($data);
        }else
            return redirect("/");
    }
/******************************************************************************************* */
/******************************************************************************************* */

    public function get_hierarchies(Request $request){

        if(check_session() =='no')
        return redirect('/'); 

        $hier = DB::select('SELECT hierarchies.libelle,hierarchies.id FROM hierarchies ');
        return $hier;
    }

/******************************************************************************************* */
/******************************************************************************************* */

    public function get_ville_of_pays(Request $request){

        if(check_session() =='no')
        return redirect('/'); 

        $villes = DB::select('SELECT villes.libelle,villes.id FROM villes where pays=? ', [$request->pays]);
        return $villes;
    }


}
