@extends('client.apprh', ['titre' => 'Analyser Congé'])
    
@section('contenu')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Demande de congé</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="/taches/taches/taches/all">Taches</a></li>
                    <li class="breadcrumb-item active">Congé</li>
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

                <form action="/taches/analyser/conge/save" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Détail de la demande de congé</h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <h3></h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table tablePresentation" style="border: 0px">
                                        <tbody>
                                            <tr>
                                                <td>Nom Complet de l'employé :</td>
                                                <th>
                                                    {{$conge->nom_complet}}
                                                    <input type="hidden" name="id_workflow_log" value="{{$conge->id_wl}}">
                                                </tr>
                                            <tr>
                                                <td>Département :</td>
                                                <th>
                                                    {{$poste[0]->departement}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Service :</td>
                                                <th>
                                                    {{$poste[0]->service}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Date de début congé :</td>
                                                <th>
                                                    {{date("d/m/Y", strtotime($conge->date_debut))}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Date de reprise :</td>
                                                <th>
                                                    {{date("d/m/Y", strtotime($conge->date_fin))}}
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
                                                    {{$congeAcquisEnCours[0]->congeAcquisEnCours - $nbrJpris[0]->nbrJpris}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Commentaire :</td>
                                                <th>
                                                    <textarea class="form-control"  name="commentaire" id="" cols="30" rows="9" placeholder="Entrer la raison de: Acceptation | Rejet | Suspension. De cette demande.">{{$conge->workflow_statut == 1 ? $conge->commentairem : ''}}</textarea>
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
                                @if ($conge->decision == 2)
                                    <div class="col-md-3">
                                        <button type="submit" data-toggle="tooltip" data-placement="top" title="Accepter la demande" class="btn btn-success" name="accepter" value="accepter" onclick="return confirm('Voulez-vous vraiment accepter? Cette action est irréversible')">
                                            Accepter
                                        </button>
                                        <button type="submit" data-toggle="tooltip" data-placement="right" title="Suspendre la demande" class="btn btn-warning" name="suspendre" value="suspendre"  >
                                            Suspendre
                                        </button>
                                        <button type="submit" data-toggle="tooltip" data-placement="right" title="Rejeter la demande" class="btn btn-danger" name="rejeter" value="rejeter" onclick="return confirm('Voulez-vous vraiment rejeter? Cette action est irréversible')">
                                            Rejeter
                                        </button>
                                    </div>
                                @elseif($conge->decision == 5)
                                    <div class="col-md-3">
                                        <button type="submit" data-toggle="tooltip" data-placement="right" title="Réactiver la demande suspendue" class="btn btn-warning" name="reactiver" value="reactiver">
                                            Réactiver
                                        </button>
                                    </div>
                                @else
                                    <td class="t_decision">
                                        {{show_statut_taches($conge->decision)}}
                                    </td>
                                @endif
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
