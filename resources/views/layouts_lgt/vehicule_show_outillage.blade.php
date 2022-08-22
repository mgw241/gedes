    @extends('client.vehicule_show')

    @section('contenu2')
                                        <?php 
                                            $month = date('m');
                                            $day = date('d');
                                            $year = date('Y');

                                            $today = $year . '-' . $month . '-' . $day;
                                        ?>
    <div class="card">
        <form method="POST" action="{{'/logistique_securite/vehicule/edit_outillage'}}" enctype="multipart/form-data">
            @csrf 
            <div class="card-header p-2">
                <h3>OUTILLAGE</h3>
            </div><!-- /.card-header-->
            <div class="card-body">
    
                <div class="row">
                    <div class="col-md-12 row">
                            <!--h5 style="color: ">Fonction Actuelle</h5-->
                            <table class="table tablePresentation col-md-4" style="border: 0px">
                                <tbody>
                                    <tr>                   
                                        <td class="col-md-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="crique" name="crique"   {{ $vehicule[0]->crique == 1 ? "checked" : ""}}>
                                                <input type="hidden" readonly id="matricule" name="matricule" value="{{$vehicule[0]->matricule}}">
                                                <label class="custom-control-label" for="crique">Crique</label>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>                   
                                        <td class="col-md-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="trousseaum" name="trousseaum" {{ $vehicule[0]->trousseaum == 1 ? "checked" : ""}}>
                                                <label class="custom-control-label" for="trousseaum">Trousse à Molette</label>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>                   
                                        <td class="col-md-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="gilet" name="gilet" {{ $vehicule[0]->gilet == 1 ? "checked" : ""}}>
                                                <label class="custom-control-label" for="gilet">Gilet</label>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            <table class="table tablePresentation col-md-4" style="border: 0px">
                                <tbody>
                                    <tr>                   
                                        <td class="col-md-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="cle_a_roue" name="cle_a_roue" {{ $vehicule[0]->cle_a_roue == 1 ? "checked" : ""}}>
                                                <label class="custom-control-label" for="cle_a_roue">Clé à roue</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>                   
                                        <td class="col-md-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="baladeuse" name="baladeuse" {{ $vehicule[0]->baladeuse == 1 ? "checked" : ""}}>
                                                <label class="custom-control-label" for="baladeuse">Baladeuse</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>                   
                                        <td class="col-md-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="triangle" name="triangle" {{ $vehicule[0]->triangle == 1 ? "checked" : ""}}>
                                                <label class="custom-control-label" for="triangle">Triangle</label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table tablePresentation col-md-4" style="border: 0px">
                                <tbody>
                                    
                                    <tr>                   
                                        <td class="col-md-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="calle_metal" name="calle_metal" {{ $vehicule[0]->calle_metal == 1 ? "checked" : ""}}>
                                                <label class="custom-control-label" for="calle_metal">Calle métal</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>                   
                                        <td class="col-md-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="sangle" name="sangle" {{ $vehicule[0]->sangle == 1 ? "checked" : ""}}>
                                                <label class="custom-control-label" for="sangle">Sangle</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>                   
                                        <td class="col-md-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="tracker" name="tracker" {{ $vehicule[0]->tracker == 1 ? "checked" : ""}}>
                                                <label class="custom-control-label" for="tracker">Tracker</label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                                    
                    </div>
                </div>
                
            </div><!-- /.card-body -->

            @if (Session('permission')[0]->edit == '1')
                <div class="card-footer p-2">
                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Accepter la demande" class="btn btn-warning" name="edit" value="edit" >
                        Modifier
                    </button>
                </div><!-- /.card-footer-->
            @endif
        </form>
    </div>
    @endsection

    @section('customjavascript')



    @endsection