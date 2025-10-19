-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-09-2025 a las 08:09:56
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

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
  `organo` varchar(50) NOT NULL,
  `especialidad` varchar(50) NOT NULL,
  `estado_area` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id_area`, `descripcion_area`, `organo`, `especialidad`, `estado_area`) VALUES
(2, 'Infórmatica Ncpp', 'administrativo', 'penal\n', 1),
(3, 'Especialista De Audiencia', 'juridiccional', 'penal', 1),
(4, 'Primera Sala Penal De Apelaciones', 'juridiccional', 'penal', 1),
(5, 'Tercer Juzgado De Investigación Preparatoria', 'juridiccional', 'penal', 1),
(6, 'Segunda Sala Penal De Apelaciones', 'juridiccional', 'penal', 1),
(13, 'Juzgado Unipersonal', 'juridiccional', 'penal', 1),
(14, 'Juzgado De Investigación Preparatoria', 'juridiccional', 'penal', 1),
(16, 'Primer Juzgado Penal Unipersonal Supraprovincial Transitorio', 'juridiccional', 'penal', 1),
(17, 'Tercer Juzgado De Investigación Preparatoria', 'juridiccional', 'penal', 1),
(18, 'Primer Juzgado Penal Unipersonal Supraprovincial Transitorio', 'juridiccional', 'penal', 1),
(19, 'Quinto Juzgado De Investigación Preparatoria', 'juridiccional', 'penal', 1),
(20, 'Administración', 'administrativo', 'penal', 1),
(21, 'Primer Juzgado Unipersonal Transitorio', 'juridiccional', 'penal', 1),
(22, 'Segundo Juzgado De Investigación Preparatoria', 'juridiccional', 'penal', 1),
(23, 'Cuarto Juzgado De Investigación Preparatoria', 'juridiccional', 'penal', 1),
(24, 'Juzgado De Investigación Preparatoria Transitorio', 'juridiccional', 'penal', 1),
(25, 'Segundo Juzgado Unipersonal', 'juridiccional', 'penal', 1),
(26, 'Extinción De Dominio', 'juridiccional', 'penal', 1),
(27, 'Juzgado De Nauta', 'juridiccional', 'penal', 1),
(28, 'Primer Juzgado Unipersonal', 'juridiccional', 'penal', 1),
(29, 'Segundo Juzgado Unipersonal Transitorio', 'juridiccional', 'penal', 1),
(30, 'Tercer Juzgado Unipersonal', 'juridiccional', 'penal', 1),
(31, 'Primer Juzgado De Investigación Preparatoria', 'juridiccional', 'penal', 1),
(33, 'Juzgado Penal Colegiado Supraprovincial Transitorio', 'juridiccional', 'penal', 1),
(34, 'Camara Gesell', 'juridiccional', 'penal', 1),
(35, 'Custodia De Expedientes', 'administrativo', 'penal', 1),
(36, 'Segunda Sala Penal De Apelaciones En Adición Liquidadora', 'juridiccional', 'penal', 1),
(37, 'Establecimiento Penitenciario Penal De Varones', 'juridiccional', 'penal', 1),
(38, 'Mesa De Parte', 'administrativo\n', 'penal', 1),
(39, 'JUZGADO DE INVESTIGACIÓN TRANSITORIO', 'juridiccional', 'penal', 1),
(49, 'Prueba Area', 'administrativo', 'Penal', 1),
(50, 'area_new_diseno_2', 'administrativo', 'Penals', 1),
(51, 'nuevo diseño', 'administrativo', 'penal', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bien`
--

CREATE TABLE `bien` (
  `id_bien` int(11) NOT NULL,
  `equipo_bien` int(11) NOT NULL,
  `marca_bien` varchar(50) NOT NULL,
  `modelo_bien` varchar(50) NOT NULL,
  `procesador_bien` varchar(200) NOT NULL,
  `numdeserie_bien` varchar(50) NOT NULL,
  `numcontropatri_bien` varchar(50) NOT NULL,
  `estado_bien` varchar(20) NOT NULL,
  `añodeadqs_bien` varchar(4) NOT NULL,
  `numdeordendecom_bien` varchar(50) NOT NULL,
  `color_bien` varchar(100) NOT NULL,
  `observacion_bien` varchar(200) NOT NULL,
  `costo_bien` double NOT NULL,
  `funcionamiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bien`
--

INSERT INTO `bien` (`id_bien`, `equipo_bien`, `marca_bien`, `modelo_bien`, `procesador_bien`, `numdeserie_bien`, `numcontropatri_bien`, `estado_bien`, `añodeadqs_bien`, `numdeordendecom_bien`, `color_bien`, `observacion_bien`, `costo_bien`, `funcionamiento`) VALUES
(17, 4, 'LENOVO	', 'THINKPAD E15', 'Intel® Core™ i7 de 10ma Generación', 'PF28DZBC', '740805003302', '1', '2020', 'O/C-01054-2020', '', 'NINGUNA', 0, 0),
(18, 1, 'HP', 'PRODESK 600 G1 SFF', 'Intel(R) Core(TM) i5-4590 CPU @ 3.30GHz	', 'MXL5282S3K', '74089950AQ14', '2', '2015', '01720-2015', '', 'NUNGUNA', 0, 0),
(19, 3, 'GENIUS', 'KB-118', '--', 'UL2118302672', '740895500PNDT', '1', '2022', 'CAJA CHICA', '', 'CAJA CHICA', 0, 0),
(20, 2, 'TONG FANG', 'TDY-19E81N', '--', 'D170519ENGD4200318', '740880375766', '1', '2017', 'NEA-00013-2017', '', 'NINGUNA', 0, 0),
(21, 14, 'SONY', 'ICD-PX370', '--', '1011662', '952245651208', '1', '2020', 'O/C-01658-2020', '', 'NINGUNA', 0, 0),
(22, 12, 'CDP', 'R2CU-AVR 1008i', '--', '180620-1065252', '46225215X976', '1', '2019', 'O/C-01065-2019', '', 'NINGUNA', 0, 0),
(23, 12, 'CDP', 'R2C-AVR 1008I', '--', '190225-0903913 ', '46225215Y911', '1', '2019', 'O/C-01656-2020', '', 'NINGUNA', 0, 0),
(24, 17, 'AKG', 'K72', '--', 'MI4022-208209', '952210701553', '1', '2021', 'O/C-02073-2021', '', 'NINGUNA', 0, 0),
(25, 14, 'SONY', 'ICD-PX370', '--', '1011664', '952245651196', '1', '2020', 'O/C-01658-2020', '', 'NINGUNA', 0, 0),
(26, 12, 'CDP', 'R2C-AVR 1008i', '--', '200920-0902782', '46225215Y912', '1', '2022', 'O/C-01656-2020', '', 'NINGUNA', 0, 0),
(27, 1, 'DELL', 'OPTIPLEX 7020', 'Intel Core i7 14700', 'CX34X54', '74089950GR06', '1', '2024', '02406-2024', '', 'NINGUNA', 0, 0),
(28, 2, 'HP', 'HP E24 G5', '--', 'CN44171JRP', '74088187N375', '1', '2024', '02406-2024', '', 'NINGUNA', 0, 0),
(29, 3, 'DELL', 'KB216T1', '--', 'CN019M93LO30048101XDA04', '74089500IS74', '1', '2024', '02406-2024', '', 'NINGUNA', 0, 0),
(30, 1, 'DELL', 'OPTIPLEX 7020', 'Intel Core i7 14700', '5PGV564', '74089950GR08', '1', '2024', '02406-2024', '', 'NINGUNA', 0, 0),
(31, 2, 'HP', 'HP E24 G5', '--', 'CN44182KKJ', '74088187N378', '1', '2024', '02406-2024', '', 'NINGUNA', 0, 0),
(32, 3, 'DELL', 'KB216T1', '--', 'CN019M93LO30047D0DCTA04', '74089500IS76', '1', '2024', '02406-2024', '', 'NINGUNA', 0, 0),
(33, 1, 'DELL', 'OPTIPLEX 7020', 'Intel Core i7 14700', '5NSV564', '74089950GR05', '1', '2024', '02406-2024', '', 'NINGUNA', 0, 0),
(34, 2, 'HP', 'HP E24 G5', '--', 'CN44190KNZ', '74088187N376', '1', '2024', '02406-2024', '', 'NINGUNA', 0, 0),
(35, 3, 'DELL', 'KB216T1', '--', 'CN019M93LO30047D0DFDA04', '74089500IS75', '1', '2024', '02406-2024', '', 'NINGUNA', 0, 0),
(36, 1, 'DELL', 'OPTIPLEX 7020', 'Intel Core i7 14700', 'JTWV564', '74089950GR07', '1', '2024', '02406-2024', '', 'NINGUNA', 0, 0),
(37, 2, 'HP', 'HP E24 G5', '--', 'CN441933QB', '74088187N377', '1', '2024', '02406-2024', '', 'NINGUNA', 0, 0),
(38, 3, 'DELL', 'KB216T1', '--', 'CN019M93LO30048105KRA04', '74089500IS73', '1', '2024', '02406-2024', '', 'NINGUNA', 0, 0),
(39, 4, 'HP', 'PROBOOK 450 G10', ' Intel® Core™ i7 de 13.ª generación ', '1H84252FHL', '740805008181', '1', '2024', 'OC-02410-2024', '', 'NINGUNA', 0, 0),
(40, 4, 'HP', 'PROBOOK 450 G10', ' Intel® Core™ i7 de 13.ª generación ', '1H84252FGM', '740805008182', '1', '2024', 'OC-02410-2024', '', 'NINGUNA', 0, 0),
(41, 13, 'APC', 'SURT1000XLI', '--', 'AS1953190525', '462200505059', '1', '2019', 'CODIGO M 423087', '', '--', 0, 0),
(42, 4, 'THINKPAD', 'LENOVO', 'LENOVO', 'LENOVO', '740805003309', '1', '2020', 'O/S - 01054-2020', '', '--', 0, 1),
(43, 1, 'DELL', 'OPTIPLEX SFF PLUS 7010', '13th Gen Intel(R) Core(TM) i7-13700   2.10 GHz', 'DGX6704', '74089950GJ41', '1', '2023', '2216-2023- C', '', 'NINGUNA', 0, 0),
(44, 2, 'DELL', 'E2424HS', '--', 'CN03GM7VFCC0039MCJ3XA00', '74088187M836', '1', '2023', '2216-2023- C', '', 'NINGUNA', 0, 0),
(45, 3, 'DELL', 'KB216', '--', 'CN019M93LO30036007CNA04', '74089500IL39', '1', '2023', '2216-2023- C', '', 'NINGUNA', 0, 0),
(46, 1, 'DELL', 'OPTIPLEX SFF PLUS 7010', '13th Gen Intel(R) Core(TM) i7-13700   2.10 GHz', '3DK6704', '74089950GJ12', '1', '2023', '2216-2023- C', '', 'NINGUNA', 0, 0),
(47, 2, 'DELL', 'E2424HS', '--', 'CN03GM7VFCC0039MAMHXA00', '74088187M919', '1', '2023', '2216-2023- C', '', 'NINGUNA', 0, 0),
(48, 3, 'DELL', 'KB216', '--', 'CN019M93LO30038S15WCA04', '74089500IK44', '1', '2023', '2216-2023- C', 'NEGRO-GRIS', 'NINGUNA', 50, 1),
(49, 1, 'DELL', 'OPTIPLEX SFF PLUS 7010', '13th Gen Intel(R) Core(TM) i7-13700   2.10 GHz', 'FGN6704', '74089950GJ06', '1', '2023', '2216-2023- C', '', 'NINGUNA', 0, 0),
(50, 2, 'DELL', 'E2424HS', '--', 'CN03GM7VFCC0039MA83XA00', '74088187M409', '1', '2023', '2216-2023- C', '', 'NINGUNA', 0, 0),
(51, 3, 'DELL', 'KB216', '--', 'CN019M93LO30038S152QA04', '74089500IN81', '1', '2023', '2216-2023- C', '', 'NINGUNA', 0, 0),
(52, 1, 'HP', 'PRODESK 600G1 SFF', 'Intel(R) Core(TM) i5-4590 CPU @ 3.30GHz', 'MXL5282S43', '74089950AQ54', '2', '2015', '01720-2015', '', 'NINGUNA', 0, 0),
(53, 2, 'HP', 'HSTND-392-F', '--', '3CQ4503LLG', '740880371297', '2', '2015', '01720-2015', '', 'NINGUNA', 0, 0),
(54, 3, 'LOGITECH', 'K10- YU0042', '--', '2313MR109178', 'S/C', '1', '2022', 'S/O', '', 'NINGUNA', 0, 0),
(55, 1, 'DELL', 'OPTIPLEX 9020', 'Intel(R) Core(TM) i5-4670 CPU @ 3.40GHz', '7GYF8Z1', '74089950Y387', '1', '2013', '1975-2013GG', '', 'NINGUNA', 0, 0),
(56, 2, 'HP', 'LV1911', '--', '6CM228227L', '74088187F287', '1', '2012', '1277-2012GG', '', 'NINGUNA', 0, 0),
(57, 3, 'GENIUS', 'KB-118', '--', 'UL2118300179', '--', '3', '2013', '1975-2013GG', '', 'COMPRADO POR CAJA CHICA', 0, 0),
(58, 1, 'TSINGHUA TONFANG', 'G700', 'Intel(R) Core(TM) i7-6700 CPU @ 3.40GHz', '2170511000308005740', '74089950CQ18', '1', '2017', 'NEA-00013-2017', '', 'NINGUNA', 0, 0),
(59, 2, 'HP', 'LV1911', '--', '6CM2282221', '74088187F334', '1', '2012', '1277-2012GG', '', 'NINGUNA', 0, 0),
(60, 3, 'MTG', 'AKB644', '--', '202012000726', '--', '1', '2024', '--', '', 'CAJA CHICA', 0, 0),
(61, 5, 'KYOCERA', 'TASKALFA 55011', '--', 'LAK5601996', '742227260040', '2', '2015', '02868-2015', '', 'ESTA PARA REPARACION', 0, 0),
(62, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9BR', '74089950HG11', '1', '2024', 'BID 000429', '', 'COMPRADO POR EL BID', 0, 0),
(63, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGLB', '74088037E738', '1', '2024', 'BID 005442', '', 'COMPRADO POR EL BID ', 0, 0),
(64, 3, 'LENOVO', 'SK-8827', '--', '46XD3VP', '74089500JH70', '1', '2024', 'BID 000431', '', 'COMPRADO POR EL BID', 0, 0),
(65, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AA', '74089950HG02', '1', '2024', 'BID 000411', '', 'COMPRADO POR EL BID', 0, 0),
(66, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00KGFK', '74089950HF90', '1', '2024', 'BID 001435', '', 'COMPRADO POR EL BID', 0, 0),
(67, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00KJLN', '74089950HF86', '1', '2024', 'BID 001417', '', 'COMPRADO POR EL BID', 0, 0),
(68, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AS', '74089950HF99', '1', '2024', 'BID 000405', '', 'COMPRADO POR EL BID', 0, 0),
(69, 3, 'LENOVO', 'SK-8827', '--', '46XD3VP', '74089500JH61', '1', '2024', 'BID 000412', '', 'COMPRADO POR EL BID', 0, 0),
(70, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9BP', '74089950HG05', '1', '2024', 'BID 000417', '', 'COMPRADO POR EL BID', 0, 0),
(71, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AJ', '74089950HG08', '1', '2024', 'BID 000423', '', 'COMPRADO POR EL BID', 0, 0),
(72, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMV', '74088037E729', '1', '2024', 'BID 005424', '', 'COMPRADO POR EL BID ', 0, 0),
(73, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9A5', '74089950HG00', '1', '2024', 'BID 000407', '', 'COMPRADO POR EL BID', 0, 0),
(74, 3, 'LENOVO', 'SK-8827', '--', '46XD187', '74089500JH84', '1', '2024', 'BID 001436', '', 'COMPRADO POR EL BID', 0, 0),
(75, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AP', '74089950HG04', '1', '2024', 'BID 000415', '', 'COMPRADO POR EL BID', 0, 0),
(76, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AL', '74089950HF98', '1', '2024', 'BID 000403', '', 'COMPRADO POR EL BID', 0, 0),
(77, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGLG', '74088037E752', '1', '2024', 'BID 005461', '', 'COMPRADO POR EL BID ', 0, 0),
(78, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K995', '74089950HG07', '1', '2024', 'BID 000421', '', 'COMPRADO POR EL BID', 0, 0),
(79, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AY', '74089950HF84', '1', '2024', 'BID 000445', '', 'COMPRADO POR EL BID', 0, 0),
(80, 3, 'LENOVO', 'SK-8827', '--', '46XD5GA', '74089500JH80', '1', '2024', 'BID 001418', '', 'COMPRADO POR EL BID', 0, 0),
(81, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGL8', '74088037E748', '1', '2024', 'BID 005457', '', 'COMPRADO POR EL BID ', 0, 0),
(82, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00KJ07', '74089950HF92', '1', '2024', 'BID 000391', '', 'COMPRADO POR EL BID', 0, 0),
(83, 3, 'LENOVO', 'SK-8827', '--', '46XD3VH', '74089500JH52', '1', '2024', 'BID 000406', '', 'COMPRADO POR EL BID', 0, 0),
(84, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGP4', '74088037E726', '1', '2024', 'BID 005414', '', 'COMPRADO POR EL BID ', 0, 0),
(85, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00KGTG', '74089950HF89', '1', '2024', 'BID 001431', '', 'COMPRADO POR EL BID', 0, 0),
(86, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00KGGR', '74089950H91', '1', '2024', 'BID 001437', '', 'COMPRADO POR EL BID', 0, 0),
(87, 3, 'LENOVO', 'SK-8827', '--', '46XD3VN', '74089500JH64', '1', '2024', 'BID 000418', '', 'COMPRADO POR EL BID', 0, 0),
(88, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9A0', '74089950HG10', '1', '2024', 'BID 000427', '', 'COMPRADO POR EL BID', 0, 0),
(89, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00KGTC', '74089950HF88', '1', '2024', 'BID 001427', '', 'COMPRADO POR EL BID', 0, 0),
(90, 3, 'LENOVO', 'SK-8827', '--', '46XD3VF', '74089500JH67', '1', '2024', 'BID 000424', '', 'COMPRADO POR EL BID', 0, 0),
(91, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGNR', '74088037E732', '1', '2024', 'BID 005434', '', 'COMPRADO POR EL BID ', 0, 0),
(92, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9A7', '74089950HF93', '1', '2024', 'BID 000393', '', 'COMPRADO POR EL BID', 0, 0),
(93, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGL4', '74088037E735', '1', '2024', 'BID 005437', '', 'COMPRADO POR EL BID ', 0, 0),
(94, 3, 'LENOVO', 'SK-8827', '--', '46XD3WX', '74089500JH59', '1', '2024', 'BID 000408', '', 'COMPRADO POR EL BID', 0, 0),
(95, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AR', '74089950HF83', '1', '2024', 'BID 000443', '', 'COMPRADO POR EL BID', 0, 0),
(96, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9A3', '74089950HF97', '1', '2024', 'BID 000401', '', 'COMPRADO POR EL BID', 0, 0),
(97, 3, 'LENOVO', 'SK-8827', '--', '46XD53E', '74089500JH63', '1', '2024', 'BID 000416', '', 'COMPRADO POR EL BID', 0, 0),
(98, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGNZ', '74088037E727', '1', '2024', 'BID 005416', '', 'COMPRADO POR EL BID ', 0, 0),
(99, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AZ', '74089950HF94', '1', '2024', 'BID 000395', '', 'COMPRADO POR EL BID', 0, 0),
(100, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K99P', '74089950HF85', '1', '2024', 'BID 000447', '', 'COMPRADO POR EL BID', 0, 0),
(101, 3, 'LENOVO', 'SK-8827', '--', '46XD3VJ', '74089500JH51', '1', '2024', 'BID 000404', '', 'COMPRADO POR EL BID', 0, 0),
(102, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGN8', '74088037E731', '1', '2024', 'BID 005427', '', 'COMPRADO POR EL BID ', 0, 0),
(103, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K999', '74089950HG01', '1', '2024', 'BID 000409', '', 'COMPRADO POR EL BID', 0, 0),
(104, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K99S', '74089950HG14', '1', '2024', 'BID 000435', '', 'COMPRADO POR EL BID', 0, 0),
(105, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGNV', '74088037E725', '1', '2024', 'BID 005413', '', 'COMPRADO POR EL BID ', 0, 0),
(106, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AQ', '74089950HG09', '1', '2024', 'BID 000425', '', 'COMPRADO POR EL BID', 0, 0),
(107, 3, 'LENOVO', 'SK-8827', '--', '46XD3W6', '74089500JH66', '1', '2024', 'BID 000422', '', 'COMPRADO POR EL BID', 0, 0),
(108, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGML', '74088037E734', '1', '2024', 'BID 005436', '', 'COMPRADO POR EL BID ', 0, 0),
(109, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGLC', '74088037E746', '1', '2024', 'BID 005454', '', 'COMPRADO POR EL BID ', 0, 0),
(110, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K99C', '74089950HG12', '1', '2024', 'BID 000431', '', 'COMPRADO POR EL BID', 0, 0),
(111, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9B1', '74089950HG16', '1', '2024', 'BID 000439', '', 'COMPRADO POR EL BID', 0, 0),
(112, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGK7', '74088037E719', '1', '2024', 'BID 005391', '', 'COMPRADO POR EL BID ', 0, 0),
(113, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AB', '74089950HG17', '1', '2024', 'BID 000441', '', 'COMPRADO POR EL BID', 0, 0),
(114, 3, 'LENOVO', 'SK-8827', '--', '46XD3VL', '74089500JH78', '1', '2024', 'BID 000446', '', 'COMPRADO POR EL BID', 0, 0),
(115, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGN0', '74088037E751', '1', '2024', 'BID 005460', '', 'COMPRADO POR EL BID ', 0, 0),
(116, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AF', '74089950HF95', '1', '2024', 'BID 000397', '', 'COMPRADO POR EL BID', 0, 0),
(117, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGLF', '74088037E753', '1', '2024', 'BID 005462', '', 'COMPRADO POR EL BID ', 0, 0),
(118, 3, 'LENOVO', 'SK-8827', '--', '46XD1F3', '74089500JH45', '1', '2024', 'BID 000392', '', 'COMPRADO POR EL BID', 0, 0),
(119, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9A2', '74089950HF96', '1', '2024', 'BID 000399', '', 'COMPRADO POR EL BID', 0, 0),
(120, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMP', '74088037E737', '1', '2024', 'BID 005440', '', 'COMPRADO POR EL BID ', 0, 0),
(121, 3, 'LENOVO', 'SK-8827', '--', '46XD5Z6', '74089500JH83', '1', '2024', 'BID 001432', '', 'COMPRADO POR EL BID', 0, 0),
(122, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K99X', '74089950HG13', '1', '2024', 'BID 000433', '', 'COMPRADO POR EL BID', 0, 0),
(123, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGNN', '74088037E750', '1', '2024', 'BID 005459', '', 'COMPRADO POR EL BID ', 0, 0),
(124, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AK', '74089950HG03', '1', '2024', 'BID 000413', '', 'COMPRADO POR EL BID', 0, 0),
(125, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGN4', '74088037E720', '1', '2024', 'BID 005393', '', 'COMPRADO POR EL BID ', 0, 0),
(126, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AX', '74089950HG15', '1', '2024', 'BID 000437', '', 'COMPRADO POR EL BID', 0, 0),
(127, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGM8', '74088037E745', '1', '2024', 'BID 005451', '', 'COMPRADO POR EL BID ', 0, 0),
(128, 3, 'LENOVO', 'SK-8827', '--', '46XD4G9', '74089500JH85', '1', '2024', 'BID 001438', '', 'COMPRADO POR EL BID', 0, 0),
(129, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00KJJS', '74089950HF87', '1', '2024', 'BID 001425', '', 'COMPRADO POR EL BID', 0, 0),
(130, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGP9', '74088037E724', '1', '2024', 'BID 005404', '', 'COMPRADO POR EL BID ', 0, 0),
(131, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMF', '74088037E721', '1', '2024', 'BID 005399', '', 'COMPRADO POR EL BID ', 0, 0),
(132, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMH', '74088037E747', '1', '2024', 'BID 005455', '', 'COMPRADO POR EL BID ', 0, 0),
(133, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K98X', '74089950HG06', '1', '2024', 'BID 000419', '', 'COMPRADO POR EL BID', 0, 0),
(134, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGM7', '74088037E728', '1', '2024', 'BID 005417', '', 'COMPRADO POR EL BID ', 0, 0),
(135, 3, 'LENOVO', 'SK-8827', '--', '46XD3WT', '74089500JH69', '1', '2024', 'BID 000428', '', 'COMPRADO POR EL BID', 0, 0),
(136, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGM9', '74088037E741', '1', '2024', 'BID 005447', '', 'COMPRADO POR EL BID ', 0, 0),
(137, 3, 'LENOVO', 'SK-8827', '--', '46XD5Z1', '74089500JH82', '1', '2024', 'BID 001428', '', 'COMPRADO POR EL BID', 0, 0),
(138, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGK2', '74088037E736', '1', '2024', 'BID 005438', '', 'COMPRADO POR EL BID ', 0, 0),
(139, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGN3', '74088037E739', '1', '2024', 'BID 005445', '', 'COMPRADO POR EL BID ', 0, 0),
(140, 3, 'LENOVO', 'SK-8827', '--', '46XD3WW', '74089500JH46', '1', '2024', 'BID 000394', '', 'COMPRADO POR EL BID', 0, 0),
(141, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMB', '74088037E743', '1', '2024', 'BID 005449', '', 'COMPRADO POR EL BID ', 0, 0),
(142, 3, 'LENOVO', 'SK-8827', '--', '46XD3VM', '74089500JH77', '1', '2024', 'BID 000444', '', 'COMPRADO POR EL BID', 0, 0),
(143, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGM5', '74088037E744', '1', '2024', 'BID 005450', '', 'COMPRADO POR EL BID ', 0, 0),
(144, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGN7', '74088037E722', '1', '2024', 'BID 005401', '', 'COMPRADO POR EL BID ', 0, 0),
(145, 3, 'LENOVO', 'SK-8827', '--', '46XD53F', '74089500JH50', '1', '2024', 'BID 000402', '', 'COMPRADO POR EL BID', 0, 0),
(146, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGNX', '74088037E723', '1', '2024', 'BID 005403', '', 'COMPRADO POR EL BID ', 0, 0),
(147, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMA', '74088037E740', '1', '2024', 'BID 005446', '', 'COMPRADO POR EL BID ', 0, 0),
(148, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGLR', '74088037E730', '1', '2024', 'BID 005426', '', 'COMPRADO POR EL BID ', 0, 0),
(149, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMC', '74088037E742', '1', '2024', 'BID 005448', '', 'COMPRADO POR EL BID ', 0, 0),
(150, 3, 'LENOVO', 'SK-8827', '--', '46XD3WS', '74089500JH47', '1', '2024', 'BID 000396', '', 'COMPRADO POR EL BID', 0, 0),
(151, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMR', '74088037E749', '1', '2024', 'BID 005458', '', 'COMPRADO POR EL BID ', 0, 0),
(152, 2, 'LENOVO', 'MODIFICADO MODELO', 'MODIFCADO PROCESADOR', 'MODIFICADO NS', '74088037E733', '1', '2024', 'BID 005435', '', 'COMPRADO POR EL BID ', 25, 1),
(153, 3, 'LENOVO', 'SK-8827', '--', '46XD3WC', '74089500JH79', '1', '2024', 'BID 000448', '', 'COMPRADO POR EL BID', 0, 0),
(154, 3, 'LENOVO', 'SK-8827', '--', '46XD3W9', '74089500JH60', '1', '2024', 'BID 000410', '', 'COMPRADO POR EL BID', 0, 0),
(155, 3, 'LENOVO', 'SK-8827', '--', '46XD3WB', '74089500JH73', '1', '2024', 'BID 000436', '', 'COMPRADO POR EL BID', 0, 0),
(156, 3, 'LENOVO', 'SK-8827', '--', '46XD3VG', '74089500JH68', '1', '2024', 'BID 000426', '', 'COMPRADO POR EL BID', 0, 0),
(157, 3, 'LENOVO', 'SK-8827', '--', '46XD3VK', '74089500JH71', '1', '2024', 'BID 000432', '', 'COMPRADO POR EL BID', 0, 0),
(158, 3, 'LENOVO', 'SK-8827', '--', '46XD3WR', '74089500JH75', '1', '2024', 'BID 000440', '', 'COMPRADO POR EL BID', 0, 0),
(159, 3, 'LENOVO', 'SK-8827', '--', '46XD3WV', '74089500JH76', '1', '2024', 'BID 000442', '', 'COMPRADO POR EL BID', 0, 0),
(160, 3, 'LENOVO', 'SK-8827', '--', '46XD53G', '74089500JH48', '1', '2024', 'BID 000398', '', 'COMPRADO POR EL BID', 0, 0),
(161, 3, 'LENOVO', 'SK-8827', '--', '46XD53H', '74089500JH49', '1', '2024', 'BID 000400', '', 'COMPRADO POR EL BID', 0, 0),
(162, 3, 'LENOVO', 'SK-8827', '--', '46XD3WA', '74089500JH72', '1', '2024', 'BID 000434', '', 'COMPRADO POR EL BID', 0, 0),
(163, 3, 'LENOVO', 'SK-8827', '--', '46XD3VR', '74089500JH62', '1', '2024', 'BID 000414', '', 'COMPRADO POR EL BID', 0, 0),
(164, 3, 'LENOVO', 'SK-8827', '--', '46XD3WP', '74089500JH74', '1', '2024', 'BID 000438', '', 'COMPRADO POR EL BID', 0, 0),
(165, 3, 'LENOVO', 'SK-8827', '--', '46XD4GB', '74089500JH81', '1', '2024', 'BID 001426', '', 'COMPRADO POR EL BID', 0, 0),
(166, 3, 'LENOVO', 'SK-8827', '--', '46XD3W7', '74089500JH65', '1', '2024', 'BID 000420', '', 'COMPRADO POR EL BID', 0, 0),
(167, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922362', '1', '2025', 'NEA-00233-2025', '', 'BID 7266', 0, 0),
(168, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922391', '1', '2025', 'NEA-00233-2025', '', 'BID9317', 0, 0),
(169, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922361', '1', '2025', 'NEA-00233-2025', '', 'BID 7262', 0, 0),
(170, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922360', '1', '2025', 'NEA-00233-2025', '', 'BID 7271', 0, 0),
(171, 12, 'FORZA', 'FVR 1012', '--', '91432408516085', '46225215BE81', '1', '2025', 'NEA-00233-2025', '', 'BID 8390', 0, 0),
(172, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922388', '1', '2025', 'NEA-00233-2025', '', 'BID 7291', 0, 0),
(173, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922387', '1', '2025', 'NEA-00233-2025', '', 'BID 7256', 0, 0),
(174, 12, 'FORZA', 'FVR 1012', '--', '91432408515656', '46225215BE65', '1', '2025', 'NEA-00233-2025', '', 'BID 8231', 0, 0),
(175, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922385', '1', '2025', 'NEA-00233-2025', '', 'BID 7292', 0, 0),
(176, 12, 'FORZA', 'FVR 1012', '--', '91432408515659 ', '46225215BE86', '1', '2025', 'NEA-00233-2025', '', 'BID 8216', 0, 0),
(177, 12, 'FORZA', 'FVR 1012', '--', '91432408515654', '46225215BE58', '1', '2025', 'NEA-00233-2025', '', 'BID 8225', 0, 0),
(178, 12, 'FORZA', 'FVR 1012', '--', '91432408516092', '46225215BE78', '1', '2025', 'NEA-00233-2025', '', 'BID 8387', 0, 0),
(179, 12, 'FORZA', 'FVR 1012', '--', '91432408516087 ', '46225215BE75', '1', '2025', 'NEA-00233-2025', '', 'BID 8384', 0, 0),
(180, 12, 'FORZA', 'FVR 1012', '--', '91432408515646', '46225215BE91', '1', '2025', 'NEA-00233-2025', '', 'BID 8222', 0, 0),
(181, 12, 'FORZA', 'FVR 1012', '--', '91432408515648', '46225215BE87', '1', '2025', 'NEA-00233-2025', '', 'BID 8217', 0, 0),
(182, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922384', '1', '2025', 'NEA-00233-2025', '', 'BID 7270', 0, 0),
(183, 12, 'FORZA', 'FVR 1012', '--', '91432408516081', '46225215BE70', '1', '2025', 'NEA-00233-2025', '', 'BID 8379', 0, 0),
(184, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922383', '1', '2025', 'NEA-00233-2025', '', 'BID 9307', 0, 0),
(185, 12, 'FORZA', 'FVR 1012', '--', '91432408516079', '46225215BE82', '1', '2025', 'NEA-00233-2025', '', 'BID 8391', 0, 0),
(186, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922382', '1', '2025', 'NEA-00233-2025', '', 'BID 7259', 0, 0),
(187, 12, 'FORZA', 'FVR 1012', '--', '91432408516086', '46225215BE80', '1', '2025', 'NEA-00233-2025', '', 'BID 8389', 0, 0),
(188, 12, 'FORZA', 'FVR 1012', '--', '91432408516075', '46225215BE67', '1', '2025', 'NEA-00233-2025', '', 'BID 8376', 0, 0),
(189, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922381', '1', '2025', 'NEA-00233-2025', '', 'BID 9292', 0, 0),
(190, 12, 'FORZA', 'FVR 1012', '--', '91432408516090 ', '46225215BE77', '1', '2025', 'NEA-00233-2025', '', 'BID 8386', 0, 0),
(191, 12, 'FORZA', 'FVR 1012', '--', '91432408515647', '46225215BE89', '1', '2025', 'NEA-00233-2025', '', 'BID 8219', 0, 0),
(192, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922380', '1', '2025', 'NEA-00233-2025', '', 'BID 7267', 0, 0),
(193, 12, 'FORZA', 'FVR 1012', '--', '91432408515649 ', '46225215BE60', '1', '2025', 'NEA-00233-2025', '', 'BID 8226', 0, 0),
(194, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922379', '1', '2025', 'NEA-00233-2025', '', 'BID 7290', 0, 0),
(195, 12, 'FORZA', 'FVR 1012', '--', '91432408515660 ', '46225215BE92', '1', '2025', 'NEA-00233-2025', '', 'BID 8223', 0, 0),
(196, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922378', '1', '2025', 'NEA-00233-2025', '', 'BID 7265', 0, 0),
(197, 12, 'FORZA', 'FVR 1012', '--', '91432408515645', '46225215BE90', '1', '2025', 'NEA-00233-2025', '', 'BID 8221', 0, 0),
(199, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922377', '1', '2025', 'NEA-00233-2025', '', 'BID 9285', 0, 0),
(200, 12, 'FORZA', 'FVR 1012', '--', '91432408515658', '46225215BE88', '1', '2025', 'NEA-00233-2025', '', 'BID 8218', 0, 0),
(201, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922376', '1', '2025', 'NEA-00233-2025', '', 'BID 9287', 0, 0),
(202, 12, 'FORZA', 'FVR 1012', '--', '91432408515643 ', '46225215BE61', '1', '2025', 'NEA-00233-2025', '', 'BID 8227', 0, 0),
(204, 12, 'FORZA', 'FVR 1012', '--', '91432408516082', '46225215BE71', '1', '2025', 'NEA-00233-2025', '', 'BID 8380', 0, 0),
(205, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922375', '1', '2025', 'NEA-00233-2025', '', 'BID 9286', 0, 0),
(206, 12, 'FORZA', 'FVR 1012', '--', '91432408516078', '46225215BE84', '1', '2025', 'NEA-00233-2025', '', 'BID 8393', 0, 0),
(207, 12, 'FORZA', 'FVR 1012', '--', '91432408516080', '46225215BE69', '1', '2025', 'NEA-00233-2025', '', 'BID 8378', 0, 0),
(208, 12, 'FORZA', 'FVR 1012', '--', '91432408515651', '46225215BE62', '1', '2025', 'NEA-00233-2025', '', 'BID 8228', 0, 0),
(209, 12, 'FORZA', 'FVR 1012', '--', '91432408516076', '46225215BE68', '1', '2025', 'NEA-00233-2025', '', 'BID 8377', 0, 0),
(210, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922374', '1', '2025', 'NEA-00233-2025', '', 'BID 9290', 0, 0),
(211, 12, 'FORZA', 'FVR 1012', '--', '91432408516084', '46225215BE83', '1', '2025', 'NEA-00233-2025', '', 'BID 8392', 0, 0),
(212, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922386', '1', '2025', 'NEA-00233-2025', '', 'BID 9289', 0, 0),
(213, 12, 'FORZA', 'FVR 1012', '--', '91432408516091', '46225215BE79', '1', '2025', 'NEA-00233-2025', '', 'BID 8388', 0, 0),
(214, 12, 'FORZA', 'FVR 1012', '--', '91432408515652', '46225215BE63', '1', '2025', 'NEA-00233-2025', '', 'BID 8229', 0, 0),
(215, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922373', '1', '2025', 'NEA-00233-2025', '', 'BID 7268', 0, 0),
(216, 12, 'FORZA', 'FVR 1012', '--', '91432408515657', '46225215BE85', '1', '2025', 'NEA-00233-2025', '', 'BID 8215', 0, 0),
(217, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922372', '1', '2025', 'NEA-00233-2025', '', 'BID 7269', 0, 0),
(218, 12, 'FORZA', 'FVR 1012', '--', '91432408515655 ', '46225215BE66', '1', '2025', 'NEA-00233-2025', '', 'BID 8232', 0, 0),
(219, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922389', '1', '2025', 'NEA-00233-2025', '', 'BID 7251', 0, 0),
(220, 12, 'FORZA', 'FVR 1012', '--', '91432408516088 ', '46225215BE76', '1', '2025', 'NEA-00233-2025', '', 'BID 8385', 0, 0),
(222, 12, 'FORZA', 'FVR 1012', '--', '91432408516083', '46225215BE72', '1', '2025', 'NEA-00233-2025', '', 'BID 8381', 0, 0),
(223, 12, 'FORZA', 'FVR 1012', '--', '91432408515653', '46225215BE64', '1', '2025', 'NEA-00233-2025', '', 'BID 8230', 0, 0),
(224, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922390', '1', '2025', 'NEA-00233-2025', '', 'BID 9291', 0, 0),
(225, 12, 'FORZA', 'FVR 1012', '--', '91432408516077 ', '46225215BE73', '1', '2025', 'NEA-00233-2025', '', 'BID 8382', 0, 0),
(226, 12, 'FORZA', 'FVR 1012', '--', '91432408515650 ', '46225215BE59', '1', '2025', 'NEA-00233-2025', '', 'BID 8224', 0, 0),
(227, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922371', '1', '2025', 'NEA-00233-2025', '', 'BID 7257', 0, 0),
(228, 12, 'FORZA', 'FVR 1012', '--', '91432408516089', '46225215BE74', '1', '2025', 'NEA-00233-2025', '', 'BID 8383', 0, 0),
(229, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922392', '1', '2025', 'NEA-00233-2025', '', 'BID 9305', 0, 0),
(230, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922393', '1', '2025', 'NEA-00233-2025', '', 'BID 7264', 0, 0),
(231, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922394', '1', '2025', 'NEA-00233-2025', '', 'BID 7263', 0, 0),
(232, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922370', '1', '2025', 'NEA-00233-2025', '', 'BID 9314', 0, 0),
(233, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922369', '1', '2025', 'NEA-00233-2025', '', 'BID 7260', 0, 0),
(234, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922368', '1', '2025', 'NEA-00233-2025', '', 'BID 7255', 0, 0),
(235, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922367', '1', '2025', 'NEA-00233-2025', '', 'BID 7261', 0, 0),
(236, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922366', '1', '2025', 'NEA-00233-2025', '', 'BID 7253', 0, 0),
(237, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922365', '1', '2025', 'NEA-00233-2025', '', 'BID 7252', 0, 0),
(238, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922364', '1', '2025', 'NEA-00233-2025', '', 'BID 7258', 0, 0),
(239, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922363', '1', '2025', 'NEA-00233-2025', '', 'BID 7289', 0, 0),
(240, 18, 'SYMBOL', 'LS2208', '--', 'Z4D2M1', '740863503307', '2', '2022', 'C-02319', '', 'C-02319-2022', 0, 0),
(241, 12, 'CDP', 'R2C-AVR 1008i', '--', '200920-0902792', '46225215Y931', '1', '2019', '-', '', 'Ninguna', 0, 0),
(242, 12, 'CDP', 'R2C-AVR 1008i', '--', '200920-0902795', '46225215Y935', '1', '2020', 'O/C-01658-2020', '', 'NINGUNA', 0, 0),
(243, 12, 'CDP', 'R2C-AVR 1008i', '--', '200920-0902816', '46225215Y943', '1', '2020', 'O/C-01658-2020', '', 'NINGUNA', 0, 0),
(244, 14, 'SONY', 'ICP-PX370', '--', '1012819', '952245651197', '2', '2020', '0/c-01658', '', 'Ninguno', 0, 0),
(245, 12, 'CDP', 'R2C-AVR 1008i', '--', '1805150901195', '46225215Y920', '2', '2020', 'O/C-01658', '', 'Ninguno', 0, 0),
(246, 12, 'CDP', 'R2C-AVR 1008i', '--', '200920-0902773', '46225215Y918', '2', '2020', 'O/C-01658', '', 'Ninguno', 0, 0),
(247, 0, 'HP', 'NUEVO', 'I9', '-', '-', '1', '-', '-', '', '-', 0, 0),
(248, 0, 'LENOVO', 'NUEVO MODELO', '--', 'SERIE NUEVA', '546548979ASD', '1', '2025', 'OC-2025-2025', '', 'NINGUNA', 0, 0),
(249, 0, 'COD M', 'MOD M', '--', 'SERIE NUEVA', 'CP NUEVO', '1', '2025', 'OC-2025', '', 'NINGUNA', 0, 0),
(250, 0, 'NOSEEEE', 'NOSE', 'NOSE', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', '', 'NOSE', 40000, 2),
(252, 5, 'EPSON L210', 'MODELO EPSON', '--', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', '', 'NINGUNA', 600, 1),
(253, 5, 'EPSON L10000', 'MODELO EPSON L10000', '--', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', '', 'NINGUNA', 6000, 1),
(254, 5, 'EPSON L50000', 'MODELO EPSON L50000', '--', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', '', 'NINGUNA', 6000, 1),
(255, 5, 'EPSON L20000', 'MODELO EPSON L200000', '--', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', '', 'NINGUNA', 0, 1),
(256, 1, 'ACER', 'NITRO 5', 'INTEL CORE I7', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', '', 'NINGUNA', 0, 1),
(257, 1, 'HP', 'HP 600', 'INTEL CORE I9', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', '', 'NINGUNA', 150000, 1),
(258, 2, 'ASUS', 'ASUS 250', '--', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', '', 'NINGUNA', 5000000, 1),
(259, 1, 'CHINA', 'CHINO', 'I3', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', '', 'NINGUNA', 500000, 1),
(260, 4, 'DELL', 'DELL 200', 'I9', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', '', 'NINGUNA', 800000, 1),
(261, 4, 'DELL', 'DELL 300', 'I9', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', '', 'NINGUNA', 700000, 1),
(262, 3, 'MICRONICS', 'MICRONICS 200', '--', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', '', 'NINGUNA', 40000, 1),
(263, 5, 'MICRONICS', 'MICRONICS 510', '--', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', '', 'NINGUNA', 90000, 1),
(264, 8, 'MICRONICS', 'MICRONICS 260', '--', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', '', 'NINGUNA', 50000, 1),
(265, 10, 'NOSE', 'NOSE', '--', 'NOSE', 'NOSE', '1', '25', 'NOSE', '', 'NOSE', 60000, 1),
(266, 13, 'NOSEee', 'NOSEee', '--', 'NOSEeee', 'NOSEee', '1', '25', 'NOSEee', '', 'NOSEee', 700, 1),
(267, 13, 'NOSE', 'NOSE', '--', 'NOSE', 'NOSE', '2', '25', 'NOSE', '', 'NOSE', 800, 1),
(268, 4, 'ASUS', 'ASUS 250', 'i9', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', 'NEGRO-GRIS', 'NINGUNA', 50, 1),
(269, 3, 'TECLADO MARCA', 'TECLADO MODELO', '--', 'NOSE', 'NOSE', '1', '2025', 'OC-2025', 'ROJO', 'NINGUNA', 100, 1),
(270, 1, 'marca diseño', 'modelo diseño', 'procesador diseño', 'serie diseño', 'codigo patrimonial diseño ', '1', '2025', 'oc - 2025', 'blanco/negro', 'observacion diseño', 2000, 1),
(271, 2, 'marca diseño 4', 'modelo diseño 4', '--', 'serie diseño 4', 'codigo patrimonial diseño  4', '2', '2027', 'oc - 2025 4', 'blanco/negro 4', 'observacion diseño 4', 505, 3);

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
(1, 'Modulo Penal Central', 1),
(2, 'Patrimonio', 1),
(3, 'Nauta', 1),
(4, 'Requena', 1),
(6, 'Caballococha', 1),
(7, 'area prueba', 1),
(8, 'PRUEBA DEPENDENCIA', 1),
(9, 'nueva_dependencia_disenos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallemovimiento`
--

CREATE TABLE `detallemovimiento` (
  `id_detallemovimiento` int(11) NOT NULL,
  `id_bien_detmov` int(11) NOT NULL,
  `id_mov_detallemovimiento` int(11) NOT NULL,
  `estado_detalle_movimiento` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallemovimiento`
--

INSERT INTO `detallemovimiento` (`id_detallemovimiento`, `id_bien_detmov`, `id_mov_detallemovimiento`, `estado_detalle_movimiento`) VALUES
(66, 18, 20, 1),
(67, 17, 21, 1),
(68, 19, 20, 1),
(69, 20, 20, 2),
(70, 21, 22, 1),
(71, 23, 23, 1),
(72, 22, 24, 1),
(73, 24, 25, 2),
(74, 25, 26, 1),
(75, 26, 27, 2),
(76, 41, 28, 1),
(77, 42, 29, 1),
(78, 43, 30, 1),
(79, 44, 30, 1),
(80, 45, 30, 1),
(81, 46, 31, 1),
(82, 47, 31, 1),
(83, 48, 31, 2),
(84, 49, 32, 1),
(85, 50, 32, 1),
(86, 51, 32, 1),
(87, 52, 32, 1),
(88, 53, 32, 1),
(89, 54, 32, 2),
(90, 55, 33, 1),
(91, 56, 33, 1),
(92, 57, 33, 1),
(93, 59, 34, 1),
(94, 58, 34, 1),
(95, 60, 34, 2),
(96, 61, 35, 1),
(97, 66, 36, 1),
(98, 77, 36, 1),
(99, 74, 36, 1),
(100, 169, 36, 1),
(101, 176, 36, 1),
(102, 62, 36, 1),
(103, 63, 36, 1),
(104, 64, 36, 1),
(105, 167, 36, 1),
(106, 171, 36, 1),
(107, 65, 37, 1),
(108, 72, 37, 1),
(109, 69, 37, 1),
(110, 168, 37, 1),
(111, 174, 37, 1),
(112, 67, 38, 1),
(113, 81, 38, 1),
(114, 80, 38, 1),
(115, 170, 38, 1),
(116, 177, 38, 1),
(117, 68, 39, 1),
(118, 84, 39, 1),
(119, 83, 39, 1),
(120, 172, 39, 1),
(121, 178, 39, 2),
(122, 70, 40, 1),
(123, 91, 40, 1),
(124, 87, 40, 1),
(125, 173, 40, 1),
(126, 179, 40, 1),
(127, 103, 41, 1),
(128, 134, 41, 1),
(129, 154, 41, 1),
(130, 224, 41, 1),
(131, 208, 41, 1),
(132, 71, 42, 1),
(133, 93, 42, 1),
(134, 90, 42, 1),
(135, 175, 42, 1),
(136, 180, 42, 2),
(137, 76, 43, 1),
(138, 105, 43, 1),
(139, 101, 43, 1),
(140, 186, 43, 1),
(141, 185, 43, 1),
(142, 104, 44, 1),
(143, 136, 44, 1),
(144, 155, 44, 1),
(145, 227, 44, 1),
(146, 209, 44, 1),
(147, 73, 45, 1),
(148, 98, 45, 1),
(149, 94, 45, 1),
(150, 182, 45, 1),
(151, 181, 45, 1),
(152, 75, 46, 1),
(153, 102, 46, 1),
(154, 97, 46, 1),
(155, 184, 46, 1),
(156, 183, 46, 1),
(157, 106, 47, 1),
(158, 138, 47, 1),
(159, 156, 47, 1),
(160, 229, 47, 1),
(161, 211, 47, 2),
(165, 110, 49, 1),
(166, 139, 49, 1),
(167, 157, 49, 1),
(168, 230, 49, 1),
(169, 213, 49, 1),
(170, 78, 50, 1),
(171, 108, 50, 1),
(172, 107, 50, 1),
(173, 189, 50, 1),
(174, 187, 50, 1),
(175, 111, 50, 1),
(176, 141, 50, 1),
(177, 158, 50, 1),
(178, 231, 50, 1),
(179, 214, 50, 1),
(181, 119, 51, 1),
(182, 146, 51, 1),
(183, 161, 51, 1),
(184, 234, 51, 1),
(185, 220, 51, 1),
(186, 79, 52, 1),
(187, 109, 52, 1),
(188, 114, 52, 1),
(189, 192, 52, 1),
(190, 188, 52, 1),
(196, 122, 54, 1),
(197, 147, 54, 1),
(198, 162, 54, 1),
(199, 235, 54, 1),
(200, 222, 54, 1),
(201, 82, 55, 1),
(202, 112, 55, 1),
(203, 118, 55, 1),
(204, 194, 55, 1),
(205, 190, 55, 2),
(206, 113, 56, 1),
(207, 143, 56, 1),
(208, 159, 56, 1),
(209, 232, 56, 1),
(210, 216, 56, 1),
(211, 116, 57, 1),
(212, 144, 57, 1),
(213, 160, 57, 1),
(214, 233, 57, 1),
(215, 85, 58, 1),
(216, 115, 58, 1),
(217, 121, 58, 1),
(218, 196, 58, 1),
(219, 191, 58, 2),
(220, 218, 57, 1),
(221, 124, 59, 1),
(222, 148, 59, 1),
(223, 163, 59, 1),
(224, 236, 59, 1),
(225, 223, 59, 1),
(226, 129, 59, 1),
(227, 151, 59, 1),
(228, 165, 59, 1),
(229, 238, 59, 1),
(230, 226, 59, 1),
(231, 126, 60, 1),
(232, 149, 60, 1),
(233, 164, 60, 1),
(234, 237, 60, 1),
(235, 225, 60, 1),
(241, 133, 62, 1),
(242, 152, 62, 1),
(243, 166, 62, 1),
(244, 239, 62, 1),
(245, 228, 62, 1),
(246, 86, 63, 1),
(247, 117, 63, 1),
(248, 128, 63, 1),
(249, 199, 63, 1),
(250, 193, 63, 1),
(251, 96, 60, 1),
(252, 130, 60, 1),
(253, 145, 60, 1),
(254, 215, 60, 1),
(255, 204, 60, 1),
(256, 88, 64, 1),
(257, 120, 64, 1),
(258, 135, 64, 1),
(259, 201, 64, 1),
(260, 195, 64, 2),
(261, 89, 65, 2),
(262, 123, 65, 2),
(263, 137, 65, 1),
(264, 205, 65, 2),
(265, 197, 65, 2),
(266, 92, 66, 1),
(267, 125, 66, 1),
(268, 140, 66, 1),
(269, 210, 66, 2),
(270, 200, 66, 2),
(271, 95, 67, 1),
(272, 127, 67, 1),
(273, 142, 67, 1),
(274, 212, 67, 2),
(275, 202, 67, 2),
(276, 99, 68, 1),
(277, 131, 68, 1),
(278, 150, 68, 1),
(279, 217, 68, 1),
(280, 206, 68, 2),
(281, 100, 69, 2),
(282, 132, 69, 2),
(283, 153, 69, 2),
(284, 219, 69, 2),
(285, 207, 69, 2),
(286, 240, 70, 1),
(287, 23, 71, 2),
(288, 241, 72, 1),
(289, 242, 73, 1),
(290, 244, 74, 1),
(291, 243, 75, 1),
(292, 245, 76, 1),
(293, 246, 77, 1),
(294, 247, 78, 1),
(295, 248, 79, 1),
(296, 249, 80, 1),
(297, 251, 81, 1),
(298, 27, 79, 2),
(299, 62, 82, 1),
(300, 20, 82, 2),
(301, 48, 83, 1),
(302, 54, 83, 1),
(303, 20, 84, 1),
(304, 24, 84, 2),
(305, 20, 85, 1),
(306, 48, 85, 1),
(307, 26, 85, 2),
(308, 20, 86, 1),
(309, 89, 86, 1),
(310, 197, 86, 2),
(311, 38, 86, 2),
(312, 35, 83, 1),
(313, 40, 83, 1),
(314, 24, 87, 2),
(315, 48, 87, 1),
(316, 197, 87, 1),
(317, 31, 87, 1),
(318, 30, 87, 1),
(319, 20, 88, 1),
(320, 26, 88, 1),
(321, 89, 88, 1),
(322, 265, 88, 2),
(323, 29, 88, 1),
(324, 20, 89, 1),
(325, 195, 89, 1),
(326, 39, 89, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_movimiento`
--

CREATE TABLE `historial_movimiento` (
  `id_movimiento_historial` int(11) NOT NULL,
  `id_movimiento` int(11) DEFAULT NULL,
  `id_transferente_movimiento` int(11) DEFAULT NULL,
  `id_receptor_movimiento` int(11) DEFAULT NULL,
  `id_dependencia_transferente_movimiento` int(11) DEFAULT NULL,
  `id_dependencia_receptor_movimiento` int(11) DEFAULT NULL,
  `id_area_transferente_movimiento` int(11) DEFAULT NULL,
  `id_area_receptor_movimiento` int(11) DEFAULT NULL,
  `id_bien_desvinculado` int(11) DEFAULT NULL,
  `fecha_movimiento` date DEFAULT NULL,
  `fecha_movimiento_actual` date DEFAULT NULL,
  `archivo_movimiento` varchar(200) DEFAULT NULL,
  `archivo_movimiento_actual` varchar(200) DEFAULT NULL,
  `estado_movimiento` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_movimiento`
--

INSERT INTO `historial_movimiento` (`id_movimiento_historial`, `id_movimiento`, `id_transferente_movimiento`, `id_receptor_movimiento`, `id_dependencia_transferente_movimiento`, `id_dependencia_receptor_movimiento`, `id_area_transferente_movimiento`, `id_area_receptor_movimiento`, `id_bien_desvinculado`, `fecha_movimiento`, `fecha_movimiento_actual`, `archivo_movimiento`, `archivo_movimiento_actual`, `estado_movimiento`) VALUES
(1, 69, 14, 46, 1, 1, 2, 29, 219, '2025-06-12', '2025-08-06', 'DOCS/mov_6878f3989fee32.42980929.pdf', 'reporte_employee_06_08_2025_01-49.pdf', 2),
(2, 69, 14, 46, 1, 1, 2, 29, 207, '2025-06-12', '2025-08-06', 'DOCS/mov_6878f3989fee32.42980929.pdf', 'reporte_employee_06_08_2025_01-49.pdf', 2),
(3, 65, 14, 63, 1, 1, 2, 4, 89, '2025-06-12', '2025-08-06', '--', NULL, 2),
(4, 65, 14, 63, 1, 1, 2, 4, 123, '2025-06-12', '2025-08-06', '--', NULL, 2),
(5, 34, 90, 91, 1, 1, 21, 25, 60, '2025-01-24', '2025-08-06', 'DOCS/mov_6798e61b746eb8.08895426.pdf', 'reporte_employee_06_08_2025_02-30.pdf', 2),
(6, 66, 14, 18, 1, 1, 2, 19, 210, '2025-06-12', '2025-08-06', '--', 'reporte_employee_06_08_2025_08-22.pdf', 2),
(7, 66, 14, 18, 1, 1, 2, 19, 200, '2025-06-12', '2025-08-06', '--', 'reporte_employee_06_08_2025_08-22.pdf', 2),
(8, 65, 145, 144, 2, 3, 3, 13, 205, '2025-06-12', '2025-08-06', '--', 'reporte_employee_06_08_2025_08-24.pdf', 2),
(9, 65, 145, 144, 2, 3, 3, 13, 197, '2025-06-12', '2025-08-06', '--', 'reporte_employee_06_08_2025_08-24.pdf', 2),
(10, 47, 14, 123, 1, 2, 2, 20, 211, '2025-06-11', '2025-08-06', '--', 'reporte_employee_06_08_2025_09-02.pdf', 2),
(11, 67, 14, 134, 1, 1, 2, 4, 212, '2025-06-12', '2025-08-06', '--', NULL, 2),
(12, 67, 14, 134, 1, 1, 2, 4, 202, '2025-06-12', '2025-08-06', '--', NULL, 2),
(13, 67, 14, 134, 1, 1, 2, 4, 212, '2025-06-12', '2025-08-06', '--', NULL, 2),
(14, 67, 14, 134, 1, 1, 2, 4, 202, '2025-06-12', '2025-08-06', '--', NULL, 2),
(15, 67, 14, 134, 1, 1, 2, 4, 212, '2025-06-12', '2025-08-06', '--', NULL, 2),
(16, 67, 14, 134, 1, 1, 2, 4, 202, '2025-06-12', '2025-08-06', '--', NULL, 2),
(17, 67, 14, 134, 1, 1, 2, 4, 212, '2025-06-12', '2025-08-06', '--', NULL, 2),
(18, 67, 14, 134, 1, 1, 2, 4, 202, '2025-06-12', '2025-08-06', '--', NULL, 2),
(19, 67, 14, 134, 1, 1, 2, 4, 212, '2025-06-12', '2025-08-06', '--', NULL, 2),
(20, 67, 14, 134, 1, 1, 2, 4, 202, '2025-06-12', '2025-08-06', '--', NULL, 2),
(21, 68, 14, 54, 1, 1, 2, 2, 206, '2025-06-12', '2025-08-06', '--', NULL, 2),
(22, 67, 14, 134, 1, 1, 2, 4, 212, '2025-06-12', '2025-08-06', '--', NULL, 2),
(23, 67, 14, 134, 1, 1, 2, 4, 202, '2025-06-12', '2025-08-06', '--', NULL, 2),
(24, 67, 14, 134, 1, 1, 2, 4, 212, '2025-06-12', '2025-08-06', '--', NULL, 2),
(25, 67, 14, 134, 1, 1, 2, 4, 202, '2025-06-12', '2025-08-06', '--', NULL, 2),
(26, 42, 14, 70, 1, 1, 2, 20, 180, '2025-06-11', '2025-08-06', '--', NULL, 2),
(27, 58, 14, 142, 1, 1, 2, 2, 191, '2025-06-11', '2025-08-06', '--', NULL, 2),
(28, 69, 14, 13, 1, 1, 2, 22, 153, '2025-06-12', '2025-08-07', 'DOCS/mov_6878f3989fee32.42980929.pdf', NULL, 2),
(29, 69, 14, 13, 1, 1, 2, 22, 153, '2025-06-12', '2025-08-07', 'DOCS/mov_6878f3989fee32.42980929.pdf', NULL, 2),
(30, 69, 14, 13, 1, 1, 2, 22, 153, '2025-06-12', '2025-08-07', 'DOCS/mov_6878f3989fee32.42980929.pdf', NULL, 2),
(31, 39, 14, 77, 1, 1, 2, 14, 178, '2025-06-11', '2025-08-07', '--', NULL, 2),
(32, 64, 14, 61, 1, 1, 2, 3, 195, '2025-06-12', '2025-08-07', '--', NULL, 2),
(33, 55, 14, 19, 1, 1, 2, 3, 190, '2025-06-11', '2025-08-07', '--', NULL, 2),
(34, 82, 14, 13, 1, 1, 2, 20, 20, '2025-08-11', '2025-08-11', 'DOCS/mov_689a00f8c18974.87952671.pdf', 'reporte_employee_11_08_2025_09-42.pdf', 2),
(35, 82, 14, 13, 1, 1, 2, 20, 20, '2025-08-11', '2025-08-11', 'DOCS/mov_689a00f8c18974.87952671.pdf', 'reporte_employee_11_08_2025_09-42.pdf', 2),
(36, 32, 14, 45, 1, 1, 2, 28, 54, '2025-01-23', '2025-08-11', 'DOCS/mov_6798e66c9ed439.97704861.pdf', 'reporte_employee_11_08_2025_12-00.pdf', 2),
(37, 31, 14, 90, 1, 1, 2, 21, 48, '2025-01-23', '2025-08-11', 'DOCS/mov_6798e659b27688.17369334.pdf', 'reporte_employee_11_08_2025_12-01.pdf', 2),
(38, 20, 14, 13, 1, 1, 2, 5, 20, '2024-11-12', '2025-08-13', 'DOCS/mov_6733abf98bc226.56897671.pdf', NULL, 2),
(39, 79, 14, 154, 7, 2, 2, 13, 27, '2025-07-31', '2025-08-13', 'DOCS/mov_688b91beeb63f8.38126889.pdf', NULL, 2),
(40, 71, 14, 66, 1, 1, 2, 20, 23, '2025-07-01', '2025-08-13', 'DOCS/mov_6877d3659bb366.34356817.pdf', NULL, 2),
(41, 27, 14, 114, 1, 1, 2, 4, 26, '2024-11-26', '2025-08-13', 'DOCS/mov_6798eb6f7910d7.97761062.pdf', NULL, 2),
(42, 25, 14, 18, 1, 1, 2, 19, 24, '2024-11-20', '2025-08-14', 'DOCS/mov_673f657a46dd71.72844975.pdf', 'reporte_employee_14_08_2025_09-08.pdf', 2),
(43, 84, 14, 144, 1, 1, 2, 38, 24, '2025-08-17', '2025-08-17', 'DOCS/mov_68a22391293985.10144150.pdf', 'reporte_employee_17_08_2025_13-47.pdf', 2),
(44, 85, 14, 13, 1, 1, 2, 34, 26, '2025-08-17', '2025-08-17', 'DOCS/mov_68a24dc3181523.68764911.pdf', 'Reporte de Bienes Asignados - SISAD NCPP_17_08_2025_16-47.pdf', 2),
(45, 86, 14, 145, 1, 1, 2, 13, 197, '2025-08-17', '2025-08-17', 'DOCS/mov_68a2785aeeaee9.73289307.pdf', 'reporte_employee_17_08_2025_19-49.pdf', 2),
(46, 86, 14, 145, 1, 1, 2, 13, 38, '2025-08-17', '2025-08-17', 'DOCS/mov_68a2785aeeaee9.73289307.pdf', 'reporte_employee_17_08_2025_19-49.pdf', 2),
(47, 87, 14, 156, 1, 1, 2, 3, 24, '2025-08-23', '2025-08-23', 'DOCS/mov_68aa592dd6a545.66271067.pdf', 'reporte_employee_23_08_2025_19-16.pdf', 2),
(48, 87, 14, 156, 1, 1, 2, 3, 24, '2025-08-23', '2025-08-23', 'DOCS/mov_68aa592dd6a545.66271067.pdf', 'reporte_employee_23_08_2025_19-16.pdf', 2),
(49, 88, 14, 144, 1, 1, 2, 38, 265, '2025-08-23', '2025-08-23', 'DOCS/mov_68aa6348068e30.94666799.pdf', 'Reporte de Bienes Asignados - SISAD NCPP_23_08_2025_19-58.pdf', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_acciones`
--

CREATE TABLE `log_acciones` (
  `id_log` int(11) NOT NULL,
  `id_usuario_log` int(11) DEFAULT NULL,
  `accion_log` varchar(100) DEFAULT NULL,
  `tabla_afectada_log` varchar(100) DEFAULT NULL,
  `id_fila_afectada_log` int(11) DEFAULT NULL,
  `fecha_accion_log` timestamp NOT NULL DEFAULT current_timestamp(),
  `detalles_log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `log_acciones`
--

INSERT INTO `log_acciones` (`id_log`, `id_usuario_log`, `accion_log`, `tabla_afectada_log`, `id_fila_afectada_log`, `fecha_accion_log`, `detalles_log`) VALUES
(1, 53, 'eliminar', 'menu', 45, '2025-07-15 16:03:33', 'Se eliminó el menú: prueba2 con archivo P/P-NUEVO.php'),
(2, 145, 'insertar', 'menu', 46, '2025-07-15 16:32:58', 'Nuevo menú: prueba3'),
(3, 53, 'eliminar', 'menu', 46, '2025-07-15 16:34:13', 'Se eliminó el menú: prueba3 con archivo P/P-NUEVO.php'),
(4, 145, 'insertar', 'menu', 47, '2025-07-15 16:38:36', 'Nuevo menú: prueba4'),
(5, 145, 'actualiza el estado de usuario', 'usuario', 54, '2025-07-15 16:38:46', 'Se actualizó el estado del usuario con ID = 54 a estado = 2'),
(6, 145, 'asigna módulos a usuario', 'usuario_menu', 54, '2025-07-15 16:38:51', 'Módulos anteriores: [6], nuevos módulos asignados: [6, 47]'),
(7, 145, 'insertar', 'menu', 48, '2025-07-15 16:55:04', 'Nuevo menú: prueba5'),
(8, 53, 'eliminar', 'menu', 47, '2025-07-15 17:09:18', 'Se eliminó el menú: prueba4 con archivo P/P-NUEVO.php'),
(9, 53, 'eliminar', 'menu', 48, '2025-07-15 17:10:14', 'Se eliminó el menú: prueba5 con archivo P/P-NUEVO-5.php'),
(10, 145, 'Actualizar', 'movimiento', 75, '2025-07-16 15:10:24', 'Se ha actualizado el PDF del movimiento.'),
(11, 145, 'Actualizar', 'movimiento', 76, '2025-07-16 15:49:45', 'Se ha actualizado el PDF del movimiento.'),
(12, 145, 'Actualizar', 'movimiento', 72, '2025-07-16 15:57:08', 'Se ha actualizado el PDF del movimiento.'),
(13, 145, 'Actualizar', 'movimiento', 73, '2025-07-16 16:10:19', 'Se ha actualizado el PDF del movimiento.'),
(14, 145, 'Actualizar', 'movimiento', 71, '2025-07-16 16:29:25', 'Se ha actualizado el PDF del movimiento.'),
(15, 145, 'Actualizar', 'movimiento', 69, '2025-07-17 12:59:04', 'Se ha actualizado el PDF del movimiento.'),
(16, 145, 'asigna módulos a usuario', 'usuario_menu', 54, '2025-07-17 16:54:48', 'Módulos anteriores: [6], nuevos módulos asignados: [6, 8]'),
(17, 145, 'insertar', 'menu', 49, '2025-07-17 21:08:45', 'Nuevo menú: prueba'),
(18, 53, 'eliminar', 'menu', 49, '2025-07-17 21:27:30', 'Se eliminó el menú: prueba200 con archivo P/P-NUEVO-5.php'),
(19, 145, 'insertar', 'usuario', 57, '2025-07-17 21:40:26', 'Nuevo usuario agregado: prueba3, Estado = 1'),
(20, 145, 'insertar', 'usuario', 58, '2025-07-17 21:40:31', 'Nuevo usuario agregado: prueba3, Estado = 1'),
(21, 145, 'insertar', 'persona', 154, '2025-07-17 21:41:48', 'Persona: personaprueba1, 23456789'),
(22, 145, 'insertar', 'usuario', 59, '2025-07-17 21:42:16', 'Nuevo usuario agregado: usupruebapersona1, Estado = 1'),
(23, 145, 'insertar', 'usuario', 60, '2025-07-17 21:45:43', 'Nuevo usuario agregado: usupruebapersona1, Estado = 1'),
(24, 145, 'insertar', 'bien', 247, '2025-07-31 15:41:44', 'Bien: LAPTOP, -'),
(25, 145, 'Insertar', 'movimiento', 78, '2025-07-31 15:43:25', 'Se ha registrado un nuevo movimiento.'),
(26, 145, 'insertar', 'bien', 248, '2025-07-31 15:52:01', 'Bien: IMPRESORA, SERIE NUEVA'),
(27, 145, 'Insertar', 'movimiento', 79, '2025-07-31 15:54:38', 'Se ha registrado un nuevo movimiento.'),
(28, 145, 'insertar', 'bien', 249, '2025-07-31 15:58:51', 'Bien: LECTOR DE CÓDIGO DE BARRAS, SERIE NUEVA'),
(29, 145, 'Insertar', 'movimiento', 80, '2025-07-31 16:00:31', 'Se ha registrado un nuevo movimiento.'),
(30, 145, 'insertar', 'bien', 250, '2025-07-31 16:23:30', 'Bien: UPS, NOSE'),
(31, 145, 'insertar', 'bien', 251, '2025-07-31 19:28:12', 'Bien: 5, PRUEBA IMPRESORA'),
(32, 145, 'Insertar', 'movimiento', 81, '2025-07-31 19:31:42', 'Se ha registrado un nuevo movimiento.'),
(33, 145, 'insertar', 'menu', 50, '2025-08-04 14:08:26', 'Nuevo menú: Gestionar bienes'),
(34, 145, 'insertar', 'bien', 252, '2025-08-07 15:07:19', 'Bien: 5, NOSE'),
(35, 145, 'insertar', 'bien', 253, '2025-08-07 17:31:09', 'Bien: 5, NOSE'),
(36, 145, 'insertar', 'bien', 254, '2025-08-07 17:36:50', 'Bien: 5, NOSE'),
(37, 145, 'insertar', 'bien', 255, '2025-08-07 17:39:25', 'Bien: 5, NOSE'),
(38, 145, 'insertar', 'bien', 256, '2025-08-07 21:23:39', 'Bien: 1, NOSE'),
(39, 145, 'insertar', 'bien', 257, '2025-08-07 21:49:37', 'Bien: 1, NOSE'),
(40, 145, 'insertar', 'bien', 258, '2025-08-07 21:53:53', 'Bien: 2, NOSE'),
(41, 145, 'insertar', 'bien', 259, '2025-08-07 21:59:52', 'Bien: 1, NOSE'),
(42, 145, 'insertar', 'bien', 260, '2025-08-07 22:01:52', 'Bien: 4, NOSE'),
(43, 145, 'insertar', 'bien', 261, '2025-08-07 22:09:54', 'Bien: 4, NOSE'),
(44, 145, 'insertar', 'bien', 262, '2025-08-07 22:13:14', 'Bien: 3, NOSE'),
(45, 145, 'insertar', 'bien', 263, '2025-08-07 22:15:47', 'Bien: 5, NOSE'),
(46, 145, 'insertar', 'bien', 264, '2025-08-07 22:19:44', 'Bien: 8, NOSE'),
(47, 145, 'insertar', 'bien', 265, '2025-08-07 22:21:20', 'Bien: 10, NOSE'),
(48, 145, 'insertar', 'bien', 266, '2025-08-07 22:25:05', 'Bien: 13, NOSEeee'),
(49, 145, 'insertar', 'bien', 267, '2025-08-07 22:26:08', 'Bien: 14, NOSE'),
(50, 145, 'insertar', 'menu', 51, '2025-08-07 23:31:24', 'Nuevo menú: Historial Desvinculaciones'),
(51, 145, 'insertar', 'area', 47, '2025-08-08 03:55:48', 'Nueva área: PRUEBA AREA'),
(52, 145, 'insertar', 'area', 48, '2025-08-08 04:15:40', 'Nueva área: PRUEBA AREA'),
(53, 145, 'insertar', 'dependencia', 8, '2025-08-08 14:05:27', 'Nueva dependencia: PRUEBA DEPENDENCIA'),
(54, 145, 'insertar', 'persona', 0, '2025-08-08 14:11:22', 'Persona: prueba persona, 25252525'),
(55, 145, 'insertar', 'menu', 52, '2025-08-08 14:14:28', 'Nuevo menú: menu prueba'),
(56, 145, 'Insertar', 'movimiento', 82, '2025-08-11 14:40:25', 'Se ha registrado un nuevo movimiento.'),
(57, 145, 'Actualizar', 'movimiento', 82, '2025-08-11 14:40:56', 'Se ha actualizado el PDF del movimiento.'),
(58, 145, 'insertar', 'menu', 53, '2025-08-11 14:48:07', 'Nuevo menú: MODULO DE FIORELLA'),
(59, 145, 'insertar', 'persona', 156, '2025-08-11 14:53:25', 'Persona: andrea zumba shapiama, 6410067'),
(60, 145, 'insertar', 'usuario', 61, '2025-08-11 14:54:46', 'Nuevo usuario agregado: andrea, Estado = 1'),
(61, 145, 'asigna módulos a usuario', 'usuario_menu', 54, '2025-08-11 14:58:58', 'Módulos anteriores: [6, 8], nuevos módulos asignados: [1, 2, 4]'),
(62, 145, 'Insertar', 'movimiento', 83, '2025-08-12 16:33:13', 'Se ha registrado un nuevo movimiento.'),
(63, 145, 'insertar', 'bien', 268, '2025-08-13 15:59:33', 'Bien: 4, NOSE'),
(64, 145, 'insertar', 'bien', 269, '2025-08-13 16:17:21', 'Bien: 3, NOSE'),
(65, 145, 'insertar', 'area', 49, '2025-08-14 14:22:52', 'Nueva área: Prueba Area'),
(66, 145, 'Insertar', 'movimiento', 84, '2025-08-17 16:11:25', 'Se ha registrado un nuevo movimiento.'),
(67, 145, 'Actualizar', 'movimiento', 84, '2025-08-17 18:46:41', 'Se ha actualizado el PDF del movimiento.'),
(68, 145, 'Insertar', 'movimiento', 85, '2025-08-17 20:20:02', 'Se ha registrado un nuevo movimiento.'),
(69, 145, 'Actualizar', 'movimiento', 85, '2025-08-17 21:46:43', 'Se ha actualizado el PDF del movimiento.'),
(70, 145, 'Insertar', 'movimiento', 86, '2025-08-18 00:47:49', 'Se ha registrado un nuevo movimiento.'),
(71, 145, 'Actualizar', 'movimiento', 86, '2025-08-18 00:48:26', 'Se ha actualizado el PDF del movimiento.'),
(72, 145, 'Actualizar', 'movimiento', 86, '2025-08-18 00:48:26', 'Se ha actualizado el PDF del movimiento.'),
(73, 145, 'insertar', 'area', 50, '2025-08-18 01:18:23', 'Nueva área: area_new_diseno'),
(74, 145, 'insertar', 'dependencia', 9, '2025-08-18 01:19:12', 'Nueva dependencia: nueva_dependencia_diseno'),
(75, 145, 'insertar', 'bien', 270, '2025-08-18 01:23:46', 'Bien: 1, serie diseño'),
(76, 145, 'insertar', 'bien', 271, '2025-08-18 01:24:55', 'Bien: 2, serie diseño 2'),
(77, 145, 'insertar', 'persona', 157, '2025-08-18 01:26:22', 'Persona: Lili Flores, 25987485'),
(78, 145, 'insertar', 'usuario', 62, '2025-08-18 14:23:24', 'Nuevo usuario agregado: LiliUsuario, Estado = 2'),
(79, 145, 'Insertar', 'movimiento', 87, '2025-08-24 00:08:33', 'Se ha registrado un nuevo movimiento.'),
(80, 145, 'Actualizar', 'movimiento', 87, '2025-08-24 00:13:33', 'Se ha actualizado el PDF del movimiento.'),
(81, 145, 'actualiza el estado de usuario', 'usuario', 61, '2025-08-24 00:24:03', 'Se actualizó el estado del usuario con ID = 61 a estado = 2'),
(82, 145, 'asigna módulos a usuario', 'usuario_menu', 61, '2025-08-24 00:24:24', 'Módulos anteriores: [1, 2, 3, 4, 5, 6, 8, 50, 51, 53], nuevos módulos asignados: [1, 2]'),
(83, 145, 'asigna módulos a usuario', 'usuario_menu', 61, '2025-08-24 00:25:45', 'Módulos anteriores: [1, 2], nuevos módulos asignados: [1, 2, 4]'),
(84, 145, 'Insertar', 'movimiento', 88, '2025-08-24 00:52:45', 'Se ha registrado un nuevo movimiento.'),
(85, 145, 'Actualizar', 'movimiento', 88, '2025-08-24 00:56:40', 'Se ha actualizado el PDF del movimiento.'),
(86, 145, 'asigna módulos a usuario', 'usuario_menu', 61, '2025-08-24 01:12:08', 'Módulos anteriores: [1, 2, 4], nuevos módulos asignados: [1, 2, 4, 50, 51]'),
(87, 145, 'Insertar', 'movimiento', 89, '2025-09-09 04:00:38', 'Se ha registrado un nuevo movimiento.'),
(88, 145, 'insertar', 'area', 51, '2025-09-09 04:01:44', 'Nueva área: nuevo diseño'),
(89, 145, 'insertar', 'menu', 54, '2025-09-13 01:50:09', 'Nuevo menú: Ubicacion de equipos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `descripcion_menu` varchar(300) NOT NULL,
  `estado_menu` int(1) NOT NULL,
  `nombrearchivo_menu` varchar(50) DEFAULT NULL,
  `nombrearchivo_img` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id_menu`, `descripcion_menu`, `estado_menu`, `nombrearchivo_menu`, `nombrearchivo_img`) VALUES
(1, 'Registrar Movimiento', 1, 'P/movimiento.php', ''),
(2, 'Ver Movimentos', 1, 'P/vermovimientos.php', ''),
(3, 'Resumen de  Usuarios / Bienes / Ubicación', 1, 'P/verbienes.php', ''),
(4, 'Registrar', 1, 'P/registrar.php', ''),
(5, 'Ver registros / Editar', 1, 'P/listaR.php', ''),
(6, 'Crear usuario', 1, 'P/crear_usuario.php', ''),
(8, 'Administrar Usuarios', 1, 'P/listar_usuarios.php', ''),
(50, 'Gestionar bienes', 1, 'P/gestionar_bienes.php', NULL),
(51, 'Historial Desvinculaciones', 1, 'P/verhistorialdesvinculaciones.php', NULL),
(54, 'Ubicacion de equipos', 1, 'P/ver_ubicacion_equipos.php', NULL);

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
  `archivo_movimiento` varchar(200) NOT NULL,
  `estado_movimiento` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimiento`
--

INSERT INTO `movimiento` (`id_movimiento`, `id_transferente_movimiento`, `id_receptor_movimiento`, `id_dependencia_transferente_movimiento`, `id_dependencia_receptor_movimiento`, `id_area_transferente_movimiento`, `id_area_receptor_movimiento`, `fecha_movimiento`, `archivo_movimiento`, `estado_movimiento`) VALUES
(20, 14, 13, 1, 1, 2, 5, '2024-11-12', 'DOCS/mov_6733abf98bc226.56897671.pdf', 2),
(21, 13, 14, 1, 1, 5, 2, '2024-11-12', 'DOCS/mov_6733ab9abae2b1.51800556.pdf', 1),
(22, 14, 15, 1, 1, 2, 16, '2024-11-13', 'DOCS/mov_6734dda3517321.50903291.pdf', 1),
(23, 14, 16, 1, 1, 2, 14, '2024-11-13', 'DOCS/mov_673f659580f4a6.43042358.pdf', 2),
(24, 14, 17, 1, 1, 2, 14, '2024-11-13', 'DOCS/mov_673f65afe63a87.63086672.pdf', 1),
(25, 14, 18, 1, 1, 2, 19, '2024-11-20', 'DOCS/mov_673f657a46dd71.72844975.pdf', 2),
(26, 14, 19, 1, 1, 2, 3, '2024-11-20', 'DOCS/mov_673f6546667d64.86428609.pdf', 1),
(27, 14, 114, 1, 1, 2, 4, '2024-11-26', 'DOCS/mov_6798eb6f7910d7.97761062.pdf', 2),
(28, 14, 53, 1, 1, 2, 31, '2025-01-21', 'DOCS/mov_6798e696366ad2.69740764.pdf', 1),
(29, 14, 135, 1, 1, 2, 30, '2025-01-21', 'DOCS/mov_6798e6a1187580.27712440.pdf', 1),
(30, 14, 123, 1, 1, 2, 13, '2025-01-22', 'DOCS/mov_6798e68c4ea8c7.95928685.pdf', 1),
(31, 14, 90, 1, 1, 2, 21, '2025-01-23', 'DOCS/mov_6798e659b27688.17369334.pdf', 2),
(32, 14, 45, 1, 1, 2, 28, '2025-01-23', 'DOCS/mov_6798e66c9ed439.97704861.pdf', 2),
(33, 45, 14, 1, 1, 28, 2, '2025-01-23', 'DOCS/mov_6798e6761802a9.14282812.pdf', 1),
(34, 90, 91, 1, 1, 21, 25, '2025-01-24', 'DOCS/mov_6798e61b746eb8.08895426.pdf', 1),
(35, 14, 44, 1, 1, 2, 20, '2025-04-15', 'DOCS/mov_6807c1a1762228.67858584.pdf', 1),
(36, 14, 48, 1, 1, 2, 30, '2025-06-11', '--', 0),
(37, 14, 92, 1, 1, 2, 30, '2025-06-11', '--', 0),
(38, 14, 139, 1, 1, 2, 14, '2025-06-11', '--', 0),
(39, 14, 77, 1, 1, 2, 14, '2025-06-11', '--', 0),
(40, 14, 75, 1, 1, 2, 3, '2025-06-11', '--', 0),
(41, 14, 58, 1, 1, 2, 21, '2025-06-11', '--', 0),
(42, 14, 70, 1, 1, 2, 3, '2025-06-11', '--', 0),
(43, 14, 88, 1, 1, 2, 19, '2025-06-11', '--', 0),
(44, 14, 135, 1, 1, 2, 6, '2025-06-11', '--', 0),
(45, 14, 82, 1, 1, 2, 6, '2025-06-11', '--', 0),
(46, 14, 140, 1, 1, 2, 6, '2025-06-11', '--', 0),
(47, 14, 141, 1, 1, 2, 33, '2025-06-11', '--', 0),
(49, 14, 112, 1, 1, 2, 4, '2025-06-11', '--', 0),
(50, 14, 91, 1, 1, 2, 25, '2025-06-11', '--', 0),
(51, 14, 86, 1, 1, 2, 29, '2025-06-11', '--', 0),
(52, 14, 90, 1, 1, 2, 13, '2025-06-11', '--', 0),
(54, 14, 87, 1, 1, 2, 29, '2025-06-11', '--', 0),
(55, 14, 19, 1, 1, 2, 3, '2025-06-11', '--', 2),
(56, 14, 62, 1, 1, 2, 14, '2025-06-11', '--', 0),
(57, 14, 72, 1, 1, 2, 14, '2025-06-11', '--', 0),
(58, 14, 142, 1, 1, 2, 3, '2025-06-11', '--', 0),
(59, 14, 129, 1, 1, 2, 39, '2025-06-11', '--', 0),
(60, 14, 13, 1, 1, 2, 22, '2025-06-11', '--', 0),
(62, 14, 143, 1, 1, 2, 19, '2025-06-11', '--', 0),
(63, 14, 74, 1, 1, 2, 3, '2025-06-11', '--', 0),
(64, 14, 61, 1, 1, 2, 3, '2025-06-12', '--', 2),
(65, 14, 63, 1, 1, 2, 4, '2025-06-12', '--', 0),
(66, 14, 18, 1, 1, 2, 19, '2025-06-12', '--', 0),
(67, 14, 134, 1, 1, 2, 14, '2025-06-12', '--', 0),
(68, 14, 54, 1, 1, 2, 5, '2025-06-12', '--', 0),
(69, 14, 46, 1, 1, 2, 29, '2025-06-12', 'DOCS/mov_6878f3989fee32.42980929.pdf', 1),
(70, 14, 123, 1, 1, 2, 13, '2025-06-19', '--', 0),
(71, 14, 66, 1, 1, 2, 20, '2025-07-01', 'DOCS/mov_6877d3659bb366.34356817.pdf', 2),
(72, 14, 47, 1, 1, 2, 20, '2025-07-01', 'DOCS/mov_6877cbd3ecf985.53179859.pdf', 1),
(73, 14, 147, 1, 1, 2, 20, '2025-07-01', 'DOCS/mov_6877ceebdffaf9.50601680.pdf', 1),
(74, 14, 142, 1, 1, 2, 3, '2025-07-01', '--', 0),
(75, 14, 148, 1, 1, 2, 20, '2025-07-01', 'DOCS/mov_6877c0e0b34ea7.29370046.pdf', 1),
(76, 14, 149, 1, 1, 2, 20, '2025-07-01', 'DOCS/mov_6877ca193c9319.72563228.pdf', 1),
(77, 14, 150, 1, 1, 2, 20, '2025-07-01', '--', 0),
(78, 14, 154, 1, 1, 2, 43, '2025-07-31', 'DOCS/mov_688b8f1d568557.74548989.pdf', 1),
(79, 14, 154, 7, 2, 2, 13, '2025-07-31', 'DOCS/mov_688b91beeb63f8.38126889.pdf', 2),
(80, 14, 145, 1, 1, 2, 2, '2025-07-29', 'DOCS/mov_688b931f0e6a33.27347653.pdf', 1),
(81, 14, 144, 1, 1, 2, 2, '2025-07-31', 'DOCS/mov_688bc49e7b4214.60131214.pdf', 1),
(82, 14, 13, 1, 1, 2, 20, '2025-08-11', 'DOCS/mov_689a00f8c18974.87952671.pdf', 2),
(83, 14, 144, 1, 1, 2, 2, '2025-08-12', '--', 0),
(84, 14, 144, 1, 1, 2, 38, '2025-08-17', 'DOCS/mov_68a22391293985.10144150.pdf', 2),
(85, 14, 13, 1, 1, 2, 34, '2025-08-17', 'DOCS/mov_68a24dc3181523.68764911.pdf', 2),
(86, 14, 145, 1, 1, 2, 13, '2025-08-17', 'DOCS/mov_68a2785aeeaee9.73289307.pdf', 2),
(87, 14, 156, 1, 1, 2, 3, '2025-08-23', 'DOCS/mov_68aa592dd6a545.66271067.pdf', 2),
(88, 14, 144, 1, 1, 2, 38, '2025-08-23', 'DOCS/mov_68aa6348068e30.94666799.pdf', 2),
(89, 14, 156, 1, 1, 2, 13, '2025-09-08', '--', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nombre_bien`
--

CREATE TABLE `nombre_bien` (
  `id_nombre_bien` int(11) NOT NULL,
  `des_nombre_bien` varchar(200) NOT NULL,
  `estado_nombre_bien` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nombre_bien`
--

INSERT INTO `nombre_bien` (`id_nombre_bien`, `des_nombre_bien`, `estado_nombre_bien`) VALUES
(1, 'UNIDAD CENTRAL DE PROCESO - CPU', 1),
(2, 'MONITOR LED', 1),
(3, 'TECLADO', 1),
(4, 'LAPTOP', 1),
(5, 'IMPRESORA', 1),
(6, 'CONSOLA AMPLIFICADORA DE AUDIO', 1),
(7, 'CONSALA MIXER DE AUDIO', 1),
(8, 'PARLANTES DE PARED', 1),
(9, 'PARLANTES DE ESCRITORIO', 1),
(10, 'MICRÓFONO PROFESIONAL', 1),
(11, 'VIDEO CÁMARA PARA COMPUTADORA', 1),
(12, 'ESTABILIZADOR', 1),
(13, 'UPS', 1),
(14, 'GRABADORA DIGITAL', 1),
(15, 'TARJETA DE SONIDO EXTERNO', 1),
(16, 'SWITCH DE RED', 1),
(17, 'AUDIFONOS PROFESIONALES', 1),
(18, 'LECTOR DE CÓDIGO DE BARRAS', 1),
(20, 'nuevo2', 1);

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
  `cargo_persona` varchar(150) NOT NULL,
  `estado_persona` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `nomyap_persona`, `dni_persona`, `cell_persona`, `correo_persona`, `cargo_persona`, `estado_persona`) VALUES
(1, 'Jack Maitahuari Vasquez', '77536265', '925944693', 'JVAZQUEZFABABA20@GMAIL.COM', '', 1),
(2, 'Luis Fernando Romero Amasifuen', '72198165', '917669478', 'luisromeroamasifuen@gmail.com', '', 1),
(3, 'Crionni Deiby  Wong Lopez', '46081102', '987654132', '--', 'ASISTENTE DE INFORMÁTICA', 1),
(13, 'Tello Dantas Gino', '41852379', '944936440', 'gtellod@pj.gob.pe', 'JUEZ DE INVESTIGACIÓN PREPARATORIA', 1),
(14, 'Hugo Clay Tiburcio Collantes', '10269301', '984969006', 'htiburcioc@pj.gob.pe', 'ASISTENTE DE INFORMÁTICA', 1),
(15, 'Marjorie Zuleika Pasquel Garcia', '40041614', '965605144', 'mpasquel@pj.gob.pe', 'ESPECIALISTA DE AUDIENCIA', 1),
(16, 'Johnny Alexander Vela Collazos', '70751018', '932784612', 'jvelaco@pj.gob.pe', 'SECRETARIO JUDICIAL', 1),
(17, 'Dilver Abel Choctalin Tauma', '72810712', '--', 'dchoctalin@pj.gob.pe', 'ESPECIALISTA LEGAL', 1),
(18, 'Soto Quintanilla Erika', '44968676', '--', 'esotoqu@pj.gob.pe', 'JUEZ', 1),
(19, 'Michel Angelo Ramirez Arregui', '70271700', '--', 'mramirezar@pj.gob.pe', 'Especialista de Audiencia', 1),
(20, 'Dolly Smiht Alvarado Lazo', '05373352', '--', 'dalvaradol@pj.gob.pe', 'Especialista de Audiencia', 1),
(21, 'Daniela Villacorta Barbaran ', '44834948', '--', 'dvillacortab@pj.gob.pe', 'Especialista de Audiencia', 1),
(22, 'Eddier Rojas Linares ', '05338887', '--', 'erojasl@pj.gob.pe', 'Especialista de Audiencia', 1),
(23, 'Alex Antonio Valdez Marrou', '70651824', '--', 'avaldezm@pj.gob.pe', 'Especialista de Audiencia', 1),
(24, 'Francisco Javier Soplin Escudero ', '70748525', '--', 'fsoplin@pj.gob.pe', 'Especialista de Audiencia', 1),
(25, 'Sheyla Talhia Rojas Ihuaraqui ', '45300214', '--', 'shrojasi@pj.gob.pe', 'Asistente Jurisdic. De Juzgado', 1),
(26, 'Martha Indira De Los Santos Vilchez ', '44278812', '--', 'mdelossantosv@pj.gob.pe', 'Especialista Judicial De Juzgado', 1),
(27, 'Maria Del Carmen Ruck Sanchez ', '05380528', '--', 'cruck@pj.gob.pe', 'Asistente Jurisdiccional De Sala', 1),
(28, 'Angie Lianhell Perez Macedo ', '72513368', '--', 'aperezma@pj.gob.pe', 'Auxiliar Judicial ', 1),
(29, 'Betti Ramirez Gutierrez ', '05266650', '--', 'bramirezg@pj.gob.pe', 'Tecnico Judicial', 1),
(30, 'Luz Rosenda Maldonado Garay ', '23016474', '--', 'lmaldonadog@pj.gob.pe', 'Especialista Judicial De Juzgado', 1),
(31, 'Ximena Pinedo Chavez ', '72283037', '--', 'xpinedo@pj.gob.pe', 'Asistente Legal', 1),
(32, 'Johans Igor Diaz Melendez ', '45356873', '--', 'jdiazmel@pj.gob.pe', 'Asistente Judicial', 1),
(33, 'Erick Edwin Solsol Cespedes ', '41885434', '--', 'esolsol@pj.gob.pe', 'Coordinador/A De Causa/ Audiencia', 1),
(34, 'Moises Leonardo Racchumick Castillo', '72737271', '--', 'mracchumick@pj.gob.pe', 'Asistente Jurisdic. De Juzgado', 1),
(35, 'Ximena Karina Garcia Lopez', '40244228', '--', 'xgarcial@pj.gob.pe', 'Asistente Jurisdiccional De Juzgado', 1),
(36, 'Jorge Luis Pasquel Curitima ', '48371122', '--', 'jpasquelc@pj.gob.pe', 'Asistente Jurisdiccional', 1),
(37, 'Cusy Carolina Reategui Malafaya ', '71113370', '--', 'creategui@pj.gob.pe', 'Asistente En Servicios Administrativos', 1),
(38, 'Jairo Neyser Salazar Angulo ', '42772071', '--', 'jsalazara@pj.gob.pe', 'JUEZ II', 1),
(39, 'Fernando Villegas Nuñez', '47432487', '--', 'fvillegasn@pj.gob.pe', 'Especialista Judicial De Audiencia De Juzgado', 1),
(40, 'Nidia Shirley Lozano Aspajo', '71245304', '--', 'nlozanoas@pj.gob.pe', 'Especialista Judicial De Audiencia', 1),
(41, 'Allison Paulina Vargas Silva ', '76601828', '--', 'pvargass@pj.gob.pe', 'Secretaria Judicial', 1),
(42, 'Grace Wendy Pacaya Garcia ', '41885426', '--', 'gpacaya@pj.gob.pe', 'Asistente Jurisdiccional', 1),
(43, 'Gianira Mercedes Valera Diaz ', '43619702', '--', 'gvalerad@pj.gob.pe', 'Especialista Judicial De Juzgado', 1),
(44, 'Andrea Del Pilar Chuquipiondo Sanchez ', '71777766', '--', 'achuquipiondo@pj.gob.pe', 'JUEZ I', 1),
(45, 'Jhovany Vasquez Huaman', '42720755', '--', 'jvasquezh@pj.gob.pe', 'JUEZ II', 1),
(46, 'Karen Vanessa Rios Guzman   ', '40333618', '--', 'krios@pj.gob.pe', 'JUEZ I ', 1),
(47, 'Alondra Pierina Villacorta Ramirez', '75816086', '--', 'avillacortar@pj.gob.pe', 'ESPEC. JUD. AUDIENCIAS', 1),
(48, 'Juan Abelardo Chiong Amasifuen ', '43708065', '--', 'jchiong@pj.gob.pe', 'JUEZ II', 1),
(49, 'Jessica Gisela Olortegui Cumari ', '71584673', '--', 'jolorteguic@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(50, 'Gilda Eloisa Hidalgo Chavez ', '05416105', '--', 'ghidalgo@pj.gob.pe', 'ADMINISTRADORA NCPP', 1),
(51, 'Victor Raul Ramirez Vela ', '05265686', '--', 'vramirezv@pj.gob.pe', 'TECNICO JUDICIAL', 1),
(53, 'Alixey Swidin Aguirre ', '46537071', '--', 'aswidin@pj.gob.pe', 'JUEZ II', 1),
(54, 'Julio Cesar Modesto Davila', '40806799', '--', 'jmodestod@pj.gob.pe', 'JUEZ II', 1),
(55, 'Dayana Kanylu Andia Alosilla ', '46596859', '--', 'dandiaa@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE AUDIENCIA', 1),
(56, 'Tania Elena Niño De Guzman Vilca', '46642985', '--', 'tninogv@pj.gob.pe', 'JUEZ I ', 1),
(57, 'Samuel Martin Soldevilla Escudero ', '41750718', '--', 'ssoldevilla@pj.gob.pe', 'JUEZ I', 1),
(58, 'Jose Neil Chumbe Silva ', '05417100', '--', 'jchumbes@pj.gob.pe', 'JUEZ I ', 1),
(59, 'Karen Jemima Gonzales Cury', '71307805', '--', 'kgonzalescu@pj.gob.pe', 'ASISTENTE JURISDICCIONAL', 1),
(60, 'Katherine Patricia Silva Wong ', '74317865', '--', 'ksilvaw@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(61, 'Jorge Stalin Macedo Piña', '72288201', '--', 'jmacedop@pj.gob.pe', 'ASISTENTE DE COMUNICACIONES', 1),
(62, 'Ana Paula Fernandez Gonzales ', '72899677', '--', 'afernandezgo@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(63, 'Manuel Humberto Guillermo Felipe', '19187634', '--', 'mguillermo@pj.gob.pe', 'JUEZ SUPERIOR', 1),
(64, 'Anibal Segundo Tapia Flores ', '16658606', '--', 'atapiaf@pj.gob.pe', 'JUEZ I', 1),
(65, 'Wendy Guerra Fasabi ', '73416036', '--', 'wguerraf@pj.gob.pe', 'TECNICO JUDICIAL', 1),
(66, 'Neper Socrates Gil Macedo ', '05335589', '--', 'ngil@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(67, 'Omar Saul Cabrera Altamirano ', '10633806', '--', 'ocabrera@pj.gob.pe', 'ASISTENTE JURISDIC. DE  CUSTODIA DE GRABACIONES Y EXPED.', 1),
(68, 'Veronica Atenas Castro Huaman ', '45086989', '--', 'vcastroh@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(69, 'Iris Alina Sampertegui Tapullima ', '73106014', '--', 'isampertegui@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(70, 'Asiria Fiorella Tucto Coriat ', '74093980', '--', 'atuctoco@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE AUDIENCIA', 1),
(71, 'Percy Enrique Cardenas Rodriguez ', '41761697', '--', 'pcardenasr@pj.gob.pe', 'ASISTENTE EN SERVICIOS ADMINISTRATIVOS', 1),
(72, 'Keiko Liria Perez Parano', '73059523', '--', 'kperezpa@pj.gob.pe', 'ASISTENTE JURISDICCIONAL', 1),
(73, 'Agui Nataly Montalvan Flores ', '44555039', '--', 'amontalvanf@pj.gob.pe', 'ASISTENTE JURISDIC. DE JUZGADO', 1),
(74, 'Oseas Lucas Augusto Wong Rojas ', '70600495', '--', 'lwongr@pj.gob.pe', 'ASISTENTE DE COMUNICACIONES', 1),
(75, 'Augusto Guerra Rojas ', '05402424', '--', 'aguerrar@pj.gob.pe', 'ASISTENTE EN SERVICIOS DE  COMUNICACIONES I', 1),
(76, 'Karla Victoria Rengifo Rengifo ', '44988411', '--', 'krengifor@pj.gob.pe', 'ASISTENTE JURISDIC. DE JUZGADO', 1),
(77, 'Zully Rengifo Rinaby ', '05410112', '--', 'zrengifor@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(78, 'Claudia Vela Rengifo', '41182972', '--', 'cvelaren@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(79, 'Gamaniel Gonzalo Laulate Lozano ', '41638984', '--', 'glaulatel@pj.gob.pe', 'SECRETARIO JUDICIAL', 1),
(80, 'Gabriel Taricuarima Perea', '41728131', '--', 'gtaricuarima@pj.gob.pe', 'ASISTENTE EN SERVICIOS DE  COMUNICACIONES I', 1),
(81, 'Lesly Jannina Montani Baca ', '05410233', '--', 'lmontanib@pj.gob.pe', 'ASISTENTE JURISDIC. DE JUZGADO', 1),
(82, 'Franz Richet Velasquez Aricari ', '42660473', '--', 'fvelasqueza@pj.gob.pe', 'ASISTENTE JUDICIAL', 1),
(83, 'Maria Cecilia Ruiz Fernandez ', '05370187', '--', 'mruizf@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE SALA', 1),
(84, 'Maria Esther Ruiz Bazalar ', '42405447', '--', 'mruizba@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE SALA', 1),
(86, 'Vanessa Guerra Maca ', '47844386', '--', 'vguerram@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(87, 'Eldi Marina Sias Peña', '05229307', '--', 'esias@pj.gob.pe', 'TECNICO JUDICIAL', 1),
(88, 'Stephanny Geraldine Nadir Ortiz Cruz', '72650610', '--', 'sortizc@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(89, 'Sonia Patricia Gutierrez Tafur ', '05316572', '--', 'sgutierrezt@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE SALA ', 1),
(90, 'Carlos Enrique Huari Mendoza ', '08844854', '--', 'chuari@pj.gob.pe', 'JUEZ II', 1),
(91, 'Ana Elizabeth Silva More ', '45711960', '--', 'asilvam@pj.gob.pe', 'JUEZ II', 1),
(92, 'Magda Lisbeth Venancino Elaluf ', '71208040', '--', 'mvenancino@pj.gob.pe', 'SECRETARIA JUDICIAL', 1),
(93, 'Judith Gisela Toro Guevara ', '46215178', '--', 'jtorog@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO ', 1),
(94, 'Milton Ronald Melendez Cobos ', '05365345', '--', 'mmelendezc@pj.gob.pe', 'ASISTENTE JURISDIC. DE JUZGADO', 1),
(95, 'Edgar Ramon Guillen Vallejo ', '42463286', '--', 'eguillenv@pj.gob.pe', 'JUEZ II', 1),
(96, 'William Jhonatan Caceres Alfaro ', '46277120', '--', 'wcaceres@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(97, 'Anita Valeria Acho Arevalo ', '70542689', '--', 'aacho@pj.gob.pe', 'ESPECIALISTA LEGAL', 1),
(98, 'Anayka Helany Torres Padilla ', '48717866', '--', 'htorresp@pj.gob.pe', 'ASISTENTE JURISDICCIONAL', 1),
(99, 'Adriana Scheherazade Estrada Fernandez ', '48140032', '--', 'aestradaf@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(100, 'Mario Rene Diaz Diaz ', '05392929', '--', 'mdiazd@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE AUDIENCIA DE JUZGADO', 1),
(101, 'Martha Junelly Marin Garcia ', '71563678', '--', 'mmaring@pj.gob.pe', 'ASISTENTE EN SERVICIOS DE COMUNICACIONES I', 1),
(102, 'Dennis Tello Marapara ', '40021826', '--', 'dtellom@pj.gob.pe', 'ASISTENTE EN SERVICIOS ADMINISTRATIVOS', 1),
(103, 'Alberth Martin Benavides Panduro ', '05392406', '--', 'abenavidesp@pj.gob.pe', 'TECNICO JUDICIAL', 1),
(104, 'Jose Sinclair Seminario Seminario ', '03381094', '--', 'jseminarios@pj.gob.pe', 'AUXILIAR ADMINISTRATIVO I', 1),
(105, 'Andrea Lopez Urresti ', '43834887', '--', 'alopezu@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(106, 'Victor Alejandro Balarezo Diaz ', '40770709', '--', 'vbalarezo@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(107, 'Nathaly Ornella Sangama Sajami ', '40939517', '--', 'nsangama@pj.gob.pe', 'ASISTENTE EN SERVICIOS DE COMUNICACIONES I', 1),
(108, 'Cinthia Del Pilar Cespedes Rodriguez ', '70496100', '--', 'ccespedesr@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE AUDIENCIA', 1),
(109, 'Bethy Vilma Palomino Pedraza ', '23957282', '--', 'bpalomino@pj.gob.pe', 'JUEZ SUPERIOR', 1),
(110, 'Nelly Lilian Lima Gutierrez ', '05278769', '--', 'nlima@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE SALA', 1),
(111, 'Ketty Gutierrez Ore ', '40323397', '--', 'kgutierrezo@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE SALA ', 1),
(112, 'Carlos Alberto Del Pielago Cardenas ', '08704656', '--', 'cdelpielagoc@pj.gob.pe', 'JUEZ SUPERIOR', 1),
(113, 'Petty Regina Ruiz Tenazoa ', '47193801', '--', 'pruizt@pj.gob.pe', 'ASISTENTE JURISDIC. DE JUZGADO', 1),
(114, 'Elena Rocio Guerrero Roque ', '72786603', '--', 'rguerreroro@pj.gob.pe', 'ASISTENTE JURISDICCIONAL ', 1),
(115, 'Roxana Karina Argomedo Obeso ', '05365785', '--', 'kargomedo@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE AUDIENCIA  DE SALA', 1),
(116, 'Evelyn Odaliz Yoxuni Zevallos Mora ', '70763540', '--', 'ezevallosm@pj.gob.pe', 'ASISTENTE JURISDICCIONAL DE JUZGADO', 1),
(117, 'Aldo Nervo Atarama Lonzoy ', '05373094', '--', 'aatarama@pj.gob.pe', 'JUEZ SUPERIOR', 1),
(118, 'Natasha Prokopiuk Otero ', '40187693', '--', 'nprokopiuk@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE SALA', 1),
(119, 'Pascual Ceberino Del Rosario Cornejo ', '06697743', '--', 'pdelrosarioc@pj.gob.pe', 'JUEZ SUPERIOR', 1),
(120, 'Guillermo Arturo Bendezu Cigaran ', '06017889', '--', 'gbendezu@pj.gob.pe', 'JUEZ SUPERIOR', 1),
(121, 'Jean Pierre Laydacker Rivas Mestanza ', '45598101', '--', 'jrivasme@pj.gob.pe', 'ASISTENTE EN SERVICIOS DE  COMUNICACIONES I', 1),
(122, 'Greysi Valeria Gonzales Valdivia ', '46024011', '--', 'ggonzalesva@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(123, 'Ana Chamoli Ruiz ', '43771553', '--', 'achamoli@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE AUDIENCIA DE SALA', 1),
(124, 'Jorge Ruy Llerena Solano ', '45295043', '--', 'jllerenas@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(125, 'Elvira Amarilis Rodriguez Vela ', '45461562', '--', 'erodriguezvel@pj.gob.pe', 'ASISTENTE JURISDIC. DE JUZGADO', 1),
(126, 'Rosa Katiuska Silva Rengifo ', '73194041', '--', 'rsilvar@pj.gob.pe', 'ASISTENTE JURISDICCIONAL DE JUZGADO', 1),
(127, 'Magali Burga Garcia ', '42530380', '--', 'mburgag@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(128, 'Gino Ruiz Salazar ', '42838128', '--', 'gruizs@pj.gob.pe', 'TÉCNICO JUDICIAL', 1),
(129, 'Milagros Del Pilar Sanchez Flores ', '42022628', '--', 'msanchezf@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(130, 'Janeth Gisella Rodriguez Gil ', '05402328', '--', 'jrodriguezg@pj.gob.pe', 'TECNICO JUDICIAL', 1),
(131, 'Angie Lianhell Perez Macedo ', '72513368', '--', 'aperezma@pj.gob.pe', 'AUXILIAR JUDICIAL ', 1),
(132, 'Issis Arletty Mavila Hurtado ', '40868730', '--', 'imavila@pj.gob.pe', 'SECRETARIA JUDICIAL', 1),
(133, 'Karla Milagros Aliaga Palla', '48657309', '--', 'kaliagap@pj.gob.pe', 'ASISTENTE DE COMUNICACIONES', 1),
(134, 'Llajaira Valquiria Perez Perea ', '72542557', '--', 'lperezpe@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(135, 'Alan Douglas Pinche Moreno ', '43010135', '--', 'apinche@pj.gob.pe', 'Asistente Jurisdicional', 1),
(136, 'CHUQUIPIONDO SANCHEZ ANDREA DEL PILAR', '71777766', '-', '-', 'Administradora', 1),
(137, 'SEGUNDO LUCAS LOZANO RIOS', '05323677', '965015423', '-', '-', 1),
(138, 'MARCO VALERIO GRANDEZ CELIS', '40879831', '965866372', '-', '-', 1),
(139, 'VANESSA MICHELY TANG DE LA CRUZ', '47338317', '-', 'vtang@pj.gob.pe', 'ASISTENTE JURISDICCIONAL', 1),
(140, 'JUAN ACHING SANCHEZ', '41736697', '-', 'jaching@pj.gob.pe', 'ASISTENTE JURISDICCIONAL', 1),
(141, 'ROBERT LUIS CHUMBIMUNE PORRAS', '10561613', '-', 'rchumbimune@pj.gob.pe', 'JUEZ', 1),
(142, 'BIBIANA SCARLETT REATEGUI SHUPINGAHUA', '76722227', '-', 'breateguis@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(143, 'ANGELICA DEL CARMEN MONCADA NAVARRO', '70427520', '-', 'amoncada@pj.gob.pe', 'ASISTENTE JURISDICCIONAL', 1),
(144, 'ALFONSO KURTHER TELLO TAMANI', '71645619', '942465727', 'kurthertellotamani@gmail.com', 'PRACTICANTE', 1),
(145, 'WILLIAMS MIGUEL ORDORES FLORES', '72906836', '904936888', 'MIGUELORDORES19@GMAIL.COM', 'PRACTICANTE', 1),
(146, 'Mauricio Leonardo Di Caprio', '70795139', '961966598', 'maurichvz12@gmail.com', 'Practicante', 1),
(147, 'Sara Miluska Olortegui Vela', '72546541', '-', 'solorteguiv@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE JUZGADO', 1),
(148, 'Jennifer Mozombite Catashunga', '46226733', '-', 'jmozombitec@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE AUDIENCIA', 1),
(149, 'Briseida Morgana Llerena Arizaga', '40386949', '-', 'bllerena@pj.gob.pe', 'ASISTENTE ADMINISTRATIVO I', 1),
(150, 'JIMMY JOAN AMBICHO CESPEDES ', '45491810', '-', 'dandiaa@pj.gob.pe', 'ESPECIALISTA JUDICIAL DE AUDIENCIA', 1),
(151, 'prueba', '12345678', '123456789', '-', '-', 1),
(152, 'prueba', '72589674', '969685749', '-', '-', 1),
(153, 'prueba 3', '32165487', '986532147', '-', '-', 1),
(154, 'personaprueba1', '23456789', '965857496', '-', '-', 1),
(155, 'prueba persona', '25252525', '999999999', 'prueba@gmail.com', 'cargo prueba', 1),
(156, 'andrea zumba shapiama', '6410067', '913262011', 'zumbandrea98@gmail.com', 'Practicante', 1),
(157, 'Lili Flores', '25987485', '965748596', 'lili@gmail.com', 'Enfermera', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion_equipos`
--

CREATE TABLE `ubicacion_equipos` (
  `id_ubicacion_equipos` int(11) NOT NULL,
  `ip_ubicacion_equipos` varchar(45) NOT NULL,
  `mac_ubicacion_equipos` varchar(100) NOT NULL,
  `nombre_ubicacion_equipos` varchar(150) DEFAULT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_area` int(11) DEFAULT NULL,
  `estado_conexion` tinyint(1) DEFAULT 0,
  `ultima_deteccion` datetime DEFAULT current_timestamp(),
  `piso` int(11) DEFAULT 1,
  `pos_x` int(11) DEFAULT 0,
  `pos_y` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicacion_equipos`
--

INSERT INTO `ubicacion_equipos` (`id_ubicacion_equipos`, `ip_ubicacion_equipos`, `mac_ubicacion_equipos`, `nombre_ubicacion_equipos`, `id_persona`, `id_area`, `estado_conexion`, `ultima_deteccion`, `piso`, `pos_x`, `pos_y`) VALUES
(1, '172.17.110.10', '00:1A:2B:3C:4D:5E', 'PC-INF-01', 1, 2, 1, '2025-09-12 09:15:00', 1, 207, 253),
(2, '172.17.110.11', '00:1A:2B:3C:4D:5F', 'LAPTOP-ADM-01', 2, 3, 0, '2025-09-12 08:50:00', 1, 37, 255),
(3, '172.17.110.12', '00:1A:2B:3C:4D:60', 'IMPRESORA-PENAL', 3, 4, 1, '2025-09-12 07:45:00', 1, 121, 298);

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
(1, 2, 'lromero', 'e10adc3949ba59abbe56e057f20f883e', 2),
(18, 3, 'cwong', 'e10adc3949ba59abbe56e057f20f883e', 2),
(48, 1, 'jvasquez', 'e10adc3949ba59abbe56e057f20f883e', 2),
(49, 14, 'htiburcioc', 'e10adc3949ba59abbe56e057f20f883e', 1),
(53, 145, 'WilliamsWick', 'e10adc3949ba59abbe56e057f20f883e', 1),
(54, 144, 'kurth99', 'e10adc3949ba59abbe56e057f20f883e', 2),
(55, 146, 'mauchucha', 'e10adc3949ba59abbe56e057f20f883e', 2),
(56, 151, 'usuprueba', '202cb962ac59075b964b07152d234b70', 2),
(57, 153, 'prueba3', 'e10adc3949ba59abbe56e057f20f883e', 1),
(60, 154, 'usupruebapersona1', 'e10adc3949ba59abbe56e057f20f883e', 1),
(61, 156, 'andrea', 'e10adc3949ba59abbe56e057f20f883e', 2),
(62, 157, 'LiliUsuario', 'e10adc3949ba59abbe56e057f20f883e', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_menu`
--

CREATE TABLE `usuario_menu` (
  `id_usuariomenu` int(11) NOT NULL,
  `id_usuario_menu` int(11) NOT NULL,
  `id_menu_usuario_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_menu`
--

INSERT INTO `usuario_menu` (`id_usuariomenu`, `id_usuario_menu`, `id_menu_usuario_menu`) VALUES
(5, 18, 1),
(6, 18, 2),
(7, 18, 3),
(8, 18, 4),
(9, 18, 5),
(10, 18, 6),
(11, 18, 8),
(12, 53, 2),
(13, 53, 4),
(14, 56, 8),
(27, 60, 1),
(28, 60, 2),
(29, 60, 3),
(30, 60, 4),
(31, 60, 5),
(32, 60, 6),
(33, 60, 8),
(44, 54, 1),
(45, 54, 2),
(46, 54, 4),
(52, 61, 1),
(53, 61, 2),
(54, 61, 4),
(55, 61, 50),
(56, 61, 51);

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
-- Indices de la tabla `historial_movimiento`
--
ALTER TABLE `historial_movimiento`
  ADD PRIMARY KEY (`id_movimiento_historial`);

--
-- Indices de la tabla `log_acciones`
--
ALTER TABLE `log_acciones`
  ADD PRIMARY KEY (`id_log`);

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
-- Indices de la tabla `nombre_bien`
--
ALTER TABLE `nombre_bien`
  ADD PRIMARY KEY (`id_nombre_bien`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indices de la tabla `ubicacion_equipos`
--
ALTER TABLE `ubicacion_equipos`
  ADD PRIMARY KEY (`id_ubicacion_equipos`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_area` (`id_area`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `usuario_menu`
--
ALTER TABLE `usuario_menu`
  ADD PRIMARY KEY (`id_usuariomenu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `bien`
--
ALTER TABLE `bien`
  MODIFY `id_bien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=272;

--
-- AUTO_INCREMENT de la tabla `dependencia`
--
ALTER TABLE `dependencia`
  MODIFY `id_dependencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detallemovimiento`
--
ALTER TABLE `detallemovimiento`
  MODIFY `id_detallemovimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=327;

--
-- AUTO_INCREMENT de la tabla `historial_movimiento`
--
ALTER TABLE `historial_movimiento`
  MODIFY `id_movimiento_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `log_acciones`
--
ALTER TABLE `log_acciones`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `nombre_bien`
--
ALTER TABLE `nombre_bien`
  MODIFY `id_nombre_bien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT de la tabla `ubicacion_equipos`
--
ALTER TABLE `ubicacion_equipos`
  MODIFY `id_ubicacion_equipos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `usuario_menu`
--
ALTER TABLE `usuario_menu`
  MODIFY `id_usuariomenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ubicacion_equipos`
--
ALTER TABLE `ubicacion_equipos`
  ADD CONSTRAINT `ubicacion_equipos_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `ubicacion_equipos_ibfk_2` FOREIGN KEY (`id_area`) REFERENCES `area` (`id_area`);

--
-- Filtros para la tabla `usuario_menu`
--
ALTER TABLE `usuario_menu`
  ADD CONSTRAINT `usuario_menu_ibfk_1` FOREIGN KEY (`id_usuario_menu`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
