<?php require_once('../templates/cabecera.php') ?>
<?php require_once('../secciones/cursos.php') ?>


<div class="col-md-5">
    <form action="" method="post">
        <div class="card">
            <div class="card-header">
                Cursos
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <label for="" class="form-label">ID</label>
                    <input type="text" class="form-control" name="id" id="id"value="<?=$id ?>"  aria-describedby="helpId" placeholder="">

                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre_curso" id="nombre_curso" value="<?=$nombre ?>" aria-describedby="helpId" placeholder="Nombre del Curso">

                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name = "accion" class="btn btn-success" value="agregar">Agregar</button>
                    <button type="submit" name = "accion" class="btn btn-warning" value="editar">Editar</button>
                    <button type="submit" name = "accion" class="btn btn-danger" value="borrar">Borrar</button>
                </div>
            </div>

        </div>
    </form>

</div>



<div class="col-md-7">

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach($listaCursos as $curso): ?>
            <tr>
                <td><?=$curso['id'] ?></td>
                <td><?=$curso['nombre_curso'] ?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="id" id="id"value= "<?=$curso['id']?>">
                        <input type="submit" value="seleccionar" name="accion" class="btn btn-info">
                    </form>    
                </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
    </table>
    

</div>




<?php require_once('../templates/pie.php') ?>