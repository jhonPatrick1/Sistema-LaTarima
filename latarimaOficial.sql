-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2025 a las 19:29:41
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `latarima`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `asunto` varchar(50) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `nombre`, `celular`, `correo`, `asunto`, `mensaje`, `fecha`) VALUES
(2, 'Lionel Molina', '987412365', 'jhonpatrickcali@gmail.com', 'Trabaja con nosotros', 'Busco chambaaaaa', '2025-11-23 21:28:47'),
(4, 'Joseph Smith', '987415365', 'josephcali@gmail.com', 'Sugerencia', 'Mejorar la carta ', '2025-11-23 21:37:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `tipo_entrega` enum('delivery','recojo') DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `referencia` varchar(200) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `metodo_pago` enum('efectivo','tarjeta') DEFAULT NULL,
  `productos` text DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'En preparación',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario`, `tipo_entrega`, `direccion`, `referencia`, `celular`, `metodo_pago`, `productos`, `total`, `estado`, `fecha`) VALUES
(21, 'jhonpatrick', 'recojo', '', '', '', 'efectivo', 'Doble Carne (S/16.90), Parrillera (S/18.50)', 35.40, 'En preparación', '2025-11-23 21:23:33'),
(22, 'daleshka', 'recojo', '', '', '986534726', 'efectivo', 'Doble Carne (S/16.90), Pack Familiar (S/59.90)', 76.80, 'En preparación', '2025-11-23 22:51:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`) VALUES
(6, 'Hamburguesa Clásica', 'Carne jugosa con papas, lechuga y tocino.', 15.90, 'img/carne1.jpg'),
(7, 'Parrillera', 'Carne, doble queso, doble chorizo, máximo sabor', 18.50, 'img/carne2.jpg'),
(8, 'Doble Carne', 'Doble carne jugosa y doble queso.', 16.90, 'img/carne3.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `rol` varchar(20) DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `correo`, `celular`, `direccion`, `contrasena`, `rol`) VALUES
(1, 'Jhon Patrick Cali', 'jhonpatrick', 'jhonpatrickcg@gmail.com', '923469044', 'Jr.Alonso del Rincón 1332', '$2y$10$MZqW.Wpc4mzJh5R7Ex7uuOts65HrP6AbP2.DasMXF.MKtJR.gFkIa', 'usuario'),
(2, 'Joseph Smith Cali', 'josephsmith', 'josephcali@gmail.com', '93587415', 'Jr.Alonso del Rincón 1333', '$2y$10$4TaepAHUugTKLBRNTpcGe.v3UySwP0O5VBJdWHXP0TP8IKi3yhYZC', 'usuario'),
(3, 'Jhonny Martin Cali', 'jhonnycali', 'jhonnycali@gmail.com', '986534726', 'Jr.Huanuco 3021', '$2y$10$VU6BfhaLzp0W0vJhN8hK6euWNq2724elkz6pPgCrvAzB5bX2XK4Wm', 'usuario'),
(5, 'Administrador', 'admin1', 'administrador@gmail.com', '987425632', 'Oficina central ', '$2y$10$HKOGHHFJSxsSX/XYV8gpuObekDwBw7z/P1970hcslhKqYzIrdau26', 'administrador'),
(6, 'Lionel Molina', 'leomolina', 'lionel@gmail.com', '987412365', 'Jr.Alonso del Rincón 1348', '$2y$10$kqwwUwKM0QUcoGY9gA0rGedcxZxVw.OU.3Fh2l7dqWd.lYYjNK4lu', 'usuario'),
(8, 'Jeremias Tablon', 'Jerebuys', 'jeremias_buys@gmail.com', '902343212', 'Jr.Alonso del Rincón 2002', '$2y$10$Sxo0XWJidSBviZxCvyMXTemsv2tcwYtQGlfZCKuZDKls2N6UxEg2C', 'usuario'),
(9, 'Daleshka zared', 'daleshka', 'dale@gmail.com', '987412365', 'Jr.Huanuco 3021', '$2y$10$IeKyrbivUN1gpEuBA49lTu7.sc4QlwElwCYOPgD3bKJ6GhtLv73Cm', 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
