<?php require_once('../templates/cabecera.php') ?>
<?php require_once('../secciones/alumnos.php') ?>


<div class="row">
    <div class="col-md-5">
        <form action="" method="post">

            <div class="card">
                <div class="card-header">
                    Alumnos
                </div>
                <div class="card-body">
                    <div class="mb-3 d-none">
                        <label for="" class="form-label">ID</label>
                        <input type="text" class="form-control" name="id" id="id" value="<?=$id?>" aria-describedby="helpId" placeholder="">
                       
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" value="<?=$nombre?>"  aria-describedby="helpId" placeholder="">
                      
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" id="apellidos" value="<?=$apellidos?>" aria-describedby="helpId" placeholder="">
                      
                    </div>

                    <div class="mb-3">
                      <label for="cursos[]" class="form-label">Curso del Alumno</label>
                      <select multiple class="form-control" name="cursos[]"  id="listaCursos">
                    
                      <?php foreach ($cursos as $curso): ?>
                        <option 
                        
                        <?php if (!empty($arregloCursos)):
                        
                                if (in_array($curso['id'], $arregloCursos)):
                                    echo 'selected';
                                endif;
                        
                              endif;?>
                        
                        value="<?=$curso['id']?>"> <?=$curso['id']." ".$curso['nombre_curso'] ?> </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name = "accion" value="agregar" class="btn btn-success">Agregar</button>
                        <button type="submit" name = "accion" value="editar" class="btn btn-warning">Editar</button>
                        <button type="submit" name = "accion" value="borrar" class="btn btn-danger">Borrar</button>
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
                
            <?php foreach ($alumnos as $alumno): ?>
                <tr>
                    <td><?=$alumno['id'] ?> </td>
                    <td><?=$alumno['nombre']." ".$alumno['apellidos'] ?><br>

                        <?php foreach ($alumno['cursos'] as $curso):?>
                          
                           -<a href="certificado.php?id_curso=<?=$curso['id']?>&id_alumno=<?=$alumno['id']?>"> <i class="bi bi-filetype-pdf text-danger"></i>  <?php echo $curso['nombre_curso']?></a><br>
                            
                        <?php endforeach;?>
                    </td>
                    <td>
                        <form action="" method="post">
                            <div class="mb-3">
                              <label for="" class="form-label"></label>
                              <input type="hidden" class="form-control" name="id" id="id" value=" <?= $alumno['id'] ?>" >
                              <input type="submit" value="seleccionar" name="accion" class="btn btn-info">
                            </div>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
             
            </tbody>
        </table>

    </div>
</div>


<link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.3/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.3/dist/js/tom-select.complete.min.js"></script>

<script>
    new TomSelect('#listaCursos')
</script>
<?php require_once('../templates/pie.php') ?>