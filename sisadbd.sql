-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-09-2024 a las 08:46:39
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
-- Base de datos: `sisadbd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `id_area` int(11) NOT NULL,
  `descripcion_area` varchar(300) NOT NULL,
  `estado_area` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id_area`, `descripcion_area`, `estado_area`) VALUES
(2, 'Informática', 1),
(3, 'Primer Juzgado de Investigación Preparatoria de Maynas', 1),
(4, 'Segundo Juzgado de Investigación Preparatoria de Maynas', 1),
(5, '3JIP', 1),
(6, '4JIP', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bien`
--

CREATE TABLE `bien` (
  `id_bien` int(11) NOT NULL,
  `equipo_bien` varchar(50) NOT NULL,
  `marca_bien` varchar(50) NOT NULL,
  `modelo_bien` varchar(50) NOT NULL,
  `procesador_bien` varchar(200) NOT NULL,
  `numdeserie_bien` varchar(50) NOT NULL,
  `numcontropatri_bien` varchar(50) NOT NULL,
  `estado_bien` varchar(20) NOT NULL,
  `añodeadqs_bien` varchar(4) NOT NULL,
  `numdeordendecom_bien` varchar(50) NOT NULL,
  `observacion_bien` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bien`
--

INSERT INTO `bien` (`id_bien`, `equipo_bien`, `marca_bien`, `modelo_bien`, `procesador_bien`, `numdeserie_bien`, `numcontropatri_bien`, `estado_bien`, `añodeadqs_bien`, `numdeordendecom_bien`, `observacion_bien`) VALUES
(1, 'Teclado', 'Logitec', 'XXX', '--', '', '', '1', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencia`
--

CREATE TABLE `dependencia` (
  `id_dependencia` int(11) NOT NULL,
  `descripcion_dependencia` varchar(300) NOT NULL,
  `estado_dependencia` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dependencia`
--

INSERT INTO `dependencia` (`id_dependencia`, `descripcion_dependencia`, `estado_dependencia`) VALUES
(1, 'Módulo Panal Central', 1),
(2, 'Patrominio', 1),
(3, 'Nauta', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallemovimiento`
--

CREATE TABLE `detallemovimiento` (
  `id_detallemovimiento` int(11) NOT NULL,
  `id_bien_detmov` int(11) NOT NULL,
  `id_mov_detallemovimiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `descripcion_menu` varchar(300) NOT NULL,
  `estado_menu` int(1) NOT NULL,
  `nombrearchivo_menu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id_menu`, `descripcion_menu`, `estado_menu`, `nombrearchivo_menu`) VALUES
(1, 'Registrar Movimiento', 1, ''),
(2, 'Ver Movimentos', 1, ''),
(3, 'Mantenimiento', 1, ''),
(4, 'Registrar', 1, ''),
(5, 'Ver registros actuales', 1, ''),
(6, 'Crear usuario', 1, '--');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
--

CREATE TABLE `movimiento` (
  `id_movimiento` int(11) NOT NULL,
  `id_transferente_movimiento` int(11) NOT NULL,
  `id_receptor_movimiento` int(11) NOT NULL,
  `id_dependencia_transferente_movimiento` int(11) NOT NULL,
  `id_dependencia_receptor_movimiento` int(11) NOT NULL,
  `id_area_transferente_movimiento` int(11) NOT NULL,
  `id_area_receptor_movimiento` int(11) NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `archivo_movimiento` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id_persona` int(11) NOT NULL,
  `nomyap_persona` varchar(100) NOT NULL,
  `dni_persona` varchar(8) NOT NULL,
  `cell_persona` varchar(9) NOT NULL,
  `correo_persona` varchar(50) NOT NULL,
  `dir_persona` varchar(150) NOT NULL,
  `estado_persona` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `nomyap_persona`, `dni_persona`, `cell_persona`, `correo_persona`, `dir_persona`, `estado_persona`) VALUES
(1, 'JACK MAITAHUARI VASQUEZ ', '775362', '925944693', 'JVAZQUEZFABABA20@GMAIL.COM', 'CALLE SARAGOZA 260', 1),
(2, 'LUIS FERNANDO ROMERO AMASIFUEN ', '72198165', '917669478', 'luisromeroamasifuen@gmail.com', 'JOSE GALVEZ #1041', 1),
(3, 'Crionni wong', '45071102', '987654132', '--', '--', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `id_persona_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `clave_usuario` varchar(50) NOT NULL,
  `estado_usuario` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `id_persona_usuario`, `nombre_usuario`, `clave_usuario`, `estado_usuario`) VALUES
(1, 2, 'lromero', 'e10adc3949ba59abbe56e057f20f883e', 1),
(17, 3, 'cwong', '202cb962ac59075b964b07152d234b70', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_area`);

--
-- Indices de la tabla `bien`
--
ALTER TABLE `bien`
  ADD PRIMARY KEY (`id_bien`);

--
-- Indices de la tabla `dependencia`
--
ALTER TABLE `dependencia`
  ADD PRIMARY KEY (`id_dependencia`);

--
-- Indices de la tabla `detallemovimiento`
--
ALTER TABLE `detallemovimiento`
  ADD PRIMARY KEY (`id_detallemovimiento`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD PRIMARY KEY (`id_movimiento`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `bien`
--
ALTER TABLE `bien`
  MODIFY `id_bien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `dependencia`
--
ALTER TABLE `dependencia`
  MODIFY `id_dependencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detallemovimiento`
--
ALTER TABLE `detallemovimiento`
  MODIFY `id_detallemovimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
