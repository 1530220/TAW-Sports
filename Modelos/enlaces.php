<?php  
	class EnlacesPaginas{
		//Function con el parametro $enlacesModel que se recibe a travez del controlador
		public function enlacesPaginasModel($enlacesModel){
			//Validar que si existe el nombre de la vista 
			if($enlacesModel=="agregarDeporte" || 
				$enlacesModel=="editarDeporte" ||
				$enlacesModel=="listaDeporte" ||
			  	$enlacesModel=="agregarEquipo"||
			  	$enlacesModel=="editarEquipo"||
			  	$enlacesModel=="listaEquipo"){
				//Mostramos el URL concatenado con $enlacesModel
				$module = "Paginas/".$enlacesModel.".php";
			}
			//Validar una lista blanca
			else{
				$module = "Paginas/inicio.php";		
			}
			//Retorna la vista
			return $module;
		}
	}
?>