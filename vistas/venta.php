<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';
  require '../config/Conexion.php';

  if ($_SESSION['ventas'] == 1) {
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
                <h1 class="box-title">Venta <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> <a href="../reportes/rptventas.php" target="_blank"><button class="btn btn-info"><i class="fa fa-clipboard"></i> Reporte</button></a> <a href="../reportes/rptventasDia.php" target="_blank"><button class="btn btn-warning"><i class="fa fa-clipboard"></i> Reporte del día</button></a></h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover w-100" style="width: 100% !important;">
                  <thead>
                    <th style="width: 18%;">Opciones</th>
                    <th>Fecha y hora</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Tipo de comprobante</th>
                    <th>Serie y N° de comprobante</th>
                    <th>Total Venta</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Fecha y hora</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Tipo de comprobante</th>
                    <th>Serie y N° de comprobante</th>
                    <th>Total Venta</th>
                    <th>Estado</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="height: 100%;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    <label>Cliente(*):</label>
                    <input type="hidden" name="idventa" id="idventa">
                    <select id="idcliente" name="idcliente" class="form-control selectpicker" data-live-search="true" required>
                    </select>
                  </div>
                  <div class="form-group col-lg-2 col-md-4 col-sm-4 col-xs-12">
                    <label>N° de serie(*):</label>
                    <input type="number" class="form-control" name="correlativo" id="correlativo" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="11" placeholder="Correlativo" required="">
                  </div>
                  <div class="form-group col-lg-2 col-md-4 col-sm-4 col-xs-12">
                    <label>Número de remisión(*):</label>
                    <input type="number" class="form-control" name="num_remision" id="num_remision" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="13" placeholder="Número de remisión" required="">
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Fecha y hora de emisión(*):</label>
                    <input type="datetime-local" class="form-control" name="fecha_hora" id="fecha_hora" required="">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Tipo de comprobante(*):</label>
                    <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" onchange="modificarSubototales();" required="">
                      <option value="Boleta">Boleta</option>
                      <option value="Factura">Factura</option>
                      <option value="Ticket">Ticket</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Serie de comprobante(*):</label>
                    <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="10" placeholder="Serie de comprobante" disabled required="">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>N° de comprobante(*):</label>
                    <input type="text" class="form-control" name="num_comprobante" id="num_comprobante" maxlength="11" placeholder="N° de comprobante" disabled required="">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Impuesto(*):</label>
                    <select name="impuesto" id="impuesto" class="form-control selectpicker" onchange="modificarSubototales();" required="">
                      <option value="0">0</option>
                      <option value="18">18</option>
                    </select>
                  </div>

                  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a data-toggle="modal" href="#myModal">
                      <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Artículos</button>
                    </a>
                  </div>

                  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover w-100" style="width: 100% !important;">
                      <thead style="background-color:#A9D0F5">
                        <th>Opciones</th>
                        <th>Artículo</th>
                        <th>Cantidad</th>
                        <th>Precio Venta</th>
                        <th>Descuento</th>
                        <th>Subtotal</th>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>IGV</th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th>
                            <h4 id="igv">S/. 0.00</h4><input type="hidden" name="total_igv" id="total_igv">
                          </th>
                        </tr>
                        <tr>
                          <th>TOTAL</th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th>
                            <h4 id="total">S/. 0.00</h4><input type="hidden" name="total_venta" id="total_venta">
                          </th>
                        </tr>
                      </tfoot>
                      <tbody>
                      </tbody>
                    </table>
                  </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                    <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                  </div>
                </form>
              </div>
              <!--Fin centro -->
            </div><!-- /.box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Seleccione un Artículo</h4>
          </div>
          <div class="modal-body table-responsive">
            <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover" style="width: 100%;">
              <thead>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Stock</th>
                <th>U. medida</th>
                <th>Cubicaje</th>
                <th>Material</th>
                <th>Precio Venta</th>
                <th>Imagen</th>
                <th>Estado</th>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Stock</th>
                <th>U. medida</th>
                <th>Cubicaje</th>
                <th>Material</th>
                <th>Precio Venta</th>
                <th>Imagen</th>
                <th>Estado</th>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin modal -->
  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/ventas14.js"></script>
<?php
}
ob_end_flush();
?>