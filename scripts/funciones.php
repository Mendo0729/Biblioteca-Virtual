<?php
require_once 'data_base.php'; // Ajusta la ruta según la estructura de tu proyecto

/**
 * Obtiene el conteo de libros en la base de datos.
 *
 * @return int Número de libros
 */
function getTotalBooks() {
    global $pdo; // Asegúrate de que $pdo esté disponible aquí
    if ($pdo === null) {
        throw new Exception("La conexión a la base de datos no está disponible.");
    }
    $stmt = $pdo->query("SELECT COUNT(*) FROM libros"); // Asegúrate de que el nombre de la tabla sea correcto
    return $stmt->fetchColumn();
}

/**
 * Obtiene el conteo de usuarios en la base de datos.
 *
 * @return int Número de usuarios
 */
function getTotalUsers() {
    global $pdo; // Asegúrate de que $pdo esté disponible aquí
    if ($pdo === null) {
        throw new Exception("La conexión a la base de datos no está disponible.");
    }
    $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios"); // Asegúrate de que el nombre de la tabla sea correcto
    return $stmt->fetchColumn();
}

// Función para obtener la cantidad de libros alquilados
function getTotalBooksRented() {
    global $pdo;

    // Consulta SQL para contar el número de libros alquilados
    $sql = "SELECT COUNT(*) FROM reservas WHERE estado = 'alquilado'"; // Ajusta el campo y valor según tu tabla

    try {
        $stmt = $pdo->query($sql);
        $count = $stmt->fetchColumn();
        return $count;
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error al consultar la base de datos: " . $e->getMessage();
        return 0;
    }
}

// Función para obtener la cantidad de reservas pendientes
function getPendingReservations() {
    global $pdo;

    // Consulta SQL para contar el número de reservas pendientes
    $sql = "SELECT COUNT(*) FROM reservas WHERE estado = 'pendiente'"; // Ajusta el campo y valor según tu tabla

    try {
        $stmt = $pdo->query($sql);
        $count = $stmt->fetchColumn();
        return $count;
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error al consultar la base de datos: " . $e->getMessage();
        return 0;
    }
}

function buscarLibros($pdo, $busqueda = '', $genero = '', $ano = '') {
    try {
        // Consulta SQL que selecciona todos los campos necesarios
        $sql = "SELECT titulo, autor, genero, anio_publicacion, descripcion, imagen FROM libros WHERE 1=1";
        
        // Array para almacenar los parámetros
        $params = [];

        // Si se proporciona búsqueda (título o autor), añadirla a la consulta
        if (!empty($busqueda)) {
            $sql .= " AND (titulo LIKE :busqueda OR autor LIKE :busqueda)";
            $params[':busqueda'] = "%$busqueda%";
        }

        // Si se proporciona género, añadirlo a la consulta
        if (!empty($genero)) {
            $sql .= " AND genero = :genero";
            $params[':genero'] = $genero;
        }

        // Si se proporciona el año, añadirlo a la consulta
        if (!empty($ano)) {
            $sql .= " AND anio_publicacion = :ano";
            $params[':ano'] = $ano;
        }

        // Preparar la consulta
        $stmt = $pdo->prepare($sql);

        // Ejecutar la consulta con los parámetros
        $stmt->execute($params);

        // Obtener todos los resultados
        $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retornar los resultados
        return $libros;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}









?>
