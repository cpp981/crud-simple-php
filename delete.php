<?php
                                                //Simple delete page information

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
        <title>Borrar</title>
    </head>
    <body>
        <?php
            if(isset($_POST['id'])){
                $id = $_POST['id'];
                try{
                    $registro = $conexProyecto->exec("DELETE FROM productos WHERE id=$id");
                }catch(PDOException $e){
                    $error = true;
                    $mensaje = $e->getMessage();
                    $conexProyecto = null;
                }
                if(!$error){
                    echo "<br>";
                    echo "<p><b>Producto de Código: ".$id." Borrado correctamente.</b>&nbsp<a href='list.php' class='btn text-bold btn-sm border border-dark' style='width:100px ;background-color:gainsboro'>Volver</a></p>";
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
    </body>
</html>