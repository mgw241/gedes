<div class="row">
  <div class="col-12">

      <div class="card">
          <div class="card-header">
              <div class="row">
                  <div class="col-md-6">
                      <button type="submit" class="btn btn-app bg-success tabBtnAddConge" data-toggle="modal" {{ Session('permission')[0]->add =='0'?'disabled':''}}>
                          <i class="fas fa-calendar"></i> Ajouter Congés
                      </button>
                  </div>
                  <div class="col-md-6">
                      <h2 style="color: darkred">Congés</h2>
                  </div>
              </div>
              
          </div>
      <!-- /.card-header -->
      <div class="card-body">
          <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
          <thead>
          <tr>
              <th>Matricule</th>
              <th>Nom & Prenom</th>
              <th>Poste</th>
              <th>Date de début</th>
              <th>Date de fin</th>
              <th>Motif</th>
              <th>Intérime</th>
              <!--th>Action</th-->
          </tr>
          </thead>
          <tbody>
                  <tr>
                      <td class="t_matricule">
                          ghjk
                      </td>

                      <td class="t_Nom">
                          
                      </td>

                      <td class="t_Prenom">
                      </td>

                      <td class="t_poste">
                      </td>

                      <td class="t_departement">
                      </td>

                      <td class="t_numero">
                      </td>

                      <td class="t_email">
                      </td>

                      <!--td>
                          @if (Session('permission')[0]->edit == '1')
                              <a class="tabBtnEdit" href="/access/groupes/edit_group/" ><i class="fas fa-lg fa-edit "></i> </a>
                          @endif
                          
                          @if (Session('permission')[0]->delete == '1')
                          <a class="tabBtnDelete" id="" data-toggle="modal"><i class="fas fa-lg fa-trash"></i> </a>
                          @endif
                      </td-->

                  </tr>
                  
          </tbody>
          </table>
      </div>
      <!-- /.card-body -->
      </div>
      <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->




<div class="container-fluid">
  <div class="row">
  <div class="col-12">

      <div class="card">
          <div class="card-header">

              <div class="row">
                  <div class="col-md-6">
                      <form action="/rh/employes/add" method="POST">
                          @csrf
                          <button type="submit" class="btn btn-app bg-success tabBtnAdd" data-toggle="modal" {{ Session('permission')[0]->add =='0'?'disabled':''}}>
                              <i class="fas fa-calendar-times"></i> Ajouter Absceces
                          </button>
                      </form>
                  </div>
                  <div class="col-md-6">
                      <h2 style="color: darkred">Abscences</h2>
                  </div>
              </div>
              
          </div>
      <!-- /.card-header -->
      <div class="card-body">
          <table id="example1" class="table table-bordered table-hover dataTable dtr-inline collapsed">
          <thead>
          <tr>
              <th>Matricule</th>
              <th>Nom & Prenom</th>
              <th>Poste</th>
              <th>Date</th>
              <!--th>Action</th-->
          </tr>
          </thead>
          <tbody>
                  <tr>
                      <td class="t_matricule">
                          ghjk
                      </td>

                      <td class="t_Nom">
                          
                      </td>

                      <td class="t_Prenom">
                      </td>

                      <!--td>
                          @if (Session('permission')[0]->edit == '1')
                              <a class="tabBtnEdit" href="/access/groupes/edit_group/" ><i class="fas fa-lg fa-edit "></i> </a>
                          @endif
                          
                          @if (Session('permission')[0]->delete == '1')
                          <a class="tabBtnDelete" id="" data-toggle="modal"><i class="fas fa-lg fa-trash"></i> </a>
                          @endif
                      </td-->

                  </tr>
                  
          </tbody>
          </table>
      </div>
      <!-- /.card-body -->
      </div>
      <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->
