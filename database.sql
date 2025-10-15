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


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `database`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `nombre` text NOT NULL,
  -- `contrasena` text NOT NULL, -- por confirmar donde poner las contrasenas
  `dni` text NOT NULL,
  `telefono` int(9) NOT NULL,
  `fecha` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

-- INSERT INTO `usuarios` (`id`, `nombre`) VALUES
-- (1, 'mikel'),
-- (2, 'aitor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--

-- TABLA ITEM(CERDO)
CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);
COMMIT;

-- RELACION: UN POSTOR PUEDE APOSTAR POR MAS DE UN CERDO, POR UN CERDO PUEDEN APOSTAR MAS DE UN POSTOR
CREATE TABLE `APUESTO`(
  `id_usuario` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,

  FOREIGN KEY (id_usuario) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (id_item) REFERENCES `item`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
