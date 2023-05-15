<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Visitas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idusuario,$nombres,$fecha_entrada,$tipo_documento,$num_documento,$motivo)
	{
		$sql="INSERT INTO visitas (idusuario,nombres,fecha_entrada,fecha_salida,tipo_documento,num_documento,motivo,estado)
		VALUES ('$idusuario','$nombres','$fecha_entrada','0000-00-00 00:00:00.000000','$tipo_documento','$num_documento','$motivo','Ingresado')";
        return ejecutarConsulta($sql);
	}

    //Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM visitas ORDER BY idvisitas DESC";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idvisitas)
	{
		$sql = "SELECT * FROM visitas v INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idvisitas='$idvisitas'";
		return ejecutarConsultaSimpleFila($sql);
	}
	
	//Implementamos un método para anular el registro de visita
	public function anular($idvisitas)
	{
		$datetime = new DateTime("", new DateTimeZone('America/Lima')); 
		$orderDate = $datetime->format('Y-m-d H:i:s');
		$datetime->setTimezone(new DateTimeZone('America/Lima')); 
		$orderDate = $datetime->format('Y-m-d H:i:s');
		
		$sql="UPDATE visitas SET fecha_salida='$orderDate', estado='Finalizado' WHERE idvisitas='$idvisitas'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar registros
	public function eliminar($idvisitas)
	{
		$sql="DELETE FROM visitas WHERE idvisitas='$idvisitas'";
		return ejecutarConsulta($sql);
	}

}
?>