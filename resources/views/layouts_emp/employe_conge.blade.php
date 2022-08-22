
@extends('client.apprh', ['titre' => 'Mes Congés'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Mes Congés</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                      <li class="breadcrumb-item active">Mes Congés</li>
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
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-app bg-success tabBtnAddConge" data-toggle="modal" data-placement="right" title="Ajouter une demande de congé">
                                            <i class="fas fa-plus"></i> Ajouter Congés
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <!--h2 style="color: darkred">Congés</h2-->
                                    </div>
                                </div>
                                
                            </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                            <thead>
                            <tr>
                                <th>Date de début</th>
                                <th>Date de fin</th>
                                <th>Motif</th>
                                <th>Justificatif</th>
                                <th>Demande</th>
                                <th>Analyse</th>
                                <!--th>Action</th-->
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($conges as $conge)
                                    <tr>        
                                        <td class="t_date_debut">
                                            {{date("d/m/Y", strtotime($conge->date_debut))}}
                                            <input type="hidden" class="nom" id="nom" value="{{$conge->nom}}">
                                            <input type="hidden" class="prenom" id="prenom" value="{{$conge->prenom}}">
                                            <input type="hidden" class="departement" id="departement" value="{{$conge->departements}}">
                                            <input type="hidden" class="direction" id="direction" value="{{$conge->direction}}">
                                            <input type="hidden" class="service" id="service" value="{{$conge->service}}">
                                            <input type="hidden" class="poste" id="poste" value="{{$conge->poste}}">
                                            <input type="hidden" class="commentairem" id="commentairem" value="{{$conge->commentairem}}">
                                            
                                            <span type="hidden" class="commentaire d-none" id="commentaire" >
                                                {{ 
                                                    show_statut_worklow_action_popup($conge->statut_w, $conge->statut, $conge->commentaire) 
                                                }}
                                            </span>
                                        </td>
        
                                        <td class="t_date_reprise">
                                            {{date("d/m/Y", strtotime($conge->date_fin))}}
                                        </td>
        
                                        <td class="t_motif">
                                            {{$conge->motif}}
                                        </td>

                                        <td class="t_justificatif">
                                            @if ($conge->fichier_justification != null)
                                                <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$conge->code_emp}}/{{$conge->fichier_justification}}" target="_blank" class="lienPDF">
                                                    <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                                    <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                                </a>
                                            
                                            @else
                                                NON
                                            @endif
                                        </td>
        
                                        <td class="t_demande">
                                            @if ($conge->fichier_demande != null)
                                                <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$conge->code_emp}}/{{$conge->fichier_demande}}" target="_blank" class="lienPDF">
                                                    <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                                    <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                                </a>
                                            @endif
                                        </td>

                                        <td  class="t_Analyse" >
                                            <a class="tabBtnShow popupetat" data-toggle="modal" id="tabBtnShow">
                                            {{ 
                                                show_statut_worklow_action($conge->statut_w, $conge->statut, $conge->commentaire) 
                                            }}
                                            </a>
                                        </td>

                                        <!--td style="text-align: center">
                                            <a class="tabBtnEdit" href="/access/groupes/edit_group/" ><i class="fas fa-lg fa-edit "></i> </a>
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

            

    <!-- Modal  ADD Congés-->
    <div id="myModalADDConge" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Ajouter une demande de Congé</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/mes_conges/save_add'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="form-group">
                        <label for="form-group">Motif :</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input custom-control-input-primary" type="radio" id="customRadio4" name="motif" checked="" value="ANNUEL">
                            <label for="customRadio4" class="custom-control-label">ANNUEL</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input custom-control-input-primary" type="radio" id="customRadio5" name="motif" value="EXCEPTIONNEL">
                            <label  for="customRadio5" class="custom-control-label">EXCEPTIONNEL <span style="font-size:12px !important; font-style: normal !important">(décès, naissance, mariage... ) (fournir un justificatif)</span></label>
                        </div>
                        <!--select name="motif_conge" id="direct" class="form-control select2" required>
                            <option selected="selected">
                                /****Selectionnez*****/
                            </option>
                            <option selected="selected">
                                Congés Payés
                            </option>
                            <option >
                                Congés Maternité
                            </option>
                            <option >
                                Congés Paternité
                            </option>
                            <option >
                                Congés Sabbatique
                            </option>
                            <option >
                                Congés pour raisons familiales
                            </option>
                            <option >
                                Congés de reclassement
                            </option>
                            <option>
                                Congés de longue maladie
                            </option>
                            <option >
                                Congés d'enseignement ou de recherche
                            </option>
                            <option >
                                Autre
                            </option>
                        </select--> 
                    </div>
                    <div class="form-group d-none" id="demo">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="justificatif" name="justificatif" accept="application/pdf">
                            <label class="custom-file-label" data-browse="Parcourir" for="justificatif">Choisir le fichier justificatif</label>
                        </div>
                    </div>
                    
                   
                    <div class="form-group">
                        <label for="form-group">Du : </label>
                        <input class="form-control" type="date"  name="date_debut_conge" required>
                    </div>
                    <div class="form-group">
                        <label for="form-group">Au :</label>
                        <input class="form-control" type="date"  name="date_fin_conge" required>
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

<script>

    window.onload = function() {
        /*var motif = document.getElementById('customRadio5');
        if ()
        motif.onchange = function() {
            if (motif.checked = true; == 'NON'){
                $("#demo").addClass('d-none');
            }

            if (motif.value == 'OUI'){
                $("#demo").removeClass('d-none');
            }

        }*/
        $('input:radio[name="motif"]').change(function() {
        if ($(this).val() == 'ANNUEL') {
            $("#demo").addClass('d-none');
        } else {
            $("#demo").removeClass('d-none');
        }
    });

    }

    /*
    function handleClick(){
        alert('New value: ' + $(this).val());
    }*/

</script>
  
@endsection
