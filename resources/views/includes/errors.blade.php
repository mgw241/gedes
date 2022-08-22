@if (Session::has('error'))
<!--script type="text/JavaScript" >
    var msg = "<?php echo Session::get('error'); ?>";
    document.addEventListener('DOMContentLoaded', function() {
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Erreur',
          subtitle: '',
          position: 'topRight',
          body: msg
        })
    }, false);          
</script-->

<script src="/frontend/popup1/toastr.js"></script>
<script src="/frontend/popup1/jquery-1.9.1.min.js"></script>
<script type="text/JavaScript" >
    document.addEventListener('DOMContentLoaded', function() {
        //alert("toastr.options");
        notificationError('{{Session::get('error')}}');
    }, false);          
</script>

{{Session::put('error', null)}}
@endif

@if (Session::has('warning'))
<!--script type="text/JavaScript" >
    var msg = "<?php echo Session::get('warning'); ?>";
    document.addEventListener('DOMContentLoaded', function() {
        $(document).Toasts('create', {
          class: 'bg-warning',
          title: 'Attention',
          subtitle: '',
          position: 'topRight',
          body: msg
        })
    }, false); 
</script-->

    <script src="/frontend/popup1/toastr.js"></script>
    <script src="/frontend/popup1/jquery-1.9.1.min.js"></script>
    <script type="text/JavaScript" >
        document.addEventListener('DOMContentLoaded', function() {
            //alert("toastr.options");
            notificationWarning('{{Session::get('warning')}}');
        }, false);          
    </script>

{{Session::put('warning', null)}}
@endif

@if (Session::has('success'))
    <script src="/frontend/popup1/toastr.js"></script>
    <script src="/frontend/popup1/jquery-1.9.1.min.js"></script>
    <script type="text/JavaScript" >
        document.addEventListener('DOMContentLoaded', function() {
            //alert("toastr.options");
            notificationSuccess('{{Session::get('success')}}');
        }, false);          
    </script>

{{Session::put('success', null)}}
@endif



@if (count($errors)> 0)
    {{$err = '';}}
    @foreach ($errors->all() as $error)
    @php
            $err = $err." ".$error;
        @endphp
    @endforeach

        @php 
            if(strcmp($err, ' The email has already been taken.') == 0 ){
				$err = "*** ERREUR [E000] : Cet email est déjà utilisé!                        *** SOLUTION : Changer d'adresse mail !";
            }
                //$err = "L'email est déjà utilisé";
        @endphp
    <!--script type="text/JavaScript" >
        var msg = "<?php echo $err; ?>";
        document.addEventListener('DOMContentLoaded', function() {
            $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Erreur',
            subtitle: '',
            position: 'topRight',
            body: msg
            })
        }, false);          
    </script-->


    <script src="/frontend/popup1/toastr.js"></script>
    <script src="/frontend/popup1/jquery-1.9.1.min.js"></script>
    <script type="text/JavaScript" >
        document.addEventListener('DOMContentLoaded', function() {
            //alert("toastr.options");
            notificationError("{{$err}}");
        }, false);          
    </script>
        @php
            $errors = [];
        @endphp
@endif