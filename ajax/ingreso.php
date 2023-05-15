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
if ($_SESSION['compras']==1)
{

require_once "../modelos/Ingreso.php";

$ingreso=new Ingreso();

$idusuario=$_SESSION["idusuario"];

$idingreso=isset($_POST["idingreso"])? limpiarCadena($_POST["idingreso"]):"";
$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_compra=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idingreso)){
			$numeroExiste = $ingreso->verificarNumeroExiste($num_comprobante);
			if ($numeroExiste) {
				echo "El número de comprobante que ha ingresado ya existe.";
			} else {
				$rspta=$ingreso->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"],$_POST["precio_venta"]);
				echo $rspta ? "Ingreso registrado" : "No se pudieron registrar todos los datos del ingreso";
			}
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$ingreso->anular($idingreso);
 		echo $rspta ? "Ingreso anulado" : "Ingreso no se puede anular";
	break;

	case 'activar':
		$rspta=$ingreso->activar($idingreso);
 		echo $rspta ? "Ingreso activado" : "Ingreso no se puede activar";
	break;

	case 'mostrar':
		$rspta=$ingreso->mostrar($idingreso);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $ingreso->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
				<th>Opciones</th>
				<th>Artículo</th>
				<th>Cantidad</th>
				<th>Precio Compra</th>
				<th>Precio Venta</th>
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
				<td>'.$reg->precio_venta.'</td>
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
			  <th></th>
			  <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_compra" id="total_compra"></th>
			</tfoot>';
	break;

	case 'listar':
		$rspta=$ingreso->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
			if($reg->tipo_comprobante=='Ticket'){
				$url='../reportes/exTicketIngreso.php?id=';
			}
			else{
				$url='../reportes/exIngreso.php?id=';
			}
			$data[]=array(
				"0"=>(($reg->estado=='Aceptado')?'<button class="btn btn-warning" style="margin-right: 3px; margin-bottom: 5px; margin-top: 5px" onclick="mostrar('.$reg->idingreso.')"><strong>Ver productos</strong></button>'.
					'<button class="btn btn-danger" style="margin-right: 3px;" onclick="anular('.$reg->idingreso.')"><i class="fa fa-close"></i></button>'.
					(($_SESSION['rol']=='Administrador')?('<button class="btn btn-danger" onclick="eliminar('.$reg->idingreso.')"><i class="fa fa-trash"></i></button>'):'').
				   	'<a target="_blank" href="'.$url.$reg->idingreso.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>':
					'<button class="btn btn-warning" style="margin-right: 3px; margin-bottom: 5px; margin-top: 5px" onclick="mostrar('.$reg->idingreso.')"><strong>Ver productos</strong></button>'.
				    (($_SESSION['rol']=='Administrador')?('<button class="btn btn-danger" onclick="eliminar('.$reg->idingreso.')"><i class="fa fa-trash"></i></button>'):'')),
				"1"=>$reg->fecha,
				"2"=>$reg->proveedor,
				"3"=>$reg->tipo_comprobante,
				"4"=>$reg->serie_comprobante.'-'.$reg->num_comprobante,
				"5"=>"<nav>S/. $reg->total_compra</nav>",
				"6"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
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

	case 'selectProveedor':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarP();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
				}
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
		$rspta=$ingreso->eliminar($idingreso);
		echo $rspta ? "Ingreso eliminado" : "Ingreso no se puede eliminar";
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
