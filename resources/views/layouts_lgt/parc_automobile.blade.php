
@extends('client.apprh', ['titre' => 'Parc Automobile'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Parc Automobile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                      <li class="breadcrumb-item active">Parc Automobile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-12">

                <div class="card">
                    @if (Session('permission')[0]->add == '1')
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-5">
                                    <button class="btn btn-app bg-success tabBtnAdd" data-toggle="modal" id="tabBtnAdd" data-placement="right" title="Ajouter une nouvelle direction">
                                        <i class="fas fa-plus"></i> Ajouter Véhicule
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <!--h2 style="color: darkred">Abscences</h2-->
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                        <thead>
                        <tr>
                            <th>Images</th>
                            <th>Matricule</th>
                            <th>Marque</th>
                            <th>Model</th>
                            <th>Nom</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehicules as $vehicule)
                                <tr style="cursor: pointer" onclick="window.location='/logistique_securite/parc_automobile/{{$vehicule->matricule}}/identification';">  

                                    <td class="t_libelle"><img src="{{config('app.DOSSIER_PARC_AUTO_storage')."".$vehicule->matricule."/".$vehicule->image1}}" width="65px" data-title="Image Avant"></td>

                                    <td class="t_code">{{$vehicule->matricule}}<input readonly type="hidden" class="idH" id="idH" value="{{$vehicule->matricule}}"></td>

                                    <td class="t_marque">{{$vehicule->libelle_marque}}</td>

                                    <td class="t_modele">{{$vehicule->modele}}</td>

                                    <td class="t_image">{{$vehicule->nom}}</td>

                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>




<!-- Modal ADD-->
<div id="myModalADD" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-xl"> <!-- modal-lg-->
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter un Véhicule</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/logistique_securite/save_add_vehicule'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-group">Matricule : (*)</label>
                                    <input class="form-control" type="text"  name="matricule" placeholder="SBGT45471" required onkeyup="
                                        var start = this.selectionStart;
                                        var end = this.selectionEnd;
                                        this.value = this.value.toUpperCase();
                                        this.setSelectionRange(start, end);" pattern=".{2,15}" minlength="2" maxlength="15" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-group">Marque : </label>
                                <select name="marque" id="marque" class="form-control select2" required>         
                                    <option value="">
                                        /****   Selectionnez    ***/
                                    </option>
                                    @foreach ($marques as $marque)
                                        <option value="{{$marque->id}}">{{$marque->libelle}}</option>
                                    @endforeach            
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-group">N° de série : (*)</label>
                                <input class="form-control" type="text"  name="serie" placeholder="ex: M7TC4WLAM0403916" required onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);" minlength="5" maxlength="25">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-group">Modele : </label>
                                <!--select name="modele" id="modele" class="form-control select2" required>         
                                    <option value="">
                                        /****   Selectionnez    ***/
                                    </option>
                                    @foreach ($modeles as $modele)
                                        <option value="{{$modele->id}}">{{$modele->libelle}}</option>
                                    @endforeach            
                                </select-->
                                <input class="form-control" type="text"  name="modele" placeholder="ex: HIACE" required onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);" minlength="3" maxlength="30">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-group">Genre : </label>
                                <select name="genre" id="genre" class="form-control select2" required>         
                                    <option value="">
                                        /****   Selectionnez    ***/
                                    </option>
                                    @foreach ($genres as $genre)
                                        <option value="{{$genre->id}}">{{$genre->libelle}}</option>
                                    @endforeach            
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-group">Source : </label>
                                <select name="source" id="source" class="form-control select2" required>         
                                    <option value="">
                                        /****   Selectionnez    ***/
                                    </option>
                                    @foreach ($sources as $source)
                                        <option value="{{$source->id}}">{{$source->libelle}}</option>
                                    @endforeach            
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-group">Puissance : </label>
                                <input class="form-control" type="text"  name="puissance" placeholder="ex: 12" required onkeyup="
                                    var start = this.selectionStart;
                                    var end = this.selectionEnd;
                                    this.value = this.value.toUpperCase();
                                    this.setSelectionRange(start, end);" pattern="[0-9]*" minlength="1" maxlength="2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-group">Nombre de place : </label>
                                <select name="nbr_place" id="nbr_place" class="form-control select2" required>
                                    <option value="1" selected>1</option>       
                                    <option value="2" >2</option>       
                                    <option value="4" >4</option>   
                                    <option value="5" >5</option>       
                                    <option value="6" >6</option>       
                                    <option value="7" >7</option>       
                                    <option value="9" >9</option>       
                                    <option value="10" >10</option>      
                                    <option value="12" >12</option>      
                                    <option value="13" >13</option>      
                                    <option value="14" >14</option>         
                                    <option value="15" >15</option>       
                                    <option value="16">16</option>      
                                    <option value="17">17</option>      
                                    <option value="18">18</option>       
                                    <option value="19">19</option>        
                                    <option value="35">35</option>      
                                    <option value="50">50</option>       
                                    <option value="63">63</option>                
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-group">Charge utile : </label>
                                <input class="form-control" type="number"  name="charge" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-group">Poids à vide (kg): </label>
                                <input class="form-control" type="number"  name="poids_vide" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-group">Date achat : </label>
                                <input type="date" id="start" name="date_achat" placeholder="1990-07-22" min="2009-01-01" class="form-control date" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-group">Date mise en circulation : </label>
                                <input type="date" id="start" name="date_mise_circulation" placeholder="1990-07-22" min="2009-01-01" class="form-control date" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-group">Valeur (CFA): </label>
                                <input class="form-control" type="number"  name="valeur" placeholder="ex: 1000000"  minlength="5" maxlength="9" min="100000" max="1000000000">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-group">Nom (non obligatoire): </label>
                                <input class="form-control" type="text" name="nom" placeholder="ex: Projet SETRAG" onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);">
                            </div>
                        </div>
                    </div>
                    <div class="row">
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


                    <hr class="mt-2 mb-3 lineSeparateur" />

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form-group">Kilometrage Actuel: </label>
                                <input class="form-control" type="text" name="km_actuel" placeholder="ex: 15000" required onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);"  pattern="[0-9]*" minlength="1" maxlength="6">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form-group">Kilometrage Pour Vidange: </label>
                                <input class="form-control" type="text" name="km_vidange" placeholder="ex: 5000" required onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);"  pattern="[0-9]*" minlength="1" maxlength="6">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form-group">Alerte 1 (Km restant avant vidange) : </label>
                                <input class="form-control" type="text" name="alerte1" placeholder="ex: 1000" required onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);"  pattern="[0-9]*" minlength="1" maxlength="6" value="1000">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form-group">Alerte 2 (Km restant avant vidange) : </label>
                                <input class="form-control" type="text" name="alerte2" placeholder="ex: 500" required onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);"  pattern="[0-9]*" minlength="1" maxlength="6" value="500">
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="modal-footer">
                    <input class="btn btn-success" type="submit" value="Ajouter">
                    <button id="commentForm"on type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- /.MODALS -->





@endsection 


@section('customjavascript')
    <!-- Custom js for this page-->
    <script type="text/javascript">
        $('.tabBtnDelete').click(function(){
            //  Recuperer les valeurs de la ligne du bouton clické
            var row = $(this).closest('tr');;   //  . c'est la classe
            var code =  row.find('.t_code').text();
            var libelle =  row.find('.t_libelle').text();
            var idF = $(this)[0].id;

            //  mettre les valeurs dans le madal
            $('#titreDelete').text("Cette action est irréverible. Voulez-vous vraiment supprimer la Direction: "+libelle+" ?");    // # c'est le ID
            $('#idModalDelete').val(idF);    // # c'est le ID

            //  J'afiche deja le Modal
            $('#myModalDelete').modal('show');
            
        });

        $('.tabBtnAdd').click(function(){
                    //  J'afiche deja le Modal
                    $('#myModalADD').modal('show');
        });

        $('.tabBtnEdit').click(function(){
                    var row = $(this).closest('tr');
                    var code =  row.find('.t_code').text();
                    var libelle =  row.find('.t_libelle').text();
                    var direction =  row.find('.t_direction').text();
                    var verion =  row.find('.t_version').text();
                    var pilote =  row.find('.t_pilote').text();
                    var copilote =  row.find('.t_copilote').text();
                    //var idF = $(this)[0].id;
                    $('#code_ed').val(code);
                    $('#libelle_ed').val(libelle);
                    
                    $('#myModalEdit').modal('show');
        });

        function showEdit(element){
            var row = $(element).closest('tr');
            var code =  row.find('.t_code').text();
            var libelle =  row.find('.t_libelle').text();
            var direction =  row.find('.t_direction').text();
            var direction_nom = row.find('td:eq(2)> input').val();
            var version =  row.find('.t_version').text();
            var pilote =  row.find('.t_pilote').text();
            var pilote_code = row.find('td:eq(3)> input').val();
            var copilote =  row.find('.t_copilote').text();
            var copilote_code = row.find('td:eq(4)> input').val();
            var idF = $(element)[0].id;

            var abreviation =  row.find('td:eq(1)> input').val();            
            var nbrProcedure =  row.find('td:eq(5)> input').val();
            
            
            $("#direction_ed > option").each(function() {
                if ($(this).val() == direction) {
                    //$(this).attr("selected", true);
                    $("#direction_ed option[value="+direction+"]").remove();
                    $("#direction_ed").append("<option value='"+direction+"' selected>"+direction_nom+"</option>");
                }
            });


            $.ajax({
                url: '/get_pilotes_of_procedussus',
                type: 'post',
                data:{
                    "direction": direction,
                    "_token": "{{ csrf_token() }}",
                    },
                success: function(data){

                    var len = data.length;

                    $("#pilote_ed").empty();

                    //$("#departement").append("<option selected>/****Selectionnez*****/</option>");
                    for( var i = 0; i<len; i++){
                        
                        var code_ = data[i]['code'];
                        var nom_complet = data[i]['nom_complet'];

                        if(code_ == pilote_code){
                            $("#pilote_ed").append("<option value='"+code_+"' selected>"+nom_complet+"</option>");
                            $('#pilote_ed').prop('change', true);
                        }else{
                            $("#pilote_ed").append("<option value='"+code_+"' >"+nom_complet+"</option>");
                            $('#pilote_ed').prop('change', true);
                        }
                    }
                    
                }
            });

            $.ajax({
                url: '/get_poste_of_direction',
                type: 'post',
                data:{
                    "direction": direction,
                    "_token": "{{ csrf_token() }}",
                    },
                success: function(data){


                    var len = data.length;

                    $("#copilote_ed").empty();
                    // Copilote Vide
                    $("#copilote_ed").append("<option value='AUCUN' selected>AUCUN</option>");
                    $('#copilote_ed').prop('change', true);
                    for( var i = 0; i<len; i++){
                        var code_ = data[i]['code'];
                        var nom_complet = data[i]['nom_complet'];
                        
                        if(code_ != pilote_ed.value){
                            if( code_ == copilote_code){
                                $("#copilote_ed").append("<option value='"+code_+"' selected>"+nom_complet+"</option>");
                                $('#copilote_ed').prop('change', true);
                            }else{
                                $("#copilote_ed").append("<option value='"+code_+"' >"+nom_complet+"</option>");
                                $('#copilote_ed').prop('change', true);
                            }
                        }
                    }
                    
                }
            });

            $("#nbr_procedure_ed").empty();
            for( var i = 1; i<8; i++){
                if(i == nbrProcedure){
                    $("#nbr_procedure_ed").append("<option value='"+i+"' selected>"+i+"</option>");
                    $('#nbr_procedure_ed').prop('change', true);
                }else{
                    $("#nbr_procedure_ed").append("<option value='"+i+"' >"+i+"</option>");
                    $('#nbr_procedure_ed').prop('change', true);
                }
            }

            
            $('#code_ed').val(abreviation);
            $('#id').val(idF);
            $('#libelle_ed').val(libelle);
            $('#version_ed').val(version);
            //alert(code+ ' '+libelle);
            
            $('#myModalEdit').modal('show');
        }

        function showDelete(element){
            //  Recuperer les valeurs de la ligne du bouton clické
            var row = $(element).closest('tr');;   //  . c'est la classe
            var code =  row.find('.t_code').text();
            var libelle =  row.find('.t_libelle').text();
            var idF = $(element)[0].id;
            

            $.ajax({
                url: '/get_nbr_procedures_of_vehicule',
                type: 'post',
                data:{
                    "id": idF,
                    "_token": "{{ csrf_token() }}",
                    },
                success: function(data){
                    nbrProcess = data[0]['nbr'];
                    //alert(nbrProcess);
                    if(nbrProcess > 0){
                        //  mettre les valeurs dans le madal
                        document.getElementById("titreDelete0").innerHTML = "le vehicule <b> "+libelle+"</b> contient <b>"+nbrProcess+"</b> Procédure (s). Suprimez-les en premier ?";
                        $('#idModalDelete0').val(idF);    // # c'est le ID
                        lien = document.getElementById('lienProcedures');
                        lien.href = "/documentaire/vehicule/"+code+"/procedures";
                        $('#lienProcedures').val(idF);    // # le lien des procedures

                        //  J'afiche deja le Modal
                        $('#myModalDelete0').modal('show');
                    }else{
                        //  mettre les valeurs dans le madal
                        document.getElementById("titreDelete").innerHTML = "Cette action est irréverible.<br/> Le vehicule sera automatiquement archivés.<br/><br/>Voulez-vous vraiment supprimer le vehicule:<b> "+libelle+"</b> ?";
                        //$('#titreDelete').text("Cette action est irréverible.<br/> Les Procedures et enregistrements de ce vehicule seront aussi supprimés et uniquement visibles dans les archives.<br/><br/>Voulez-vous vraiment supprimer le vehicule:<b> "+libelle+"</b> ?");    // # c'est le ID
                        //alert(idF);
                        $('#idModalDelete').val(idF);    // # c'est le ID

                        //  J'afiche deja le Modal
                        $('#myModalDelete').modal('show');
                    }
                    
                }
            });

            
        }
    </script>

    <script>
        $(function () {
        var table = $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            buttons: [
        {
            extend: 'pdf',
            footer: true,
            exportOptions: {
                columns: [':visible :not(:last-child)']
                }
        },
        {
            extend: 'csv',
            footer: false,
            exportOptions: {
                columns: [':visible :not(:last-child)']
                }
            
        },
        {
            extend: 'excel',
            footer: false,
            exportOptions: {
                columns: [':visible :not(:last-child)']
                }
        },
            {
            extend: 'colvis',
            footer: false,
            exportOptions: {
                columns: [':visible :not(:last-child)']
                }
        } ,        
        ]  ,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        var table2 = $('#example1').DataTable();
        if ( table2.rows(  ).count()  === 0 ) {
            table2.buttons().disable();
        }
        else {
            table2.buttons().enable();
        }
        
        });
    </script>
  

    <script>
        
        window.onload = function() {
            var direct = document.getElementById('direction');
            var direct_ed = document.getElementById('direction_ed');
            var pilote = document.getElementById('pilote');
            var pilote_ed = document.getElementById('pilote_ed');
            /* CHARGER ON LOAD FIRST*/

            $.ajax({
                url: '/get_pilotes_of_procedussus',
                type: 'post',
                data:{
                    "direction": direct.value,
                    "_token": "{{ csrf_token() }}",
                    },
                success: function(data){

                    var len = data.length;

                    $("#pilote").empty();

                    //$("#departement").append("<option selected>/****Selectionnez*****/</option>");
                    for( var i = 0; i<len; i++){
                        var code = data[i]['code'];
                        var nom_complet = data[i]['nom_complet'];
                        
                        $("#pilote").append("<option value='"+code+"' >"+nom_complet+"</option>");
                        $('#pilote').prop('change', true);
                    }
                    
                }
            });
            $.ajax({
                url: '/get_poste_of_direction',
                type: 'post',
                data:{
                    "direction": direct.value,
                    "_token": "{{ csrf_token() }}",
                    },
                success: function(data){

                    var len = data.length;

                    $("#copilote").empty();
                    for( var i = 0; i<len; i++){
                        var code = data[i]['code'];
                        var nom_complet = data[i]['nom_complet'];
                        
                        if(code != pilote.value){
                            $("#copilote").append("<option value='"+code+"' >"+nom_complet+"</option>");
                            $('#copilote').prop('change', true);
                        }
                    }
                    // Copilote Vide
                    $("#copilote").append("<option value='AUCUN' selected>AUCUN</option>");
                    $('#copilote').prop('change', true);
                    
                }
            });
            /* CHARGER ON LOAD FIRST*/

            direct.onchange = function() {
                $.ajax({
                url: '/get_pilotes_of_procedussus',
                type: 'post',
                data:{
                    "direction": direct.value,
                    "_token": "{{ csrf_token() }}",
                    },
                success: function(data){

                    var len = data.length;

                    $("#pilote").empty();

                    //$("#departement").append("<option selected>/****Selectionnez*****/</option>");
                    for( var i = 0; i<len; i++){
                        var code = data[i]['code'];
                        var nom_complet = data[i]['nom_complet'];
                        
                        $("#pilote").append("<option value='"+code+"' >"+nom_complet+"</option>");
                        $('#pilote').prop('change', true);
                    }
                    
                }
                });
                $.ajax({
                    url: '/get_poste_of_direction',
                    type: 'post',
                    data:{
                        "direction": direct.value,
                        "_token": "{{ csrf_token() }}",
                        },
                    success: function(data){

                        var len = data.length;

                        $("#copilote").empty();
                        for( var i = 0; i<len; i++){
                            var code = data[i]['code'];
                            var nom_complet = data[i]['nom_complet'];
                            
                            if(code != pilote.value){
                                $("#copilote").append("<option value='"+code+"' >"+nom_complet+"</option>");
                                $('#copilote').prop('change', true);
                            }
                        }
                        // Copilote Vide
                        $("#copilote").append("<option value='AUCUN' selected>AUCUN</option>");
                        $('#copilote').prop('change', true);
                        
                    }
                });

            }

            direct_ed.onchange = function() {
                $.ajax({
                url: '/get_pilotes_of_procedussus',
                type: 'post',
                data:{
                    "direction": direct_ed.value,
                    "_token": "{{ csrf_token() }}",
                    },
                success: function(data){

                    var len = data.length;

                    $("#pilote_ed").empty();

                    //$("#departement").append("<option selected>/****Selectionnez*****/</option>");
                    for( var i = 0; i<len; i++){
                        var code = data[i]['code'];
                        var nom_complet = data[i]['nom_complet'];
                        
                        $("#pilote_ed").append("<option value='"+code+"' >"+nom_complet+"</option>");
                        $('#pilote_ed').prop('change', true);
                    }
                    
                }
                });
                $.ajax({
                    url: '/get_poste_of_direction',
                    type: 'post',
                    data:{
                        "direction": direct_ed.value,
                        "_token": "{{ csrf_token() }}",
                        },
                    success: function(data){

                        var len = data.length;

                        $("#copilote_ed").empty();
                        for( var i = 0; i<len; i++){
                            var code = data[i]['code'];
                            var nom_complet = data[i]['nom_complet'];
                            
                            if(code != pilote.value){
                                $("#copilote_ed").append("<option value='"+code+"' >"+nom_complet+"</option>");
                                $('#copilote_ed').prop('change', true);
                            }
                        }
                        // Copilote Vide
                        $("#copilote_ed").append("<option value='AUCUN' selected>AUCUN</option>");
                        $('#copilote_ed').prop('change', true);
                        
                    }
                });

            }

            /********************/
            /*      PILOTE      */
            /********************/
            pilote.onchange = function() {
                $.ajax({
                    url: '/get_poste_of_direction',
                    type: 'post',
                    data:{
                        "direction": direct.value,
                        "_token": "{{ csrf_token() }}",
                        },
                    success: function(data){
                        //alert('tp');

                        var len = data.length;

                        $("#copilote").empty();

                        //$("#departement").append("<option selected>/****Selectionnez*****/</option>");
                        for( var i = 0; i<len; i++){
                            var code = data[i]['code'];
                            var nom_complet = data[i]['nom_complet'];
                            if(code != pilote.value){
                                $("#copilote").append("<option value='"+code+"' >"+nom_complet+"</option>");
                                $('#copilote').prop('change', true);
                            }
                        }
                        // Copilote Vide
                        $("#copilote").append("<option value='AUCUN' selected>AUCUN</option>");
                        $('#copilote').prop('change', true);
                        
                    }
                });

            }

            pilote_ed.onchange = function() {
                $.ajax({
                    url: '/get_poste_of_direction',
                    type: 'post',
                    data:{
                        "direction": direct_ed.value,
                        "_token": "{{ csrf_token() }}",
                        },
                    success: function(data){
                        //alert('tp');

                        var len = data.length;

                        $("#copilote_ed").empty();

                        //$("#departement").append("<option selected>/****Selectionnez*****/</option>");
                        for( var i = 0; i<len; i++){
                            var code = data[i]['code'];
                            var nom_complet = data[i]['nom_complet'];
                            if(code != pilote_ed.value){
                                $("#copilote_ed").append("<option value='"+code+"' >"+nom_complet+"</option>");
                                $('#copilote_ed').prop('change', true);
                            }
                        }
                        // Copilote Vide
                        $("#copilote_ed").append("<option value='AUCUN' selected>AUCUN</option>");
                        $('#copilote_ed').prop('change', true);
                        
                    }
                });

            }
        }
    </script>
@endsection
