
@extends('client.apprh', ['titre' => 'Annuaire'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Annuaire</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                          <li class="breadcrumb-item active">Annuaire</li>
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
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Poste</th>
                        <th>Direction</th>
                        <th>Numéro de flotte</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($annuaires as $annuaire)
                            <tr>
                                <td class="t_Email">{{$annuaire->nom}}</td>
                                <td class="t_Nom">{{$annuaire->prenom}}</td>
                                <td class="t_Prenom">{{$annuaire->poste}}</td>
                                <td class="t_groupe">{{$annuaire->direction}}</td>
                                <td class="t_groupe">{{ (isset($annuaire->flotte) &&  $annuaire->flotte!="") ? $annuaire->flotte : "-" }}</td>
                                <td class="t_groupe">{{ (isset($annuaire->email) &&  $annuaire->email!="") ? $annuaire->email : "-" }}</td>
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
    if ( table2.rows(  ).count()  == 0 ) {
        table2.buttons().disable();
    }
    else {
        table2.buttons().enable();
    }
    });
  </script>
  
@endsection
