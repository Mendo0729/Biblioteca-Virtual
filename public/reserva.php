<?php
session_start();
include '../scripts/data_base.php'; // Archivo de conexión a la base de datos

// Verificación del ID de usuario
if (empty($_SESSION['usuario_id']) || !is_numeric($_SESSION['usuario_id'])) {
    die('Error: ID de usuario no válido.');
}

// Verifica si se han recibido los datos necesarios
if (isset($_POST['libro_id']) && isset($_POST['usuario_id'])) {
    $libro_id = $_POST['libro_id'];
    $usuario_id = $_POST['usuario_id'];

    // Fechas de reserva
    $fecha_reserva = date('Y-m-d');
    $fecha_alquiler = date('Y-m-d'); // Para alquiler
    $fecha_devolucion = date('Y-m-d', strtotime('+7 days')); // Fecha de devolución

    // Iniciar transacción para asegurarnos de que ambas inserciones se completen correctamente
    try {
        $pdo->beginTransaction();

        // Inserta la reserva en la tabla RESERVAS
        $sqlReserva = "INSERT INTO RESERVAS (usuario_id, libro_id, fecha_reserva, estado)
                       VALUES (:usuario_id, :libro_id, :fecha_reserva, 'pendiente')";
        $stmtReserva = $pdo->prepare($sqlReserva);
        $stmtReserva->execute([
            ':usuario_id' => $usuario_id,
            ':libro_id' => $libro_id,
            ':fecha_reserva' => $fecha_reserva
        ]);

        // Inserta el alquiler en la tabla ALQUILERES
        $sqlAlquiler = "INSERT INTO ALQUILERES (usuario_id, libro_id, fecha_alquiler, fecha_devolucion, estado)
                        VALUES (:usuario_id, :libro_id, :fecha_alquiler, :fecha_devolucion, 'activo')";
        $stmtAlquiler = $pdo->prepare($sqlAlquiler);
        $stmtAlquiler->execute([
            ':usuario_id' => $usuario_id,
            ':libro_id' => $libro_id,
            ':fecha_alquiler' => $fecha_alquiler,
            ':fecha_devolucion' => $fecha_devolucion
        ]);

        // Confirma la transacción si ambos inserts fueron exitosos
        $pdo->commit();

        // Mensaje de confirmación
        $_SESSION['mensaje_reserva'] = "Reserva exitosa. Tienes 7 días para devolver el libro.";
        header('Location: libros.php');
        exit();
    } catch (PDOException $e) {
        // Si ocurre algún error, deshacer la transacción
        $pdo->rollBack();
        echo "Error al realizar la reserva: " . $e->getMessage();
    }
} else {
    echo "Faltan datos para realizar la reserva.";
}
?>
