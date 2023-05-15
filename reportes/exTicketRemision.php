<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1)
  session_start();

if (!isset($_SESSION["remision"])) {
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
} else {
  if ($_SESSION['remision'] == 1) {
?>
    <html>

    <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
    </head>

    <body onload="window.print();">
      <?php

      //Incluímos la clase compra
      require_once "../modelos/Remision.php";
      //Instanaciamos a la clase con el objeto compra
      $compra = new Remision();
      //En el objeto $rspta Obtenemos los valores devueltos del método compracabecera del modelo
      $rspta = $compra->remisioncabecera($_GET["id"]);
      //Recorremos todos los valores obtenidos
      $reg = $rspta->fetch_object();

      //Establecemos los datos de la empresa
      $empresa = "Arena San Andrés Perú S.A.C.";
      $documento = "20477157772";
      $direccion = "Av Gerardo Unger 5689 - Los Olivos - Lima";
      $telefono = "998 393 220";
      $email = "jorgepomar10@gmail.com";

      ?>
      <div class="zona_impresion">
        <!-- codigo imprimir -->
        <br>
        <table border="0" align="center" width="300px">
          <tr>
            <td align="center">
              <img width="140px" height="70px" src="./arena.jpg">
            </td>
          </tr>
          <tr>
            <td colspan="16"></td>
          </tr>
          <tr>
            <td align="center">
              <!-- Mostramos los datos de la empresa en el documento HTML -->
              .::<strong> <?php echo $empresa; ?></strong> ::.<br>
              <?php echo $documento; ?><br>
              <?php echo $direccion . '<br>Teléfono: ' . $telefono; ?><br>
            </td>
          </tr>
          <tr>
            <td align="center">Emisión: <?php echo $reg->fecha_emision; ?></td>
          </tr>
          <tr>
            <td align="center">Traslado: <?php echo $reg->fecha_traslado; ?></td>
          </tr>
          <tr>
            <td align="center"></td>
          </tr>
          <tr>
            <!-- Mostramos los datos del usuario en el documento HTML -->
            <td>Creador de la guía de remisión: <strong><?php echo $reg->nombreusur; ?></strong></td>
          </tr>
          <tr>
            <td><?php echo $reg->tipo_documento . ": " . $reg->num_documento; ?></td>
          </tr>
          <tr>
            <td>Guía de remisión: <?php echo "N° " . $reg->correlativo . " - " . $reg->num_remision; ?></td>
          </tr>
        </table>
        <br>
        <!-- Mostramos los detalles de la compra en el documento HTML -->
        <table border="0" align="center" width="300px">
          <tr>
            <td>CANT.</td>
            <td>DESCRIPCIÓN</td>
            <td align="right">IMPORTE</td>
          </tr>
          <tr>
            <td colspan="3">==========================================</td>
          </tr>
          <?php
          $rsptad = $compra->remisiondetalle($_GET["id"]);
          $cantidad = 0;
          while ($regd = $rsptad->fetch_object()) {
            echo "<tr>";
            echo "<td>" . $regd->cantidad . "</td>";
            echo "<td>" . $regd->articulo;
            echo "<td align='right'>S/ " . $regd->subtotal . "</td>";
            echo "</tr>";
            $cantidad = $cantidad + 1;
          }
          ?>
          <!-- Mostramos los totales de la compra en el documento HTML -->
          <tr>
            <td>&nbsp;</td>
            <td align="right"><b>TOTAL:</b></td>
            <td align="right"><b>S/ <?php echo $reg->total_compra;  ?></b></td>
          </tr>
          <tr>
            <td colspan="3">Nº de artículos: <?php echo $cantidad; ?></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="center">¡Gracias por su compra!</td>
          </tr>
          <tr>
            <td colspan="3" align="center">Sistema De Inventario</td>
          </tr>
          <tr>
            <td colspan="3" align="center">Lima - Perú</td>
          </tr>

        </table>
        <br>
      </div>
      <p>&nbsp;</p>

    </body>

    </html>
<?php
  } else {
    echo 'No tiene permiso para visualizar el reporte';
  }
}
ob_end_flush();
?>