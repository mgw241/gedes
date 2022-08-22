
@extends('client.apprh', ['titre' => 'Mes Missions'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Mes Missions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                      <li class="breadcrumb-item active">Mes Missions</li>
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
                                        <button type="submit" class="btn btn-app bg-success tabBtnAddMission" data-toggle="modal" data-placement="right" title="Ajouter une demande de mission">
                                            <i class="fas fa-plus"></i> Ajouter Mission
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
                                <th>Date Départ</th>
                                <th>Date Retour</th>
                                <th>Objet</th>
                                <!--th>Demande de mission</th-->
                                <th>Fiche de frais </th>
                                <th>Ordre de mission</th>
                                <th>Analyse</th>
                                <!--th>Action</th-->
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($missions as $mission)
                                    <tr>        
                                        <td class="t_Date_depart">
                                            {{date("d/m/Y", strtotime($mission->date_debut))}}
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
                                        <td class="t_Date_retour">
                                            {{date("d/m/Y", strtotime($mission->date_retour))}}
                                        </td>
                                        <td class="t_Objet">
                                            {{$mission->objet}}
                                        </td>
                                        <!--td class="t_Demande_mission">
                                            @if ($mission->statut == 1)
                                                <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$mission->code_emp}}/{{$mission->fichier_demande}}" target="_blank" class="lienPDF">
                                                    <i class="nav-icon fas fa-file-pdf" ></i>
                                                    <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                                </a>
                                            @endif
                                        </td-->
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
                                            <a class="tabBtnEdit" href="/access/groupes/edit_group/" ><i class="fas fa-lg fa-edit "></i> </a>
                                            
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


    <!-- Modal  ADD Mission-->
    <div id="myModalADDMission" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg">

        <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Ajouter une Demande de Mission</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form class="cmxform" method="post" action="{{'/mes_missions/save_add'}}" enctype="multipart/form-data">
            @csrf 
            <div class="modal-body"> 
                <!--div class="form-group">
                    <label>Da</label>
                    <input type="text" class="form-control" name="nom" id="nom" value="{{session()->get('user')->nom}}">
                </div-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="form-group">Objet de la mission :</label>
                            <input class="form-control" type="texte"  name="objet" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="form-group">Pays : </label>
                            <select name="pays" class="form-control select2" id="pays" required>
                                @foreach ( $pays as $item )
                                    <option value="{{$item->libelle}}" {{$item->libelle=='Gabon' ? 'selected' : ''}}>{{$item->libelle}} </option>
                                @endforeach
                            </select>
                            <!--input class="form-control" type="texte"  name="pays" required-->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="form-group">Ville : </label>
                            <!--input class="form-control" type="texte" name="ville" id="pays" required-->
                            <select name="ville" class="form-control select2" id="ville" required>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="form-group">Date de départ : </label>
                            <input class="form-control" type="date"  name="date_depart" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="form-group">Date de retour : </label>
                            <input class="form-control" type="date"  name="date_retour" required>
                        </div>
                    </div>
                </div>
                <!--div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="form-group">Durée de la mission (en jours)</label>
                            <input class="form-control" type="number" name="duree" required>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                </div-->
                <hr class="mt-3 mb-3"/>
                <h4 style="text-decoration-line: underline">Avance des frais de mission</h4>
                <div class="row">
                    <!--div class="col-md-4">
                        <div class="form-group">
                            <label for="form-group">Nombre de jour Repas :</label>
                            <input class="form-control" type="number" name="repas" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="form-group">Nombre de jour Hébergement : </label>
                            <input class="form-control" type="number" name="hebergement" required>
                        </div>
                    </div-->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="form-group">Transport :</label>
                            <select name="transport" id="" class="form-control select2">
                                @foreach (StaticArray::$transport as $item)
                                    <option value="{{$item["moyen"]}}" {{$item["moyen"]=='Avion' ? 'selected' : ''}}>{{$item["moyen"]}} </option>
                                @endforeach
                            </select>
                            <!--input class="form-control" type="number" name="transport" required-->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="form-group">Nombre de jour Téléphone: </label>
                            <input class="form-control" type="number" name="telephone" value="0" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="form-group">Nombre de jour HTM/ MOT :</label>
                            <input class="form-control" type="number" name="mot" value="0" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="form-group">Nombre de jour Aléas ou Autres: </label>
                            <input class="form-control" type="number" name="autre" value="0" required>
                        </div>
                    </div>
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

        $('.tabBtnAddMission').click(function(){
            //  J'afiche deja le Modal
            $('#myModalADDMission').modal('show');
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
        window.onload = function() {
            var pays = document.getElementById('pays');
            /* CHARGER ON LOAD FIRST*/
            $.ajax({
                url: '/get_ville_of_pays',
                type: 'post',
                data:{
                    "pays": pays.value,
                    "_token": "{{ csrf_token() }}",
                     },
                success: function(data){
    
                    var len = data.length;
    
                    $("#ville").empty();
    
                    //$("#departement").append("<option selected>/****Selectionnez*****/</option>");
                    for( var i = 0; i<len; i++){
                        var code = data[i]['id'];
                        var libelle = data[i]['libelle'];
                        
                        $("#ville").append("<option value='"+libelle+"' >"+libelle+"</option>");
                        $('#ville').prop('change', true);
                    }
                    }
            });
            /* CHARGER ON LOAD FIRST*/
    
            pays.onchange = function() {
                $.ajax({
                url: '/get_ville_of_pays',
                type: 'post',
                data:{
                    "pays": pays.value,
                    "_token": "{{ csrf_token() }}",
                     },
                success: function(data){
    
                    var len = data.length;
    
                    $("#ville").empty();
    
                    //$("#departement").append("<option selected>/****Selectionnez*****/</option>");
                    for( var i = 0; i<len; i++){
                        var code = data[i]['id'];
                        var libelle = data[i]['libelle'];
                        
                        $("#ville").append("<option value='"+libelle+"' >"+libelle+"</option>");
                        $('#ville').prop('change', true);
                    }
                    }
                });
    
            }
    
        }
    </script>
    

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
