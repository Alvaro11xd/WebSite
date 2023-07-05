<?php
include("../../bd.php");

// Eliminar entrada
if(isset($_GET['id'])){
    $id=(isset($_GET['id'])) ? $_GET['id'] : "";
    // Proceso para eliminar el registro y la imagen
    // Buscando imagen de la entrada
    $sentencia = $conexion->prepare("SELECT imagen FROM tbl_entradas WHERE id=:id;");
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
    $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);

    // Borrando la imagen del directorio | proyecto
    if(isset($registro_imagen['imagen'])){
        if(file_exists("../../../assets/img/about/" . $registro_imagen['imagen'])){
            // Borrar imagen
            unlink("../../../assets/img/about/" . $registro_imagen['imagen']);
        }
    }

    // Borrando registro de la BD
    $sentencia = $conexion->prepare("DELETE FROM tbl_entradas WHERE id=:id;");
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
}

// Recepcionando todos los datos de la BD
$sentencia=$conexion->prepare("SELECT * FROM tbl_entradas;");
$sentencia->execute();
$entradas=$sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include("../../templates/header.php") ?>

<div class="card">
    <!-- Header de la card -->
    <div class="card-header">
        <h2>Lista de Entradas de Blog</h2>
        <!-- Botón para agregar -->
        <a class="btn btn-primary" href="crear.php" role="button">Crear nueva entrada</a>
    </div>
    <!-- Cuerpo de la card -->
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Título</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entradas as $entrada) { ?>
                        <tr class="">
                            <td><?php echo $entrada['ID']; ?></td>
                            <td>
                                <strong><?php echo $entrada['fecha']; ?></strong>
                            </td>
                            <td><?php echo $entrada['titulo']?></td>
                            <td><?php echo $entrada['descripcion']; ?></td>
                            <td>
                            <img width="50" src="../../../assets/img/about/<?php echo $entrada['imagen']; ?>" alt="">
                            </td>
                            <td>
                                <a class="btn btn-warning" href="editar.php?id=<?php echo $entrada["ID"]; ?>" role="button">Editar</a>
                                |
                                <a class="btn btn-danger" href="index.php?id=<?php echo $entrada["ID"]; ?>" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../../templates/footer.php") ?>