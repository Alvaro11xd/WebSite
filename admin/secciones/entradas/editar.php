<?php
include("../../bd.php");

// Recuperando los datos del entrada por su ID
if (isset($_GET['id'])) {
    $id = (isset($_GET['id'])) ? $_GET['id'] : "";
    $sentencia = $conexion->prepare("SELECT * FROM tbl_entradas WHERE id=:id");
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
    $entrada = $sentencia->fetch(PDO::FETCH_LAZY);
    $fecha = $entrada['fecha'];
    $titulo = $entrada['titulo'];
    $descripcion = $entrada['descripcion'];
    $imagen = $entrada['imagen'];
}

// Proceso para actualizar los datos del formulario
if ($_POST) {
    // Recepcionando los valores del formulario
    $id = (isset($_POST['id'])) ? $_POST['id'] : "";
    $fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : "";
    $titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : "";
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : "";

    // creando consulta
    $sentencia = $conexion->prepare("UPDATE tbl_entradas SET fecha=:fecha,titulo=:titulo,descripcion=:descripcion,imagen=:imagen WHERE id=:id;");

    // emparejando datos
    $sentencia->bindParam(':fecha', $fecha);
    $sentencia->bindParam(':titulo', $titulo);
    $sentencia->bindParam(':descripcion', $descripcion);
    $sentencia->bindParam(':imagen', $imagen);
    $sentencia->bindParam(':id', $id);

    // ejecutando consulta
    $sentencia->execute();

    // Proceso para actualizar la imagen
    if ($_FILES['imagen']['tmp_name'] != "") {
        $imagen = (isset($_FILES['imagen']['name'])) ? $_FILES['imagen']['name'] : "";
        $fecha_imagen = new DateTime();
        $nombre_imagen = ($imagen != "") ? $fecha_imagen->getTimestamp() . "_" . $imagen : "";
        $tmp_imagen = $_FILES['imagen']['tmp_name'];

        move_uploaded_file($tmp_imagen, "../../../assets/img/about/" . $nombre_imagen);

        // Borrando imagen antigua
        $sentencia = $conexion->prepare("SELECT imagen FROM tbl_entradas WHERE id=:id;");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);

        // Borrando la imagen de la BD y del directorio / proyecto
        if ($registro_imagen['imagen']) {
            if (file_exists("../../../assets/img/about/" . $registro_imagen['imagen'])) {
                // Borrar imagen
                unlink("../../../assets/img/about/" . $registro_imagen['imagen']);
            }
        }

        // Actualizando imagen antigua a una nueva imagen
        $sentencia = $conexion->prepare("UPDATE tbl_entradas SET imagen=:imagen WHERE id=:id;");
        $sentencia->bindParam(":imagen", $nombre_imagen);
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
    }

    // Redireccionando al usuario
    $mensaje = "Actualizado con éxito :)";
    header('location:index.php?mensaje=' . $mensaje);
}

?>

<?php include("../../templates/header.php") ?>
<div class="card">
    <!-- Titulo de la card -->
    <div class="card-header">
        Editar Datos de la Entrada
    </div>
    <!-- Cuerpo de la card -->
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="helpId" value="<?php echo $titulo; ?>">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3"><?php echo $descripcion; ?></textarea>
            </div>
            <!-- Imagen -->
            <div class="d-flex align-items-center gap-5 mb-3">
                <img width="100" src="../../../assets/img/about/<?php echo $imagen; ?>" alt="">
                <div>
                    <input type="file" class="form-control" name="imagen" id="imagen">
                </div>
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="" id="" class="btn btn-outline-secondary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>
<?php include("../../templates/footer.php") ?>