<?php
//Start db connection
require 'dbConnection.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!--BOOTSTRAP-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>GESTOR DE PRODUCTOS</title>
    </head>
    <body style="background:aqua">

        <h2 style="text-align:center; font-weight:bold">Gestión de Productos</h2>
        <br>
        <div class="container mt-3">
            <a href='./create.php' class='btn btn-success mb-2'>Crear</a>
            <table class="table table-striped table-dark">
            <?php
                //Take the data
                $consulta = "SELECT id, nombre FROM productos ORDER BY nombre";
                try{
                    $resultado = $conexProyecto->query($consulta);
                }catch(PDOException $e){
                    $error = true;
                    $mensaje = $e->getMessage();
                    $conexProyecto = null;
                }
                if(!$error){
                    //If not errors, paint the table
                    echo "<thead>";
                    echo "<tr class='text-center font-weight-bold'><th scope='col'>Detalle</th>";
                    echo "<th scope='col'>Código</th><th scope='col'>Nombre</th><th scope='col'>Acciones</th></tr>";
                    echo "</thead>";
                    while($registro = $resultado->fetch()){
                        echo "<tr class='text-center'>";
                        echo "<td><a href='./details.php?id={$registro['id']}' class='btn text-white bg-primary mb-1'>Detalle</a></td><td class='text-center'>".$registro['id']."</td><td class='text-center'>".$registro['nombre']."</td>";
                        //Form POST
                        echo "<td><form action='delete.php' method='POST'><a href='./update.php?id={$registro['id']}' class='btn bg-warning mb-1 mr-2'>Actualizar</a><input type='hidden' name='id' value='{$registro['id']}'>";
                        echo "<input type='submit' class='btn text-white btn-danger mb-1' value='Borrar' name='enviar'></form></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    $conexProyecto = null;
                }
            ?>

        </div>
            </div>
            <?php
                if($error){
                    echo "<div class='container mt-3'><p class='text-danger font-weight-bold'>$mensaje</p></div>";
                    echo "<a href='./list.php' class='btn text-white bg-info mb-1'>Volver</a>";
                }
            ?>

</body>
</html>