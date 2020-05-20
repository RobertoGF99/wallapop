-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2020 a las 23:55:41
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `wallapop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`tipo`) VALUES
('otros'),
('propiedad'),
('vehiculo\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images_producto`
--

CREATE TABLE `images_producto` (
  `id_image` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `images_producto`
--

INSERT INTO `images_producto` (`id_image`, `name`, `created`, `id_producto`) VALUES
(29, 'seat.jpg', '2020-05-20 23:36:49', 45),
(30, 'seat2.jpg', '2020-05-20 23:36:49', 45),
(31, 'seat3.jpg', '2020-05-20 23:36:49', 45),
(33, 'casa.jpg', '2020-05-20 23:42:09', 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images_user`
--

CREATE TABLE `images_user` (
  `id_image` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `images_user`
--

INSERT INTO `images_user` (`id_image`, `name`, `created`, `id_usuario`) VALUES
(1, 'mesa.jpg', '2020-05-15 03:48:20', 15),
(2, 'yo.jpeg', '2020-05-15 03:48:20', 15),
(3, 'editHabitos.jpg', '2020-05-20 18:31:38', 16),
(4, 'editHabitos.jpg', '2020-05-20 18:34:40', 16),
(5, 'juan.jpg', '2020-05-20 23:19:40', 18),
(6, 'juan.jpg', '2020-05-20 23:21:37', 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(5) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `precio` float NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `stock` int(1) NOT NULL,
  `id_usuario` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `tipo`, `nombre`, `descripcion`, `precio`, `created`, `stock`, `id_usuario`) VALUES
(45, 'vehiculo', 'seat Leon', 'Seat leon blanco nuevo. A estrenar', 10000, '2020-05-20 23:36:49', 1, 19),
(47, 'propiedad', 'chalet', 'grande, jardin, piscina, nuevo', 35000, '2020-05-20 23:42:09', 1, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(15) NOT NULL,
  `localizacion` varchar(30) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `imagen` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `apellidos`, `email`, `password`, `localizacion`, `created`, `imagen`) VALUES
(19, 'juan', 'rubio', 'juan@juan.com', 'abc', 'alicante', '2020-05-20 23:21:36', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`tipo`);

--
-- Indices de la tabla `images_producto`
--
ALTER TABLE `images_producto`
  ADD PRIMARY KEY (`id_image`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `images_user`
--
ALTER TABLE `images_user`
  ADD PRIMARY KEY (`id_image`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`) USING BTREE;

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `images_producto`
--
ALTER TABLE `images_producto`
  MODIFY `id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `images_user`
--
ALTER TABLE `images_user`
  MODIFY `id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
