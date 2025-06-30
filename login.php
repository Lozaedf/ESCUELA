<?php
session_start();
include_once 'config/database.php';
include_once 'models/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    if ($user->login()) {
        $_SESSION["usuario_id"] = $user->id;
        $_SESSION["tipo"] = $user->type;
        $_SESSION["id_relacionado"] = $user->related_id;
        header("Location: dashboard.php");
        exit;
    } else {
        $mensaje = "Email o contraseña incorrectos.";
    }
}
// The rest of your HTML remains the same
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