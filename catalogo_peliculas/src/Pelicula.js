import React from "react";
import Axios from "axios";
import { useState, useEffect } from "react";

function Pelicula({ id, titulo, year, descripcion }) {
  return (
    <div className="tarjeta">
      <h2>{titulo}</h2>
      <p>Año: {year}</p>
      <p>Descripción: {descripcion}</p>
    </div>
  );
}

export default Pelicula;
