<?php
ob_start();
if (strlen(session_id()) < 1) {
	session_start(); //Validamos si existe o no la sesión
}
if (!isset($_SESSION["nombre"])) {
	header("Location: ../vistas/login.html"); //Validamos el acceso solo a los usuarios logueados al sistema.
} else {
	//Validamos el acceso solo al usuario logueado y autorizado.
	if ($_SESSION['perfilu'] == 1) {
		require_once "../modelos/Perfiles.php";

		$perfil = new Perfiles();

		$serie_comprobante1 = isset($_POST["serie_comprobante1"]) ? limpiarCadena($_POST["serie_comprobante1"]) : "";
		$num_comprobante1 = isset($_POST["num_comprobante1"]) ? limpiarCadena($_POST["num_comprobante1"]) : "";

		$serie_comprobante2 = isset($_POST["serie_comprobante2"]) ? limpiarCadena($_POST["serie_comprobante2"]) : "";
		$num_comprobante2 = isset($_POST["num_comprobante2"]) ? limpiarCadena($_POST["num_comprobante2"]) : "";

		$serie_comprobante3 = isset($_POST["serie_comprobante3"]) ? limpiarCadena($_POST["serie_comprobante3"]) : "";
		$num_comprobante3 = isset($_POST["num_comprobante3"]) ? limpiarCadena($_POST["num_comprobante3"]) : "";

		switch ($_GET["op"]) {
			case 'guardaryeditar1':
				$numCompExiste1 = $perfil->verificarNumComprobante1($num_comprobante1);
				if ($numCompExiste1) {
					echo "El número de comprobante que ha ingresado ya existe.";
				} else {
					$rspta = $perfil->actualizarComprobante1($serie_comprobante1, $num_comprobante1);
					echo $rspta ? "Serie y N° de comprobante actualizado correctamente en el submódulo de compras." : "Serie y N° de comprobante no se pudo actualizar.";
				}
				break;

			case 'guardaryeditar2':
				$numCompExiste2 = $perfil->verificarNumComprobante2($num_comprobante2);
				if ($numCompExiste2) {
					echo "El número de comprobante que ha ingresado ya existe.";
				} else {
					$rspta = $perfil->actualizarComprobante2($serie_comprobante2, $num_comprobante2);
					echo $rspta ? "Serie y N° de comprobante actualizado correctamente en el submódulo de ventas." : "Serie y N° de comprobante no se pudo actualizar.";
				}
				break;

			case 'guardaryeditar3':
				$numCompExiste3 = $perfil->verificarNumComprobante3($num_comprobante3);
				if ($numCompExiste3) {
					echo "El número de comprobante que ha ingresado ya existe.";
				} else {
					$rspta = $perfil->actualizarComprobante3($serie_comprobante3, $num_comprobante3);
					echo $rspta ? "Serie y N° de comprobante actualizado correctamente en el submódulo de remisión." : "Serie y N° de comprobante no se pudo actualizar.";
				}
				break;

			case 'getNumerosSerieComprobantes':
				$row = mysqli_fetch_assoc($perfil->getNumerosSerieComprobantes());
				$num_serie_comprobante1 = $row["num_serie_comprobante1"];
				$num_serie_comprobante2 = $row["num_serie_comprobante2"];
				$num_serie_comprobante3 = $row["num_serie_comprobante3"];

				echo json_encode(array(
					'num_serie_comprobante1' => $num_serie_comprobante1,
					'num_serie_comprobante2' => $num_serie_comprobante2,
					'num_serie_comprobante3' => $num_serie_comprobante3
				));
				break;

			case 'listarCompCompra':

				$rspta = $perfil->listarCompCompra();
				//Vamos a declarar un array
				$data = array();

				while ($reg = $rspta->fetch_object()) {
					$data[] = array(
						"0" => $reg->serie_comprobante,
						"1" => $reg->num_comprobante,
					);
				}
				$results = array(
					"sEcho" => 1, //Información para el datatables
					"iTotalRecords" => count($data), //enviamos el total registros al datatable
					"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
					"aaData" => $data
				);
				echo json_encode($results);

				break;

			case 'listarCompVenta':

				$rspta = $perfil->listarCompVenta();
				//Vamos a declarar un array
				$data = array();

				while ($reg = $rspta->fetch_object()) {
					$data[] = array(
						"0" => $reg->serie_comprobante,
						"1" => $reg->num_comprobante,
					);
				}
				$results = array(
					"sEcho" => 1, //Información para el datatables
					"iTotalRecords" => count($data), //enviamos el total registros al datatable
					"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
					"aaData" => $data
				);
				echo json_encode($results);

				break;

			case 'listarCompRemision':

				$rspta = $perfil->listarCompRemision();
				//Vamos a declarar un array
				$data = array();

				while ($reg = $rspta->fetch_object()) {
					$data[] = array(
						"0" => $reg->correlativo,
						"1" => $reg->num_remision,
					);
				}
				$results = array(
					"sEcho" => 1, //Información para el datatables
					"iTotalRecords" => count($data), //enviamos el total registros al datatable
					"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
					"aaData" => $data
				);
				echo json_encode($results);

				break;
		}
		//Fin de las validaciones de acceso
	} else {
		require 'noacceso.php';
	}
}
ob_end_flush();
