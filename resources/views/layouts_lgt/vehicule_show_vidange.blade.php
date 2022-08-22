    @extends('client.vehicule_show')

    @section('contenu2')
    <div class="card">

        <form method="post" action="{{'/logistique_securite/vehicule/edit_vidange'}}" enctype="multipart/form-data">
            @csrf 
            <div class="card-header p-2">
                <h3>VIDANGE</h3>
            </div><!-- /.card-header-->
            <div class="card-body">
                <h5 style="color: ">Prochaine Vidange</h5>
                <div class="row">
                    <div class="col-md-10">
                        <table class="table tablePresentation col-md-8" style="border: 0px">
                            <tbody>
                                <tr>
                                    <td class="col-md-5" style="text-align: right">Prochaine Vidange :</td>
                                    <th class="col-md-5">
                                        <input class="form-control" type="number" name="km_actuel" id="km_actuel" value="{{$prochainevidange[0]->prochainevidange}}" pattern="[0-9]*" minlength="1" maxlength="6" readonly>
                                    </td>
                                </tr>
                                    
                            </tbody>
                        </table>
                    </div>
                </div>
                <h5 style="color: ">Etat Actuel</h5>

                    <div class="row">
                        <div class="col-md-10">
                            <table class="table tablePresentation col-md-8" style="border: 0px">
                                <tbody>
                                    <tr>
                                        <td class="col-md-5" style="text-align: right">Kilométrage Actuel :</td>
                                        <th class="col-md-5">
                                            <input class="form-control" type="number" name="km_actuel" id="km_actuel" value="{{$vehicule[0]->km_actuel}}" pattern="[0-9]*" minlength="1" maxlength="6" required>
                                            <input type="hidden" readonly id="matricule" name="matricule" value="{{$vehicule[0]->matricule}}">
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="col-md-5" style="text-align: right">Alerte 1 :</td>
                                        <td class="col-md-5">
                                            <input class="form-control" type="number" name="alerte1" id="alerte1" value="{{$vehicule[0]->km_alerte1}}" pattern="[0-9]*" minlength="1" maxlength="6" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-5" style="text-align: right">Alerte 2 :</td>
                                        <td class="col-md-5">
                                            <input class="form-control" type="number" name="alerte2" id="alerte2" value="{{$vehicule[0]->km_alerte2}}" pattern="[0-9]*" minlength="1" maxlength="6" required>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-2">

                        </div>
                    </div>
            
    
            </div><!-- /.card-body -->

            @if (Session('permission')[0]->edit == '1')
                <div class="card-footer p-2">
                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Enregistrer les paramètres" class="btn btn-warning" name="edit" value="edit" >
                        Modifier
                    </button>
                </div><!-- /.card-footer-->
            @endif

        </form>
                
            
    </div>
            
        <br class=""/>

    <div class="card">
        <div class="card-body">
            <h5 style="color: ">Historique Vidanges</h5>
            @if (Session('permission')[0]->add == '1')
                <div class="row">
                    <div class="col-md-5">
                        <button class="btn btn-app bg-success tabBtnAdd" data-toggle="modal" id="tabBtnAdd" data-placement="right" title="Ajouter une nouvelle vidange">
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
                            <th>Date Vidange</th>
                            <th>Concessionnaire</th>
                            <th>Type</th>
                            <th>Kilométrage (après vidange)</th>
                            <th>Prix (F.cfa)</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($vidanges as $vidange)
                                <tr>  
                                    <td class="t_libelle">{{ date("d/m/Y", strtotime($vidange->date)) }}</td>

                                    <td class="t_marque">{{$vidange->lib_concessionnaire}}</td>

                                    <td class="t_marque">
                                        @if ($vidange->type == "S")
                                            SIMPLE
                                        @endif
                                        @if ($vidange->type == "C")
                                            COMPLETE
                                        @endif
                                    </td>

                                    <td class="t_modele">{{$vidange->km_actuel}}</td>

                                    <td class="t_image">{{$vidange->prix}}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
              
        </div>             
    </div>




     <!-- Modal ADD-->
<div id="myModalADD" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg"> <!-- modal-lg-->
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter une Vidange</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="cmxform" method="post" action="{{'/logistique_securite/vehicule/add_vidange'}}" enctype="multipart/form-data">
                @csrf 
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Date Vidange : </label>
                                <input type="date" id="start" name="date_vidange" placeholder="1990-07-22" min="2009-01-01" class="form-control date" required>
                                <input type="hidden" readonly id="matricule" name="matricule" value="{{$vehicule[0]->matricule}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Concessionnaire : </label>
                                <select name="concessionnaire" id="concessionnaire" class="form-control select2" required>   
                                    <option value="">
                                        /****   Selectionnez    ***/
                                    </option>      
                                    @foreach ($concessionnaires as $concessionnaire)
                                        <option value="{{$concessionnaire->id}}">{{$concessionnaire->libelle}}</option>
                                    @endforeach        
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Type de vidange : </label>
                                <select name="type" id="type" class="form-control select2" required>         
                                    <option value="">
                                        /****   Selectionnez    ***/
                                    </option>
                                    <option value="S">SIMPLE</option>
                                    <option value="C">COMPLETE</option>        
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Kilométrage Actuel : </label>
                                <input class="form-control" type="text" name="km_actuel" placeholder="ex: 15000" required onkeyup="
                                    var start = this.selectionStart;
                                    var end = this.selectionEnd;
                                    this.value = this.value.toUpperCase();
                                    this.setSelectionRange(start, end);"  pattern="[0-9]*" minlength="1" maxlength="6">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form-group">Prix : </label>
                                <input class="form-control" type="number"  name="prix" placeholder="ex: 1000000" required  minlength="4" maxlength="9" min="10000" max="1000000">
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