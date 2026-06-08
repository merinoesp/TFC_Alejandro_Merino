-- 1. Crear la base de datos
CREATE DATABASE IF NOT EXISTS car2iu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE car2iu;

-- 2. Tabla usuarios (Ajustada a tu función PHP)
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    avatar_ruta VARCHAR(255),
    -- Campo exacto que busca tu función verificarAdmin
    es_admin TINYINT(1) DEFAULT 0, 
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabla anuncios
CREATE TABLE IF NOT EXISTS anuncios (
    id_anuncio INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    marca VARCHAR(50),
    anio YEAR,
    kilometraje INT,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    ruta VARCHAR(255),
    ubicacion VARCHAR(100),
    vendido TINYINT DEFAULT 0,
    fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

-- 4. Tabla reportes
CREATE TABLE IF NOT EXISTS reportes (
    id_reporte INT AUTO_INCREMENT PRIMARY KEY,
    id_anuncio INT NOT NULL,
    id_usuario INT NOT NULL,
    motivo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    fecha_reporte DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'leido') DEFAULT 'pendiente',
    FOREIGN KEY (id_anuncio) REFERENCES anuncios(id_anuncio) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);