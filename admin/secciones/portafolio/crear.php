<?php
include("../../bd.php");
if ($_POST) {

    // validando información
    $titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : "";
    $subtitulo = (isset($_POST['subtitulo'])) ? $_POST['titulo'] : "";
    $imagen = (isset($_FILES['imagen']['name'])) ? $_FILES['imagen']['name'] : "";
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : "";
    $cliente = (isset($_POST['cliente'])) ? $_POST['cliente'] : "";
    $categoria = (isset($_POST['categoria'])) ? $_POST['categoria'] : "";
    $url = (isset($_POST['url'])) ? $_POST['url'] : "";

    // adjuntando imagen a la BD
    /*
        Creamos la fecha de la imagen.
        Validamos el nombre del archivo para moverlo a una carpeta de destino.
        Creamos el nombre temporal de la imagen para guardarlo y luego moverlo a una carpeta.
        Validamos si se seleccionó una imagen para luego moverla a la ruta de destino.
    */
    $fecha_imagen=new DateTime();
    $nombre_imagen=($imagen!="") ? $fecha_imagen->getTimestamp()."_".$imagen : "";
    $tmp_imagen=$_FILES['imagen']['tmp_name'];
    if($tmp_imagen!=""){
        move_uploaded_file($tmp_imagen, "../../../assets/img/portfolio/".$nombre_imagen);
    }


    // creando consulta
    $sentencia=$conexion->prepare("INSERT INTO tbl_portafolio(titulo,subtitulo,imagen,descripcion,cliente,categoria,url) VALUES (:titulo,:subtitulo,:imagen,:descripcion,:cliente,:categoria,:url);");

    // emparejando datos
    $sentencia->bindParam(':titulo',$titulo);
    $sentencia->bindParam(':subtitulo',$subtitulo);
    $sentencia->bindParam(':imagen',$nombre_imagen);
    $sentencia->bindParam(':descripcion',$descripcion);
    $sentencia->bindParam(':cliente',$cliente);
    $sentencia->bindParam(':categoria',$categoria);
    $sentencia->bindParam(':url',$url);

    // ejecutando consulta
    $sentencia->execute();
    header('location:index.php');
}
?>



<?php include("../../templates/header.php") ?>

<div class="card">
    <!-- Titulo de la card -->
    <div class="card-header">
        Producto del portafolio
    </div>
    <!-- Cuerpo de la card -->
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="icono" aria-describedby="helpId" placeholder="Ingrese el títiulo">
            </div>
            <div class="mb-3">
                <label for="subtitulo" class="form-label">Subtítulo:</label>
                <input type="text" class="form-control" name="subtitulo" id="titulo" aria-describedby="helpId" placeholder="Ingrese el subtítulo">
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="cliente" class="form-label">Cliente:</label>
                <input type="text" class="form-control" name="cliente">
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría:</label>
                <input type="text" class="form-control" name="categoria">
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">URL:</label>
                <input type="text" class="form-control" name="url">
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-outline-secondary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
    <div class="card-footer text-muted">

    </div>
</div>

<?php include("../../templates/footer.php") ?>