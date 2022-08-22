
@extends('client.apprh', ['titre' => 'Detail Vehicule'])
    
@section('contenu')
    
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{$vehicule[0]->matricule}} | {{$vehicule[0]->nom}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="/logistique_securite/parc_automobile">Parc Automobile</a></li>
                            <li class="breadcrumb-item">{{$vehicule[0]->matricule}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <nav class="navbar navbar-expand navbar-secondary navbar-dark justify-content-center">
                <!-- Left navbar links -->
                <ul class="navbar-nav justify-content-center">
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/logistique_securite/parc_automobile/{{$vehicule[0]->matricule}}/identification" class="{{ (request()->is("logistique_securite/parc_automobile/*/identification"))?"btn btn-dark":"nav-link" }}" data-toggle="tooltip" data-placement="right" title="Accéder aux abscences des employés">IDENTIFICATION</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/logistique_securite/parc_automobile/{{$vehicule[0]->matricule}}/affectation" class="{{ (request()->is("logistique_securite/parc_automobile/*/affectation"))?"btn btn-dark":"nav-link" }}" data-toggle="tooltip" data-placement="right" title="Accéder aux abscences des employés">AFFECTATION</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/logistique_securite/parc_automobile/{{$vehicule[0]->matricule}}/vidange" class="{{ (request()->is("logistique_securite/parc_automobile/*/vidange"))?"btn btn-dark":"nav-link" }}" data-toggle="tooltip" data-placement="right" title="Accéder aux abscences des employés">VIDANGE</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/logistique_securite/parc_automobile/{{$vehicule[0]->matricule}}/visite_technique" class="{{ (request()->is("logistique_securite/parc_automobile/*/visite_technique"))?"btn btn-dark":"nav-link" }}" data-toggle="tooltip" data-placement="right" title="Accéder aux abscences des employés">VISITE TECHNIQUE</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/logistique_securite/parc_automobile/{{$vehicule[0]->matricule}}/extincteur" class="{{ (request()->is("logistique_securite/parc_automobile/*/extincteur"))?"btn btn-dark":"nav-link" }}" data-toggle="tooltip" data-placement="right" title="Accéder aux abscences des employés">EXTINCTEUR</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/logistique_securite/parc_automobile/{{$vehicule[0]->matricule}}/outillage" class="{{ (request()->is("logistique_securite/parc_automobile/*/outillage"))?"btn btn-dark":"nav-link" }}" data-toggle="tooltip" data-placement="right" title="Accéder aux congés des employés">OUTILLAGE</a>
                    </li>
                </ul>
            </nav>
            
            
            <div class="row ">
                <div class="col-md-2">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-12">
                          <a href="{{config('app.DOSSIER_PARC_AUTO_storage')."".$vehicule[0]->matricule."/".$vehicule[0]->image1}}" data-toggle="lightbox" data-title="Image Avant" data-gallery="gallery">
                            <img src="{{config('app.DOSSIER_PARC_AUTO_storage')."".$vehicule[0]->matricule."/".$vehicule[0]->image1}}" class="img-fluid mb-2" alt="Image Avant">
                          </a>
                        </div>
                        <div class="col-sm-12">
                          <a href="{{config('app.DOSSIER_PARC_AUTO_storage')."".$vehicule[0]->matricule."/".$vehicule[0]->image2}}" data-toggle="lightbox" data-title="Image Gauche" data-gallery="gallery">
                            <img src="{{config('app.DOSSIER_PARC_AUTO_storage')."".$vehicule[0]->matricule."/".$vehicule[0]->image2}}" alt="Image Gauche"  class="img-fluid mb-2">
                          </a>
                        </div>
                        <div class="col-sm-12">
                          <a href="{{config('app.DOSSIER_PARC_AUTO_storage')."".$vehicule[0]->matricule."/".$vehicule[0]->image3}}" data-toggle="lightbox" data-title="Image Arrière" data-gallery="gallery">
                            <img src="{{config('app.DOSSIER_PARC_AUTO_storage')."".$vehicule[0]->matricule."/".$vehicule[0]->image3}}" alt="Image Arrière" class="img-fluid mb-2" >
                          </a>
                        </div>
                        <div class="col-sm-12">
                          <a href="{{config('app.DOSSIER_PARC_AUTO_storage')."".$vehicule[0]->matricule."/".$vehicule[0]->image4}}" data-toggle="lightbox" data-title="Image Droite/Intérieur" data-gallery="gallery">
                            <img src="{{config('app.DOSSIER_PARC_AUTO_storage')."".$vehicule[0]->matricule."/".$vehicule[0]->image4}}" alt="Image Droite/Intérieur" class="img-fluid mb-2" >
                          </a>
                        </div>
                      </div>
                    </div>
                </div>

                <!--div class="col-md-2" >
                    
                        <img class="img-thumbnail" src="{{config('app.DOSSIER_PARC_AUTO_storage')."".$vehicule[0]->matricule."/".$vehicule[0]->image1}}" alt="Avant" style="height:150px; width:200px;">
                        </a>
                        
                        <img class="img-thumbnail"  src="{{config('app.DOSSIER_PARC_AUTO_storage')."".$vehicule[0]->matricule."/".$vehicule[0]->image2}}" alt="Gauche" style="height:150px; width:200px;">
                        </a>
                        
                        
                        <img class="img-thumbnail" src="{{config('app.DOSSIER_PARC_AUTO_storage')."".$vehicule[0]->matricule."/".$vehicule[0]->image3}}" alt="Arrière" style="height:150px; width:200px;">
                        </a>
                        
                        
                        <img class="img-thumbnail" src="{{config('app.DOSSIER_PARC_AUTO_storage')."".$vehicule[0]->matricule."/".$vehicule[0]->image4}}" alt="Droite/Intérieur" style="height:150px; width:200px;">
                        </a>                           
                </div-->
                <!-- /.col -->
                <div class="col-md-10">
                
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
    <!-- -->
    @yield('customjavascript')

    

@endsection
