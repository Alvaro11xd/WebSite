<?php
include("../../bd.php");

// Recuperando datos de la BD
if (isset($_GET['id'])) {
    $id = (isset($_GET['id'])) ? $_GET['id'] : "";
    $sentencia = $conexion->prepare("SELECT * FROM tbl_equipo WHERE id=:id");
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
    $profesional = $sentencia->fetch(PDO::FETCH_LAZY);

    $imagen = $profesional['imagen'];
    $nombreCompleto = $profesional['nombreCompleto'];
    $puesto = $profesional['puesto'];
    $twitter = $profesional['twitter'];
    $facebook = $profesional['facebook'];
    $linkedin = $profesional['linkedin'];
}

if ($_POST) {
    // Recepcionando los valores del formulario
    $id = (isset($_POST['id'])) ? $_POST['id'] : "";
    $nombreCompleto = (isset($_POST['name'])) ? $_POST['name'] : "";
    $puesto = (isset($_POST['puesto'])) ? $_POST['puesto'] : "";

    $twitter = (isset($_POST['twitter'])) ? $_POST['twitter'] : "";
    $facebook = (isset($_POST['facebook'])) ? $_POST['facebook'] : "";
    $linkedin = (isset($_POST['linkedin'])) ? $_POST['linkedin'] : "";

    // creando consulta
    $sentencia = $conexion->prepare("UPDATE tbl_equipo SET imagen=:imagen,nombreCompleto=:nombreCompleto,puesto=:puesto,twitter=:twitter,facebook=:facebook,linkedin=:linkedin WHERE id=:id;");

    // emparejando datos
    $sentencia->bindParam(':imagen', $imagen);
    $sentencia->bindParam(':nombreCompleto', $nombreCompleto);
    $sentencia->bindParam(':puesto', $puesto);
    $sentencia->bindParam(':twitter', $twitter);
    $sentencia->bindParam(':facebook', $facebook);
    $sentencia->bindParam(':linkedin', $linkedin);
    $sentencia->bindParam(':id', $id);

    // ejecutando consulta
    $sentencia->execute();

    // Actualizando imagen
    if ($_FILES['imagen']['tmp_name'] != "") {

        $imagen = (isset($_FILES['imagen']['name'])) ? $_FILES['imagen']['name'] : "";
        $fecha_imagen = new DateTime();
        $nombre_imagen = ($imagen != "") ? $fecha_imagen->getTimestamp() . "_" . $imagen : "";
        $tmp_imagen = $_FILES['imagen']['tmp_name'];

        move_uploaded_file($tmp_imagen, "../../../assets/img/team/" . $nombre_imagen);

        // Borrando imagen antigua
        $sentencia = $conexion->prepare("SELECT imagen FROM tbl_equipo WHERE id=:id;");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);

        // Borrando la imagen de la BD
        if (isset($registro_imagen['imagen'])) {
            if (file_exists("../../../assets/img/team/" . $registro_imagen['imagen'])) {
                // Borrar imagen
                unlink("../../../assets/img/team/" . $registro_imagen['imagen']);
            }
        }

        // Actualizando imagen antigua
        $sentencia = $conexion->prepare("UPDATE tbl_equipo SET imagen=:imagen WHERE id=:id;");
        $sentencia->bindParam(":imagen", $nombre_imagen);
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
    }

    $mensaje = "Actualizado con éxito :)";
    header('location:index.php?mensaje=' . $mensaje);
}

?>

<?php include("../../templates/header.php")?>
<div class="card">
    <!-- Titulo de la card -->
    <div class="card-header">
        Editar Datos del Profesional
    </div>
    <!-- Cuerpo de la card -->
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <!-- Imagen -->
            <div class="d-flex align-items-center gap-5">
                <div>
                    <img width="100" src="../../../assets/img/team/<?php echo $imagen ?>" alt="">
                </div>
                <div>
                    <input type="file" class="form-control" name="imagen">
                </div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre Completo:</label>
                <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" value="<?php echo $nombreCompleto; ?>">
            </div>
            <div class="mb-3">
                <label for="puesto" class="form-label">Puesto:</label>
                <input type="text" class="form-control" name="puesto" value="<?php echo $puesto; ?>">
            </div>
            <div class="mb-3">
                <label for="twitter" class="form-label">Twitter:</label>
                <input type="text" class="form-control" name="twitter" id="twitter" aria-describedby="helpId" value="<?php echo $twitter; ?>">
            </div>
            <div class="mb-3">
                <label for="facebook" class="form-label">Facebook:</label>
                <input type="text" class="form-control" name="facebook" id="facebook" value="<?php echo $facebook; ?>">
            </div>
            <div class="mb-3">
                <label for="linkedin" class="form-label">Linkedin:</label>
                <input type="text" class="form-control" name="linkedin" value="<?php echo $linkedin; ?>">
            </div>
            

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="" id="" class="btn btn-outline-secondary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
</div>
<?php include("../../templates/footer.php")?>