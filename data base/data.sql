CREATE DATABASE Biblioteca;
use Biblioteca;

-- Crear tabla de ROL
CREATE TABLE ROL (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- Insertar roles predefinidos
INSERT INTO ROL (nombre) VALUES ('usuario'), ('administrador');

-- Crear tabla de USUARIOS
CREATE TABLE USUARIOS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL,
    FOREIGN KEY (rol_id) REFERENCES ROL(id)
);

-- Crear tabla de LIBROS con cantidad de copias
CREATE TABLE LIBROS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    genero VARCHAR(100) NOT NULL,
    anio_publicacion YEAR NOT NULL,
    descripcion TEXT NOT NULL,
    imagen VARCHAR(500), -- Ruta a la imagen del libro
    cantidad INT NOT NULL DEFAULT 0 -- Cantidad de copias disponibles
);

-- Crear tabla de ALQUILERES
CREATE TABLE ALQUILERES (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    libro_id INT NOT NULL,
    fecha_alquiler DATE NOT NULL,
    fecha_devolucion DATE NOT NULL,
    estado ENUM('activo', 'devuelto') NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES USUARIOS(id),
    FOREIGN KEY (libro_id) REFERENCES LIBROS(id)
);

-- Crear tabla de RESERVAS
CREATE TABLE RESERVAS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    libro_id INT NOT NULL,
    fecha_reserva DATE NOT NULL,
    estado ENUM('pendiente', 'aprobada', 'cancelada') NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES USUARIOS(id),
    FOREIGN KEY (libro_id) REFERENCES LIBROS(id)
);



