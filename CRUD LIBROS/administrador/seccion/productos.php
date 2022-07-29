<?php require_once('../template/cabecera.php') ?>
<?php require_once('../config/bd.php');

$txtID = "";
$txtImagen="";
$txtNombre = "";
$accion = "";

if ($_POST) {



    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
    $txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
    $accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";



    if ($accion == 'Agregar') {

        $sql = "INSERT INTO libros(nombre,imagen) VALUES(:nombre,:imagen);";
        $insertSql = $conexion->prepare($sql);
        $insertSql->bindParam(':nombre', $txtNombre);

        $fecha = new DateTime();
        $nombreArchivo = ($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES['txtImagen']["name"]:"imagen.jpg";

        $tmpImagen = $_FILES['txtImagen']['tmp_name'];
        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        }
        $insertSql->bindParam(':imagen', $nombreArchivo);
        $insertSql->execute();
        header("Location:productos.php");

    } elseif ($accion == 'Modificar') {

        $queryModificar = "UPDATE libros SET nombre = :nombre";

        if ($txtImagen != "") {
            
            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES['txtImagen']["name"]:"imagen.jpg";
            $tmpImagen = $_FILES['txtImagen']['tmp_name'];
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

            
            $querySelect = "SELECT imagen FROM libros WHERE id =:id";
            $selectSql = $conexion->prepare($querySelect);
            $selectSql->bindParam(':id',$txtID);
            $selectSql->execute();
            $libro = $selectSql->fetch(PDO::FETCH_LAZY);

            if ( isset($libro["imagen"]) && ($libro['imagen'] != "imagen.jpg")) {
                if (file_exists("../../img/".$libro['imagen'])) {
                    
                        unlink("../../img/".$libro['imagen']);
                }
            }

            $queryModificar.=", imagen = :imagen WHERE id = :id";
            $updateSql = $conexion->prepare($queryModificar);
            $updateSql->bindParam(':imagen',$nombreArchivo);
            $updateSql->bindParam(':id',$txtID);
            $updateSql->bindParam(':nombre',$txtNombre);
            $updateSql->execute();
        }else{
            $queryModificar.=" WHERE id = :id";
            $updateSql = $conexion->prepare($queryModificar);
            $updateSql->bindParam(':id',$txtID);
            $updateSql->bindParam(':nombre',$txtNombre);
            $updateSql->execute();
        }
        
        header("Location:productos.php");
        
    } elseif ($accion == "Cancelar") {
      
        header("Location:productos.php");

    } elseif ($accion == "Seleccionar") {
                
        $querySelect = "SELECT * FROM libros WHERE id =:id";
        $selectSql = $conexion->prepare($querySelect);
        $selectSql->bindParam(':id',$txtID);
        $selectSql->execute();
        $libro = $selectSql->fetch(PDO::FETCH_LAZY);

        $txtID = $libro['id'];
        $txtNombre = $libro['nombre'];
        $txtImagen = $libro['imagen'];


    } elseif ($accion == "Borrar") {


        $querySelect = "SELECT imagen FROM libros WHERE id =:id";
        $selectSql = $conexion->prepare($querySelect);
        $selectSql->bindParam(':id',$txtID);
        $selectSql->execute();
        $libro = $selectSql->fetch(PDO::FETCH_LAZY);

        if ( isset($libro["imagen"]) && ($libro['imagen'] != "imagen.jpg")) {
           if (file_exists("../../img/".$libro['imagen'])) {
               
                unlink("../../img/".$libro['imagen']);
           }
        }

        $queryDelete = "DELETE FROM libros WHERE id =:id";
        $deleteSql = $conexion->prepare($queryDelete);
        $deleteSql->bindParam(':id',$txtID);
        $deleteSql->execute();
        
        header("Location:productos.php");
    } else {
        echo "no modifique el codigo porfavor";
    }
}


$querySelect = "SELECT * FROM libros;";
$selectSql = $conexion->prepare($querySelect);
$selectSql->execute();
$listaLibros = $selectSql->fetchAll(PDO::FETCH_ASSOC);

?>


<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos de Libro
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly class="form-control" name="txtID" id="txtID" placeholder="Ingresa el ID" value = "<?=$txtID?>">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" name="txtNombre" id="txtNombre" placeholder="Ingresa el Nombre" value = "<?=$txtNombre?>" >
                </div>

                <div class="form-group">
                    <label for="txtImagen">Imagen:</label>
                    
                    <?=$txtImagen?>
                    <br>

                    <?php if ($txtImagen): ?>

                        <img class="img-thumbnail rounded" src="../../img/<?=$txtImagen?>" alt="" srcset="" width="100px">
                    <?php endif; ?>

                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Ingresa la Imagen" >
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?= ($accion == "Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?= ($accion != "Seleccionar")?"disabled":""; ?>value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?= ($accion != "Seleccionar")?"disabled":""; ?>value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>

    </div>




</div>

<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaLibros as $libro) : ?>
                <tr>
                    <td><?= $libro['id']; ?> </td>
                    <td><?= $libro['nombre']; ?></td>
                    <td>
                      <img class="img-thumbnail rounded" src="../../img/<?= $libro['imagen']; ?>" alt="" srcset="" width="100px">  
                    </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" value="<?= $libro['id'] ?>" id="txtID">
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</div>


<?php require_once('../template/pie.php') ?>