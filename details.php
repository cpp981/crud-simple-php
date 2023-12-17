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
        <title>Detalle</title>
    </head>
    <body style="background:aqua">
        <h2 style="text-align:center; font-weight:bold">Detalle Producto</h2>
        <br>
        <div class="container mt-3 text-center">
            <table class="table table-borderless bg-info bg-gradient rounded">
            <?php
            //If we receive "id" we paint the table with the data
            if(isset($_GET['id'])){
                $id = $_GET["id"];
                $consulta = "SELECT * FROM productos WHERE id=$id";
                try{    
                    $resultado = $conexProyecto->query($consulta);
                }catch(PDOException $e){
                    $error = true;
                    $mensaje = $e->getMessage();
                    $conexProyecto = null;
                }
                if(!$error){  
                    //If the SQL query not generate errors
                    echo "<thead>";
                    while($registro = $resultado->fetch()){
                        echo "<tr class='text-center text-white font-weight-bold'><th scope='col'>".$registro['nombre']."</th></tr>";
                        echo "</thead>";
                        echo "<tr class='fs-1 text-white text-center'>";
                        echo "<td>Código: ".$registro['id']."</td>";
                        echo "</tr>";
                        echo "<tr class='text-white text-left'>";
                        echo "<td>Nombre: ".$registro['nombre']."</td>";
                        echo "</tr>";
                        echo "<tr class='text-white text-left'>";
                        echo "<td>Nombre Corto: ".$registro['nombre_corto']."</td>";
                        echo "</tr>";
                        echo "<tr class='text-white text-left'>";
                        echo "<td>Código Familia: ".$registro['familia']."</td>";
                        echo "</tr>";
                        echo "<tr class='text-white text-left'>";
                        echo "<td>PVP(€): ".$registro['pvp']."</td>";
                        echo "</tr>";
                        echo "<tr class='text-white text-left'>";
                        echo "<td>Descripción: ".$registro['descripcion']."</td>";
                        echo "</tr>";
                        echo "</table><br><br>";
                        echo "<a href='list.php' class='btn text-white bg-info mb-1'>Volver</a>";
                    }
                    $conexProyecto = null;
                }
            }else{
                if($error){
                    echo "<div class='container mt-3'><p class='text-danger font-weight-bold'>$mensaje</p></div>";
                    echo "<a href='list.php' class='btn text-white bg-info mb-1'>Volver</a>";

                }
                header('Location:list.php'); 
            }
            ?>
        </div>
    </body>
</html>