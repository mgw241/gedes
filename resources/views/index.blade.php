<!DOCTYPE html>
<html lang="en">
<head>
	<title>Authentification | GEDES</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="/frontend/images/logo2.png"/>
<link rel="stylesheet" href="/frontend/loginf/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script src="/frontend/loginf/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="/frontend/loginf/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="/frontend/loginf/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="/frontend/plugins/fontawesome-free/css/all.min.css">
<style type="text/css">

	.button {
	  background-color: #4CAF50; /* Green */
	  border: none;
	  color: white;
	  padding: 15px 32px;
	  text-align: center;
	  text-decoration: none;
	  display: inline-block;
	  font-size: 16px;
	  margin: 4px 2px;
	  cursor: pointer;
	  border-radius: 5px;
	  float: right;
	}


	.btDaryl {
	  background-color: grey; 
	  /*color: black;*/
	  font-weight: bold;
	  /*border: 2px solid #4CAF50; /* Green */
	}
	.btDaryl:hover {
	  background-color: blue;
	  color: white;
	   font-weight: bold;
	}

	.textAuth{
		text-decoration-line: underline;text-decoration-style: solid;
	  text-decoration-thickness: 2px;
	}

	.contientForm{
		 border: 1px solid grey;
		border-radius: 30px;
		/*border-color:black;*/
		padding: none;
	}

	.centered {
    position: fixed;
    left: 50%;
    transform: translate(-50%, 0);
}


html, body {
    height: 100%;
}

/* CSS only for examples not required for centering */
.container {
    height: 80%;
	max-width: 90% !important;
}

.note {
    position: absolute;
    z-index: 10;
    right: 0;
    top: 0;
    padding: 5px;
    background: #eee;
    max-width: 360px;
    border: 1px dotted #bbb;
}

/* show border around full height container */
.h-100 {
    /*border: 1px dotted #cc2222;*/
}
</style>


</head>
<body style="background-color: #ffffff;">
	<!-- Navbar-->
<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container">
            <!-- Navbar Brand
            <a href="#" class="navbar-brand">
                <img src="https://res.cloudinary.com/mhmd/image/upload/v1571398888/Group_1514_tjekh3_zkts1c.svg" alt="logo" width="150">
            </a>
             -->
        </div>
    </nav>
</header>



<div class="container">
    <!--vertical align on parent using my-auto-->
    <div class="row h-100">
        <div class="col-sm-12 my-auto">
            <div class="row justify-content-center" >
		        <!-- For Demo Purpose -->
		        <div class="col-md-7 d-flex flex-wrap align-items-center" style="margin-right: 0px;">
		            <img src="/frontend/images/Gestion Electroniques des Données en environnement Sécuriré2.png" width="100%" height="80%">
		            <!--h1>Gestion des Documents Electroniques</h1>
		            <p class="font-italic text-muted mb-0">	yguyhytgyuhnygcyhcyghbhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh.
		            </p-->
		        </div>

		        <!-- Registeration Form -->
		        <div class="col-md-5">
		            <div class="contientForm">

		            	<form action="/se_loger" method="POST" class="align-items-center" style="margin: 10px;" >
							@csrf
		                	<div class="input-group align-items-center mb-3" style="margin-left: 15%;">
		                		<img src="/frontend/images/login.jpg" width="16%" >
		                		<span class="textAuth"><h2>Authentification</h2></span>
		                    </div>

						

							<!-- Eroor -->
		                    
		                        @if (Session::has('error'))
								<div class="text-justify" row" style="margin: 20px">
									<span class="" style="color: red; text-align: center">
									Email ou mot de passe incorrecte!
									</span>
								</div>


									{{Session::put('error', null)}}
								@endif

		                    <!-- Email 
								pattern="([a-z0-9._%+-])+[.]+([a-z0-9._%+-])+@<?PHP echo config('app.DOMAIN_FQDN');?>"
							-->
		                    <div class="form-group row">
		                        <label style="text-align: right" for="exampleInputEmail1" class="col-sm-4 col-form-label">Nom de connexion : </label>
		                        <div class="col-sm-8" >
		                        	<input type="email" class="form-control col-lg-12" id="exampleInputEmail1" name="email" data-validate="Entrez un email valide: ex@abc.xyz" placeholder="x.y@strafrica.com" pattern="([a-z0-9._%+-])+[.]+([a-z0-9._%+-])+@<?PHP echo config('app.DOMAIN_FQDN');?>"  required>
		                        </div>
		                    </div>

		                    <!-- Password -->
		                    <div class="form-group row">
		                        <label style="text-align: right" for="password" class="col-sm-4 col-form-label">Mot de passe : </label>
		                        <div class="col-sm-8 " id="show_hide_password">
									<div class="input-group ">
										<input type="password" name="password" class="form-control col-sm-12" id="password" placeholder="************" >
										<span class="input-group-append bg-white">
											<a href="" class="btn" style="border-color: lavender"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
										</span>
									</div>
		                        </div>
		                    </div>


		                    <!-- Submit Button -->
		                    <div class="form-group row">
		                        <div class="offset-sm-4 col-sm-8">
		                        <button type="submit" class="button btDaryl">Connexion</button>
		                        </div>
		                    </div>

		            	</form>
		            </div>
		        </div>
    		</div>
        </div>
    </div>
    
</div>

<div class="fixed-bottom align-items-center" style="background-color:white;">
	<p style="text-align: center;color: grey;font-size: 12px;">
		<img src="/frontend/images/STRAFRICA.png" width="40px">
		 <strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script> GEDES | Tous droits reservés | GEDES est un produit de STR AFRICA S.A</strong>     
	</p>
</div>



<script type="text/javascript">
</script>

<script type="text/javascript">
	$(document).ready(function() {
$("#show_hide_password a").on('click', function(event) {
	event.preventDefault();
	if($('#show_hide_password input').attr("type") == "text"){
		$('#show_hide_password input').attr('type', 'password');
		$('#show_hide_password i').addClass( "fa-eye-slash" );
		$('#show_hide_password i').removeClass( "fa-eye" );
	}else if($('#show_hide_password input').attr("type") == "password"){
		$('#show_hide_password input').attr('type', 'text');
		$('#show_hide_password i').removeClass( "fa-eye-slash" );
		$('#show_hide_password i').addClass( "fa-eye" );
	}
});
});
</script>
</body>
</html>