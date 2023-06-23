<!-- Inicio de sesion para el admin -->
<?php include("./bd.php"); ?>
<!doctype html>
<html lang="es">

<head>
    <title>Iniciar sesión</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="./css/estilos.css">

</head>

<body>
    <form action="" class="form">
        <h2 class="form-title">Inicia Sesión</h2>
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

            <!-- <input type="submit" class="form-submit" value="Entrar"> -->
            <a href="index.php" class="form-submit">Entrar</a>
        </div>
    </form>

</body>

</html>