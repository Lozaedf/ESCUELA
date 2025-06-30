<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}
$tipo = $_SESSION["tipo"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel Principal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h2>Bienvenido al Sistema Escolar</h2>
<ul>
    <li><a href="ver_notas.php">Ver Notas</a></li>
    <li><a href="horarios.php">Ver Horarios</a></li>
    <li><a href="anuncios.php">Ver Anuncios</a></li>
    <?php if ($tipo == 'profesor') echo '<li><a href="publicar_anuncio.php">Publicar Anuncio</a></li>'; ?>
    <li><a href="logout.php">Cerrar Sesión</a></li>
</ul>
</body>
</html>