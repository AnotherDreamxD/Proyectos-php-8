<?php require_once('template/cabecera.php') ?>
<?php require_once('administrador/config/bd.php') ?>


<?php
        $querySelect = "SELECT * FROM libros";
        $selectSql = $conexion->prepare($querySelect);
        $selectSql->execute();
        $libros = $selectSql->fetchAll(PDO::FETCH_ASSOC);

?>

<?php foreach ($libros as $libro): ?>
<div class="col-md-3">

    <div class="card">

        <img class="card-img-top" src="img/<?=$libro['imagen']?>" alt="" width="100px">

        <div class="card-body">
            <h4 class="card-title"><?= $libro['nombre']; ?></h4>
            <a name="" id="" class="btn btn-primary" href="https://goalkicker.com" role="button">Ver Más</a>
        </div>

    </div>
</div>
<?php endforeach; ?>






<?php require_once('template/pie.php') ?>