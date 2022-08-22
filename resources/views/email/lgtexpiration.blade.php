<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style>
table, th, td {
  border: 1px solid white;
  border-collapse: collapse;
}
th, td {
  background-color: #96D4D4;
  /*border-style: dotted;*/
}
</style>
</head>
<body style="background: #ffffff;" >

<div style="background: #fff;">
	<!--h3>Notification :</h3-->

    @if ( count($vidanges) > 0 )
        <div>
            <h1 style="text-align: center">VIDANGE</h1>
            <p>
                <table style="width: 80%;margin-left: 10%;">
                    <thead style="font-weight: bold">
                        <td>Matricule</td>
                        <td>Nom</td>
                        <td>Kilometrage Actuel</td>
                        <td>Kilometrage Expiration</td>
                        <td>Expire dans (Kilomètre)</td>
                        <td>Criticité</td>
                        <td>Consulter</td>
                    </thead>
                    <tbody>
                        @foreach ($vidanges as $vidange)
                            <tr>
                                <td>{{$vidange->matricule}}</td>
                                <td>{{$vidange->nom}}</td>
                                <td>{{$vidange->km_actuel}}</td>
                                <td>{{$vidange->km_restant_pour_expirer+$vidange->km_actuel}}</td>
                                <td>{{$vidange->km_restant_pour_expirer}}</td>
                                <td style="background-color: black">
                                    @if ( $vidange->km_restant_pour_expirer <= $vidange->km_alerte2 )
                                        <span style="color: red">CRITIQUE</span>
                                    @else
                                        <span style="color: orange">BIENTOT</span>
                                    @endif
                                </td>
                                <td><a href="{{config("app.SERVER_URL")}}/logistique_securite/parc_automobile/{{$vidange->matricule}}/vidange">ouvrir</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </p>
        </div>
    @endif

    <br/>

    @if ( count($extincteurs) > 0 )
        <div>
            <h1 style="text-align: center">EXTINCTEUR</h1>
            <p>
                <table style="width: 80%;margin-left: 10%;">
                    <thead style="font-weight: bold">
                        <td>Matricule</td>
                        <td>Nom</td>
                        <td>Date Expiration</td>
                        <td>Jour restant</td>
                        <td>Criticité</td>
                        <td>Consulter</td>
                    </thead>
                    <tbody>
                        @foreach ($extincteurs as $extincteur)
                            <tr>
                                <td>{{$extincteur->matricule}}</td>
                                <td>{{$extincteur->nom}}</td>
                                <td>{{date("d/m/Y", strtotime($extincteur->expiration))}}</td>
                                <td>{{$extincteur->j_restant}}</td>
                                <td style="background-color: black">
                                    @if ( $extincteur->j_restant <= config("app.LGT_alert2") )
                                        <span style="color: red">CRITIQUE</span>
                                    @else
                                        <span style="color: orange">BIENTOT</span>
                                    @endif
                                </td>
                                <td><a href="{{config("app.SERVER_URL")}}/logistique_securite/parc_automobile/{{$extincteur->matricule}}/extincteur">ouvrir</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </p>
        </div>
    @endif

    <br/>

    @if ( count($viste_techniques) > 0 )
        <div>
            <h1 style="text-align: center">VISITE TECHNIQUE</h1>
            <p>
                <table style="width: 80%;margin-left: 10%;">
                    <thead style="font-weight: bold">
                        <td>Matricule</td>
                        <td>Nom</td>
                        <td>Expire dans (Jour)</td>
                        <td>Criticité</td>
                        <td>Consulter</td>
                    </thead>
                    <tbody>
                        @foreach ($viste_techniques as $viste_technique)
                        <tr>
                            <td>{{$viste_technique->matricule}}</td>
                            <td>{{$viste_technique->nom}}</td>
                            <td>{{$viste_technique->nbrj_expiration}}</td>
                            <td style="background-color: black">
                                @if ( $viste_technique->nbrj_expiration <= config("app.LGT_alert2") )
                                    <span style="color: red">CRITIQUE</span>
                                @else
                                    <span style="color: orange">BIENTOT</span>
                                @endif
                            </td>
                            <td><a href="{{config("app.SERVER_URL")}}/logistique_securite/parc_automobile/{{$viste_technique->matricule}}/visite_technique">ouvrir</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </p>
        </div>
    @endif
    


    <div>
        <!--a href="http://10.10.5.87:8000"> Acceder à GEDES</a-->
    </div>
</div>

</body>
</html>