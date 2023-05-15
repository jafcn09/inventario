<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['consultac'] == 1) {
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
                <h1 class="box-title">Consulta de Compras</h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <label>Fecha Inicio</label>
                  <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <label>Fecha Fin</label>
                  <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
                </div>
                <div class="form-inline col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Proveedor</label>
                  <select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true" required></select>
                </div>
                <div class="row">
                  <div class="col-12"></div>
                </div>
                <div class="row" style="margin-bottom: 20px;">
                  <div class="col-md-12">
                    <button style="margin-top: 10px; margin-left: 10px; float: left;" class="btn btn-success" onclick="listarcompras()">Mostrar compras al provedor seleccionado por fecha</button>
                    <button style="margin-top: 10px; margin-left: 10px; float: left;" class="btn btn-warning" onclick="listartodascompras()">Mostrar todas las compras al proovedor</button>
                    <button style="margin-top: 10px; margin-left: 10px; float: left;" class="btn btn-danger" onclick="listartodascomprasproveedores()">Mostrar todas las compras a todos los proveedores</button>
                  </div>
                </div>
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover w-100" style="width: 100% !important;">
                  <thead>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Proveedor</th>
                    <th>Comprobante</th>
                    <th>Número</th>
                    <th>Total Compra</th>
                    <th>Impuesto</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Proveedor</th>
                    <th>Comprobante</th>
                    <th>Número</th>
                    <th>Total Compra</th>
                    <th>Impuesto</th>
                    <th>Estado</th>
                  </tfoot>
                </table>
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
  <script type="text/javascript" src="scripts/comprasfecha3.js"></script>
<?php
}
ob_end_flush();
?>