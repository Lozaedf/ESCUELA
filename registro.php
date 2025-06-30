<?php
include 'conexion.php';
$mensaje = "";
$mensaje_tipo = ""; // 'exito' o 'error'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (previous code is fine)
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
    } else { // 'profesor'
        $stmt = $conn->prepare("INSERT INTO profesores (nombre, apellido, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $apellido, $email);
        $stmt->execute();
        $id_relacionado = $stmt->insert_id;
        $stmt->close();
    }

    // The error is here
    $stmt = $conn->prepare("INSERT INTO usuarios (email, password, tipo, id_relacionado) VALUES (?, ?, ?, ?)");
    
    // ▼▼▼ THIS IS THE FIX ▼▼▼
    // You must bind the parameters before executing
    $stmt->bind_param("sssi", $email, $password, $tipo, $id_relacionado);

    if ($stmt->execute()) {
        $mensaje = "Registro exitoso. Ahora puedes <a href='login.php'>iniciar sesión</a>.";
        $mensaje_tipo = "exito";
    } else {
        $mensaje = "Error en el registro. Es posible que el email ya esté en uso.";
        $mensaje_tipo = "error";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Registro de Usuario</h2>
    <?php if (!empty($mensaje)): ?>
        <div class="mensaje <?php echo $mensaje_tipo; ?>"><?php echo $mensaje; ?></div>
    <?php endif; ?>
    <form method="post">
        <label for="tipo">Tipo de Usuario:</label>
        <select id="tipo" name="tipo" required onchange="mostrarCampos(this.value)">
            <option value="">Seleccionar...</option>
            <option value="alumno">Alumno</option>
            <option value="profesor">Profesor</option>
        </select>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <div id="campos_alumno" style="display:none; flex-direction: column; gap: 15px;">
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni">
            
            <label for="curso">Curso:</label>
            <input type="text" id="curso" name="curso">
            
            <label for="division">División:</label>
            <input type="text" id="division" name="division">
        </div>

        <input type="submit" value="Registrarse">
    </form>
    <p style="text-align: center; margin-top: 20px;">
        ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a>
    </p>
</div>

<script>
function mostrarCampos(tipo) {
    var camposAlumno = document.getElementById("campos_alumno");
    if (tipo === "alumno") {
        camposAlumno.style.display = 'flex';
        camposAlumno.querySelectorAll('input').forEach(input => input.required = true);
    } else {
        camposAlumno.style.display = 'none';
        camposAlumno.querySelectorAll('input').forEach(input => input.required = false);
    }
}
</script>
</body>
</html>