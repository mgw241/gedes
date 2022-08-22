    @extends('client.employes_show_emp')

    @section('contenu2')
    <div class="card">
    <div class="card-header p-2">
        <h3>ABSCENCES</h3>
    </div><!-- /.card-header-->
    <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <h5 style="color: ">Historique des abscences</h5>
                    <div class="col-md-8"><hr class="mt-3 mb-3"/></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date de début</th>
                                <th>Nombre de reprise</th>
                                <th>Motif</th>
                                <th>Demande d'Abscence</th>
                                <th>Justificatif</th>
                                <!--th>Nombre jour demandé</th>
                                <th>Nombre jour accordé</th>
                                <th>Nombre jour sans solde</th-->
                                <th>Statut</th-->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($abscences as $abscence)
                            <tr>
                                <td>{{date("d/m/Y", strtotime($abscence->date_depart))}}</td>
                                <td>{{date("d/m/Y", strtotime($abscence->date_reprise))}}</td>
                                <td>{{$abscence->motif}}</td>
                                <td>
                                    @if ($abscence->justifier == null)
                                        
                                    @else
                                        
                                    @endif
                                    <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$abscence->code_emp}}/{{$abscence->fichier_demande}}" target="_blank" class="lienPDF">
                                        <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                        <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                    </a>
                                    
                                </td>
                                <td>
                                    @if ($abscence->justifier == 1)
                                        <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$employes[0]->code}}/{{$abscence->fichier_justification}}" target="_blank" class="lienPDF">
                                            <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                        </a>
                                    @else
                                        NON
                                    @endif
                                    
                                </td>
                                <!--td>{{$abscence->nbrJ_demande}}</td>
                                <td>{{$abscence->nbrJ_accord}}</td>
                                <td>{{$abscence->nbrJ_accord_ssolde}}</td-->
                                <td class="t_statut">
                                    {{ 
                                        show_statut_taches($abscence->statut) 
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