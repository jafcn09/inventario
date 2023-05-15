<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['escritorio'] == 1) {
    require_once "../modelos/Consultas.php";
    $consulta = new Consultas();
    $rsptac = $consulta->totalcomprahoy();
    $regc = $rsptac->fetch_object();
    $totalc = $regc->total_compra;

    $rsptav = $consulta->totalventahoy();
    $regv = $rsptav->fetch_object();
    $totalv = $regv->total_venta;

    //Datos para mostrar el gráfico de barras de las compras
    $compras10 = $consulta->comprasultimos_10dias();
    $fechasc = '';
    $totalesc = '';
    while ($regfechac = $compras10->fetch_object()) {
      $fechasc = $fechasc . '"' . $regfechac->fecha . '",';
      $totalesc = $totalesc . $regfechac->total . ',';
    }

    //Quitamos la última coma
    $fechasc = substr($fechasc, 0, -1);
    $totalesc = substr($totalesc, 0, -1);

    //Datos para mostrar el gráfico de barras de las ventas
    $ventas12 = $consulta->ventasultimos_12meses();
    $fechasv = '';
    $totalesv = '';
    while ($regfechav = $ventas12->fetch_object()) {
      $fechasv = $fechasv . '"' . $regfechav->fecha . '",';
      $totalesv = $totalesv . $regfechav->total . ',';
    }

    //Quitamos la última coma
    $fechasv = substr($fechasv, 0, -1);
    $totalesv = substr($totalesv, 0, -1);

?>

    <style>
      .panel-body {
        padding-top: 0;
        padding-bottom: 0;
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
                <h1 class="box-title">Escritorio </h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body">
                <?php
                if ($_SESSION['almacen'] == 1) {
                ?>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="small-box bg-yellow">
                      <div class="inner">
                        <h4 style="font-size:17px;">
                          &nbsp;
                        </h4>
                        <p>DOCUMENTOS</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                      <a href="articulo.php" class="small-box-footer"> Tipo Documento <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                <?php
                }
                ?>
                <?php
                if ($_SESSION['remision'] == 1) {
                ?>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="small-box bg-blue">
                      <div class="inner">
                        <h4 style="font-size:17px;">
                          &nbsp;
                        </h4>
                        <p>Remisión</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                      <a href="remision.php" class="small-box-footer">Remisión <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                <?php
                }
                ?>
                <?php
                if ($_SESSION['controlv'] == 1) {
                ?>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="small-box bg-red">
                      <div class="inner">
                        <h4 style="font-size:17px;">
                          &nbsp;
                        </h4>
                        <p>Control de documentos</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                      <a href="articulo-externa.php" class="small-box-footer">Control de documentos <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                <?php
                }
                ?>
                <?php
                if ($_SESSION['visitas'] == 1) {
                ?>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="small-box bg-purple">
                      <div class="inner">
                        <h4 style="font-size:17px;">
                          &nbsp;
                        </h4>
                        <p>Visitas</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                      <a href="visitas.php" class="small-box-footer">Visitas <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                <?php
                }
                ?>
                <?php
                if ($_SESSION['compras'] == 1) {
                ?>
                  
                <?php
                }
                ?>
                <?php
                if ($_SESSION['ventas'] == 1) {
                ?>
                  
                <?php
                }
                ?>
              </div>
              <div class="panel-body">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                     Cantidad De Documentos Aprobados
                    </div>
                    <div class="box-body">
                      <canvas id="compras" width="400" height="300"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      Cantidad De Docuemenos Rechazados
                    </div>
                    <div class="box-body">
                      <canvas id="ventas" width="400" height="300"></canvas>
                    </div>
                  </div>
                </div>

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

  <script src="../public/js/chart.min.js"></script>
  <script src="../public/js/Chart.bundle.min.js"></script>
  <script type="text/javascript">
    var ctx = document.getElementById("compras").getContext('2d');
    var compras = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [<?php echo $fechasc; ?>],
        datasets: [{
          label: 'Documentos aprobados en el ultimo mes',
          data: [<?php echo $totalesc; ?>],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });

    var ctx = document.getElementById("ventas").getContext('2d');
    var ventas = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [<?php echo $fechasv; ?>],
        datasets: [{
          label: 'Documentos rechazados en  los últimos 12 Meses',
          data: [<?php echo $totalesv; ?>],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  </script>

<?php
}
ob_end_flush();
?>