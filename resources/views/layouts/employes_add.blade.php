
@extends('client.apprh', ['titre' => 'Enregistrement employé'])
    
@section('contenu')

<style>
    label{
        /* text-align: right !important; */
    } 
    
</style>
    
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ajout Employé</h1>
                </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                <li class="breadcrumb-item active"><a href="/rh/employes">Employés</a></li>
                <li class="breadcrumb-item active">Ajouter</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-0">
                    </div>
                    <div class="col-12">

                                <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
              <div class="card card-default">
                
                <!-- card-header -->
                <div class="card-header">
                    <h3 class="card-title">Renseignez les informations de l'employé</h3>
                </div>
                <!-- /.card-header -->
                
                <div id="loadingGif" style="display:none"><img src="https://media.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.gif"></div>
                <!-- card-body      class="needs-validation" novalidate -->
                <form action="/rh/employes/save_add" method="post" enctype="multipart/form-data" id="formID" name="formID" class="needs-validation" novalidate>
                    @csrf
                    <div class="card-body p-0">
                        <div class="bs-stepper">
                          <div class="bs-stepper-header" role="tablist">
<!-- your steps here -->
                            <div class="step" data-target="#etat_civil">
                              <button type="button" class="step-trigger" role="tab" aria-controls="etat_civil" id="etat_civil-trigger">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Etat Civil</span>
                              </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#etat_social">
                              <button type="button" class="step-trigger" role="tab" aria-controls="etat_social" id="etat_social-trigger">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Etat Social</span>
                              </button>
                            </div>
                        <!--    <div class="line"></div>
                            <div class="step" data-target="#carriere">
                              <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="carriere-trigger">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">Carrière</span>
                              </button>
                            </div>
                        -->
                            <div class="line"></div>
                            <div class="step" data-target="#statut_str">
                              <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="statut_str-trigger">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">Statut à STR Africa</span>
                              </button>
                            </div>
                          </div>


                          <div class="bs-stepper-content" style="margin-top: 20px">
<!-- your steps content here -->
                            <div id="etat_civil" class="content" role="tabpanel" aria-labelledby="etat_civil-trigger">
                                <div class="row ml-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group row col-md-2 align-self-center">
                                                    <label class="align-middle labelRow">Nom complet</label>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Nom <span class="reqD">*</span></label>
                                                    <input type="nom" class="form-control" id="nom" name="nom" required placeholder="exemple: Mboumba Mba" onkeyup="
                                                    var start = this.selectionStart;
                                                    var end = this.selectionEnd;
                                                    this.value = this.value.toUpperCase();
                                                    this.setSelectionRange(start, end);">
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Prenom</label><span class="reqD">*</span>
                                                    <input type="text" class="form-control" id="nom" name="prenom" required placeholder="exemple: Jean Ives" onkeyup="
                                                    var start = this.selectionStart;
                                                    var end = this.selectionEnd;
                                                    this.value = this.value.toUpperCase();
                                                    this.setSelectionRange(start, end);">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-3 lineSeparateur" />

                                <div class="row ml-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group row col-md-2">
                                                    <label class="align-middle labelRow">GenreGenreGenre</label><span class="reqD"> *</span></label>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    @foreach ($sexes as $sexe)
                                                    
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="sexe" id="inlineRadio1" value="{{$sexe->id}}" checked>
                                                            <label class="form-check-label" for="inlineRadio1">{{$sexe->libelle}}</label>
                                                        </div>
                                                    @endforeach                                        
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-2" style="margin-left: 5px; text-align: end">
                                                <label class="align-middle labelRow">Date de naissance</label><span class="reqD"> *</span></label>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-9">
                                                    <input type="date" id="start" name="date_naiss"
                                                        placeholder="1990-07-22"
                                                        min="1900-01-01" class="form-control date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group row col-md-2">
                                                    <label class="align-middle labelRow">Nationalité</label>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <select name="nationalite" class="form-control select2">
                                                        @foreach (StaticArray::$nationalite as $item)
                                                            <option value="{{$item["pays"]}}" {{$item["pays"]=='Gabon' ? 'selected' : ''}}>{{$item["pays"]}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-2" style="margin-left: 5px">
                                                <label class="align-middle labelRow">Domicile actuel</label><span class="reqD"> *</span></label>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-9">
                                                    <input type="texte" class="form-control" name="adresse" required placeholder="exemple: Nzeng-Ayong">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-3 lineSeparateur" />

                                <div class="row ml-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group row col-md-2">
                                                    <label class="align-middle labelRow">Statut matrimonal</label>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <select name="etat_matrimonial" class="form-control select2">
                                                        @foreach ($etat_matrimonials as $matrimonial)
                                                            <option value="{{$matrimonial->id}}" >
                                                                {{$matrimonial->libelle}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-2" style="margin-left: 5px">
                                                <label class="align-middle labelRow">Nombre d'enfants</label><span class="reqD"> *</span></label>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-9">
                                                    <input type="number" class="form-control" name="nbr_enfant" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-3 lineSeparateur" />

                                <div class="row ml-5">
                                    <div class="form-group row col-md-2">
                                            <label class="align-middle labelRow">Téléphone 1 </label><span class="reqD"> *</span></label>
                                    </div>
                                    <div class="form-group row col-md-3">
                                        <div class="form-group col-md-12">
                                            <input class="form-control" type="text" name="telephone1" required min="8" id="validationCustom03" pattern="^0[0-9]{8}" size="9" minlength="9" maxlength="9" placeholder="076122159" required>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-2" style="margin-left: 5px">
                                        <label class="align-middle labelRow">Téléphone 2</label>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <div class="form-group col-md-9">
                                            <input class="form-control" type="text" name="telephone2" pattern="^0[0-9]{8}" size="9" minlength="9" maxlength="9" placeholder="076122159" >  
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-3 lineSeparateur" />

                                <div class="row ml-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group row col-md-2 align-self-center">
                                                    <label class="align-middle labelRow">Piece d'identité</label>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Type </label>
                                                    <select name="piece_id" id="" class="form-control select2">
                                                        <option value="1">CARTE D'IDENTITE NATIONALE (CNI)</option>
                                                        <option value="2">PASSEPORT</option>
                                                        <option value="4">ACTE DE NAISSANCE</option>
                                                    </select> 
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Charger le ficher de la pièce</label>
                                                    <input id="piece_file" class="form-control" type="file"  accept="application/pdf"  name="piece_file" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-3 lineSeparateur" />

                                <div class="row ml-5">
                                    <div class="form-group row col-md-2">
                                            <label class="align-middle labelRow">Permis</label></label>
                                    </div>
                                    <div class="form-group row col-md-3">
                                        <div class="row col-md-12">
                                            <div class="form-group col-md-12">
                                                <!--select name="permis" id="" class="form-control select2">
                                                    @foreach ($permiss as $permis)
                                                        <option value="{{$permis->id}}">
                                                            {{$permis->type}}
                                                        </option>
                                                    @endforeach
                                                </select--> 
                                                <select name="permis" id="permis" class="form-control select2">
                                                    <option value="NON">NON</option>
                                                    <option value="OUI" data-toggle="collapse" data-target="#demo">OUI</option>
                                                </select> 
                                                
                                            </div>
                                        </div>
                                        <div class="row col-md-12 d-none" id="demo">
                                           
                                            @foreach ($permiss as $permis)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="permisSelect" value="{{$permis->id}}" name="perm[]" style="width: 30px">
                                                    <label class="form-check-label" for="permisSelect">{{$permis->type}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-2" style="margin-left: 5px">
                                        <label class="align-middle labelRow">Photo</label>
                                    </div>
                                    <div class="form-group row col-md-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="photo" accept="image/*">
                                            <label class="custom-file-label" data-browse="Parcourir" for="customFile">Choisir la photo</label>
                                        </div>
                                    </div>
                                </div>
                                

                                <hr class="mt-2 mb-3 lineSeparateur" />
                                <a class="btn btn-primary" onclick="stepper.next()" id="suivant">Suivant</a>
                                <span class="reqD">(*) </span> <span style="color: grey">Champs Obligatoires</span> 
                            </div>

<!-- ETAT SOCIAL -->
                            <div id="etat_social" class="content" role="tabpanel" aria-labelledby="etat_social-trigger">
                                <div class="row ml-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group row col-md-2 align-self-center">
                                                    <label class="align-middle labelRow">Urgences</label>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Nom de la pesonne à contacter</label><span class="reqD"> *</span>
                                                    <input type="nom_urgence" class="form-control" name="urgence_nom" required placeholder="exemple: Koumba Catherine">
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Lien</label>
                                                    <select  name="urgence_lien" class="form-control select2">
                                                        <option value="Femme">Epoux(se)</option>
                                                        <option value="Fiancé(e)">Fiancé(e)</option>
                                                        <option value="Mère">Mère</option>
                                                        <option value="Père">Père</option>
                                                        <option value="Frère">Frère</option>
                                                        <option value="Soeur">Soeur</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Adresse</label><span class="reqD"> *</span>
                                                    <input type="text" class="form-control" name="urgence_adresse" required placeholder="exemple: Okala">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" >
                                            <div class="form-group row col-md-2 align-self-center">
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Téléphone 1</label><span class="reqD"> *</span>
                                                    <input type="text" class="form-control" name="urgence_number1" pattern="^0[0-9]{8}" size="9" minlength="9" maxlength="9" placeholder="076122159" required>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Téléphone 2</label>
                                                    <input type="texte" class="form-control" name="urgence_number2" pattern="^0[0-9]{8}" size="9" minlength="9" maxlength="9" placeholder="076122159" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-3 lineSeparateur" />

                                <div class="row ml-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group row col-md-2">
                                                <label class="align-middle labelRow">Numéro CNSS</label>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <input type="text" name="cnss" id="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-2" style="margin-left: 5px">
                                                <label class="align-middle labelRow">Numéro CNAMGS</label>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <input type="text" name="cnamgs" id="" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group row col-md-2">
                                                <label class="align-middle labelRow">Numéro NIF</label>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <input type="text" name="nif" id="" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-3 lineSeparateur" />
                                
                                <a class="btn btn-primary" onclick="stepper.previous()">Précédent</a>
                                <a class="btn btn-primary" onclick="stepper.next()">Suivant</a>
                                <span class="reqD">(*) </span> <span style="color: grey">Champ Obigatoire</span>
                            </div>

<!-- CARRIERE                      
                            <div id="carriere" class="content" role="tabpanel" aria-labelledby="carriere-trigger">
                                
                                <div class="row ml-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group row col-md-2 align-self-center">
                                                    <label class="align-middle labelRow">Curriculum Viate</label>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Charger le ficher du CV</label>
                                                    <input id="permis_file" class="form-control" type="file"  accept="application/pdf"  name="permis_file">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-3 lineSeparateur" />

                                <button class="btn btn-primary" onclick="stepper.previous()">Précédent</button>
                                <button class="btn btn-primary" onclick="stepper.next()">Suivant</button>
                            </div>
-->
<!-- STATUT STR -->                
                            <div id="statut_str" class="content" role="tabpanel" aria-labelledby="statut_str-trigger">
                                
                                <div class="row ml-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group row col-md-2 ">
                                                    <label class="align-middle labelRow">Curriculum Vitae</label><span class="reqD"> *</span>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-12">
                                                    <input id="cv" class="form-control" type="file"  accept="application/pdf"  name="cv" required>
                                                    <!--input type="hidden" name="max_file_size" value="2048" /-->
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-2" style="margin-left: 5px">
                                                <label class="align-middle labelRow">Date d'embauche</label><span class="reqD"> *</span></label>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-9">
                                                    <input type="date" id="start" name="date_embauche"
                                                        placeholder="1990-07-22"
                                                        min="1900-01-01" class="form-control date" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-3 lineSeparateur" />

                                <div class="row ml-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group row col-md-2 align-self-center">
                                                    <label class="align-middle labelRow">Affectation</label><span class="reqD"> *</span>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Direction</label>
                                                    <select name="direction" id="direct" class="form-control select2" onselect="return chargerServices()" required>
                                                        <option selected="selected">
                                                            /****Selectionnez*****/
                                                        </option>
                                                        @foreach ($directions as $direction)
                                                            <option value="{{$direction->code}}">
                                                                {{$direction->libelle}}
                                                            </option>
                                                        @endforeach
                                                    </select> 
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Poste</label>
                                                    <select name="sel_poste" id="sel_poste" class="form-control select2" required>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--div class="row ml-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group row col-md-2 align-self-center">
                                                    <label class="align-middle labelRow">Affectation</label><span class="reqD"> *</span>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Département</label>
                                                    <select name="departement" id="dept" class="form-control select2" onselect="return chargerServices()" required>
                                                        <option selected="selected">
                                                            /****Selectionnez*****/
                                                        </option>
                                                        @foreach ($departements as $departement)
                                                            <option value="{{$departement->code}}">
                                                                {{$departement->libelle}}
                                                            </option>
                                                        @endforeach
                                                    </select> 
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Service</label>
                                                    <select name="service" id="sel_serv" class="form-control select2" required>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Poste</label>
                                                    <select name="sel_poste" id="sel_poste" class="form-control select2" required>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div-->

                                <hr class="mt-2 mb-3 lineSeparateur" />

                                <div class="row ml-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group row col-md-2 align-self-center">
                                                    <label class="align-middle labelRow">Contrat</label><span class="reqD"> *</span>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Type</label>
                                                    <select name="type_contrat" id="" class="form-control select2">
                                                        @foreach ($contrats as $contrat)
                                                            <option value="{{$contrat->type}}">
                                                                {{$contrat->type}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-12">
                                                    <label class="labelChamp">Fichier du contrat</label>
                                                    <input id="contrat_emp" class="form-control" type="file"  accept="application/pdf" name="contrat_emp" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-3 lineSeparateur" />

                                <div class="row ml-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group row col-md-2">
                                                <label class="align-middle labelRow">Numéro de flotte</label></label><span class="reqD">* </span>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <input class="form-control" type="texte" name="flotte" pattern="^0[0-9]{8}" size="9" minlength="9" maxlength="9" placeholder="076122159" required> 
                                                </div>
                                            </div>
                                            <div class="form-group row col-md-1" style="margin-left: 5px"></div>
                                            <div class="form-group row col-md-2 align-self-center">
                                                <label class="align-middle labelRow">Email Professionnel</label><span class="reqD">* </span>
                                            </div>
                                            <div class="form-group row col-md-3">
                                                <div class="form-group col-md-12">
                                                    <input type="email" class="form-control" name="email" required placeholder="x.y@strafrica.com" pattern="([a-z0-9._%+-])+[.]+([a-z0-9._%+-])+@<?PHP echo config('app.DOMAIN_FQDN');?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-2 mb-3 lineSeparateur" />

                                <div class="row ml-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group row col-md-2 align-self-center">
                                                <label class="align-middle labelRow">Salaire</label><span class="reqD">* </span>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-12">
                                                    <input type="number" class="form-control" name="salaire" required min="50000">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-3 lineSeparateur" />

                                <!--div class="row ml-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group row col-md-2 align-self-center">
                                                    <label class="align-middle labelRow">Logement de la société</label>
                                            </div>
                                            <div class="form-group row col-md-4">
                                                <div class="form-group col-md-12">
                                                    <select name="logement" id="" class="form-control select2">
                                                        @foreach ($logements as $logement)
                                                            <option value="{{$logement->id}}">
                                                                {{$logement->adresse}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div-->
                                

                                <hr class="mt-2 mb-3 lineSeparateur" />
                                <a class="btn btn-primary" onclick="stepper.previous()">Précédent</a>
                                <button type="submit" onclick="return valider()" id="saveAll" class="btn btn-primary">Enregistrer</button>
                                <span class="reqD">(*) </span> <span style="color: grey">Champ Obigatoire</span>
                            </div>


                          </div>
                          
                        </div>
                      </div>
                </form>
                
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.row -->

                            <!-- /.card-body -->


                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection 

@section('customjavascript')
    <script>
        function showDiv() {
        document.getElementById('saveAll').style.display = "none";
        document.getElementById('loadingGif').style.display = "block";
        setTimeout(function() {
            document.getElementById('loadingGif').style.display = "none";
            //document.getElementById('showme').style.display = "block";
        },2000);
        
        }
    </script>
    <script>
         // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function () {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        

        var stepper1 = new Stepper(document.querySelector('#bs-stepper'));
        var form = document.querySelector('form');
        var validFormFeedback = document.querySelector('#test-l-3 .valid-feedback');
        var inValidFormFeedback = document.querySelector('#test-l-3 .invalid-feedback');

        form.addEventListener('submit', function(event) {
        form.classList.remove('was-validated');
        inValidFormFeedback.classList.remove('d-block');
        validFormFeedback.classList.remove('d-block');
        
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            inValidFormFeedback.classList.add('d-block');
        } else {
            validFormFeedback.classList.add('d-block');
        }

        form.classList.add('was-validated');
        }, false);
    </script>
    <script>

        window.onload = function() {
        var direct = document.getElementById('direct');
        direct.onchange = function() {
            $.ajax({
            url: '/rh/employes/get_postes_of_direction',
            type: 'post',
            data:{
                "code": direct.value,
                "_token": "{{ csrf_token() }}",
                 },
            success: function(data){

                //Log the data to the console so that
                //you can get a better view of what the script is returning.
                console.log(data);

                var len = data.length;

                $("#sel_poste").empty();

                $("#sel_poste").append("<option selected>/****Selectionnez*****/</option>");
                for( var i = 0; i<len; i++){
                    var id = data[i]['id'];
                    var libelle = data[i]['libelle'];
                    
                    $("#sel_poste").append("<option value='"+id+"' >"+libelle+"</option>");
                    $('#sel_poste').prop('change', true);
                }
            }
        });

        }



        var permis = document.getElementById('permis');
        permis.onchange = function() {
            if (permis.value == 'NON'){
                //document.getElementById('permisSelect').disabled= true;
                $("#demo").addClass('d-none');
            }

            if (permis.value == 'OUI'){
                //document.getElementById('permisSelect').disabled= false;
                $("#demo").removeClass('d-none');
            }

        }

    }
    
    </script>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
    </script>

    <script>

        function valider(){
            var form = document.getElementById('formID');
            var submitButton = document.getElementById('saveAll');
            if ($('#formID').get(0).checkValidity() == false) {
                //alert('BAD');
                notificationWarning("{{custom_warning('W002')}}");
                //return false;
            }else{
                // Disable the submit button
                submitButton.setAttribute('disabled', 'disabled');
                // Change the "Submit" text
                //submitButton.text = 'Enregistrement en cours...';
                $("#saveAll").html("Enregistrement en cours...");
                document.formID.submit();
            }       
            
        }
       
    </script>

@endsection