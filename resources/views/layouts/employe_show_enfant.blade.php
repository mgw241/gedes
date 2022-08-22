    @extends('client.employes_show')

    @section('contenu2')
    <div class="card">
    <div class="card-header p-2">
        <h3>ENFANTS</h3>
    </div><!-- /.card-header-->
    <div class="card-body">

        @if (Session('permission')[0]->add == '1')
            <div class="row">
                <div class="col-md-12">
                    <a href="" class="" data-toggle="collapse" data-target="#demo" style="color: ; "><h5 style="color: ; text-decoration: underline;">Ajouter un Enfant</h5></a>


                    <form action="/rh/employes/save_enfant" method="POST">
                        @csrf
                        <div id="demo" class="collapse col-md-12">
                            <div class="col-md-8"><hr class="mt-3 mb-3"/></div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Nom</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="nom" placeholder="Nom" required>
                                            <input type="hidden" value="{{$employes[0]->code}}" name="employe">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Prenom</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" placeholder="Prenom"  name="prenom" minlength="4" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Date de naissance</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="date"  name="date_naiss" minlength="4" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Scolarité </label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" placeholder="Nom de l'établissement" value="Non" name="scolarite" required>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Nom complet du Conjoint</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" placeholder="Nom" name="nom_conjoint" minlength="4" required>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Profession du Conjoint</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" placeholder="Profession" name="profession_conjoint" minlength="4" required>
                                        </div>
                                    </div>
                                </div>                               
                            </div>
                            <div class="row">

                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Téléphone du Conjoint</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" name="telephone_conjoint" required min="8" id="validationCustom03" pattern="^0[0-9]{8}" size="9" minlength="9" maxlength="9" placeholder="076122159" required>
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
                    <h5 style="color: ">Enfants </h5>
                    <div class="col-md-8"><hr class="mt-3 mb-3"/></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th >Nom</th>
                                <th >Prenom</th>
                                <th>Date de naissance</th>
                                <th>Scolarité</th>
                                <th>Non du comjoint</th>
                                <th>Profession</th>
                                <th>Téléphone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enfants as $enfant)
                            <tr>
                                <td class="t_Nom">{{$enfant->nom}}</td>
                                <td class="t_Prenom">{{$enfant->prenom}}</td>
                                <td >{{date("d/m/Y", strtotime($enfant->date_naissance))}}</td>
                                <td class="t_Date_naiss" style="display:none;">{{date("Y-m-d", strtotime($enfant->date_naissance))}}</td>
                                <td class="t_Scolarite">{{$enfant->scolarite}}</td>
                                <td class="t_Conjoint">{{$enfant->nom_conjoint}}</td>
                                <td class="t_Profession">{{$enfant->profession_conjoint}}</td>
                                <td class="t_Télephone">{{$enfant->telephone}}</td>
                                <td class="t_Action">
                                    @if (Session('permission')[0]->edit == '1')
                                        <a class="tabBtnEdit" value="$enfant->id"  id="{{$enfant->id}}" data-toggle="modal"><i class="fas fa-lg fa-edit"></i></a>
                                    @endif

                                    @if (Session('permission')[0]->delete == '1')
                                        <a class="tabBtnDelete" id="{{$enfant->id}}" data-toggle="modal"><i class="fas fa-lg  fa-trash"></i></a>
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
                    <buttid="commentForm"on type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
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


    @endsection