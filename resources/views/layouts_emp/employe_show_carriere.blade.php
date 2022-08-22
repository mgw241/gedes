    @extends('client.employes_show_emp')

    @section('contenu2')
                                        <?php 
                                            $month = date('m');
                                            $day = date('d');
                                            $year = date('Y');

                                            $today = $year . '-' . $month . '-' . $day;
                                        ?>
    <div class="card">
    <div class="card-header p-2">
        <h3>CARRIÈRE</h3>
    </div><!-- /.card-header-->
    <div class="card-body">

            <div class="row">
                <div class="col-md-8">
                    <h5 style="color: ">Fonction Actuelle</h5>
                    <table class="table tablePresentation col-md-12" style="border: 0px">
                        <tbody>
                            <tr>
                                <td class="col-md-3">Poste :</td>
                                <th class="col-md-9">{{$employePoste[0]->poste}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Service :</td>
                                <th class="col-md-9">{{$employePoste[0]->service}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Département :</td>
                                <th class="col-md-9" >{{$employePoste[0]->departement}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Direction :</td>
                                <th class="col-md-9" >{{$employePoste[0]->direction}}</td>
                            </tr>
                            <tr style="border-bottom: none">
                                <td class="col-md-3">Date d'affectation :</td>
                                <th class="col-md-9" style="border-bottom: none">
                                    {{date("d/m/Y", strtotime($employePoste[0]->debut))}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr class="mt-3 mb-3"/>

            <div class="row">
                <div class="col-md-12">
                    <h5 style="color: ">Historique des affectations</h5>
                    <div class="col-md-8"><hr class="mt-3 mb-3"/></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th>Date de début</th>
                            <th>Poste</th>
                            <th>Date de fin</th>
                            <th style="width: 40px">Contrat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($affectations as $affectation)
                            <tr>
                                <td>{{date("d/m/Y", strtotime($affectation->debut))}}</td>
                                <td>{{$affectation->libelle}}</td>
                                <td>
                                    {{$affectation->fin =='' ? 'Contrat en Cours' : date("d/m/Y", strtotime($affectation->fin))}}
                                </td>
                                <td>
                                    <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$employes[0]->code}}/{{$affectation->fichier}}" target="_blank" class="lienPDF">
                                        <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                        <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
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