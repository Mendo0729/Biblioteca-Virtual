<?php
// Configuración de la base de datos
require_once '../scripts/data_base.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Verificar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        echo "Por favor, ingrese el correo electrónico y la contraseña.";
        exit();
    }

    // Llamada al procedimiento almacenado para obtener el hash de la contraseña y el rol
    $query = "CALL LoguearUsuario(:email, @user_id, @password_hash, @role_id, @return_code)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Obtener los valores de salida
    $result = $pdo->query("SELECT @user_id AS user_id, @password_hash AS password_hash, @role_id AS role_id, @return_code AS return_code");
    $row = $result->fetch();

    $user_id = $row['user_id'];
    $password_hash = $row['password_hash'];
    $role_id = $row['role_id'];
    $return_code = $row['return_code'];

    // Depuración (mantén esto mientras pruebas, pero elimina antes de producción)
    // echo "Role ID: " . htmlspecialchars($role_id) . "<br>";
    // echo "Return Code: " . htmlspecialchars($return_code) . "<br>";

    // Verificar el código de retorno y si el usuario fue encontrado
    if ($return_code == 1503 && password_verify($password, $password_hash)) {
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['rol'] = $role_id;
        
        // Redirigir según el rol
        if ($role_id === 2) { // Administrador
            header("Location: ../../public/admin/admin_dashboard.php");
            exit();
        } else { // Usuario
            header("Location: ../public/pagina_inicio.php");
            exit();
        }
    } elseif ($return_code == 1504) {
        echo "Contraseña incorrecta.";
    } elseif ($return_code == 1505) {
        echo "Correo electrónico no registrado.";
    }
}
?>
