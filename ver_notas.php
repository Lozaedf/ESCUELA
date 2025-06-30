<?php
session_start();
include 'conexion.php';

$notas = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_alumno = $_POST["id_alumno"];
    $query = "SELECT m.nombre AS materia, n.trimestre, n.nota
              FROM notas n
              JOIN materias m ON n.id_materia = m.id
              WHERE n.id_alumno = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_alumno);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($fila = $result->fetch_assoc()) {
        $notas[] = $fila;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ver Notas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h2>Buscar Notas de Alumno</h2>
<form method="post">
    <label>ID del Alumno:</label>
    <input type="number" name="id_alumno" required>
    <input type="submit" value="Buscar">
</form>

<?php if (!empty($notas)): ?>
    <h3>Notas:</h3>
    <table>
        <tr><th>Materia</th><th>Trimestre</th><th>Nota</th></tr>
        <?php foreach ($notas as $nota): ?>
            <tr>
                <td><?= $nota['materia'] ?></td>
                <td><?= $nota['trimestre'] ?></td>
                <td><?= $nota['nota'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
</body>
</html>