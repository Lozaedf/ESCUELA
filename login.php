<?php
session_start();
include 'conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($password, $usuario["password"])) {
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["tipo"] = $usuario["tipo"];
            $_SESSION["id_relacionado"] = $usuario["id_relacionado"];
            header("Location: dashboard.php");
            exit;
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "Usuario no encontrado.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Iniciar Sesión</h2>
    <?php if (!empty($mensaje)): ?>
        <div class="mensaje error"><?php echo $mensaje; ?></div>
    <?php endif; ?>
    <form method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <input type="submit" value="Ingresar">
    </form>
    <p style="text-align: center; margin-top: 20px;">
        ¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>
    </p>
</div>
</body>
</html>