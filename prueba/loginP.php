<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba</title>
    <link rel="stylesheet" href="../prueba/prueba.css">
</head>
<body>
    <div class="container-form">
        <form action="" method="post">
            <h2>Login</h2>
            <hr>
            <div class="grupo">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="grupo">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Iniciar sesión</button>
            <p>¿No tienes una cuenta? <a href="#">Regístrate aquí</a></p>
        </form>
    </div>
</body>
</html>