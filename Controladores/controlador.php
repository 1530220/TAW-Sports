<?php  
	class MvcController{
		//Función para mandar llamar a la plantilla para las vistas que se van a mostrar
		public function plantilla(){
			//Aquí es para redirigir a la plantilla para mostrar la vista
			header("location:Vistas/plantilla.php");
		}

		//Función para poder llamar a la vista que quiere ver el usuario
		public function enlacesPaginasController(){
			//Trabajar con los enlaces de las paginas
			//Validar si la variable "action" viene vacia, es decir, cuando se abre la pagina por primera vez, se debe cargar la vista index.php
			if (isset($_GET['action'])) {
				//Se consigue el action para poder ingresar a la vista
				$enlacesController = $_GET['action'];
			}else{
				//Si viene vacio inicializo con index
				$enlacesController = "index";
			}
			//Se crea un objeto de la clase EnlacesPaginas
			$respuesta = new EnlacesPaginas();

			//Aqui con la variable respuesta manda llamar la función del modelo que va hacer la tarea de mostrar la vista.
			include $respuesta->enlacesPaginasModel($enlacesController);
		}

		//Esta función sirve para ingresar con un usuario y contraseña para entrar a la pantalla principal(dashboard)
		public function login(){
			if(isset($_POST['usuario'])&&isset($_POST['contraseña'])){
				//Mediante variables mandar llamar a los campos de usuario y contraseña de la vista del login
				$usuario = $_POST['usuario'];
				$contraseña = $_POST['contraseña'];

				//Se crea un objeto de la clase Datos
				$log = new Datos();
				//Aqui se manda la información que se ir a la función de Iniciar_Sesión para que haga la consulta correspondiente
				$r = $log->loginModel($usuario,$contraseña);
				//Esta condición es para mandar la respuesta si es verdadero que inicie la sesión o si no mandar una alerta de error para que ingrese bien los datos
				if($r){
					//Las variables para poder iniciar la sesión mediante el nombre, el password, la imagen y el id
					$_SESSION['usuario'] = $r['nombre'];
					$_SESSION['contraseña'] = $r['contraseña'];
					$_SESSION['id'] = $r['id'];
					//Redirige a la plantilla y para que muestra el dashboard
					header("location:plantilla.php");
				}else{
					//Sino se manda una alerta indicando usuario o contraseña incorrecta
					echo "<script>alert('Usuario o contraseña incorrecta.')</script>";
				}
			}
		}

		//Función para obtener todos los registros de una tabla
		public function getAllController($tabla){
			//Instancia del modelo datos
			$datos = new Datos();

			//Retornar los datos de la tabla
			return $datos->getAllModel($tabla);
		}

		public function agregarDeporte(){
        	if(isset($_POST['nombre'])){
            	$nombre_deporte=$_POST['nombre'];
            	$datos=array('nombre_deporte'=>$nombre_deporte);
            	$respuesta = Datos::agregarDeporteModel($datos, 'deporte');
            	if ($respuesta) {
            		echo "<script>alert('Deporte agregado correcatamente')</script>";
            	}else{
            		echo "<script>alert('Deporte no agregado')</script>";
            	}
        	}
		}

		public function obtenerDatosDeportes()
    	{

        $datosDeCarreras = array();
        
        //Manda llamar el metodo desde el modelo y pasandole la tabla de donde se van a extraer los datos como parametro
        $datosDeCarreras = Datos::traerDatosDeportes("deporte");

        return $datosDeCarreras;
    	}

    	public function obtenerDatosDeporteId(){
        $deporte_id = $_GET['id'];

        $datosDeDeportes = array();
        
        //Se manda llamar el metodo del modelo pasandole como parametro la matricula del deporte a traer los datos, de igual forma se hace una union de tablas para obtener la informacion mas entendible, por ello no se pasa el nombre de la tabla como parametro
        $datosDeDeportes = Datos::obtenerDatosDeDeporteId($deporte_id);

        return $datosDeDeportes;
    }

    public function editarDatosDeporte(){

        $id = $_GET['id'];
        $nombre = $_POST['nombre'];
        
        

        //Se finaliza de crear los datos, ya con la  foto nueva o en caso de que haya elegido una nueva
        $datosDeporte = array('id' => $id,
                            'nombre' => $nombre);
        
        //Se manda ese objeto con los datos al modelo para que los almacenen en la tabla pasada por parametro aqui abajo
        $respuesta = Datos::editarDeporte($datosDeporte, "deporte");
        
        //El metodo responde con un success o un error y se realiza las notificaciones pertinentes al usuario
        if($respuesta=="success"){
            
            echo '<script> 
                    alert("Datos guardados correctamente");
                    window.location.href = "?action=listaDeporte"; 
                  </script>';
            
        }else{
            echo '<script> alert("Error al guardar") </script>';
        }

    }

    public function eliminarDeporte(){

        $id = $_GET['id'];
        
        $respuesta = Datos::eliminarDatosDeporte($id, "deporte");

        //Se notifca al usuario como se realizo en los metodos pasados y si se borro exitosamente lo redirecciona a la pagina principal en donde estan listados todos los usuarios
        if($respuesta == "success"){
            echo '<script> 
                    alert("Deporte eliminado");
                    window.location.href = "?action=listaDeporte";
                  </script>';
        }else{
            echo '<script> alert("Error al eliminar") </script>';
        }

    }

	}

	
?>