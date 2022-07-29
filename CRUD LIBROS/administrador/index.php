<?php 
    session_start();
    if ($_POST) {
        #cambiar el if por una consulta a la base de datos
        if (($_POST['usuario'] == "miguel")&&($_POST['contraseña']=="sistema")) {
            $_SESSION['usuario']="ok";
            $_SESSION['nombreUsuario'] = "miguel";
            header('Location:inicio.php');
        }else{
            $mensaje = "ERROR: el usuario o contraseña son incorrectos";
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

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                
            </div>

            <div class="col-md-4">
                <br><br><br>
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                    <?php if (isset($mensaje)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?=$mensaje?>
                        </div>
                    <?php endif; ?>
                        <form method="POST" >

                        <div class = "form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" name="usuario" placeholder="Escribe tu Usuario">
                        </div>

                        <div class="form-group">
                        <label for="contraseña">Contraseña:</label>
                        <input type="password" class="form-control" name="contraseña" placeholder="Escribe tu contraseña">
                        </div>
                       
                        <button type="submit" class="btn btn-primary">Entrar al Administrador</button>

                        </form>
                        
                    </div>
                  
                </div>
            </div>
            
        </div>
    </div>

</body>
</html>