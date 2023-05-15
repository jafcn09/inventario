<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['visitas']==1)
{

//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_Table.php');
 
//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table();
 
//Agregamos la primera página al documento pdf
$pdf->AddPage();
 
//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
 
//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial','B',12);

$pdf->Cell(45,6,'',0,0,'C');
$pdf->Cell(100,6,'LISTA DE VISITAS',1,0,'C'); 
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,6,'Nombres',1,0,'C',1); 
$pdf->Cell(25,6,'Tipo Doc',1,0,'C',1);
$pdf->Cell(25,6,'Num Doc',1,0,'C',1);
$pdf->Cell(40,6,'Fec Entrada',1,0,'C',1);
$pdf->Cell(40,6,'Fec Salida',1,0,'C',1);
 
$pdf->Ln(10);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Visitas.php";
$venta = new Visitas();

$rspta = $venta->listar();

// idvisitas
// idusuario
// nombres
// fecha_entrada
// fecha_salida
// tipo_documento
// num_documento
// motivo

//Table with rows and columns
$pdf->SetWidths(array(60,25,25,40,40));

while($reg= $rspta->fetch_object())
{  
    $nombres = $reg->nombres;
    $tipo_documento = $reg->tipo_documento;
    $num_documento = $reg->num_documento;
    $fecha_entrada = $reg->fecha_entrada;
    $fecha_salida = $reg->fecha_salida;
 	
 	$pdf->SetFont('Arial','',10);
    $pdf->Row(array(utf8_decode($nombres),$tipo_documento,$num_documento,$fecha_entrada,$fecha_salida));
}
 
//Mostramos el documento pdf
$pdf->Output();

?>
<?php
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>