
@extends('client.apprh', ['titre' => 'Utilisateurs'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Utilisateurs</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                          <li class="breadcrumb-item active">Utlisateurs</li>
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
                        <button class="btn btn-app bg-success tabBtnAdd" data-toggle="modal" {{ Session('permission')[0]->add =='0'?'disabled':''}}>
                            <i class="fas fa-user-plus"></i> Ajouter
                        </button>
                    </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                    <thead>
                    <tr>
                        <th>Email</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Groupe</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="t_Email">{{$user->email}}</td>
                                <td class="t_Nom">{{$user->nom}}</td>
                                <td class="t_Prenom">{{$user->prenom}}</td>
                                <td class="t_groupe">{{$user->groupe_libelle}}</td>
                                <td>
                                    @if (Session('permission')[0]->edit == '1')
                                        <a class="tabBtnEdit" value="$user->id"  href="/access/utilisateurs/edituser/{{$user->id}}"><i class="fas fa-lg fa-edit"></i></a>
                                    @endif

                                    @if (Session('permission')[0]->delete == '1')
                                        <a class="tabBtnDelete" id="{{$user->id}}" data-toggle="modal"><i class="fas fa-lg  fa-trash"></i></a>
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


    <!-- Modal -->
    <div id="myModalDelete" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="titreDelete" >Supprimer Utlisateur</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <form class="cmxform" id="commentForm" method="post" action="{{'/access/utilisateurs/delete_user'}}">
                @csrf 
                <div class="modal-footer">
                    <input class="form-control" type="hidden" id="idModalDelete" name="idModal">
                    <input class="btn btn-danger" type="submit" value="OUI">
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
            <h4 class="modal-title">Ajouter un utilisateur</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/access/utilisateurs/add_user'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="form-group">
                        <label for="form-group">Email Professonnel</label>
                        <input class="form-control" type="email" placeholder="email"  name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="form-group">Nom</label>
                        <input class="form-control" type="text" placeholder="Nom" name="nom" minlength="4" required>
                    </div>
                    <div class="form-group">
                        <label for="form-group">Prenom (s)</label>
                        <input class="form-control" type="text" placeholder="Prenom"  name="prenom" minlength="4" required>
                    </div>
                    <div class="form-group">
                        <label>Groupe de l'utlisateur</label>
                        <select class="form-control select2" style="width: 100%;" name="groupe" required>
                            @foreach ($groupes as $groupe)
                                <option value="{{$groupe->id}}" >{{$groupe->libelle}}</option>
                            @endforeach
                        </select>
                      </div>
                </div>
                
                <div class="modal-footer">
                    <input class="btn btn-success" type="submit" value="Ajouter">
                    <buttid="commentForm"on type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
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
            var nom =  row.find('.t_Nom').text();
            var prenom =  row.find('.t_Prenom').text();
            var idF = $(this)[0].id;

            //alert(idF);
            //*

            //  mettre les valeurs dans le madal
            $('#titreDelete').text("Voulez-vous vraiment supprimer l'utilisateur: "+nom+" "+prenom+" ?");    // # c'est le ID
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
                columns: [0,1,2,3]
            }
       },
       {
           extend: 'csv',
           footer: false,
           exportOptions: {
            columns: [0,1,2,3]
            }
          
       },
       {
           extend: 'excel',
           footer: false,
           exportOptions: {
                columns: [0,1,2,3]
            }
       },
        {
           extend: 'colvis',
           footer: false,
           exportOptions: {
                columns: [0,1,2,3]
            }
       } ,             
    ]  ,
    "columnDefs": [
    { "width": "10%", "targets": 4 }
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

    });
  </script>
  
@endsection
