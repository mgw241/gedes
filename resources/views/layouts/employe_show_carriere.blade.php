    @extends('client.employes_show')

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
        @if (Session('permission')[0]->add == '1')
            <div class="row">
                <div class="col-md-12">
                    <a href="" class="" data-toggle="collapse" data-target="#demo" style="color: ; "><h5 style="color: ; text-decoration: underline;">Ajouter une affectation à l'employé</h5></a>


                    <form action="/rh/employes/save_affectation" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div id="demo" class="collapse col-md-12">
                            <div class="col-md-8"><hr class="mt-3 mb-3"/></div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Date d'affectation</label>
                                        
                                        <div class="col-sm-8">
                                            <input type="hidden" name="employe" value="{{$employes[0]->code}}">
                                            <input type="date" class="form-control" id="inputDateAff" placeholder="Date" name="date_affect"  min="1990-01-01" value="<?php echo $today; ?>"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Contrat</label>
                                        <div class="col-sm-8">
                                            <input id="contrat_emp" class="form-control" type="file"  accept="application/pdf"  name="contrat_emp" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Direction</label>
                                        <div class="col-sm-8">
                                            <select name="direction" id="direct" class="form-control select2" required>
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
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Poste: </label>
                                        <div class="col-sm-8">
                                            <select name="sel_poste" id="sel_poste" class="form-control select2" required>
                                                        
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Salaire</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="salaireAffect" name="salaireAffect" minlength="5" maxlength="10" value="{{$employes[0]->salaire}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Type de contrat</label>
                                        <div class="col-sm-8">
                                            <select name="type_contrat" id="" class="form-control select2">
                                                @foreach ($contrats as $contrat)
                                                    <option value="{{$contrat->type}}">
                                                        {{$contrat->type}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-success" type="submit">Ajouter</button>
                        </div>
                    </form>
                    
                    
                </div>
            </div>

            <hr class="mt-3 mb-3"/>
        @endif
        
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