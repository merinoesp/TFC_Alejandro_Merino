-- ============================================================
-- Base de datos: if0_41267709_car2iu
-- Adaptada al código PHP del proyecto (Database.php)
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- ============================================================
-- Tabla: usuarios
-- ============================================================
CREATE TABLE `usuarios` (
  `id_usuario`      INT(11)       NOT NULL AUTO_INCREMENT,
  `nombre`          VARCHAR(100)  NOT NULL,
  `email`           VARCHAR(150)  NOT NULL,
  `contraseña`      VARCHAR(255)  NOT NULL,
  `telefono`        VARCHAR(20)   DEFAULT NULL,
  `fecha_registro`  DATETIME      DEFAULT CURRENT_TIMESTAMP,
  `es_admin`        TINYINT(1)    NOT NULL DEFAULT 0,
  `avatar_ruta`     VARCHAR(255)  DEFAULT 'uploads/avatars/default.png',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de usuarios
-- Contraseña del admin: Admin1234! (bcrypt)
INSERT INTO `usuarios`
  (`id_usuario`, `nombre`, `email`, `contraseña`, `telefono`, `fecha_registro`, `es_admin`, `avatar_ruta`)
VALUES
  (1,  'Carlos',       'merinoalex2003@gmail.com',  '$2y$10$EbhwjiasEgHeH0RpWIcFM.5igDtRqecemzUatmi5XY.tayYraE96S', '691293628', '2026-03-17 08:52:40', 0, 'uploads/avatars/gti.webp'),
  (2,  'JoseLuis',     'neshoxhdxd@gmail.com',       '$2y$10$2/p6D3vtKyzPaqA/YS8WWeK44v5dBtPmp.Gp5kvqHRmed4VsV7z.a', '685902856', '2026-03-18 12:02:01', 0, 'uploads/avatars/OIP.webp'),
  (3,  'merinoesp',    'merino@gmail.com',            '$2y$10$jY4Qs1VQFRqMUIBlLyCG2en3OrzSt.Pc8fwliKkUKLW6pYhWQ4MVK', '652977315', '2026-03-18 16:47:20', 0, 'uploads/avatars/prueba.png'),
  (4,  'Sammy',        'sammy@gmail.com',             '$2y$10$HN7ce.X80aMFxQz79yeGg.sHoTt5GKSlTH3j0sHxS3E54BKE26nbS', '666253809', '2026-03-25 03:45:07', 0, 'uploads/avatars/default.png'),
  (5,  'Soreia Reith', 'sori.rth@gmail.com',          '$2y$10$8rYgiGaaLLTm.tVGg6Y2kuHiR84XS5.h9vD0E5JK4aBNRZ.Ir3Cie', '650605555', '2026-03-25 04:54:00', 0, 'uploads/avatars/IMG_20260318_233636_134.webp'),
  (6,  'Jose Mesa',    'josemesa@educa.madrid.org',   '$2y$10$TimIFf0/0Bsp7bfSWVwYte9bIJ4u9BnT/368KhVSYyujfZF.zYGZG', '548632145', '2026-03-25 09:13:49', 0, 'uploads/avatars/default.png'),
  (7,  'Alejandro',    'admin@hotmail.com',           '$2y$10$XoIgZ9OHWusVeQ2uJOdrPusv98WolBRJhp1kjBms4SwN4teeWag9C', '666253809', '2026-04-08 10:13:10', 0, 'uploads/avatars/default.png'),
  -- CUENTA ADMIN — contraseña: Admin1234!
  (8,  'Admin',        'admin@car2iu.com',            '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL,        '2026-05-21 00:00:00', 1, 'uploads/avatars/default.png');

-- ============================================================
-- Tabla: anuncios
-- ============================================================
CREATE TABLE `anuncios` (
  `id_anuncio`        INT(11)         NOT NULL AUTO_INCREMENT,
  `id_usuario`        INT(11)         NOT NULL,
  `titulo`            VARCHAR(150)    NOT NULL,
  `marca`             VARCHAR(100)    NOT NULL,
  `descripcion`       TEXT            DEFAULT NULL,
  `kilometraje`       INT(11)         NOT NULL DEFAULT 0,
  `anio`              INT(11)         NOT NULL,
  `precio`            DECIMAL(10,2)   NOT NULL,
  `ruta`              VARCHAR(255)    DEFAULT NULL,
  `fecha_publicacion` DATETIME        DEFAULT CURRENT_TIMESTAMP,
  `vendido`           TINYINT(1)      NOT NULL DEFAULT 0,
  `ubicacion`         VARCHAR(255)    DEFAULT NULL,
  PRIMARY KEY (`id_anuncio`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `anuncios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `anuncios`
  (`id_anuncio`, `id_usuario`, `titulo`, `marca`, `descripcion`, `kilometraje`, `anio`, `precio`, `ruta`, `fecha_publicacion`, `vendido`, `ubicacion`)
VALUES
  (26, 1, 'VW Golf GTI 7', 'Volkswagen',
   'Coche en perfecto estado, muy cuidado y en estado casi de colección, en 10 años se le han hecho 120mil km, perfecto para alguien que no haga muchos, mantenimientos al dia',
   120876, 2016, '14.90', 'uploads/anuncios/anuncio_69d67adb8c5955.53944714.webp', '2026-04-08 08:57:16', 0, 'Lugo'),
  (27, 1, 'POLO GTI', 'Volkswagen',
   'bdjdjskskwjsilddkkdkskxkkdkskskdjjejejdjdj',
   150000, 2003, '2300.00', 'uploads/anuncios/anuncio_69da173c9739b5.57563943.jpg', '2026-04-11 02:41:16', 0, 'Madrid');

-- ============================================================
-- Tabla: reportes
-- ============================================================
CREATE TABLE `reportes` (
  `id_reporte`    INT(11)      NOT NULL AUTO_INCREMENT,
  `id_anuncio`    INT(11)      NOT NULL,
  `id_usuario`    INT(11)      NOT NULL,
  `motivo`        VARCHAR(150) NOT NULL,
  `descripcion`   TEXT         DEFAULT NULL,
  `fecha_reporte` DATETIME     DEFAULT CURRENT_TIMESTAMP,
  `estado`        ENUM('pendiente','leido') DEFAULT 'pendiente',
  PRIMARY KEY (`id_reporte`),
  KEY `id_anuncio` (`id_anuncio`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `reportes_ibfk_1` FOREIGN KEY (`id_anuncio`) REFERENCES `anuncios` (`id_anuncio`) ON DELETE CASCADE,
  CONSTRAINT `reportes_ibfk_2` FOREIGN KEY (`id_usuario`)  REFERENCES `usuarios`  (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- AUTO_INCREMENT
ALTER TABLE `usuarios`  MODIFY `id_usuario`  INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
ALTER TABLE `anuncios`  MODIFY `id_anuncio`  INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
ALTER TABLE `reportes`  MODIFY `id_reporte`  INT(11) NOT NULL AUTO_INCREMENT;

COMMIT;

-- ============================================================
-- Tabla: chats (conversaciones entre dos usuarios)
-- ============================================================
CREATE TABLE IF NOT EXISTS `chats` (
  `id_chat`        INT(11)   NOT NULL AUTO_INCREMENT,
  `id_usuario_1`   INT(11)   NOT NULL,
  `id_usuario_2`   INT(11)   NOT NULL,
  `id_anuncio`     INT(11)   DEFAULT NULL,
  `creado_en`      DATETIME  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_chat`),
  UNIQUE KEY `uq_chat` (`id_usuario_1`, `id_usuario_2`, `id_anuncio`),
  KEY `id_usuario_1` (`id_usuario_1`),
  KEY `id_usuario_2` (`id_usuario_2`),
  KEY `id_anuncio`   (`id_anuncio`),
  CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`id_usuario_1`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`id_usuario_2`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  CONSTRAINT `chats_ibfk_3` FOREIGN KEY (`id_anuncio`)   REFERENCES `anuncios` (`id_anuncio`)  ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Tabla: mensajes
-- ============================================================
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje`   INT(11)   NOT NULL AUTO_INCREMENT,
  `id_chat`      INT(11)   NOT NULL,
  `id_emisor`    INT(11)   NOT NULL,
  `contenido`    TEXT      NOT NULL,
  `enviado_en`   DATETIME  DEFAULT CURRENT_TIMESTAMP,
  `leido`        TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_mensaje`),
  KEY `id_chat`   (`id_chat`),
  KEY `id_emisor` (`id_emisor`),
  CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_chat`)   REFERENCES `chats`    (`id_chat`)    ON DELETE CASCADE,
  CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_emisor`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `chats`    MODIFY `id_chat`    INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `mensajes` MODIFY `id_mensaje` INT(11) NOT NULL AUTO_INCREMENT;
