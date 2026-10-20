-- =========================================
-- CREATE TABLES 
-- =========================================

CREATE DATABASE IF NOT EXISTS practica
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE practica;


-- =========================================
-- 1. USUARIOS
-- =========================================

CREATE TABLE usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- =========================================
-- 2. PUBLICACIONES (ANUNCIOS)
-- =========================================

CREATE TABLE publicaciones (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    cuerpo TEXT NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_publicaciones_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE,

    INDEX idx_publicaciones_titulo (titulo),
    INDEX idx_publicaciones_categoria (categoria),
    INDEX idx_publicaciones_usuario (usuario_id)
) ENGINE=InnoDB;


-- =========================================
-- 3. COMENTARIOS
-- =========================================

CREATE TABLE comentarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    publicacion_id INT UNSIGNED NOT NULL,
    usuario_id INT UNSIGNED NOT NULL,
    cuerpo TEXT NOT NULL,
    fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_comentarios_publicacion
        FOREIGN KEY (publicacion_id)
        REFERENCES publicaciones(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_comentarios_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE,

    INDEX idx_comentarios_publicacion (publicacion_id),
    INDEX idx_comentarios_usuario (usuario_id)
) ENGINE=InnoDB;


-- =========================================
-- INSERTS DE DATOS DE PRUEBA
-- =========================================



-- =========================================
-- 1. USUARIOS
-- =========================================

INSERT INTO usuarios (nombre, email, password) VALUES
(
    'Ana García',
    'ana@example.com',
    '$2y$10$abcdefghijklmnopqrstuuABCDEFGHIJKLMNOPQRSTUVWXYZ012'
),
(
    'Carlos López',
    'carlos@example.com',
    '$2y$10$abcdefghijklmnopqrstuuABCDEFGHIJKLMNOPQRSTUVWXYZ012'
),
(
    'Laura Martín',
    'laura@example.com',
    '$2y$10$abcdefghijklmnopqrstuuABCDEFGHIJKLMNOPQRSTUVWXYZ012'
),
(
    'Pedro Sánchez',
    'pedro@example.com',
    '$2y$10$abcdefghijklmnopqrstuuABCDEFGHIJKLMNOPQRSTUVWXYZ012'
);


-- =========================================
-- 2. PUBLICACIONES
-- =========================================

INSERT INTO publicaciones
    (usuario_id, titulo, cuerpo, categoria)
VALUES
(
    1,
    'Vendo bicicleta de montaña',
    'Bicicleta de montaña en buen estado, ruedas de 29 pulgadas. Precio negociable.',
    'Deportes'
),
(
    1,
    'Busco compañero de piso',
    'Busco una persona responsable para compartir piso cerca del centro.',
    'Inmobiliaria'
),
(
    2,
    'Portátil en venta',
    'Portátil en buen estado, ideal para estudiar o trabajar. Se entrega con cargador.',
    'Informática'
),
(
    3,
    'Clases particulares de matemáticas',
    'Ofrezco clases de matemáticas para estudiantes de ESO y Bachillerato.',
    'Educación'
),
(
    4,
    'Se vende sofá de tres plazas',
    'Sofá de color gris, cómodo y en buen estado. Recogida a cargo del comprador.',
    'Hogar'
);


-- =========================================
-- 3. COMENTARIOS
-- =========================================

INSERT INTO comentarios
    (publicacion_id, usuario_id, cuerpo)
VALUES
(
    1,
    2,
    '¡Hola! ¿Todavía está disponible la bicicleta?'
),
(
    1,
    3,
    '¿Podrías indicar el precio final?'
),
(
    2,
    4,
    'Me interesa. ¿En qué zona se encuentra el piso?'
),
(
    3,
    1,
    '¿Qué procesador tiene el portátil?'
),
(
    3,
    3,
    '¿Se podría ver esta semana?'
),
(
    4,
    2,
    '¿También das clases durante el verano?'
),
(
    5,
    1,
    '¿Cuáles son las medidas del sofá?'
);

