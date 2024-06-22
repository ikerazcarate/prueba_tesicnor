import { useState, useEffect } from "react";
import Axios from "axios";
import Pelicula from "./Pelicula.js";

function ListaPeliculas() {
  const [peliculas, setPeliculas] = useState([]);
  const [busquedaTitle, setBusquedaTitle] = useState("");
  const [busquedaYear, setBusquedaYear] = useState("");
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        const response = await Axios.get(
          `http://localhost/prueba-tesicnor/WebService.php`
        );
        console.log(response.data);
        setPeliculas(response.data);
        setLoading(false);
        setError(""); // Limpiar el error si se reciben datos exitosamente
      } catch (error) {
        console.error("Error fetching data:", error);
        setError("No se han encontrado resultados."); // Manejar el error
        setLoading(false);
      }
    };

    fetchData();
  }, [busquedaTitle, busquedaYear]);

  const handleBuscar = (event) => {
    setBusquedaTitle(event.target.value);
  };

  const handleBuscarYear = (event) => {
    setBusquedaYear(event.target.value);
  };

  return (
    <div className="container">
      <h1 className="title">Peliculas de Star Wars</h1>
      <input
        aria-label="Buscar por título"
        type="text"
        placeholder="Buscar por título"
        value={busquedaTitle}
        onChange={handleBuscar}
        className="input"
      />
      <input
        aria-label="Buscar por año"
        type="text"
        placeholder="Buscar por año"
        value={busquedaYear}
        onChange={handleBuscarYear}
        className="input"
      />
      {loading ? (
        <p>Cargando...</p>
      ) : (
        <>
          {error ? (
            <p>{error}</p> // Mostrar mensaje de error si se ha producido un error al obtener los datos
          ) : (
            <>
              {peliculas.length === 0 ? (
                <p>No se han encontrado resultados.</p> // Mostrar mensaje si no se encuentran resultados
              ) : (
                <>
                  <div className="tarjetas">
                    {peliculas.map((pelicula, index) => (
                      <Pelicula
                        key={index}
                        id={pelicula.id}
                        titulo={pelicula.titulo}
                        year={pelicula.fecha}
                        descripcion={pelicula.descripcion}
                      />
                    ))}
                  </div>
                </>
              )}
            </>
          )}
        </>
      )}
    </div>
  );
}

export default ListaPeliculas;
