<?php
require("db.php");
class backupdb extends db
{
	private $ruta = "";
	function __construct()
	{
		parent::__construct();
		echo $this->config();
	}

	private function config():string
	{
		$ruta = "";

		$fecha = date("h-m-s_d-m-Y");
		// poner la ruta donde se guardará el archivo.
		// $this->ruta = "backup/backup/{$fecha}_{$this->getdb()}.sql";
		// $this->ruta = "D:/downloads/{$fecha}_{$this->getdb()}.sql";
		$this->ruta = "C:/xampp/htdocs/excavadora3/db/{$fecha}_{$this->getdb()}.sql";
		if(is_writable("backup"))
		{
			if(file_exists($ruta))
			{
				unlink($ruta);
			}
			else
			{
				$comando = "mysqldump -u {$this->getUsuario()} {$this->getdb()} > {$this->ruta} --all-tablespaces --column-statistics=0";
				echo '<script>window.location.href = window.location; window.alert("Se exportó la base de datos correctamente."); </script>';
				return system($comando);
			}
		}
		else
		{
			return "El directorio no tiene permisos de escritura.";
		}
	}

	public function getRuta():string
	{
		return $this->ruta;
	}
}