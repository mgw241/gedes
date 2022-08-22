
@extends('client.apprh', ['titre' => 'Configuration-RH'])
    
@section('contenu')
    
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edition le Groupe</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Accueil</a></li>
                <li class="breadcrumb-item"><a href="/access/groupes">Groupes</a></li>
                <li class="breadcrumb-item active">Edition</li>
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

                    <form id="pForm" class="form-horizontal" method="POST">
                        @csrf
                    <div class="card">
                        <!-- card-header -->
                        <div class="card-header">
                            <h3 class="card-title">Les informations du groupe:</h3>
                        </div>
                        <!-- /.card-header -->

                        <!-- card-body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3 form-group row">
                                    <label for="exampleInputEmail1" class="col-sm-4 col-form-label">
                                        Nom :
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="libelle" id="libelle" value='{{$groupe->libelle}}'class="form-control" name="libelle">
                                        <input type="hidden" id="idG" name='id' value="{{$groupe->id}}">
                                    </div>
                                </div>
                                        
                                <div class="col-9">
                                    <table class="table table-bordered" id="Tpermissions">
                                        <thead>
                                        <tr>
                                            <th>Sections de l'application</th>
                                            <th>
                                                <input type="checkbox" name="Bread" id="Bread" style="width: 15px; height: 15px;">
                                                Lecture
                                            </th>
                                            <th>
                                                <input type="checkbox" name="Bread" id="Badd" style="width: 15px; height: 15px;">
                                                Ajout
                                            </th>
                                            <th>
                                                <input type="checkbox" name="Bedit" id="Bedit" style="width: 15px; height: 15px;">
                                                Modification
                                            </th>
                                            <th>
                                                <input type="checkbox" name="Bdelete" id="Bdelete" style="width: 15px; height: 15px;">
                                                
                                                Supression
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $permission)
                                            <tr>

                                                <td>
                                                    <input type="hidden" value="{{$permission->group_id.'@'.$permission->form_id}}"">
                                                    <span>
                                                        {{$permission->nom}}
                                                    </span>
                                                </td>
                                                <td>
                                                    @php
                                                        
                                                    @endphp
                                                    <input class="mesCheck" id="read" type="checkbox" name="{{$permission->group_id.'@'.$permission->form_id.'@read'}}" {{$permission->read ==1 ? "checked value='1'" : " value='0'"}}
                                                    style="width: 15px; height: 15px;">
                                                </td>
                                                <td>
                                                    @php
                                                        
                                                    @endphp
                                                    <input class="mesCheck"  id="add" type="checkbox" name="{{$permission->group_id.'@'.$permission->form_id.'@add'}}"
                                                    {{$permission->add ==1 ? "checked value='1'" : " value='0'"}}
                                                    style="width: 15px; height: 15px;">
                                                </td>
                                                <td>
                                                    <input class="mesCheck" id="edit" type="checkbox" name="{{$permission->group_id.'@'.$permission->form_id.'@edit'}}" 
                                                    {{$permission->edit ==1 ? "checked value='1'" : " value='0'"}}
                                                    style="width: 15px; height: 15px;">
                                                </td>
                                                <td>
                                                    <input class="mesCheck" id="delete" type="checkbox" name="{{$permission->group_id.'@'.$permission->form_id.'@delete'}}"  
                                                    {{$permission->delete ==1 ? "checked value='1'" : " value='0'"}}
                                                    style="width: 15px; height: 15px;">
                                                </td>
                                            </tr>
                                            @endforeach
                                            @foreach ($notpermissions as $notpermission)
                                            <tr>

                                                <td>
                                                    <input type="hidden" value="{{$groupe->id.'@'.$notpermission->id}}"">
                                                    <span>
                                                        {{$notpermission->nom}}
                                                    </span>
                                                </td>
                                                <td>
                                                    @php
                                                        
                                                    @endphp
                                                    <input class="mesCheck" id="read" type="checkbox" name="{{$groupe->id.'@'.$notpermission->id.'@read'}}" value='0' style="width: 15px; height: 15px;">
                                                </td>
                                                <td>
                                                    @php
                                                        
                                                    @endphp
                                                    <input class="mesCheck"  id="add" type="checkbox" name="{{$groupe->id.'@'.$notpermission->id.'@add'}}" value='0' style="width: 15px; height: 15px;">
                                                </td>
                                                <td>
                                                    <input class="mesCheck" id="edit" type="checkbox" name="{{$groupe->id.'@'.$notpermission->id.'@edit'}}" value='0' style="width: 15px; height: 15px;">
                                                </td>
                                                <td>
                                                    <input class="mesCheck" id="delete" type="checkbox" name="{{$groupe->id.'@'.$notpermission->id.'@delete'}}"  value='0' style="width: 15px; height: 15px;">
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <!-- card-footer -->
                        <div class="card-footer">
                            <div class="form-group row">
                                <div class="offset-sm-5 col-sm-7">
                                <button type="submit" id="bsubmit" class="btn btn-danger" >Valider</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->

                </form>
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

@section('customjavascript')
<!-- jQuery -->
<script src="/frontend/plugins/jquery/jquery.min.js"></script>
<script src="/frontend/plugins/jquery.json.min.js"></script>
<script type="text/javascript">
/*
    function validateForm() {
            //$.post('../php/insertMember.php', data);

            var TableData;
        TableData = $.toJSON(storeTblValues());
            $.ajax({
            type: "POST",
            url: '/access/groupes/saveeditgroup',
            data:{"maTable": TableData, },
        }).done(function( msg ) {
            alert( msg );
        });
    
    }
 */   
    </script>
<script type="text/javascript">
//method="post" action="{{'/access/groupes/saveeditgroup'}}"

$('#pForm').on('submit',function(e){
        e.preventDefault();

        var TableData;
        var libelle = document.getElementById('libelle').value;
        var id = document.getElementById('idG').value;
        TableData = $.toJSON(storeTblValues());
        var csrf = document.querySelector('meta[name="csrf-token"]').content;
         
        $.ajax({
            type: "POST",
            url: '/access/groupes/saveeditgroup',
            dataType: "json",
            "data":{
                "maTable": TableData,
                "libelle": libelle,
                "idG": id,
                "_token": "{{ csrf_token() }}",
                 },
        });
        setTimeout(function (){
        location.href ='/access/groupes';

        }, 1500); // How long do you want the delay to be (in milliseconds)? 


        /*$.ajax({
          url: "/access/groupes/saveeditgroup",
          type:"POST",
          dataType: "json",
          data:{
            "_token": "{{ csrf_token() }}",
            //'_token': csrf,
            "maTable": TableData,
          },
         });*/
        
        
        /*
        $.ajax({
        "type": "POST",
        "dataType": "json",
        "url": "/access/groupes/saveeditgroup",
        "dataType": "json",
        "contentType": 'application/json; charset=utf-8',
        data: { 'value': 'value', '_token': csrf, },
    });*/


        //$.post('/access/groupes/saveeditgroup', TableData);
        
        //alert(TableData);
});


function sendDataToForm(){
    var TableData;
    TableData = storeTblValues()
    TableData = $.toJSON(TableData);
    return TableData;
}


function storeTblValues()
{
    var TableData = new Array();

    $('#Tpermissions tr').each(function(row, tr){
        TableData[row]={
            "form" : $(tr).find('td:eq(0)> input').val()
            , "read" :$(tr).find('td:eq(1)> input').val()
            , "add" : $(tr).find('td:eq(2)> input').val()
            , "edit" : $(tr).find('td:eq(3)> input').val()
            , "delete" : $(tr).find('td:eq(4)> input').val()
        }    
    }); 
    TableData.shift();  // first row will be empty - so remove
    return TableData;
}



/*    function validateForm(){
        
        //alert(sendDataToForm());

        var TableData;
        TableData = $.toJSON(storeTblValues());
                        
        /*$.ajax({
            type: "POST",
            url: "/access/groupes/saveeditgroup",
            data: "maTable=" + TableData,
            success: function(msg){
                // return value stored in msg variable
            }
        });*/
/*
        $.post('/access/groupes/saveeditgroup', TableData);
    }
*/

    function getDataTale() {
        document.getElementById('info').innerHTML = "";
        var myTab = document.getElementById('empTable');

        // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
        for (i = 1; i < myTab.rows.length; i++) {

            // GET THE CELLS COLLECTION OF THE CURRENT ROW.
            var objCells = myTab.rows.item(i).cells;

            // LOOP THROUGH EACH CELL OF THE CURENT ROW TO READ CELL VALUES.
            for (var j = 0; j < objCells.length; j++) {
                info.innerHTML = info.innerHTML + ' ' + objCells.item(j).innerHTML;
            }
            info.innerHTML = info.innerHTML + '<br />';     // ADD A BREAK (TAG).
        }
    }



var nbr=0;
        $('.mesCheck').change(function(){
            if($(this).prop('checked')){
                    $(this).prop('value', '1');
                    if ($(this).attr('id') == 'read') {

                        var row = $(this).closest('tr');
                        //  add
                        row.find('#add').prop("disabled", false);
                        //  edit
                        row.find('#edit').prop("disabled", false);
                        //  delete
                        row.find('#delete').prop("disabled", false);
                    }
            }else{
                    $(this).prop('value', '0');
                    if ($(this).attr('id') == 'read') {
                        //alert($(this).attr('id'));
                        var row = $(this).closest('tr');
                        //  add
                        row.find('#add').prop('checked', false);
                        row.find('#add').prop('value', '0');
                        row.find('#add').prop("disabled", true);
                        //  edit
                        row.find('#edit').prop('checked', false);
                        row.find('#edit').prop('value', '0');
                        row.find('#edit').prop("disabled", true);
                        //  delete
                        row.find('#delete').prop('checked', false);
                        row.find('#delete').prop('value', '0');
                        row.find('#delete').prop("disabled", true);
                    }
            }
        });
//  CHECKBOX des TH
        $('#Bread').change(function(){
            if($(this).prop('checked')){
                $('tbody tr td input[id="read"] ').each(function(){
                    
                    $(this).prop('checked', true);
                    $(this).prop('value', '1');
                });

                if(nbr == 0){
                }else{
                    //  Les autres TD
                    $('tbody tr td input[id="add"]').each(function(){
                        $(this).prop('checked', false);
                        $(this).prop("disabled", false);
                    });

                    $('tbody tr td input[id="edit"]').each(function(){
                        $(this).prop('checked', false);
                        $(this).prop("disabled", false);
                    });

                    $('tbody tr td input[id="delete"]').each(function(){
                        $(this).prop('checked', false);
                        $(this).prop("disabled", false);
                    });
                    //  LES TH
                    $('#Badd').prop("disabled", false);
                    $('#Bedit').prop("disabled", false);
                    $('#Bdelete').prop("disabled", false);
                }
                nbr = nbr+1

            }else{
                $('tbody tr td input[id="read"]').each(function(){
                    $(this).prop('checked', false);
                    $(this).prop('value', '0');
                });
                

                //  Les autres TD
                $('tbody tr td input[id="add"]').each(function(){
                    $(this).prop('checked', false);
                    $(this).prop('value', '0');
                    $(this).prop("disabled", true);
                });

                $('tbody tr td input[id="edit"]').each(function(){
                    $(this).prop('checked', false);
                    $(this).prop('value', '0');
                    $(this).prop("disabled", true);
                });

                $('tbody tr td input[id="delete"]').each(function(){
                    $(this).prop('checked', false);
                    $(this).prop('value', '0');
                    $(this).prop("disabled", true);
                });

                //  LES TH
                var row = $(this).closest('tr');
                row.find('#Badd').prop('checked', false);
                row.find('#Badd').prop('value', '0');
                row.find('#Badd').prop("disabled", true);

                row.find('#Bedit').prop('checked', false);
                row.find('#Bedit').prop('value', '0');
                row.find('#Bedit').prop("disabled", true);

                row.find('#Bdelete').prop('checked', false);
                row.find('#Bdelete').prop('value', '0');
                row.find('#Bdelete').prop("disabled", true);
                /*
                $('#Badd').prop("disabled", true);
                $('#Bedit').prop("disabled", true);
                $('#Bdelete').prop("disabled", true);
                */
            }
        });

        $('#Badd').change(function(){
            if($(this).prop('checked')){
                $('tbody tr td input[id="add"] ').each(function(){
                    
                    $(this).prop('checked', true);
                    $(this).prop('value', '1');
                });
            }else{
                $('tbody tr td input[id="add"]').each(function(){
                    $(this).prop('checked', false);
                    $(this).prop('value', '0');
                });
            }
        });

        $('#Bedit').change(function(){
            if($(this).prop('checked')){
                $('tbody tr td input[id="edit"] ').each(function(){
                    
                    $(this).prop('checked', true);
                    $(this).prop('value', '1');
                });
            }else{
                $('tbody tr td input[id="edit"]').each(function(){
                    $(this).prop('checked', false);
                    $(this).prop('value', '0');
                });
            }
        });

        $('#Bdelete').change(function(){
            if($(this).prop('checked')){
                $('tbody tr td input[id="delete"] ').each(function(){
                    
                    $(this).prop('checked', true);
                    $(this).prop('value', '1');
                });
            }else{
                $('tbody tr td input[id="delete"]').each(function(){
                    $(this).prop('checked', false);
                    $(this).prop('value', '0');
                });
            }
        });

    </script>
@endsection