    @extends('client.employes_show_emp')

    @section('contenu2')
    <div class="card">
    <div class="card-header p-2">
        <h3>DOCUMENTS</h3>
    </div><!-- /.card-header-->
    <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 style="color: ">Liste des documents téléversés</h5>
                    <div class="col-md-8"><hr class="mt-3 mb-3"/></div>
                    <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Fichier</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sesdocuments as $sesdocument)
                            <tr>
                                <td class="t_Nom">{{$sesdocument->libelle}}</td>
                                <td class="t_Prenom">
                                    <a href="/storage/employes/{{$sesdocument->code_emp}}/{{$sesdocument->fichier}}" target="_blank" class="lienPDF">
                                        <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                        <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                    </a>
                                </td>
                                <td >{{date("d/m/Y h:m:i", strtotime($sesdocument->updated_at))}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            
        
    </div><!-- /.card-body -->
    </div>


    <!-- Modal DELETE-->
    <div id="myModalDelete" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="titreDelete" >Supprimer L'enfant</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <form class="cmxform" id="commentForm" method="post" action="/rh/employes/save_delete_enfant">
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
    <div id="myModalEdit" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title"  id="titreEdit">Edition de l'enfant: </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="/rh/employes/save_edit_enfant" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="form-group">
                        <label for="form-group">Nom</label>
                        <input class="form-control" type="text" placeholder="Nom" name="nom_edit" id="nom_edit" minlength="4" required>
                        <input type="hidden" value="{{$employes[0]->code}}" name="employe">
                        <input type="hidden" id="id_enfant" name="id_enfant">
                    </div> 
                    <div class="form-group">
                        <label for="form-group">Prenom (s)</label>
                        <input class="form-control" type="text" placeholder="Prenom" id="prenom_edit" name="prenom_edit" minlength="4" required>
                    </div>
                    <div class="form-group">
                        <label for="form-group">Date de naissance</label>
                        <input class="form-control" type="date" id="date_naiss_edit" name="date_naiss_edit" minlength="4" required>
                    </div>

                    <div class="form-group">
                        <label for="form-group">Scolarité</label>
                        <input class="form-control" type="text" placeholder="nom de l'établissement"  name="scolarite_edit" id="scolarite_edit" minlength="3" required>
                    </div>
                    <div class="form-group">
                        <label for="form-group">Nom complet du Conjoint</label>
                        <input class="form-control" type="text" placeholder="Nom" name="nom_conjoint_edit" id="nom_conjoint_edit"  minlength="4" required>
                    </div>
                    <div class="form-group">
                        <label for="form-group">Profession du Conjoint</label>
                        <input class="form-control" type="text" placeholder="Profession" name="profession_conjoint_edit" id="profession_conjoint_edit" minlength="4" required>
                    </div>
                    <div class="form-group">
                        <label for="form-group">Téléphone du Conjoint</label>
                        <input class="form-control" type="text" name="telephone_conjoint_edit" id="telephone_conjoint_edit" required min="8" id="validationCustom03" pattern="^0[0-9]{8}" size="9" minlength="9" maxlength="9" placeholder="076122159" required>
                    </div> 
                              
                </div>
                
                <div class="modal-footer">
                    <input class="btn btn-success" type="submit" value="Ajouter">
                    <button id="commentForm" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>

        </div>
    </div>
    <!-- Modal -->

    @endsection

    @section('customjavascript')

    <script type="text/javascript">
        $('.tabBtnDelete').click(function(){
            //  Recuperer les valeurs de la ligne du bouton clické
            var row = $(this).closest('tr');;   //  . c'est la classe
            var nom =  row.find('.t_Nom').text();
            var idF = $(this)[0].id;

            //alert(idF);
            //*

            //  mettre les valeurs dans le madal
            $('#titreDelete').text("Voulez-vous vraiment supprimer l'enfant: "+nom+" ?");    // # c'est le ID
            $('#idModalDelete').val(idF);    // # c'est le ID

            //  J'afiche deja le Modal
            $('#myModalDelete').modal('show');
            
        });

        $('.tabBtnEdit').click(function(){
                //  J'afiche deja le Modal
                var row = $(this).closest('tr');;   //  . c'est la classe
                var nom =  row.find('.t_Nom').text();
                var prenom =  row.find('.t_Prenom').text();
                var date_naiss =  row.find('.t_Date_naiss').text();
                var scolarite =  row.find('.t_Scolarite').text();
                var nom_conjoint =  row.find('.t_Conjoint').text();
                var profession =  row.find('.t_Profession').text();
                var telephone =  row.find('.t_Télephone').text();
                var idF = $(this)[0].id;


                $('#titreEdit').text("Edition de l'enfant: "+nom);

                $('#nom_edit').val(nom);
                $('#prenom_edit').val(prenom);
                $('#date_naiss_edit').val(date_naiss);
                $('#scolarite_edit').val(scolarite);
                $('#nom_conjoint_edit').val(nom_conjoint);
                $('#profession_conjoint_edit').val(profession);
                $('#telephone_conjoint_edit').val(telephone);
                $('#id_enfant').val(idF);

                $('#myModalEdit').modal('show');
        });
    </script>

    <script>
        $(function () {
        var table = $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "ordering": false,
            //"order": [[ 2, "desc" ]],
            buttons: [
        {
            extend: 'pdf',
            footer: true,
            exportOptions: {
                    columns: [0,1,2]
                }
        },
        {
            extend: 'csv',
            footer: false,
            exportOptions: {
                    columns: [0,1,2]
                }
            
        },
        {
            extend: 'excel',
            footer: false,
            exportOptions: {
                    columns: [0,1,2]
                }
        },
            {
            extend: 'colvis',
            footer: false,
            exportOptions: {
                    columns: [0,1,2]
                }
        } ,        
        ]  ,
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