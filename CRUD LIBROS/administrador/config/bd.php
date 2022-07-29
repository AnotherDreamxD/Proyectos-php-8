<?php 


    $host="localhost";
    $db = "sitio";
    $user = "root";
    $password = "";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$db",$user,$password);
        if ($conexion) {
      
        }
    } catch (Exception $e) {
    
        echo $e->getMessage();
    }

?>