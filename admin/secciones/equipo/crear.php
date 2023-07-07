<?php
include("../../bd.php");

if($_POST){
    // validar la información del formulario
    $imagen=(isset($_FILES['imagen']['name'])) ? $_FILES['imagen']['name'] : "";
    $nombreCompleto=(isset($_POST['name'])) ? $_POST['name'] : "";
    $puesto=(isset($_POST['puesto'])) ? $_POST['puesto'] : "";
    $twitter=(isset($_POST['twitter'])) ? $_POST['twitter'] : "";
    $facebook=(isset($_POST['facebook'])) ? $_POST['facebook'] : "";
    $linkedin=(isset($_POST['linkedin'])) ? $_POST['linkedin'] : "";

    // adjuntando la imagen al proyecto
    $fecha_imagen=new DateTime();
    $nombre_imagen=($imagen!="") ? $fecha_imagen->getTimestamp()."_".$imagen : "";
    $tmp_imagen=$_FILES['imagen']['tmp_name'];
    if($tmp_imagen!=""){
        move_uploaded_file($tmp_imagen, "../../../assets/img/team/".$nombre_imagen);
    }

    // creando consulta
    $sentencia=$conexion->prepare("INSERT INTO tbl_equipo(imagen,nombreCompleto,puesto,twitter,facebook,linkedin) VALUES (:imagen,:nombreCompleto,:puesto,:twitter,:facebook,:linkedin);");

    // emparejando datos
    $sentencia->bindParam(':imagen',$nombre_imagen);
    $sentencia->bindParam(':nombreCompleto',$nombreCompleto);
    $sentencia->bindParam(':puesto',$puesto);
    $sentencia->bindParam(':twitter',$twitter);
    $sentencia->bindParam(':facebook',$facebook);
    $sentencia->bindParam(':linkedin',$linkedin);

    // ejecutando consulta
    $sentencia->execute();
    header('location:index.php');
}

?>

<?php include("../../templates/header.php") ?>
<div class="card">
    <!-- Titulo de la card -->
    <div class="card-header">
        Profesional del Equipo
    </div>
    <!-- Cuerpo de la card -->
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre Completo:</label>
                <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="Ingrese su nombre completo">
            </div>
            <div class="mb-3">
                <label for="puesto" class="form-label">Puesto:</label>
                <input type="text" class="form-control" name="puesto" placeholder="Puesto del Profesional">
            </div>
            <div class="mb-3">
                <label for="twitter" class="form-label">Twitter:</label>
                <input type="text" class="form-control" name="twitter" id="twitter" aria-describedby="helpId" placeholder="Twitter">
            </div>
            <div class="mb-3">
                <label for="facebook" class="form-label">Facebook:</label>
                <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Facebook">
            </div>
            <div class="mb-3">
                <label for="linkedin" class="form-label">Linkedin:</label>
                <input type="text" class="form-control" name="linkedin" placeholder="Linkedin">
            </div>
            

            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-outline-secondary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
</div>
<?php include("../../templates/footer.php") ?>