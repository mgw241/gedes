
@extends('client.apprh', ['titre' => 'Accueil'])
    
@section('contenu')
    
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Accueil</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Accueil</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
        <!-- Info boxes -->

         <!-- TACHES -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{$tacheTraiter}}</h3>
    
                    <p>Taches à traiter</p>
                    </div>
                    <div class="icon">
                    <i class="fas  fa-cog"></i>
                    </div>
                    <a href="/taches/taches/taches/traité" class="small-box-footer">Acceder <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="small-box bg-warning" style="color: white !important">
                    <div class="inner">
                    <h3>{{$tacheSuspendues}}</h3>
    
                    <p>Taches suspendues</p>
                    </div>
                    <div class="icon">
                    <i class="fas  fa-pause"></i>
                    </div>
                    <a href="/taches/taches/taches/Suspendu" class="small-box-footer" style="color: white !important">Acceder <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="small-box bg-success">
                    <div class="inner">
                    <h3>{{$tacheValide}}</h3>
    
                    <p>Tache validées</p>
                    </div>
                    <div class="icon">
                    <i class="fas  fa-check"></i><!--  fa-thumbs-up -->
                    </div>
                    <a href="/taches/taches/taches/Accordé" class="small-box-footer">Acceder <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                    <h3>{{$tacheRejete}}</h3>
    
                    <p>Taches rejetées</p>
                    </div>
                    <div class="icon">
                    <i class="fas  fa-times"></i>
                    </div>
                    <a href="/taches/taches/taches/Rejeté" class="small-box-footer">Acceder <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

         <!-- ACTIONS -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="small-box bg-warning" style="background-color: rgb(131, 192, 250) !important">
                    <div class="inner">
                    <h3>{{$actionAttente}}</h3>
    
                    <p>Actions initiées en attente</p>
                    </div>
                    <div class="icon">
                    <i class="fas  fa-cog""></i>
                    </div>
                    <a href="/taches/taches/actions/Attente" class="small-box-footer">Acceder <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="small-box bg-warning" style="background-color: rgb(253, 235, 134) !important">
                    <div class="inner">
                    <h3>{{$actionSuspendues}}</h3>
    
                    <p>Action suspendues</p>
                    </div>
                    <div class="icon">
                    <i class="fas  fa-pause"></i>
                    </div>
                    <a href="/taches/taches/actions/Suspendu" class="small-box-footer">Acceder <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="small-box bg-warning" style="background-color: rgb(114, 252, 109) !important">
                    <div class="inner">
                    <h3>{{$actionValide}}</h3>
    
                    <p>Actions initiées validées</p>
                    </div>
                    <div class="icon">
                    <i class="fas  fa-check"></i><!-- thumbs-up -->
                    </div>
                    <a href="/taches/taches/actions/Accordé" class="small-box-footer">Acceder <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="small-box bg-warning" style="background-color: rgb(238, 140, 116) !important">
                    <div class="inner">
                    <h3>{{$actionRejete}}</h3>
    
                    <p>Actions rejetées</p>
                    </div>
                    <div class="icon">
                    <i class="fas  fa-times"></i>
                    </div>
                    <a href="/taches/taches/actions/Rejeté" class="small-box-footer">Acceder <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>



            <!--div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text">Actions à traiter</span>
                    <span class="info-box-number">
                        13
                    </span>
                    </div>
                    <-- /.info-box-content ->
                </div>
                <-- /.info-box ->
            </div-->
            <!-- /.col -->
            <!--div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-pause"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text">Actions initiées en attente</span>
                    <span class="info-box-number">4</span>
                    </div>
                    <-- /.info-box-content ->
                </div>
                <-- /.info-box ->
            </div-->
            <!-- /.col -->

            <!-- fix for small devices only -->
            <!--div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-thumbs-up"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text">Actions initiées validées</span>
                    <span class="info-box-number">21</span>
                    </div>
                    <-- /.info-box-content ->
                </div>
            <-- /.info-box ->
            </div-->
            <!-- /.col -->
            <!--div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-comment"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text">Messages internes</span>
                    <span class="info-box-number">2</span>
                    </div>
                    <-- /.info-box-content ->
                </div>
            <-- /.info-box ->
            </div-->
            <!-- /.col -->




        </div>
        <!-- /.row -->

         <!-- MESSAGES -->
        <div class="row">
            
            <div class="col-12 col-sm-6 col-md-3">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>@php
                            $MessageTraiter = DB::select("SELECT COUNT(messages.id) as message FROM messages WHERE emp_getter = ? AND lecture = 0",[session()->get('user')->code_user] )[0]->message;
			if($MessageTraiter > 0 ){
				echo $MessageTraiter;
			}else{
                echo '0';
            }
                        @endphp</h3>
    
                    <p>Messages internes</p>
                    </div>
                    <div class="icon">
                    <i class="fas  fa-comment"></i>
                    </div>
                    <a href="/messagerie" class="small-box-footer">Acceder <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
    </div>

@endsection 


@section('customjavascript')
    <script language="javascript">
        setInterval(function(){
        window.location.reload(1);
        }, 30000);
    </script>
@endsection 