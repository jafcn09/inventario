<?php
if (strlen(session_id()) < 1)
  session_start();

  $nombre_login = $_SESSION['nombre'];
  $rol_login = $_SESSION['rol'];
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistema De Gestion De Documentos | Moquegua</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="../public/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/css/font-awesome.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../public/css/_all-skins.min.css">
  <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
  <link rel="shortcut icon" href="../public/img/favicon.ico">

  <!-- DATATABLES -->
  <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
  <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
  <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">

</head>

<body class="hold-transition skin-blue-light sidebar-mini">
  <div class="wrapper">

    <header class="main-header">

      <!-- Logo -->
      <a href="./escritorio.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>S.I.</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg" style="font-size: 15px;"><b>Sistema De Documentos</b></span>
      </a>

      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Navegación</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                <span class="hidden-xs user-info"><?php echo $nombre_login; ?> - <?php echo '<strong> Rol: ' . $rol_login . '</strong>' ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                  <p>
                    Sistema de documentos <br> PROCOMPITE MOQUEGUA
                    <small>nuestro contacto: +51 999999999999</small>
                  </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">

                  <div class="pull-right">
                    <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat" onclick="destruirSession()">Cerrar</a>
                  </div>
                </li>
              </ul>
            </li>

          </ul>
        </div>

      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header"></li>
          <?php
          // if ($_SESSION['escritorio'] == 1) {
          //   echo '<li id="mEscritorio">
          //     <a href="escritorio.php">
          //       <i class="fa fa-user"></i> <span>Rol: '.$_SESSION['rol'].'</span>
          //     </a>
          //   </li>';
          // }
          ?>

          <?php
          if ($_SESSION['escritorio'] == 1) {
            echo '<li id="mEscritorio">
              <a href="escritorio.php">
                <i class="fa fa-tasks"></i> <span>Escritorio</span>
              </a>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['almacen'] == 1) {
            echo '<li id="mAlmacen" class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Documentos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lArticulos"><a href="articulo.php"><i class="fa fa-circle-o"></i> Tipo De Documentos</a></li>
 
                <li id="lAlmacenes"><a href="almacenes.php"><i class="fa fa-circle-o"></i> Locales</a></li>
                <li id="lMarcas"><a href="marcas.php"><i class="fa fa-circle-o"></i> Empresas</a></li>
              </ul>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['compras'] == 1) {
            echo '<li id="mCompras" class="treeview">
              <a href="#">
                <i class="fa fa-th"></i>
                <span>Recepcion</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lIngresos"><a href="ingreso.php"><i class="fa fa-circle-o"></i> Ingresos de documentos</a></li>
                <li id="lProveedores"><a href="proveedor.php"><i class="fa fa-circle-o"></i> Afiliados</a></li>
              </ul>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['remision'] == 1) {
            echo '<li id="mRemision" class="treeview">
              <a href="#">
                <i class="fa fa-hospital-o"></i> <span>Remisión</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lRemision"><a href="remision.php"><i class="fa fa-circle-o"></i> Guía de remisión</a></li>                
              </ul>
            </li>';
          }
          ?>

     

          <?php
          if ($_SESSION['controlv'] == 1) {
            echo '<li id="mControlv" class="treeview">
              <a href="#">
                <i class="fa fa-truck"></i> <span>Control De Documentos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lArticuloE"><a href="articulo-externa.php"><i class="fa fa-circle-o"></i> Documentos externos</a></li>                
                <li id="lVentasE"><a href="venta-externa.php"><i class="fa fa-circle-o"></i> Publicaciones</a></li>                
              </ul>
            </li>';
          }
          ?>

         

          <?php
          if ($_SESSION['visitas'] == 1) {
            echo '<li id="mVisitas" class="treeview">
              <a href="#">
                <i class="fa fa-eye"></i> <span>Visitas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lVisitas"><a href="visitas.php"><i class="fa fa-circle-o"></i> Control de visitas</a></li>                
              </ul>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['acceso'] == 1) {
            echo '<li id="mAcceso" class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Acceso</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lUsuarios"><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                <li id="lPermisos"><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                
              </ul>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['perfilu'] == 1) {
            echo '<li id="mPerfilUsuario" class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Perfil de usuario</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">';
            // Submódulo de Configuración de comprobante
            if ($_SESSION['rol'] == "Administrador") {
              echo '<li id="lConfComprobante"><a href="confComprobante.php"><i class="fa fa-circle-o"></i> Configuración de comprobante</a></li>';
            }
            // Submódulo de Configuración de usuario
            echo '<li id="lConfUsuario"><a href="confUsuario.php"><i class="fa fa-circle-o"></i> Configuración de perfil</a></li>';
            // Submódulo de Configuración de portada
            if ($_SESSION['rol'] == "Administrador") {
              echo '<li id="lConfPortada"><a href="confPortada.php"><i class="fa fa-circle-o"></i> Configuración de portada</a></li>';
            }
            echo '</ul>
                </li>';
          }
          ?>

          <?php
          if ($_SESSION['consultac'] == 1) {
            echo '<li id="mConsultaC" class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Documentos Aprobados</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lConsulasC"><a href="comprasfecha.php"><i class="fa fa-circle-o"></i> Consulta De Documentos Aprobados</a></li>                
              </ul>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['consultav'] == 1) {
            echo '<li id="mConsultaV" class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Documentos Rechazados</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lConsulasV"><a href="ventasfechacliente.php"><i class="fa fa-circle-o"></i> Consulta De Documentos Rechazados</a></li>                
              </ul>
            </li>';
          }
          ?>

<?php
          if ($_SESSION['consultav'] == 1) {
            echo '<li id="mConsultaV" class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Documentos en espera</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lConsulasV"><a href="ventasfechacliente.php"><i class="fa fa-circle-o"></i> Consulta De Documentos En Espera</a></li>                
              </ul>
            </li>';
          }
          ?>

          <li>
            <?php
            if ($_SESSION['ayuda'] == 1) {
              echo '
            <a href="ayuda.php">
              <i class="fa fa-plus-square"></i> <span>Ayuda</span>
              <small class="label pull-right bg-red">PDF</small>
            </a>';
            }


            ?>
          </li>
          <li>
            <?php
            if ($_SESSION['acerca'] == 1) {
              echo '
            <a href="acerca.php">
              <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
              <small class="label pull-right bg-yellow">IT</small>
            </a>';
            }
            ?>
          </li>

          <li id="sql_export">
            <a>
              <?php
              if ($_POST) {
                if ($_POST["backup"]) {
                  require("backup/backup.php");
                  $backupdb = new backupdb();
                }
              }
              ?>
              <form method="post">
                <input type="hidden" value="true" name="backup">
                <i class="fa fa-file"></i>
                <input id="sql" type="submit" value="Exportar DB." style="border: none; background-color: transparent; outline: none;">
              </form>
              <small class="label pull-right bg-green">SQL</small>
            </a>
          </li>

          <div style="display: none;" id="rolUsuario"><?php echo $_SESSION['rol'] ?></div>

        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    <script>
      // si no queremos que se actualice cada cierto tiempo, se tendrá que comentar todo este script.
      // var timeout_time = 3200; // 1 hora => 3200 seg || media hora => 1800 seg
      // var time_remaining = 0;
      // var rolusuario = document.getElementById("rolUsuario").innerHTML;

      // console.log(rolusuario);

      // if (sessionStorage.getItem('timeout_time') == null) {
      //   run_timeout(timeout_time);
      // } else {
      //   run_timeout(sessionStorage.getItem('timeout_time'))
      // }

      // if (rolusuario == "Administrador") {
      //   setInterval(function() {
      //     time_remaining = sessionStorage.getItem('timeout_time');
      //     if (time_remaining > 1 || time_remaining != null) {
      //       sessionStorage.setItem('timeout_time', time_remaining - 1);
      //     }
      //   }, 1000);
      //   document.getElementById("sql_export").style.display = "block";
      // } else {
      //   document.getElementById("sql_export").style.display = "none";
      // }

      // function run_timeout(time) {
      //   setTimeout(function() {
      //     document.getElementById("sql").click();
      //     sessionStorage.removeItem('timeout_time');
      //   }, time * 1000);
      //   sessionStorage.setItem('timeout_time', time);
      //   sessionStorage.setItem('rol_usuario', rolusuario);
      // }

      function destruirSession() {
        sessionStorage.clear();
      }
    </script>