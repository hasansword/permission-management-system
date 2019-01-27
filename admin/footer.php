<?php
    include_once "sessionBilgi.php";
?>
        </div>
        <!-- END wrapper -->


        <script>
            var resizefunc = [];
        </script>

        <script src="../plugins/moment/moment.js"></script>
     	<script src="../plugins/timepicker/bootstrap-timepicker.js"></script>
     	<script src="../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
     	<script src="../plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> 
     	<script src="../plugins/clockpicker/js/bootstrap-clockpicker.min.js"></script>
     	<script src="../plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="assets/pages/jquery.form-pickers.init.js"></script>

        <script src="assets/js/datatables.min.js" type="text/javascript"></script>
        <script src="assets/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
        <script src="assets/js/datatable-buttons.js" type="text/javascript"></script>
        <script src="assets/js/dataTables.responsive.min.js"></script>
        <script src="../plugins/datatables/jszip.min.js"></script>
        <script src="../plugins/datatables/pdfmake.min.js"></script>
        <script src="../plugins/datatables/vfs_fonts.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <script src="assets/js/custom.js"></script>

        <!-- Sweet-Alert  -->
        <script src="../plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
        <script src="assets/pages/jquery.sweet-alert.init.js"></script>

        <script>
            $(document).ready(function () {
                $.each($('.dataTable'), function (key, value) {
                    tableInit("#" + $(value).attr('id'));
                });
            });
        </script>

         <script type="text/javascript" src="../plugins/parsleyjs/parsley.min.js"></script>
                <script type="text/javascript">
			$(document).ready(function() {
				$('form').parsley();
			});
		</script>

    </body>
</html>