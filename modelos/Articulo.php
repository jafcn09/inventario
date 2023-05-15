<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Articulo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idmarcas,$idcategoria,$idusuario,$idalmacen,$codigo,$nombre,$stock,$descripcion,$medida,$cubicaje,$material,$imagen)
	{
		$sql="INSERT INTO articulo (idmarcas,idcategoria,idusuario,idalmacen,codigo,nombre,stock,descripcion,medida,cubicaje,material,imagen,condicion)
		VALUES ('$idmarcas','$idcategoria','$idusuario','$idalmacen','$codigo','$nombre','$stock','$descripcion','$medida','$cubicaje','$material','$imagen','1')";
		return ejecutarConsulta($sql);
	}

	public function verificarCodigoExiste($codigo)
	{
		$sql = "SELECT * FROM articulo WHERE codigo = '$codigo'";
		$resultado = ejecutarConsulta($sql);
		if (mysqli_num_rows($resultado) > 0) {
			// El código ya existe en la tabla
			return true;
		}	
		// El código no existe en la tabla
		return false;
	}

	//Implementamos un método para editar registros
	public function editar($idarticulo,$idmarcas,$idcategoria,$idalmacen,$codigo,$nombre,$stock,$descripcion,$medida,$cubicaje,$material,$imagen)
	{
		$sql="UPDATE articulo SET idmarcas='$idmarcas',idcategoria='$idcategoria',idalmacen='$idalmacen',codigo='$codigo',nombre='$nombre',stock='$stock',descripcion='$descripcion',medida='$medida',cubicaje='$cubicaje', material='$material',imagen='$imagen' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idarticulo)
	{
		$sql="UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idarticulo)
	{
		$sql="UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar registros
	public function eliminar($idarticulo)
	{
		$sql="DELETE FROM articulo WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idarticulo)
	{
		$sql="SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,m.nombre as marcas,c.nombre as categoria,al.ubicacion as almacen,u.nombre as usuario,a.codigo,a.nombre,a.stock,a.descripcion,a.medida,a.cubicaje,a.material,a.imagen,a.condicion FROM articulo a INNER JOIN marcas m ON a.idmarcas=m.idmarcas INNER JOIN categoria c ON a.idcategoria=c.idcategoria INNER JOIN usuario u ON a.idusuario=u.idusuario INNER JOIN almacen al ON a.idalmacen=al.idalmacen ORDER BY a.idarticulo DESC";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros activos
	public function listarActivos()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.descripcion,a.medida,a.cubicaje,a.material,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria ORDER BY a.idarticulo DESC";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
	public function listarActivosVenta()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.medida,a.cubicaje,a.material,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo order by iddetalle_ingreso desc limit 0,1) as precio_venta,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria ORDER BY a.idarticulo DESC";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM articulo where condicion = 1";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function selectarticuloexterno($idusuario)
	{
		$sql="SELECT * FROM articulo_externo where condicion = 1 and idusuario = '$idusuario'";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function selectarticuloexternoGeneral()
	{
		$sql="SELECT * FROM articulo_externo where condicion = 1";
		return ejecutarConsulta($sql);		
	}

	// Artículos externos

	//Implementamos un método para insertar registros
	public function insertararticuloexterno($idcategoria,$idusuario,$idalmacen,$codigo,$nombre,$stock,$descripcion,$medida,$cubicaje,$material,$imagen)
	{
		$sql="INSERT INTO articulo_externo(idcategoria,idusuario,idalmacen,codigo,nombre,stock,descripcion,medida,cubicaje,material,imagen,condicion)
		VALUES ('$idcategoria','$idusuario','$idalmacen','$codigo','$nombre','$stock','$descripcion','$medida','$cubicaje','$material','$imagen','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editararticuloexterno($idarticulo,$idcategoria,$idalmacen,$codigo,$nombre,$stock,$descripcion,$medida,$cubicaje,$material,$imagen)
	{
		$sql="UPDATE articulo_externo SET idcategoria='$idcategoria',idalmacen='$idalmacen',codigo='$codigo',nombre='$nombre',stock='$stock',descripcion='$descripcion',medida='$medida',cubicaje='$cubicaje', material='$material',imagen='$imagen' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	public function listararticuloexterno($idusuario)
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,al.ubicacion as almacen,u.nombre as usuario,a.codigo,a.nombre,a.stock,a.descripcion,a.medida,a.cubicaje,a.material,a.imagen,a.condicion FROM articulo_externo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria INNER JOIN usuario u ON a.idusuario=u.idusuario INNER JOIN almacen al ON a.idalmacen=al.idalmacen WHERE a.idusuario='$idusuario' ORDER BY a.idarticulo DESC";
		return ejecutarConsulta($sql);		
	}

	public function listararticuloexternoAdmin()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,al.ubicacion as almacen,u.nombre as usuario,a.codigo,a.nombre,a.stock,a.descripcion,a.medida,a.cubicaje,a.material,a.imagen,a.condicion FROM articulo_externo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria INNER JOIN usuario u ON a.idusuario=u.idusuario INNER JOIN almacen al ON a.idalmacen=al.idalmacen ORDER BY a.idarticulo DESC";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrararticuloexterno($idarticulo)
	{
		$sql="SELECT * FROM articulo_externo WHERE idarticulo='$idarticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementamos un método para eliminar registros
	public function eliminararticuloexterno($idarticulo)
	{
		$sql="DELETE FROM articulo_externo WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivararticuloexterno($idarticulo)
	{
		$sql="UPDATE articulo_externo SET condicion='0' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activararticuloexterno($idarticulo)
	{
		$sql="UPDATE articulo_externo SET condicion='1' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}
}

?>