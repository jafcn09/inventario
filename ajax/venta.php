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
if ($_SESSION['ventas']==1)
{
require_once "../modelos/Venta.php";

$venta=new Venta();

// idventa
// idcliente
// idusuario
// num_remision
// correlativo
// fecha_hora
// tipo_comprobante
// serie_comprobante
// num_comprobante
// impuesto
// total_venta

$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idusuario=$_SESSION["idusuario"];
$num_remision=isset($_POST["num_remision"])? limpiarCadena($_POST["num_remision"]):"";
$correlativo=isset($_POST["correlativo"])? limpiarCadena($_POST["correlativo"]):"";
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idventa)){
			$numeroExiste = $venta->verificarNumeroExiste($num_comprobante);
			if ($numeroExiste) {
				echo "El número de comprobante que ha ingresado ya existe.";
			} else {
				$rspta=$venta->insertar($idcliente,$idusuario,$num_remision,$correlativo,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"]);
				echo $rspta ? "Venta registrada" : "Uno de las cantidades superan al stock del artículo.";
			}
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$venta->anular($idventa);
 		echo $rspta ? "Venta anulada" : "Venta no se puede anular";
	break;

	case 'activar':
		$rspta=$venta->activar($idventa);
 		echo $rspta ? "Venta activada" : "Venta no se puede activar";
	break;

	case 'mostrar':
		$rspta=$venta->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idventa
		$id=$_GET['id'];

		$rspta = $venta->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
								</thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->precio_venta.'</td><td>'.$reg->descuento.'</td><td>'.$reg->subtotal.'</td></tr>';
					$total=$total+($reg->precio_venta*$reg->cantidad-$reg->descuento);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$rspta=$venta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			if($reg->tipo_comprobante=='Ticket'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFactura.php?id=';
 			}

 			$data[]=array(
			   "0"=>(($reg->estado=='Aceptado')?'<button class="btn btn-warning" style="margin-right: 3px; margin-bottom: 5px; margin-top: 5px" onclick="mostrar('.$reg->idventa.')"><strong>Ver productos</strong></button>'.
				   '<button class="btn btn-danger" style="margin-right: 3px;" onclick="anular('.$reg->idventa.')"><i class="fa fa-close"></i></button>'.
				   (($_SESSION['rol']=='Administrador')?('<button class="btn btn-danger" onclick="eliminar('.$reg->idventa.')"><i class="fa fa-trash"></i></button>'):'').
				   '<a target="_blank" href="'.$url.$reg->idventa.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>':
				   '<button class="btn btn-warning" style="margin-right: 3px; margin-bottom: 5px; margin-top: 5px" onclick="mostrar('.$reg->idventa.')"><strong>Ver productos</strong></button>'.
				   (($_SESSION['rol']=='Administrador')?('<button class="btn btn-danger" onclick="eliminar('.$reg->idventa.')"><i class="fa fa-trash"></i></button>'):'')),
			   "1"=>$reg->fecha,
			   "2"=>$reg->cliente,
			   "3"=>$reg->usuario,
			   "4"=>$reg->tipo_comprobante,
			   "5"=>$reg->serie_comprobante.'-'.$reg->num_comprobante,
			   "6"=>"<nav>S/. $reg->total_venta</nav>",
			   "7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
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

	case 'selectCliente':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarC();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
				}
	break;

	case 'listarArticulosVenta':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosVenta();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				"0"=>($reg->stock!='0')?'<button class="btn btn-warning" data-idarticulo="'.$reg->idarticulo.'" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\',\''.$reg->precio_venta.'\'); disableButton(this);"><span class="fa fa-plus"></span></button>':'',
				"1"=>$reg->nombre,
				"2"=>$reg->categoria,
 				"3"=>$reg->codigo,
 				"4"=>$reg->stock,
				"5"=>$reg->medida,
				"6"=>$reg->cubicaje,
 				"7"=>$reg->material,
 				"8"=>$reg->precio_venta == '' ? "0.00" : $reg->precio_venta,
 				"9"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >",
				"10"=>($reg->stock!='0')?'<span class="label bg-green">Disponible</span>':
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
		$rspta=$venta->eliminar($idventa);
		echo $rspta ? "Venta eliminada" : "Venta no se puede eliminar";
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
?>