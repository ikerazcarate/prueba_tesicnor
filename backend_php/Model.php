<?php
class Model
{
	public function __construct(){
		require_once 'DatabaseConn.php';
	}
}

class Pelicula{
	public $id;
	public $titulo;
	public $fecha;
	public $descripcion;
	
	public function __construct($id,$titulo,$fecha,$descripcion){
		$this->id = $id;
		$this->titulo = $titulo;
		$this->fecha = $fecha;
		$this->descripcion = $descripcion;
	}
}

class peliculasModule extends Model{
	
	public function getAllPeliculas(){
		try{
			$conn = DatabaseConn::getConn();
			$peliculasList = array();
			$query = "SELECT * FROM peliculas_star_wars";
			if ($res = $conn->query("$query")) {
				while ($row = $res->fetch_assoc()) {
					array_push($peliculasList, new Pelicula($row["ID"],$row["Titulo"],$row["Fecha"],$row["Descripcion"]));
				}
				$res->free();
				return $peliculasList;
			}
        }catch(Exception $e){
			return false;
		}
	}

	public function insertPeliculas(){
		try{
			//Si no hacemos este array de episodios y solo ponemos Star Wars en el enlace solo devolverá el 4 episodio, no es eficiente porque hacemos 9 llamadas pero en la documentación de la api no aportan otra solución 
			$episodios=["I","II","III","IV","V","VI","VII","VIII","IX"];
			
			//Conexion BBDD
			$conn = DatabaseConn::getConn();
			$conn->autocommit(false);
			
			foreach($episodios as $ep){
			//Conexion API
			$api="http://www.omdbapi.com/?apikey=731e41f&t=Star+Wars+".$ep;

			$json_data = file_get_contents($api);
			$film=json_decode($json_data,true);

				$query = "INSERT INTO peliculas_star_wars (ID,Titulo,Fecha,Descripcion) VALUES ('".$film['imdbID']."','".$film['Title']."','".$film['Year']."','".$film['Plot']."')";
				if ($res = $conn->query("$query")) {
					// Confirma la transacción si la inserción es exitosa
					$conn->commit();
					return true;
				}else{
					// Si hay un error, revierte la transacción
					$conn->rollback();
					return false;
				}
			}
		}catch(Exception $e){
			// Si hay una excepción, revierte la transacción
			$conn->rollback();
			return false;
		}finally {
			$conn->autocommit(true); // Restaurar el modo de autocommit
		}
	}
}
?>