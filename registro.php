<?php
include 'conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST["tipo"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    if ($tipo == "alumno") {
        $dni = $_POST["dni"];
        $curso = $_POST["curso"];
        $division = $_POST["division"];

        $stmt = $conn->prepare("INSERT INTO alumnos (nombre, apellido, dni, curso, division) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombre, $apellido, $dni, $curso, $division);
        $stmt->execute();
        $id_relacionado = $stmt->insert_id;
        $stmt->close();
    } else {
        $stmt = $conn->prepare("INSERT INTO profesores (nombre, apellido, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $apellido, $email);
        $stmt->execute();
        $id_relacionado = $stmt->insert_id;
        $stmt->close();
    }

    $stmt = $conn->prepare("INSERT INTO usuarios (email, password, tipo, id_relacionado) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $email, $password, $tipo, $id_relacionado);
    $stmt->execute();
    $stmt->close();

    $mensaje = "Registro exitoso. Ahora puedes iniciar sesión.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h2>Registro de Usuario</h2>
<p><?php echo $mensaje; ?></p>
<form method="post">
    <label>Tipo:</label>
    <select name="tipo" required onchange="mostrarCampos(this.value)">
        <option value="">Seleccionar</option>
        <option value="alumno">Alumno</option>
        <option value="profesor">Profesor</option>
    </select><br><br>

    <label>Nombre:</label><input type="text" name="nombre" required><br>
    <label>Apellido:</label><input type="text" name="apellido" required><br>
    <label>Email:</label><input type="email" name="email" required><br>
    <label>Contraseña:</label><input type="password" name="password" required><br>

    <div id="campos_alumno" style="display:none;">
        <label>DNI:</label><input type="text" name="dni"><br>
        <label>Curso:</label><input type="text" name="curso"><br>
        <label>División:</label><input type="text" name="division"><br>
    </div>

    <input type="submit" value="Registrarse">
</form>

<script>
function mostrarCampos(tipo) {
    document.getElementById("campos_alumno").style.display = (tipo === "alumno") ? "block" : "none";
}
</script>
</body>
</html>