<aside class="main-sidebar sidebar-light-primary elevation-4" style="//background-color: brown" >
    <!-- Brand Logo jai mis light au lieu de dark -->
    <a href="/home" class="brand-link" data-toggle="tooltip" data-placement="right" title="Accéder à la page d'accueil">
    <img src="/frontend/images/logo2.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">GEDES</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar sidebar-light">

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Recherche" aria-label="Search"  style="background-color: white">
        <div class="input-group-append">
            <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
            </button>
        </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
            @if (is_readable_view("CONFIGURATION", "CONFIGURATION", session()->get('user')->id))
                <li class="nav-item">
                    <a href="/configuration/configuration/" class='{{ (request()->is("configuration/*"))?"nav-link active":"nav-link" }}'>
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>
                        CONFIGURATIONS
                    </p>
                    </a>
                </li>
            @endif
            
            @if (
                is_readable_view("Utilisateurs", "ACCESS", session()->get('user')->id)
            || is_readable_view("Groupes", "ACCESS", session()->get('user')->id))
                <li class=' {{ (request()->is("access/*"))?"nav-item menu-open":"nav-item" }}'>

                    <a href="#" class='{{ (request()->is("access*"))?"nav-link active":"nav-link" }} '>
                    <i class="nav-icon fas fa-universal-access"></i>
                    <p>
                        ACCES INTERFACE
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    @if (is_readable_view("Utilisateurs", "ACCESS", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/access/utilisateurs" class='{{ (request()->is("access/utilisateur*"))?"nav-link active":"nav-link" }}'>
                            <i class="fa fa-user nav-icon"></i>
                            <p>Utilisateurs</p>
                            </a>
                        </li>
                    @endif
                    @if (is_readable_view("Groupes", "ACCESS", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/access/groupes" class='{{ (request()->is("access/groupe*"))?"nav-link active":"nav-link" }}'>
                            <i class="fa fa-users nav-icon"></i>
                            <p>Groupes</p>
                            </a>
                        </li>
                    @endif
                    </ul>
                </li>
            @endif


            @if (
                is_readable_view("Employes", "RH", session()->get('user')->id)
                || is_readable_view("Abscences_conges", "RH", session()->get('user')->id)
                || is_readable_view("Missions", "RH", session()->get('user')->id)
            )
                <li class=' {{ (request()->is("rh/*"))?"nav-item menu-open":"nav-item" }}'>

                    <a href="#" class='{{ (request()->is("rh*"))?"nav-link active":"nav-link" }} '>
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        RESSOURCES HUMAINES
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    @if (is_readable_view("Employes", "RH", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/rh/employes" class='{{ (request()->is("rh/employes*"))?"nav-link active":"nav-link" }}'>
                            <i class="fa fa-male nav-icon"></i>
                            <p>Employés</p>
                            </a>
                        </li>
                    @endif
                    @if (is_readable_view("Abscences_conges", "RH", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/rh/abscences_conges/abscences" class='{{ (request()->is("rh/abscences_conges/*"))?"nav-link active":"nav-link" }}'>
                            <i class="far fa-calendar  nav-icon"></i>
                            <p>Abscences/Congés</p>
                            </a>
                        </li>
                    @endif
                    @if (is_readable_view("Missions", "RH", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/rh/missions" class='{{ (request()->is("rh/missions*"))?"nav-link active":"nav-link" }}'>
                            <i class="fa fa-space-shuttle nav-icon"></i>
                            <p>Missions</p>
                            </a>
                        </li>
                    @endif
                    </ul>
                </li>
            @endif


            @if (
                is_readable_view("Cartographie", "DOCUMENTAIRE", session()->get('user')->id)
                || is_readable_view("Procedures", "DOCUMENTAIRE", session()->get('user')->id)
                || is_readable_view("Archivage", "DOCUMENTAIRE", session()->get('user')->id)
            )
                <li class=' {{ (request()->is("documentaire/*"))?"nav-item menu-open":"nav-item" }}'>

                    <a href="#" class='{{ (request()->is("documentaire*"))?"nav-link active":"nav-link" }} '>
                    <i class="nav-icon fas fa-file"></i>
                    <p>
                        PROCESSUS/DOCUMENTAIRE
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    @if (is_readable_view("Cartographie", "DOCUMENTAIRE", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/documentaire/cartographie" class='{{ (request()->is("documentaire/cartographie*"))?"nav-link active":"nav-link" }}'>
                            <i class="fa fa-map nav-icon"></i>
                            <p>Cartographie</p>
                            </a>
                        </li>
                    @endif

                    @if (is_readable_view("Processus", "DOCUMENTAIRE", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/documentaire/processus" class='{{ (request()->is("documentaire/processus*"))?"nav-link active":"nav-link" }}'>
                            <i class="fa fa-step-forward nav-icon"></i>
                            <p>Processus</p>
                            </a>
                        </li>
                    @endif

                    @if (is_readable_view("Procedures", "DOCUMENTAIRE", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/documentaire/procedures" class='{{ (request()->is("documentaire/procedures*"))?"nav-link active":"nav-link" }}'>
                            <i class="fa fa-bullhorn nav-icon"></i>
                            <p>Procédures</p>
                            </a>
                        </li>
                    @endif

                    @if (is_readable_view("Enregistrements", "DOCUMENTAIRE", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/documentaire/enregistrements" class='{{ (request()->is("documentaire/enregistrements*"))?"nav-link active":"nav-link" }}'>
                            <i class="fa fa-download nav-icon"></i>
                            <p>Enregistrements</p>
                            </a>
                        </li>
                    @endif

                    @if (is_readable_view("Archivage", "DOCUMENTAIRE", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/documentaire/archivage" class='{{ (request()->is("documentaire/archivage*"))?"nav-link active":"nav-link" }}'>
                            <i class="fa fa-archive nav-icon"></i>
                            <p>Archivage</p>
                            </a>
                        </li>
                    @endif
                    </ul>
                </li>
            @endif

            @if (
                is_readable_view("Logistique", "LOGISTIQUE_SECURITE", session()->get('user')->id)
                || is_readable_view("Parc_Automobile", "LOGISTIQUE_SECURITE", session()->get('user')->id)
                || is_readable_view("Securite", "LOGISTIQUE_SECURITE", session()->get('user')->id)
            )
                <li class=' {{ (request()->is("logistique_securite/*"))?"nav-item menu-open":"nav-item" }}'>
                    <a href="#" class='{{ (request()->is("logistique*"))?"nav-link active":"nav-link" }} '>
                        <i class="nav-icon fas fa-dolly"></i>
                        <p>
                            LOGISTIQUE ET SÉCURITÉ
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                    @if (is_readable_view("Logistique", "LOGISTIQUE_SECURITE", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/logistique_securite/logistique" class='{{ (request()->is("logistique_securite/logistique*"))?"nav-link active":"nav-link" }}'>
                            <i class="fa fa-boxes nav-icon"></i>
                            <p>Logistique</p>
                            </a>
                        </li>
                    @endif

                    @if (is_readable_view("Parc_Automobile", "LOGISTIQUE_SECURITE", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/logistique_securite/parc_automobile" class='{{ (request()->is("logistique_securite/parc_automobile*"))?"nav-link active":"nav-link" }}'>
                            <i class="fa fa-car nav-icon"></i>
                            <p>Parc Automobile</p>
                            </a>
                        </li>
                    @endif

                    @if (is_readable_view("Securite", "LOGISTIQUE_SECURITE", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/logistique_securite/securite" class='{{ (request()->is("logistique_securite/securite*"))?"nav-link active":"nav-link" }}'>
                            <i class="fa fa-shield-alt nav-icon"></i>
                            <p>Sécurité</p>
                            </a>
                        </li>
                    @endif

                    </ul>
                </li>
            @endif

            @if (is_readable_view("TACHES", "TACHES", session()->get('user')->id))
                <li class="nav-item">
                    <a href="/taches/taches/taches/all" class='{{ (request()->is("taches*"))?"nav-link active":"nav-link" }}'>
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>
                        TACHES/ACTIONS
                    </p>
                    </a>
                </li>
            @endif

                <li class="nav-item">
                    <a href="/annuaire" class='{{ (request()->is("annuaire*"))?"nav-link active":"nav-link" }}'>
                    <i class="nav-icon fas fa-address-book"></i>
                    <p>
                        ANNUAIRE
                    </p>
                    </a>
                </li>

            @if (is_readable_view("MESSAGERIE", "MESSAGERIE", session()->get('user')->id))
                <li class="nav-item">
                    <a href="/messagerie" class='{{ (request()->is("messagerie*"))?"nav-link active":"nav-link" }}'>
                    <i class="nav-icon fas fa-comments"></i>
                    <p>
                        MESSAGERIE INTERNE
                    </p>
                    </a>
                </li>
            @endif

            @if (
                is_readable_view("Documentation", "INFORMATIONS", session()->get('user')->id)
                || is_readable_view("Apropos_gedes", "INFORMATIONS", session()->get('user')->id)
                || is_readable_view("Apropos_trafrica", "INFORMATIONS", session()->get('user')->id)
            )
                <li class=' {{ (request()->is("informations/*"))?"nav-item menu-open":"nav-item" }}'>

                    <a href="#" class='{{ (request()->is("informations*"))?"nav-link active":"nav-link" }} '>
                    <i class="nav-icon fas fa-info"></i>
                    <p>
                        INFORMATIONS
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    @if (is_readable_view("Documentation", "INFORMATIONS", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/informations/documentation" class='{{ (request()->is("informations/documentation*"))?"nav-link active":"nav-link" }}'>
                            <i class="fa fa-book-open nav-icon"></i>
                            <p>Documentation GEDES</p>
                            </a>
                        </li>
                    @endif

                    @if (is_readable_view("Apropos_gedes", "INFORMATIONS", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="/informations/apropos_gedes" class='{{ (request()->is("informations/apropos_gedes*"))?"nav-link active":"nav-link" }}'>
                                <!--img src="/frontend/images/logo2.png"  style="width:25.6px"/-->
                            <i class="fa fa-award nav-icon"></i>
                            <p>A propos de GEDES</p>
                            </a>
                        </li>
                    @endif

                    @if (is_readable_view("Apropos_trafrica", "INFORMATIONS", session()->get('user')->id))
                        <li class="nav-item">
                            <a href="http://strafrica.com/" target="_blank" class='{{ (request()->is("informations/apropos_strafrica*"))?"nav-link active":"nav-link" }}'>
                            <!--img src="/frontend/images/STRAFRICA.png"  style="width:25.6px"/-->
                            <i class="fa fa-sun nav-icon"></i>
                            <p>A propos de STR AFRICA</p>
                            </a>
                        </li>
                    @endif
                    </ul>
                </li>
            @endif

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>