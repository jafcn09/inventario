<?php
ob_start();
if (strlen(session_id()) < 1) {
	session_start(); //Validamos si existe o no la sesión
}
if (!isset($_SESSION["nombre"])) {
	header("Location: ../vistas/login.html"); //Validamos el acceso solo a los usuarios logueados al sistema.
} else {
	//Validamos el acceso solo al usuario logueado y autorizado.
	if ($_SESSION['almacen'] == 1) {
		require_once "../modelos/Articulo.php";

		$articulo = new Articulo();

		$idarticulo = isset($_POST["idarticulo"]) ? limpiarCadena($_POST["idarticulo"]) : "";
		$idmarcas = isset($_POST["idmarcas"]) ? limpiarCadena($_POST["idmarcas"]) : "";
		$idcategoria = isset($_POST["idcategoria"]) ? limpiarCadena($_POST["idcategoria"]) : "";
		$idusuario = $_SESSION["idusuario"];
		$idalmacen = isset($_POST["idalmacen"]) ? limpiarCadena($_POST["idalmacen"]) : "";
		$codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
		$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
		$stock = isset($_POST["stock"]) ? limpiarCadena($_POST["stock"]) : "";
		$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
		$medida = isset($_POST["medida"]) ? limpiarCadena($_POST["medida"]) : "";
		$cubicaje = isset($_POST["cubicaje"]) ? limpiarCadena($_POST["cubicaje"]) : "";
		$material = isset($_POST["material"]) ? limpiarCadena($_POST["material"]) : "";

		$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

		switch ($_GET["op"]) {
			case 'guardaryeditar':

				if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
					$imagen = $_POST["imagenactual"];
				} else {
					$ext = explode(".", $_FILES["imagen"]["name"]);
					if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
						$imagen = round(microtime(true)) . '.' . end($ext);
						move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $imagen);
					}
				}
				if (empty($idarticulo)) {
					$codigoExiste = $articulo->verificarCodigoExiste($codigo);
					if ($codigoExiste) {
						echo "El código del artículo que ha ingresado ya existe.";
					} else {
						$rspta = $articulo->insertar($idmarcas, $idcategoria, $idusuario, $idalmacen, $codigo, $nombre, $stock, $descripcion, $medida, $cubicaje, $material, $imagen);
						echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";
					}
				} else {
					$rspta = $articulo->editar($idarticulo, $idmarcas, $idcategoria, $idalmacen, $codigo, $nombre, $stock, $descripcion, $medida, $cubicaje, $material, $imagen);
					echo $rspta ? "Artículo actualizado" : "Artículo no se pudo actualizar";
				}
				break;

			case 'desactivar':
				$rspta = $articulo->desactivar($idarticulo);
				echo $rspta ? "Artículo Desactivado" : "Artículo no se puede desactivar";
				break;

			case 'activar':
				$rspta = $articulo->activar($idarticulo);
				echo $rspta ? "Artículo activado" : "Artículo no se puede activar";
				break;

			case 'eliminar':
				$rspta = $articulo->eliminar($idarticulo);
				echo $rspta ? "Artículo eliminado" : "Artículo no se puede eliminar";
				break;

			case 'mostrar':
				$rspta = $articulo->mostrar($idarticulo);
				//Codificar el resultado utilizando json
				echo json_encode($rspta);
				break;

			case 'listar':
				$rspta = $articulo->listar();
				//Vamos a declarar un array
				$data = array();

				while ($reg = $rspta->fetch_object()) {
					$data[] = array(
						"0" => (($_SESSION['rol'] == 'Administrador') ? ('<button class="btn btn-warning" style="margin-right: 3px;" onclick="mostrar(' . $reg->idarticulo . ')"><i class="fa fa-pencil"></i></button>') : '') .
							(($_SESSION['rol'] == 'Administrador') ? ('<button class="btn btn-danger" onclick="eliminar(' . $reg->idarticulo . ')"><i class="fa fa-trash"></i></button>') : ''),
						"1" => $reg->usuario,
						"2" => $reg->nombre,
						"3" => $reg->marcas,
						"4" => $reg->categoria,
						"5" => $reg->almacen,
						"6" => $reg->codigo,
						"7" => $reg->stock,
						"8" => "<nav>S/. $reg->descripcion</nav>",
						"9" => $reg->medida,
						"10" => $reg->cubicaje,
						"11" => $reg->material,
						"12" => "<img src='../files/articulos/" . $reg->imagen . "' height='50px' width='50px' >",
						"13" => ($reg->stock != '0') ? '<span class="label bg-green">Disponible</span>' :
							'<span class="label bg-red">agotado</span>'
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

			case 'listararticuloexternoAdmin':
				$rspta = $articulo->listararticuloexternoAdmin();
				//Vamos a declarar un array
				$data = array();

				while ($reg = $rspta->fetch_object()) {
					$data[] = array(
						"0" => (($_SESSION['rol'] == 'Administrador') ? ('<button class="btn btn-warning" style="margin-right: 3px;" onclick="mostrararticuloexterno(' . $reg->idarticulo . ')"><i class="fa fa-pencil"></i></button>') : '') .
							(($_SESSION['rol'] == 'Administrador') ? ('<button class="btn btn-danger" onclick="eliminararticuloexterno(' . $reg->idarticulo . ')"><i class="fa fa-trash"></i></button>') : ''),
						"1" => $reg->usuario,
						"2" => $reg->nombre,
						"3" => $reg->categoria,
						"4" => $reg->almacen,
						"5" => $reg->codigo,
						"6" => $reg->stock,
						"7" => "<nav>S/. $reg->descripcion</nav>",
						"8" => $reg->medida,
						"9" => $reg->cubicaje,
						"10" => $reg->material,
						"11" => "<img src='../files/articulos/" . $reg->imagen . "' height='50px' width='50px' >"
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

			case "selectMarcas":
				require_once "../modelos/Marcas.php";
				$marcas = new Marcas();

				$rspta = $marcas->select();

				while ($reg = $rspta->fetch_object()) {
					echo '<option value=' . $reg->idmarcas . '>' . $reg->nombre . '</option>';
				}
				break;

			case "selectCategoria":
				require_once "../modelos/Categoria.php";
				$categoria = new Categoria();

				$rspta = $categoria->select();

				while ($reg = $rspta->fetch_object()) {
					echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
				}
				break;

			case "selectAlmacen":
				require_once "../modelos/Almacenes.php";
				$almacen = new Almacenes();

				$rspta = $almacen->select();

				while ($reg = $rspta->fetch_object()) {
					echo '<option value=' . $reg->idalmacen . '>' . $reg->ubicacion . '</option>';
				}
				break;

				// Artículos externos

			case 'guardaryeditararticuloexterno':

				if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
					$imagen = $_POST["imagenactual"];
				} else {
					$ext = explode(".", $_FILES["imagen"]["name"]);
					if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
						$imagen = round(microtime(true)) . '.' . end($ext);
						move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $imagen);
					}
				}
				if (empty($idarticulo)) {
					$rspta = $articulo->insertararticuloexterno($idcategoria, $idusuario, $idalmacen, $codigo, $nombre, $stock, $descripcion, $medida, $cubicaje, $material, $imagen);
					echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";
				} else {
					$rspta = $articulo->editararticuloexterno($idarticulo, $idcategoria, $idalmacen, $codigo, $nombre, $stock, $descripcion, $medida, $cubicaje, $material, $imagen);
					echo $rspta ? "Artículo actualizado" : "Artículo no se pudo actualizar";
				}
				break;

			case 'listararticuloexterno':
				$rspta = $articulo->listararticuloexterno($idusuario);
				//Vamos a declarar un array
				$data = array();

				while ($reg = $rspta->fetch_object()) {
					$data[] = array(
						"0" => '<button class="btn btn-warning" style="margin-right: 3px;" onclick="mostrararticuloexterno(' . $reg->idarticulo . ')"><i class="fa fa-pencil"></i></button>' .
							'<button class="btn btn-danger" onclick="eliminararticuloexterno(' . $reg->idarticulo . ')"><i class="fa fa-trash"></i></button>',
						"1" => $reg->usuario,
						"2" => $reg->nombre,
						"3" => $reg->categoria,
						"4" => $reg->almacen,
						"5" => $reg->codigo,
						"6" => $reg->stock,
						"7" => "<nav>S/. $reg->descripcion</nav>",
						"8" => $reg->medida,
						"9" => $reg->cubicaje,
						"10" => $reg->material,
						"11" => "<img src='../files/articulos/" . $reg->imagen . "' height='50px' width='50px' >"
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

			case 'desactivararticuloexterno':
				$rspta = $articulo->desactivararticuloexterno($idarticulo);
				echo $rspta ? "Artículo Desactivado" : "Artículo no se puede desactivar";
				break;

			case 'activararticuloexterno':
				$rspta = $articulo->activararticuloexterno($idarticulo);
				echo $rspta ? "Artículo activado" : "Artículo no se puede activar";
				break;

			case 'eliminararticuloexterno':
				$rspta = $articulo->eliminararticuloexterno($idarticulo);
				echo $rspta ? "Artículo eliminado" : "Artículo no se puede eliminar";
				break;

			case 'mostrararticuloexterno':
				$rspta = $articulo->mostrararticuloexterno($idarticulo);
				//Codificar el resultado utilizando json
				echo json_encode($rspta);
				break;
		}
		//Fin de las validaciones de acceso
	} else {
		require 'noacceso.php';
	}
}
ob_end_flush();
