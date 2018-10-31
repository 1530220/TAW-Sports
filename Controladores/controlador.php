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
	}
?>