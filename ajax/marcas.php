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
require_once "../modelos/Marcas.php";

$marcas=new Marcas();

$idmarcas=isset($_POST["idmarcas"])? limpiarCadena($_POST["idmarcas"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idmarcas)){
			$marcasExiste = $marcas->verificarMarcasExiste($nombre);
			if ($marcasExiste) {
				echo "El nombre que ha ingresado ya existe.";
			} else {
				$rspta=$marcas->insertar($nombre,$descripcion);
				echo $rspta ? "Marca registrada" : "La marca no se pudo registrar";
			}
		}
		else {
			$rspta=$marcas->editar($idmarcas,$nombre,$descripcion);
			echo $rspta ? "Marca actualizada" : "La marca no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$marcas->desactivar($idmarcas);
 		echo $rspta ? "Marca desactivada" : "La marca no se pudo desactivar";
	break;

	case 'activar':
		$rspta=$marcas->activar($idmarcas);
 		echo $rspta ? "Marca activada" : "La marca no se pudo activar";
	break;

	case 'mostrar':
		$rspta=$marcas->mostrar($idmarcas);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$marcas->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado=='Activado')?(($_SESSION['rol']=='Administrador')?('<button class="btn btn-warning" style="margin-right: 3px;" onclick="mostrar('.$reg->idmarcas.')"><i class="fa fa-pencil"></i></button>'):'').
 					'<button class="btn btn-danger" onclick="desactivar('.$reg->idmarcas.')"><i class="fa fa-close"></i></button>':
 					(($_SESSION['rol']=='Administrador')?('<button class="btn btn-warning" style="margin-right: 3px;" onclick="mostrar('.$reg->idmarcas.')"><i class="fa fa-pencil"></i></button>'):'').
 					'<button class="btn btn-success" onclick="activar('.$reg->idmarcas.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
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
