
@extends('client.apprh', ['titre' => 'Actions'])
    
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
                      <li class="breadcrumb-item active">Actions</li>
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
                        <a href="/taches/taches/taches/all"  class="nav-link">Taches</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/taches/taches/actions/all"  class="btn btn-dark">Actions</a>
                    </li>
                </ul>
              </nav>
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Mes Actions</h3>
                        </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                            <thead>
                            <tr>
                                <th>Type d'action</th>
                                <!--th>Motif</th-->
                                <th>Date de création</th>
                                <th>Décision</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($actionF as $action)
                                    <tr >        
                                        <td class="t_type_tache">
                                            @if ($action->libelle == "abscences")
                                                Abscence
                                            @elseif($action->libelle == "missions")
                                                Mission
                                            @elseif($action->libelle == "conges")
                                                Congé
                                            @endif


                                            <input type="hidden" class="nom" id="nom" value="{{$user->nom}}">
                                            <input type="hidden" class="prenom" id="prenom" value="{{$user->prenom}}">
                                            <input type="hidden" class="departement" id="departement" value="{{$user->departement}}">
                                            <input type="hidden" class="direction" id="direction" value="{{$user->direction}}">
                                            <input type="hidden" class="service" id="service" value="{{$user->service}}">
                                            <input type="hidden" class="poste" id="poste" value="{{$user->poste}}">
                                            <input type="hidden" class="commentairem" id="commentairem" value="{{$action->commentairem}}">
                                            
                                            <span class="commentaire d-none" id="commentaire" >
                                                {{ 
                                                    show_statut_worklow_action_popup($action->statut_w, $action->statut, $action->commentaire) 
                                                }}
                                            </span>
                                        </td>

        
                                        <td class="t_date_creation">
                                            {{date("d/m/Y H:i", strtotime($action->created_at))}}
                                        </td>
        
                                        <td  class="t_Analyse" >
                                            <a class="tabBtnShow popupetat" data-toggle="modal" id="tabBtnShow" data-placement="right" title="Consulter cette action">
                                                {{ 
                                                    show_statut_worklow_action($action->statut_w, $action->statut, $action->commentaire) 
                                                }}
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



    <input class="d-none myseach" id="myseach" type="hidden" value="{{$myseachD}}">

  <!-- Modal  SHOW WORKFLOW-->
  <div id="myModalSHOW" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Etat de ma demande</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-md-6">
                        <table class="table tablePresentation" style="border: 0px">
                            <tbody>
                                <tr>
                                    <td>Nom :</td>
                                    <th class="m_nom">
                                        
                                    </tr>
                                <tr>
                                    <td>Direction :</td>
                                    <th class="m_direc">

                                    </th>
                                </tr>
                                <tr>
                                    <td>Service :</td>
                                    <th class="m_serv">
                                        
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table tablePresentation" style="border: 0px">
                            <tbody>
                                <tr>
                                    <td>Prenom :</td>
                                    <th class="m_prenom">
                                        
                                    </th>
                                </tr>
                                <tr>
                                    <td>Département :</td>
                                    <th class="m_dept">
                                        
                                    </th>
                                </tr>
                                <tr>
                                    <td>Poste :</td>
                                    <th class="m_poste">
                                        
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <table class="table tablePresentation" style="border: 0px">
                            <tbody >
                                <tr style="border-top: none">
                                    <td style="border-top: none">Etat de la demande :</td>
                                    <th style="border-top: none" class="m_etat">     
                                        
                                    </tr>
                                <tr style="border-bottom: none">
                                    <td >Commentaire :</td>
                                    <th style="border-bottom: none">
                                        <textarea class="form-control m_commentairem"  name="m_commentairem" id="" cols="30" rows="4"  disabled></textarea>
                                    </th>
                                </tr>
                            </tbody>
                        </table>            
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button id="commentForm"on type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
    </div>

    </div>
</div>
<!-- Modal -->


@endsection 


@section('customjavascript')
 <!-- Custom js for this page-->
 <script type="text/javascript">
    $('.tabBtnShow').click(function(){
                //  J'afiche deja le Modal
                var row = $(this).closest('tr');
                var nom =  row.find('#nom').val();
                var prenom =  row.find('#prenom').val();
                var dept =  row.find('#departement').val();
                var direc =  row.find('#direction').val();
                var comm =  row.find('#commentaire').text();
                var poste =  row.find('#poste').val();
                var comm_m =  row.find('#commentairem').val();
                var service =  row.find('#service').val();
                
                //alert(nom);
                $('.m_nom').text(nom);
                $('.m_prenom').text(prenom);
                $('.m_direc').text(direc);
                $('.m_dept').text(dept);
                $('.m_poste').text(poste);
                $('.m_etat').text(comm);
                $('.m_serv').text(service);
                $('.m_commentairem').text(comm_m);
                $('#myModalSHOW').modal('show');
    });
</script>

<script>
    
</script>


<script>
    window.onload = function() {
        var myseach = document.getElementById('myseach');
        if (myseach.value == "all") {
            myseach.value = "";
        }
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
     
    //set search text on specific column
    //table.columns(columnIndex).search('default search text'); 
      
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
