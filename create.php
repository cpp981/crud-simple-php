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
        <title>Crear</title>
    </head>
    <body style="background:aqua">
        <h2 style="text-align:center; font-weight:bold">Crear Producto</h2>
        <br>
        <div class="container mt-3 text-center">
            <?php
            //If we receive "send", retrieve the data from the html form and INSERT into DB
                if(isset($_POST['enviar'])){
                    $nombre = $_POST['nombre'];
                    $nombreCorto = $_POST['nombre_corto'];
                    $pvp = (int)$_POST['precio'];
                    $fam = $_POST['familia'];
                    $descrip = $_POST['descripcion'];
                    $ok = true;
                    $insert = "INSERT INTO productos (nombre, nombre_corto, pvp, familia, descripcion) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conexProyecto->prepare($insert);
                    $stmt->bindParam(1, $nombre);
                    $stmt->bindParam(2, $nombreCorto);
                    $stmt->bindParam(3, $pvp);
                    $stmt->bindParam(4, $fam);
                    $stmt->bindParam(5, $descrip);
                    try{
                        $ok = $stmt->execute();
                    }catch(PDOException $e){
                        $error = true;
                        $mensaje = $e->getMessage();
                        $conexProyecto = null;
                    }
                    if(!$error){
                        //If error
                        echo "<p class='font-weight-bold'>Registro creado correctamente</p>";
                        echo "<a href='list.php' class='btn text-white bg-info mb-1'>Volver</a>";
                        $conexProyecto = null;
                    }
                    //If we don't receive send we paint html form
                }else{
            ?>
            <form name="f1" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="n" class="font-weight-bold float-left">Nombre</label>
                        <input type="text" class="form-control" id="n" name="nombre" placeholder="Nombre">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nc"class="font-weight-bold float-left">Nombre Corto</label>
                        <input type="text" class="form-control" id="nc" name="nombre_corto" placeholder="Nombre Corto">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="pvp" class="font-weight-bold float-left">Precio (€)</label>
                        <input type="text" class="form-control" id="pvp" name="precio" placeholder="Precio (€)">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fam" class="font-weight-bold float-left">Familia</label>
                        <select id="fam" class="form-control" name="familia">
                            <?php
                                //Fill in the select from form with the corresponding data from the db
                                $consulta = "SELECT cod, nombre FROM familias ORDER BY nombre";
                                try{
                                    $resultado = $conexProyecto->query($consulta);
                                }catch(PDOException $e){
                                    $error = true;
                                    $mensaje = $e->getMessage();
                                    $conexProyecto = null;
                                }
                                if(!$error){
                                    while($registro = $resultado->fetch()){
                                        echo "<option name='familia' style='' value='{$registro['cod']}'>".$registro['nombre'];
                                        echo "</option>";
                                    }
                                }    
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="d" class="font-weight-bold float-left">Descripción</label>
                    <textarea id="d" class="form-control h-auto" rows="15" name="descripcion"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="submit" class="btn text-white bg-primary mr-1  float-left" value="Crear" name="enviar">
                        <input type="reset" class="btn text-white btn-success mr-1 ml-3 float-left" value="Limpiar">
                        <a href="list.php" class="btn text-white bg-primary mb-1 ml-3 float-left">Volver</a>
                    </div>
                </div>
            </form>
            <?php if($error){
                    echo "<div class='container mt-3'><p class='text-danger font-weight-bold'>$mensaje</p></div>";
                    echo "<a href='list.php' class='btn text-white bg-info mb-1'>Volver</a>";
            }}?>
        </div>
    </body>
</html>    