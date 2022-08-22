
@extends('layouts_config.configuration')


@section('contenu2')
        <div class="row">
            <div class="col-12">

                <div class="card">
                    @if (Session('permission')[0]->add == '1')
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-5">
                                <button class="btn btn-app bg-success tabBtnAdd" data-toggle="modal" id="tabBtnAdd" data-placement="right" title="Ajouter un nouveau service">
                                    <i class="fas fa-plus"></i> Ajouter Service
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
                            <!--th>Code</th-->
                            <th>Libelle du service</th>
                            <th>Département</th>
                            <th>Direction</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr >        
                                    <!--td class="t_code">{{$service->id}}<input type="hidden" class="codeH" id="codeH" value="{{$service->id}}"></td-->

                                    <td class="t_libelle">{{$service->libelle}}</td>

                                    <td class="t_departement" >{{$service->lib_dep}}<input type="hidden" class="codeDep" id="codeDep" value="{{$service->departement_code}}"></td>

                                    <td class="t_direction">{{$service->direction}}</td>

                                    <td class="t_action" style="text-align: center">
                                    @if (Session('permission')[0]->edit == '1')
                                        <a class="tabBtnEdit popupetat" id="{{$service->id}}"  data-toggle="modal" id="tabBtnShow" data-placement="right" title="Editer"><i class="fas fa-lg fa-edit"></i></a>
                                    @endif

                                    @if (Session('permission')[0]->delete == '1')
                                        <a class="tabBtnDelete" id="{{$service->id}}" data-toggle="modal"><i class="fas fa-lg  fa-trash" data-placement="right" title="Supprimer"></i></a>
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
                <h4 class="modal-title">Ajouter un Service</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/configuration/save_add_service'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Libelle : </label>
                                <input class="form-control" type="text" name="libelle" placeholder="exe: Administration du Personnel" required onkeyup="
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
                                <label for="form-group">Direction : </label>
                                {!! Form::select('code', $directions, '', ['class' => 'form-control select2', 'name' => 'direction', 'id' => 'direction']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Département : </label>
                                <select name="departement" id="departement" class="form-control select2" required>
                                                        
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr class="mt-3 mb-3"/>

                    <div style="font-size: 12px">
                        <span style="font-weight: bold">
                            (*) Le libelle est unique par département !
                        </span>                        
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
                <h4 class="modal-title">Modifer le Service</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/configuration/save_edit_service'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Libelle : (*) </label>
                                <input class="form-control" type="text" name="libelle_ed" placeholder="exe: Administration du Personnel" id="libelle_ed" required onkeyup="
                                var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);">
                                <input type="hidden" name="code_ed" id="code_ed" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Direction : </label>
                                {!! Form::select('code', $directions, '', ['class' => 'form-control select2', 'name' => 'direction_ed', 'id' => 'direction_ed', 'disabled']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Département : </label>
                                <select name="departement_ed" id="departement_ed" class="form-control select2" disabled required>
                                                        
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr class="mt-3 mb-3"/>

                    <div style="font-size: 12px">
                        <span style="font-weight: bold">
                            (*) Le libelle est unique par département !
                        </span>                        
                    </div>
                    
                </div>
                
                <div class="modal-footer">
                    <input class="btn btn-danger" type="submit" value="Valider">
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
            <h4 class="modal-title" id="titreDelete" >Supprimer Service</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <form class="cmxform" id="commentForm" method="post" action="{{'/configuration/save_delete_service'}}">
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
  <!-- Custom js for this page-->
    <script type="text/javascript">
        $('.tabBtnDelete').click(function(){
            //  Recuperer les valeurs de la ligne du bouton clické
            var row = $(this).closest('tr');;   //  . c'est la classe
            var libelle =  row.find('.t_libelle').text();
            var idF = $(this)[0].id;

            //  mettre les valeurs dans le madal
            $('#titreDelete').text("Cette action est irréverible. Voulez-vous vraiment supprimer le Service: "+libelle+" ?");    // # c'est le ID
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
            var code_dep =  row.find('td:eq(1)> input').val();//row.find('.t_departement').text();
            var code_direc =  row.find('.t_direction').text();
            var libelle =  row.find('.t_libelle').text();
            //var codeDep = row.find('td:eq(1)> input').val();
            
            var select = document.getElementById('direction_ed');
            $("#direction_ed > option").each(function() {
                if ($(this).val()== code_direc) {
                    //$(this).attr("selected", true);
                    $("#direction_ed option[value="+code_direc+"]").remove();
                    $("#direction_ed").append("<option value='"+code_direc+"' selected>"+code_direc+"</option>");
                }
            });

            //  LOAD DEPARTEMENT DE LA DIRECTION SELECTIONNEE
            $.ajax({
                url: '/get_departements_of_direction',
                type: 'post',
                data:{
                    "code": code_direc,
                    "_token": "{{ csrf_token() }}",
                    },
                success: function(data){

                    var len = data.length;

                    $("#departement_ed").empty();

                    //$("#departement").append("<option selected>/****Selectionnez*****/</option>");
                    for( var i = 0; i<len; i++){
                        var code = data[i]['code'];
                        var libelle = data[i]['libelle'];
                        if(data[i]['code'] == code_dep){   
                            $("#departement_ed").append("<option value='"+code+"' selected>"+libelle+"</option>");
                        }else{
                            $("#departement_ed").append("<option value='"+code+"' >"+libelle+"</option>");
                        }
                        $('#departement_ed').prop('change', true);
                    }
                }
            });

            /*
            var select_dep = document.getElementById('departement_ed');
            $("#departement_ed > option").each(function() {
                if ($(this).val()== code_direc) {
                    //$(this).attr("selected", true);
                    $("#direction_ed option[value="+code_direc+"]").remove();
                    $("#direction_ed").append("<option value='"+code_direc+"' selected>"+code_direc+"</option>");
                }
            });*/

            var idF = $(this)[0].id;
            //$('#code').val(code);
            $('#direction_ed').val(code_direc);
            $('#libelle_ed').val(libelle);
            $('#code_ed').val(idF);
            //$('#direction').text(direc);
            
            $('#myModalEdit').modal('show');
        });
    </script>

<script>
    window.onload = function() {
        var direct = document.getElementById('direction');
        var direct_ed = document.getElementById('direction_ed');
        /* CHARGER ON LOAD FIRST*/
        $.ajax({
            url: '/get_departements_of_direction',
            type: 'post',
            data:{
                "code": direct.value,
                "_token": "{{ csrf_token() }}",
                 },
            success: function(data){

                var len = data.length;

                $("#departement").empty();

                //$("#departement").append("<option selected>/****Selectionnez*****/</option>");
                for( var i = 0; i<len; i++){
                    var code = data[i]['code'];
                    var libelle = data[i]['libelle'];
                    
                    $("#departement").append("<option value='"+code+"' >"+libelle+"</option>");
                    $('#departement').prop('change', true);
                }
                }
        });
        /* CHARGER ON LOAD FIRST*/

        direct.onchange = function() {
            $.ajax({
            url: '/get_departements_of_direction',
            type: 'post',
            data:{
                "code": direct.value,
                "_token": "{{ csrf_token() }}",
                 },
            success: function(data){

                var len = data.length;

                $("#departement").empty();

                //$("#departement").append("<option selected>/****Selectionnez*****/</option>");
                for( var i = 0; i<len; i++){
                    var code = data[i]['code'];
                    var libelle = data[i]['libelle'];
                    
                    $("#departement").append("<option value='"+code+"' >"+libelle+"</option>");
                    $('#departement').prop('change', true);
                }
                }
            });

        }

        direct_ed.onchange = function() {
            $.ajax({
            url: '/get_departements_of_direction',
            type: 'post',
            data:{
                "code": direct_ed.value,
                "_token": "{{ csrf_token() }}",
                 },
            success: function(data){

                var len = data.length;

                $("#departement_ed").empty();

                //$("#departement").append("<option selected>/****Selectionnez*****/</option>");
                for( var i = 0; i<len; i++){
                    var code = data[i]['code'];
                    var libelle = data[i]['libelle'];
                    
                    $("#departement_ed").append("<option value='"+code+"' >"+libelle+"</option>");
                    $('#departement_ed').prop('change', true);
                }
                }
            });

        }
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
                columns: [0,1,2]
            }
       },
       {
           extend: 'csv',
           footer: false,
           exportOptions: {
                columns: [0,1,2]
            }
          
       },
       {
           extend: 'excel',
           footer: false,
           exportOptions: {
                columns: [0,1,2]
            }
       },
        {
           extend: 'colvis',
           footer: false,
           exportOptions: {
                columns: [0,1,2]
            }
       } ,        
    ]  ,
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

      
    });
  </script>
  
@endsection
