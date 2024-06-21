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
			$query = "SELECT * FROM peliculas";
			if ($res = $conn->query("$query")) {
				while ($row = $res->fetch_assoc()) {
					array_push($peliculasList, new Pelicula($row["ID"],$row["Titulo"],$row["Fecha"],$row["Descripcion"]));
				}
				$res->free();
				array_pop($peliculasList);
				return $peliculasList;
			}
        }catch(Exception $e){
			return false;
		}
	}

	public function insertPeliculas(){
		try{
			//Conexion API
			$api="http://www.omdbapi.com/?apikey=731e41f&t=Star+Wars";
			$json_data = file_get_contents($api);
			$data=json_decode($json_data,true);
			//Conexion BBDD
			$conn = DatabaseConn::getConn();
			$conn->autocommit(false);

			foreach($data as $film){
				$query = "INSERT INTO peliculas (ID,Titulo,Fecha,Descripcion) VALUES ('".$film['ID']."','".$film['Title']."','".$film['Year']."','".$film['Plot']."')";
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