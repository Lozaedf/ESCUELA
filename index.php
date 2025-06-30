<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Escolar</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .contenedor {
            max-width: 500px;
            margin: 80px auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .contenedor h2 {
            margin-bottom: 20px;
        }

        .boton {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            margin: 10px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .boton:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h2>Bienvenido al Sistema Escolar</h2>
        <p>Elija una opción para comenzar:</p>
        <a href="login.php" class="boton">Iniciar Sesión</a>
        <a href="registro.php" class="boton">Registrarse</a>
    </div>
</body>
</html>
