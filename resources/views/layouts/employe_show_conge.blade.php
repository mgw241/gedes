@extends('client.employes_show')

@section('contenu2')
<div class="card">
    <div class="card-header p-2">
        <h3>CONGÉS</h3>
    </div><!-- /.card-header-->
    <div class="card-body">

        <div class="row">
            <div class="col-md-8">
                <h5 style="color: ">Congés payés acquis de l'année @php echo date("Y");@endphp</h5>
                <table class="table tablePresentation col-md-12" style="border: 0px">
                    <tbody>
                        <tr>
                            <td class="col-md-7">Nombre de jours de congés :</td>
                            <th class="col-md-5" style="text-align: right; vertical-align: middle;">{{$nbrJoursCongeAnneeEnCours[0]->nbrJoursCongeAnneeEnCours}} Jours</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <hr class="mt-3 mb-3"/>
        <div class="row">
            <div class="col-md-8">
                <h5 style="color: ">Congés payés acquis depuis l'embauche ({{date("d/m/Y", strtotime($employes[0]->debut))}})</h5>
                <table class="table tablePresentation col-md-12" style="border: 0px">
                    <tbody>
                        <tr>
                            <td class="col-md-7">Nombre de jours de congés :</td>
                            <th class="col-md-5" style="text-align: right; vertical-align: middle;">{{$nbrJoursCongeAcquisDepuisFonction[0]->nbrJoursCongeAcquisDepuisFonction}} Jours</td>
                        </tr>
                        <tr>
                            <td class="col-md-7">Nombre de jours de congés ancienneté :</td>
                            <th class="col-md-5" style="text-align: right; vertical-align: middle;">{{$nbrJoursCongeAnciennete[0]->nbrJoursCongeAnciennete}} Jours</td>
                        </tr>
                        <tr>
                            <td class="col-md-7">Nombre de jours de congés mère :</td>
                            <th class="col-md-5" style="text-align: right; vertical-align: middle;">{{$nbrJoursCongeMere2[0]->nbrJoursCongeMere2}} Jours</td>
                        </tr>
                        <tr>
                            <td class="col-md-7">Nombre de jours de congés déjà pris:</td>
                            <th class="col-md-5" style="text-align: right; vertical-align: middle;">{{$nbrJoursCongeDejaPris[0]->nbrJoursCongeDejaPris}} Jours</td>
                        </tr>
                        <tr>
                            <td class="col-md-7">
                                <h5 style="color: red">
                                    Nombre de jours total disponibles: 
                                </h5>
                            </td>
                            <th class="col-md-5" style="text-align: right; vertical-align: middle;">
                                <h6 style="color: red; font-weight: bold;">
                                    {{$congeAcquisEnCours[0]->congeAcquisEnCours}} Jours
                                </h6>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>


        <div class="card-body">

            @if (Session('permission')[0]->add == '1')
                <div class="row">
                    <div class="col-md-12">
                        <a href="" class="" data-toggle="collapse" data-target="#demo" style="color: ; "><h5 style="color: ; text-decoration: underline;">Ajouter un ancien congé</h5></a>
    
                        <form class="cmxform" method="post" action="{{'/employe_conge/save_add_old_conge'}}" enctype="multipart/form-data">
                            @csrf 
                            <div id="demo" class="collapse ">
                                <div class="modal-body" > 
                                    <div class="form-group">
                                        <label for="form-group">Motif :</label>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input custom-control-input-primary" type="radio" id="customRadio4" name="motif" checked="" value="ANNUEL">
                                            <input type="hidden" value="{{$employes[0]->code}}" name="employe">
                                            <label for="customRadio4" class="custom-control-label">ANNUEL</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input custom-control-input-primary" type="radio" id="customRadio5" name="motif" value="EXCEPTIONNEL">
                                            <label  for="customRadio5" class="custom-control-label">EXCEPTIONNEL <span style="font-size:12px !important; font-style: normal !important">(décès, naissance, mariage... ) (fournir un justificatif)</span></label>
                                        </div>
                                    </div>
                                    <div class="form-group d-none col-md-5" id="demo2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="justificatif" name="justificatif" accept="application/pdf">
                                            <label class="custom-file-label" data-browse="Parcourir" for="justificatif">Choisir le fichier justificatif</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-4 col-form-label">Du :</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="date"  name="date_debut_conge" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-4 col-form-label">Au :</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="date"  name="date_fin_conge" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="autorisation_conge" name="autorisation_conge" accept="application/pdf">
                                            <label class="custom-file-label" data-browse="Parcourir" for="autorisation_conge">Choisir le fichier d'autorisation de congé</label>
                                        </div>
                                    </div>
                                    <input class="btn btn-success" type="submit" value="Ajouter">
                                </div>
                                
                                <!--div class="modal-footer">
                                    <input class="btn btn-success" type="submit" value="Ajouter">
                                    <button id="commentForm"on type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                </div-->
                            </div>
                            
                        </form>
                        
                    </div>
                </div>
        
            @endif


        <hr class="mt-3 mb-3"/>

        <div class="row">
            <div class="col-md-12">
                <h5 style="color: ">Historique des congés</h5>
                <div class="col-md-8"><hr class="mt-3 mb-3"/></div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th>Date de début</th>
                        <th>Motif</th>
                        <th>Date de fin</th>
                        <th>Nombre de jours</th>
                        <th>Justificatif</th>
                        <th>Attestation de congé</th>
                        <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($conges as $conge)
                        <tr>
                            <td>{{date("d/m/Y", strtotime($conge->date_debut))}}</td>
                            <td>{{$conge->motif}}</td>
                            <td>{{date("d/m/Y", strtotime($conge->date_fin))}}</td>
                            <td>{{$conge->nbrJ}}</td>
                            <td class="t_justificatif">
                                @if ($conge->fichier_justification != null)
                                    <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$conge->code_emp}}/{{$conge->fichier_justification}}" target="_blank" class="lienPDF">
                                        <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                        <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                    </a>
                                
                                @else
                                    NON
                                @endif
                            </td>
                            <td class="t_justificatif">
                                @if ($conge->statut == 1)
                                    <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$conge->code_emp}}/{{$conge->fichier_demande}}" target="_blank" class="lienPDF">
                                        <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                        <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                    </a>
                                
                                @else
                                    
                                @endif
                            </td>
                            <td class="t_statut">
                                {{ 
                                    show_statut_taches($conge->statut) 
                                }}
                            </td>

                            
                            
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
            </div>
        </div>


            <!--hr class="mt-3 mb-3"/>

            <div class="row">
                <div class="col-md-12">
                    <a href="" class="" data-toggle="collapse" data-target="#demo" style="color: ; "><h5 style="color: ; text-decoration: underline;">Ajouter une prise de congé</h5></a>


                    <form action="/rh/employes/save_conge" method="POST">
                        @csrf
                        <div id="demo" class="collapse col-md-12">
                            <div class="col-md-8"><hr class="mt-3 mb-3"/></div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Date de début</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="inputDateAff" placeholder="Date" name="date_debut" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Date de fin</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="inputDateAff" placeholder="Date" name="date_fin" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Motif</label>
                                        <div class="col-sm-8">
                                            <select name="motif" id="direct" class="form-control select2" required>
                                                <option selected="selected">
                                                    Congés Payés
                                                </option>
                                                <option >
                                                    Congés Maternité
                                                </option>
                                                <option >
                                                    Congés Paternité
                                                </option>
                                                <option >
                                                    Congés Sabbatique
                                                </option>
                                                <option >
                                                    Congés pour raisons familiales
                                                </option>
                                                <option >
                                                    Congés de reclassement
                                                </option>
                                                <option>
                                                    Congés de longue maladie
                                                </option>
                                                <option >
                                                    Congés d'enseignement ou de recherche
                                                </option>
                                                <option >
                                                    Autre
                                                </option>
                                            </select> 
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <button class="btn btn-success" type="submit">Ajouter</button>
                        </div>
                    </form>
                    
                    
                </div>
            </div-->

            
            
        
    </div><!-- /.card-body -->
</div>
@endsection

@section('customjavascript')

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

}

</script>


<script>

    window.onload = function() {
        $('input:radio[name="motif"]').change(function() {
        if ($(this).val() == 'ANNUEL') {
            $("#demo2").addClass('d-none');
        } else {
            $("#demo2").removeClass('d-none');
        }
    });

    }

</script>
  

@endsection