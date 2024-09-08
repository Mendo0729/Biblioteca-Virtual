<?php
$titulo = "Admin-Dashboard";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Biblioteca Virtual - <?php echo "$titulo"?></title>
    <link rel="stylesheet" href="../../public/css/admin/style_admin.css">
    <link rel="stylesheet" href="../../public/css/admin/style_tablaLibros.css">
</head>
<body>
    <header>
        <nav class="container-menu">
            <div class="menu-logo">
                <p>Biblioteca Virtual</p>
            </div>
            <div class="menu-link">
                <ul>
                    <li><a href="../../public/admin/admin_dashboard.php">Inicio</a></li>
                    <li><a href="../../public/admin/admin_libros.php">Libros</a></li>
                    <li><a href="../../public/admin/usuarios.php">Usuarios</a></li>
                    <li><a href="../../public/admin/alquileres.php">Alquileres</a></li>
                    <li><a href="../../includes/logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </nav>
    </header>