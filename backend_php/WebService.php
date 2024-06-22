<?php
require_once "./Model.php";
require_once './DatabaseConn.php';

//RECIBIR DATOS
//$equipo = $_GET['title'];
//$year = $_GET['year'];

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if (class_exists("peliculasModule")) {
    $module = new peliculasModule();
    $respuesta = $module->getAllPeliculas();
    print json_encode($respuesta);
}
?>
