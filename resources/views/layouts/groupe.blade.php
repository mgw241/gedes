
@extends('client.apprh', ['titre' => 'Groupes'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Groupes</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                        <li class="breadcrumb-item active">Groupes</li>
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
                    <div class="card-header">
                        <button class="btn btn-app bg-success tabBtnAdd" data-toggle="modal" {{ Session('permission')[0]->add =='0'?'disabled':''}}  data-placement="right" title="Ajouter un groupe">
                            <i class="fas fa-user-plus"></i> Ajouter
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                        <thead>
                        <tr>
                            <th>Nom du Groupe</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupes as $group)
                                <tr>
                                    <td class="t_libelle">{{$group->libelle}}</td>
                                    <td>

                                        <!--
                                        <button class="tabBtnShow btn btn-outline-primary" value="$group->id" data-toggle="modal"><i class="fas fa-eye"></i> Voir</button>
                                        -->

                                        @if (Session('permission')[0]->edit == '1')
                                            <a class="tabBtnEdit" href="/access/groupes/edit_group/{{$group->id}}" data-placement="right" title="Editer" ><i class="fas fa-lg fa-edit "></i> </a>
                                        @endif
                                        
                                        @if (Session('permission')[0]->delete == '1')
                                        <a class="tabBtnDelete" id="{{$group->id}}" data-toggle="modal"><i class="fas fa-lg fa-trash" data-placement="right" title="Supprimer"></i> </a>
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


    <!-- Modal  SUPPRMMER-->
    <div id="myModalDelete" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="titreDelete" >Supprimer Groupe</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <form class="cmxform" id="commentForm" method="post" action="{{'/access/groupes/delete_group'}}">
                @csrf 
                <div class="modal-footer">
                    <input class="form-control" type="hidden" id="idModalDelete" name="idModal">
                    <input class="btn btn-success" type="submit" value="OUI">
                    <button type="button" class="btn btn-default" data-dismiss="modal">NON</button>
                </div>
            </form>
            
        </div>

        </div>
    </div>
  <!-- Modal -->

    <!-- Modal  ADD-->
    <div id="myModalADD" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Ajouter un Groupe</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/access/groupes/add_group'}}">
                @csrf 
                <div class="modal-body"> 
                    <div class="form-group">
                        <label for="form-group">Nom du Groupe</label>
                        <input class="form-control" type="text"  name="libelle" minlength="4" required>
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
  <!-- Modal -->

@endsection 


@section('customjavascript')
  <!-- Custom js for this page-->
    <script type="text/javascript">

$('.tabBtnDelete').click(function(){
            //  Recuperer les valeurs de la ligne du bouton clické
            var row = $(this).closest('tr');;   //  . c'est la classe
            var libelle =  row.find('.t_libelle').text();
            var idF = $(this)[0].id;

            //alert(idF);
            //*

            //  mettre les valeurs dans le madal
            $('#titreDelete').text("Voulez-vous vraiment supprimer le groupe "+libelle+" ?");    // # c'est le ID
            $('#idModalDelete').val(idF);    // # c'est le ID

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
                columns: [0]
            }
       },
       {
           extend: 'csv',
           footer: false,
           exportOptions: {
            columns: [0]
            }
          
       },
       {
           extend: 'excel',
           footer: false,
           exportOptions: {
                columns: [0]
            }
       },
       {
           extend: 'colvis',
           footer: false,
           exportOptions: {
                columns: [0]
            }
       } ,             
    ]  ,
    "columnDefs": [
    { "width": "10%", "targets": 1 }
  ]
       /* "columnDefs": [
            {
                "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 3 ],
                "visible": false
            }
        ],*/
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
