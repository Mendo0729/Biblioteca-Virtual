<?php
// Incluir el admin_header.php
include '../../includes/admin/admin_header.php';

// Incluir el archivo de funciones
require_once '../../scripts/funciones.php';

// Obtener los conteos de libros y usuarios
$totalBooks = getTotalBooks();
$totalUsers = getTotalUsers();
$totalLibrosAlquilados = getTotalBooksRented();
$totalReservasPendientes = getPendingReservations();
?>

<main class="dashboard">
    <!-- Resumen General -->
    <section class="dashboard-overview">
        <h2>Resumen General</h2>
        <div class="stats">
            <div class="stat-item">
                <p>Total de Libros</p>
                <h3><?php echo $totalBooks?></h3>
            </div>
            <div class="stat-item">
                <p>Total de Usuarios</p>
                <h3><?php echo $totalUsers?></h3>
            </div>
            <div class="stat-item">
                <p>Libros Alquilados</p>
                <h3><?php echo$totalLibrosAlquilados?></h3>
            </div>
            <div class="stat-item">
                <p>Reservas Pendientes</p>
                <h3><?php echo$totalReservasPendientes?></h3>
            </div>
        </div>
    </section>
    
    <!-- Gestión de Libros -->
    <section class="dashboard-management">
        <h2>Gestión de Libros</h2>
        <div class="management-buttons">
            <a href="admin_libros.php" class="btn">Ver Libros</a>
            <a href="admin_libros_add.php" class="btn">Agregar Libro</a>
        </div>
    </section>

    <!-- Gestión de Usuarios -->
    <section class="dashboard-management">
        <h2>Gestión de Usuarios</h2>
        <div class="management-buttons">
            <a href="admin_usuarios.php" class="btn">Ver Usuarios</a>
            <a href="admin_usuarios_add.php" class="btn">Agregar Usuario</a>
        </div>
    </section>

    <!-- Gestión de Alquileres -->
    <section class="dashboard-management">
        <h2>Gestión de Alquileres</h2>
        <div class="management-buttons">
            <a href="admin_alquileres.php" class="btn">Ver Alquileres</a>
            <a href="admin_alquileres_add.php" class="btn">Agregar Alquiler</a>
        </div>
    </section>
</main>



<?php
// Incluir el admin_header.php
include '../../includes/footer.php';
?>