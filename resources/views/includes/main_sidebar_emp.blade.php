<aside class="main-sidebar sidebar-light-primary elevation-4" style="//background-color: brown">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
    <img src="/frontend/images/logo2.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-center font-weight-light" >GEDES</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" style="background-color: white">
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
            <li class="nav-item">
                <a href="/profil" class='{{ (request()->is("profil*"))?"nav-link active":"nav-link" }}'>
                <i class="nav-icon fas fa-user"></i>
                <p>
                    MON PROFIL
                </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/mes_abscences" class='{{ (request()->is("mes_abscences*"))?"nav-link active":"nav-link" }}'>
                <i class="nav-icon fas fa-calendar-times"></i>
                <p>
                    MES ABSCENCES
                </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/mes_conges" class='{{ (request()->is("mes_conges*"))?"nav-link active":"nav-link" }}'>
                <i class="nav-icon fas fa-calendar"></i>
                <p>
                    MES CONGES
                </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/mes_missions" class='{{ (request()->is("mes_missions*"))?"nav-link active":"nav-link" }}'>
                <i class="nav-icon fas fa-space-shuttle"></i>
                <p>
                    MES MISSIONS
                </p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>