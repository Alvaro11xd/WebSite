<?php
include("../../bd.php");

// Eliminar proyecto
if (isset($_GET['id'])) {
    $id = ($_GET['id']) ? $_GET['id'] : "";
    $sentencia = $conexion->prepare("DELETE FROM tbl_portafolio WHERE id=:id;");
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
}


$sentencia = $conexion->prepare("SELECT * FROM tbl_portafolio;");
$sentencia->execute();
$proyectos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include("../../templates/header.php") ?>


<div class="card">
    <div class="card-header">
        <h2>Lista de Proyectos</h2>
        <a class="btn btn-primary" href="crear.php" role="button">Crear nuevo proyecto</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Título</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">CategorÍa</th>
                        <th scope="col">URL</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proyectos as $proyecto) { ?>
                        <tr class="">
                            <td><?php echo $proyecto['ID']; ?></td>
                            <td>
                                <?php echo $proyecto['titulo']; ?><br>
                                <?php echo $proyecto['subtitulo']; ?>
                            </td>
                            <td><?php echo $proyecto['imagen']; ?></td>
                            <td><?php echo $proyecto['descripcion']; ?></td>
                            <td><?php echo $proyecto['cliente']; ?></td>
                            <td><?php echo $proyecto['categoria']; ?></td>
                            <td><?php echo $proyecto['url']; ?></td>
                            <td>
                                <a class="btn btn-warning" href="editar.php?id=<?php echo $proyecto["ID"]; ?>" role="button">Editar</a>
                                |
                                <a class="btn btn-danger" href="index.php?id=<?php echo $proyecto["ID"]; ?>" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<?php include("../../templates/footer.php") ?>