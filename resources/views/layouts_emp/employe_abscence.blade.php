
@extends('client.apprh', ['titre' => 'Mes Abscences'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Mes Abscences</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                      <li class="breadcrumb-item active">Mes Abscences</li>
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
        
                                <div class="row">
                                    <div class="col-md-5">
                                        <button class="btn btn-app bg-success tabBtnAddAbscence" data-toggle="modal" id="tabBtnAddAbscence" data-placement="right" title="Ajouter une demande d'abscences">
                                            <i class="fas fa-plus"></i> Ajouter Abscences
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <!--h2 style="color: darkred">Abscences</h2-->
                                    </div>
                                </div>
                                
                            </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                            <thead>
                            <tr>
                                <th>Date D??but</th>
                                <th>Date Fin</th>
                                <th>Motif</th>
                                <th>Justification</th>
                                <th>Fichier justificatif</th>
                                <th>Fichier Demande</th>
                                <th>Analyse</th>
                                <!---th>Action</th-->
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($abscences as $abscence)
                                    <tr >        
                                        <td class="t_Date_debut">
                                            {{date("d/m/Y", strtotime($abscence->date_depart))}}
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
                                        <td class="t_Date_fin">
                                            {{date("d/m/Y", strtotime($abscence->date_reprise))}}
                                        </td>
                                        <td class="t_Motif">
                                            {{$abscence->motif}}
                                        </td>
                                        <td class="t_Justification">
                                            {{$abscence->justifier == 0 ? "NON" : "OUI"}}
                                        </td>
                                        <td class="t_fichier_justification">
                                            @if ($abscence->justifier == 0 )
                                                <a class="tabBtnEditAbscence" href="/access/groupes/edit_group/" value="{{$abscence->id}}" id="{{$abscence->id}}" data-toggle="modal">
                                                    <i class="fas fa-lg fa-plus"></i> ajouter
                                                </a>
                                            @endif
                                            @if ($abscence->justifier == 1 )
                                                <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$abscence->code_emp}}/{{$abscence->fichier_justification}}" target="_blank" class="lienPDF">
                                                    <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                                    <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                                </a>
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
                                        


                                        <!--td>
                                            <a class="tabBtnDelete" id="" data-toggle="modal"><i class="fas fa-lg fa-trash"></i> </a>
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

            <!-- Modal  EDIT Abscence-->
<div id="myModalEdit" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog"> <!-- modal-lg-->
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter le justificatif</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/mes_abscences/save_edit_justificatif'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="justificatif" name="justificatif" accept="application/pdf">
                        <input type="hidden" id="id_abs" name="id_abs">
                        <label class="custom-file-label" data-browse="Parcourir" for="justificatif">Choisir le fichier justificatif</label>
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
                                    <td>D??partement :</td>
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
    <div class="modal-dialog modal-lg"> <!-- modal-lg-->
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter une Demande d'Abscence</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/mes_abscences/save_add'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <!--div class="form-group">
                        <label>Da</label>
                        <input type="text" class="form-control" name="nom" id="nom" value="{{session()->get('user')->nom}}">
                    </div-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form-group">Motif de l'abscence <span style="font-weight: normal;">(hors cong??s annuel)</span></label>
                                <textarea class="form-control" maxlength="115"  name="motif" required style="width:100%"></textarea> 
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Date de d??but d'abscence : </label>
                                <input class="form-control" type="date"  name="date_debut_abs" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Nombre de jours d'abscence : </label>
                                <input class="form-control" type="number" name="nbrJ_abscence" required>
                            </div>
                        </div>
                    </div-->
                    <!--div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Date de d??part : </label>
                                <input class="form-control" type="date"  name="date_debut_abs" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Date de reprise : </label>
                                <input class="form-control" type="date"  name="date_fin_abs" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Heure de d??part</label>
                                <input class="form-control" type="time" name="hdepart" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Heure de reprise</label>
                                <input class="form-control" type="time" name="hreprise" required>
                            </div>
                        </div>
                    </div-->

                    <hr class="mt-3 mb-3"/>

                    <div style="font-size: 12px">
                        <span style="color: red; ">
                            Les abscences exceptionneles n'ouvrent pas droit ?? r??mun??ration sauf dans le cas d'abscences pour ??v??nements familiaux. <br/>
                        </span>
                        <span style="font-weight: bold">
                            ??v??nements familiaux concern??s:<br/>
                        </span>
                        
                        &nbsp;&nbsp;&nbsp;- D??c??s du p??re, de la m??re, d'un enfant : <span style="font-weight: bold">5 jours</span> <br/>
                        &nbsp;&nbsp;&nbsp;- Mariage du travailleur : <span style="font-weight: bold">4 jours</span> <br/>
                        &nbsp;&nbsp;&nbsp;- Naissance d'un enfant : <span style="font-weight: bold">3 jours</span> <br/>
                        &nbsp;&nbsp;&nbsp;- Mariage d'un enfant, d??c??s du fr??re, de la soeur, du beau-p??re, de la belle-m??re : <span style="font-weight: bold">2 jours</span> <br/>
                        &nbsp;&nbsp;&nbsp;- Mariage du fr??re ou de la soeur : <span style="font-weight: bold">1 jour</span> <br/>
                        <span style="font-weight: bold; font-style: oblique">
                            La r??mun??raton n'est maintenue qu'?? condition qu'un justificatif prouvant l'??v??nement, le lien de filiation ou de parent?? (acte de naissance, acte de d??cc??s, acte de mariage etc.) ait ??t?? transmis au service du personnel dans des d??lais raisonnables.  <br/>
                        </span>
                        <span style="color: red;">
                            La soci??t?? d??cline toute resonsabilit?? en cas d'incident ou accident survenu au cours d'une abscence du salari?? (abscence excetionnelle, cong?? annuel etc...).  <br/>
                        </span>
                        
                    </div>
                    <!--div class="form-group">
                        <label for="form-group">Nombre de jours d'abscence <span style="font-weight: normal;">(week-ends exlus!) </span> :</label>
                        <input class="form-control" type="text" name="nbrJ" required min="1" pattern="[0-9]" size="2" minlength="1" maxlength="2" placeholder="1" required>
                    </div-->
                    
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
            //  Recuperer les valeurs de la ligne du bouton click??
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

        $('.tabBtnAddAbscence').click(function(){
                    //  J'afiche deja le Modal
                    $('#myModalADDAbscence').modal('show');
        });

        $('.tabBtnEditAbscence').click(function(){
                    //  J'afiche deja le Modal
                    var idF = $(this)[0].id;
                    $('#id_abs').val(idF);
                    $('#myModalEdit').modal('show');
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
                columns: [0,1,2,3,4,5,6]
            }
       },
       {
           extend: 'csv',
           footer: false,
           exportOptions: {
            columns: [0,1,2,3,4,5,6]
            }
          
       },
       {
           extend: 'excel',
           footer: false,
           exportOptions: {
            columns: [0,1,2,3,4,5,6]
            }
       },
        {
           extend: 'colvis',
           footer: false,
           exportOptions: {
            columns: [0,1,2,3,4,5,6]
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
