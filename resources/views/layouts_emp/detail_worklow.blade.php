@extends('client.apprh', ['titre' => 'Analyser Congé'])
    
@section('contenu')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Détail de la demande</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="/taches/taches/abscences">Taches & Actions</a></li>
                    <li class="breadcrumb-item active">{{$conge->id}}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <form action="" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informations</h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <h3></h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table tablePresentation" style="border: 0px">
                                        <tbody>
                                            <tr>
                                                <td>Nom :</td>
                                                <th>
                                                    {{$conge->nom_complet}}
                                                </tr>
                                            <tr>
                                                <td>Prenom :</td>
                                                <th>
                                                    {{$poste[0]->departement}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Direction :</td>
                                                <th>
                                                    {{$poste[0]->service}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Département :</td>
                                                <th>
                                                    {{date("d/m/Y", strtotime($conge->date_debut))}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Service :</td>
                                                <th>
                                                    {{date("d/m/Y", strtotime($conge->date_fin))}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Etat de la demande :</td>
                                                <th>
                                                    {{date("d/m/Y", strtotime($conge->date_fin))}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Commentaire :</td>
                                                <th>
                                                    
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Justificatif :</td>
                                                <th class="t_justificatif">
                                                    @if ($conge->fichier_justification != null)
                                                        <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$conge->code_emp}}/{{$conge->fichier_justification}}" target="_blank" class="lienPDF">
                                                            <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                                            <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                                        </a>
                                                    
                                                    @else
                                                        NON
                                                    @endif
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Motif:</td>
                                                <th>
                                                    {{$conge->motif}}
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table tablePresentation" style="border: 0px">
                                        <tbody>
                                            <tr>
                                                <td>Nombre de jours décomptés :</td>
                                                <th>
                                                    {{$nbrJpris[0]->nbrJpris}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Nombre de jours restants :</td>
                                                <th>
                                                    {{$congeAcquisEnCours[0]->congeAcquisEnCours}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Commentaire :</td>
                                                <th>
                                                    <textarea class="form-control"  name="commentaire" id="" cols="30" rows="9" placeholder="Entrer la raison de: Acceptation | Rejet | Suspension. De cette demande."></textarea>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                        <div class="card-footer">
                            <div class="row col-md-12">
                                <div class="col-md-3">
                                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Accepter la demande" class="btn btn-success">
                                        Accepter
                                    </button>
                                    <button type="submit" data-toggle="tooltip" data-placement="right" title="Suspendre la demande" class="btn btn-warning">
                                        Suspendre
                                    </button>
                                    <button type="submit" data-toggle="tooltip" data-placement="right" title="Rejeter la demande" class="btn btn-danger">
                                        Rejeter
                                    </button>
                                </div>
                                <div class="col-md-3 offset-md-6">
                                    <button type="submit" class="btn btn-primary">Enregistrer modificatons</button>
                                </div>
                            </div>
                            <!--h3 class="card-title">Détail de la demande d'abscence</h3-->
                        </div>
                    </div>
                </form>
        <!-- /.col -->
            </div>
        <!-- /.row -->
        </div>
    <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
