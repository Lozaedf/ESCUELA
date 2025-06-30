<?php
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
<h2>Anuncios Escolares</h2>

<?php while ($fila = $resultado->fetch_assoc()): ?>
    <div class="anuncio">
        <h3><?= $fila['titulo'] ?> (<?= $fila['fecha'] ?>)</h3>
        <p><?= $fila['contenido'] ?></p>
        <p><em>Publicado por <?= $fila['nombre'] . ' ' . $fila['apellido'] ?></em></p>
    </div>
<?php endwhile; ?>
</body>
</html>