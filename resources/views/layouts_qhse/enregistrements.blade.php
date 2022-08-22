
@extends('client.apprh', ['titre' => 'Enregistrements'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Enregistrements</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                      <li class="breadcrumb-item active">Enregistrements</li>
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
                                            <i class="fas fa-plus"></i> Ajouter Procedure
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
                                <th>Code</th>
                                <th>Libelle</th>
                                <th>Version</th>
                                <th>Procedure</th>
                                <th>Fichier</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($enregistrements as $enregistrement)
                                    <tr >        
                                        <td class="t_code">{{$enregistrement->code}}</td>

                                        <td class="t_libelle">{{$enregistrement->libelle}}</td>
    
                                        <td class="t_version">{{$enregistrement->version}}</td>
    
                                        <td class="t_procedure">{{$enregistrement->procedure_code}}<input readonly type="hidden" class="idProcedure" id="idProcedure" value="{{$enregistrement->procedure_id}}"></td>
    
                                        <td class="t_fichier">
                                            <a onclick="event.stopImmediatePropagation();" href="{{config('app.DOSSIER_PROCESSUS_storage').$enregistrement->process_code.'/'.$enregistrement->procedure_code.'/'.$enregistrement->fichier}}" target="_blank" class="lienPDF">
                                                <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                                <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                            </a>    
                                        </td>
                                        
                                        <td class="t_action" style="text-align: center">
                                            @if (Session('permission')[0]->edit == '1')
                                                <a class="tabBtnEdit popupetat" id="{{$enregistrement->id}}"  data-toggle="modal" id="tabBtnShow" data-placement="right" title="Editer" onclick="event.stopImmediatePropagation(); showEdit(this);"><i class="fas fa-lg fa-edit"></i></a>
                                            @endif
        
                                            @if (Session('permission')[0]->delete == '1')
                                                <a class="tabBtnDelete" id="{{$enregistrement->id}}" data-toggle="modal" data-placement="right" title="Supprimer"><i class="fas fa-lg  fa-trash" onclick="event.stopImmediatePropagation(); showDelete(this);"></i></a>
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
                    <h4 class="modal-title">Ajouter un Enregistrement</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form class="cmxform" method="post" action="{{'/documentaire/save_add_enregistrement'}}" enctype="multipart/form-data">
                    @csrf 
                    <div class="modal-body"> 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form-group">Réference : (*)</label>
                                    <input class="form-control" type="text"  name="code" placeholder="ex: FI.STRAF.PR.DTSI.OPM.01" required onkeyup="
                                    var start = this.selectionStart;
                                    var end = this.selectionEnd;
                                    this.value = this.value.toUpperCase();
                                    this.setSelectionRange(start, end);" value="FI.">
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
                                    this.setSelectionRange(start, end);">
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form-group">Procedure : </label>
                                    <select name="procedure" id="procedure" class="form-control select2" required>
                                        @foreach ($procedures as $procedure)
                                            <option value="{{$procedure->id}}">
                                                {{$procedure->code.' : '.$procedure->libelle}}
                                            </option>
                                        @endforeach
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
                    <h4 class="modal-title">Editer un Enregistrement</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form class="cmxform" method="post" action="{{'/documentaire/save_edit_enregistrement'}}" enctype="multipart/form-data">
                    @csrf 
                    <div class="modal-body"> 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form-group">Réference : (*)</label>
                                    <input class="form-control" type="text"  name="code_ed" id="code_ed" placeholder="ex: STRAF.PR.DTSI.OPM.01" required onkeyup="
                                    var start = this.selectionStart;
                                    var end = this.selectionEnd;
                                    this.value = this.value.toUpperCase();
                                    this.setSelectionRange(start, end);">
                                    <input class="form-control" type="text"  name="id" id="id"  required readonly hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form-group">Libelle : </label>
                                    <input class="form-control" type="text" name="libelle_ed" id="libelle_ed"  placeholder="ex: OPTIMISATION PROCEDURE MAINTENANCE" required onkeyup="
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form-group">Procedure : </label>
                                    <select name="procedure_ed" id="procedure_ed" class="form-control select2" required>
                                        
                                        
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
                    <h4 class="modal-title"  >Supprimer Enregistrement</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="titreDelete">

                </div>
                
                <form class="cmxform" id="commentForm" method="post" action="{{'/documentaire/save_delete_enregistrement'}}">
                    @csrf 
                    <div class="modal-footer">
                        <input class="form-control" type="hidden" id="idModalDelete" name="code_del">
                        <input class="btn btn-success" type="submit" value="OUI">
                        <button type="button" class="btn btn-default" data-dismiss="modal">NON</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    <!-- /.MODALS -->

    
    
@endsection 
    
    
@section('customjavascript')
    
    <script type="text/javascript">

        $('.tabBtnAdd').click(function(){
                    //  J'afiche deja le Modal
                    $('#myModalADD').modal('show');
        });


        function showEdit(element){
            var row = $(element).closest('tr');
            var code =  row.find('.t_code').text();
            var libelle =  row.find('.t_libelle').text();
            var direction =  row.find('.t_direction').text();
            var processus =  row.find('.t_process').text();
            //var direction_nom = row.find('td:eq(2)> input').val();
            var version =  row.find('.t_version').text();
            var idF = $(element)[0].id;


            $("#procedure_ed").empty();

            <?PHP
                foreach ($procedures as $procedure){

            ?> 
                    if ('<?PHP echo $procedure->code; ?>' ==  processus) {
                        $("#procedure_ed").append("<option value='<?PHP echo $procedure->id; ?>' selected><?PHP echo $procedure->code.' : '.$procedure->libelle ?></option>");
                        $('#procedure_ed').prop('change', true);
                    }else{
                        $("#procedure_ed").append("<option value='<?PHP echo $procedure->id; ?>' ><?PHP echo $procedure->code.' : '.$procedure->libelle ?></option>");
                        $('#procedure_ed').prop('change', true);
                    }
                
            <?PHP
                }
            ?>
            
            $('#code_ed').val(code);
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

            //  mettre les valeurs dans le madal
            document.getElementById("titreDelete").innerHTML = "Cette action est irréverible.<br/> La Procédure sera automatiquement archivée.<br/><br/>Voulez-vous vraiment supprimer la Procédure:<b> "+libelle+"</b> ?";
            //$('#titreDelete').text("Cette action est irréverible.<br/> Les Procedures et enregistrements de ce Processus seront aussi supprimés et uniquement visibles dans les archives.<br/><br/>Voulez-vous vraiment supprimer le Processus:<b> "+libelle+"</b> ?");    // # c'est le ID
            $('#idModalDelete').val(idF);    // # c'est le ID

            //  J'afiche deja le Modal
            $('#myModalDelete').modal('show');
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
      
@endsection
    