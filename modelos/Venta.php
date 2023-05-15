<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Venta
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	//Implementamos un método para insertar registros
	public function insertar($idcliente, $idusuario, $num_remision, $correlativo, $tipo_comprobante, $serie_comprobante, $num_comprobante, $fecha_hora, $impuesto, $total_venta, $idarticulo, $cantidad, $precio_venta, $descuento)
	{
		// Primero, debemos verificar si hay suficiente stock para cada artículo
		$error = $this->validarStock($idarticulo, $cantidad);
		if ($error) {
			// Si hay un error, no se puede insertar
			return false;
		}

		// Si no hay errores, continuamos con el registro de la venta
		$sql = "INSERT INTO venta (idcliente,idusuario,num_remision,correlativo,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_venta,estado)
		VALUES ('$idcliente','$idusuario','$num_remision','$correlativo','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_venta','Aceptado')";
		//return ejecutarConsulta($sql);
		$idventanew = ejecutarConsulta_retornarID($sql);

		$num_elementos = 0;
		$sw = true;

		while ($num_elementos < count($idarticulo)) {
			$sql_detalle = "INSERT INTO detalle_venta(idventa, idarticulo,cantidad,precio_venta,descuento) VALUES ('$idventanew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos = $num_elementos + 1;
		}

		// Obtenemos el número de comprobante sin el prefijo "FQ"
		$num_comprobante_sin_prefijo = substr($num_comprobante, 2);

		// Sumamos 1 al número de comprobante
		$num_comprobante_nuevo = intval($num_comprobante_sin_prefijo) + 1;

		// Convertimos el número de comprobante nuevo en una cadena de texto y agregarle el prefijo "FQ"
		$num_comprobante_nuevo_con_prefijo = "FQ" . str_pad($num_comprobante_nuevo, 4, "0", STR_PAD_LEFT);

		// Y por último actualizamos el número de comprobante en la tabla perfil_usuario
		$this->actualizarComprobante($serie_comprobante, $num_comprobante_nuevo_con_prefijo);

		return $sw;
	}

	public function actualizarComprobante($serie_comprobante, $num_comprobante_nuevo_con_prefijo)
	{
		$sql = "UPDATE perfil_usuario SET serie_comprobante='$serie_comprobante',num_comprobante='$num_comprobante_nuevo_con_prefijo' WHERE id_perfilusuario=2";
		return ejecutarConsulta($sql);
	}

	public function validarStock($idarticulo, $cantidad)
	{
		for ($i = 0; $i < count($idarticulo); $i++) {
			$sql = "SELECT stock FROM articulo WHERE idarticulo = '$idarticulo[$i]'";
			$res = ejecutarConsultaSimpleFila($sql);
			$stockActual = $res['stock'];
			if ($cantidad[$i] > $stockActual) {
				return true;
			}
		}
		return false;
	}

	public function verificarNumeroExiste($num_comprobante)
	{
		$sql = "SELECT * FROM venta WHERE num_comprobante = '$num_comprobante'";
		$resultado = ejecutarConsulta($sql);
		if (mysqli_num_rows($resultado) > 0) {
			// El número ya existe en la tabla
			return true;
		}
		// El número no existe en la tabla
		return false;
	}

	//Implementamos un método para anular la venta
	public function anular($idventa)
	{
		$sql = "UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar la venta
	public function activar($idventa)
	{
		$sql = "UPDATE venta SET estado='Aceptado' WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql = "SELECT v.idventa,(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.num_remision,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementamos un método para eliminar registros
	public function eliminar($idventa)
	{
		$sql = "DELETE FROM venta WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function listarDetalle($idventa)
	{
		$sql = "SELECT dv.idventa,dv.idarticulo,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal FROM detalle_venta dv inner join articulo a on dv.idarticulo=a.idarticulo where dv.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT v.idventa,(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario ORDER by v.idventa DESC";
		return ejecutarConsulta($sql);
	}

	public function listarVentasPorDia()
	{
		$sql = "SELECT v.idventa, v.fecha_hora as fecha, v.idcliente, p.nombre as cliente, u.idusuario, u.nombre as usuario, v.tipo_comprobante, v.serie_comprobante, v.num_comprobante, v.total_venta, v.impuesto, v.estado 
				FROM venta v 
				INNER JOIN persona p ON v.idcliente = p.idpersona 
				INNER JOIN usuario u ON v.idusuario = u.idusuario 
				WHERE DATE(v.fecha_hora) = CURDATE()
				ORDER BY v.idventa DESC";
		return ejecutarConsulta($sql);
	}

	public function ventacabecera($idventa)
	{
		$sql = "SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.correlativo,v.num_remision,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function ventadetalle($idventa)
	{
		$sql = "SELECT a.nombre as articulo,a.codigo,d.cantidad,d.precio_venta,d.descuento,(d.cantidad*d.precio_venta-d.descuento) as subtotal FROM detalle_venta d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}
}
