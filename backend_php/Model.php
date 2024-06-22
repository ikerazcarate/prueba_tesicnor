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

	public function getPeliculas($title,$year){
		try{
			$conn = DatabaseConn::getConn();
			$peliculasList = array();
			
			$query = "SELECT * FROM peliculas_star_wars";
			if($title != "" && $year != ""){
				$query .= " WHERE Titulo LIKE '%$title%' AND Fecha LIKE '%$year%'";
			}elseif($title != ""){
				$query .= " WHERE Titulo LIKE '%$title%'";
			}elseif($year != ""){
				$query .= " WHERE Fecha LIKE '%$year%'";
			}

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

	public function insertPeliculas() {
		// Si no hacemos este array de episodios y solo ponemos Star Wars en el enlace solo devolverá el 4 episodio, no es eficiente porque hacemos 9 llamadas pero en la documentación de la api no aportan otra solución 
		$episodios = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX"];
	
		try {
			// Conexion BBDD
			$conn = DatabaseConn::getConn();
			$conn->autocommit(false); // Deshabilitar el autocommit para manejar transacciones manualmente
	
			foreach ($episodios as $ep) {
				// Conexion API
				$api = "http://www.omdbapi.com/?apikey=731e41f&t=Star+Wars+Episode+" . $ep;
				$json_data = file_get_contents($api);
				$film = json_decode($json_data, true);
	
				// Verificar el contenido del campo para la insercion, y sustituir por vacíos si no existen
				$id = $conn->real_escape_string(isset($film['imdbID']) ? $film['imdbID'] : '');
				$titulo = $conn->real_escape_string(isset($film['Title']) ? $film['Title'] : '');
				$fecha = $conn->real_escape_string(isset($film['Year']) ? $film['Year'] : '');
				$descripcion = $conn->real_escape_string(isset($film['Plot']) ? $film['Plot'] : '');
	
				// Comprobar si la película ya existe en la base de datos
				$query1 = "SELECT * FROM peliculas_star_wars WHERE ID = '$id'";
				$result = $conn->query($query1);
				if ($result && $result->num_rows > 0) {
					// La película ya existe
					continue;
				}
	
				// Insertar en la base de datos
				$query2 = "INSERT INTO peliculas_star_wars (ID, Titulo, Fecha, Descripcion) VALUES ('$id', '$titulo', '$fecha', '$descripcion')";
				if (!$conn->query($query2)) {
					throw new Exception("Error en la consulta: " . $conn->error);
				}
			}
	
			// Confirma la transacción si todas las inserciones son exitosas
			$conn->commit();
			return true;
	
		} catch (Exception $e) {
			// Si hay una excepción se revierte la transacción
			$conn->rollback();
			return array('error' => $e->getMessage());
	
		} finally {
			$conn->autocommit(true); // Restaurar el modo de autocommit
			DatabaseConn::closeConn();
		}
	}
	
	
}
?>