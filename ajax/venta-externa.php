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
if ($_SESSION['almacen']==1)
{	
require_once "../modelos/Venta-externa.php";

$ventaexterna=new VentaExterna();

$idventaexterna=isset($_POST["idventaexterna"])? limpiarCadena($_POST["idventaexterna"]):"";
$idusuario=$_SESSION["idusuario"];
$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$correo=isset($_POST["correo"])? limpiarCadena($_POST["correo"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idventaexterna)){
			$rspta=$ventaexterna->insertar($idusuario,$idarticulo,$telefono,$correo,$descripcion);
			echo $rspta ? "Publicación registrada" : "La publicación no se pudo registrar";
		}
		else {
			$rspta=$ventaexterna->editar($idventaexterna,$idarticulo,$telefono,$correo,$descripcion);
			echo $rspta ? "Publicación actualizada" : "La publicación no se pudo actualizar";
		}
	break;

    case 'mostrar':
		$rspta=$ventaexterna->mostrar($idventaexterna);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'eliminar':
		$rspta=$ventaexterna->eliminar($idventaexterna);
		echo $rspta ? "Publicación eliminada" : "La publicación no se puede eliminar";
	break;

	case 'listar':
		$rspta=$ventaexterna->listar($idusuario);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				"0"=>(($reg->estado=='Activado')?
					 '<button class="btn btn-warning" style="margin-right: 3px;" onclick="mostrar('.$reg->idventaexterna.')"><i class="fa fa-pencil"></i></button>'.
                     '<button class="btn btn-danger" style="margin-right: 3px;" onclick="desactivar('.$reg->idventaexterna.')"><i class="fa fa-close"></i></button>'.
                     '<button class="btn btn-danger" onclick="eliminar('.$reg->idventaexterna.')"><i class="fa fa-trash"></i></button>':
                     '<button class="btn btn-success" style="margin-right: 3px; width: 36px; padding: 6px;" onclick="activar('.$reg->idventaexterna.')"><i class="fa fa-check"></i></button>'.
					 '<button class="btn btn-danger" onclick="eliminar('.$reg->idventaexterna.')"><i class="fa fa-trash"></i></button>'),
				"1"=>$reg->usuario,
				"2"=>$reg->articulo,
				"3"=>$reg->categoria,
				"4"=>$reg->almacen,
				"5"=>"S/ ".$reg->precio,
 				"6"=>$reg->correo,
 				"7"=>$reg->telefono,
 				"8"=>$reg->fecha,
 				"9"=>($reg->estado=='Activado')?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
                "10"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'listarventaexternaAdmin':
		$rspta=$ventaexterna->listarventaexternaAdmin();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				"0"=>(($reg->estado=='Activado')?'<button class="btn btn-warning" style="margin-right: 3px;" onclick="mostrar('.$reg->idventaexterna.')"><i class="fa fa-pencil"></i></button>'.
                     '<button class="btn btn-danger" style="margin-right: 3px;" onclick="desactivar('.$reg->idventaexterna.')"><i class="fa fa-close"></i></button>'.
                     '<button class="btn btn-danger" onclick="eliminar('.$reg->idventaexterna.')"><i class="fa fa-trash"></i></button>':
                     '<button class="btn btn-success" style="margin-right: 3px; width: 36px; padding: 6px;" onclick="activar('.$reg->idventaexterna.')"><i class="fa fa-check"></i></button>'.
					 '<button class="btn btn-danger" onclick="eliminar('.$reg->idventaexterna.')"><i class="fa fa-trash"></i></button>'),
				"1"=>$reg->usuario,
				"2"=>$reg->articulo,
				"3"=>$reg->categoria,
				"4"=>$reg->almacen,
				"5"=>"S/ ".$reg->precio,
 				"6"=>$reg->correo,
 				"7"=>$reg->telefono,
 				"8"=>$reg->fecha,
 				"9"=>($reg->estado=='Activado')?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
                "10"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

    case 'desactivar':
		$rspta=$ventaexterna->desactivar($idventaexterna);
 		echo $rspta ? "Publicación Desactivada" : "La publicación no se puede desactivar";
	break;

	case 'activar':
		$rspta=$ventaexterna->activar($idventaexterna);
 		echo $rspta ? "Publicación activada" : "La publicación no se puede activar";
	break;

	case "selectArticulo":
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();

		$rspta = $articulo->selectarticuloexterno($idusuario);

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idarticulo . '>' . $reg->nombre . " - S/. " . $reg->descripcion . '</option>';
				}
	break;

	case "selectArticuloGeneral":
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();

		$rspta = $articulo->selectarticuloexternoGeneral();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idarticulo . '>' . $reg->nombre . " - S/. " . $reg->descripcion . '</option>';
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
?>