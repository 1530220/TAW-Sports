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
		public function agregarDeporteModel($datos,$tabla){
			//Llama la conexión y hace la inserción de los datos y cada stmt para llenar los datos a la tabla deporte
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre) VALUES(:nombre) ");
			$stmt->bindParam(":nombre", $datos["nombre_deporte"] , PDO::PARAM_STR);
			return $stmt->execute();
		}

		public function traerDatosDeportes($tabla){

        //Conexion::conectar() -> es igual a un objeto PDO el cual sirve para conectarse a la base de datos
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

        //Metodo que ejecuta el query previamente preparado
        $stmt->execute();

        //Se crea un objeto tipo array para recibir los datos
        $r = array();
        //se traen todos los datos con la funcion fetchAll
        $r = $stmt->FetchAll();
        
        //Se retornan los datos para el modelo
        return $r;
    
    }

    public function obtenerDatosDeDeporteId($deporte_id){

        //Se prepara el query
       $stmt = Conexion::conectar()->prepare("SELECT * FROM deporte WHERE id = :deporte_id");

        //Se pasan los parametros de ese query
        $stmt->bindParam(":deporte_id", $deporte_id , PDO::PARAM_STR);

        //se ejecuta
        $stmt->execute();

        $r = array();

        //Se trane todos los ddatos
        $r = $stmt->FetchAll();
        
        //y finalmente se pasan al controlador para ponerlos en la vista en donde se hace la edicion de dicho registro
        return $r;

    }
    public function editarDeporte($datosDeporte, $tabla){

        //Se prepara el query con el comando UPDATE -> DE EDITAR, O ACTUALIZAR
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla 
                                               SET nombre = :nombre
                                               WHERE id = :id ");
        
        //Se relacionan todos los parametros con los pasados en el arreglo asociativo desde el controlador
        $stmt->bindParam(":nombre", $datosDeporte["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $datosDeporte["id"] , PDO::PARAM_INT);

        //Y son ejecutados y notificados al controlador para que este les notifique a las vistas para que den un mensaje amigable al usuario
        if($stmt->execute()){
            return "success";
        }else{
            return "error";
        }

        $stmt->close();


    }

	public function eliminarDatosDeporte($deporte_id, $tabla){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id ");

        $stmt->bindParam(":id", $deporte_id , PDO::PARAM_INT);

        //Le informa al controlador si se realizao con exito o no dicha transaccion
        if($stmt->execute() ){
            return "success";
        }else{
            return "error";
        }

    }    

	}
?>