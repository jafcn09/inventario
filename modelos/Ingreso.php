<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Ingreso
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	//Implementamos un método para insertar registros
	public function insertar($idproveedor, $idusuario, $tipo_comprobante, $serie_comprobante, $num_comprobante, $fecha_hora, $impuesto, $total_compra, $idarticulo, $cantidad, $precio_compra, $precio_venta)
	{
		$sql = "INSERT INTO ingreso (idproveedor,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_compra,estado)
    VALUES ('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','Aceptado')";
		//return ejecutarConsulta($sql);
		$idingresonew = ejecutarConsulta_retornarID($sql);

		$num_elementos = 0;
		$sw = true;

		while ($num_elementos < count($idarticulo)) {
			$sql_detalle = "INSERT INTO detalle_ingreso(idingreso, idarticulo,cantidad,precio_compra,precio_venta) VALUES ('$idingresonew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos = $num_elementos + 1;
		}

		// Obtenemos el número de comprobante sin el prefijo "FQ"
		$num_comprobante_sin_prefijo = substr($num_comprobante, 2);

		// Sumamos 1 al número de comprobante
		$num_comprobante_nuevo = intval($num_comprobante_sin_prefijo) + 1;

		// Convertimos el número de comprobante nuevo en una cadena de texto y agregarle el prefijo "FQ"
		$num_comprobante_nuevo_con_prefijo = "FQ" . str_pad($num_comprobante_nuevo, 3, "0", STR_PAD_LEFT);

		// Y por último actualizamos el número de comprobante en la tabla perfil_usuario
		$this->actualizarComprobante($serie_comprobante, $num_comprobante_nuevo_con_prefijo);

		return $sw;
	}

	public function actualizarComprobante($serie_comprobante, $num_comprobante_nuevo_con_prefijo)
	{
		$sql = "UPDATE perfil_usuario SET serie_comprobante='$serie_comprobante',num_comprobante='$num_comprobante_nuevo_con_prefijo' WHERE id_perfilusuario=1";
		return ejecutarConsulta($sql);
	}

	public function verificarNumeroExiste($num_comprobante)
	{
		$sql = "SELECT * FROM ingreso WHERE num_comprobante = '$num_comprobante'";
		$resultado = ejecutarConsulta($sql);
		if (mysqli_num_rows($resultado) > 0) {
			// El número ya existe en la tabla
			return true;
		}
		// El número no existe en la tabla
		return false;
	}

	//Implementamos un método para anular el ingreso
	public function anular($idingreso)
	{
		$sql = "UPDATE ingreso SET estado='Anulado' WHERE idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar el ingreso
	public function activar($idingreso)
	{
		$sql = "UPDATE ingreso SET estado='Aceptado' WHERE idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idingreso)
	{
		$sql = "SELECT i.idingreso,(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE i.idingreso='$idingreso'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementamos un método para eliminar registros
	public function eliminar($idingreso)
	{
		$sql = "DELETE FROM ingreso WHERE idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}

	public function listarDetalle($idingreso)
	{
		$sql = "SELECT di.idingreso,di.idarticulo,a.nombre,di.cantidad,di.precio_compra,di.precio_venta FROM detalle_ingreso di inner join articulo a on di.idarticulo=a.idarticulo where di.idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT i.idingreso,DATE_FORMAT(i.fecha_hora,'%d-%m-%Y %H:%i:%s') as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario ORDER BY i.idingreso DESC";
		return ejecutarConsulta($sql);
	}

	public function listarIngresosPorDia()
	{
		$sql = "SELECT i.idingreso,DATE_FORMAT(i.fecha_hora,'%d-%m-%Y %H:%i:%s') as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE DATE(fecha_hora) = CURDATE() ORDER BY i.idingreso DESC";
		return ejecutarConsulta($sql);
	}

	public function ingresocabecera($idingreso)
	{
		$sql = "SELECT i.idingreso,i.idproveedor,p.nombre as proveedor,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,i.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante, (i.fecha_hora) as fecha,i.impuesto,i.total_compra FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE i.idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}

	public function ingresodetalle($idingreso)
	{
		$sql = "SELECT a.nombre as articulo,a.codigo,d.cantidad,d.precio_compra,d.precio_venta,(d.cantidad*d.precio_compra) as subtotal FROM detalle_ingreso d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}
}
