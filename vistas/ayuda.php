<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['ayuda'] == 1) {
?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Ayuda</h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body">
                <h4><strong>Soporte: </strong></h4>
                <p>Si necesitas ayuda o más información, contáctate con nosotros llamando al <strong>+51 998 393 220</strong></p>
                <h4><strong>Empresa: </strong></h4>
                <p>Arena San Andrés Perú S.A.C.</p>
                <h4><strong>Desarrollado por: </strong></h4>
                <p>SistemaDeInventario@gmail.com</p>
              </div>
              <!--Fin centro -->
            </div><!-- /.box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>

<?php
}
ob_end_flush();
?>