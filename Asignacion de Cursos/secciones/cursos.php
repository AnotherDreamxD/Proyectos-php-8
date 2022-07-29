<?php 


    require_once('../configuraciones/bd.php');
    $conexionBD = BD::crearInstancia();


    $id = isset($_POST['id'])?$_POST['id']: "";
    $nombre = isset($_POST['nombre_curso'])?$_POST['nombre_curso']: "";
    $accion = isset($_POST['accion'])?$_POST['accion']: "";


    if ($accion) {
        
            switch($accion){
                case 'agregar':
                    $sql = "INSERT INTO cursos (id, nombre_curso) VALUES (NULL, :nombre)";
                    $consulta = $conexionBD->prepare($sql);
                    $consulta->bindParam(':nombre',$nombre);
                    $consulta->execute();
                    
                    break;
                case 'editar':
                    
                    $sql = "UPDATE cursos SET nombre_curso = :nombre WHERE id = :id";
                    $consulta = $conexionBD->prepare($sql);
                    $consulta->bindParam(':id',$id);
                    $consulta->bindParam(':nombre',$nombre);
                    $consulta->execute();
                    
                    break;
                case 'borrar':
                    $sql = "DELETE FROM cursos WHERE id = :id";
                    $consulta = $conexionBD->prepare($sql);
                    $consulta->bindParam(':id',$id);
                    $consulta->execute();
                    break;

                case 'seleccionar':
                        $sql = "SELECT * FROM cursos WHERE id = :id";
                        $consulta = $conexionBD->prepare($sql);
                        $consulta->bindParam(':id',$id);
                        $consulta->execute();
                        $curso = $consulta->fetch(PDO::FETCH_ASSOC);
                        $nombre = $curso['nombre_curso'];
                        $id = $curso['id'];
                       

                    break;
            }
    }

    $consulta = $conexionBD->prepare("SELECT * FROM cursos");
    $consulta->execute();
    $listaCursos = $consulta->fetchAll();

?>