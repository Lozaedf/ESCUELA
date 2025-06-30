<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

include_once 'config/database.php';
include_once 'models/Student.php';
include_once 'models/Teacher.php';

$database = new Database();
$db = $database->getConnection();

$notas = [];
$alumno_buscado = false;
$tipo_usuario = $_SESSION["tipo"];

if ($tipo_usuario == 'alumno') {
    $student = new Student($db);
    $student->related_id = $_SESSION['id_relacionado'];
    $result = $student->getGrades();
    while ($fila = $result->fetch_assoc()) {
        $notas[] = $fila;
    }
    $alumno_buscado = true;
} elseif ($tipo_usuario == 'profesor' && $_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher = new Teacher($db);
    $id_alumno = $_POST["id_alumno"];
    $result = $teacher->getGradesForStudent($id_alumno);
    while ($fila = $result->fetch_assoc()) {
        $notas[] = $fila;
    }
    $alumno_buscado = true;
}

// Your HTML part remains the same
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