<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}
include 'conexion.php';

$horarios = [];
$curso_buscado = '';
$division_buscada = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $curso = $_POST["curso"];
    $division = $_POST["division"];
    $curso_buscado = $curso;
    $division_buscada = $division;

    $query = "SELECT h.dia_semana, h.hora_inicio, h.hora_fin, m.nombre AS materia, p.nombre AS profe_nombre, p.apellido AS profe_apellido
              FROM horarios h
              JOIN materias m ON h.id_materia = m.id
              JOIN profesores p ON h.id_profesor = p.id
              WHERE h.curso = ? AND h.division = ?
              ORDER BY FIELD(h.dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'), h.hora_inicio";
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
<?php include 'dashboard.php'; // Incluye la barra de navegación ?>

<div class="container">
    <h2>Buscar Horario por Curso y División</h2>
    <form method="post">
        <label for="curso">Curso:</label>
        <input type="text" id="curso" name="curso" required>
        <label for="division">División:</label>
        <input type="text" id="division" name="division" required>
        <input type="submit" value="Ver Horario">
    </form>

    <?php if (!empty($horarios)): ?>
        <h3>Horario para <?php echo htmlspecialchars($curso_buscado) . ' ' . htmlspecialchars($division_buscada); ?></h3>
        <table>
            <thead>
                <tr>
                    <th>Día</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Materia</th>
                    <th>Profesor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horarios as $h): ?>
                    <tr>
                        <td><?= htmlspecialchars($h['dia_semana']) ?></td>
                        <td><?= htmlspecialchars($h['hora_inicio']) ?></td>
                        <td><?= htmlspecialchars($h['hora_fin']) ?></td>
                        <td><?= htmlspecialchars($h['materia']) ?></td>
                        <td><?= htmlspecialchars($h['profe_nombre'] . ' ' . $h['profe_apellido']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p style="text-align: center; margin-top: 20px;">No se encontraron horarios para la selección realizada.</p>
    <?php endif; ?>
</div>
</body>
</html>