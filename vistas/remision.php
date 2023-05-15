<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';
  require '../config/Conexion.php';

  if ($_SESSION['remision'] == 1) {
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
                <h1 class="box-title">Guía de remisión <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> <a href="../reportes/rptremision.php" target="_blank"><button class="btn btn-info"><i class="fa fa-clipboard"></i> Reporte</button></a> <a href="../reportes/rptremisionDia.php" target="_blank"><button class="btn btn-warning"><i class="fa fa-clipboard"></i> Reporte del día</button></a></h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover w-100" style="width: 100% !important;">
                  <thead>
                    <th style="width: 20%;">Opciones</th>
                    <th>Fecha y hora de emisión</th>
                    <th>Comprobante</th>
                    <th>Serie y N° de comp.</th>
                    <th>Tipo de documento</th>
                    <th>N° de documento</th>
                    <th>Razón social</th>
                    <th>Total de compra</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Fecha y hora de emisión</th>
                    <th>Comprobante</th>
                    <th>Serie y N° de comp.</th>
                    <th>Tipo de documento</th>
                    <th>N° de documento</th>
                    <th>Razón social</th>
                    <th>Total de compra</th>
                    <th>Estado</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="height: 100%;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Domicilio de partida(*):</label>
                    <input type="hidden" name="idremision" id="idremision">
                    <input type="text" class="form-control" name="domicilio_partida" id="domicilio_partida" maxlength="40" placeholder="Domicilio de partida" required="">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Domicilio de llegada(*):</label>
                    <input type="text" class="form-control" name="domicilio_llegada" id="domicilio_llegada" maxlength="40" placeholder="Domicilio de llegada" required="">
                  </div>

                  <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label>Serie de comprobante(*):</label>
                    <input type="text" class="form-control" name="correlativo" id="correlativo" maxlength="10" placeholder="Serie de comprobante" disabled required="" />
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label>N° de comprobante(*):</label>
                    <input type="text" class="form-control" name="num_remision" id="num_remision" maxlength="11" placeholder="N° de comprobante" disabled required="">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label>Fecha de emisión(*):</label>
                    <input type="datetime-local" class="form-control" name="fecha_emision" id="fecha_emision" required="">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label>Fecha de traslado(*):</label>
                    <input type="datetime-local" class="form-control" name="fecha_traslado" id="fecha_traslado" required="">
                  </div>

                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Tipo de Documento(*):</label>
                    <select class="form-control selectpicker" name="tipo_documento" id="tipo_documento" onchange="changeValue(this);" required="">
                      <option value="DNI">DNI</option>
                      <option value="RUC">RUC</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>N° de Documento:</label>
                    <input type="number" class="form-control" name="num_documento" id="num_documento" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8" placeholder="Número de documento">
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Tipo de comprobante(*):</label>
                    <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                      <option value="Remision">Remisión</option>
                    </select>
                  </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label>Razón social(*):</label>
                    <select id="razonsocial" name="razonsocial" class="form-control selectpicker" data-live-search="true" required>
                    </select>
                  </div>

                  <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label>Marca de vehículo(*):</label>
                    <input type="text" class="form-control" name="marca" id="marca" maxlength="15" placeholder="Marca de vehículo" required="">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <label>Placa de vehículo(*):</label>
                    <input type="text" class="form-control" name="placa" id="placa" maxlength="6" placeholder="Placa de vehículo" required="">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label>N° de certificado de inscripción(*):</label>
                    <input type="number" class="form-control" name="certificado" id="certificado" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="13" placeholder="N° de certificado de inscripción" required="">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label>N° de licencia de conducir(*):</label>
                    <input type="number" class="form-control" name="licencia" id="licencia" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="13" placeholder="N° de licencia de conducir" required="">
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
                        <th>Peso por unidad</th>
                        <th>Subtotal</th>
                      </thead>
                      <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>
                          <h5 class="justify-content-center align-items-center" style="font-weight: bold;">TOTAL</h5>
                        </th>
                        <th>
                          <h4 id="total">S/. 0.00</h4><input type="hidden" name="total_compra" id="total_compra">
                        </th>
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
  <script type="text/javascript" src="scripts/remision13.js"></script>
<?php
}
ob_end_flush();
?>