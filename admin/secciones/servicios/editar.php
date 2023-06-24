<?php
include("../../bd.php");

// Recuperando los datos del servicio por su ID
if (isset($_GET['id'])) {
    $id = ($_GET['id']) ? $_GET['id'] : "";
    $sentencia = $conexion->prepare("SELECT * FROM tbl_servicios WHERE id=:id");
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
    $servicio=$sentencia->fetch(PDO::FETCH_LAZY);
    $icono=$servicio['icono'];
    $titulo=$servicio['titulo'];
    $descripcion=$servicio['descripcion'];
}

if ($_POST) {
    // Recepcionando los valores del formulario
    $id = (isset($_POST['id'])) ? $_POST['id'] : "";
    $icono = (isset($_POST['icono'])) ? $_POST['icono'] : "";
    $titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : "";
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : "";

    // creando consulta
    $sentencia=$conexion->prepare("UPDATE tbl_servicios SET icono=:icono,titulo=:titulo,descripcion=:descripcion WHERE id=:id;");

    // emparejando datos
    $sentencia->bindParam(':icono',$icono);
    $sentencia->bindParam(':titulo',$titulo);
    $sentencia->bindParam(':descripcion',$descripcion);
    $sentencia->bindParam(':id',$id);

    // ejecutando consulta
    $sentencia->execute();
    $mensaje="Actualizado con éxito :)";
    header('location:index.php?mensaje='.$mensaje);
}
?>



<?php include("../../templates/header.php") ?>

<div class="card">
    <div class="card-header">
        Editar datos del servicio
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <div class="mb-3">
                <label for="" class="form-label">Icono:</label>
                <input type="text" class="form-control" name="icono" id="icono" aria-describedby="helpId" placeholder="Icono" value="<?php echo $icono;?>">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Ingrese el título" value="<?php echo $titulo;?>">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3"><?php echo $descripcion;?></textarea>
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="" id="" class="btn btn-outline-secondary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
    <div class="card-footer text-muted">

    </div>
</div>

<?php include("../../templates/footer.php") ?>