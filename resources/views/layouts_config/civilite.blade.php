
@extends('layouts_config.configuration')


@section('contenu2')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if (Session('permission')[0]->add == '1')
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-5">
                                <button class="btn btn-app bg-success tabBtnAdd" data-toggle="modal" id="tabBtnAdd" data-placement="right" title="Ajouter un état civil">
                                    <i class="fas fa-plus"></i> Ajouter Civilité
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
                            <th>Lbelle</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($civilites as $civilite)
                                <tr >        
                                    <td class="t_code">{{$civilite->code}}</td>

                                    <td class="t_libelle">{{$civilite->libelle}}</td>

                                    <td class="t_action" style="text-align: center">
                                    @if (Session('permission')[0]->edit == '1')
                                        <a class="tabBtnEdit popupetat" id="{{$civilite->id}}"  data-toggle="modal" id="tabBtnShow"><i class="fas fa-lg fa-edit"></i></a>
                                    @endif

                                    @if (Session('permission')[0]->delete == '1')
                                        <a class="tabBtnDelete" id="{{$civilite->id}}" data-toggle="modal" data-placement="right" title="supprimer"><i class="fas fa-lg  fa-trash"></i></a>
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
                <h4 class="modal-title">Ajouter un Département</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'configuration/save_add/direction'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Code : (*)</label>
                                <input class="form-control" type="text"  name="code" placeholder="exe: ING" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Libelle : </label>
                                <input class="form-control" type="text" name="libelle" placeholder="exe: Ingéneurie" required>
                            </div>
                        </div>
                    </div>

                    <hr class="mt-3 mb-3"/>

                    <div style="font-size: 12px">
                        <span style="font-weight: bold">
                            (*) Le code est une abreviation qui permet d'identifier la civilité en une lettre et de manière unique. Le code ne pourra pas être modifié !
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
                <h4 class="modal-title">Modifier la civilité</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'configuration/save_add/direction'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Code : (*)</label>
                                <input class="form-control" type="text"  name="code" placeholder="exe: DTSI" required id="code" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Libelle : </label>
                                <input class="form-control" type="text" name="libelle" placeholder="exe: Direction des Ressources Humaines" required id="libelle">
                            </div>
                        </div>
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
            <h4 class="modal-title" id="titreDelete" >Supprimer Civilité</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <form class="cmxform" id="commentForm" method="post" action="{{'/configuration/save_edit/direction'}}">
                @csrf 
                <div class="modal-footer">
                    <input class="form-control" type="hidden" id="idModalDelete" name="code">
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
            var code =  row.find('.t_code').text();
            //var idF = $(this)[0].id;

            //  mettre les valeurs dans le madal
            $('#titreDelete').text("Cette action est irréverible. Voulez-vous vraiment supprimer la Direction: "+code+" ?");    // # c'est le ID
            $('#idModalDelete').val(code);    // # c'est le ID

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
                    var direc =  row.find('.t_direction').text();
                    
                    var select = document.getElementById('direction');

                    $("option").each(function(){
                        if ($(this).val()== direc) {
                            //$(this).attr("selected", true);
                            $("#direction option[value="+direc+"]").remove();
                            $("#direction").append("<option value='"+direc+"' selected>"+direc+"</option>");
                        }
                    });

                    //var idF = $(this)[0].id;
                    $('#code').val(code);
                    $('#libelle').val(libelle);
                    //$('#direction').text(direc);
                    
                    $('#myModalEdit').modal('show');
        });
    </script>
    <!-- End custom js for this page-->


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
