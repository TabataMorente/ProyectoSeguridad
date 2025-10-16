-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 16-09-2020 a las 16:37:17
-- Versión del servidor: 10.5.5-MariaDB-1:10.5.5+maria~focal
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Configuración de codificación
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Base de datos: `database`

-- Tabla: usuarios
CREATE TABLE `usuarios` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `nombre` text NOT NULL,
  `contrasena` text NOT NULL,
  `dni` text NOT NULL,
  `telefono` int(11) NOT NULL,
  `fecha` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla: cerdo
CREATE TABLE `cerdo` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `nombre` text NOT NULL,
  `peso` decimal(10,2) NOT NULL,
  `especie` text NOT NULL,
  `color` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla: carrera
CREATE TABLE `carrera` (
  `fecha` date NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `ubicacion` text NOT NULL,
  PRIMARY KEY (`fecha`, `nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla: participante
CREATE TABLE `participante` (
  `cerdo` int(11) NOT NULL,
  `fechaCarrera` date NOT NULL,
  `nombreCarrera` varchar(40) NOT NULL,
  PRIMARY KEY (`cerdo`, `fechaCarrera`, `nombreCarrera`),
  FOREIGN KEY (`cerdo`) REFERENCES `cerdo`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`fechaCarrera`, `nombreCarrera`) REFERENCES `carrera`(`fecha`, `nombre`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla: apuesta
CREATE TABLE `apuesta` (
  `cerdo` int(11) NOT NULL,
  `fechaCarrera` date NOT NULL,
  `nombreCarrera` varchar(40) NOT NULL,
  `idUs` int(11) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  PRIMARY KEY (`cerdo`, `fechaCarrera`, `nombreCarrera`, `idUs`),
  FOREIGN KEY (`cerdo`) REFERENCES `cerdo`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`fechaCarrera`, `nombreCarrera`) REFERENCES `carrera`(`fecha`, `nombre`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`idUs`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Datos de ejemplo para la tabla cerdo
INSERT INTO `cerdo` (`id`, `nombre`, `peso`, `especie`, `color`) VALUES
(1, 'Ta', 280.00, 'Bentheim Black Pied', 'Negro'),
(2, 'Marco', 320.00, 'Yorkshire', 'Rosa'),
(3, 'Laura', 42.00, 'Gottigen', 'Rosa'),
(4, 'Pi', 270.00, 'Hereford', 'Marron con manchas'),
(5, 'Tata', 79.00, 'Kunekune', 'Blanco con manchas'),
(6, 'Iker', 420.00, 'Meishan', 'Negro'),
(7, 'Gorka', 500.00, 'Poland china', 'Negro'),
(8, 'As', 250.00, 'Mangalica', 'Gris');

-- Datos de ejemplo para la tabla carrera
INSERT INTO `carrera` (`fecha`, `nombre`, `ubicacion`) VALUES
('2025-10-31', 'Marcarrera especial Halloween', 'Sonora'),
('2025-12-20', 'Carrera nacional', 'Badajoz'),
('2026-01-10', 'Marcarrera especial Navidad', 'Bilbao'),
('2026-03-22', 'Mundial', 'Australia');

-- Datos de ejemplo para la tabla participante
INSERT INTO `participante` (`cerdo`, `fechaCarrera`, `nombreCarrera`) VALUES
(2, '2025-10-31', 'Marcarrera especial Halloween'),
(3, '2025-10-31', 'Marcarrera especial Halloween'),
(5, '2025-10-31', 'Marcarrera especial Halloween'),
(7, '2025-10-31', 'Marcarrera especial Halloween'),
(6, '2025-10-31', 'Marcarrera especial Halloween');

-- Ejemplo comentado para insertar usuarios
-- INSERT INTO `usuarios` (`id`, `nombre`, `contrasena`, `dni`, `telefono`, `fecha`, `email`) VALUES
-- (1, 'mikel', '1234', '12345678A', 600123456, '2025-10-01', 'mikel@example.com'),
-- (2, 'aitor', '5678', '87654321B', 611987654, '2025-10-05', 'aitor@example.com');

-- Restaurar codificación original
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

