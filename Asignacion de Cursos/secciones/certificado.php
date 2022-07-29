<?php 

require_once('../librerias/fpdf/fpdf.php');
require_once('../configuraciones/bd.php');

$conexionBD = BD::crearInstancia();

function agregarTexto($pdf,$texto,$x,$y,$aling='L',$fuente,$size=10,$r=0,$g=0,$b=0){
    
    $pdf->SetFont($fuente,"",$size);
    $pdf->SetXY($x,$y);
    $pdf->SetTextColor($r,$g,$b);
    $pdf->Cell($x,$y,$texto,0,0,$aling);
}

function agregarImagen($pdf,$imagen,$x,$y){
    $pdf->Image($imagen,$x,$y,0);
}

$id_curso = isset($_GET['id_curso'])?$_GET['id_curso']:"";
$id_alumno = isset($_GET['id_alumno'])?$_GET['id_alumno']:"";

$sql = "SELECT alumnos.nombre, alumnos.apellidos, cursos.nombre_curso FROM alumnos, cursos WHERE alumnos.id = :id_alumno AND cursos.id = :id_curso";
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':id_alumno',$id_alumno);
$consulta->bindParam(':id_curso',$id_curso);
$consulta->execute();
$alumno = $consulta->fetch(PDO::FETCH_ASSOC);


$pdf = new FPDF("L","mm",array(235,235));
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
agregarImagen($pdf,"../src/certificado.png",0,0);
agregarTexto($pdf,ucwords(utf8_decode($alumno['nombre'].' '.$alumno['apellidos'])),90,40,'L',"helvetica",30,0,84,115);
agregarTexto($pdf,$alumno['nombre_curso'],90,60,'L',"helvetica",20,0,84,115);
agregarTexto($pdf,date("d/m/Y"),60,80,'L',"helvetica",11,0,84,115);
$pdf->Output();





?>