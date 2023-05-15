<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['perfilu'] == 1) {
?>
    <style>
      .compras,
      .ventas,
      .remision {
        display: flex;
        align-items: end;
      }

      .compras .form-group,
      .ventas .form-group,
      .remision .form-group {
        padding: 0 10px !important;
      }

      @media (max-width: 991px) {

        .compras,
        .ventas,
        .remision {
          display: block;
        }
      }

      .marco {
        background-color: white;
        border-top: 3px #3686b4 solid;
        padding: 0 20px 20px 20px;
      }

      .box-title {
        padding: 5px 0 5px 0;
      }

      .box-header {
        margin-bottom: 15px;
      }
    </style>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Configuración de comprobante</h1>
                <div class="box-tools pull-right">
                </div>
              </div>
            </div>
            <div class="box" style="border-top: none !important">
              <div class="panel-body marco" id="formularioregistros1">
                <div class="box-header with-border">
                  <h1 class="box-title">Configuración de compras</h1>
                </div>
                <form name="formulario1" id="formulario1" method="POST">
                  <div class="compras">
                    <div class="form-group col-lg-5 col-md-5 col-sm-12">
                      <label>Serie de comprobante(*):</label>
                      <input type="text" class="form-control" name="serie_comprobante1" id="serie_comprobante1" maxlength="10" placeholder="Serie de comprobante" required="" />
                    </div>
                    <div class="form-group col-lg-5 col-md-5 col-sm-12">
                      <label>Número de comprobante(*):</label>
                      <input type="text" class="form-control" name="num_comprobante1" id="num_comprobante1" maxlength="11" placeholder="N° de comprobante" required="">
                    </div>
                    <div class="form-group col-lg-2 col-md-2 col-sm-12">
                      <button class="btn btn-success" type="submit" id="btnGuardar1"><i class="fa fa-save"></i>&nbsp; Actualizar</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="box" style="border-top: none !important">
              <div class="panel-body marco" id="formularioregistros2">
                <div class="box-header with-border">
                  <h1 class="box-title">Configuración de ventas</h1>
                </div>
                <form name="formulario2" id="formulario2" method="POST">
                  <div class="ventas">
                    <div class="form-group col-lg-5 col-md-5 col-sm-12">
                      <label>Serie de comprobante(*):</label>
                      <input type="text" class="form-control" name="serie_comprobante2" id="serie_comprobante2" maxlength="10" placeholder="Serie de comprobante" required="" />
                    </div>
                    <div class="form-group col-lg-5 col-md-5 col-sm-12">
                      <label>Número de comprobante(*):</label>
                      <input type="text" class="form-control" name="num_comprobante2" id="num_comprobante2" maxlength="11" placeholder="N° de comprobante" required="">
                    </div>
                    <div class="form-group col-lg-2 col-md-2 col-sm-12">
                      <button class="btn btn-success" type="submit" id="btnGuardar2"><i class="fa fa-save"></i>&nbsp; Actualizar</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="box" style="border-top: none !important">
              <div class="panel-body marco" id="formularioregistros3">
                <div class="box-header with-border">
                  <h1 class="box-title">Configuración de remisión</h1>
                </div>
                <form name="formulario3" id="formulario3" method="POST">
                  <div class="remision">
                    <div class="form-group col-lg-5 col-md-5 col-sm-12">
                      <label>Serie de comprobante(*):</label>
                      <input type="text" class="form-control" name="serie_comprobante3" id="serie_comprobante3" maxlength="10" placeholder="Serie de comprobante" required="" />
                    </div>
                    <div class="form-group col-lg-5 col-md-5 col-sm-12">
                      <label>Número de comprobante(*):</label>
                      <input type="text" class="form-control" name="num_comprobante3" id="num_comprobante3" maxlength="11" placeholder="N° de comprobante" required="">
                    </div>
                    <div class="form-group col-lg-2 col-md-2 col-sm-12">
                      <button class="btn btn-success" type="submit" id="btnGuardar3"><i class="fa fa-save"></i>&nbsp; Actualizar</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Consulta de series y nùmeros de comprobantes</h1>
                <div class="box-tools pull-right">
                </div>
              </div>
            </div>

            <div class="box">
              <div class="marco row" style="padding-bottom: 10px;">
                <div class="col-md-12" style="padding: 20px 0 20px 0 !important; margin-bottom: 20px; display: flex; gap: 10px; justify-content: center; border-bottom: 1px solid #f1f1f1;">
                  <button class="btn btn-primary" onclick="listarCompCompra()">Ver Comprobantes de Compra</button>
                  <button class="btn btn-primary" onclick="listarCompVenta()">Ver Comprobantes de Venta</button>
                  <button class="btn btn-primary" onclick="listarCompRemision()">Ver Comprobantes de Remisión</button>
                </div>
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover w-100" style="width: 100% !important">
                  <thead>
                    <th style="text-align: center;">Serie de comprobante</th>
                    <th style="text-align: center;">N° de comprobante</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th style="text-align: center;">Serie de comprobante</th>
                    <th style="text-align: center;">N° de comprobante</th>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
    </section>
    </div>
    <!--Fin-Contenido-->
  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/confComprobante5.js"></script>
<?php
}
ob_end_flush();
?>