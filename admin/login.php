<!-- Inicio de sesion para el admin -->
<?php 

session_start();

if($_POST){
    include("./bd.php"); 
    $user=(isset($_POST['user'])) ? $_POST['user'] : "";
    $password=(isset($_POST['password'])) ? $_POST['password'] : "";

    $sql=$conexion->prepare("SELECT *, count(*) as n_usuario
        FROM tbl_usuarios
        WHERE usuario=:usuario
        AND password=:password;"
        );
    $sql->bindParam(":usuario",$user);
    $sql->bindParam(":password",$password);

    $sql->execute();

    $resultado_usuario=$sql->fetch(PDO::FETCH_LAZY);

    if($resultado_usuario['n_usuario']>0){
        print_r("El usuario y contraseña existen");
        $_SESSION['usuario']=$resultado_usuario['usuario'];
        $_SESSION['logueado']=true;
        header("location:index.php");
    }else{
        print_r("El usuario o la contraseña no existen");
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

</head>

<body>
    <form action="" method="post" class="form">
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

            <input type="submit" class="form-submit" value="Entrar">
        </div>
    </form>

</body>

</html>