<?php
include("../../bd.php");

// Recepcionando todos los datos de la BD
$sentencia = $conexion->prepare("SELECT * FROM tbl_configuraciones;");
$sentencia->execute();
$configuraciones = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../templates/header.php")?>
<div class="card">
    <!-- Header de la card -->
    <div class="card-header">
        <h2>Lista de Configuraciones</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre de la Configuración</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($configuraciones as $configuracion) { ?>
                        <tr class="">
                            <td><?php echo $configuracion['ID']; ?></td>
                            <td><?php echo $configuracion['nombreConfiguracion']; ?></td>
                            <td><?php echo $configuracion['valor']; ?></td>
                            <td>
                                <a class="btn btn-warning" href="editar.php?id=<?php echo $configuracion["ID"]; ?>" role="button">Editar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include("../../templates/footer.php")?>