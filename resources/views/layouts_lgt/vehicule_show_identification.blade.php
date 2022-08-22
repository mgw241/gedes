    @extends('client.vehicule_show')

    @section('contenu2')
                                        <?php 
                                            $month = date('m');
                                            $day = date('d');
                                            $year = date('Y');

                                            $today = $year . '-' . $month . '-' . $day;
                                        ?>
<style>
    .form-group label{
        color: #007bff;
        font-weight: normal;
        border-top: none;   
    }
    
    .form-control{
        font-weight: bold;
    }
    .select2{
        font-weight: bold;
    }
</style>
    <div class="card">
        <form method="POST" action="{{'/logistique_securite/vehicule/edit_identification'}}" enctype="multipart/form-data">
            @csrf 
            <div class="card-header p-2">
                <h3>IDENTIFICATION</h3>
            </div><!-- /.card-header-->
            <div class="card-body">

                <div class="row">
                    <div class="col-md-12 row">
                            <!--h5 style="color: ">Fonction Actuelle</h5-->

                        <div class="form-group row col-md-6 ">
                            <label for="inputPassword" class="col-sm-4 col-form-label" style="text-align: right;font-weight: normal;">Matricule : </label>
                            <div class="col-sm-8">
                                <input class="form-control " type="text"  name="matricule" placeholder="SBGT45471" required onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);" pattern=".{2,15}" minlength="2" maxlength="15" value="{{$vehicule[0]->matricule}}" readonly required >

                                <input type="hidden" readonly id="matricule" name="matricule" value="{{$vehicule[0]->matricule}}">
                            </div>
                        </div>
                    
                        <div class="form-group row col-md-6 ">
                            <label for="inputPassword" class="col-sm-4 col-form-label" style="text-align: right;font-weight: normal;">Marque : </label>
                            <div class="col-sm-8">
                                <select name="marque" id="marque" class="form-control select2" required>         
                                    <option value="">
                                        /****   Selectionnez    ***/
                                    </option>
                                    @foreach ($marques as $marque)
                                        <option value="{{$marque->id}}" {{ $marque->id == $vehicule[0]->marque ? "selected" : ""}}>{{$marque->libelle}}</option>
                                    @endforeach            
                                </select>
                            </div>
                        </div>
                    
                        <div class="form-group row col-md-6 ">
                            <label for="inputPassword" class="col-sm-4 col-form-label" style="text-align: right;font-weight: normal;">N° de série : </label>
                            <div class="col-sm-8">
                            <input class="form-control" type="text"  name="serie" placeholder="ex: M7TC4WLAM0403916" required onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);" minlength="5" maxlength="25" value="{{$vehicule[0]->numero_serie}}" >
                            </div>
                        </div>
                    
                        <div class="form-group row col-md-6 ">
                            <label for="inputPassword" class="col-sm-4 col-form-label" style="text-align: right;font-weight: normal;">Modèle : </label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text"  name="modele" placeholder="ex: HIACE" required onkeyup="
                                    var start = this.selectionStart;
                                    var end = this.selectionEnd;
                                    this.value = this.value.toUpperCase();
                                    this.setSelectionRange(start, end);" minlength="3" maxlength="30" value="{{$vehicule[0]->modele}}" >
                            </div>
                        </div>
                    
                        <div class="form-group row col-md-6 ">
                            <label for="inputPassword" class="col-sm-4 col-form-label" style="text-align: right;font-weight: normal;">Genre : </label>
                            <div class="col-sm-8">
                                <select name="genre" id="genre" class="form-control select2" required>         
                                    <option value="">
                                        /****   Selectionnez    ***/
                                    </option>
                                    @foreach ($genres as $genre)
                                        <option value="{{$genre->id}}" {{ $genre->id == $vehicule[0]->genre ? "selected" : ""}}>{{$genre->libelle}}</option>
                                    @endforeach            
                                </select>
                            </div>
                        </div>
                    
                        <div class="form-group row col-md-6 " >
                            <label for="inputPassword" class="col-sm-4 col-form-label" style="text-align: right;font-weight: normal;;font-weight: normal;">Source : </label>
                            <div class="col-sm-8">
                                <select name="source" id="source" class="form-control select2" required>         
                                    <option value="">
                                        /****   Selectionnez    ***/
                                    </option>
                                    @foreach ($sources as $source)
                                        <option value="{{$source->id}}" {{ $source->id == $vehicule[0]->source ? "selected" : ""}}>{{$source->libelle}}</option>
                                    @endforeach            
                                </select>
                            </div>
                        </div>
                
                        <div class="form-group row col-md-6 ">
                            <label for="inputPassword" class="col-sm-4 col-form-label" style="text-align: right;font-weight: normal;">Puissance : </label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text"  name="puissance" placeholder="ex: 12" required onkeyup="
                                    var start = this.selectionStart;
                                    var end = this.selectionEnd;
                                    this.value = this.value.toUpperCase();
                                    this.setSelectionRange(start, end);" pattern="[0-9]*" minlength="1" maxlength="2" value="{{$vehicule[0]->puissance}}" >
                            </div>
                        </div>


                        <div class="form-group row col-md-6 " >
                            <label for="inputPassword" class="col-sm-4 col-form-label" style="text-align: right;font-weight: normal;;font-weight: normal;">Nombre de place : </label>
                            <div class="col-sm-8">
                                <input class="form-control" type="number"  name="nbr_place" placeholder="ex: 7" required  value="{{$vehicule[0]->nbr_place}}" min="2" max="60">
                            </div>
                        </div>

                        <div class="form-group row col-md-6 " >
                            <label for="inputPassword" class="col-sm-4 col-form-label" style="text-align: right;font-weight: normal;;font-weight: normal;">Charge utile :</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="number"  name="charge" placeholder="ex: 605" required  value="{{$vehicule[0]->charge}}">
                            </div>
                        </div>

                        <div class="form-group row col-md-6 " >
                            <label for="inputPassword" class="col-sm-4 col-form-label" style="text-align: right;font-weight: normal;;font-weight: normal;">Poids à vide (kg) :</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="number"  name="poids_a_vide" placeholder="ex: 605" required  value="{{$vehicule[0]->poids_a_vide}}">
                            </div>
                        </div>

                        <div class="form-group row col-md-6 " >
                            <label for="inputPassword" class="col-sm-4 col-form-label" style="text-align: right;font-weight: normal;;font-weight: normal;">Date achat   :</label>
                            <div class="col-sm-8">
                                <input type="date" id="start" name="date_achat" placeholder="1990-07-22" min="2009-01-01" class="form-control date" required value="{{$vehicule[0]->date_achat}}">
                            </div>
                        </div>

                        <div class="form-group row col-md-6 " >
                            <label for="inputPassword" class="col-sm-4 col-form-label" style="text-align: right;font-weight: normal;;font-weight: normal;">Date circulation   :</label>
                            <div class="col-sm-8">
                                <input type="date" id="start" name="date_mise_circulation" placeholder="1990-07-22" min="2009-01-01" class="form-control date" required value="{{$vehicule[0]->date_mise_circulation}}">
                            </div>
                        </div>

                        <div class="form-group row col-md-6 " >
                            <label for="inputPassword" class="col-sm-4 col-form-label" style="text-align: right;font-weight: normal;;font-weight: normal;">valeur (F. Cfa) :</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="number"  name="valeur" placeholder="ex: 1000000" required  value="{{$vehicule[0]->valeur}}" minlength="5" maxlength="9" min="100000" max="1000000000">
                            </div>
                        </div>

                        <div class="form-group row col-md-6 " >
                            <label for="inputPassword" class="col-sm-4 col-form-label" style="text-align: right;font-weight: normal;;font-weight: normal;">Nom :</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="nom" placeholder="ex: Projet SETRAG" onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);"  value="{{$vehicule[0]->nom}}">
                            </div>
                        </div>
                        
                        <div class="row col-md-12">
                            <div class="col-md-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image1" name="image1" accept="image/*">
                                    <label class="custom-file-label" data-browse="Parcourir" for="customFile">Photo Avant</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                            <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image2" name="image2" accept="image/*">
                                    <label class="custom-file-label" data-browse="Parcourir" for="customFile">Photo Gauche</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image3" name="image3" accept="image/*">
                                    <label class="custom-file-label" data-browse="Parcourir" for="customFile">Photo Derrière</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image4" name="image4" accept="image/*">
                                    <label class="custom-file-label" data-browse="Parcourir" for="customFile">Photo Droite</label>
                                </div>
                            </div>

                        </div>
                                
                        
                    </div>
                </div>
                
            </div><!-- /.card-body -->
            @if (Session('permission')[0]->edit == '1')
                <div class="card-footer p-2">
                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Enregistrer les modifications apportées à l'Identification de ce véhicule" class="btn btn-warning" name="edit" value="edit" >
                        Modifier
                    </button>

                <!--/form>
                    <button type="submit" data-toggle="tooltip" data-placement="right" title="Désactiver ce véhicule de la flotte" class="btn btn-danger" name="delete" value="delete"  style="float: right">
                        Supprimer ce Véhicule
                    </button-->
                </div><!-- /.card-footer-->

            @endif
        </form>
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