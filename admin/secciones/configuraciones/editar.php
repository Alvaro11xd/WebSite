<?php
include("../../bd.php");

if(isset($_GET['id'])){
    $id=(isset($_GET['id'])) ? $_GET['id'] : "";

    $sql=$conexion->prepare("SELECT * FROM tbl_configuraciones WHERE id=:id;");

    $sql->bindParam(":id",$id);
    $sql->execute();

    $configuracion=$sql->fetch(PDO::FETCH_LAZY);

    $nameConfig=$configuracion['nombreConfiguracion'];
    $value=$configuracion['valor'];
}

if($_POST){
    $id=(isset($_POST['id'])) ? $_POST['id'] : "";
    $nameConfig=(isset($_POST['nameConfig'])) ? $_POST['nameConfig'] : "";
    $value=(isset($_POST['value'])) ? $_POST['value'] : "";

    $sql=$conexion->prepare("UPDATE tbl_configuraciones SET nombreConfiguracion=:nombreConfiguracion, valor=:valor WHERE id=:id");
    $sql->bindParam(":id",$id);
    $sql->bindParam(":nombreConfiguracion",$nameConfig);
    $sql->bindParam(":valor",$value);

    $sql->execute();

    $mensaje="Actualizado con éxito :)";
    header("location:index.php?mensaje=" . $mensaje);
}
?>

<?php include("../../templates/header.php")?>
<div class="card">
    <!-- Titulo de la card -->
    <div class="card-header">
        Editar Datos de la Configuración
    </div>
    <!-- Cuerpo de la card -->
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            Lorem ipsum dolor sit amet.
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="nameConfig" class="form-label">Nombre de la Configuración:</label>
                <input type="text" class="form-control" name="nameConfig" id="nameConfig" aria-describedby="helpId" value="<?php echo $nameConfig; ?>">
            </div>
            <div class="mb-3">
                <label for="value" class="form-label">Valor:</label>
                <input type="text" class="form-control" name="value" id="value" aria-describedby="helpId" value="<?php echo $value; ?>">
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="" id="" class="btn btn-outline-secondary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
</div>
<?php include("../../templates/footer.php")?>