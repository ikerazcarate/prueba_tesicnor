<?php
require_once 'DatabaseConn.php';

$conn = DatabaseConn::getConn();

if ($conn) {
    echo "Conexión exitosa a la base de datos!";
} else {
    echo "Error al conectar a la base de datos.";
}

DatabaseConn::closeConn();
?>
