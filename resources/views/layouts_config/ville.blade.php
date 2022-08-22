
@extends('layouts_config.configuration')


@section('contenu2')
        <div class="row">
            <div class="col-12">

                <div class="card">
                    @if (Session('permission')[0]->add == '1')
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-5">
                                <button class="btn btn-app bg-success tabBtnAdd" data-toggle="modal" id="tabBtnAdd" data-placement="right" title="Ajouter un nouveau département">
                                    <i class="fas fa-plus"></i> Ajouter Ville
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
                            <th hidden></th>
                            <th>Libelle</th>
                            <th>Pays</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($villes as $ville)
                                <tr >        
                                    <td class="t_code d-none">{{$ville->id}}<input readonly type="hidden" class="codeH" id="codeH" value="{{$ville->id}}"></td>

                                    <td class="t_libelle">{{$ville->libelle}}</td>

                                    <td class="t_pays">{{$ville->pays}}</td>

                                    <td class="t_action" style="text-align: center">
                                    @if (Session('permission')[0]->edit == '1')
                                        <a class="tabBtnEdit popupetat" id="{{$ville->id}}"  data-toggle="modal" id="tabBtnShow" data-placement="right" title="Editer"><i class="fas fa-lg fa-edit"></i></a>
                                    @endif

                                    @if (Session('permission')[0]->delete == '1')
                                        <a class="tabBtnDelete" id="{{$ville->id}}" data-toggle="modal" data-placement="right" title="Supprimer"><i class="fas fa-lg  fa-trash"></i></a>
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
                <h4 class="modal-title">Ajouter une Ville</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/configuration/save_add_ville'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Libelle : </label>
                                <input class="form-control" type="text" name="libelle" placeholder="exe: Libreville" required onkeyup="
                                /*var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);//">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Pays : </label>
                                <select class="form-control select2" name="pays" id="code_direction">
                                    @foreach ($pays as $pay => $code)
                                        <option value="{{ $code }}" {{$code =='Gabon' ? "selected" : ''}}> 
                                            {{ $code }} 
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
                <h4 class="modal-title">Modifier la ville</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/configuration/save_edit_ville'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Libelle : </label>
                                <input class="form-control" type="text" name="libelle_ed" placeholder="exe: Libreville" required id="libelle_ed" onkeyup="
                                /*var start = this.selectionStart;
                                var end = this.selectionEnd;
                                this.value = this.value.toUpperCase();
                                this.setSelectionRange(start, end);*/">
                                <input class="form-control" type="hidden" name="id_ed" readonly required id="id_ed" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Pays : </label>
                                <select class="form-control select2" name="pays_ed" id="pays_ed">
                                    @foreach ($pays as $pay => $code)
                                        <option value="{{ $code }}" > 
                                            {{ $code }} 
                                        </option>
                                    @endforeach    
                                </select>
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
            <h4 class="modal-title" id="titreDelete" >Supprimer Ville</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <form class="cmxform" id="commentForm" method="post" action="{{'/configuration/save_delete_ville'}}">
                @csrf 
                <div class="modal-footer">
                    <input class="form-control" type="hidden" id="id_del" name="id_del">
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
            //var code =  row.find('.t_code').text();
            var libelle =  row.find('.t_libelle').text();
            var idF = $(this)[0].id;

            //  mettre les valeurs dans le madal
            $('#titreDelete').text("Cette action est irréverible. Voulez-vous vraiment supprimer la Ville: "+libelle+" ?");    // # c'est le ID
            $('#id_del').val(idF);    // # c'est le ID

            //  J'afiche deja le Modal
            $('#myModalDelete').modal('show');
            
        });

        $('.tabBtnAdd').click(function(){
                    //  J'afiche deja le Modal
                    $('#myModalADD').modal('show');
        });

        $('.tabBtnEdit').click(function(){
                    var row = $(this).closest('tr');
                    //var code =  row.find('.t_code').text();
                    var libelle =  row.find('.t_libelle').text();
                    var pays =  row.find('.t_pays').text();
                    
                    $("option").each(function(){
                        if ($(this).val()== pays) {
                            //$(this).attr("selected", true);
                            $("#pays_ed option[value="+pays+"]").remove();
                            $("#pays_ed").append("<option value='"+pays+"' selected>"+pays+"</option>");
                        }
                    });

                    var idF = $(this)[0].id;
                    //$('#code_ed').val(code);
                    $('#libelle_ed').val(libelle);
                    $('#id_ed').val(idF);
                    
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
