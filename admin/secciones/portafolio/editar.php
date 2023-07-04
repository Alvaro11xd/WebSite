<?php
include("../../bd.php");

// Recuperando los datos del proyecto por su ID
if (isset($_GET['id'])) {
    $id = (isset($_GET['id'])) ? $_GET['id'] : "";
    $sentencia = $conexion->prepare("SELECT * FROM tbl_portafolio WHERE id=:id");
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
    $proyecto = $sentencia->fetch(PDO::FETCH_LAZY);
    $titulo = $proyecto['titulo'];
    $subtitulo = $proyecto['subtitulo'];
    $imagen = $proyecto['imagen'];
    $descripcion = $proyecto['descripcion'];
    $cliente = $proyecto['cliente'];
    $categoria = $proyecto['categoria'];
    $url = $proyecto['url'];
}

if ($_POST) {
    // Recepcionando los valores del formulario
    $id = (isset($_POST['id'])) ? $_POST['id'] : "";
    $titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : "";
    $subtitulo = (isset($_POST['subtitulo'])) ? $_POST['subtitulo'] : "";

    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : "";
    $cliente = (isset($_POST['cliente'])) ? $_POST['cliente'] : "";
    $categoria = (isset($_POST['categoria'])) ? $_POST['categoria'] : "";
    $url = (isset($_POST['url'])) ? $_POST['url'] : "";

    // creando consulta
    $sentencia = $conexion->prepare("UPDATE tbl_portafolio SET titulo=:titulo,subtitulo=:subtitulo,imagen=:imagen,descripcion=:descripcion,cliente=:cliente,categoria=:categoria,url=:url WHERE id=:id;");

    // emparejando datos
    $sentencia->bindParam(':titulo', $titulo);
    $sentencia->bindParam(':subtitulo', $subtitulo);
    $sentencia->bindParam(':imagen', $imagen);
    $sentencia->bindParam(':descripcion', $descripcion);
    $sentencia->bindParam(':cliente', $cliente);
    $sentencia->bindParam(':categoria', $categoria);
    $sentencia->bindParam(':url', $url);
    $sentencia->bindParam(':id', $id);

    // ejecutando consulta
    $sentencia->execute();

    // Actualizando imagen
    if ($_FILES['imagen']['tmp_name'] != "") {

        $imagen = (isset($_FILES['imagen']['name'])) ? $_FILES['imagen']['name'] : "";
        $fecha_imagen = new DateTime();
        $nombre_imagen = ($imagen != "") ? $fecha_imagen->getTimestamp() . "_" . $imagen : "";
        $tmp_imagen = $_FILES['imagen']['tmp_name'];

        move_uploaded_file($tmp_imagen, "../../../assets/img/portfolio/" . $nombre_imagen);

        // Borrando imagen antigua
        $sentencia = $conexion->prepare("SELECT imagen FROM tbl_portafolio WHERE id=:id;");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);

        // Borrando la imagen de la BD
        if (isset($registro_imagen['imagen'])) {
            if (file_exists("../../../assets/img/portfolio/" . $registro_imagen['imagen'])) {
                // Borrar imagen
                unlink("../../../assets/img/portfolio/" . $registro_imagen['imagen']);
            }
        }

        // Actualizando imagen antigua
        $sentencia = $conexion->prepare("UPDATE tbl_portafolio SET imagen=:imagen WHERE id=:id;");
        $sentencia->bindParam(":imagen", $nombre_imagen);
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
    }

    $mensaje = "Actualizado con éxito :)";
    header('location:index.php?mensaje=' . $mensaje);
}
?>



<?php include("../../templates/header.php") ?>

<div class="card">
    <div class="card-header">
        Editar datos del proyecto
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="icono" aria-describedby="helpId" placeholder="Ingrese el títiulo" value="<?php echo $titulo; ?>">
            </div>
            <div class="mb-3">
                <label for="subtitulo" class="form-label">Subtítulo:</label>
                <input type="text" class="form-control" name="subtitulo" id="titulo" aria-describedby="helpId" placeholder="Ingrese el subtítulo" value="<?php echo $subtitulo; ?>">
            </div>
            <div class="d-flex gap-5">
                <div>
                    <img width="100" src="../../../assets/img/portfolio/<?php echo $imagen ?>" alt="">
                </div>
                <input type="file" class="form-control" name="imagen">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3"><?php echo $descripcion; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="cliente" class="form-label">Cliente:</label>
                <input type="text" class="form-control" name="cliente" value="<?php echo $cliente; ?>">
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría:</label>
                <input type="text" class="form-control" name="categoria" value="<?php echo $categoria; ?>">
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">URL:</label>
                <input type="text" class="form-control" name="url" value="<?php echo $url; ?>">
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="" id="" class="btn btn-outline-secondary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
    <div class="card-footer text-muted">

    </div>
</div>

<?php include("../../templates/footer.php") ?>