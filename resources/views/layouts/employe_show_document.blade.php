    @extends('client.employes_show')

    @section('contenu2')
    <div class="card">
        <div class="card-header p-2">
            <h3>DOCUMENTS</h3>
        </div><!-- /.card-header-->
        <div class="card-body">

            @if (Session('permission')[0]->add == '1')
                <div class="row">
                    <div class="col-md-12">
                        <a href="" class="" data-toggle="collapse" data-target="#demo" style="color: ; "><h5 style="color: ; text-decoration: underline;">Téléverser un document</h5></a>


                        <form action="/rh/employes/save_add_documents" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div id="demo" class="collapse col-md-12">
                                <div class="col-md-8"><hr class="mt-3 mb-3"/></div>
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group row col-md-10">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Type de document</label>
                                            <div class="form-group col-md-8">
                                                <select  name="document_type" class="form-control select2">
                                                    @foreach ($documents as $document)
                                                        <option value="{{$document->id}}">
                                                            {{$document->libelle}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" value="{{$employes[0]->code}}" name="employe">
                                            </div>
                                        </div>
                                    </div>                           
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group row col-md-10">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Charger le ficher</label>
                                            <div class="form-group col-md-8">
                                                <input id="document_file" class="form-control" type="file"  accept="application/pdf"  name="document_file" required>
                                            </div>
                                        </div>
                                    </div>                           
                                </div>
                                
                                <button class="btn btn-success" type="submit">Ajouter</button>
                                
                            </div>
                        </form>
                        
                        
                    </div>
                </div>
            
                <hr class="mt-3 mb-3"/>
            @endif

                <div class="row">
                    <div class="col-md-12">
                        <h5 style="color: ">Liste des documents téléversés </h5>
                        <div class="col-md-8"><hr class="mt-3 mb-3"/></div>
                        <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Fichier</th>
                                    <th>Date</th>
                                    <th>Actions</th>
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
                                    <td class="t_Action">
                                        @if (Session('permission')[0]->edit == '1')
                                            <a class="tabBtnEdit" id="{{$sesdocument->type_id}}" data-toggle="modal"><i class="fas fa-lg fa-edit"></i></a>
                                        @endif

                                        @if (Session('permission')[0]->delete == '1')
                                            <a class="tabBtnDelete" id="{{$sesdocument->type_id}}" data-toggle="modal"><i class="fas fa-lg  fa-trash"></i></a>
                                        @endif
                                    </td>
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
            
            <form class="cmxform" id="commentForm" method="post" action="/rh/employes/save_delete_documents">
                @csrf 
                <div class="modal-footer">
                    <input class="form-control" type="hidden" id="idModalDelete" name="idModal">
                    <input class="btn btn-danger" type="submit" value="OUI">
                    <input type="hidden" value="{{$employes[0]->code}}" name="employe">
                    <button type="button" class="btn btn-default" data-dismiss="modal">NON</button>
                </div>
            </form>
            
        </div>

        </div>
    </div>
    <!-- Modal -->

    <!-- Modal  EDIT-->
    <div id="myModalEdit" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title"  id="titreEdit">Edition du document : </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="/rh/employes/save_edit_documents" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="form-group">
                        <label for="form-group">Charger le ficher : </label>
                        <input type="hidden" value="{{$employes[0]->code}}" name="employe">
                        <input type="hidden" id="id_edit" name="id_edit">
                        <input id="document_file" class="form-control" type="file"  accept="application/pdf"  name="document_file" required>
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
                $('#titreDelete').text("Voulez-vous vraiment supprimer le document: "+nom+" ?");    // # c'est le ID
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


                    $('#titreEdit').text("Edition du document : "+nom);

                    $('#nom_edit').val(nom);
                    $('#prenom_edit').val(prenom);
                    $('#date_naiss_edit').val(date_naiss);
                    $('#scolarite_edit').val(scolarite);
                    $('#nom_conjoint_edit').val(nom_conjoint);
                    $('#profession_conjoint_edit').val(profession);
                    $('#telephone_conjoint_edit').val(telephone);
                    $('#id_edit').val(idF);

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