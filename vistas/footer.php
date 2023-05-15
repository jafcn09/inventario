    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 4.0.0
        </div>
        <strong>Copyright &copy; 2023 <a href="./escritorio.php">Sistema De Gestion De Documentos</a>.</strong> All rights reserved.
    </footer>    
    <!-- jQuery -->
    <script src="../public/js/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../public/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../public/js/app.min.js"></script>

    <!-- DATATABLES -->
    <script src="../public/datatables/jquery.dataTables.min.js"></script>    
    <script src="../public/datatables/dataTables.buttons.min.js"></script>
    <script src="../public/datatables/buttons.html5.min.js"></script>
    <script src="../public/datatables/buttons.colVis.min.js"></script>
    <script src="../public/datatables/jszip.min.js"></script>
    <script src="../public/datatables/pdfmake.min.js"></script>
    <script src="../public/datatables/vfs_fonts.js"></script> 

    <script src="../public/js/bootbox.min.js"></script> 
    <script src="../public/js/bootstrap-select.min.js"></script>

    <script type="text/javascript">
      function changeValue(dropdown) {
        var option = dropdown.options[dropdown.selectedIndex].value,
        field = document.getElementById('num_documento');

        if (option == 'DNI') {
          $("#num_documento").val("");
          field.maxLength = 8;
        } else if (option == 'CEDULA') {
          $("#num_documento").val("");
          field.maxLength = 10;
        } else {
          $("#num_documento").val("");
          field.maxLength = 11;
        }
      }
    </script>
  </body>
</html>