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
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h2>Iniciar Sesión</h2>
<p><?php echo $mensaje; ?></p>
<form method="post">
    <label>Email:</label><input type="email" name="email" required><br>
    <label>Contraseña:</label><input type="password" name="password" required><br>
    <input type="submit" value="Ingresar">
</form>
</body>
</html>