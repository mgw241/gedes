
@extends('client.apprh', ['titre' => 'Configuration'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Configurations</h1>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <nav class="navbar navbar-expand navbar-secondary navbar-dark justify-content-center">
                <!-- Left navbar links -->
                <ul class="navbar-nav justify-content-center">
                    <!--li class="nav-item d-none d-sm-inline-block">
                        <a href="/configuration/configuration/civilite"   class='{{ (request()->is("configuration/configuration/civilite"))?"btn btn-dark":"nav-link"}}'>Civilité</a>
                    </li-->
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/configuration/configuration/" class='{{ (request()->is("configuration/configuration"))?"btn btn-dark":"nav-link"}}'>Direction</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/configuration/configuration/departement" class='{{ (request()->is("configuration/configuration/departement"))?"btn btn-dark":"nav-link"}}'>Département</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/configuration/configuration/service" class='{{ (request()->is("configuration/configuration/service"))?"btn btn-dark":"nav-link"}}'>Service</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/configuration/configuration/poste" class='{{ (request()->is("configuration/configuration/poste"))?"btn btn-dark":"nav-link"}}'>Poste</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/configuration/configuration/pays" class='{{ (request()->is("configuration/configuration/pays"))?"btn btn-dark":"nav-link"}}'>Pays</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/configuration/configuration/type_document" class='{{ (request()->is("configuration/configuration/type_document"))?"btn btn-dark":"nav-link"}}'>Type Documents</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/configuration/configuration/ville" class='{{ (request()->is("configuration/configuration/ville"))?"btn btn-dark":"nav-link"}}'>Ville</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/configuration/configuration/m_parc_auto" class='{{ (request()->is("configuration/configuration/m_parc_auto"))?"btn btn-dark":"nav-link"}}'>Moniteur Parc Auto</a>
                    </li>
                </ul>
            </nav>


            @yield('contenu2')

@endsection 

@section('customjavascript')
    <!-- Page specific script From Card Of Employe Details-->
    @yield('customjavascript')
    
@endsection