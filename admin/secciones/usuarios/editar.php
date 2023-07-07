<?php
include("../../bd.php");

// Proceso para actualizar un registro
// Validar que exista el id del usuario seleccionado
if (isset($_GET['id'])) {
    $id = (isset($_GET['id'])) ? $_GET['id'] : "";

    // Consultando la informacion del usuario en la BD
    $sql = $conexion->prepare("SELECT * FROM tbl_usuarios WHERE id=:id");
    $sql->bindParam(":id",$id);
    $sql->execute();
    $usuario=$sql->fetch(PDO::FETCH_LAZY);

    $nombreUsuario=$usuario['usuario'];
    $password=$usuario['password'];
    $correo=$usuario['correo'];
}

// Validar que los campos del formulario estén llenos
if($_POST){
    $id=(isset($_POST['id'])) ? $_POST['id'] : "";
    $nombreUsuario=(isset($_POST['user'])) ? $_POST['user'] : "";
    $password=(isset($_POST['password'])) ? $_POST['password'] : "";
    $correo=(isset($_POST['email'])) ? $_POST['email'] : "";

    // Encriptar la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Consulta para actualizar el registro
    $sql=$conexion->prepare("UPDATE tbl_usuarios SET usuario=:usuario,password=:password,correo=:correo WHERE id=:id;");
    
    // Comparando datos
    $sql->bindParam(":usuario",$nombreUsuario);
    $sql->bindParam(":password",$hashedPassword);
    $sql->bindParam(":correo",$correo);
    $sql->bindParam(":id",$id);

    // Ejecutando consulta
    $sql->execute();

    // Redirigiendo al usuario
    $mensaje = "Actualizado con éxito :)";
    header('location:index.php?mensaje=' . $mensaje);
}

?>

<?php include("../../templates/header.php") ?>
<div class="card">
    <!-- Titulo de la card -->
    <div class="card-header">
        Datos del Usuario
    </div>
    <!-- Cuerpo de la card -->
    <div class="card-body">
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="user" class="form-label">Usuario:</label>
                <input type="text" class="form-control" name="user" id="user" aria-describedby="helpId" value="<?php echo $nombreUsuario; ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico:</label>
                <input type="email" class="form-control" name="email" value="<?php echo $correo; ?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña:</label>
                <input type="password" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Ingresa tu nueva contraseña">
            </div>


            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="" id="" class="btn btn-outline-secondary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
    <div class="card-footer text-muted">

    </div>
</div>
<?php include("../../templates/footer.php") ?>