<nav class="main-header navbar navbar-expand navbar-white navbar-light" >
    <!-- Left navbar links ////// fixed-top -->
    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="/home" class="nav-link" data-toggle="tooltip" data-placement="right" title="Accéder à la page d'acceuil">Accueil</a>
    </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown" data-toggle="tooltip" data-placement="right" title="Notifications des taches à traiter ">
            <a class="nav-link" href="/taches/taches/taches/traité">
                <i class="far fa-bell fa-lg"></i>
                <span class="badge badge-warning navbar-badge notifAction" id="notifAction" style="font-size: .7em;">{{get_and_print_nbr_notification();}}</span>
            </a>
        </li>
        <li class="nav-item dropdown" data-toggle="tooltip" data-placement="right" title="Notifications des messages reçus ">
            <a class="nav-link" href="/messagerie">
                <i class="far fa-comments fa-lg"></i>
                <span class="badge badge-warning navbar-badge notifAction" id="notifMessage" style="font-size: .7em;">{{get_and_print_nbr_message();}}</span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" style="font-style: normal; font-weight:bold" >
                <i>{{session()->get('user')->nom}}</i>
            </a>

        </li>

        <!-- User Account: style can be found in dropdown.less -->
        <li class="nav dropdown user user-menu"  data-toggle="tooltip" data-placement="right" title="Mon profil. Cliquez!" >
            <a href="#" data-toggle="dropdown" class="nav-link">
                @if (session('user')->image == "no-user.jpg")
                    <img src="/storage/users/images/{{(session('user')->image)}}" class="user-image border" size="6rem" />
                @else
                    <img src="/storage/employes/{{session('user')->code_user}}/{{(session('user')->image)}}" class="user-image border" size="6rem" />
                @endif
            
            </a>
            <ul class="dropdown-menu" style="width: 50px;">
                <a class="dropdown-item" href="/profil"  data-toggle="tooltip" data-placement="right" title="Accedez à mon profil" ><i class="nav-icon fas fa-user"></i>&nbsp;&nbsp; Mon Compte </a>

                <a class="dropdown-item" href="/mes_abscences"  data-toggle="tooltip" data-placement="right" title="Accedez à mes abscences" ><i class="nav-icon fas fa-calendar"></i>&nbsp;&nbsp; Mes Absences </a>

                <a class="dropdown-item" href="/mes_conges"  data-toggle="tooltip" data-placement="right" title="Accedez à mes congés" ><i class="nav-icon fas fa-calendar-times"></i>&nbsp;&nbsp; Mes Congés </a>

                <a class="dropdown-item" href="/mes_missions"  data-toggle="tooltip" data-placement="right" title="Accedez à mes missions" ><i class="nav-icon fas fa-space-shuttle"></i>&nbsp;&nbsp; Mes Missions </a>
                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/logout"  data-toggle="tooltip" data-placement="right" title="Se déconnecter de l'application" ><i class="nav-icon fas fa-power-off text-danger"></i></i>&nbsp;&nbsp;Se déconnecter</a>
            </ul>
        </li>

        <li class="nav-item"  data-toggle="tooltip" data-placement="right" title="Mettre la fenêtre en plein écran" >
            <a class="nav-link" data-widget="fullscreen" href="#" role="button"  >
            <i class="fas fa-expand-arrows-alt"  ></i>
            </a>
        </li>
        
    </ul>
</nav>