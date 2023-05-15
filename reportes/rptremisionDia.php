<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1)
  session_start();

if (!isset($_SESSION["remision"])) {
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
} else {
  if ($_SESSION['compras'] == 1) {

    //Inlcuímos a la clase PDF_MC_Table
    require('PDF_MC_Table.php');

    //Instanciamos la clase para generar el documento pdf
    $pdf = new PDF_MC_Table();

    //Agregamos la primera página al documento pdf
    $pdf->AddPage();

    //Seteamos el inicio del margen superior en 25 pixeles 
    $y_axis_initial = 25;

    //Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(40, 6, '', 0, 0, 'C');
    $pdf->Cell(100, 6, 'LISTA DE REMISIONES', 1, 0, 'C');
    $pdf->Ln(10);

    //Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
    $pdf->SetFillColor(232, 232, 232);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(35, 6, utf8_decode('Tipo Comprobante'), 1, 0, 'C', 1);
    $pdf->Cell(30, 6, utf8_decode('Guía remisión'), 1, 0, 'C', 1);
    $pdf->Cell(23, 6, utf8_decode('Tipo Doc.'), 1, 0, 'C', 1);
    $pdf->Cell(25, 6, utf8_decode('Num Doc.'), 1, 0, 'C', 1);
    $pdf->Cell(56, 6, utf8_decode('Razón Social'), 1, 0, 'C', 1);
    $pdf->Cell(20, 6, utf8_decode('Total'), 1, 0, 'C', 1);

    $pdf->Ln(10);
    //Comenzamos a crear las filas de los registros según la consulta mysql
    require_once "../modelos/Remision.php";
    $remision = new Remision();

    $rspta = $remision->listarRemisionesPorDia();

    //Table with rows and columns
    $pdf->SetWidths(array(35, 30, 23, 25, 56, 20));

    while ($reg = $rspta->fetch_object()) {
      $tipo_comprobante = $reg->tipo_comprobante;
      $num_remision = "N° " + $reg->correlativo + " - " + $reg->num_remision;
      $tipo_documento = $reg->tipo_documento;
      $num_documento = $reg->num_documento;
      $razonsocial = $reg->razonsocial;
      $total_compra = $reg->total_compra;

      $pdf->SetFont('Arial', '', 10);
      $pdf->Row(array(utf8_decode($tipo_comprobante), utf8_decode($num_remision), utf8_decode($tipo_documento), utf8_decode($num_documento), utf8_decode($razonsocial), $total_compra));
    }

    //Mostramos el documento pdf
    $pdf->Output();

?>
<?php
  } else {
    echo 'No tiene permiso para visualizar el reporte';
  }
}
ob_end_flush();
?>