
@extends('client.apprh', ['titre' => 'Missions'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Missions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                      <li class="breadcrumb-item active">Missions</li>
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
                        <!--div class="card-header">
    
                            <a href="/rh/employes/add">
                                GO
                            </a>
                            <form action="/rh/employes/add" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-app bg-success tabBtnAdd" data-toggle="modal" {{ Session('permission')[0]->add =='0'?'disabled':''}}>
                                    <i class="fas fa-space-shuttle"></i> Ajouter
                                </button>
                            </form>
                            
                        </div-->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                        <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom & Prenom</th>
                            <th>Objet</th>
                            <th>Date départ</th>
                            <th>Date retour</th>
                            <!--th>Pays</th-->
                            <th>Ville</th>
                            <!--th>Demande de mission</th-->
                            <th>Fiche de Frais</th>
                            <th>Ordre de mission</th>
                            <th>Analyse</th>
                            <!--th>Action</th-->
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($missions as $mission)
                                <tr>
                                    <td class="t_matricule">
                                        <a href="/rh/employes/{{$mission->code_emp}}">
                                            {{$mission->code_emp}}
                                        </a>
                                        <input type="hidden" class="nom" id="nom" value="{{$mission->nom}}">
                                            <input type="hidden" class="prenom" id="prenom" value="{{$mission->prenom}}">
                                            <input type="hidden" class="departement" id="departement" value="{{$mission->departements}}">
                                            <input type="hidden" class="direction" id="direction" value="{{$mission->direction}}">
                                            <input type="hidden" class="service" id="service" value="{{$mission->service}}">
                                            <input type="hidden" class="poste" id="poste" value="{{$mission->poste}}">
                                            <input type="hidden" class="commentairem" id="commentairem" value="{{$mission->commentairem}}">
                                            <span type="hidden" class="commentaire d-none" id="commentaire" >
                                                {{ 
                                                    show_statut_worklow_action_popup($mission->statut_w, $mission->statut, $mission->commentaire) 
                                                }}
                                            </span>
                                    </td>
    
                                    <td class="t_Nom_prenom">
                                        <a href="/rh/employes/{{$mission->code_emp}}">
                                            {{$mission->nom}} {{$mission->prenom}}
                                        </a>
                                    </td>

                                    <td class="t_Objet">
                                        {{$mission->objet}} 
                                    </td>

                                    <td class="t_Date_depart">
                                        {{date("d/m/Y", strtotime($mission->date_debut))}}
                                    </td>
                                    <td class="t_Date_retour">
                                        {{date("d/m/Y", strtotime($mission->date_retour))}}
                                    </td>

                                    <!--td class="t_pays">
                                        {{$mission->pays}}
                                    </td-->

                                    <td class="t_ville">
                                        {{$mission->ville}}
                                    </td>

                                    <td class="t_frais">
                                        @if ($mission->statut == 1)
                                            <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$mission->code_emp}}/{{$mission->fichier_frais}}" target="_blank" class="lienPDF">
                                                <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                                <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                            </a>
                                        @endif
                                    </td>
                                    <td class="t_ordre">
                                        @if ($mission->statut == 1)
                                            <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$mission->code_emp}}/{{$mission->fichier_ordre}}" target="_blank" class="lienPDF">
                                                <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                                <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                            </a>
                                        @endif
                                    </td>
                                    <td  class="t_Analyse" >
                                        <a class="tabBtnShow popupetat" data-toggle="modal" id="tabBtnShow">
                                        {{ 
                                            show_statut_worklow_action($mission->statut_w, $mission->statut, $mission->commentaire) 
                                        }}
                                        </a>
                                    </td>
                                    

                                    <!--td>
                                        @if (Session('permission')[0]->edit == '1')
                                            <a class="tabBtnEdit" href="/access/groupes/edit_group/" ><i class="fas fa-lg fa-edit "></i> </a>
                                        @endif
                                        
                                        @if (Session('permission')[0]->delete == '1')
                                        <a class="tabBtnDelete" id="" data-toggle="modal"><i class="fas fa-lg fa-trash"></i> </a>
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
            </div>
            <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>



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
