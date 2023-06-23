<?php
include("../../bd.php");
if ($_POST) {
    // validando información
    $icono = (isset($_POST['icono'])) ? $_POST['icono'] : "";
    $titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : "";
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : "";

    // creando consulta
    $sentencia=$conexion->prepare("INSERT INTO tbl_servicios(icono,titulo,descripcion) VALUES (:icono,:titulo,:descripcion);");

    // emparejando datos
    $sentencia->bindParam(':icono',$icono);
    $sentencia->bindParam(':titulo',$titulo);
    $sentencia->bindParam(':descripcion',$descripcion);

    // ejecutando consulta
    $sentencia->execute();
}
?>



<?php include("../../templates/header.php") ?>

<div class="card">
    <div class="card-header">
        Ingresar los datos
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="" class="form-label">Icono:</label>
                <input type="text" class="form-control" name="icono" id="icono" aria-describedby="helpId" placeholder="Icono">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Ingrese el título">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-outline-secondary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
    <div class="card-footer text-muted">

    </div>
</div>

<?php include("../../templates/footer.php") ?>