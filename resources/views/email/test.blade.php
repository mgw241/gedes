<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body style="background: #ffffff; padding: 30px;" >

<div style="max-width: 320px; margin: 0 auto; padding: 20px; background: #fff;">
	<!--h3>Notification :</h3-->
	<div>
          
        @if (isset($data['message']))
            {{$data['message']}}
        @else
            Une nouvelle tache vous a été attribuée dans l'Intranet GEDES.
        @endif
    </div>
    <div>
        <a href="http://10.10.5.87:8000"> Acceder à GEDES</a>
    </div>
</div>

</body>
</html>