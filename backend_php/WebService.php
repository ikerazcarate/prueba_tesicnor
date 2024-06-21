<?php
session_start();
require_once "./Model.php";
require_once './DatabaseConn.php';

//RECIBIR DATOS
$equipo = $_GET['film_title'];

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (class_exists("peliculasModule")) {
    $module = new peliculasModule();
    $respuesta = $module->getAllPeliculas();
    print json_encode($respuesta);
}
?>
