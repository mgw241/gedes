    @extends('client.employes_show_emp')

    @section('contenu2')
    <div class="card">
    <div class="card-header p-2">
        <h3>SALAIRE</h3>
    </div><!-- /.card-header-->
    <div class="card-body">

        <div class="row">
            <div class="col-md-8">
                <h5 style="color: ">Salaire de Base</h5>
                <table class="table tablePresentation col-md-12" style="border: 0px">
                    <tbody>
                        <tr>
                            <td class="col-md-3">Salaire Brut :</td>
                            <th class="col-md-9" style="text-align: right">
                                {{$employes[0]->salaire}} Fcfa
                            </th>
                        </tr>
                        <tr>
                    </tbody>
                </table>
            </div>
        </div>  
        <div class="row">
            <div class="col-md-8">
                <h5 style="color: ">(-) Imposables</h5>
                <table class="table tablePresentation col-md-12" style="border: 0px;">
                    <tbody>
                        <tr>
                            <td class="col-md-3">IRRPP :</td>
                            <th class="col-md-9" style="text-align: right">
                                {{$employes[0]->salaire * 1.75 /100}} Fcfa
                            </th>
                        </tr>
                        <tr>
                            <td class="col-md-3">CNSS :</td>
                            <th class="col-md-9" style="text-align: right"> {{$employes[0]->salaire * 2.5/100;}} Fcfa</td>
                        </tr>
                        <tr>
                            <td class="col-md-3">CNAMGS :</td>
                            <th class="col-md-9" style="text-align: right">{{$employes[0]->salaire * 2/100;}} Fcfa</td>
                        </tr>
                        <tr>
                            <td class="col-md-3">CSS :</td>
                            <th class="col-md-9" style="text-align: right">{{$employes[0]->salaire * 2.725/100;}} Fcfa</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-8">
                <h5 style="color: ">(+) Indemnité non imposables</h5>
                <table class="table tablePresentation col-md-12" style="border: 0px">
                    <tbody>
                        <tr>
                            <td class="col-md-3">IRRPP :</td>
                            <th class="col-md-9" style="text-align: right">
                                {{$employes[0]->salaire}} Fcfa
                            </th>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>  
        <div class="row col-md-8">
            <div class="col-md-3">
                <h5 style="color: red">
                     Salaire Net: 
                </h5>
            </div>
            <div class="col-md-9">
                <h5 style="color: red; font-weight: bold;text-align: right">
                     {{$employes[0]->salaire}} Fcfa
                </h5>
            </div>
        </div>            
        
    </div><!-- /.card-body -->
    </div>
    @endsection

    @section('customjavascript')

    <script>

    window.onload = function() {
        
        var direct = document.getElementById('direct');
        direct.onchange = function() {
            $.ajax({
            url: '/rh/employes/get_postes_of_direction',
            type: 'post',
            data:{
                "code": direct.value,
                "_token": "{{ csrf_token() }}",
                 },
            success: function(data){

                //Log the data to the console so that
                //you can get a better view of what the script is returning.
                console.log(data);

                var len = data.length;

                $("#sel_poste").empty();

                $("#sel_poste").append("<option selected>/****Selectionnez*****/</option>");
                for( var i = 0; i<len; i++){
                    var id = data[i]['id'];
                    var libelle = data[i]['libelle'];
                    
                    $("#sel_poste").append("<option value='"+id+"' >"+libelle+"</option>");
                    $('#sel_poste').prop('change', true);
                }
            }
            });
        }

    }

    </script>


    @endsection