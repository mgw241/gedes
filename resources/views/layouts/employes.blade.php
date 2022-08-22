
@extends('client.apprh', ['titre' => 'Employés'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employés</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                          <li class="breadcrumb-item active">Employes</li>
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

                        <!--a href="/rh/employes/add">
                            GO
                        </a-->
                        <form action="/rh/employes/add" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-app bg-success tabBtnAdd" data-toggle="modal" {{ Session('permission')[0]->add =='0'?'disabled':''}}  data-placement="right" title="Ajouter un employé">
                                <i class="fas fa-user-plus"></i> Ajouter
                            </button>
                        </form>
                        
                    </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                    <thead>
                    <tr>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Poste</th>
                        <th>Direction</th>
                        <th>Numéro flotte</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($employes as $employe)
                            <tr>
                                <td class="t_matricule">
                                    <a href="/rh/employes/{{$employe->code}}">
                                        {{$employe->code}}
                                    </a>
                                </td>

                                <td class="t_Nom">
                                    <a href="/rh/employes/{{$employe->code}}">
                                        {{$employe->nom}}
                                    </a>
                                </td>

                                <td class="t_Prenom">
                                    {{$employe->prenom}}
                                </td>

                                <td class="t_poste">
                                    {{$employe->libelle_post}}
                                </td>

                                <!--td class="t_departement">
                                    {{substr( $employe->libelle_dept , 0, 3 ) == 'UNK' ? 'AUCUN' : $employe->libelle_dept}}
                                </td-->
                                <td class="t_direction">
                                    {{$employe->libelle_direct}}
                                </td>

                                <td class="t_numero">
                                    {{$employe->telephone_travail}}
                                </td>

                                <td class="t_email">
                                    <a href="mailto:{{$employe->email}}">
                                        {{$employe->email}}
                                    </a>
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

@endsection 


@section('customjavascript')
  <!-- Custom js for this page-->
    <script type="text/javascript">
        $('.tabBtnDelete').click(function(){
            //  Recuperer les valeurs de la ligne du bouton clické
            var row = $(this).closest('tr');;   //  . c'est la classe
            var nom =  row.find('.t_Nom').text();
            var prenom =  row.find('.t_Prenom').text();
            var idF = $(this).val();

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
                columns: [':visible' ]
            }
       },
       {
           extend: 'csv',
           footer: false,
           exportOptions: {
                columns: [':visible' ]
            }
          
       },
       {
           extend: 'excel',
           footer: false,
           exportOptions: {
                columns: [':visible' ]
            }
       },
        {
           extend: 'colvis',
           footer: false,
           exportOptions: {
                columns: [':visible' ]
            }
       } ,        
    ]  ,
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
