<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Marcas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$descripcion)
	{
		$sql="INSERT INTO marcas (nombre,descripcion,estado)
		VALUES ('$nombre','$descripcion','Activado')";
		return ejecutarConsulta($sql);
	}

	public function verificarMarcasExiste($nombre)
	{
		$sql = "SELECT * FROM marcas WHERE nombre = '$nombre'";
		$resultado = ejecutarConsulta($sql);
		if (mysqli_num_rows($resultado) > 0) {
			// El nombre de la marca ya existe en la tabla
			return true;
		}	
		// El nombre de la marca no existe en la tabla
		return false;
	}

	//Implementamos un método para editar registros
	public function editar($idmarcas,$nombre,$descripcion)
	{
		$sql="UPDATE marcas SET nombre='$nombre',descripcion='$descripcion' WHERE idmarcas='$idmarcas'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar marcas
	public function desactivar($idmarcas)
	{
		$sql="UPDATE marcas SET estado='Desactivado' WHERE idmarcas='$idmarcas'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar marcas
	public function activar($idmarcas)
	{
		$sql="UPDATE marcas SET estado='Activado' WHERE idmarcas='$idmarcas'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idmarcas)
	{
		$sql="SELECT * FROM marcas WHERE idmarcas='$idmarcas'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM marcas ORDER BY idmarcas DESC";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM marcas where estado='Activado'";
		return ejecutarConsulta($sql);		
	}
}

?>