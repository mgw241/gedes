@extends('client.employes_show_emp')

@section('contenu2')
<div class="card">
    <!--div class="card-header p-2">
        <h3>Généralité</h3>
    </div><-- /.card-header -->
    <div class="card-body">
        <h3>GÉNERALITÉS</h3>
        <div class="row">
            <div class="col-md-6">
                <table class="table tablePresentation" style="border: 0px">
                    <tbody>
                        <tr>
                            <td>Nom :</td>
                            <th>{{$employes[0]->nom}}</th>
                        </tr>
                        <tr>
                            <td>Prenom :</td>
                            <th>{{$employes[0]->prenom}}</th>
                        </tr>
                        <tr>
                            <td>Sexe :</td>
                            <th>{{$employes[0]->genre}}</th>
                        </tr>
                        <tr>
                            <td>Date de naissance :</td>
                            <th>{{date("d/m/Y", strtotime($employes[0]->date_naiss))}}</th>
                        </tr>
                        <tr>
                            <td>Nationaité :</td>
                            <th>{{$employes[0]->nationalite}}</th>
                        </tr>
                        <tr>
                            <td>Statut matrimonial :</td>
                            <th>{{$employes[0]->etat_matrimonial}}</th>
                        </tr>
                        <tr>
                            <td>Téléphone de Bureau :</td>
                            <th>{{$employes[0]->telephone_travail}}</th>
                        </tr>
                        <tr>
                            <td>Téléphone Personnel :</td>
                            <th>{{$employes[0]->telephone1}}</th>
                        </tr>
                        <tr>
                            <td>Email :</td>
                            <th>{{$employes[0]->email}}</th>
                        </tr>
                        <tr>
                            <td>Permis de conduire :</td>
                            <th>
                                @if ($permiss == null)
                                    -
                                @endif
                                @foreach ($permiss as $permis)
                                | {{$permis->type}}
                                @endforeach
                               
                            </th>
                        </tr>
                        <tr>
                            <td>Pièce d'identité :</td>
                            <th><a href="/storage/employes/{{$employes[0]->code}}/{{$employes[0]->piece}}" target="_blank" class="lienPDF">
                                <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                 {{$employes[0]->piece}}
                            </a></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table tablePresentation" style="border: 0px">
                    <tbody>
                        <tr>
                            <td>Curriculum Vitae :</td>
                            <th><a href="{{config('app.DOSSIER_EMPLOYES_storage')}}{{$employes[0]->code}}/{{$employes[0]->cv}}" target="_blank" class="lienPDF">
                                <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                 {{$employes[0]->cv}}
                            </a></th>
                        </tr>
                        <tr>
                            <td>Etat d'activité :</td>
                            @if ($employes[0]->etat_activite == 'actif')
                                <th style="color: green">{{$employes[0]->etat_activite}}</th>   
                            @elseif($employes[0]->etat_activite == 'congés')
                                <th style="color: blue">{{$employes[0]->etat_activite}}</th> 
                            @else
                                <th style="color: red">{{$employes[0]->etat_activite}}</th>
                            @endif
                            
                        </tr>
                        
                        <tr>
                            <td>Type de contrat :</td>
                            <th>
                                {{$employes[0]->type_contrat}}
                            </a></th>
                        </tr>
                        <tr>
                            <td>Fichier contrat :</td>
                            <th>
                                <a href="/storage/employes/{{$employes[0]->code}}/{{$employes[0]->contrat}}" target="_blank" class="lienPDF">
                                <!--i class="nav-icon fas fa-file-pdf" ></i-->
                                <img class="imgPDF" src="/frontend/images/PDF_file_icon.svg" alt="">
                                 {{$employes[0]->contrat}}
                            </a></th>
                        </tr>
                        <tr>
                            <td>Date d'entrée :</td>
                            <th>{{date("d/m/Y", strtotime($employes[0]->date_debut))}}</th>
                        </tr>
                        <tr>
                            <td>Date de départ :</td>
                            <th>
                                {{
                                    $employes[0]->date_depart == null ? 'Contrat en cours' : date("d/m/Y", strtotime($employes[0]->date_depart))
                                    }}
                            </th>
                        </tr>
                        <tr>
                            <td>Ancienneté :</td>
                            <th>{{$employes[0]->anciennete}}</th>
                        </tr>
                        <tr>
                            <td>Motif départ :</td>
                            <th>
                                @if ($employes[0]->motif_depart == null)
                                    -
                                @endif
                                {{$employes[0]->motif_depart}}
                            </th>
                        </tr>
                        <!---tr>
                            <td>Logement société :</td>
                            <th>{{$employes[0]->logementL}}</th>
                        </tr-->
                        <tr>
                            <td>Adresse :</td>
                            <th>{{$employes[0]->adresse}}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        
    </div><!-- /.card-body -->
</div>
@endsection
