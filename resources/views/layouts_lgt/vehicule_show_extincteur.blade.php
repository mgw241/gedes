@extends('client.vehicule_show')

@section('contenu2')
                                    <?php 
                                        $month = date('m');
                                        $day = date('d');
                                        $year = date('Y');

                                        $today = $year . '-' . $month . '-' . $day;
                                    ?>
<div class="card">
    <div class="card-header p-2">
        <h3>EXTINCTEUR</h3>
    </div><!-- /.card-header-->
    <div class="card-body">


        <h5 style="color: ">Dernière carte Extincteur</h5>
        <div class="row">
            <div class="col-md-12 row">
                <table class="table tablePresentation col-md-8" style="border: 0px">
                    <tbody>
                        <tr>
                            <td class="col-md-3" style="text-align: right">Date Obtention :</td>
                            <th class="col-md-9">@if (isset($lastExtincteur[0])) {{ date("d/m/Y", strtotime($lastExtincteur[0]->obtention)) }}
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-3" style="text-align: right">Date Expiration :</td>
                            <th class="col-md-9">@if (isset($lastExtincteur[0])) {{ date("d/m/Y", strtotime($lastExtincteur[0]->expiration)) }}
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-3" style="text-align: right">STATUT :</td>
                            <th class="col-md-9">
                                @if (isset($lastExtincteur[0])) 
                                    @if ($lastExtincteur[0]->statut == 1)
                                        <span style="color: rgb(33, 150, 29)"><i class="nav-icon fas fa-check-circle fa-thumbs-up fa-sm" > A JOUR</i></span>
                                    @endif
                                    @if ($lastExtincteur[0]->statut == 0)
                                        <span style="color: rgb(209, 53, 14)"><i class="nav-icon fas fa-times-circle fa-sm" > EXPIRE</i></span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br class=""/>

        <h5 style="color: ">Historique Cartes Extincteurs</h5>
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
                        <th>Date Obtention</th>
                        <th>Date Expiration</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($extincteurs as $extincteur)
                            <tr>  
                                <td class="t_libelle">{{ date("d/m/Y", strtotime($extincteur->obtention))}}</td>

                                <td class="t_marque">{{ date("d/m/Y", strtotime($extincteur->expiration))}}</td>

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
                    <h4 class="modal-title">Ajouter une Carte Extincteur</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form class="cmxform" method="post" action="{{'/logistique_securite/vehicule/add_extincteur'}}" enctype="multipart/form-data">
                    @csrf 
                    <div class="modal-body"> 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form-group">Date Obtention : </label>
                                    <input type="date" id="start" name="date_obtention" placeholder="1990-07-22" min="2009-01-01" class="form-control date" required>
                                    <input type="hidden" readonly id="matricule" name="matricule" value="{{$vehicule[0]->matricule}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form-group">Date Expiration : </label>
                                    <input type="date" id="start" name="date_expiration" placeholder="1990-07-22" min="2009-01-01" class="form-control date" required>
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