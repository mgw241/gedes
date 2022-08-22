@extends('client.employes_show_emp')

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
                            <td class="col-md-7">Nombre de jours de l'année en cours :</td>
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
                        <th>Statut de la demande</th>
                        <th>Justificatif</th>
                        <th>Attestation de congé</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($conges as $conge)
                        <tr>
                            <td>{{date("d/m/Y", strtotime($conge->date_debut))}}</td>
                            <td>{{$conge->motif}}</td>
                            <td>{{date("d/m/Y", strtotime($conge->date_fin))}}</td>
                            <td>{{$conge->nbrJ}}</td>
                            <td>
                                {{ 
                                    show_statut_taches($conge->statut) 
                                }}
                            </td>
                            <td>
                                @if ($conge->fichier_justification != null)
                                    <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$conge->code_emp}}/{{$conge->fichier_justification}}" target="_blank" class="lienPDF">
                                        <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                        <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                    </a>
                                
                                @else
                                    NON
                                @endif
                            </td>
                            <td>
                                @if ($conge->statut == 1)
                                    
                                <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$conge->code_emp}}/{{$conge->fichier_demande}}"  target="_blank" class="lienPDF">
                                    
                                    <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                @else
                                    
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
            </div>
        </div>

        
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


@endsection