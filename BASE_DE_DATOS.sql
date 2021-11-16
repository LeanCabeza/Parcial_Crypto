-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2021 a las 01:45:08
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crypto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crypto`
--

CREATE TABLE `crypto` (
  `id` int(255) NOT NULL,
  `precio` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `nacionalidad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `crypto`
--

INSERT INTO `crypto` (`id`, `precio`, `nombre`, `foto`, `nacionalidad`) VALUES
(1, '15000', 'bitcoin', '', 'argentina'),
(2, '150000', 'Eterium', 'bitcoin.jpg', 'alemania'),
(4, '190000', 'dogecoin', 'dogecoin.jpg', 'boliviana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `mail`, `tipo`, `clave`, `nombre`) VALUES
(1, 'admin@admin.com', 'admin', '$2y$10$ufNJBj7nyaNYc14Hc.Fni.GaeaG7LRBCWzQqSqnJ6D2KCmN5RahLK', 'Juan'),
(2, 'usuario@usuario.com', 'usuario', '$2y$10$ufNJBj7nyaNYc14Hc.Fni.GaeaG7LRBCWzQqSqnJ6D2KCmN5RahLK', 'Pablo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `id_cliente` varchar(255) NOT NULL,
  `id_crypto` varchar(255) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `cantidad` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `id_cliente`, `id_crypto`, `fecha`, `cantidad`, `foto`) VALUES
(1, '1', '1', '2021-11-15 04:03:44', '500', 'Juan-bitcoin-2021-11-15.jpg'),
(2, '1', '2', '2021-06-11 04:03:44', '99999', ''),
(3, '1', '1', '2021-11-15 23:02:49', '500', 'Juan-bitcoinx-2021-11-15.jpg'),
(4, '1', '1', '2021-11-15 23:04:26', '500', 'Juan-bitcoinx-2021-11-15.jpg'),
(5, '2', '1', '2021-11-15 23:05:12', '500', 'Pablo-bitcoinx-2021-11-15.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `crypto`
--
ALTER TABLE `crypto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `crypto`
--
ALTER TABLE `crypto`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
