-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-06-2019 a las 17:44:08
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `homeswitch`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `username` varchar(30) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `mail` varchar(60) NOT NULL,
  `contraseña` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`username`, `nombre`, `apellido`, `mail`, `contraseña`) VALUES
('admin', 'unNombre', 'unApellido', 'unMAil@gmail', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialdepujas`
--

CREATE TABLE `historialdepujas` (
  `username` varchar(30) NOT NULL,
  `idsubasta` int(11) NOT NULL,
  `montopuja` float(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `historialdepujas`
--

INSERT INTO `historialdepujas` (`username`, `idsubasta`, `montopuja`) VALUES
('1', 3, 400.00),
('1', 4, 550.00),
('1', 3, 550.00),
('1', 3, 700.00),
('1', 4, 800.00),
('macarena.sanchez', 8, 200.00),
('macarena.sanchez', 10, 200.00),
('macarena.sanchez', 12, 300.30),
('otroUser2', 10, 210.00),
('otroUser123', 13, 200.00),
('guille', 9, 1.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `idpago` int(11) NOT NULL,
  `dni` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantcuotas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peticiones`
--

CREATE TABLE `peticiones` (
  `username` varchar(30) NOT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `peticiones`
--

INSERT INTO `peticiones` (`username`, `estado`) VALUES
('macarena.sanchez', 'esperandoRespuesta'),
('otroUser2', 'esperandoRespuesta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios`
--

CREATE TABLE `precios` (
  `id` int(1) NOT NULL,
  `basico` float(7,2) NOT NULL,
  `premiun` float(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `precios`
--

INSERT INTO `precios` (`id`, `basico`, `premiun`) VALUES
(1, 1500.50, 3400.75);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `numreserva` int(11) NOT NULL,
  `tipo` varchar(11) NOT NULL,
  `idresidencia` int(11) NOT NULL,
  `preciobase` float(7,2) NOT NULL,
  `fechainicio` date NOT NULL,
  `semana` int(3) NOT NULL,
  `año` int(5) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`numreserva`, `tipo`, `idresidencia`, `preciobase`, `fechainicio`, `semana`, `año`, `estado`) VALUES
(9, 'directa', 2, 0.11, '0000-00-00', 22, 2019, 0),
(10, 'subasta', 2, 99.00, '0000-00-00', 25, 2019, 0),
(11, 'hotsale', 2, 0.11, '0000-00-00', 27, 2019, 1),
(12, 'subasta', 3, 200.00, '0000-00-00', 27, 2019, 1),
(13, 'subasta', 9, 100.00, '0000-00-00', 25, 2019, 1),
(14, 'directa', 1, 333.33, '2019-06-06', 33, 2019, 1),
(15, 'subasta', 2, 99.00, '2019-06-16', 29, 2019, 1),
(16, 'directa', 4, 700.00, '2019-06-18', 50, 2021, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `residencia`
--

CREATE TABLE `residencia` (
  `idresidencia` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `pais` varchar(40) NOT NULL,
  `ciudad` varchar(85) NOT NULL,
  `cantpersonas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `residencia`
--

INSERT INTO `residencia` (`idresidencia`, `descripcion`, `direccion`, `nombre`, `pais`, `ciudad`, `cantpersonas`) VALUES
(0, 'unaDescripcionNueva4', 'calle 8 223', 'resiPrueba', 'unPaisNuevo5', 'unaCiudadNueva3', 4),
(1, 'unaDescrip', 'unaDir', 'unNombre', 'unPais', 'unaCiudad', 3),
(2, 'unaDescrip2', 'unaDir2', 'unNombre2', 'unPais2', 'unaCiudad2', 2),
(3, 'unaDescripcionNueva2', 'unaDirNueva1', 'unnombreNuevo1', 'unPaisNuevo3', 'unaCiudadNueva1', 2),
(4, 'unaDescripcionNueva2', 'unaDirNueva2', 'unnombreNuevo2', 'unPaisNuevo5', 'unaCiudadNueva1', 2),
(9, 'unaDescripcionNueva3', 'unaDir', 'unNombre1', 'unPaisNuevo7', 'unaCiudadNueva1', 3),
(10, 'unaDescripcionNueva1', 'unaDirNueva1', 'unNombre', 'unPaisNuevo5', 'unaCiudadNueva2', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `dni` int(11) NOT NULL,
  `tipo` varchar(10) NOT NULL DEFAULT '1',
  `username` varchar(30) NOT NULL,
  `contraseña` varchar(10) NOT NULL,
  `cantReservas` int(1) NOT NULL DEFAULT '2',
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `mail` varchar(45) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `inicioContrato` date NOT NULL,
  `finContrato` date NOT NULL,
  `numTarjeta` varchar(16) NOT NULL,
  `vencimientoTarjeta` date NOT NULL,
  `codSegTarjeta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`dni`, `tipo`, `username`, `contraseña`, `cantReservas`, `nombre`, `apellido`, `mail`, `telefono`, `direccion`, `inicioContrato`, `finContrato`, `numTarjeta`, `vencimientoTarjeta`, `codSegTarjeta`) VALUES
(28875123, 'premiun', '', 'contraseña', 2, 'tomas', 'orejuela', 'unmail@gmail.com', '2147483647', 'calle 8 223', '0000-00-00', '0000-00-00', '2147483647', '0000-00-00', 123),
(39487145, 'premiun', 'guille', 'guille', 1, 'Guille', 'Guillen', 'mail@gmail.com', '2147483647', 'Direccion', '0000-00-00', '0000-00-00', '1212131314141515', '2019-07-01', 221),
(390891113, 'basico', 'macarena.sanchez', 'contraseña', 2, 'macarena1', 'sanchez1', 'unmail@gmail.com1', '2147483647', 'calle 13 29981', '0000-00-00', '0000-00-00', '2147483647', '0000-00-00', 351),
(42888999, 'basico', 'otroUser', 'user', 2, 'unnombreNuevo2', 'sanchez', 'unaDir@gmail.com', '2147483647', 'unaDir', '0000-00-00', '0000-00-00', '2147483647', '0000-00-00', 123),
(41999348, 'basico', 'otroUser123', '12345', 2, 'mario', 'Guillen', 'unmail@gmail.com', '2147483647', 'calle 8 223', '0000-00-00', '0000-00-00', '1212111113131411', '2020-02-01', 129),
(28875123, 'basico', 'otroUser2', 'contraseña', 2, 'unNombre', 'sanchez', 'unmail@gmail.com', '2147483647', 'calle 8 223', '0000-00-00', '0000-00-00', '2147483647', '0000-00-00', 123),
(28875123, 'basico', 'user', 'user', 2, 'unNombre', 'roldan', 'unmail@gmail.com', '2344409478', 'unaDirNueva1', '0000-00-00', '0000-00-00', '1212121213131414', '2019-07-01', 112);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`idpago`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`numreserva`);

--
-- Indices de la tabla `residencia`
--
ALTER TABLE `residencia`
  ADD PRIMARY KEY (`idresidencia`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
