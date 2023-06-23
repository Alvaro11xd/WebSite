<!-- Abrir conexion a BD -->
<?php 
$servidor="localhost";
$baseDatos="website";
$usuario="root";
$contrasenia="";

try {
    $conexion=new PDO("mysql:host=$servidor;dbname=$baseDatos",$usuario,$contrasenia);
    // echo "Conexion exitosa...";
} catch (Exception $error) {
    echo $error->getMessage();
}
?>