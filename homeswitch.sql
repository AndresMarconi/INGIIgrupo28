-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2019 a las 21:46:47
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
  `dni` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `mail` varchar(60) NOT NULL,
  `contraseña` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`dni`, `username`, `nombre`, `apellido`, `mail`, `contraseña`) VALUES
(11222333, 'admin', 'unNombre', 'unApellido', 'unMAil@gmail', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directa`
--

CREATE TABLE `directa` (
  `numreserva` int(11) NOT NULL,
  `idresidencia` int(11) NOT NULL,
  `dni` int(11) NOT NULL,
  `disponibilidaddesde` date NOT NULL,
  `disponibilidadhasta` date NOT NULL,
  `fechainicio` date NOT NULL,
  `semana` int(3) NOT NULL,
  `año` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `directa`
--

INSERT INTO `directa` (`numreserva`, `idresidencia`, `dni`, `disponibilidaddesde`, `disponibilidadhasta`, `fechainicio`, `semana`, `año`) VALUES
(1, 1, 11222333, '0000-00-00', '0000-00-00', '2019-02-02', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialdepujas`
--

CREATE TABLE `historialdepujas` (
  `username` varchar(30) NOT NULL,
  `idsubasta` int(11) NOT NULL,
  `montopuja` int(11) NOT NULL,
  `mail` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `historialdepujas`
--

INSERT INTO `historialdepujas` (`username`, `idsubasta`, `montopuja`, `mail`) VALUES
('1', 3, 400, 'unmail@gmail.com'),
('1', 4, 550, 'unmail@gmail.com'),
('1', 3, 550, 'unmail@gmail.com'),
('1', 3, 700, 'asdf@gmail.com'),
('1', 4, 800, 'otromail@gmail.com'),
('macarena.sanchez', 8, 200, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotsale`
--

CREATE TABLE `hotsale` (
  `numreserva` int(11) NOT NULL,
  `idresidencia` int(11) NOT NULL,
  `dni` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `disponibilidaddesde` date NOT NULL,
  `disponibilidadhasta` date NOT NULL,
  `fechainicio` date NOT NULL,
  `semana` int(3) NOT NULL,
  `año` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `hotsale`
--

INSERT INTO `hotsale` (`numreserva`, `idresidencia`, `dni`, `precio`, `disponibilidaddesde`, `disponibilidadhasta`, `fechainicio`, `semana`, `año`) VALUES
(2, 1, 11222333, 100, '0000-00-00', '0000-00-00', '2019-02-02', 0, 0);

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
-- Estructura de tabla para la tabla `reservasconcretadas`
--

CREATE TABLE `reservasconcretadas` (
  `identificador` int(11) NOT NULL,
  `dni` int(11) NOT NULL,
  `semanarealizada` date NOT NULL,
  `idreserva` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `residencia`
--

CREATE TABLE `residencia` (
  `idresidencia` int(11) NOT NULL,
  `dni` int(11) NOT NULL,
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

INSERT INTO `residencia` (`idresidencia`, `dni`, `descripcion`, `direccion`, `nombre`, `pais`, `ciudad`, `cantpersonas`) VALUES
(1, 11222333, 'unaDescrip', 'unaDir', 'unNombre', 'unPais', 'unaCiudad', 3),
(2, 11222333, 'unaDescrip2', 'unaDir2', 'unNombre2', 'unPais2', 'unaCiudad2', 2),
(3, 0, 'unaDescripcionNueva2', 'unaDirNueva1', 'unnombreNuevo1', 'unPaisNuevo3', 'unaCiudadNueva1', 2),
(4, 0, 'unaDescripcionNueva2', 'unaDirNueva2', 'unnombreNuevo2', 'unPaisNuevo5', 'unaCiudadNueva1', 2),
(9, 0, 'unaDescripcionNueva3', 'unaDir', 'unNombre1', 'unPaisNuevo7', 'unaCiudadNueva1', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subasta`
--

CREATE TABLE `subasta` (
  `numreserva` int(11) NOT NULL,
  `idresidencia` int(11) NOT NULL,
  `dni` int(11) NOT NULL,
  `preciobase` float(7,2) NOT NULL,
  `ganador` int(11) NOT NULL,
  `disponibilidaddesde` date NOT NULL,
  `disponibilidadhasta` date NOT NULL,
  `fechainicio` date NOT NULL,
  `semana` int(3) NOT NULL,
  `año` int(5) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `subasta`
--

INSERT INTO `subasta` (`numreserva`, `idresidencia`, `dni`, `preciobase`, `ganador`, `disponibilidaddesde`, `disponibilidadhasta`, `fechainicio`, `semana`, `año`, `estado`) VALUES
(3, 1, 11222333, 500.00, 0, '0000-00-00', '0000-00-00', '2019-02-02', 0, 0, 0),
(4, 3, 0, 501.00, 0, '0000-00-00', '0000-00-00', '2019-05-27', 0, 0, 0),
(5, 1, 0, 500.90, 0, '0000-00-00', '0000-00-00', '2019-05-15', 0, 0, 0),
(6, 4, 0, 300.44, 0, '0000-00-00', '0000-00-00', '0000-00-00', 0, 0, 1),
(7, 4, 0, 400.00, 0, '0000-00-00', '0000-00-00', '2019-05-23', 0, 0, 1),
(8, 1, 0, 1.11, 0, '0000-00-00', '0000-00-00', '2019-05-23', 0, 0, 0),
(9, 2, 0, 0.11, 0, '0000-00-00', '0000-00-00', '0000-00-00', 22, 2019, 1),
(10, 2, 0, 99.00, 0, '0000-00-00', '0000-00-00', '0000-00-00', 25, 2019, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `dni` int(11) NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT '1',
  `username` varchar(30) NOT NULL,
  `contraseña` varchar(10) NOT NULL,
  `cantReservas` int(1) NOT NULL DEFAULT '2',
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `mail` varchar(45) NOT NULL,
  `telefono` int(11) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `inicioContrato` date NOT NULL,
  `finContrato` date NOT NULL,
  `numTarjeta` int(11) NOT NULL,
  `vencimientoTarjeta` varchar(5) NOT NULL,
  `codSegTarjeta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`dni`, `tipo`, `username`, `contraseña`, `cantReservas`, `nombre`, `apellido`, `mail`, `telefono`, `direccion`, `inicioContrato`, `finContrato`, `numTarjeta`, `vencimientoTarjeta`, `codSegTarjeta`) VALUES
(28875123, 0, '', 'contraseña', 2, 'tomas', 'orejuela', 'unmail@gmail.com', 2147483647, 'calle 8 223', '0000-00-00', '0000-00-00', 2147483647, '0000-', 123),
(39089112, 1, 'macarena.sanchez', 'contraseña', 2, 'macarena', 'sanchez', 'unmail@gmail.com', 2147483647, 'calle 13 298', '0000-00-00', '0000-00-00', 2147483647, '12/29', 978);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `directa`
--
ALTER TABLE `directa`
  ADD PRIMARY KEY (`numreserva`);

--
-- Indices de la tabla `hotsale`
--
ALTER TABLE `hotsale`
  ADD PRIMARY KEY (`numreserva`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`idpago`);

--
-- Indices de la tabla `reservasconcretadas`
--
ALTER TABLE `reservasconcretadas`
  ADD PRIMARY KEY (`identificador`);

--
-- Indices de la tabla `residencia`
--
ALTER TABLE `residencia`
  ADD PRIMARY KEY (`idresidencia`);

--
-- Indices de la tabla `subasta`
--
ALTER TABLE `subasta`
  ADD PRIMARY KEY (`numreserva`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`dni`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `reservasconcretadas`
--
ALTER TABLE `reservasconcretadas`
  MODIFY `identificador` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
