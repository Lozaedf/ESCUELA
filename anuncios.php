<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}
include 'conexion.php';

$resultado = $conn->query("SELECT a.titulo, a.contenido, a.fecha, p.nombre, p.apellido
                           FROM anuncios a
                           JOIN profesores p ON a.id_profesor = p.id
                           ORDER BY a.fecha DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Anuncios Escolares</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'dashboard.php'; // Incluye la barra de navegación ?>

<div class="container">
    <h2>Anuncios Escolares</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <div class="anuncio">
                <h3><?= htmlspecialchars($fila['titulo']) ?></h3>
                <p><?= nl2br(htmlspecialchars($fila['contenido'])) ?></p>
                <p><em>Publicado por <?= htmlspecialchars($fila['nombre'] . ' ' . $fila['apellido']) ?> el <?= date("d/m/Y", strtotime($fila['fecha'])) ?></em></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="mensaje" style="background-color: #e9ecef; text-align: center;">No hay anuncios para mostrar en este momento.</div>
    <?php endif; ?>
</div>
</body>
</html>