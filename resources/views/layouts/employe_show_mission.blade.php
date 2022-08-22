    @extends('client.employes_show')

    @section('contenu2')
    <div class="card">
    <div class="card-header p-2">
        <h3>MISSIONS</h3>
    </div><!-- /.card-header-->
    <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <h5 style="color: ">Historique des missions</h5>
                    <div class="col-md-8"><hr class="mt-3 mb-3"/></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date de départ</th>
                                <th>Nombre de retour</th>
                                <th>Motif</th>
                                <th>Ville</th>
                                <!--th>Analyse</th-->
                                <!--th>Demande de mission</th-->
                                <th>Fiche Frais de Mission</th>
                                <th>Ordre de Mission</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($missions as $mission)
                                <tr>        
                                    <td class="t_Date_depart">
                                        {{date("d/m/Y", strtotime($mission->date_debut))}}
                                    </td>
                                    <td class="t_Date_retour">
                                        {{date("d/m/Y", strtotime($mission->date_retour))}}
                                    </td>
                                    <td class="t_Objet">
                                        {{$mission->objet}}
                                    </td>
                                    <td class="t_ville">
                                        {{$mission->ville}}
                                    </td>
                                    <!--td class="t_analyse">
                                        @if ($mission->statut == 2)
                                            <span style="color: rgb(157, 157, 48)">Analyse en cours</span>
                                        @endif
                                        @if ($mission->statut == 1)
                                            <span style="color: rgb(157, 157, 48)">Accordé</span>
                                        @endif
                                        @if ($mission->statut == 0)
                                            <span style="color: rgb(157, 157, 48)">Rejeté</span>
                                        @endif
                                    </td-->
                                    <!--td class="t_demande">
                                    </td-->
                                    <td class="t_frais">
                                        @if ($mission->statut == 1)
                                            <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$mission->code_emp}}/{{$mission->fichier_frais}}" target="_blank" class="lienPDF">
                                                <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                                <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                            </a>
                                        @endif
                                    </td>
                                    <td class="t_ordre">
                                        @if ($mission->statut == 1)
                                            <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$mission->code_emp}}/{{$mission->fichier_ordre}}" target="_blank" class="lienPDF">
                                                <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                                <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                            </a>
                                        @endif
                                    </td>

                                    <td class="t_statut">
                                        {{ 
                                            show_statut_taches($mission->statut) 
                                        }}
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