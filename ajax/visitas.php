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
if ($_SESSION['visitas']==1)
{
require_once "../modelos/Visitas.php";

$visitas=new Visitas();

// idvisitas
// idusuario
// nombres
// fecha_entrada
// fecha_salida
// tipo_documento
// num_documento
// motivo

$idvisitas=isset($_POST["idvisitas"])? limpiarCadena($_POST["idvisitas"]):"";
$idusuario=$_SESSION["idusuario"];
$nombres=isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
$fecha_entrada=isset($_POST["fecha_entrada"])? limpiarCadena($_POST["fecha_entrada"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$motivo=isset($_POST["motivo"])? limpiarCadena($_POST["motivo"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idvisitas)){
			$rspta=$visitas->insertar($idusuario,$nombres,$fecha_entrada,$tipo_documento,$num_documento,$motivo);
			echo $rspta ? "Registro de visita registrada" : "No se pudieron registrar todos los datos del registro de visita";
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$visitas->anular($idvisitas);
 		echo $rspta ? "Registro de visita anulada" : "Registro de visita no se puede anular";
	break;

	case 'mostrar':
		$rspta=$visitas->mostrar($idvisitas);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$visitas->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){

 			$data[]=array(
				"0"=>(($reg->estado=='Ingresado')?
					'<button class="btn btn-danger" style="margin-right: 3px;" onclick="anular('.$reg->idvisitas.')"><i class="fa fa-sign-out"></i></button>'.
					'<button class="btn btn-warning" style="margin-right: 3px;" onclick="mostrar('.$reg->idvisitas.')"><i class="fa fa-eye"></i></button>'.
					(($_SESSION['rol']=='Administrador')?('<button class="btn btn-danger" style="margin-right: 3px;" onclick="eliminar('.$reg->idvisitas.')"><i class="fa fa-trash"></i></button>'):''):
					'<button class="btn btn-warning" style="margin-right: 3px;" onclick="mostrar('.$reg->idvisitas.')"><i class="fa fa-eye"></i></button>'.
					(($_SESSION['rol']=='Administrador')?('<button class="btn btn-danger" style="margin-right: 3px;" onclick="eliminar('.$reg->idvisitas.')"><i class="fa fa-trash"></i></button>'):'')),
                "1"=>$reg->nombres,
                "2"=>$reg->tipo_documento,
                "3"=>$reg->num_documento,
                "4"=>$reg->fecha_entrada,
                "5"=>$reg->fecha_salida,
				"6"=>($reg->estado=='Ingresado')?'<span class="label bg-green">Ingresado</span>':
 				'<span class="label bg-red">Finalizado</span>'
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
		$rspta=$visitas->eliminar($idvisitas);
		echo $rspta ? "Registro de visita eliminada" : "Registro de visita no se puede eliminar";
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