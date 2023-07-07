<?php
include("../../bd.php");

// Recepcionar datos del formulario
if ($_POST) {
    $usuario = (isset($_POST['user'])) ? $_POST['user'] : "";
    $correo = (isset($_POST['email'])) ? $_POST['email'] : "";
    $password = (isset($_POST['password'])) ? $_POST['password'] : "";

    // Encriptar la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Realizar consulta para agregar un nuevo registro
    $sql = $conexion->prepare("INSERT INTO tbl_usuarios(usuario,password,correo) VALUES (:usuario,:password,:correo);");
    
    $sql->bindParam(":usuario", $usuario);
    $sql->bindParam(":password", $hashedPassword);
    $sql->bindParam(":correo", $correo);
    
    // Ejecutar consulta
    $sql->execute();
    header('location:index.php');
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

            <div class="mb-3">
                <label for="user" class="form-label">Usuario:</label>
                <input type="text" class="form-control" name="user" id="user" aria-describedby="helpId" placeholder="usuario123">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico:</label>
                <input type="email" class="form-control" name="email" placeholder="ejemplo@gmail.com">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="*********">
            </div>


            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-outline-secondary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
    <div class="card-footer text-muted">

    </div>
</div>
<?php include("../../templates/footer.php") ?>