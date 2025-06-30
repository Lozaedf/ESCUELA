<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}
include 'conexion.php';

$notas = [];
$alumno_buscado = false;
$tipo_usuario = $_SESSION["tipo"];
$id_relacionado = $_SESSION["id_relacionado"];

// Si el usuario es un alumno, busca sus propias notas automáticamente.
if ($tipo_usuario == 'alumno') {
    $id_alumno = $id_relacionado;
    $alumno_buscado = true;
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Si es profesor, busca por el ID que ponga en el formulario.
    $id_alumno = $_POST["id_alumno"];
    $alumno_buscado = true;
}

if ($alumno_buscado) {
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
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ver Notas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'dashboard.php'; // Incluye la barra de navegación ?>

<div class="container">
    <h2>Mis Notas</h2>

    <?php if ($tipo_usuario == 'profesor'): ?>
    <h3>Buscar Notas de Alumno</h3>
    <form method="post">
        <label for="id_alumno">ID del Alumno:</label>
        <input type="number" id="id_alumno" name="id_alumno" required>
        <input type="submit" value="Buscar Notas">
    </form>
    <?php endif; ?>

    <?php if ($alumno_buscado): ?>
        <?php if (!empty($notas)): ?>
            <h3>Mostrando Notas:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Trimestre</th>
                        <th>Nota</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notas as $nota): ?>
                        <tr>
                            <td><?= htmlspecialchars($nota['materia']) ?></td>
                            <td><?= htmlspecialchars($nota['trimestre']) ?></td>
                            <td><?= htmlspecialchars($nota['nota']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="mensaje" style="background-color: #e9ecef; text-align: center;">No se encontraron notas para mostrar.</div>
        <?php endif; ?>
    <?php elseif ($tipo_usuario == 'alumno'): ?>
        <div class="mensaje" style="background-color: #e9ecef; text-align: center;">Aún no tienes notas cargadas.</div>
    <?php endif; ?>
</div>
</body>
</html>