

<!-- bs-custom-file-input -->
<script src="/frontend/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
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
<!-- SweetAlert2 -->
<script src="/frontend/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Select2 -->
<script src="/frontend/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="/frontend/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- BS-Stepper -->
<script src="/frontend/plugins/bs-stepper/js/bs-stepper.min.js"></script>

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
  <!----------------    DATATABLE  ----------------->
<!----------------------------------------------------------------------->

<script>
$(function () {
    $("#example1").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
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
</script>


<!----------------------------------------------------------------------->
  <!----------------    TOAST  ----------------->
<!----------------------------------------------------------------------->

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

