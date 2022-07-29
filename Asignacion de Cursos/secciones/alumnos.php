<?php 

require_once('../configuraciones/bd.php');
$conexionBD = BD::crearInstancia();


$id = isset($_POST['id'])?$_POST['id']: "";
$nombre = isset($_POST['nombre'])?$_POST['nombre']: "";
$apellidos = isset($_POST['apellidos'])?$_POST['apellidos']: "";


$cursos = isset($_POST['cursos'])?$_POST['cursos']: "";
$accion = isset($_POST['accion'])?$_POST['accion']: "";


if ($accion !=="") {
   switch($accion){
        case "agregar":
            $sql = "INSERT INTO alumnos (id, nombre, apellidos) VALUES (NULL, :nombre, :apellido) ";
            $consulta = $conexionBD->prepare($sql);
            $consulta->bindParam(':nombre',$nombre);
            $consulta->bindParam(':apellido',$apellidos);
            $consulta->execute();
            $idAlumno = $conexionBD->lastInsertId();

            foreach ($cursos as $curso ) {
               $sql = "INSERT INTO alumnos_cursos (id,id_alumno,id_curso) VALUES (NULL, :id_alumno, :id_curso)";
               $consulta = $conexionBD->prepare($sql);
               $consulta->bindParam(':id_alumno',$idAlumno);
               $consulta->bindParam(':id_curso',$curso);
               $consulta->execute();
            }

        break;

        case"seleccionar":
            
            $sql = "SELECT * FROM alumnos WHERE id=:id";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':id',$id);
            $consulta->execute();
            $alumno = $consulta->fetch(PDO::FETCH_ASSOC);
            $nombre =  $alumno['nombre'];
            $apellidos =  $alumno['apellidos'];

            $sql = "SELECT ac.id_curso FROM alumnos_cursos ac INNER JOIN cursos c ON c.id = ac.id_curso WHERE ac.id_alumno=:id_alumno";
            $consulta = $conexionBD->prepare($sql);
            $consulta->bindParam(':id_alumno',$id);
            $consulta->execute();
            $cursosAlumno = $consulta->fetchAll(PDO::FETCH_ASSOC);
       

            foreach ($cursosAlumno as $curso ) {
    
                $arregloCursos[]=$curso['id_curso'];
            }


        break;

        case "borrar":

            $sql = "DELETE FROM alumnos WHERE id=:id";
            $consulta = $conexionBD->prepare($sql);
            $consulta->bindParam(':id',$id);
            $consulta->execute();

        break;

        case "editar":

            $sql = "UPDATE alumnos SET nombre = :nombre, apellidos = :apellidos WHERE id = :id";
            $consulta = $conexionBD->prepare($sql);
            $consulta->bindParam(':nombre',$nombre);
            $consulta->bindParam(':apellidos',$apellidos);
            $consulta->bindParam(':id',$id);
            $consulta->execute();

            if(isset($cursos)){
                $sql = "DELETE FROM alumnos_cursos WHERE id_alumno = :id_alumno";
                $consulta = $conexionBD->prepare($sql);
                $consulta->bindParam(':id_alumno',$id);
                $consulta->execute();

                foreach ($cursos as $curso) {
                   $sql = "INSERT INTO alumnos_cursos (id,id_alumno,id_curso) VALUES(NULL,:id_alumno,:id_curso) ";
                   $consulta = $conexionBD->prepare($sql);
                   $consulta->bindParam(':id_alumno',$id);
                   $consulta->bindParam(':id_curso',$curso);
                   $consulta->execute();
                }
                $arregloCursos=$cursos;
            }

        break;
   }
}



$sql = "SELECT * FROM alumnos";
$listaAlumnos = $conexionBD->query($sql);
$alumnos = $listaAlumnos->fetchAll();

foreach ($alumnos as $clave => $alumno) {
   $sql = "SELECT * FROM cursos WHERE id IN (SELECT id_curso FROM alumnos_cursos WHERE id_alumno=:id_alumno)";
   $consulta = $conexionBD->prepare($sql);
   $consulta->bindParam(':id_alumno',$alumno['id']);
   $consulta->execute();
   $cursosAlumno = $consulta->fetchAll();
   $alumnos[$clave]['cursos'] = $cursosAlumno;
}

$sql = "SELECT * FROM cursos";
$listaCursos = $conexionBD->query($sql);
$cursos = $listaCursos->fetchAll();


?>