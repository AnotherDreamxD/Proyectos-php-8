<?php 
session_start();
if($_POST){
    
    $mensaje = "usuario y contraseña incorrecto";

    if ($_POST['usuario']=='admin' && $_POST['password']=='admin') {
        $_SESSION['usuario'] = $_POST['usuario'];
        echo "loginCorrecto";
        header('Location: secciones/index.php');
    }else{
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.0-beta1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

</head>

<body>
    <div class="container">

        <div class="row">

            <div class="col-md-4">
            </div>


            <div class="col-md-4">
                <br>
                <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        Inicio de sessión
                    </div>
                    <div class="card-body">
                        <?php if(isset($mensaje)):?>
                            <div class="alert alert-danger" role="alert">
                                <strong><?= $mensaje ?> </strong>
                            </div>
                               
                        <?php endif;?>
                         
                        <div class="mb-3">
                            <label for="" class="form-label">Usuario</label>
                            <input type="text" class="form-control" name="usuario" id="usuario" placeholder="">
                            <small id="helpId" class="form-text text-muted">Escriba su usuario</small>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="password">
                            <small id="helpId" class="form-text text-muted">Escriba su contraseña</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Iniciar sesión</button>

                    </div>



                </div>
                </form>
            </div>

            <div class="col-md-4">
            </div>

        </div>

    </div>

</body>

</html>