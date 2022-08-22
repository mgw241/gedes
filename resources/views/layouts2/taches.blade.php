
@extends('client.apprh', ['titre' => 'Taches'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Taches / Actions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                      <li class="breadcrumb-item active">Taches</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <nav class="navbar navbar-expand navbar-secondary navbar-dark justify-content-center">
                <!-- Left navbar links -->
                <ul class="navbar-nav justify-content-center">
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/taches/taches/taches/all" class="btn btn-dark">Taches</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/taches/taches/actions/all"  class="nav-link">Actions</a>
                    </li>
                </ul>
              </nav>
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Mes Taches</h3>
                        </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                            <thead>
                            <tr>
                                <th>Type de tache</th>
                                <th>Employé</th>
                                <!--th>Motif</th-->
                                <th>Date d'attribution</th>
                                <th>Décision</th>
                                <th>Analyser</th>
                            </tr>
                            </thead>
                            <tbody>

                                @foreach ($tachesF as $tache)
                                    <tr >        
                                        <td class="t_type_tache">
                                            @if ($tache->libelle == "abscences")
                                                Abscence
                                            @elseif($tache->libelle == "missions")
                                                Mission
                                            @elseif($tache->libelle == "conges")
                                                Congé
                                            @endif
                                        </td>
        
                                        <td class="t_employe">
                                            {{$tache->nom_complet}}
                                        </td>
        
                                        <!--td class="t_motif">
                                            onclick="window.location='/taches/taches/analyser/{{$tache->libelle}}/{{$tache->id_wl}}';"
                                        </td-->

                                        <td class="t_date_creation">
                                            {{date("d/m/Y H:i", strtotime($tache->created_at))}}
                                        </td>

                                        <td class="t_decision">
                                            {{show_statut_taches($tache->decision)}}
                                        </td>

                                        <td class="t_analyse" style="text-align: center">
                                            <a class="tabBtnEdit" href="/taches/taches/analyser/{{$tache->libelle}}/{{$tache->id_wl}}" data-placement="right" title="Analyser la tache"><i class="fas fa-lg fa-edit "></i> </a>
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
    <input class="d-none myseach" id="myseach" type="hidden" value="{{$myseachD}}">
@endsection 


@section('customjavascript')
<script>
    window.onload = function() {
        var myseach = document.getElementById('myseach');
    }
    $(function () {
        if (myseach.value == "all") {
            myseach.value = "";
        }
      var table = $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "search": {
            "search": myseach.value
        },
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
