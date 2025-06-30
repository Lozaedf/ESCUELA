<?php
session_start();
include 'conexion.php';

// Redirigir si no es un profesor
if (!isset($_SESSION["usuario_id"]) || $_SESSION["tipo"] != "profesor") {
    header("Location: dashboard.php");
    exit;
}

$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];
    $id_profesor = $_SESSION["id_relacionado"]; // ID del profesor logueado
    $fecha = date("Y-m-d");

    $stmt = $conn->prepare("INSERT INTO anuncios (titulo, contenido, fecha, id_profesor) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $titulo, $contenido, $fecha, $id_profesor);
    
    if ($stmt->execute()) {
        $mensaje = "Anuncio publicado exitosamente.";
    } else {
        $mensaje = "Hubo un error al publicar el anuncio.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Publicar Anuncio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'dashboard.php'; // Incluye la barra de navegación ?>

<div class="container">
    <h2>Publicar un Nuevo Anuncio</h2>

    <?php if (!empty($mensaje)): ?>
        <div class="mensaje exito"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>
        
        <label for="contenido">Contenido:</label>
        <textarea id="contenido" name="contenido" rows="8" required></textarea>
        
        <input type="submit" value="Publicar Anuncio">
    </form>
</div>
</body>
</html>