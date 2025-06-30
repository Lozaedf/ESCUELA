<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

<nav class="navbar">
    <ul>
        <li><a href="dashboard.php">Inicio</a></li>
        <li><a href="ver_notas.php">Ver Notas</a></li>
        <li><a href="horarios.php">Ver Horarios</a></li>
        <li><a href="anuncios.php">Ver Anuncios</a></li>
        <?php if ($tipo == 'profesor'): ?>
            <li><a href="publicar_anuncio.php">Publicar Anuncio</a></li>
        <?php endif; ?>
        <li><a href="logout.php">Cerrar Sesión</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Bienvenido al Sistema Escolar</h2>
    <p>Utilice la barra de navegación de arriba para moverse por las distintas secciones del sistema.</p>
    <p>Esta es su página principal. Desde aquí puede acceder a todas las funcionalidades disponibles para su tipo de usuario.</p>
</div>

</body>
</html>