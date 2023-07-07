<?php
include("../../bd.php");

// Eliminar registro
if (isset($_GET['id'])) {
    $id = (isset($_GET['id'])) ? $_GET['id'] : "";

    // Buscando imagen del registro
    $sentencia = $conexion->prepare("SELECT imagen FROM tbl_equipo WHERE id=:id;");
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
    $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);

    // Borrando imagen de la BD
    if (isset($registro_imagen['imagen'])) {
        if (file_exists("../../../assets/img/team/" . $registro_imagen['imagen'])) {
            // Borrar imagen
            unlink("../../../assets/img/team/" . $registro_imagen['imagen']);
        }
    }

    // Borrando registro de la BD
    $sentencia = $conexion->prepare("DELETE FROM tbl_equipo WHERE id=:id;");
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
}

// Recepcionando todos los datos de la BD
$sentencia = $conexion->prepare("SELECT * FROM tbl_equipo;");
$sentencia->execute();
$profesionales = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include("../../templates/header.php") ?>
<div class="card">
    <!-- Header de la card -->
    <div class="card-header">
        <h2>Lista de Profesionales</h2>
        <!-- Botón para agregar -->
        <a class="btn btn-primary" href="crear.php" role="button">Crear nuevo registro</a>
    </div>
    <!-- Cuerpo de la card -->
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Twitter</th>
                        <th scope="col">Facebook</th>
                        <th scope="col">Linkedin</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador = 1;
                    foreach ($profesionales as $profesional) { ?>
                        <tr class="">
                            <td><?php echo $contador; ?></td>
                            <td>
                                <img width="50" src="../../../assets/img/team/<?php echo $profesional['imagen']; ?>" alt="">
                            </td>
                            <td>
                                <strong><?php echo $profesional['nombreCompleto']; ?></strong><br>
                                <?php echo $profesional['puesto']; ?>
                            </td>
                            <td><?php echo $profesional['twitter']; ?></td>
                            <td><?php echo $profesional['facebook']; ?></td>
                            <td><?php echo $profesional['linkedin']; ?></td>
                            <td>
                                <a class="btn btn-warning" href="editar.php?id=<?php echo $profesional["ID"]; ?>" role="button">Editar</a>
                                |
                                <a class="btn btn-danger" href="index.php?id=<?php echo $profesional["ID"]; ?>" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php
                        $contador++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include("../../templates/footer.php") ?>