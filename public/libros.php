<?php
include '../includes/header.php'; 
include '../scripts/funciones.php'; // Asegúrate de tener la función buscarLibros definida

session_start();
include '../scripts/data_base.php'; // Archivo de conexión a la base de datos

// Mostrar mensaje de confirmación si existe
if (isset($_SESSION['mensaje_reserva'])) {
    echo '<p>' . htmlspecialchars($_SESSION['mensaje_reserva'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>';
    unset($_SESSION['mensaje_reserva']);
}
?>

<main class="container-principal-libros">
    <div class="title-container">
        <h1>Catálogo de Libros</h1>
    </div>

    <!-- Formulario de búsqueda -->
    <form action="" method="GET">
        <div class="search-form">
            <input type="text" name="busqueda" placeholder="Buscar por título o autor" value="<?= htmlspecialchars($_GET['busqueda'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            <select name="genero">
                <option value="">Todos los géneros</option>
                <option value="Ficción" <?= (isset($_GET['genero']) && $_GET['genero'] === 'Ficción') ? 'selected' : '' ?>>Ficción</option>
                <option value="No ficción" <?= (isset($_GET['genero']) && $_GET['genero'] === 'No ficción') ? 'selected' : '' ?>>No ficción</option>
                <option value="Ciencia" <?= (isset($_GET['genero']) && $_GET['genero'] === 'Ciencia') ? 'selected' : '' ?>>Ciencia</option>
                <option value="Historia" <?= (isset($_GET['genero']) && $_GET['genero'] === 'Historia') ? 'selected' : '' ?>>Historia</option>
                <option value="Biografia" <?= (isset($_GET['genero']) && $_GET['genero'] === 'Biografia') ? 'selected' : '' ?>>Biografia</option>
                <option value="Fantasia" <?= (isset($_GET['genero']) && $_GET['genero'] === 'Fantasia') ? 'selected' : '' ?>>Fantasia</option>
                <option value="Romance" <?= (isset($_GET['genero']) && $_GET['genero'] === 'Romance') ? 'selected' : '' ?>>Romance</option>
                <!-- Agrega más géneros si es necesario -->
            </select>
            <input type="number" name="anio" placeholder="Año de publicación" value="<?= htmlspecialchars($_GET['anio'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            <button type="submit">Buscar</button>
        </div>
    </form>

    <!-- Resultados de búsqueda -->
    <div class="container-libros">
        <?php
        // Variables para la búsqueda
        $busqueda = $_GET['busqueda'] ?? '';
        $genero = $_GET['genero'] ?? '';
        $anio = $_GET['anio'] ?? '';

        // Obtener los libros de la base de datos
        $libros = buscarLibros($pdo, $busqueda, $genero, $anio);

        // Mostrar los libros
        if ($libros) {
            foreach ($libros as $libro) {
                ?>
                <div class="libros">
                    <img src="img/libros/<?= htmlspecialchars($libro['imagen'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($libro['titulo'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="descp-libros">
                    <h2 class="book-title"><?= htmlspecialchars($libro['titulo'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p class="book-author"><?= htmlspecialchars($libro['autor'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="book-year"><?= htmlspecialchars($libro['anio_publicacion'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="book-description"><?= htmlspecialchars($libro['descripcion'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <div class="reserv-libro">
                    <form action="reserva.php" method="POST">
                        <input type="hidden" name="libro_id" value="<?= htmlspecialchars($libro['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="usuario_id" value="<?= htmlspecialchars($_SESSION['usuario_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"> <!-- El ID del usuario logueado -->
                        <button type="submit">Reservar ya</button>
                    </form>
                </div>
                <?php
            }
        } else {
            echo "<p>No se encontraron libros con los criterios de búsqueda.</p>";
        }
        ?>
    </div>
</main>

<?php
include '../includes/footer.php';
?>
