<?php
//Start db connection
require 'dbConnection.php';
session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!--BOOTSTRAP-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Update</title>
    </head>
    <body style="background:aqua">
        <h2 style="text-align:center; font-weight:bold">Modificar Producto</h2>
        <br>
        <div class="container mt-3 text-center">
            <?php 
                //If we receive "enviar", we put the data in array
                if(isset($_POST['enviar'])){
                    $_SESSION[0]=$_POST['id'];
                    $_SESSION[1]=$_POST['nombre'];
                    $_SESSION[2]=$_POST['nombre_corto'];
                    $_SESSION[3]=$_POST['descripcion'];
                    $_SESSION[4]=$_POST['precio'];
                    $_SESSION[5]=$_POST['familia'];
                    
                    $ok=true;
                    $update = "UPDATE productos SET nombre = ?, nombre_corto = ?, descripcion = ?, pvp = ?, familia = ? WHERE id = ?";

                    //SQL query by parameters
                    $s = $conexProyecto->prepare($update);
                    $s->bindParam(1, $_SESSION[1]);
                    $s->bindParam(2, $_SESSION[2]);
                    $s->bindParam(3, $_SESSION[3]);
                    $s->bindParam(4, $_SESSION[4]);
                    $s->bindParam(5, $_SESSION[5]);
                    $s->bindParam(6, $_SESSION[0]);
                    try{   
                        $s->execute();
                    }catch(PDOException $e){
                        $error = true;
                        $mensaje = $e->getMessage();
                        $conexProyecto = null;
                    }
                    if(!$error){
                        //If not errors
                        session_abort();
                        echo "<p class='font-weight-bold'>Registro actualizado correctamente</p><br>";
                        echo "<a href='list.php' class='btn text-white bg-info mb-1'>Volver</a>";
                        $conexProyecto = null;
                    }
                }
                //If "id" exists, retrieve the data and paint html form
                    else if(isset($_GET['id'])){
                    $id=$_GET['id'];
                    $consulta = "SELECT nombre, nombre_corto, familia, pvp, descripcion FROM productos WHERE id=$id";
                    $resultado = $conexProyecto->query($consulta);
                    while($registro = $resultado->fetch()){
                       $nombre = $registro['nombre'];
                       $nombreCorto = $registro['nombre_corto'];
                       $pvp = $registro['pvp'];
                       $familia = $registro['familia'];
                       $desc = $registro['descripcion'];
                    }
            ?>
              <form name="f1" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="n" class="font-weight-bold float-left">Nombre</label>
                        <input type="text" class="form-control" id="n" name="nombre" value="<?php echo $nombre;?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nc" class="font-weight-bold float-left">Nombre Corto</label>
                        <input type="text" class="form-control" id="nc" name="nombre_corto" value="<?php echo $nombreCorto;?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="pvp" class="font-weight-bold float-left">Precio(€)</label>
                        <input type="text" class="form-control" id="pvp" name="precio" value="<?php echo $pvp;?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fam" class="font-weight-bold float-left">Familia</label>
                        <select id="fam" class="form-control" name="familia">
                            <?php
                                $consulta = "SELECT cod, nombre FROM familias WHERE cod = '$familia'";
                                try{
                                    $resultado = $conexProyecto->query($consulta);
                                }catch(PDOException $e){
                                    $error = true;
                                    $mensaje = $e->getMessage();
                                    $conexProyecto = null;
                                }
                                if(!$error){
                                    while($registro = $resultado->fetch()){
                                         echo "<option name='familia' class='' value='{$registro['cod']}'>".$registro['nombre']."</option>";
                                    }
                                }
                            ?>
                            </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="d" class="font-weight-bold float-left">Descripción</label>
                    <textarea id="d" class="form-control h-auto" rows="15" name="descripcion"><?php echo $desc;?></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="hidden" name="id" value=<?php echo $id; ?>>
                        <input type="submit" class="btn text-white bg-primary mr-1 float-left" value="Modificar" name="enviar">
                        <a href="list.php" class="btn text-white bg-info mb-1 ml-3 float-left">Volver</a>               
                    </div>
                </div>
            </form>     
            <?php
                if($error){
                    echo "<div class='container mt-3'><p class='text-danger font-weight-bold'>$mensaje</p></div>";
                    echo "<a href='list.php' class='btn text-white bg-info mb-1'>Volver</a>";

                }
                }else header('Location:list.php');
            ?>
        </div>
    </body>
</html>