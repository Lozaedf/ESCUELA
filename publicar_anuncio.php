<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION["usuario_id"]) || $_SESSION["tipo"] != "profesor") {
    header("Location: login.php");
    exit;
}

$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];
    $id_profesor = $_SESSION["id_relacionado"];
    $fecha = date("Y-m-d");

    $stmt = $conn->prepare("INSERT INTO anuncios (titulo, contenido, fecha, id_profesor) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $titulo, $contenido, $fecha, $id_profesor);
    $stmt->execute();
    $stmt->close();

    $mensaje = "Anuncio publicado exitosamente.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Publicar Anuncio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h2>Publicar Anuncio</h2>
<p><?php echo $mensaje; ?></p>
<form method="post">
    <label>Título:</label><input type="text" name="titulo" required><br>
    <label>Contenido:</label><br>
    <textarea name="contenido" rows="5" cols="40" required></textarea><br>
    <input type="submit" value="Publicar">
</form>
</body>
</html>
