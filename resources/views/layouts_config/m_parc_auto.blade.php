
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
                                    <i class="fas fa-plus"></i> Ajouter Moniteur
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
                            <th>Nom employé</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($moniteurs as $moniteur)
                                <tr >        
                                    <td class="t_id d-none">{{$moniteur->id}}<input readonly type="hidden" class="codeH" id="codeH" value="{{$moniteur->id}}"></td>

                                    <td class="t_libelle">{{$moniteur->nom_complet}}</td>

                                    <td class="t_action" style="text-align: center">

                                    @if (Session('permission')[0]->delete == '1')
                                        <a class="tabBtnDelete" id="{{$moniteur->id}}" data-toggle="modal" data-placement="right" title="Supprimer"><i class="fas fa-lg  fa-trash"></i></a>
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
                <h4 class="modal-title">Ajouter un Moniteur</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/configuration/save_add_m_parc_auto'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form-group">Employé : </label>
                                <select class="form-control select2" name="employe" id="employe">
                                    @foreach ($employes as $employe)
                                        <option value="{{ $employe->code }}"> 
                                            {{ $employe->nom_complet }} 
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

<!-- Modal  SUPPRMMER-->
<div id="myModalDelete" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="titreDelete" >Supprimer Moniteur</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <form class="cmxform" id="commentForm" method="post" action="{{'/configuration/save_delete_m_parc_auto'}}">
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
            $('#titreDelete').text("Cette action est irréverible. Voulez-vous vraiment supprimer le Moniteur: "+libelle+" ?");    // # c'est le ID
            $('#id_del').val(idF);    // # c'est le ID

            //  J'afiche deja le Modal
            $('#myModalDelete').modal('show');
            
        });

        $('.tabBtnAdd').click(function(){
                    //  J'afiche deja le Modal
                    $('#myModalADD').modal('show');
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
