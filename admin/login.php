<!-- Inicio de sesion para el admin -->
<?php

session_start();

if ($_POST) {
    include("./bd.php");
    $user = (isset($_POST['user'])) ? $_POST['user'] : "";
    $password = (isset($_POST['password'])) ? $_POST['password'] : "";

    $sql = $conexion->prepare(
        "SELECT *, count(*) as n_usuario
        FROM tbl_usuarios
        WHERE usuario=:usuario
        AND password=:password;"
    );
    $sql->bindParam(":usuario", $user);
    $sql->bindParam(":password", $password);

    $sql->execute();

    $resultado_usuario = $sql->fetch(PDO::FETCH_LAZY);

    if ($resultado_usuario['n_usuario'] > 0) {
        $_SESSION['usuario'] = $resultado_usuario['usuario'];
        $_SESSION['logueado'] = true;
        header("location:index.php");
    } else {
        $mensaje = "El usuario o contraseña son incorrectos";
    }
}

?>
<!doctype html>
<html lang="es">

<head>
    <title>Iniciar sesión</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="./css/estilos.css">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <form action="" method="post" class="form">
        <h2 class="form-title">Inicia Sesión</h2>
        <?php if(isset($mensaje)) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Error:</strong> <?php echo $mensaje; ?>
        </div>
        <?php } ?>

        <script>
            var alertList = document.querySelectorAll('.alert');
            alertList.forEach(function(alert) {
                new bootstrap.Alert(alert)
            })
        </script>


        <p class="form-paragraph">¿Aún no tienes una cuenta? <a href="#" class="form-link">Entra aquí</a></p>

        <div class="form-container">
            <div class="form-group">
                <input type="text" id="user" name="user" class="form-input" placeholder=" ">
                <label for="user" class="form-label">Usuario:</label>
                <span class="form-line"></span>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" class="form-input" placeholder=" ">
                <label for="password" class="form-label">Contraseña:</label>
                <span class="form-line"></span>
            </div>

            <input type="submit" class="form-submit" value="Entrar">
        </div>
    </form>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>