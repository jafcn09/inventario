<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1)
  session_start();

if (!isset($_SESSION["remision"])) {
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
} else {
  if ($_SESSION['compras'] == 1) {
    //Incluímos el archivo Remision.php
    require('Remision.php');

    //Establecemos los datos de la empresa
    $logo = "logo.jpg";
    $ext_logo = "jpg";
    $empresa = "Arena San Andrés Perú S.A.C.";
    $documento = "20477157772";
    $direccion = "Av Gerardo Unger 5689 - Los Olivos - Lima";
    $telefono = "998 393 220";
    $email = "jorgepomar10@gmail.com";

    $excavadora_logo = "excavadora.png";
    $tipo_archivo = "png";

    //Obtenemos los datos de la cabecera de la venta actual
    require_once "../modelos/Remision.php";
    $ingreso = new Remision();

    $rsptav = $ingreso->remisioncabecera($_GET["id"]);
    //Recorremos todos los valores obtenidos
    $regv = $rsptav->fetch_object();

    //Establecemos la configuración de la Remisión
    $pdf = new PDF_Invoice('P', 'mm', 'A4');
    $pdf->AddPage();

    //Enviamos los datos de la empresa al método addSociete de la clase Remisión
    $pdf->addSociete(
      utf8_decode($empresa),
      utf8_decode($documento) . "\n" .
        utf8_decode("Dirección: ") . utf8_decode($direccion) . "\n" .
        utf8_decode("Teléfono: ") . $telefono . "\n" .
        "Email : " . $email,
      $logo,
      $ext_logo
    );

    $pdf->fact_dev("");

    $pdf->RoundedRect2(151, 18, 49, 11, 3.5, '', 'DF');

    $pdf->RoundedRect2(10, 57, 93, 8, 3.5, '12', 'DF');
    $pdf->RoundedRect2(107, 57, 93, 8, 3.5, '12', 'DF');
    $pdf->RoundedRect2(10, 81, 108, 8, 3.5, '12', 'DF');
    $pdf->RoundedRect2(122, 81, 78, 8, 3.5, '12', 'DF');

    $pdf->guiaRemisionCabecera(
      "$regv->tipo_documento - $regv->num_documento",
      utf8_decode("N° $regv->correlativo - $regv->num_remision")
    );

    $pdf->fechaEmision($regv->fecha_emision);
    $pdf->FechaTraslado($regv->fecha_traslado);

    $pdf->addDomicilioPartida(utf8_decode($regv->domicilio_partida));
    $pdf->addDomicilioLlegada(utf8_decode($regv->domicilio_llegada));

    //Enviamos los datos del cliente al método addClientAdresse de la clase Remisión
    $pdf->addClientAdresse1(
      utf8_decode(""),
      utf8_decode($regv->tipo_documento . ": " . $regv->num_documento),
      utf8_decode("Razón social: ") . utf8_decode($regv->razonsocial),
      utf8_decode("Tipo y número de documento: " . $regv->tipo_documento . " - " . $regv->num_documento)
    );

    $pdf->addClientAdresse2(
      utf8_decode(""),
      utf8_decode("Marca y placa: ") . utf8_decode($regv->marca . " - " . $regv->placa),
      utf8_decode("Certificado de inscripción: N° ") . utf8_decode($regv->certificado),
      utf8_decode("Licencia de conducir: N° " . $regv->licencia)
    );

    //Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
    $cols = array(
      "CODIGO" => 23,
      "DESCRIPCION" => 78,
      "CANTIDAD" => 22,
      "PESO POR UNIDAD" => 37,
      "PESO TOTAL" => 30
    );

    $pdf->addCols($cols);

    $cols = array(
      "CODIGO" => "L",
      "DESCRIPCION" => "L",
      "CANTIDAD" => "C",
      "PESO POR UNIDAD" => "R",
      "PESO TOTAL" => "C"
    );

    $pdf->addLineFormat($cols);
    $pdf->addLineFormat($cols);

    //Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
    $y = 123;

    //Obtenemos todos los detalles de la venta actual
    $rsptad = $ingreso->remisiondetalle($_GET["id"]);

    while ($regd = $rsptad->fetch_object()) {
      $line = array(
        "CODIGO" => "$regd->codigo",
        "DESCRIPCION" => utf8_decode("$regd->articulo"),
        "CANTIDAD" => "$regd->cantidad",
        "PESO POR UNIDAD" => "$regd->precio_compra",
        "PESO TOTAL" => "$regd->subtotal"
      );
      $size = $pdf->addLine($y, $line);
      $y   += $size + 2;
    }

    $pdf->excavadoraImg($excavadora_logo, $tipo_archivo);

    $pdf->RoundedRect(88, 239, 4, 3.5, 0.5, '13', 'DF');
    $pdf->RoundedRect(88, 243, 4, 3.5, 0.5, '13', 'DF');
    $pdf->RoundedRect(88, 247, 4, 3.5, 0.5, '13', 'DF');
    $pdf->RoundedRect(88, 251, 4, 3.5, 0.5, '13', 'DF');
    $pdf->RoundedRect(88, 255, 4, 3.5, 0.5, '13', 'DF');
    $pdf->RoundedRect(88, 259, 4, 3.5, 0.5, '13', 'DF');
    $pdf->RoundedRect(88, 266, 4, 3.5, 0.5, '13', 'DF');

    $pdf->RoundedRect(125, 239, 4, 3.5, 0.5, '13', 'DF');
    $pdf->RoundedRect(125, 247.5, 4, 3.5, 0.5, '13', 'DF');
    $pdf->RoundedRect(125, 251.5, 4, 3.5, 0.5, '13', 'DF');
    $pdf->RoundedRect(125, 255.5, 4, 3.5, 0.5, '13', 'DF');
    $pdf->RoundedRect(125, 259.5, 4, 3.5, 0.5, '13', 'DF');

    $pdf->RoundedRect(150, 239, 4, 3.5, 0.5, '13', 'DF');
    $pdf->RoundedRect(150, 243, 4, 3.5, 0.5, '13', 'DF');
    $pdf->RoundedRect(150, 247, 4, 3.5, 0.5, '13', 'DF');

    $pdf->Line(161, 255, 137, 255);
    $pdf->Line(161, 259, 137, 259);
    $pdf->Line(161, 263, 137, 263);
    $pdf->Line(161, 267, 137, 267);

    $pdf->Line(10, 238, 163, 238);
    $pdf->Line(163, 271, 163, 231);
    $pdf->Line(43, 271, 43, 231);

    $pdf->RoundedRect2(10, 231, 33, 7, 3.5, '1', 'DF');
    $pdf->RoundedRect2(10, 251, 33, 7, 3.5, '', 'DF');

    $pdf->plantillaFooter();
    $pdf->contenidoFooter();

    $pdf->Line(198, 246, 165, 246);
    $pdf->Line(198, 261, 165, 261);

    $pdf->Output(utf8_decode('Reporte de Remisión.pdf'), 'I');
    
  } else {
    echo 'No tiene permiso para visualizar el reporte';
  }
}
ob_end_flush();
