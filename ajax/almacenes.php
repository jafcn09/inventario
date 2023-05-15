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
require_once "../modelos/Almacenes.php";

$almacen=new Almacenes();

$idalmacen=isset($_POST["idalmacen"])? limpiarCadena($_POST["idalmacen"]):"";
$ubicacion=isset($_POST["ubicacion"])? limpiarCadena($_POST["ubicacion"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idalmacen)){
			$almacenExiste = $almacen->verificarAlmacenExiste($ubicacion);
			if ($almacenExiste) {
				echo "La ubicación que ha ingresado ya existe.";
			} else {
				$rspta=$almacen->insertar($ubicacion,$descripcion);
				echo $rspta ? "Almacen registrado" : "El almacen no se pudo registrar";
			}
		}
		else {
			$rspta=$almacen->editar($idalmacen,$ubicacion,$descripcion);
			echo $rspta ? "Almacen actualizado" : "El almacen no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$almacen->desactivar($idalmacen);
 		echo $rspta ? "Almacen desactivado" : "El almacen no se pudo desactivar";
	break;

	case 'activar':
		$rspta=$almacen->activar($idalmacen);
 		echo $rspta ? "Almacen activado" : "El almacen no se pudo activar";
	break;

	case 'mostrar':
		$rspta=$almacen->mostrar($idalmacen);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$almacen->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado=='Activado')?(($_SESSION['rol']=='Administrador')?('<button class="btn btn-warning" style="margin-right: 3px;" onclick="mostrar('.$reg->idalmacen.')"><i class="fa fa-pencil"></i></button>'):'').
 					'<button class="btn btn-danger" onclick="desactivar('.$reg->idalmacen.')"><i class="fa fa-close"></i></button>':
 					(($_SESSION['rol']=='Administrador')?('<button class="btn btn-warning" style="margin-right: 3px;" onclick="mostrar('.$reg->idalmacen.')"><i class="fa fa-pencil"></i></button>'):'').
 					'<button class="btn btn-success" onclick="activar('.$reg->idalmacen.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->ubicacion,
 				"2"=>$reg->descripcion,
 				"3"=>($reg->estado=='Activado')?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

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
