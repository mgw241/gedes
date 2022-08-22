
@extends('client.apprh', ['titre' => 'Procédures'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Processus</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                      <li class="breadcrumb-item active">Processus</li>
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
                                        <i class="fas fa-plus"></i> Ajouter Processus
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
                            <th>Réference</th>
                            <th>Libelle</th>
                            <th>Direction</th>
                            <th>Pilote</th>
                            <th>Co-Pilote</th>
                            <th>Version</th>
                            <th>Fichier</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($processuss as $processus)
                                <tr style="cursor: pointer" onclick="window.location='/documentaire/processus/{{$processus->code}}';">        
                                    <td class="t_code">{{$processus->code}}<input readonly type="hidden" class="idH" id="idH" value="{{$processus->id}}"></td>

                                    <td class="t_libelle">{{$processus->libelle}}<input readonly type="hidden" class="abreviation" id="abreviation" value="{{$processus->abreviation}}"></td>

                                    <td class="t_direction">{{$processus->direction_code}}<input readonly type="hidden" class="direction_nom" id="direction_nom" value="{{$processus->direction_nom}}"></td>

                                    <td class="t_pilote">{{$processus->postepilote}}<input readonly type="hidden" class="idPilote" id="idPilote" value="{{$processus->pilote}}"></td>

                                    <td class="t_copilote">
                                        @if ($processus->copilote != NULL )
                                            {{$processus->postecopilote}}<input readonly type="hidden" class="idCopilote" id="idCopilote" value="{{$processus->copilote}}">
                                        @else
                                            <input readonly type="hidden" class="idCopilote" id="idCopilote" value="{{$processus->copilote}}">
                                        @endif
                                    </td>

                                    <td class="t_version">{{$processus->version}}<input readonly type="hidden" class="nbrProcedure" id="nbrProcedure" value="{{$processus->nbr_procedure}}"></td>

                                    <td class="t_fichier" >
                                        <a onclick="event.stopImmediatePropagation();" href="/storage/{{'QHSE/'.$processus->code}}/{{$processus->fichier}}" target="_blank" class="lienPDF">
                                            <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                            <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                        </a>
                                    </td>
                                    
                                    <td class="t_action" style="text-align: center">
                                        
                                    @if (Session('permission')[0]->edit == '1')
                                        <a class="tabBtnEdit popupetat" id="{{$processus->id}}"  data-toggle="modal" id="tabBtnShow" data-placement="right" title="Editer" onclick="event.stopImmediatePropagation(); showEdit(this);"><i class="fas fa-lg fa-edit"></i></a>
                                    @endif

                                    @if (Session('permission')[0]->delete == '1')
                                        <a class="tabBtnDelete" id="{{$processus->id}}" data-toggle="modal" data-placement="right" title="Supprimer" onclick="event.stopImmediatePropagation(); showDelete(this);"><i class="fas fa-lg  fa-trash"></i></a>
                                    @endif
                                    </td>
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
    <div class="modal-dialog modal-lg"> <!-- modal-lg-->
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter un Processus</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/documentaire/save_add_processus'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Réference : (*)</label>
                                <div class="row">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text"  name="start" required onkeyup="
                                            var start = this.selectionStart;
                                            var end = this.selectionEnd;
                                            this.value = this.value.toUpperCase();
                                            this.setSelectionRange(start, end);" value="FIP." readonly>
                                    </div>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text"  name="code" placeholder="ex: GSI" required onkeyup="
                                            var start = this.selectionStart;
                                            var end = this.selectionEnd;
                                            this.value = this.value.toUpperCase();
                                            this.setSelectionRange(start, end);" pattern="[A-Za-z_]{2,4}" minlength="2" maxlength="4" >
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Libelle : </label>
                                <input class="form-control" type="text" name="libelle" placeholder="ex: GESTION DES SYSTEMES D'INFORMATION" required onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Version : </label>
                                <input class="form-control" type="text"  name="version" placeholder="ex: 01" required onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);" value="01">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Fichier (PDF): </label>
                                <input id="fichier" class="form-control" type="file"  accept="application/pdf"  name="fichier" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Direction : </label>
                                {!! Form::select('code', $directions, '', ['class' => 'form-control select2', 'name' => 'direction', 'id' => 'direction']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Pilote : </label>
                                <select name="pilote" id="pilote" class="form-control select2" required>
                                                        
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Copilote : </label>
                                <select name="copilote" id="copilote" class="form-control select2">
                                                        
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Nombre de Procédures : </label>
                                <select name="nbr_procedure" id="nbr_procedure" class="form-control select2" required>
                                    <option value="1" selected>1</option>       
                                    <option value="2" >2</option>       
                                    <option value="3" >3</option>       
                                    <option value="4" >4</option>   
                                    <option value="5" >5</option>       
                                    <option value="6" >6</option>       
                                    <option value="7" >7</option>       
                                    <option value="8" >8</option>       
                                    <option value="9" >9</option>       
                                    <option value="10" >10</option>                
                                </select>
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


<!-- Modal EDIT-->
<div id="myModalEdit" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg"> <!-- modal-lg-->
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editer un Processus</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/documentaire/save_edit_processus'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Réference : (*)</label>
                                <div class="row">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text"  name="start" required onkeyup="
                                            var start = this.selectionStart;
                                            var end = this.selectionEnd;
                                            this.value = this.value.toUpperCase();
                                            this.setSelectionRange(start, end);" value="FIP." readonly>
                                    </div>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text"  name="code_ed" id="code_ed" placeholder="ex: GSI" required onkeyup="
                                            var start = this.selectionStart;
                                            var end = this.selectionEnd;
                                            this.value = this.value.toUpperCase();
                                            this.setSelectionRange(start, end);" pattern="[A-Za-z_]{2,4}" minlength="2" maxlength="4" >
                                             <input class="form-control" type="text"  name="id" id="id"  required readonly hidden>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Libelle : </label>
                                <input class="form-control" type="text" name="libelle_ed" id="libelle_ed"  placeholder="ex: GESTION DES SYSTEMES D'INFORMATION" required onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Version : </label>
                                <input class="form-control" type="text"  name="version_ed" id="version_ed" placeholder="ex: 01" required onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Fichier (PDF): </label>
                                <input id="fichier_ed" class="form-control" type="file"  accept="application/pdf"  name="fichier_ed">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Direction : </label>
                                {!! Form::select('code', $directions, '', ['class' => 'form-control select2', 'name' => 'direction_ed', 'id' => 'direction_ed']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Pilote : </label>
                                <select name="pilote_ed" id="pilote_ed" class="form-control select2" required>
                                                        
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Copilote : </label>
                                <select name="copilote_ed" id="copilote_ed" class="form-control select2" required>
                                                        
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Nombre de Procédures : </label>
                                <select name="nbr_procedure_ed" id="nbr_procedure_ed" class="form-control select2" required>
                                                   
                                </select>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="modal-footer">
                    <input class="btn btn-success" type="submit" value="Modifier">
                    <button id="commentForm"on type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- /.MODALS -->


<!-- Modal  SUPPRMMER-->
<div id="myModalDelete" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"  >Supprimer Processus</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="titreDelete">

            </div>
            
            <form class="cmxform" id="commentForm" method="post" action="{{'/documentaire/save_delete_processus'}}">
                @csrf 
                <div class="modal-footer">
                    <input class="form-control" type="hidden" id="idModalDelete" name="id">
                    <input class="btn btn-success" type="submit" value="OUI">
                    <button type="button" class="btn btn-default" data-dismiss="modal">NON</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
<!-- /.MODALS -->
<!-- Modal  SUPPRMMER-->
<div id="myModalDelete0" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"  >Supprimer Processus</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="titreDelete0">

            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-success" id="lienProcedures">OUI</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">NON</button>
            </div>
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
                url: '/get_nbr_procedures_of_processus',
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
                        document.getElementById("titreDelete0").innerHTML = "le Processus <b> "+libelle+"</b> contient <b>"+nbrProcess+"</b> Procédure (s). Suprimez-les en premier ?";
                        $('#idModalDelete0').val(idF);    // # c'est le ID
                        lien = document.getElementById('lienProcedures');
                        lien.href = "/documentaire/processus/"+code+"/procedures";
                        $('#lienProcedures').val(idF);    // # le lien des procedures

                        //  J'afiche deja le Modal
                        $('#myModalDelete0').modal('show');
                    }else{
                        //  mettre les valeurs dans le madal
                        document.getElementById("titreDelete").innerHTML = "Cette action est irréverible.<br/> Le Processus sera automatiquement archivés.<br/><br/>Voulez-vous vraiment supprimer le Processus:<b> "+libelle+"</b> ?";
                        //$('#titreDelete').text("Cette action est irréverible.<br/> Les Procedures et enregistrements de ce Processus seront aussi supprimés et uniquement visibles dans les archives.<br/><br/>Voulez-vous vraiment supprimer le Processus:<b> "+libelle+"</b> ?");    // # c'est le ID
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
