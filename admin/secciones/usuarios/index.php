<?php
include("../../bd.php");

// Proceso para eliminar un registro
// Validar que exista el id del usuario seleccionado
if(isset($_GET['id'])){
    $id=(isset($_GET['id'])) ? $_GET['id'] : "";

    // Eliminar el registro del usuario
    $sql=$conexion->prepare("DELETE FROM tbl_usuarios WHERE id=:id;");
    $sql->bindParam(":id",$id);
    $sql->execute();
}


// Recepcionando todos los datos de la BD
$sql = $conexion->prepare("SELECT * FROM tbl_usuarios");
$sql->execute();
$usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../templates/header.php") ?>
<div class="card">
    <!-- Header de la card -->
    <div class="card-header">
        <h2>Lista de Usuarios</h2>
        <!-- Botón para agregar -->
        <a class="btn btn-primary" href="crear.php" role="button">Crear nuevo usuario</a>
    </div>
    <!-- Cuerpo de la card -->
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador = 1;
                    foreach ($usuarios as $usuario) { ?>
                        <tr class="">
                            <td><?php echo $contador; ?></td>
                            <td>
                                <strong><?php echo $usuario['usuario']; ?></strong><br>
                                <?php echo $usuario['correo']; ?>
                            </td>
                            <td>
                                <a class="btn btn-warning" href="editar.php?id=<?php echo $usuario["ID"]; ?>" role="button">Editar</a>
                                |
                                <a class="btn btn-danger" href="index.php?id=<?php echo $usuario["ID"]; ?>" role="button">Eliminar</a>
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