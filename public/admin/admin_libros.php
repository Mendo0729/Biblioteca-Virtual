<?php
// Incluir archivo de conexión a la base de datos
require_once '../../scripts/data_base.php';

// Include the admin header
include '../../includes/admin/admin_header.php';

// Include the function to search for books
include '../../scripts/funciones.php';

// Get the search parameters from the form
$nombreAutor = isset($_GET['nombre_o_autor']) ? $_GET['nombre_o_autor'] : '';
$genero = isset($_GET['genero']) ? $_GET['genero'] : '';
$ano = isset($_GET['ano']) ? $_GET['ano'] : '';

// Search for books using the function
$libros = buscarLibros($pdo, $nombreAutor, $genero, $ano);

// Verificar si se enviaron los datos a través del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $anioPublicacion = $_POST['anio_publicacion'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];

    // Verifica que se haya enviado la imagen correctamente
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Obtener información del archivo
        $nombreArchivo = $_FILES['imagen']['name'];
        $tipoArchivo = $_FILES['imagen']['type'];
        $tamanoArchivo = $_FILES['imagen']['size'];
        $rutaTemporal = $_FILES['imagen']['tmp_name'];

        // Validar el tipo de archivo (solo permitir imágenes)
        $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'gif');
        $extensionArchivo = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

        if (in_array(strtolower($extensionArchivo), $extensionesPermitidas)) {
            // Definir el nombre final del archivo y la ruta donde se guardará
            $directorioDestino = '../../public/img/libros/'; // Cambia esto por la ruta donde quieres guardar la imagen
            $nombreFinal = uniqid() . '.' . $extensionArchivo;
            $rutaFinal = $directorioDestino . $nombreFinal;

            // Mover el archivo a su ubicación final
            if (move_uploaded_file($rutaTemporal, $rutaFinal)) {
                // El archivo se ha subido correctamente, procesamos el resto de los datos

                try {
                    // Preparar la consulta SQL para insertar el libro
                    $sql = "INSERT INTO LIBROS (titulo, autor, genero, anio_publicacion, descripcion, imagen, cantidad) 
                            VALUES (:titulo, :autor, :genero, :anio_publicacion, :descripcion, :imagen, :cantidad)";
                    $stmt = $pdo->prepare($sql);

                    // Vincular los valores
                    $stmt->bindParam(':titulo', $titulo);
                    $stmt->bindParam(':autor', $autor);
                    $stmt->bindParam(':genero', $genero);
                    $stmt->bindParam(':anio_publicacion', $anioPublicacion);
                    $stmt->bindParam(':descripcion', $descripcion);
                    $stmt->bindParam(':imagen', $nombreFinal); // Guardamos el nombre de la imagen en la base de datos
                    $stmt->bindParam(':cantidad', $cantidad);

                    // Ejecutar la consulta
                    if ($stmt->execute()) {
                        // Redirigir a la página de libros con un mensaje de éxito
                        header('Location: admin_libros.php?mensaje=Libro añadido con éxito');
                        exit();
                    } else {
                        echo "Error al guardar el libro en la base de datos.";
                    }
                } catch (PDOException $e) {
                    echo "Error en la base de datos: " . $e->getMessage();
                }
            } else {
                echo "Error al mover el archivo.";
            }
        } else {
            echo "Formato de archivo no permitido. Solo se permiten imágenes.";
        }
    } else {
        echo "No se ha subido ninguna imagen o hubo un error en la subida.";
    }
} else {
    echo "Método no permitido.";
}
?>



<main class="admin-libros">
    <div class="titulo">
        <h2>Catalogo de Libros</h2>
    </div>

    <div class="busqueda-libro">
        <form action="admin_libros.php" method="GET">
            <!-- Input para buscar por nombre o autor -->
            <label for="nombre_o_autor">Nombre del libro o autor:</label>
            <input type="text" id="nombre_o_autor" name="nombre_o_autor" placeholder="Nombre del libro o autor" value="<?php echo htmlspecialchars($nombreAutor); ?>">

            <!-- Lista desplegable para género -->
            <label for="genero">Género:</label>
            <select id="genero" name="genero">
                <option value="">Todos los géneros</option>
                <option value="Ficcion" <?php if ($genero == 'Ficcion') echo 'selected'; ?>>Ficción</option>
                <option value="No Ficcion" <?php if ($genero == 'No Ficcion') echo 'selected'; ?>>No Ficción</option>
                <option value="Ciencia" <?php if ($genero == 'Ciencia') echo 'selected'; ?>>Ciencia</option>
                <option value="Historia" <?php if ($genero == 'Historia') echo 'selected'; ?>>Historia</option>
                <option value="Biografia" <?php if ($genero == 'Biografia') echo 'selected'; ?>>Biografía</option>
                <option value="Fantasia" <?php if ($genero == 'Fantasia') echo 'selected'; ?>>Fantasia</option>
                <option value="Romance" <?php if ($genero == 'Romance') echo 'selected'; ?>>Romance</option>
            </select>

            <!-- Lista desplegable para el año de publicación -->
            <label for="ano">Año de publicación:</label>
            <select id="ano" name="ano">
                <option value="">Todos los años</option>
                <?php
                $currentYear = date("Y");
                for ($year = $currentYear; $year >= 1900; $year--) {
                    echo "<option value='$year'" . ($ano == $year ? ' selected' : '') . ">$year</option>";
                }
                ?>
            </select>

            <!-- Botón de búsqueda -->
            <button type="submit">Buscar</button>
        </form>
    </div>

    <div class="tabla-libro">
        <table>
            <tr>
                <th>Nombre</th>
                <th>Autor</th>
                <th>Año</th>
                <th>Género</th>
            </tr>
            <?php
            if (!empty($libros)) {
                // If books were found, display them in the table
                foreach ($libros as $libro) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($libro['titulo']) . "</td>";
                    echo "<td>" . htmlspecialchars($libro['autor']) . "</td>";
                    echo "<td>" . htmlspecialchars($libro['anio_publicacion']) . "</td>";
                    echo "<td>" . htmlspecialchars($libro['genero']) . "</td>";
                    echo "</tr>";
                }
            } else {
                // If no books were found
                echo "<tr><td colspan='4'>No se ha encontrado ningún libro.</td></tr>";
            }
            ?>
        </table>
    </div>
    <div class="anadir-libros">
        <a href="#" id="mostrarFormulario">Añadir Libro</a>
        <div id="formularioAnadirLibro" class="formulario-oculto">
            <form action="admin_libros.php" method="POST" enctype="multipart/form-data">
                <label for="titulo">Título del libro:</label>
                <input type="text" id="titulo" name="titulo" required>

                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" required>

                <label for="genero">Género:</label>
                <select id="genero" name="genero" required>
                    <option value="Ficcion">Ficción</option>
                    <option value="No Ficcion">No Ficción</option>
                    <option value="Ciencia">Ciencia</option>
                    <option value="Historia">Historia</option>
                    <option value="Biografia">Biografía</option>
                    <option value="Biografia">Fantasia</option>
                    <option value="Biografia">Romance</option>
                </select>

                <label for="anio_publicacion">Año de publicación:</label>
                <input type="number" id="anio_publicacion" name="anio_publicacion" min="1900" max="<?php echo date('Y'); ?>" required>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

                <label for="imagen">Imagen del libro:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>

                <label for="cantidad">Cantidad de libros:</label>
                <input type="number" id="cantidad" name="cantidad" min="1" required>

                <button type="submit">Guardar</button>
                <button type="button" id="cancelarFormulario">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
    // Mostrar y ocultar el formulario
    document.getElementById('mostrarFormulario').addEventListener('click', function(e) {
        e.preventDefault();  // Prevenir el comportamiento predeterminado del enlace
        document.getElementById('formularioAnadirLibro').style.display = 'block';
    });

    document.getElementById('cancelarFormulario').addEventListener('click', function() {
        document.getElementById('formularioAnadirLibro').style.display = 'none';
    });
    </script>


    </div>

</main>

<?php
// Include the footer
include '../../includes/footer.php';
?>
