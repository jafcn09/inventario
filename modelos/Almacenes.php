<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Almacenes
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($ubicacion,$descripcion)
	{
		$sql="INSERT INTO almacen (ubicacion,descripcion,estado)
		VALUES ('$ubicacion','$descripcion','Activado')";
		return ejecutarConsulta($sql);
	}

	public function verificarAlmacenExiste($ubicacion)
	{
		$sql = "SELECT * FROM almacen WHERE ubicacion = '$ubicacion'";
		$resultado = ejecutarConsulta($sql);
		if (mysqli_num_rows($resultado) > 0) {
			// El almacén ya existe en la tabla
			return true;
		}	
		// El almacén no existe en la tabla
		return false;
	}

	//Implementamos un método para editar registros
	public function editar($idalmacen,$ubicacion,$descripcion)
	{
		$sql="UPDATE almacen SET ubicacion='$ubicacion',descripcion='$descripcion' WHERE idalmacen='$idalmacen'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar almacenes
	public function desactivar($idalmacen)
	{
		$sql="UPDATE almacen SET estado='Desactivado' WHERE idalmacen='$idalmacen'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar almacenes
	public function activar($idalmacen)
	{
		$sql="UPDATE almacen SET estado='Activado' WHERE idalmacen='$idalmacen'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idalmacen)
	{
		$sql="SELECT * FROM almacen WHERE idalmacen='$idalmacen'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM almacen ORDER BY idalmacen DESC";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM almacen where estado='Activado'";
		return ejecutarConsulta($sql);		
	}
}
