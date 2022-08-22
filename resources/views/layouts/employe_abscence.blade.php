
@extends('client.apprh', ['titre' => 'Abscences'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Abscences & Congés</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                      <li class="breadcrumb-item active">Congés & Abscences</li>
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
                            <a href="/rh/abscences_conges/abscences" class="btn btn-dark" data-toggle="tooltip" data-placement="right" title="Accéder aux abscences des employés">ABSCENCES</a>
                        </li>
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="/rh/abscences_conges/conges"  class="nav-link" data-toggle="tooltip" data-placement="right" title="Accéder aux congés des employés">CONGES</a>
                        </li>
                    </ul>
                  </nav>
                <div class="row">
                    <div class="col-12">
        
                        <div class="card">
                            <!--div class="card-header">
                                
                            </div-->
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                            <thead>
                            <tr>
                                <th>Matricule</th>
                                <th>Nom & Prenom</th>
                                <th>Date Début</th>
                                <th>Date Fin</th>
                                <th>Motif</th>
                                <th>Justification</th>
                                <th>Demande</th>
                                <th>Analyse</th>
                                <!--th>Action</th-->
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($abscences as $abscence)
                                    <tr >
                                        <td class="t_matricule">
                                            <a href="/rh/employes/{{$abscence->code_emp}}">
                                                {{$abscence->code_emp}}
                                            </a>
                                            <input type="hidden" class="nom" id="nom" value="{{$abscence->nom}}">
                                            <input type="hidden" class="prenom" id="prenom" value="{{$abscence->prenom}}">
                                            <input type="hidden" class="departement" id="departement" value="{{$abscence->departements}}">
                                            <input type="hidden" class="direction" id="direction" value="{{$abscence->direction}}">
                                            <input type="hidden" class="service" id="service" value="{{$abscence->service}}">
                                            <input type="hidden" class="poste" id="poste" value="{{$abscence->poste}}">
                                            <input type="hidden" class="commentairem" id="commentairem" value="{{$abscence->commentairem}}">
                                            <span type="hidden" class="commentaire d-none" id="commentaire" >
                                                {{ 
                                                    show_statut_worklow_action_popup($abscence->statut_w, $abscence->statut, $abscence->commentaire) 
                                                }}
                                            </span>
                                        </td>
        
                                        <td class="t_Nom_prenom">
                                            <a href="/rh/employes/{{$abscence->code_emp}}">
                                                {{$abscence->nom}} {{$abscence->prenom}}
                                            </a>
                                        </td>
        
                                        <td class="t_Date_depart">
                                            {{date("d/m/Y", strtotime($abscence->date_depart))}}
                                        </td>
                                        <td class="t_Date_reprise">
                                            {{date("d/m/Y", strtotime($abscence->date_reprise))}}
                                        </td>
                                        <td class="t_Motif">
                                            {{$abscence->motif}}
                                        </td>
                                        <td class="t_fichier_justification">
                                            @if ($abscence->justifier == 1)
                                                <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$abscence->code_emp}}/{{$abscence->fichier_justification}}" target="_blank" class="lienPDF">
                                                    <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                                </a>
                                            @else
                                                NON
                                            @endif
                                        </td>
                                        <td class="t_Demande">
                                            <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$abscence->code_emp}}/{{$abscence->fichier_demande}}" target="_blank" class="lienPDF">
                                                    <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                                    <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                                </a>
                                        </td>

                                        <td  class="t_Analyse" >
                                            <a class="tabBtnShow popupetat" data-toggle="modal" id="tabBtnShow">
                                            {{ 
                                                show_statut_worklow_action($abscence->statut_w, $abscence->statut, $abscence->commentaire) 
                                            }}
                                            </a>
                                            
                                        </td>

                                        <!--td class="t_Analyse">
                                            @if ($abscence->statut == 2)
                                            <span style="color: rgb(157, 157, 48)">Analyse en cours</span>
                                            @endif
                                            @if ($abscence->statut == 1)
                                                <span style="color: rgb(33, 150, 29)">Accordé</span>
                                            @endif
                                            @if ($abscence->statut == 0)
                                                <span style="color: rgb(209, 53, 14)">Rejeté</span>
                                            @endif
                                        </td-->

                                        <!--td>
                                            @if (Session('permission')[0]->edit == '1')
                                                <a class="tabBtnEdit" href="/access/groupes/edit_group/" ><i class="fas fa-lg fa-eye "></i> </a>
                                            @endif
                                            
                                            @if (Session('permission')[0]->delete == '1')
                                            <-a class="tabBtnDelete" id="" data-toggle="modal"><i class="fas fa-lg fa-trash"></i> </a>
                                            @endif
                                        </td-->
        
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


    <!-- Modal  ADD Abscence-->
    <div id="myModalADDAbscence" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Ajouter une Abscence</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/access/utilisateurs/add_user'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="form-group">
                        <label>Employé</label>
                        <select class="form-control select2" style="width: 100%;" name="groupe" required>
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="form-group">Date</label>
                        <input class="form-control" type="date"  name="date_debut_conge" required>
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

        $('.tabBtnAddConge').click(function(){
                    //  J'afiche deja le Modal
                    $('#myModalADDConge').modal('show');
        });

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
                columns: ':visible'
            }
       },
       {
           extend: 'csv',
           footer: false,
           exportOptions: {
                columns: ':visible'
            }
          
       },
       {
           extend: 'excel',
           footer: false,
           exportOptions: {
                columns: ':visible'
            }
       },
        {
           extend: 'colvis',
           footer: false,
           exportOptions: {
                columns: ':visible'
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
