<?php  
	require_once "conexion.php";

	class Datos extends Conexion{
		//Metodo para verificar si el usuario que desea iniciar sesion  esta registrado
		public function loginModel($usuario,$contraseña){
			//Consulta para seleccionar la tabla usuarios
			$sql = "SELECT * FROM usuarios";
			//Se prepara la consulta
			$stmt = Conexion::conectar()->prepare($sql);
			//Se ejecuta la consulta
			$stmt->execute(array($usuario,$contraseña));
			$r = $stmt->fetch();
			var_dump($r);
			//Una condicion para que devuelva la respuesta o un array vacio
			if($r){
				return $r;
			}else{
				return [];
			}
		}

	}
?>