<?php
ob_start();
if (strlen(session_id()) < 1) {
	session_start(); //Validamos si existe o no la sesión
}
require_once "../modelos/Usuario.php";

$usuario = new Usuario();

$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$cargo = isset($_POST["cargo"]) ? limpiarCadena($_POST["cargo"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$rol = isset($_POST["rol"]) ? limpiarCadena($_POST["rol"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (!isset($_SESSION["nombre"])) {
			header("Location: ../vistas/login.html"); //Validamos el acceso solo a los usuarios logueados al sistema.
		} else {
			//Validamos el acceso solo al usuario logueado y autorizado.
			if ($_SESSION['almacen'] == 1) {
				if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
					$imagen = $_POST["imagenactual"];
				} else {
					$ext = explode(".", $_FILES["imagen"]["name"]);
					if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
						$imagen = round(microtime(true)) . '.' . end($ext);
						move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
					}
				}

				if (empty($idusuario)) {
					$nombreExiste = $usuario->verificarNombreExiste($nombre);
					$dniExiste = $usuario->verificarDniExiste($num_documento);
					$emailExiste = $usuario->verificarEmailExiste($email);
					$usuarioExiste = $usuario->verificarUsuarioExiste($login);
					if ($nombreExiste) {
						echo "El nombre que ha ingresado ya existe.";
					} else if ($dniExiste) {
						echo "El número de documento que ha ingresado ya existe.";
					} else if ($emailExiste) {
						echo "El email que ha ingresado ya existe.";
					} else if ($usuarioExiste) {
						echo "El nombre del usuario que ha ingresado ya existe.";
					} else {
						$rspta = $usuario->insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $rol, $imagen, $_POST['permiso']);
						echo $rspta ? "Usuario registrado" : "Usuario no se pudo registrar";
					}
				} else {
					$rspta = $usuario->editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $rol, $imagen, $_POST['permiso']);
					echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
				}
				//Fin de las validaciones de acceso
			} else {
				require 'noacceso.php';
			}
		}
		break;

	case 'desactivar':
		if (!isset($_SESSION["nombre"])) {
			header("Location: ../vistas/login.html"); //Validamos el acceso solo a los usuarios logueados al sistema.
		} else {
			//Validamos el acceso solo al usuario logueado y autorizado.
			if ($_SESSION['almacen'] == 1) {
				$rspta = $usuario->desactivar($idusuario);
				echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
				//Fin de las validaciones de acceso
			} else {
				require 'noacceso.php';
			}
		}
		break;

	case 'activar':
		if (!isset($_SESSION["nombre"])) {
			header("Location: ../vistas/login.html"); //Validamos el acceso solo a los usuarios logueados al sistema.
		} else {
			//Validamos el acceso solo al usuario logueado y autorizado.
			if ($_SESSION['almacen'] == 1) {
				$rspta = $usuario->activar($idusuario);
				echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
				//Fin de las validaciones de acceso
			} else {
				require 'noacceso.php';
			}
		}
		break;

	case 'eliminar':
		$rspta = $usuario->eliminar($idusuario);
		echo $rspta ? "Usuario eliminado" : "Usuario no se puede eliminar";
		break;

	case 'mostrar':
		if (!isset($_SESSION["nombre"])) {
			header("Location: ../vistas/login.html"); //Validamos el acceso solo a los usuarios logueados al sistema.
		} else {
			//Validamos el acceso solo al usuario logueado y autorizado.
			if ($_SESSION['almacen'] == 1) {
				$rspta = $usuario->mostrar($idusuario);
				//Codificar el resultado utilizando json
				echo json_encode($rspta);
				//Fin de las validaciones de acceso
			} else {
				require 'noacceso.php';
			}
		}
		break;

	case 'listar':
		if (!isset($_SESSION["nombre"])) {
			header("Location: ../vistas/login.html"); //Validamos el acceso solo a los usuarios logueados al sistema.
		} else {
			//Validamos el acceso solo al usuario logueado y autorizado.
			if ($_SESSION['almacen'] == 1) {
				$rspta = $usuario->listar();
				//Vamos a declarar un array
				$data = array();

				while ($reg = $rspta->fetch_object()) {
					$data[] = array(
						"0" => ($reg->condicion) ? (($_SESSION['rol'] == 'Administrador') ? ('<button class="btn btn-warning" style="margin-right: 4px" onclick="mostrar(' . $reg->idusuario . ')"><i class="fa fa-pencil"></i></button>') : '') .
							(($_SESSION['rol'] == 'Administrador') ? ('<button class="btn btn-danger" style="margin-right: 4px;" onclick="eliminar(' . $reg->idusuario . ')"><i class="fa fa-trash"></i></button>') : '') .
							'<button class="btn btn-danger" onclick="desactivar(' . $reg->idusuario . ')"><i class="fa fa-close"></i></button>' : (($_SESSION['rol'] == 'Administrador') ? ('<button class="btn btn-warning" style="margin-right: 4px" onclick="mostrar(' . $reg->idusuario . ')"><i class="fa fa-pencil"></i></button>') : '') .
							'<button class="btn btn-primary" onclick="activar(' . $reg->idusuario . ')"><i class="fa fa-check"></i></button>',
						"1" => $reg->rol,
						"2" => $reg->nombre,
						"3" => $reg->tipo_documento,
						"4" => $reg->num_documento,
						"5" => $reg->telefono,
						"6" => $reg->email,
						"7" => $reg->login,
						"8" => "<img src='../files/usuarios/" . $reg->imagen . "' height='50px' width='50px' >",
						"9" => ($reg->condicion) ? '<span class="label bg-green">Activado</span>' :
							'<span class="label bg-red">Desactivado</span>'
					);
				}
				$results = array(
					"sEcho" => 1, //Información para el datatables
					"iTotalRecords" => count($data), //enviamos el total registros al datatable
					"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
					"aaData" => $data
				);
				echo json_encode($results);
				//Fin de las validaciones de acceso
			} else {
				require 'noacceso.php';
			}
		}
		break;

	case 'permisos':
		//Obtenemos todos los permisos de la tabla permisos
		require_once "../modelos/Permiso.php";
		$permiso = new Permiso();
		$rspta = $permiso->listar();

		//Obtener los permisos asignados al usuario
		$id = $_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		//Declaramos el array para almacenar todos los permisos marcados
		$valores = array();

		//Almacenar los permisos asignados al usuario en el array
		while ($per = $marcados->fetch_object()) {
			array_push($valores, $per->idpermiso);
		}

		//Mostramos la lista de permisos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object()) {
			$sw = in_array($reg->idpermiso, $valores) ? 'checked' : '';
			echo '<li> <input type="checkbox" ' . $sw . '  name="permiso[]" value="' . $reg->idpermiso . '">' . $reg->nombre . '</li>';
		}
		break;

	case 'verificar':
		$logina = $_POST['logina'];
		$clavea = $_POST['clavea'];

		$rspta = $usuario->verificar($logina, $clavea);

		$fetch = $rspta->fetch_object();

		if (isset($fetch)) {
			//Declaramos las variables de sesión
			$_SESSION['idusuario'] = $fetch->idusuario;
			$_SESSION['nombre'] = $fetch->nombre;
			$_SESSION['imagen'] = $fetch->imagen;
			$_SESSION['login'] = $fetch->login;
			$_SESSION['clave'] = $fetch->clave;
			$_SESSION['rol'] = $fetch->rol;

			//Obtenemos los permisos del usuario
			$marcados = $usuario->listarmarcados($fetch->idusuario);

			//Declaramos el array para almacenar todos los permisos marcados
			$valores = array();

			//Almacenamos los permisos marcados en el array
			while ($per = $marcados->fetch_object()) {
				array_push($valores, $per->idpermiso);
			}

			//Determinamos los accesos del usuario
			in_array(1, $valores) ? $_SESSION['escritorio'] = 1 : $_SESSION['escritorio'] = 0;
			in_array(2, $valores) ? $_SESSION['almacen'] = 1 : $_SESSION['almacen'] = 0;
			in_array(3, $valores) ? $_SESSION['compras'] = 1 : $_SESSION['compras'] = 0;
			in_array(4, $valores) ? $_SESSION['ventas'] = 1 : $_SESSION['ventas'] = 0;
			in_array(5, $valores) ? $_SESSION['acceso'] = 1 : $_SESSION['acceso'] = 0;
			in_array(6, $valores) ? $_SESSION['consultac'] = 1 : $_SESSION['consultac'] = 0;
			in_array(7, $valores) ? $_SESSION['consultav'] = 1 : $_SESSION['consultav'] = 0;
			in_array(8, $valores) ? $_SESSION['remision'] = 1 : $_SESSION['remision'] = 0;
			in_array(9, $valores) ? $_SESSION['visitas'] = 1 : $_SESSION['visitas'] = 0;
			in_array(10, $valores) ? $_SESSION['ayuda'] = 1 : $_SESSION['ayuda'] = 0;
			in_array(11, $valores) ? $_SESSION['acerca'] = 1 : $_SESSION['acerca'] = 0;
			in_array(12, $valores) ? $_SESSION['controlv'] = 1 : $_SESSION['controlv'] = 0;
			in_array(13, $valores) ? $_SESSION['perfilu'] = 1 : $_SESSION['perfilu'] = 0;
		}
		echo json_encode($fetch);
		break;

	case 'salir':
		//Limpiamos las variables de sesión   
		session_unset();
		//Destruìmos la sesión
		session_destroy();
		//Redireccionamos al login
		header("Location: ../index.php");

		break;
}
ob_end_flush();
