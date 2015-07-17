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
function sec_print($s) {
    return htmlspecialchars(strip_tags($s), ENT_QUOTES, 'utf-8');
}
function sanitasize($toPrint){
return $strAux;
}
function table_data_rows(){
  $str = "";
  $i = 1;
  $primero = true;
  foreach ($_POST as $data){
   if($primero){
    $str.= "<tr>";
    $primero = false;
   }
   $str.="<td>" .sec_print($data)."</td>";
   if($i%3==0){
    $primero = true; //significa que termine una fila, las filas son de a 3
    $str.= "</tr>";
   }
    $i++;
 }
  error_log($str);
  return $str;
}

$titulo= get_string('PDFTitle','report_mygrades');
$nombre= levantarNombre();
$hoy = date("j/n/Y");//uso la fecha de php porque es mas facil.   
//var_dump($date);
$html = '<html><body><h2>No hay cursos seleccionados para el usuario'.$nombre.'</h2></body></html>';
if($_POST){
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
    margin-bottom: 50px;
    text-align: center;
}
a{
   color:black;
}
table, td, th {
   /* border: 1px solid black;*/
	
}
tr{
    /*background-color: #FFEBCD;*/
}
.alt{
  /* background-color: #DEB887;*/ 
}
td {
    margin-left: 3px;
	
}
 th {
    font-size: 1.1em;
    text-align: center;
    padding-top: 5px;
    padding-bottom: 4px;
   /* background-color: #FFEBCD;*/
    font-size: larger;
    margin-left: 3px;
}
</style>
<body><img src="logo_calp.png" alt="logo calp" height="100" width="100"> <h4>Colegio de Abogados de La Plata</h4> <h2>'.$titulo.'</h2> <p>usuario: '.$nombre .'</p><table>'.
		'<tr><th style="width: 350px;">'.get_string('gradetblheader_course','report_mygrades').'</th><th style="width: 105px;">'."Calificación".'</th><th style="width: 200px;">'.get_string('gradetblheader_startdate','report_mygrades').'</th></tr>'.table_data_rows().	
	'</table><p> Fecha de emisión: '.$hoy. '</body></html>';
}

$dompdf = new DOMPDF();
$dompdf->load_html(utf8_decode($html)); 
$dompdf->render();
$dompdf->stream(get_string('PDFFileTitle','report_mygrades').$nombre.".pdf");

