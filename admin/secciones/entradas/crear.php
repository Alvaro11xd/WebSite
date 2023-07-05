<?php
include("../../bd.php");

if($_POST){

    // Identificando datos del formulario
    $fecha=(isset($_POST['fecha'])) ? $_POST['fecha'] : "";
    $titulo=(isset($_POST['titulo'])) ? $_POST['titulo'] : "";
    $descripcion=(isset($_POST['descripcion'])) ? $_POST['descripcion'] : "";
    $imagen=(isset($_FILES['imagen']['name'])) ? $_FILES['imagen']['name'] : "";

    // Adjuntando la imagen al proyecto para luego subirla a la BD
    $fecha_imagen=new DateTime();
    $nombre_imagen=($imagen!="") ? $fecha_imagen->getTimestamp() . "_" . $imagen : "";

    $tmp_imagen=$_FILES['imagen']['tmp_name'];
    if($tmp_imagen!=""){
        move_uploaded_file($tmp_imagen,"../../../assets/img/about/" . $nombre_imagen);
    }

    // Insertando datos en la BD
    $sentencia=$conexion->prepare("INSERT INTO tbl_entradas(fecha,titulo,descripcion,imagen)
                                VALUES (:fecha,:titulo,:descripcion,:imagen)");
    $sentencia->bindParam(":fecha",$fecha);
    $sentencia->bindParam(":titulo",$titulo);
    $sentencia->bindParam(":descripcion",$descripcion);
    $sentencia->bindParam(":imagen",$nombre_imagen);

    $sentencia->execute();

    // Redireccionando al usuario
    $mensaje = "Creado con éxito :)";
    header('location:index.php?mensaje=' . $mensaje);
}

?>

<?php include("../../templates/header.php")?>

<div class="card">
    <!-- Titulo de la card -->
    <div class="card-header">
        Datos de la Entrada
    </div>
    <!-- Cuerpo de la card -->
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" class="form-control" name="fecha" id="fecha">
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Ingrese el Título">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="imagen">
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-outline-secondary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php include("../../templates/footer.php")?>