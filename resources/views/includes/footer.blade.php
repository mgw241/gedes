    <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
    <b>Version</b> 1.0
    </div>
    <strong>Copyright - STR Africa-Gabon</strong> &copy;  <script>document.write(new Date().getFullYear());</script>  Tous droits reservés.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <!-- jQuery -->
    <script src="/frontend/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/frontend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="/frontend/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/frontend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/frontend/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/frontend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/frontend/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/frontend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/frontend/plugins/jszip/jszip.min.js"></script>
    <script src="/frontend/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/frontend/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/frontend/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/frontend/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/frontend/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/frontend/dist/js/adminlte.min.js"></script>
    <!-- DATE SORTING -->
    <script src="/frontend/dist/js/date-eu.js" type="text/javascript"></script>
    <!-- Select2 -->
    <script src="/frontend/plugins/select2/js/select2.full.min.js"></script>

    <!-- bs-custom-file-input -->
    <script src="/frontend/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- BS-Stepper -->
    <script src="/frontend/plugins/bs-stepper/js/bs-stepper.min.js"></script>

    <!-- POPUP -->
    <!--    <script src="/frontend/popup1/jquery-1.9.1.min.js"></script> -->
    <script src="/frontend/popup1/toastr.js"></script>
    <!--script src="/frontend/popup1/toastr.js"></script-->
    <!--script src="/frontend/popup1/jquery-1.9.1.min.js"></script-->

    <script>
    /*    $(function () {
        $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        /*"columnDefs": [
            {
                "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 3 ],
                "visible": false
            }
        ]*/
    /*      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        });
    });
    */
    </script>






    <!----------------------------------------------------------------------->
    <!----------------    GALLERY  ----------------->
    <!----------------------------------------------------------------------->

    <!-- Ekko Lightbox -->
    <script src="/frontend/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <!-- Filterizr-->
    <script src="/frontend/plugins/filterizr/jquery.filterizr.min.js"></script>
    <!-- Page specific script -->
    <script>
        $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            //alert('top');
            event.preventDefault();
            $(this).ekkoLightbox({
            alwaysShowClose: true
            });
        });

        $('.filter-container').filterizr({gutterPixels: 3});
        $('.btn[data-filter]').on('click', function() {
            $('.btn[data-filter]').removeClass('active');
            $(this).addClass('active');
        });
        })
    </script>


    <!----------------------------------------------------------------------->
    <!----------------    INPUT FLE  ----------------->
    <!----------------------------------------------------------------------->
    <!-- Page specific script -->
    <script>
    $(function () {
        bsCustomFileInput.init();

    });
    </script>


    <!----------------------------------------------------------------------->
    <!----------------    TOAST  ----------------->
    <!----------------------------------------------------------------------->

    <!-- SweetAlert2 -->
    <script src="/frontend/plugins/sweetalert2/sweetalert2.min.js"></script>

    <script>
    $(function() {
        var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
        });

        function error(ver){

        }

        $('.toastsDefaultDanger').click(function() {
        $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Toast Title',
            subtitle: 'Subtitle',
            position: 'topRight',
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
        });
    });
    </script>


    <!----------------------------------------------------------------------->
    <!----------------    SELECT  ----------------->
    <!----------------------------------------------------------------------->

    <!-- Page specific script -->
    <script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        })
        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })

        $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

    })
    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function () {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
    }
    document.querySelector("#actions .cancel").onclick = function() {
        myDropzone.removeAllFiles(true)
    }
    // DropzoneJS Demo Code End
    </script>


    <!----------------------------------------------------------------------->
    <!----------------    TOAST POPUP1  ----------------->
    <!----------------------------------------------------------------------->

    <script>


    function notificationSuccess(message){
    //alert('t');
    var shortCutFunction = "success";//$("#toastTypeGroup input:radio:checked").val()  info,warning,error,success
    var msg = message;
    var title = "Information !";

    toastr.options = {      ///////////////     LES OPTIONS DU TOAST
        closeButton: true,
        debug: false,//   $('#debugInfo').prop('checked')
        newestOnTop: false, //  $('#newestOnTop').prop('checked')
        progressBar: false,  // $('#progressBar').prop('checked')
        rtl: false,  //  $('#rtl').prop('checked')
        positionClass: "toast-top-center", //   $('#positionGroup input:radio:checked').val() || 'toast-top-right'
        preventDuplicates: true,    //  $('#preventDuplicates').prop('checked'),
        onclick: null
    };

        toastr.options.showDuration = 300;
        toastr.options.hideDuration = 1000;
        toastr.options.timeOut = 5000; //   addClear ? 0 : 5000
        toastr.options.extendedTimeOut = 1000;   // addClear ? 0 : 1000
        toastr.options.showEasing = "swing";  //  swing, linear
        toastr.options.hideEasing = "swing";
        toastr.options.showMethod = "fadeIn";  // show, fadeIn, slideDown
        toastr.options.hideMethod = "fadeOut";  //  hide, fadeOut, slideUp

    $('#toastrOptions').text('Command: toastr["'
            + shortCutFunction
            + '"]("'
            + msg
            + (title ? '", "' + title : '')
            + '")\n\ntoastr.options = '
            + JSON.stringify(toastr.options, null, 2)
    );
    var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
    }


    function notificationError(message){
    //alert('t');
    var shortCutFunction = "error";//$("#toastTypeGroup input:radio:checked").val()  info,warning,error,success
    var msg = message;
    var title = "Erreur !";

    toastr.options = {      ///////////////     LES OPTIONS DU TOAST
        closeButton: true,
        debug: false,//   $('#debugInfo').prop('checked')
        newestOnTop: true, //  $('#newestOnTop').prop('checked')
        progressBar: false,  // $('#progressBar').prop('checked')
        rtl: false,  //  $('#rtl').prop('checked')
        positionClass: "toast-top-center", //   $('#positionGroup input:radio:checked').val() || 'toast-top-right'
        preventDuplicates: true,    //  $('#preventDuplicates').prop('checked'),
        onclick: false
    };

        toastr.options.tapToDismiss = false;
        toastr.options.timeOut = 0; //   addClear ? 0 : 5000
        toastr.options.extendedTimeOut = 0;   // addClear ? 0 : 1000
        toastr.options.showEasing = "swing";  //  swing, linear
        toastr.options.hideEasing = "swing";
        toastr.options.showMethod = "fadeIn";  // show, fadeIn, slideDown
        toastr.options.hideMethod = "fadeOut";  //  hide, fadeOut, slideUp
        //toastr.options.tapToDismiss = false;

    $('#toastrOptions').text('Command: toastr["'
            + shortCutFunction
            + '"]("'
            + msg
            + (title ? '", "' + title : '')
            + '")\n\ntoastr.options = '
            + JSON.stringify(toastr.options, null, 2)
    );
    var $toast = toastr[shortCutFunction](msg, title).css("width","100%").css("background-color","#ff655d").css("color","black"); // Wire up an event handler to a button in the toast, if it exists
    }


    function notificationWarning(message){
    //alert('t');
    var shortCutFunction = "warning";//$("#toastTypeGroup input:radio:checked").val()  info,warning,error,success
    var msg = message;
    var title = "Attention !";

    toastr.options = {      ///////////////     LES OPTIONS DU TOAST
        closeButton: true,
        debug: false,//   $('#debugInfo').prop('checked')
        newestOnTop: false, //  $('#newestOnTop').prop('checked')
        progressBar: false,  // $('#progressBar').prop('checked')
        rtl: false,  //  $('#rtl').prop('checked')
        positionClass: "toast-top-center", //   $('#positionGroup input:radio:checked').val() || 'toast-top-right'
        preventDuplicates: true,    //  $('#preventDuplicates').prop('checked'),
        onclick: null
    };

        toastr.options.showDuration = 300;
        toastr.options.hideDuration = 1000;
        toastr.options.timeOut = 5000; //   addClear ? 0 : 5000
        toastr.options.extendedTimeOut = 1000;   // addClear ? 0 : 1000
        toastr.options.showEasing = "swing";  //  swing, linear
        toastr.options.hideEasing = "swing";
        toastr.options.showMethod = "fadeIn";  // show, fadeIn, slideDown
        toastr.options.hideMethod = "fadeOut";  //  hide, fadeOut, slideUp

    $('#toastrOptions').text('Command: toastr["'
            + shortCutFunction
            + '"]("'
            + msg
            + (title ? '", "' + title : '')
            + '")\n\ntoastr.options = '
            + JSON.stringify(toastr.options, null, 2)
    );
    var $toast = toastr[shortCutFunction](msg, title).css("width","100%").css("color","black"); // Wire up an event handler to a button in the toast, if it exists
    }

    </script>

    <!----------------------------------------------------------------------->
    <!----------------    NOTIICATION TACHES  ----------------->
    <!----------------------------------------------------------------------->

<script>
    setInterval(function(){
        getNotification();
        getNotificationMessage();
        }, 5000);


        function getNotification(){

            //var notifA = document.getElementById(notifAction);
            $.ajax({
                type: "GET",
                url: '/getnotificationtache',
                dataType: "json",
                success:function(data){
                    //alert(data);
                    var nbrNotif = data;
                    if(nbrNotif > 0){
                        document.getElementById("notifAction").innerHTML=nbrNotif;
                    }
                },
            });
        }

        function getNotificationMessage(){
            var span = document.getElementById("notifMessage");
            alert(span.text());

        //var notifA = document.getElementById(notifAction);
        $.ajax({
            type: "GET",
            url: '/getnotificationmessage',
            dataType: "json",
            success:function(data){
                //alert(data);
                var nbrNotif = data;
                if(nbrNotif > 0){
                    document.getElementById("notifMessage").innerHTML=nbrNotif;
                    
                var audioElement = document.createElement('audio');
                audioElement.setAttribute('src', '/frontend/music/sound_msg.mp3');
                audioElement.setAttribute('autoplay', 'autoplay');
                audioElement.load();
                audioElement.play();
                
                }else{
                    document.getElementById("notifMessage").innerHTML="";
                }
            },
        });
        }

</script>