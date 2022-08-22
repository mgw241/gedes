<?php

namespace App\Http\Controllers;

use App\Mail\LgtExpiration;
use App\Mail\SimpleEmail;
use App\Models\Vehicule;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LogisticController extends Controller
{

   /**********************************************************************************************************************************   
    *   ----------------------------------------------------    /
    *   ----------------------------------------------------    /
    *                   PARC AUTOMOBILE
    */

    // GO TO Parc Automobile
    public function parc_automobile(){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        //$vehicules = DB::select("SELECT vehicules.*, modele_vehicules.libelle, marque_vehicules.libelle FROM vehicules, modele_vehicules, marque_vehicules WHERE vehicules.modele = modele_vehicules.id AND vehicules.marque = marque_vehicules.id");
        $vehicules = DB::select("SELECT vehicules.*, marque_vehicules.libelle as libelle_marque FROM vehicules, marque_vehicules WHERE vehicules.marque = marque_vehicules.id");

        $marques = DB::select("SELECT * FROM marque_vehicules");
        $modeles = DB::select("SELECT * FROM modele_vehicules");
        $genres = DB::select("SELECT * FROM vehicule_genres");
        $sources = DB::select("SELECT * FROM vehicule_sources");

        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_lgt.parc_automobile")->with('vehicules', $vehicules)->with('marques', $marques)->with('modeles', $modeles)->with('genres', $genres)->with('sources', $sources);

    }

    //  Add Vehicule
    public function save_add_vehicule(Request $request){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $request->matricule  = $matricule = strtoupper($request->matricule);
        $request->serie =  strtoupper($request->serie);
        $request->modele =  strtoupper($request->modele);

        $check1 = DB::select("SELECT count(matricule) as nbr FROM vehicules WHERE matricule = ? ", [$matricule])[0]->nbr;
        $check2 = DB::select("SELECT count(matricule) as nbr FROM vehicules WHERE numero_serie = ? ", [$request->serie])[0]->nbr;

        //  CHECKER
        if($check1 > 0  ){
            session()->put('warning',custom_warning('W039'));
            return redirect("/logistique_securite/parc_automobile");
        }else if($check2 > 0 ){
            session()->put('warning',custom_warning('W040'));
            return redirect("/logistique_securite/parc_automobile");
        }

        //  IMAGES
        if(isset($request->image1)){
            $fichier1 = $request->fichier;
            $fichier1 = get_file_name_to_store($request,'image1', config('app.DOSSIER_PARC_AUTO'). $request->matricule, 'avant', '' );
        }else{
            $fichier1 = null;
        }
        if(isset($request->image2)){
            $fichier2 = $request->fichier;
            $fichier2 = get_file_name_to_store($request,'image2', config('app.DOSSIER_PARC_AUTO'). $request->matricule, 'gauche', '' );
        }else{
            $fichier2 = null;
        }
        if(isset($request->image3)){
            $fichier3 = $request->fichier;
            $fichier3 = get_file_name_to_store($request,'image3', config('app.DOSSIER_PARC_AUTO'). $request->matricule, 'arriere', '' );
        }else{
            $fichier3 = null;
        }
        if(isset($request->image4)){
            $fichier4 = $request->fichier;
            $fichier4 = get_file_name_to_store($request,'image4', config('app.DOSSIER_PARC_AUTO'). $request->matricule, 'interieur_droite', '' );
        }else{
            $fichier4 = null;
        }

        //  INSERTION
        
        try {
            $insert = DB::insert("INSERT INTO `vehicules` (`matricule`, `modele`, `marque`, `nom`, `numero_serie`, `genre`, `source`, `puissance`, `nbr_place`, `charge`, `poids_a_vide`, `date_achat`, `date_mise_circulation`, `valeur`, `km_actuel`, `km_vidanger`, `km_alerte1`, `km_alerte2`, `crique`, `cle_a_roue`, `calle_metal`, `trousseaum`, `baladeuse`, `sangle`, `gilet`, `triangle`, `tracker`, `image1`, `image2`, `image3`, `image4`, `created_at`, `updated_at`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', '0', '0', '0', '0', '0', '0', '0', '0', ?, ?, ?, ?, NOW(), NOW());", [$request->matricule, $request->modele,  $request->marque,  $request->nom,  $request->serie,  $request->genre,  $request->source,  $request->puissance,  $request->nbr_place,  $request->charge,  $request->poids_vide,  $request->date_achat,  $request->date_mise_circulation,  $request->valeur,  $request->km_actuel,  $request->km_vidange,  $request->alerte1,  $request->alerte2,  $fichier1,  $fichier2, $fichier3, $fichier4]);
        } catch (\Exception $e) {
            session()->put('error',custom_error($e->getMessage()));
            return redirect("/logistique_securite/parc_automobile");
        }

        afficherSuccess(custom_success(999));
        return redirect("/logistique_securite/parc_automobile");

    }

    //  Go To Vehicule
    public function vehicule_show_identification($val){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT vehicules.*, marque_vehicules.libelle as libelle_marque, vehicule_genres.libelle as libelle_genre, vehicule_sources.libelle as libelle_source FROM vehicules, marque_vehicules, vehicule_genres, vehicule_sources WHERE vehicules.marque = marque_vehicules.id AND vehicule_genres.id = genre AND vehicule_sources.id = source AND matricule=?", [$val]);

        $marques = DB::select("SELECT * FROM marque_vehicules");
        $modeles = DB::select("SELECT * FROM modele_vehicules");
        $genres = DB::select("SELECT * FROM vehicule_genres");
        $sources = DB::select("SELECT * FROM vehicule_sources");

        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_lgt.vehicule_show_identification")->with('vehicule', $vehicule)->with('marques', $marques)->with('modeles', $modeles)->with('genres', $genres)->with('sources', $sources);

    }

    //  Go To Vehicule affectation
    public function vehicule_show_affectation($val){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT vehicules.*, marque_vehicules.libelle as libelle_marque, vehicule_genres.libelle as libelle_genre, vehicule_sources.libelle as libelle_source FROM vehicules, marque_vehicules, vehicule_genres, vehicule_sources WHERE vehicules.marque = marque_vehicules.id AND vehicule_genres.id = genre AND vehicule_sources.id = source AND matricule=?", [$val]);

        $affectations = DB::select("SELECT affectation_vehicules.*, concat(employes.nom, ' ',employes.prenom) as nom_complet FROM affectation_vehicules, employes WHERE employes.code = employe_code AND matricule_vh = ?", [$val]);

        $affectation_actuel = DB::select("SELECT affectation_vehicules.*, concat(employes.nom, ' ',employes.prenom) as nom_complet FROM affectation_vehicules, employes WHERE employes.code = employe_code AND matricule_vh = ? AND date_debut = (SELECT MAX(date_debut) FROM affectation_vehicules WHERE matricule_vh = ?)", [$val, $val]);

        $employes = DB::select("SELECT concat(employes.nom, ' ',employes.prenom) as nom_complet, code FROM employes WHERE etat_activite = 'actif' AND code != 'STR_0'");

        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_lgt.vehicule_show_affectation")->with('vehicule', $vehicule)->with('affectations', $affectations)->with('affectation_actuel', $affectation_actuel)->with('employes', $employes);

    }

    //  Go To Vehicule vidange
    public function vehicule_show_vidange($val){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT vehicules.*, marque_vehicules.libelle as libelle_marque, vehicule_genres.libelle as libelle_genre, vehicule_sources.libelle as libelle_source FROM vehicules, marque_vehicules, vehicule_genres, vehicule_sources WHERE vehicules.marque = marque_vehicules.id AND vehicule_genres.id = genre AND vehicule_sources.id = source AND matricule=?", [$val]);

        $vidanges = DB::select("SELECT vidanges.*, concessionnaires.libelle as lib_concessionnaire FROM vehicules, vidanges, concessionnaires WHERE vehicules.matricule = vidanges.matricule_vh AND vidanges.concessionnaire = concessionnaires.id  AND matricule=? ORDER by created_at DESC", [$val]);

        $prochainevidange = DB::select("SELECT IFNULL( (vi.km_actuel+ve.km_vidanger), 0 ) as prochainevidange FROM vidanges vi, vehicules ve WHERE vi.matricule_vh = ve.matricule AND ve.matricule = ? AND vi.km_actuel = (SELECT MAX(km_actuel) FROM vidanges WHERE vidanges.matricule_vh = ?)", [$val, $val]);


        $concessionnaires = DB::select("SELECT concessionnaires.* FROM concessionnaires");

        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_lgt.vehicule_show_vidange")->with('vehicule', $vehicule)->with('vidanges', $vidanges)->with('concessionnaires', $concessionnaires)->with('prochainevidange', $prochainevidange);

    }

    //  Go To Vehicule visite technique
    public function vehicule_show_visite_technique($val){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT vehicules.*, marque_vehicules.libelle as libelle_marque, vehicule_genres.libelle as libelle_genre, vehicule_sources.libelle as libelle_source FROM vehicules, marque_vehicules, vehicule_genres, vehicule_sources WHERE vehicules.marque = marque_vehicules.id AND vehicule_genres.id = genre AND vehicule_sources.id = source  AND matricule=?", [$val]);

        $lastVisite = DB::select("SELECT visite_techniques.*, NOW() as now FROM visite_techniques, vehicules WHERE matricule_vh = ? AND date_expiration = ( SELECT MAX(date_expiration) FROM visite_techniques WHERE  matricule_vh = ?) ORDER BY date_emission DESC", [$val, $val]);

        if(!empty($lastVisite)){
            if($lastVisite[0]->date_expiration > $lastVisite[0]->now){
                $lastVisite[0]->statut = 1;
            }else{
                $lastVisite[0]->statut = 0;
            }
        }

        $visites = DB::select("SELECT visite_techniques.* FROM visite_techniques, vehicules WHERE matricule_vh = matricule AND matricule = ? ORDER BY date_emission DESC", [$val]);
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_lgt.vehicule_show_visite_technique")->with('vehicule', $vehicule)->with('visites', $visites)->with('lastVisite', $lastVisite);

    }


    //  Go To Vehicule extincteur
    public function vehicule_show_extincteur($val){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT vehicules.*, marque_vehicules.libelle as libelle_marque, vehicule_genres.libelle as libelle_genre, vehicule_sources.libelle as libelle_source FROM vehicules, marque_vehicules, vehicule_genres, vehicule_sources WHERE vehicules.marque = marque_vehicules.id AND vehicule_genres.id = genre AND vehicule_sources.id = source AND matricule=?", [$val]);

        $lastExtincteur = DB::select("SELECT extincteurs.*, NOW() as now  FROM extincteurs, vehicules WHERE matricule_vh = ? AND expiration = ( SELECT MAX(expiration) FROM extincteurs WHERE  matricule_vh = ?) ORDER BY expiration DESC", [$val, $val]);
        if(!empty($lastExtincteur)){
            if($lastExtincteur[0]->expiration > $lastExtincteur[0]->now){
                $lastExtincteur[0]->statut = 1;
            }else{
                $lastExtincteur[0]->statut = 0;
            }
        }

        $extincteurs = DB::select("SELECT extincteurs.* FROM extincteurs, vehicules WHERE matricule_vh = matricule AND matricule = ? ORDER BY expiration DESC", [$val]);
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_lgt.vehicule_show_extincteur")->with('vehicule', $vehicule)->with('extincteurs', $extincteurs)->with('lastExtincteur', $lastExtincteur);
    }

    //  Go To Vehicule Outillage
    public function vehicule_show_outillage($val){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT vehicules.*, marque_vehicules.libelle as libelle_marque, vehicule_genres.libelle as libelle_genre, vehicule_sources.libelle as libelle_source FROM vehicules, marque_vehicules, vehicule_genres, vehicule_sources WHERE vehicules.marque = marque_vehicules.id AND vehicule_genres.id = genre AND vehicule_sources.id = source  AND matricule=?", [$val]);

        $marques = DB::select("SELECT * FROM marque_vehicules");
        $modeles = DB::select("SELECT * FROM modele_vehicules");
        $genres = DB::select("SELECT * FROM vehicule_genres");
        $sources = DB::select("SELECT * FROM vehicule_sources");

        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_lgt.vehicule_show_outillage")->with('vehicule', $vehicule)->with('marques', $marques)->with('modeles', $modeles)->with('genres', $genres)->with('sources', $sources);

    }
    

    /*------------------------------    ADD    ---------------------------------*/    

    //  ADD Outillage of VEHICULE
    public function vehicule_add_affectation(Request $request){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT matricule FROM vehicules WHERE matricule = ?", [$request->matricule]);
        if(empty($vehicule)){
            session()->put('warning',custom_warning('W042'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/affectation");
        }

        $check1 = DB::select("SELECT date_mise_circulation FROM vehicules WHERE matricule = ?", [$request->matricule]);
        
        if($check1[0]->date_mise_circulation >  $request->date_affectation){
            session()->put('warning',custom_warning('W043'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/affectation");
        }
        
        
        try{
            $update = DB::update("UPDATE affectation_vehicules SET date_fin = ? WHERE matricule_vh = ? AND date_debut <= ? AND date_fin IS NULL;", [$request->date_affectation, $request->matricule, $request->date_affectation]);
            $insert = DB::insert("INSERT INTO `affectation_vehicules` (`id`, `matricule_vh`, `employe_code`, `date_debut`, `date_fin`, `created_at`, `updated_at`) VALUES (NULL, ?, ?, ?, NULL, NOW(), NOW())  ", [ $request->matricule, $request->employe, $request->date_affectation]);
        }catch (\Exception $e) {
            session()->put('error',custom_error('E023'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/affectation");
        }

        afficherSuccess(custom_success(999));
        return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/affectation");

    }

    //  ADD Outillage of VEHICULE
    public function vehicule_add_vidange(Request $request){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT matricule, km_actuel FROM vehicules WHERE matricule = ?", [$request->matricule]);
        if(empty($vehicule)){
            session()->put('warning',custom_warning('W042'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }

        if( $request->km_actuel <= $vehicule[0]->km_actuel ){
            session()->put('warning',custom_warning('W044'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }        
        
        try{
            $insert = DB::insert("INSERT INTO `vidanges` (`id`, `matricule_vh`, `concessionnaire`, `date`, `km_actuel`, `prix`, `type`, `created_at`, `updated_at`) VALUES (NULL, ?, ?, ?, ?, ?, ?, NOW(), NOW())", [$vehicule[0]->matricule, $request->concessionnaire, $request->date_vidange, $request->km_actuel, $request->prix, $request->type]);
            $update = DB::update("UPDATE vehicules  SET km_actuel = ? WHERE matricule = ? ", [$request->km_actuel, $request->matricule]);
        }catch (\Exception $e) {
            session()->put('error',$e->getMessage());
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }

        afficherSuccess(custom_success(999));
        return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");

    }

    //  ADD VISITE TECHNIQUE of VEHICULE
    public function vehicule_add_visite_technique(Request $request){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT matricule, km_actuel FROM vehicules WHERE matricule = ?", [$request->matricule]);
        if(empty($vehicule)){
            session()->put('warning',custom_warning('W042'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/visite_technique");
        }

        //  IMAGES
        if(isset($request->fichier)){
            $fichier = $request->fichier;
            $fichier = get_file_name_to_store($request,'fichier', config('app.DOSSIER_PARC_AUTO'). $request->matricule, 'VT_'.$request->date_visite, '' );
        } else{
            $fichier = NULL;
        }
        
        try{
            $insert = DB::insert("INSERT INTO `visite_techniques` (`id`, `matricule_vh`, `date_emission`, `duree`, `date_expiration`, `fichier`, `created_at`, `updated_at`) VALUES (NULL, ?, ?, TIMESTAMPDIFF(MONTH, ?, ?), ?, ?, NOW(), NOW())", [$vehicule[0]->matricule, $request->date_visite, $request->date_visite, $request->date_expiration, $request->date_expiration, $fichier]);
        }catch (\Exception $e) {
            session()->put('error',$e->getMessage());
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/visite_technique");
        }

        afficherSuccess(custom_success(999));
        return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/visite_technique");

    }

    //  ADD VISITE TECHNIQUE of VEHICULE
    public function vehicule_add_extincteur(Request $request){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT matricule, km_actuel FROM vehicules WHERE matricule = ?", [$request->matricule]);
        if(empty($vehicule)){
            session()->put('warning',custom_warning('W042'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/extincteur");
        }
        
        try{
            $insert = DB::insert("INSERT INTO `extincteurs` (`id`, `matricule_vh`, `obtention`, `expiration`, `created_at`, `updated_at`) VALUES (NULL, ?, ?, ?, NOW(), NOW())", [$vehicule[0]->matricule, $request->date_obtention, $request->date_expiration]);
        }catch (\Exception $e) {
            session()->put('error',$e->getMessage());
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/extincteur");
        }

        afficherSuccess(custom_success(999));
        return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/extincteur");

    }


    /*------------------------------    EDIT    ---------------------------------*/    

    //  Edit Outillage of VEHICULE
    public function vehicule_edit_outillage(Request $request){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT matricule FROM vehicules WHERE matricule = ?", [$request->matricule]);
        if(empty($vehicule)){
            session()->put('warning',custom_warning('W042'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/outillage");
        }
        
        //  Attribution variable - valeur
        isset($request->crique) ? $crique = 1 : $crique = 0;
        isset($request->cle_a_roue) ? $cle_a_roue = 1 : $cle_a_roue = 0;
        isset($request->calle_metal) ? $calle_metal = 1 : $calle_metal = 0;
        isset($request->trousseaum) ? $trousseaum = 1 : $trousseaum = 0;
        isset($request->baladeuse) ? $baladeuse = 1 : $baladeuse = 0;
        isset($request->sangle) ? $sangle = 1 : $sangle = 0;
        isset($request->gilet) ? $gilet = 1 : $gilet = 0;
        isset($request->triangle) ? $triangle = 1 : $triangle = 0;
        isset($request->tracker) ? $tracker = 1 : $tracker = 0;
        
        try{
            $update = DB::update("UPDATE `vehicules` SET `crique` = ?, `cle_a_roue` = ?, `calle_metal` = ?, `trousseaum` = ?, `baladeuse` = ?, `sangle` = ?, `gilet` =?, `triangle` = ?, `tracker` = ? WHERE `vehicules`.`matricule` = ?  ", [$crique, $cle_a_roue, $calle_metal, $trousseaum, $baladeuse, $sangle, $gilet, $triangle, $tracker, $vehicule[0]->matricule]);
        }catch (\Exception $e) {
            session()->put('error',custom_error('E023'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/outillage");
        }

        afficherSuccess(custom_success(999));
        return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/outillage");

    }


    //  Edit Outillage of VEHICULE
    public function vehicule_edit_identification(Request $request){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT matricule, image1, image2, image3, image4 FROM vehicules WHERE matricule = ?", [$request->matricule]);

        if(empty($vehicule)){
            session()->put('warning',custom_warning('W042'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/identification");
        }

        //$vehi = Vehicule::where('matricule', $vehicule[0]->matricule)->first();

        
        $fichier1 =  $fichier2 =  $fichier3 =  $fichier4 = "";
        //  IMAGES
        if(isset($request->image1)){
            $fichier1 = $request->fichier;
            $fichier1 = get_file_name_to_store($request,'image1', config('app.DOSSIER_PARC_AUTO'). $request->matricule, 'avant', '' );

            //$vehi->image1 = $fichier1;
        }
        if(isset($request->image2)){
            $fichier2 = $request->fichier;
            $fichier2 = get_file_name_to_store($request,'image2', config('app.DOSSIER_PARC_AUTO'). $request->matricule, 'gauche', '' );
            //$vehi->image2 = $fichier2;
        }
        if(isset($request->image3)){
            $fichier3 = $request->fichier;
            $fichier3 = get_file_name_to_store($request,'image3', config('app.DOSSIER_PARC_AUTO'). $request->matricule, 'arriere', '' );
            //$vehi->image3 = $fichier3;
        }
        if(isset($request->image4)){
            $fichier4 = $request->fichier;
            $fichier4 = get_file_name_to_store($request,'image4', config('app.DOSSIER_PARC_AUTO'). $request->matricule, 'interieur_droite', '' );
            //$vehi->image4 = $fichier4;
        }
        
        
        //  UPDATE
        try{
            //$vehi->save();
            $update = DB::update("UPDATE `vehicules` SET `modele` = ?, `marque` = ?, `nom` = ?, `numero_serie` = ?, `genre` = ?, `source` = ?, `puissance` = ?, `nbr_place` = ?, `charge` = ?, `poids_a_vide` = ?, `date_achat` = ?, `date_mise_circulation` = ?, `valeur` = ?, `image1` = ?, `image2` = ?, `image3` = ?, `image4` = ? WHERE matricule = ?", [$request->modele,  $request->marque,  $request->nom,  $request->serie,  $request->genre,  $request->source,  $request->puissance,  $request->nbr_place,  $request->charge,  $request->poids_a_vide,  $request->date_achat,  $request->date_mise_circulation,  $request->valeur, $fichier1 == "" ? $vehicule[0]->image1 : $fichier1, $fichier2 == "" ? $vehicule[0]->image2 : $fichier2, $fichier3 == "" ? $vehicule[0]->image3 : $fichier3, $fichier4 == "" ? $vehicule[0]->image4 : $fichier4, $vehicule[0]->matricule]);
            
        } catch (\Exception $e) {
            session()->put('error',custom_error($e->getMessage()));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/identification");
        }

        afficherSuccess(custom_success(999));
        return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/identification");

    }


    //  Edit VIDANGE of VEHICULE
    public function vehicule_edit_vidange(Request $request){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT matricule, km_actuel  FROM vehicules WHERE matricule = ?", [$request->matricule]);
        if(empty($vehicule)){
            session()->put('warning',custom_warning('W042'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }

        if( $request->km_actuel < $vehicule[0]->km_actuel ){
            session()->put('warning',custom_warning('W044'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }
        if( $request->alerte1 <= $request->alerte2 ){
            session()->put('warning',custom_warning('W045'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }
        
        try{
            $update = DB::update("UPDATE `vehicules` SET `km_actuel` = ?, `km_alerte1` = ?, `km_alerte2` = ? WHERE `vehicules`.`matricule` = ?  ", [$request->km_actuel, $request->alerte1, $request->alerte2, $vehicule[0]->matricule]);
        }catch (\Exception $e) {
            session()->put('error',custom_error('E023'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }

        afficherSuccess(custom_success(999));
        return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");

    }
    


    //  Edit VISITE TECHNIQUE of VEHICULE
    public function vehicule_edit_visite_technique(Request $request){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT matricule, km_actuel  FROM vehicules WHERE matricule = ?", [$request->matricule]);
        if(empty($vehicule)){
            session()->put('warning',custom_warning('W042'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }

        if( $request->km_actuel < $vehicule[0]->km_actuel ){
            session()->put('warning',custom_warning('W044'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }
        if( $request->alerte1 <= $request->alerte2 ){
            session()->put('warning',custom_warning('W045'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }
        
        try{
            $update = DB::update("UPDATE `vehicules` SET `km_actuel` = ?, `km_alerte1` = ?, `km_alerte2` = ? WHERE `vehicules`.`matricule` = ?  ", [$request->km_actuel, $request->alerte1, $request->alerte2, $vehicule[0]->matricule]);
        }catch (\Exception $e) {
            session()->put('error',custom_error('E023'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }

        afficherSuccess(custom_success(999));
        return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");

    }
    


    //  Edit VISITE TECHNIQUE of VEHICULE
    public function vehicule_edit_extincteur(Request $request){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        $vehicule = DB::select("SELECT matricule, km_actuel  FROM vehicules WHERE matricule = ?", [$request->matricule]);
        if(empty($vehicule)){
            session()->put('warning',custom_warning('W042'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }

        if( $request->km_actuel < $vehicule[0]->km_actuel ){
            session()->put('warning',custom_warning('W044'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }
        if( $request->alerte1 <= $request->alerte2 ){
            session()->put('warning',custom_warning('W045'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }
        
        try{
            $update = DB::update("UPDATE `vehicules` SET `km_actuel` = ?, `km_alerte1` = ?, `km_alerte2` = ? WHERE `vehicules`.`matricule` = ?  ", [$request->km_actuel, $request->alerte1, $request->alerte2, $vehicule[0]->matricule]);
        }catch (\Exception $e) {
            session()->put('error',custom_error('E023'));
            return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");
        }

        afficherSuccess(custom_success(999));
        return redirect("/logistique_securite/parc_automobile/".$vehicule[0]->matricule."/vidange");

    }

    /**********************************************************************************************************************************   
    *   ----------------------------------------------------    /
    *   ----------------------------------------------------    /
    *                   LOGISTIQUE
    */
    // GO TO Logistique
    public function logistique(){
        if(check_session() =='no'){
            return redirect('/'); 
        }

        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts_lgt.logistique");

    }



    /*                  
    *   ----------------------------------------------------    /
    *   ----------------------------------------------------    /
    *                   SECURITE
    */




    /**********************************************************************************************************************************   
    *   ----------------------------------------------------    /
    *   ----------------------------------------------------    /
    *                   CRON TABE EXPIRATION
    */

    public function sendEmailExpirations(){
        Log::info("START EXPIRATION VISITE TECHNIQUE!"); //  logger dans storage/log/laravel.php

        //  Take les Moniteurs
        $lesmoniteurs = DB::select("SELECT employes.email FROM `moniteur_parc_autos`, employes WHERE moniteur_parc_autos.code_emp = employes.code AND employes.etat_activite = 'actif'");
        
        // EXPIRATION VISITE TECHNIQUE MOINS 15 JOURS   GLOBAL
        $expireVisiteTechnique = DB::select("SELECT ve.matricule, ve.modele, ve.marque, ve.nom, ve.numero_serie, vi.*, (DATEDIFF(vi.date_expiration, CURRENT_DATE())) as nbrj_expiration FROM vehicules ve, visite_techniques vi WHERE ve.matricule = vi.matricule_vh AND vi.date_expiration = ( SELECT MAX(vii.date_expiration) FROM visite_techniques vii WHERE  vii.matricule_vh = vi.matricule_vh) AND DATEDIFF(vi.date_expiration, CURRENT_DATE()) <= ?",[config("app.LGT_alert1")]);

        // EXPIRATION VIDANGE MOINS 15 JOURS   GLOBAL
        $expireVidange = DB::select(" SELECT ve.matricule, ve.modele, ve.marque, ve.nom, ve.km_alerte2, ve.km_alerte1, ve.numero_serie, ve.km_actuel, vi.date, vi.type, vi.created_at, ( (SELECT vii.km_actuel FROM vidanges vii WHERE vii.matricule_vh = ve.matricule AND vii.created_at = (SELECT MAX(viii.created_at) FROM vidanges viii WHERE viii.matricule_vh = ve.matricule))+ve.km_vidanger - (ve.km_actuel) ) as km_restant_pour_expirer FROM vehicules ve, vidanges vi WHERE ve.matricule = vi.matricule_vh AND ( (SELECT km_actuel FROM vidanges vii WHERE vii.matricule_vh = ve.matricule AND vii.created_at = (SELECT MAX(viii.created_at) FROM vidanges viii WHERE viii.matricule_vh = ve.matricule))+ve.km_vidanger - (ve.km_actuel) ) <= ve.km_alerte1 ");

        // EXPIRATION EXTINTEUR MOINS 15 JOURS   GLOBAL
        $expireExtincteur = DB::select("SELECT ve.matricule, ve.modele, ve.marque, ve.nom, ve.numero_serie, vi.*, (DATEDIFF(vi.expiration, CURRENT_DATE())) as j_restant FROM vehicules ve, extincteurs vi WHERE ve.matricule = vi.matricule_vh AND vi.expiration = ( SELECT MAX(vii.expiration) FROM extincteurs vii WHERE  vii.matricule_vh = vi.matricule_vh) AND DATEDIFF(vi.expiration, CURRENT_DATE()) <= ?",[config("app.LGT_alert1")]);

        // 

        $ilyaexpiration = count($expireVisiteTechnique)+count($expireVidange)+count($expireExtincteur);

        if( $ilyaexpiration > 0){
            foreach($lesmoniteurs as $moniteur){
                Mail::to($moniteur->email)->send(new LgtExpiration($expireVisiteTechnique, $expireExtincteur, $expireVidange, "RAPPORT GEDES : EXPIRATION PARC AUTOMONILE") );  
            } 
        }     

        // pour chacun d'eux on va 
        // SELECT vehicules.*, visite_techniques.* FROM vehicules, visite_techniques WHERE vehicules.matricule = visite_techniques.matricule_vh AND DATEDIFF(CURRENT_DATE(), visite_techniques.date_expiration); 


    }

}
