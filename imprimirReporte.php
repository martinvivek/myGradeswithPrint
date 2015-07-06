<?php
/*
Falta agregar lo de levantar el nombre
*/
require('../../config.php');
require_once($CFG->libdir . '/gradelib.php');
require_once $CFG->dirroot . '/grade/report/overview/lib.php';
require_once $CFG->dirroot . '/grade/lib.php';
require_once($_SERVER['DOCUMENT_ROOT']."/dompdf/dompdf_config.inc.php");
/*error_log(var_dump($_POST));*/
require_login();
global $DB,$CFG;

function levantarNombre(){
   global $USER;
   return ($USER->firstname.' '.$USER->lastname);
}


$titulo= get_string('PDFTitle','report_mygrades');
$nombre= levantarNombre();
error_log($nombre);
$titulo.= $nombre;
$html = '<html><body><h2>No hay cursos seleccionados para el usuario'.$nombre.'</h2></body></html>';
if(isset($_POST['imprimir'])&&($_POST['imprimir']!='vacio')){
  $html ='<html>
<head>
<style>
h2{
font-family: verdana;
}
table {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
    color: black;
    font-size: medium; 
    font-family: verdana;
    font-size: large;
}
a{
   color:black;
}
table, td, th {
    border: 1px solid black;
}
tr{
    background-color: #FFEBCD;
}
.alt{
   background-color: #DEB887; 
}
td {
    margin-left: 3px;
	
}
 th {
    font-size: 1.1em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #FFEBCD;
    font-size: larger;
    margin-left: 3px;
}
</style>
<body><h2>'.$titulo.'</h2><table>'.
		'<tr><th style="width: 400px;">'.get_string('gradetblheader_course','report_mygrades').'</th><th style="width: 105px;">'."Calificaciones".'</th><th style="width: 200px;">'.get_string('gradetblheader_startdate','report_mygrades').'</th></tr>'.$_POST["imprimir"] .	
	'</table></body></html>';
}

$dompdf = new DOMPDF();
$dompdf->load_html($html); 
$dompdf->render();
$dompdf->stream(get_string('PDFFileTitle','report_mygrades').$nombre.".pdf");

