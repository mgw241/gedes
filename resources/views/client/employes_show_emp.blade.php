
@extends('client.apprh', ['titre' => 'Detail employe'])
    
@section('contenu')
    
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{$employes[0]->prenom}} {{$employes[0]->nom}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                            <li class="breadcrumb-item">{{$employes[0]->nom}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center" style="margin: -10px">
                        <img width="60%" 
                            src="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$employes[0]->code}}/{{$employes[0]->image}}"
                            alt="Photo de profie">

                            <h3 class="profile-username text-center"> {{$employes[0]->nom}}</h3>
                            <p class="text-muted text-center">{{$employes[0]->prenom}}</p>
                    </div>

                    <div>

                    </div>


                </div>
                <!-- /.card-body -->

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item" style="text-align: center;margin-bottom:5px;margin-left:10px;margin-right:10px">
                        <a class="btn btn-primary btn-block btn-sm" style="margin-bottom: 5px;font-size: 15px;" href="/profil">G??NERALIT??S</a>
                    </li>
                    <li class="nav-item" style="text-align: center;margin-bottom:5px;margin-left:10px;margin-right:10px">
                        <a class="btn btn-primary btn-block btn-sm"  href="/profil/carriere" style="margin-bottom: 5px;font-size: 15px;">CARRI??RE</a>
                    </li>
                    <li class="nav-item" style="text-align: center;margin-bottom:5px;margin-left:10px;margin-right:10px">
                        <a class="btn btn-primary btn-block btn-sm"  href="/profil/salaire" style="margin-bottom: 5px;font-size: 15px;">SALAIRE</a>
                    </li>
                    <li class="nav-item" style="text-align: center;margin-bottom:5px;margin-left:10px;margin-right:10px">
                        <a class="btn btn-primary btn-block btn-sm" href="/profil/conge" style="margin-bottom: 5px;font-size: 15px;">CONG??S</a>
                    </li>
                    <li class="nav-item" style="text-align: center;margin-bottom:5px;margin-left:10px;margin-right:10px">
                        <a class="btn btn-primary btn-block btn-sm" href="/profil/abscence" style="margin-bottom: 5px;font-size: 15px;">ABSCENCES</a>
                    </li> 
                    <li class="nav-item" style="text-align: center;margin-bottom:5px;margin-left:10px;margin-right:10px">
                        <a class="btn btn-primary btn-block btn-sm" href="/profil/mission" style="margin-bottom: 5px;font-size: 15px;">MISSIONS</a>
                    </li> 
                    <li class="nav-item" style="text-align: center;margin-bottom:5px;margin-left:10px;margin-right:10px">
                        <a class="btn btn-primary btn-block btn-sm" href="/profil/enfant" style="margin-bottom: 5px;font-size: 15px;">ENFANTS</a>
                    </li>   
                    <li class="nav-item" style="text-align: center;margin-bottom:5px;margin-left:10px;margin-right:10px">
                        <a class="btn btn-primary btn-block btn-sm" href="/profil/document" style="margin-bottom: 5px;font-size: 15px;">DOCUMENTS</a>
                    </li>        
                </ul>
                
            </div>
            <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
            
                @yield('contenu2')

            <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
        <!-- /.content -->
    </div>

@endsection 


@section('customjavascript')
    <!-- Page specific script From Card Of Employe Details-->
    @yield('customjavascript')
    

@endsection
