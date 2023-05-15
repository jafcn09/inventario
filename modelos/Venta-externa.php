<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class VentaExterna
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idusuario,$idarticulo,$telefono,$correo,$descripcion)
	{
        $datetime = new DateTime("", new DateTimeZone('America/Lima')); 
		$orderDate = $datetime->format('Y-m-d H:i:s');
		$datetime->setTimezone(new DateTimeZone('America/Lima')); 
		$orderDate = $datetime->format('Y-m-d H:i:s');

		$sql="INSERT INTO venta_externa (idusuario,idarticulo,telefono,correo,descripcion,fecha_hora,estado)
		VALUES ('$idusuario','$idarticulo','$telefono','$correo','$descripcion','$orderDate','Activado')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idventaexterna,$idarticulo,$telefono,$correo,$descripcion)
	{
        $datetime = new DateTime("", new DateTimeZone('America/Lima')); 
		$orderDate = $datetime->format('Y-m-d H:i:s');
		$datetime->setTimezone(new DateTimeZone('America/Lima')); 
		$orderDate = $datetime->format('Y-m-d H:i:s');

		$sql="UPDATE venta_externa SET idarticulo='$idarticulo', telefono='$telefono',correo='$correo',descripcion='$descripcion', fecha_hora='$orderDate' WHERE idventaexterna='$idventaexterna'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar registros
	public function eliminar($idventaexterna)
	{
		$sql="DELETE FROM venta_externa WHERE idventaexterna='$idventaexterna'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar($idusuario)
	{
		$sql="SELECT ve.idventaexterna,ve.correo,ve.telefono,ve.descripcion,u.nombre as usuario,ae.nombre as articulo,ae.imagen as imagen,c.nombre as categoria,a.ubicacion as almacen,ae.descripcion as precio,ae.idarticulo,ve.fecha_hora as fecha,ve.estado FROM venta_externa ve INNER JOIN usuario u ON ve.idusuario=u.idusuario INNER JOIN articulo_externo ae ON ve.idarticulo=ae.idarticulo INNER JOIN categoria c ON ae.idcategoria=c.idcategoria INNER JOIN almacen a ON ae.idalmacen=a.idalmacen WHERE ve.idusuario='$idusuario' ORDER BY ve.idventaexterna DESC";
		return ejecutarConsulta($sql);
	}

	public function listarventaexternaAdmin()
	{
		$sql="SELECT ve.idventaexterna,ve.correo,ve.telefono,ve.descripcion,u.nombre as usuario,ae.nombre as articulo,ae.imagen as imagen,c.nombre as categoria,a.ubicacion as almacen,ae.descripcion as precio,ae.idarticulo,ve.fecha_hora as fecha,ve.estado FROM venta_externa ve INNER JOIN usuario u ON ve.idusuario=u.idusuario INNER JOIN articulo_externo ae ON ve.idarticulo=ae.idarticulo INNER JOIN categoria c ON ae.idcategoria=c.idcategoria INNER JOIN almacen a ON ae.idalmacen=a.idalmacen ORDER BY ve.idventaexterna DESC";
		return ejecutarConsulta($sql);
	}

    //Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventaexterna)
	{
		$sql="SELECT ve.idventaexterna,ve.correo,ve.telefono,ve.descripcion,u.nombre as usuario,ae.nombre as articulo,ae.imagen as imagen,c.nombre as categoria,a.ubicacion as almacen,ae.descripcion as precio,ae.idarticulo,ve.fecha_hora as fecha,ve.estado FROM venta_externa ve INNER JOIN usuario u ON ve.idusuario=u.idusuario INNER JOIN articulo_externo ae ON ve.idarticulo=ae.idarticulo INNER JOIN categoria c ON ae.idcategoria=c.idcategoria INNER JOIN almacen a ON ae.idalmacen=a.idalmacen WHERE idventaexterna='$idventaexterna'";
		return ejecutarConsultaSimpleFila($sql);
	}

    //Implementamos un método para desactivar registros
	public function desactivar($idventaexterna)
	{
		$sql="UPDATE venta_externa SET estado='Desactivado' WHERE idventaexterna='$idventaexterna'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idventaexterna)
	{
		$sql="UPDATE venta_externa SET estado='Activado' WHERE idventaexterna='$idventaexterna'";
		return ejecutarConsulta($sql);
	}
}

?>