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

		$portada = new Perfiles();

		$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

		switch ($_GET["op"]) {
			case 'guardaryeditar':
				if ($_SESSION['perfilu'] == 1) {
					if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
						$imagen = $_POST["imagenmuestra"];
					} else {
						$ext = explode(".", $_FILES["imagen"]["name"]);
						if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
							$imagen = round(microtime(true)) . '.' . end($ext);
							move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/portadas/" . $imagen);
						}
					}
					$rspta = $portada->actualizarPortadaLogin($imagen);
					echo $rspta ? "Portada actualizada correctamente." : "Portada no se pudo actualizar.";
				} else {
					require 'noacceso.php';
				}
				break;

			case 'mostrar':
				if ($_SESSION['perfilu'] == 1) {
					$rspta = $portada->obtenerPortadaLogin();
					echo json_encode($rspta);
				} else {
					require 'noacceso.php';
				}
				break;
		}
		//Fin de las validaciones de acceso
	} else {
		require 'noacceso.php';
	}
}
ob_end_flush();
