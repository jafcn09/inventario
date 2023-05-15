<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Remision
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	//Implementamos un método para insertar registros
	public function insertar($idusuario, $num_remision, $correlativo, $tipo_comprobante, $domicilio_partida, $domicilio_llegada, $razonsocial, $tipo_documento, $num_documento, $marca, $placa, $certificado, $licencia, $fecha_emision, $fecha_traslado, $total_compra, $idarticulo, $cantidad, $precio_compra)
	{
		$sql = "INSERT INTO remision (idusuario,num_remision,correlativo,tipo_comprobante,domicilio_partida,domicilio_llegada,razonsocial,tipo_documento,num_documento,marca,placa,certificado,licencia,fecha_emision,fecha_traslado,total_compra,estado) 
		VALUES ('$idusuario','$num_remision','$correlativo','$tipo_comprobante','$domicilio_partida','$domicilio_llegada','$razonsocial','$tipo_documento','$num_documento','$marca','$placa','$certificado','$licencia','$fecha_emision','$fecha_traslado','$total_compra','Aceptado')";
		//return ejecutarConsulta($sql);

		$idremisionnew = ejecutarConsulta_retornarID($sql);

		$num_elementos = 0;
		$sw = true;

		while ($num_elementos < count($idarticulo)) {
			$sql_detalle = "INSERT INTO detalle_remision(idremision, idarticulo,cantidad, precio_compra) VALUES ('$idremisionnew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos = $num_elementos + 1;
		}

		// Obtenemos el número de comprobante sin el prefijo "FQ"
		$num_comprobante_sin_prefijo = substr($num_remision, 2);

		// Sumamos 1 al número de comprobante
		$num_comprobante_nuevo = intval($num_comprobante_sin_prefijo) + 1;

		// Convertimos el número de comprobante nuevo en una cadena de texto y agregarle el prefijo "FQ"
		$num_comprobante_nuevo_con_prefijo = "FQ" . str_pad($num_comprobante_nuevo, 3, "0", STR_PAD_LEFT);

		// Y por último actualizamos el número de comprobante en la tabla perfil_usuario
		$this->actualizarComprobante($num_remision, $num_comprobante_nuevo_con_prefijo);

		return $sw;
	}

	public function actualizarComprobante($serie_comprobante, $num_comprobante_nuevo_con_prefijo)
	{
		$sql = "UPDATE perfil_usuario SET serie_comprobante='$serie_comprobante',num_comprobante='$num_comprobante_nuevo_con_prefijo' WHERE id_perfilusuario=1";
		return ejecutarConsulta($sql);
	}

	public function verificarNumeroExiste($correlativo)
	{
		$sql = "SELECT * FROM remision WHERE correlativo = '$correlativo'";
		$resultado = ejecutarConsulta($sql);
		if (mysqli_num_rows($resultado) > 0) {
			// El número ya existe en la tabla
			return true;
		}
		// El número no existe en la tabla
		return false;
	}

	//Implementamos un método para editar registros
	public function editar($idremision, $num_remision, $correlativo, $tipo_comprobante, $domicilio_partida, $domicilio_llegada, $razonsocial, $tipo_documento, $num_documento, $marca, $placa, $certificado, $licencia, $fecha_emision, $fecha_traslado)
	{
		$sql = "UPDATE remision SET num_remision='$num_remision',correlativo='$correlativo',tipo_comprobante='$tipo_comprobante',domicilio_partida='$domicilio_partida',domicilio_llegada='$domicilio_llegada',razonsocial='$razonsocial',tipo_documento='$tipo_documento', num_documento='$num_documento', marca='$marca', placa='$placa', certificado='$certificado', licencia='$licencia', fecha_emision='$fecha_emision', fecha_traslado='$fecha_traslado' WHERE idremision='$idremision'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para anular categorías
	public function anular($idremision)
	{
		$sql = "UPDATE remision SET estado='Anulado' WHERE idremision='$idremision'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para anular la remisión
	public function activar($idremision)
	{
		$sql = "UPDATE remision SET estado='Aceptado' WHERE idremision='$idremision'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	// public function mostrar($idremision)
	// {
	// 	$sql = "SELECT * FROM remision r INNER JOIN usuario u ON r.idusuario=u.idusuario WHERE r.idremision='$idremision'";
	// 	return ejecutarConsultaSimpleFila($sql);
	// }

	public function listarDetalle($idremision)
	{
		$sql = "SELECT * FROM detalle_remision dr inner join articulo a on dr.idarticulo=a.idarticulo where dr.idremision='$idremision'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT * FROM remision ORDER BY idremision DESC";
		return ejecutarConsulta($sql);
	}

	public function listarRemisionesPorDia()
	{
		$sql = "SELECT * FROM remision WHERE DATE(fecha_emision) = CURDATE() ORDER BY idremision DESC";
		return ejecutarConsulta($sql);
	}

	public function remisioncabecera($idremision)
	{
		$sql = "SELECT u.nombre as nombreusur, r.correlativo, r.fecha_emision, r.fecha_traslado, r.tipo_documento, r.num_documento, r.marca, r.placa, r.certificado, r.licencia, r.num_remision, r.total_compra, r.domicilio_partida, r.domicilio_llegada, r.razonsocial, u.email as emailusur FROM remision r INNER JOIN usuario u ON r.idusuario=u.idusuario WHERE r.idremision='$idremision'";
		return ejecutarConsulta($sql);
	}

	public function remisiondetalle($idremision)
	{
		$sql = "SELECT a.nombre as articulo,a.codigo,d.cantidad,d.precio_compra,(d.cantidad*d.precio_compra) as subtotal FROM detalle_remision d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idremision='$idremision'";
		return ejecutarConsulta($sql);
	}

	public function mostrar($idremision)
	{
		$sql = "SELECT * FROM remision r INNER JOIN usuario u ON r.idusuario=u.idusuario WHERE r.idremision='$idremision'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementamos un método para eliminar registros
	public function eliminar($idremision)
	{
		$sql = "DELETE FROM remision WHERE idremision='$idremision'";
		return ejecutarConsulta($sql);
	}

	// public function listarDetalle($idremision)
	// {
	// 	$sql = "SELECT dr.idremision,dr.idarticulo,a.nombre,dr.cantidad,dr.precio_compra FROM detalle_remision dr inner join articulo a on dr.idarticulo=a.idarticulo where dr.idremision='$idremision'";
	// 	return ejecutarConsulta($sql);
	// }

	// //Implementar un método para listar los registros
	// public function listar()
	// {
	// 	$sql = "SELECT r.idremision, (r.fecha_emision) as fechaemision, (r.fecha_traslado) as fechatraslado, u.idusuario, u.nombre as usuario,r.domicilio_partida,r.domicilio_llegada,r.num_remision,r.tipo_documento,r.num_documento,r.tipo_comprobante, r.razonsocial, r.total_compra, r.estado FROM remision r INNER JOIN usuario u ON r.idusuario=u.idusuario ORDER BY r.idremision asc";
	// 	return ejecutarConsulta($sql);
	// }

	// public function remisioncabecera($idremision)
	// {
	// 	$sql = "SELECT r.idremision, r.idusuario,u.nombre as usuario,r.domicilio_partida,r.domicilio_llegada,r.num_remision,r.fecha_emision,r.fecha_traslado,r.tipo_documento,r.num_documento,r.tipo_comprobante,r.razonsocial,  (r.fecha_emision) as fechaemision, (r.fecha_traslado) as fechatraslado, r.total_compra FROM remision r INNER JOIN usuario u ON r.idusuario=u.idusuario WHERE r.idremision='$idremision'";
	// 	return ejecutarConsulta($sql);
	// }

	// public function remisiondetalle($idremision)
	// {
	// 	$sql = "SELECT a.nombre as articulo,a.codigo,d.cantidad,d.precio_compra,(d.cantidad*d.precio_compra) as subtotal FROM detalle_remision d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idremision='$idremision'";
	// 	return ejecutarConsulta($sql);
	// }
}
