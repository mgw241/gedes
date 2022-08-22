@extends('client.apprh', ['titre' => 'Analyser Abscences'])
    
@section('contenu')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Demande d'abscence</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="/taches/taches/taches/all">Taches</a></li>
                  <li class="breadcrumb-item active">Abscence</li>
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

                <form action="/taches/analyser/abscence/save" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Détail de la demande d'abscence</h3>
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
                                                    {{$abscence->nom_complet}}
                                                    <input type="hidden" name="id_workflow_log" value="{{$abscence->id_wl}}">
                                                </th>
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
                                                <td>Date d'abscence :</td>
                                                <th>
                                                    {{date("d/m/Y", strtotime($abscence->date_depart))}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Date de reprise :</td>
                                                <th>
                                                    {{date("d/m/Y", strtotime($abscence->date_reprise))}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Nombre de jour demandé :</td>
                                                <th>
                                                    {{$abscence->nbrJ_demande}} jour(s)
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Justificatif:</td>
                                                <th>
                                                    @if ($abscence->justifier == 0 )
                                                        AUCUN
                                                    @endif
                                                    @if ($abscence->justifier == 1 )
                                                        <a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$abscence->code_emp}}/{{$abscence->fichier_justification}}" target="_blank" class="lienPDF">
                                                            <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                                            <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                                        </a>
                                                    @endif
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Motif:</td>
                                                <th>
                                                    {{$abscence->motif}}
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table tablePresentation" style="border: 0px">
                                        <tbody>
                                            <tr>
                                                <td>Nombre de jour accordé :</td>
                                                <th>
                                                    <input class="form-control"  type="number" name="nbrJ_accode" id="" value="{{$abscence->nbrJ_accord}}" max="{{$abscence->nbrJ_demande}}" min="1" {{ Session('permission')[0]->edit =="0" ? "disabled":""}}>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Nombre de jour sans solde :</td>
                                                <th>
                                                    <input class="form-control"  type="number" name="nbrJ_ssolde" id="" value="{{$abscence->nbrJ_accord_ssolde}}" max="{{$abscence->nbrJ_demande}}" {{ Session('permission')[0]->edit =="0" ? "disabled":""}}>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Commentaire :</td>
                                                <th>
                                                    <textarea class="form-control"  name="commentaire" id="" cols="30" rows="9" placeholder="Entrer la raison de: Acceptation | Rejet | Suspension. De cette demande.">{{$abscence->workflow_statut == 1 ? $abscence->commentairem : ''}}</textarea>
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
                                @if ($abscence->decision == 2)
                                    <div class="col-md-3">
                                        <button type="submit" data-toggle="tooltip" data-placement="top" title="Accepter la demande" class="btn btn-success" name="accepter" value="accepter" onclick="return confirm('Cette action est irréversible. Voulez-vous vraiment accepter la demande ? ')">
                                            Accepter
                                        </button>
                                        <button type="submit" data-toggle="tooltip" data-placement="right" title="Suspendre la demande" class="btn btn-warning" name="suspendre" value="suspendre"  >
                                            Suspendre
                                        </button>
                                        <button type="submit" data-toggle="tooltip" data-placement="right" title="Rejeter la demande" class="btn btn-danger" name="rejeter" value="rejeter" onclick="return confirm('Cette action est irréversible. Voulez-vous vraiment rejeter la demande ? ')">
                                            Rejeter
                                        </button>
                                    </div>
                                    <!--div class="col-md-3 offset-md-6">
                                        <button type="submit" data-toggle="tooltip" data-placement="right" title="Enregstrer les modiications" class="btn btn-primary" {{ Session('permission')[0]->edit =="0" ? "disabled":""}} name="enregistrer" value="enregistrer">Enregistrer modificatons</button>
                                    </div-->
                                @elseif($abscence->decision == 5)
                                <div class="col-md-3">
                                    <button type="submit" data-toggle="tooltip" data-placement="right" title="Réactiver la demande suspendue" class="btn btn-warning" name="reactiver" value="reactiver">
                                        Réactiver
                                    </button>
                                </div>
                                @else
                                    <td class="t_decision">
                                        {{show_statut_taches($abscence->decision)}}
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


    <!-- Modal  SOUMMETTRE-->
    <div id="myModal" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titreDelete" >Voulez-vous vraiment soumettre? </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-footer">
                    <input class="form-control" type="hidden" id="idModalDelete" name="idModal">
                    <input class="btn btn-success" type="submit" value="OUI" >
                    <button type="button" class="btn btn-default" data-dismiss="modal">NON</button>
                </div>
            </div>

        </div>
    </div>
  <!-- Modal -->
@endsection
