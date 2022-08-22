
@extends('client.apprh', ['titre' => 'Configuration-RH'])
    
@section('contenu')
       
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editer l'utilisateur</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                  <li class="breadcrumb-item active"><a href="/access/utilisateurs">Utlisateurs</a></li>
                  <li class="breadcrumb-item active">Voir</li>
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

                <div class="card">
                    <div class="card-header">
                        <a class="tabBtnEdit btn btn-outline-warning" value="$user->id"><i class="fas fa-edit"></i> Editer</a>
                    </div>
                <!-- /.card-header -->
                
                


                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection 
