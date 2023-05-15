<?php 
ob_start();
if (strlen(session_id()) < 1){
	session_start();//Validamos si existe o no la sesión
} 
if (!isset($_SESSION["nombre"]))
{
  header("Location: ../vistas/login.html");//Validamos el acceso solo a los usuarios logueados al sistema.
}
else
{
//Validamos el acceso solo al usuario logueado y autorizado.
if ($_SESSION['remision']==1)
{

require_once "../modelos/Remision.php";

$remision=new Remision();

// idremision
// domicilio_partida
// domicilio_llegada
// num_remision
// correlativo
// fecha_emision
// fecha_traslado
// tipo_documento
// num_documento
// tipo_comprobante
// razonsocial
// total_compra

$idremision=isset($_POST["idremision"])? limpiarCadena($_POST["idremision"]):"";
$idusuario=$_SESSION["idusuario"];
$correlativo=isset($_POST["correlativo"])? limpiarCadena($_POST["correlativo"]):"";
$num_remision=isset($_POST["num_remision"])? limpiarCadena($_POST["num_remision"]):"";
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$domicilio_partida=isset($_POST["domicilio_partida"])? limpiarCadena($_POST["domicilio_partida"]):"";
$domicilio_llegada=isset($_POST["domicilio_llegada"])? limpiarCadena($_POST["domicilio_llegada"]):"";
$razonsocial=isset($_POST["razonsocial"])? limpiarCadena($_POST["razonsocial"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$marca=isset($_POST["marca"])? limpiarCadena($_POST["marca"]):"";
$placa=isset($_POST["placa"])? limpiarCadena($_POST["placa"]):"";
$certificado=isset($_POST["certificado"])? limpiarCadena($_POST["certificado"]):"";
$licencia=isset($_POST["licencia"])? limpiarCadena($_POST["licencia"]):"";
$fecha_emision=isset($_POST["fecha_emision"])? limpiarCadena($_POST["fecha_emision"]):"";
$fecha_traslado=isset($_POST["fecha_traslado"])? limpiarCadena($_POST["fecha_traslado"]):"";
$total_compra=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idremision)){
			$numeroExiste = $remision->verificarNumeroExiste($correlativo);
			if ($numeroExiste) {
				echo "El número de comprobante que ha ingresado ya existe.";
			} else {
				$rspta=$remision->insertar($idusuario,$num_remision,$correlativo,$tipo_comprobante,$domicilio_partida,$domicilio_llegada,$razonsocial,$tipo_documento,$num_documento,$marca,$placa,$certificado,$licencia,$fecha_emision,$fecha_traslado,$total_compra,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"]);
			echo $rspta ? "Remisión registrada" : "No se pudieron registrar todos los datos de la remisión";
			}
		}else {
			$rspta=$remision->editar($idremision,$num_remision,$correlativo,$tipo_comprobante,$domicilio_partida,$domicilio_llegada,$razonsocial,$tipo_documento,$num_documento,$marca,$placa,$certificado,$licencia,$fecha_emision,$fecha_traslado);
			echo $rspta ? "Remisión actualizada" : "No se pudieron actualizar todos los datos de la remisión";
		}
	break;

	case 'anular':
		$rspta=$remision->anular($idremision);
 		echo $rspta ? "Remisión anulado" : "Remision no se puede anular";
	break;

	case 'activar':
		$rspta=$remision->activar($idremision);
 		echo $rspta ? "Remisión activada" : "Remisión no se puede activar";
	break;

	case 'mostrar':
		$rspta=$remision->mostrar($idremision);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idremision
		$id=$_GET['id'];

		$rspta = $remision->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
				<th>Opciones</th>
				<th>Artículo</th>
				<th>Cantidad</th>
				<th>Peso por unidad</th>
				<th>Subtotal</th>
				</thead>';

		while ($reg = $rspta->fetch_object())
		{
			echo '
			<tr class="filas">
				<td></td>
				<td>'.$reg->nombre.'</td>
				<td>'.$reg->cantidad.'</td>
				<td>'.$reg->precio_compra.'</td>
				<td>'.$reg->precio_compra*$reg->cantidad.'</td>
				<td><button type="button" class="btn btn-info" disabled><i class="fa fa-refresh"></i></button></td>
			</tr>';
			$total=$total+($reg->precio_compra*$reg->cantidad);
		}
		echo '
			<tfoot>
			  <th>TOTAL</th>
			  <th></th>
			  <th></th>
			  <th></th>
			  <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_compra" id="total_compra"></th>
			</tfoot>';
	break;

	case 'listar':
		$rspta=$remision->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
			if($reg->tipo_comprobante=='Ticket'){
				$url='../reportes/exTicketRemision.php?id=';
			}
			else{
				$url='../reportes/exRemision.php?id=';
			}
 			$data[]=array(
				"0"=>(($reg->estado=='Aceptado')?'<button class="btn btn-warning" style="margin-right: 3px; margin-bottom: 5px; margin-top: 5px" onclick="mostrar('.$reg->idremision.')"><strong>Ver productos</strong></button>'.
				(($_SESSION['rol']=='Administrador')?('<button class="btn btn-warning" style="margin-right: 3px" onclick="mostrar2('.$reg->idremision.')"><i class="fa fa-pencil"></i></button>'):'').
				'<button class="btn btn-danger" style="margin-right: 3px;" onclick="anular('.$reg->idremision.')"><i class="fa fa-close"></i></button>'.
				(($_SESSION['rol']=='Administrador')?('<button class="btn btn-danger" onclick="eliminar('.$reg->idremision.')"><i class="fa fa-trash"></i></button>'):'').
				'<a target="_blank" href="'.$url.$reg->idremision.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>':
				'<button class="btn btn-warning" style="margin-right: 3px; margin-bottom: 5px; margin-top: 5px" onclick="mostrar('.$reg->idremision.')"><strong>Ver productos</strong></button>'.
				(($_SESSION['rol']=='Administrador')?('<button class="btn btn-danger" onclick="eliminar('.$reg->idremision.')"><i class="fa fa-trash"></i></button>'):'')),
			    "1"=>$reg->fecha_emision,
 				"2"=>$reg->tipo_comprobante == "Remision" ? "Remisión" : "Ticket",
 				"3"=>$reg->correlativo.'-'.$reg->num_remision,
 				"4"=>$reg->tipo_documento == "DNI" ? "DNI" : "RUC",
 				"5"=>$reg->num_documento,
 				"6"=>$reg->razonsocial,
 				"7"=>"<nav>S/. $reg->total_compra</nav>",
 				"8"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>',
			);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'listarArticulos':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivos();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" data-idarticulo="'.$reg->idarticulo.'" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\'); disableButton(this);"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->categoria,
 				"3"=>$reg->codigo,
 				"4"=>$reg->stock,
				"5"=>$reg->medida,
				"6"=>$reg->cubicaje,
 				"7"=>$reg->material,
 				"8"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >",
				"9"=>($reg->stock!='0')?'<span class="label bg-green">Disponible</span>':
 				'<span class="label bg-red">agotado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

	case 'eliminar':
		$rspta=$remision->eliminar($idremision);
		echo $rspta ? "Remisión eliminado" : "Remisión no se puede eliminar";
	break;

	case 'selectPersonas':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listar();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . " - " . $reg->tipo_persona . '</option>';
				}
	break;
}
//Fin de las validaciones de acceso
}
else
{
  require 'noacceso.php';
}
}
ob_end_flush();
