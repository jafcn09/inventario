<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Perfiles
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	/* ===================  COMPROBANTES ====================== */

	/* -------------  verificar si el Nª de comprobante existe ------------- */
	public function verificarNumComprobante1($num_comprobante1)
	{
		$sql = "SELECT * FROM ingreso WHERE num_comprobante = '$num_comprobante1'";
		$resultado = ejecutarConsulta($sql);
		if (mysqli_num_rows($resultado) > 0) {
			// El número ya existe en la tabla
			return true;
		}
		// El número no existe en la tabla
		return false;
	}

	public function verificarNumComprobante2($num_comprobante2)
	{
		$sql = "SELECT * FROM venta WHERE num_comprobante = '$num_comprobante2'";
		$resultado = ejecutarConsulta($sql);
		if (mysqli_num_rows($resultado) > 0) {
			// El número ya existe en la tabla
			return true;
		}
		// El número no existe en la tabla
		return false;
	}

	public function verificarNumComprobante3($num_comprobante3)
	{
		$sql = "SELECT * FROM remision WHERE num_comprobante = '$num_comprobante3'";
		$resultado = ejecutarConsulta($sql);
		if (mysqli_num_rows($resultado) > 0) {
			// El número ya existe en la tabla
			return true;
		}
		// El número no existe en la tabla
		return false;
	}

	/* ------------- actualizar el Nª de comprobante en la tabla ------------- */
	public function actualizarComprobante1($serie_comprobante1, $num_comprobante1)
	{
		$sql = "UPDATE perfil_usuario SET serie_comprobante='$serie_comprobante1',num_comprobante='$num_comprobante1' WHERE id_perfilusuario=1";
		return ejecutarConsulta($sql);
	}

	public function actualizarComprobante2($serie_comprobante2, $num_comprobante2)
	{
		$sql = "UPDATE perfil_usuario SET serie_comprobante='$serie_comprobante2',num_comprobante='$num_comprobante2' WHERE id_perfilusuario=2";
		return ejecutarConsulta($sql);
	}

	public function actualizarComprobante3($serie_comprobante3, $num_comprobante3)
	{
		$sql = "UPDATE perfil_usuario SET serie_comprobante='$serie_comprobante3',num_comprobante='$num_comprobante3' WHERE id_perfilusuario=3";
		return ejecutarConsulta($sql);
	}

	/* ------------- setear el Nª de comprobante a los inputs de config. comprobante ------------- */
	public function getNumerosSerieComprobantes()
	{
		$sql = "SELECT
                (SELECT CONCAT(num_comprobante, '-', serie_comprobante) FROM perfil_usuario WHERE id_perfilusuario = 1) AS num_serie_comprobante1,
                (SELECT CONCAT(num_comprobante, '-', serie_comprobante) FROM perfil_usuario WHERE id_perfilusuario = 2) AS num_serie_comprobante2,
                (SELECT CONCAT(num_comprobante, '-', serie_comprobante) FROM perfil_usuario WHERE id_perfilusuario = 3) AS num_serie_comprobante3";

		return ejecutarConsulta($sql);
	}

	/* ------------- listar el Nª de comprobante de Compras ------------- */
	public function listarCompCompra()
	{
		$sql = "SELECT num_comprobante, serie_comprobante FROM ingreso";
		return ejecutarConsulta($sql);
	}

	/* ------------- listar el Nª de comprobante de Venta ------------- */
	public function listarCompVenta()
	{
		$sql = "SELECT num_comprobante, serie_comprobante FROM venta";
		return ejecutarConsulta($sql);
	}

	/* ------------- listar el Nª de comprobante de Remisiòn ------------- */
	public function listarCompRemision()
	{
		$sql = "SELECT num_remision, correlativo FROM remision";
		return ejecutarConsulta($sql);
	}

	/* ===================  PERFILES DE USUARIO ====================== */
	public function mostrarUsuario($idusuario)
	{
		$sql = "SELECT * FROM usuario WHERE idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function actualizarPerfilUsuario($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $login, $clave, $imagen)
	{
		$sql = "UPDATE usuario SET nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email',login='$login',clave='$clave',imagen='$imagen' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}


	/* ===================  PORTADA DE LOGIN ====================== */
	public function actualizarPortadaLogin($imagen)
	{
		$sql = "UPDATE portada_login SET imagen='$imagen' WHERE idportada=1";
		return ejecutarConsulta($sql);
	}

	public function obtenerPortadaLogin()
	{
		$sql = "SELECT * FROM portada_login WHERE idportada=1";
		return ejecutarConsultaSimpleFila($sql);
	}
}
