<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <link rel="stylesheet" href="../public/css/style-Form.css">
    <script>
        function validarContrasenas() {
            var password = document.getElementById("password").value;
            var passwordCon = document.getElementById("password-Con").value;
            
            if (password !== passwordCon) {
                alert("Las contraseñas no coinciden.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container-form">
        <form action="../includes/registrar_usuario.php" method="post" onsubmit="return validarContrasenas()">
            <h2>Sign up</h2>
            <hr>
            <div class="grupo">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="grupo">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="grupo">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="grupo">
                <label for="password-Con">Confirmación contraseña:</label>
                <input type="password" id="password-Con" name="password-Con" required>
            </div>
            
            <button type="submit">Registrar</button>
            <p>Vuelve al <a href="index.php"> inicio de sesion</a></p>
        </form>
    </div>
</body>
</html>
