
@extends('client.apprh', ['titre' => 'Configuration-RH'])
    
@section('contenu')
    
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edition Utilisateur</h1>
                </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                <li class="breadcrumb-item active"><a href="/access/utilisateurs">Utlisateurs</a></li>
                <li class="breadcrumb-item active">Edition</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-12">

                        <div class="card">

                            <form class="form-horizontal" method="post" action="{{'/access/utilisateurs/saveedituser'}}" enctype="multipart/form-data">
                                @csrf
                            <!-- card-header -->
                                <div class="card-header">
                                    <h3 class="card-title" style="font-weight: bold">Informations de l'utilisateur</h3>
                                </div>
                                <!-- /.card-header -->

                                <!-- card-body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="exampleInputEmail1" class="col-sm-4 col-form-label">Email address</label>
                                                <div class="col-sm-8">
                                                <input type="email" value='{{$user->email}}'class="form-control" id="exampleInputEmail1" name="email">
                                                <input type="hidden" name='valid' value="{{$user->id}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="form-group" class="col-sm-4 col-form-label">Nom</label>
                                                <div class="col-sm-8">
                                                <input class="form-control" type="text" placeholder="Nom" name="nom" minlength="4" required value="{{$user->nom}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="form-group" class="col-sm-4 col-form-label">Prenom</label>
                                                <div class="col-sm-8">
                                                <input class="form-control" type="text" placeholder="Prenom"  name="prenom" minlength="4" required value="{{$user->prenom}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Groupe de l'utlisateur</label>
                                                <div class="col-sm-8">
                                                <select class="form-control select2" name="groupe" required>
                                                    @foreach ($groupes as $groupe)
                                                        @if ($groupe->id == $user->groupe_id)
                                                        <option selected value="{{$groupe->id}}" >{{$groupe->libelle}}</option>
                                                        @else
                                                        <option value="{{$groupe->id}}" >{{$groupe->libelle}}</option>
                                                        @endif
                                                        
                                                    @endforeach>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="col-12">
                                                <div class="form-group">
                                                <label>
                                                    Employés responsables de validations des Workflows :
                                                </label>
                                                <input type="hidden" name="stringW" id="stringW" >
                                                <select class="duallistbox" id="duallistbox" multiple="multiple" style="display: none;" name="worklowuser[]" size="6">
                                                    @if($employeChefService != null)
                                                        <option value="{{$employeChefService[0]->code}}">
                                                            {{$employeChefService[0]->libelle}} --> {{$employeChefService[0]->nom_c}} 
                                                        </option>
                                                    @endif
                                                    @if($employeRespoDepartement!= null)
                                                        <option value="{{$employeRespoDepartement[0]->code}}">
                                                            {{$employeRespoDepartement[0]->libelle}} --> {{$employeRespoDepartement[0]->nom_c}} 
                                                        </option>
                                                    @endif
                                                    @if($employeDirecteur!= null)
                                                        <option value="{{$employeDirecteur[0]->code}}">
                                                            {{$employeDirecteur[0]->libelle}} --> {{$employeDirecteur[0]->nom_c}} 
                                                        </option>
                                                    @endif
                                                    @if($employeDRH!= null)
                                                        <option value="{{$employeDRH[0]->code}}">
                                                            {{$employeDRH[0]->libelle}} --> {{$employeDRH[0]->nom_c}} 
                                                        </option>
                                                    @endif
                                                    @if($employeDG!= null)
                                                        <option value="{{$employeDG[0]->code}}">
                                                            {{$employeDG[0]->libelle}} --> {{$employeDG[0]->nom_c}} 
                                                        </option>
                                                    @endif
                                                    
                                                </select>
                                                </div>
                                                <!-- /.form-group -->
                                            </div>
                                        <!-- /.col -->
                                        </div>

                                    </div>
                                            
                                            
                                    <!--div class="form-group row">
                                        <label for="cimage" class="col-sm-4 col-form-label">Photo</label>
                                        <div class="col-sm-8">
                                        <img id="imageVisuel" src="/storage/users/images/{{$user->image}}" height="150px">
                                        <input id="imageModal" class="form-control" type="file" accept="image/*"  name="image">
                                        </div>
                                    </div-->
                                
                                </div>
                            <!-- /.card-body -->
                                <div class="card-footer">
                                    <div class="offset-sm-5 col-sm-6">
                                        <button type="submit" class="btn btn-danger" id="submit">Valider</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection 

@section('customjavascript')

<!-- Bootstrap4 Duallistbox -->
<script src="/frontend/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- Page specific script -->
<script>
    $(function () {
        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox({

            sortByInputOrder: 'true',
            // sort by input order
            // default text
            /*filterTextClear:'show all',
            filterPlaceHolder:'Filter',
            moveSelectedLabel:'Move selected',
            moveAllLabel:'Move all',
            removeSelectedLabel:'Remove selected',
            removeAllLabel:'Remove all',
            infoText:'Showing all {0}',   */

        })    
        
       
        $('#duallistbox').on('change', function() {

            var yourArray = []; 
            var monString = "";
            $.each($('#duallistbox option[data-sortindex]'), function(index, values) {
                yourArray[$(values).attr('data-sortindex')] = $(values).val();
                //monString =  $(values).val();
                
            });
            yourArray.forEach(element => {
                monString = monString+'-'+element;
            });
            //alert(monString);
            $('#stringW').val(monString);

        });

    });
</script>
<script>
    $('#submit').click(function(){
            var campos= [];
            $('#duallistbox option'), function(index, values) {
                campos.push($(this).val);
            });
            alert(campos);
        });
</script>
    
@endsection
