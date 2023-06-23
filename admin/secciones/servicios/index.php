<?php
include("../../bd.php");
$sentencia = $conexion->prepare("SELECT * FROM tbl_servicios;");
$sentencia->execute();
$servicios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include("../../templates/header.php") ?>
Listar servicios

<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="crear.php" role="button">Crear nuevo servicio</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Icono</th>
                        <th scope="col">Título</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($servicios as $servicio) { ?>
                        <tr class="">
                            <td><?php echo $servicio['ID']; ?></td>
                            <td><?php echo $servicio['icono']; ?></td>
                            <td><?php echo $servicio['titulo']; ?></td>
                            <td><?php echo $servicio['descripcion']; ?></td>
                            <td>
                                <a class="btn btn-warning" href="#" role="button">Editar</a>
                                |
                                <a class="btn btn-danger" href="#" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<?php include("../../templates/footer.php") ?>