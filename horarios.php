<?php
include 'conexion.php';

$horarios = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $curso = $_POST["curso"];
    $division = $_POST["division"];

    $query = "SELECT h.dia_semana, h.hora_inicio, h.hora_fin, m.nombre AS materia, p.nombre AS profe_nombre, p.apellido AS profe_apellido
              FROM horarios h
              JOIN materias m ON h.id_materia = m.id
              JOIN profesores p ON h.id_profesor = p.id
              WHERE h.curso = ? AND h.division = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $curso, $division);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($fila = $result->fetch_assoc()) {
        $horarios[] = $fila;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ver Horarios</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h2>Buscar Horario por Curso y División</h2>
<form method="post">
    <label>Curso:</label><input type="text" name="curso" required>
    <label>División:</label><input type="text" name="division" required>
    <input type="submit" value="Ver Horario">
</form>

<?php if (!empty($horarios)): ?>
    <h3>Horario:</h3>
    <table>
        <tr><th>Día</th><th>Hora Inicio</th><th>Hora Fin</th><th>Materia</th><th>Profesor</th></tr>
        <?php foreach ($horarios as $h): ?>
            <tr>
                <td><?= $h['dia_semana'] ?></td>
                <td><?= $h['hora_inicio'] ?></td>
                <td><?= $h['hora_fin'] ?></td>
                <td><?= $h['materia'] ?></td>
                <td><?= $h['profe_nombre'] . ' ' . $h['profe_apellido'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
</body>
</html>