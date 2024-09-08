<?php
// Conexión a la base de datos
require_once '../scripts/data_base.php'; // Incluye tu archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordCon = $_POST['password-Con'];

    // Verificar si las contraseñas coinciden
    if ($password !== $passwordCon) {
        echo "Las contraseñas no coinciden.";
        exit(); // Detener el proceso de registro si no coinciden
    }

    // Encriptar contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT); 

    // Verificar si el usuario es un administrador
    session_start();
    $es_admin = isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador';

    // Si no es administrador, asignar el rol de usuario normal
    $rol = $es_admin && isset($_POST['rol']) && $_POST['rol'] === 'administrador' ? 'administrador' : 'usuario';

    // Llamada al procedimiento almacenado
    $query = "CALL RegistrarUsuario(:nombre, :email, :passwordHash, :rol, @return_code)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':passwordHash', $passwordHash);
    $stmt->bindParam(':rol', $rol);
    $stmt->execute();

    // Obtener el código de retorno
    $result = $pdo->query("SELECT @return_code AS return_code");
    $row = $result->fetch();
    $return_code = $row['return_code'];

    // Manejar el código de retorno
    if ($return_code == 1503) {
        // Registro exitoso, redirigir al usuario
        header("Location: ../public/index.php");
        exit();
    } elseif ($return_code == 1504) {
        echo "El correo electrónico ya está registrado.";
    } else {
        echo "Error al registrar el usuario.";
    }
}
?>
