<?php
include("../../bd.php");

if($_POST){
    $nameConfig=(isset($_POST['nameConfig'])) ? $_POST['nameConfig'] : "";
    $value=(isset($_POST['value'])) ? $_POST['value'] : "";

    $sql=$conexion->prepare("INSERT INTO tbl_configuraciones(nombreConfiguracion,valor) VALUES (:nombreConfiguracion,:valor);");
    $sql->bindParam(":nombreConfiguracion",$nameConfig);
    $sql->bindParam(":valor",$value);
    $sql->execute();
    header("location:index.php");
}
?>

<?php include("../../templates/header.php")?>
<div class="card">
    <!-- Titulo de la card -->
    <div class="card-header">
        Datos de la Configuración
    </div>
    <!-- Cuerpo de la card -->
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="nameConfig" class="form-label">Nombre de la Configuración:</label>
                <input type="text" class="form-control" name="nameConfig" id="nameConfig" aria-describedby="helpId" placeholder="Ingrese el nombre de la configuración">
            </div>
            <div class="mb-3">
                <label for="value" class="form-label">Valor:</label>
                <input type="text" class="form-control" name="value" id="value" aria-describedby="helpId" placeholder="Ingrese el valor">
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-outline-secondary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
</div>
<?php include("../../templates/footer.php")?>