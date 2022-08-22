    @extends('client.vehicule_show')

    @section('contenu2')
    <div class="card">
        <div class="card-header p-2">
            <h3>AFFECTATION</h3>
        </div><!-- /.card-header-->
        <div class="card-body">


            <h5 style="color: ">Affectation Actuelle</h5>
            <div class="row">
                <div class="col-md-12 row">
                    <table class="table tablePresentation col-md-8" style="border: 0px">
                        <tbody>
                            <tr>
                                <td class="col-md-3" style="text-align: right">Date Affectation :</td>
                                <th class="col-md-9">@if (isset($affectation_actuel[0])) {{date("d/m/Y", strtotime($affectation_actuel[0]->date_debut))}}
                                @endif
                                </td>
                            </tr>
                            <!--tr>
                                <td class="col-md-3" style="text-align: right">Poste :</td>
                                <th class="col-md-9">@if (isset($affectation_actuel[0])) {{$affectation_actuel[0]->nom_complet}}
                                    @endif</td>
                            </tr-->
                            <tr>
                                <td class="col-md-3" style="text-align: right">Employe :</td>
                                <th class="col-md-9">@if (isset($affectation_actuel[0])) {{$affectation_actuel[0]->nom_complet}}
                                    @endif</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>

            <br class=""/>

            <h5 style="color: ">Historique Affectations</h5>
            @if (Session('permission')[0]->add == '1')
                <div class="row">
                    <div class="col-md-5">
                        <button class="btn btn-app bg-success tabBtnAdd" data-toggle="modal" id="tabBtnAdd" data-placement="right" title="Ajouter une nouvelle affectation">
                            <i class="fas fa-plus"></i> Ajouter
                        </button>
                    </div>
                    <div class="col-md-6">
                        <!--h2 style="color: darkred">Abscences</h2-->
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                        <thead>
                        <tr>
                            <th>Date Affectation</th>
                            <!--th>Poste</th-->
                            <th>Employé</th>
                            <th>Fin Affectation</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($affectations as $affectation)
                                <tr>  
                                    <td class="t_libelle">{{ date("d/m/Y", strtotime($affectation->date_debut)) }}</td>

                                    <td class="t_modele">{{$affectation->nom_complet}}</td>

                                    <td class="t_image">{{$affectation->date_fin == NULL ? '-' : date("d/m/Y", strtotime($affectation->date_fin)) }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div><!-- /.card-body -->
        <!--div class="card-footer p-2">
            <button type="submit" data-toggle="tooltip" data-placement="top" title="Accepter la demande" class="btn btn-success" name="edit" value="edit" onclick="return confirm('Voulez-vous vraiment accepter? Cette action est irréversible')">
                Modifier
            </button>
            <button type="submit" data-toggle="tooltip" data-placement="right" title="Désactiver ce véhicule de la flotte" class="btn btn-danger" name="delete" value="delete"  >
                Supprimer
            </button>
        </div>< /.card-footer-->
    </div>



    <!-- Modal ADD-->
<div id="myModalADD" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg"> <!-- modal-lg-->
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter une Affectation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/logistique_securite/vehicule/add_affectation'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Date Affectation : </label>
                                <input type="date" id="start" name="date_affectation" placeholder="1990-07-22" min="2009-01-01" class="form-control date" required>
                                <input type="hidden" readonly id="matricule" name="matricule" value="{{$vehicule[0]->matricule}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Employé : </label>
                                <select name="employe" id="employe" class="form-control select2" required>         
                                    <option value="">
                                        /****   Selectionnez    ***/
                                    </option>
                                    @foreach ($employes as $employe)
                                        <option value="{{$employe->code}}">{{$employe->nom_complet}}</option>
                                    @endforeach            
                                </select>
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
<!-- /.MODALS -->
    @endsection

@section('customjavascript')

    <script>
        $(function () {
        var table = $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "order": [[ 0, "desc" ]], //or asc 
            "columnDefs" : [{"targets":0, "type":"date-eu"}],
            buttons: [
        {
            extend: 'pdf',
            footer: true,
            exportOptions: {
                columns: [':visible :not(:last-child)']
                }
        },
        {
            extend: 'csv',
            footer: false,
            exportOptions: {
                columns: [':visible :not(:last-child)']
                }
            
        },
        {
            extend: 'excel',
            footer: false,
            exportOptions: {
                columns: [':visible :not(:last-child)']
                }
        },
            {
            extend: 'colvis',
            footer: false,
            exportOptions: {
                columns: [':visible :not(:last-child)']
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

    <script type="text/javascript">
        $('.tabBtnAdd').click(function(){
                    //  J'afiche deja le Modal
                    $('#myModalADD').modal('show');
        });

    </script>

@endsection