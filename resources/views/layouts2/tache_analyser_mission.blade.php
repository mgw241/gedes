@extends('client.apprh', ['titre' => 'Analyser Mission'])
    
@section('contenu')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Demande de mission</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="/taches/taches/taches/all">Taches</a></li>
                    <li class="breadcrumb-item active">Mission</li>
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

                <form action="/taches/analyser/mission/save" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Détail de la demande de mission</h3>
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
                                                    {{$missions->nom_complet}}
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
                                                <td>Date de départ :</td>
                                                <th>
                                                    {{date("d/m/Y", strtotime($missions->date_debut))}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Date de retour :</td>
                                                <th>
                                                    {{date("d/m/Y", strtotime($missions->date_retour))}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Objet de la mission :</td>
                                                <th>
                                                    {{$missions->objet}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Pays de la mission :</td>
                                                <th>
                                                    {{$missions->pays}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Ville de la mission :</td>
                                                <th>
                                                    {{$missions->ville}}
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table tablePresentation" style="border: 0px">
                                        <tbody>
                                            <tr>
                                                <td>Nombre de jours Repas :</td>
                                                <th>
                                                    <input type="hidden" name="id_workflow_log" value="{{$missions->id_wl}}">
                                                    <input class="form-control" type="number"  name="repas" id="" required value="{{$missions->nbrj_repas}}" {{ Session('permission')[0]->edit =="0" ? "disabled":""}}>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Nombre de jours Hébergement :</td>
                                                <th>
                                                    <input class="form-control" type="number"  name="hebergement" required id="" value="{{$missions->nbrj_hebergement}}" {{ Session('permission')[0]->edit =="0" ? "disabled":""}}>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Transport :</td>
                                                <th>
                                                    <!--input class="form-control" type="text"  name="transport" id="" value="{{$missions->transport}}" {{ Session('permission')[0]->add =="0" ? "disabled":""}}-->
                                                    <select name="transport" id="" class="form-control select2">
                                                        @foreach (StaticArray::$transport as $item)
                                                            <option value="{{$item["moyen"]}}" {{$item["moyen"]==$missions->transport ? 'selected' : ''}}>{{$item["moyen"]}} </option>
                                                        @endforeach
                                                    </select>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Nombre de jours Téléphone :</td>
                                                <th>
                                                    <input class="form-control" type="number"  name="telephone" required id="" value="{{$missions->nbrj_telephone}}" {{ Session('permission')[0]->edit =="0" ? "disabled":""}} >
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Nombre de jours HTM/MOT :</td>
                                                <th>
                                                    <input class="form-control" type="number"  name="mot" id="" required value="{{$missions->nbrj_mot}}" {{ Session('permission')[0]->edit =="0" ? "disabled":""}}>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Nombre de jours Aléas & autre :</td>
                                                <th>
                                                    <input class="form-control" type="number" name="autre" id="" required value="{{$missions->nbrj_autre}}" {{ Session('permission')[0]->edit =="0" ? "disabled":""}}>
                                                </th>
                                                <tr>
                                                    <td>Commentaire :</td>
                                                    <th>
                                                        <textarea class="form-control"  name="commentaire" id="" cols="30" rows="2" placeholder="Entrer la raison de: Acceptation | Rejet | Suspension. De cette demande.">{{$missions->workflow_statut == 1 ? $missions->commentairem : ''}}
                                                        </textarea>
                                                    </th>
                                                </tr>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                        <div class="card-footer">
                            <div class="row col-md-12">
                                @if ($missions->decision == 2)
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
                                    <!--div class="col-md-3 offset-md-6">
                                        <button type="submit" data-toggle="tooltip" data-placement="right" title="Enregstrer les modiications" class="btn btn-primary" {{ Session('permission')[0]->edit =="0" ? "disabled":""}} name="enregistrer" value="enregistrer">Enregistrer modificatons</button>
                                    </div-->
                                @elseif($missions->decision == 5)
                                    <div class="col-md-3">
                                        <button type="submit" data-toggle="tooltip" data-placement="right" title="Réactiver la demande suspendue" class="btn btn-warning" name="reactiver" value="reactiver">
                                            Réactiver
                                        </button>
                                    </div>
                                @else
                                    <td class="t_decision">
                                        {{show_statut_taches($missions->decision)}}
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
