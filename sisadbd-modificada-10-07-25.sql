-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-07-2025 a las 08:30:59
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
  `estado_area` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id_area`, `descripcion_area`, `estado_area`) VALUES
(2, 'Infórmatica Ncpp', 1),
(3, 'Especialista De Audiencia', 1),
(4, 'Primera Sala Penal De Apelaciones', 1),
(5, 'Tercer Juzgado De Investigación Preparatoria', 1),
(6, 'Segunda Sala Penal De Apelaciones', 1),
(13, 'Juzgado Unipersonal', 1),
(14, 'Juzgado De Investigación Preparatoria', 1),
(16, 'Primer Juzgado Penal Unipersonal Supraprovincial Transitorio', 1),
(17, 'Tercer Juzgado De Investigación Preparatoria', 1),
(18, 'Primer Juzgado Penal Unipersonal Supraprovincial Transitorio', 1),
(19, 'Quinto Juzgado De Investigación Preparatoria', 1),
(20, 'Administración', 1),
(21, 'Primer Juzgado Unipersonal Transitorio', 1),
(22, 'Segundo Juzgado De Investigación Preparatoria', 1),
(23, 'Cuarto Juzgado De Investigación Preparatoria', 1),
(24, 'Juzgado De Investigación Preparatoria Transitorio', 1),
(25, 'Segundo Juzgado Unipersonal', 1),
(26, 'Extinción De Dominio', 1),
(27, 'Juzgado De Nauta', 1),
(28, 'Primer Juzgado Unipersonal', 1),
(29, 'Segundo Juzgado Unipersonal Transitorio', 1),
(30, 'Tercer Juzgado Unipersonal', 1),
(31, 'Primer Juzgado De Investigación Preparatoria', 1),
(33, 'Juzgado Penal Colegiado Supraprovincial Transitorio', 1),
(34, 'Camara Gesell', 1),
(35, 'Custodia De Expedientes', 1),
(36, 'Segunda Sala Penal De Apelaciones En Adición Liquidadora', 1),
(37, 'Establecimiento Penitenciario Penal De Varones', 1),
(38, 'Mesa De Partes', 1),
(39, 'JUZGADO DE INVESTIGACIÓN TRANSITORIO', 1);

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
  `observacion_bien` varchar(200) NOT NULL,
  `costo_bien` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bien`
--

INSERT INTO `bien` (`id_bien`, `equipo_bien`, `marca_bien`, `modelo_bien`, `procesador_bien`, `numdeserie_bien`, `numcontropatri_bien`, `estado_bien`, `añodeadqs_bien`, `numdeordendecom_bien`, `observacion_bien`, `costo_bien`) VALUES
(17, 4, 'LENOVO	', 'THINKPAD E15', 'Intel® Core™ i7 de 10ma Generación', 'PF28DZBC', '740805003302', '1', '2020', 'O/C-01054-2020', 'NINGUNA', 0),
(18, 1, 'HP', 'PRODESK 600 G1 SFF', 'Intel(R) Core(TM) i5-4590 CPU @ 3.30GHz	', 'MXL5282S3K', '74089950AQ14', '2', '2015', '01720-2015', 'NUNGUNA', 0),
(19, 3, 'GENIUS', 'KB-118', '--', 'UL2118302672', '740895500PNDT', '1', '2022', 'CAJA CHICA', 'CAJA CHICA', 0),
(20, 2, 'TONG FANG', 'TDY-19E81N', '--', 'D170519ENGD4200318', '740880375766', '1', '2017', 'NEA-00013-2017', 'NINGUNA', 0),
(21, 14, 'SONY', 'ICD-PX370', '--', '1011662', '952245651208', '1', '2020', 'O/C-01658-2020', 'NINGUNA', 0),
(22, 12, 'CDP', 'R2CU-AVR 1008i', '--', '180620-1065252', '46225215X976', '1', '2019', 'O/C-01065-2019', 'NINGUNA', 0),
(23, 12, 'CDP', 'R2C-AVR 1008I', '--', '190225-0903913 ', '46225215Y911', '1', '2019', 'O/C-01656-2020', 'NINGUNA', 0),
(24, 17, 'AKG', 'K72', '--', 'MI4022-208209', '952210701553', '1', '2021', 'O/C-02073-2021', 'NINGUNA', 0),
(25, 14, 'SONY', 'ICD-PX370', '--', '1011664', '952245651196', '1', '2020', 'O/C-01658-2020', 'NINGUNA', 0),
(26, 12, 'CDP', 'R2C-AVR 1008i', '--', '200920-0902782', '46225215Y912', '1', '2022', 'O/C-01656-2020', 'NINGUNA', 0),
(27, 1, 'DELL', 'OPTIPLEX 7020', 'Intel Core i7 14700', 'CX34X54', '74089950GR06', '1', '2024', '02406-2024', 'NINGUNA', 0),
(28, 2, 'HP', 'HP E24 G5', '--', 'CN44171JRP', '74088187N375', '1', '2024', '02406-2024', 'NINGUNA', 0),
(29, 3, 'DELL', 'KB216T1', '--', 'CN019M93LO30048101XDA04', '74089500IS74', '1', '2024', '02406-2024', 'NINGUNA', 0),
(30, 1, 'DELL', 'OPTIPLEX 7020', 'Intel Core i7 14700', '5PGV564', '74089950GR08', '1', '2024', '02406-2024', 'NINGUNA', 0),
(31, 2, 'HP', 'HP E24 G5', '--', 'CN44182KKJ', '74088187N378', '1', '2024', '02406-2024', 'NINGUNA', 0),
(32, 3, 'DELL', 'KB216T1', '--', 'CN019M93LO30047D0DCTA04', '74089500IS76', '1', '2024', '02406-2024', 'NINGUNA', 0),
(33, 1, 'DELL', 'OPTIPLEX 7020', 'Intel Core i7 14700', '5NSV564', '74089950GR05', '1', '2024', '02406-2024', 'NINGUNA', 0),
(34, 2, 'HP', 'HP E24 G5', '--', 'CN44190KNZ', '74088187N376', '1', '2024', '02406-2024', 'NINGUNA', 0),
(35, 3, 'DELL', 'KB216T1', '--', 'CN019M93LO30047D0DFDA04', '74089500IS75', '1', '2024', '02406-2024', 'NINGUNA', 0),
(36, 1, 'DELL', 'OPTIPLEX 7020', 'Intel Core i7 14700', 'JTWV564', '74089950GR07', '1', '2024', '02406-2024', 'NINGUNA', 0),
(37, 2, 'HP', 'HP E24 G5', '--', 'CN441933QB', '74088187N377', '1', '2024', '02406-2024', 'NINGUNA', 0),
(38, 3, 'DELL', 'KB216T1', '--', 'CN019M93LO30048105KRA04', '74089500IS73', '1', '2024', '02406-2024', 'NINGUNA', 0),
(39, 4, 'HP', 'PROBOOK 450 G10', ' Intel® Core™ i7 de 13.ª generación ', '1H84252FHL', '740805008181', '1', '2024', 'OC-02410-2024', 'NINGUNA', 0),
(40, 4, 'HP', 'PROBOOK 450 G10', ' Intel® Core™ i7 de 13.ª generación ', '1H84252FGM', '740805008182', '1', '2024', 'OC-02410-2024', 'NINGUNA', 0),
(41, 13, 'APC', 'SURT1000XLI', '--', 'AS1953190525', '462200505059', '1', '2019', 'CODIGO M 423087', '--', 0),
(42, 4, 'THINKPAD', 'LENOVO', 'Intel(R) Core(TM) i7-10510U CPU @ 1.80GHz', 'PF-28D41B', '740805003309', '1', '2020', 'O/S - 01054-2020', '--', 0),
(43, 1, 'DELL', 'OPTIPLEX SFF PLUS 7010', '13th Gen Intel(R) Core(TM) i7-13700   2.10 GHz', 'DGX6704', '74089950GJ41', '1', '2023', '2216-2023- C', 'NINGUNA', 0),
(44, 2, 'DELL', 'E2424HS', '--', 'CN03GM7VFCC0039MCJ3XA00', '74088187M836', '1', '2023', '2216-2023- C', 'NINGUNA', 0),
(45, 3, 'DELL', 'KB216', '--', 'CN019M93LO30036007CNA04', '74089500IL39', '1', '2023', '2216-2023- C', 'NINGUNA', 0),
(46, 1, 'DELL', 'OPTIPLEX SFF PLUS 7010', '13th Gen Intel(R) Core(TM) i7-13700   2.10 GHz', '3DK6704', '74089950GJ12', '1', '2023', '2216-2023- C', 'NINGUNA', 0),
(47, 2, 'DELL', 'E2424HS', '--', 'CN03GM7VFCC0039MAMHXA00', '74088187M919', '1', '2023', '2216-2023- C', 'NINGUNA', 0),
(48, 3, 'DELL', 'KB216', '--', 'CN019M93LO30038S15WCA04', '74089500IK44', '1', '2023', '2216-2023- C', 'NINGUNA', 0),
(49, 1, 'DELL', 'OPTIPLEX SFF PLUS 7010', '13th Gen Intel(R) Core(TM) i7-13700   2.10 GHz', 'FGN6704', '74089950GJ06', '1', '2023', '2216-2023- C', 'NINGUNA', 0),
(50, 2, 'DELL', 'E2424HS', '--', 'CN03GM7VFCC0039MA83XA00', '74088187M409', '1', '2023', '2216-2023- C', 'NINGUNA', 0),
(51, 3, 'DELL', 'KB216', '--', 'CN019M93LO30038S152QA04', '74089500IN81', '1', '2023', '2216-2023- C', 'NINGUNA', 0),
(52, 1, 'HP', 'PRODESK 600G1 SFF', 'Intel(R) Core(TM) i5-4590 CPU @ 3.30GHz', 'MXL5282S43', '74089950AQ54', '2', '2015', '01720-2015', 'NINGUNA', 0),
(53, 2, 'HP', 'HSTND-392-F', '--', '3CQ4503LLG', '740880371297', '2', '2015', '01720-2015', 'NINGUNA', 0),
(54, 3, 'LOGITECH', 'K10- YU0042', '--', '2313MR109178', 'S/C', '1', '2022', 'S/O', 'NINGUNA', 0),
(55, 1, 'DELL', 'OPTIPLEX 9020', 'Intel(R) Core(TM) i5-4670 CPU @ 3.40GHz', '7GYF8Z1', '74089950Y387', '1', '2013', '1975-2013GG', 'NINGUNA', 0),
(56, 2, 'HP', 'LV1911', '--', '6CM228227L', '74088187F287', '1', '2012', '1277-2012GG', 'NINGUNA', 0),
(57, 3, 'GENIUS', 'KB-118', '--', 'UL2118300179', '--', '3', '2013', '1975-2013GG', 'COMPRADO POR CAJA CHICA', 0),
(58, 1, 'TSINGHUA TONFANG', 'G700', 'Intel(R) Core(TM) i7-6700 CPU @ 3.40GHz', '2170511000308005740', '74089950CQ18', '1', '2017', 'NEA-00013-2017', 'NINGUNA', 0),
(59, 2, 'HP', 'LV1911', '--', '6CM2282221', '74088187F334', '1', '2012', '1277-2012GG', 'NINGUNA', 0),
(60, 3, 'MTG', 'AKB644', '--', '202012000726', '--', '1', '2024', '--', 'CAJA CHICA', 0),
(61, 5, 'KYOCERA', 'TASKALFA 55011', '--', 'LAK5601996', '742227260040', '2', '2015', '02868-2015', 'ESTA PARA REPARACION', 0),
(62, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9BR', '74089950HG11', '1', '2024', 'BID 000429', 'COMPRADO POR EL BID', 0),
(63, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGLB', '74088037E738', '1', '2024', 'BID 005442', 'COMPRADO POR EL BID ', 0),
(64, 3, 'LENOVO', 'SK-8827', '--', '46XD3VP', '74089500JH70', '1', '2024', 'BID 000431', 'COMPRADO POR EL BID', 0),
(65, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AA', '74089950HG02', '1', '2024', 'BID 000411', 'COMPRADO POR EL BID', 0),
(66, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00KGFK', '74089950HF90', '1', '2024', 'BID 001435', 'COMPRADO POR EL BID', 0),
(67, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00KJLN', '74089950HF86', '1', '2024', 'BID 001417', 'COMPRADO POR EL BID', 0),
(68, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AS', '74089950HF99', '1', '2024', 'BID 000405', 'COMPRADO POR EL BID', 0),
(69, 3, 'LENOVO', 'SK-8827', '--', '46XD3VP', '74089500JH61', '1', '2024', 'BID 000412', 'COMPRADO POR EL BID', 0),
(70, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9BP', '74089950HG05', '1', '2024', 'BID 000417', 'COMPRADO POR EL BID', 0),
(71, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AJ', '74089950HG08', '1', '2024', 'BID 000423', 'COMPRADO POR EL BID', 0),
(72, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMV', '74088037E729', '1', '2024', 'BID 005424', 'COMPRADO POR EL BID ', 0),
(73, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9A5', '74089950HG00', '1', '2024', 'BID 000407', 'COMPRADO POR EL BID', 0),
(74, 3, 'LENOVO', 'SK-8827', '--', '46XD187', '74089500JH84', '1', '2024', 'BID 001436', 'COMPRADO POR EL BID', 0),
(75, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AP', '74089950HG04', '1', '2024', 'BID 000415', 'COMPRADO POR EL BID', 0),
(76, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AL', '74089950HF98', '1', '2024', 'BID 000403', 'COMPRADO POR EL BID', 0),
(77, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGLG', '74088037E752', '1', '2024', 'BID 005461', 'COMPRADO POR EL BID ', 0),
(78, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K995', '74089950HG07', '1', '2024', 'BID 000421', 'COMPRADO POR EL BID', 0),
(79, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AY', '74089950HF84', '1', '2024', 'BID 000445', 'COMPRADO POR EL BID', 0),
(80, 3, 'LENOVO', 'SK-8827', '--', '46XD5GA', '74089500JH80', '1', '2024', 'BID 001418', 'COMPRADO POR EL BID', 0),
(81, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGL8', '74088037E748', '1', '2024', 'BID 005457', 'COMPRADO POR EL BID ', 0),
(82, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00KJ07', '74089950HF92', '1', '2024', 'BID 000391', 'COMPRADO POR EL BID', 0),
(83, 3, 'LENOVO', 'SK-8827', '--', '46XD3VH', '74089500JH52', '1', '2024', 'BID 000406', 'COMPRADO POR EL BID', 0),
(84, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGP4', '74088037E726', '1', '2024', 'BID 005414', 'COMPRADO POR EL BID ', 0),
(85, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00KGTG', '74089950HF89', '1', '2024', 'BID 001431', 'COMPRADO POR EL BID', 0),
(86, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00KGGR', '74089950H91', '1', '2024', 'BID 001437', 'COMPRADO POR EL BID', 0),
(87, 3, 'LENOVO', 'SK-8827', '--', '46XD3VN', '74089500JH64', '1', '2024', 'BID 000418', 'COMPRADO POR EL BID', 0),
(88, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9A0', '74089950HG10', '1', '2024', 'BID 000427', 'COMPRADO POR EL BID', 0),
(89, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00KGTC', '74089950HF88', '1', '2024', 'BID 001427', 'COMPRADO POR EL BID', 0),
(90, 3, 'LENOVO', 'SK-8827', '--', '46XD3VF', '74089500JH67', '1', '2024', 'BID 000424', 'COMPRADO POR EL BID', 0),
(91, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGNR', '74088037E732', '1', '2024', 'BID 005434', 'COMPRADO POR EL BID ', 0),
(92, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9A7', '74089950HF93', '1', '2024', 'BID 000393', 'COMPRADO POR EL BID', 0),
(93, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGL4', '74088037E735', '1', '2024', 'BID 005437', 'COMPRADO POR EL BID ', 0),
(94, 3, 'LENOVO', 'SK-8827', '--', '46XD3WX', '74089500JH59', '1', '2024', 'BID 000408', 'COMPRADO POR EL BID', 0),
(95, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AR', '74089950HF83', '1', '2024', 'BID 000443', 'COMPRADO POR EL BID', 0),
(96, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9A3', '74089950HF97', '1', '2024', 'BID 000401', 'COMPRADO POR EL BID', 0),
(97, 3, 'LENOVO', 'SK-8827', '--', '46XD53E', '74089500JH63', '1', '2024', 'BID 000416', 'COMPRADO POR EL BID', 0),
(98, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGNZ', '74088037E727', '1', '2024', 'BID 005416', 'COMPRADO POR EL BID ', 0),
(99, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AZ', '74089950HF94', '1', '2024', 'BID 000395', 'COMPRADO POR EL BID', 0),
(100, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K99P', '74089950HF85', '1', '2024', 'BID 000447', 'COMPRADO POR EL BID', 0),
(101, 3, 'LENOVO', 'SK-8827', '--', '46XD3VJ', '74089500JH51', '1', '2024', 'BID 000404', 'COMPRADO POR EL BID', 0),
(102, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGN8', '74088037E731', '1', '2024', 'BID 005427', 'COMPRADO POR EL BID ', 0),
(103, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K999', '74089950HG01', '1', '2024', 'BID 000409', 'COMPRADO POR EL BID', 0),
(104, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K99S', '74089950HG14', '1', '2024', 'BID 000435', 'COMPRADO POR EL BID', 0),
(105, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGNV', '74088037E725', '1', '2024', 'BID 005413', 'COMPRADO POR EL BID ', 0),
(106, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AQ', '74089950HG09', '1', '2024', 'BID 000425', 'COMPRADO POR EL BID', 0),
(107, 3, 'LENOVO', 'SK-8827', '--', '46XD3W6', '74089500JH66', '1', '2024', 'BID 000422', 'COMPRADO POR EL BID', 0),
(108, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGML', '74088037E734', '1', '2024', 'BID 005436', 'COMPRADO POR EL BID ', 0),
(109, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGLC', '74088037E746', '1', '2024', 'BID 005454', 'COMPRADO POR EL BID ', 0),
(110, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K99C', '74089950HG12', '1', '2024', 'BID 000431', 'COMPRADO POR EL BID', 0),
(111, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9B1', '74089950HG16', '1', '2024', 'BID 000439', 'COMPRADO POR EL BID', 0),
(112, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGK7', '74088037E719', '1', '2024', 'BID 005391', 'COMPRADO POR EL BID ', 0),
(113, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AB', '74089950HG17', '1', '2024', 'BID 000441', 'COMPRADO POR EL BID', 0),
(114, 3, 'LENOVO', 'SK-8827', '--', '46XD3VL', '74089500JH78', '1', '2024', 'BID 000446', 'COMPRADO POR EL BID', 0),
(115, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGN0', '74088037E751', '1', '2024', 'BID 005460', 'COMPRADO POR EL BID ', 0),
(116, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AF', '74089950HF95', '1', '2024', 'BID 000397', 'COMPRADO POR EL BID', 0),
(117, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGLF', '74088037E753', '1', '2024', 'BID 005462', 'COMPRADO POR EL BID ', 0),
(118, 3, 'LENOVO', 'SK-8827', '--', '46XD1F3', '74089500JH45', '1', '2024', 'BID 000392', 'COMPRADO POR EL BID', 0),
(119, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9A2', '74089950HF96', '1', '2024', 'BID 000399', 'COMPRADO POR EL BID', 0),
(120, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMP', '74088037E737', '1', '2024', 'BID 005440', 'COMPRADO POR EL BID ', 0),
(121, 3, 'LENOVO', 'SK-8827', '--', '46XD5Z6', '74089500JH83', '1', '2024', 'BID 001432', 'COMPRADO POR EL BID', 0),
(122, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K99X', '74089950HG13', '1', '2024', 'BID 000433', 'COMPRADO POR EL BID', 0),
(123, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGNN', '74088037E750', '1', '2024', 'BID 005459', 'COMPRADO POR EL BID ', 0),
(124, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AK', '74089950HG03', '1', '2024', 'BID 000413', 'COMPRADO POR EL BID', 0),
(125, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGN4', '74088037E720', '1', '2024', 'BID 005393', 'COMPRADO POR EL BID ', 0),
(126, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K9AX', '74089950HG15', '1', '2024', 'BID 000437', 'COMPRADO POR EL BID', 0),
(127, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGM8', '74088037E745', '1', '2024', 'BID 005451', 'COMPRADO POR EL BID ', 0),
(128, 3, 'LENOVO', 'SK-8827', '--', '46XD4G9', '74089500JH85', '1', '2024', 'BID 001438', 'COMPRADO POR EL BID', 0),
(129, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00KJJS', '74089950HF87', '1', '2024', 'BID 001425', 'COMPRADO POR EL BID', 0),
(130, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGP9', '74088037E724', '1', '2024', 'BID 005404', 'COMPRADO POR EL BID ', 0),
(131, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMF', '74088037E721', '1', '2024', 'BID 005399', 'COMPRADO POR EL BID ', 0),
(132, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMH', '74088037E747', '1', '2024', 'BID 005455', 'COMPRADO POR EL BID ', 0),
(133, 1, 'LENOVO', 'THINKCENTRE M70s Gen 5', '13th Gen Intel(R) Core(TM) i7-13700', 'MZ00K98X', '74089950HG06', '1', '2024', 'BID 000419', 'COMPRADO POR EL BID', 0),
(134, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGM7', '74088037E728', '1', '2024', 'BID 005417', 'COMPRADO POR EL BID ', 0),
(135, 3, 'LENOVO', 'SK-8827', '--', '46XD3WT', '74089500JH69', '1', '2024', 'BID 000428', 'COMPRADO POR EL BID', 0),
(136, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGM9', '74088037E741', '1', '2024', 'BID 005447', 'COMPRADO POR EL BID ', 0),
(137, 3, 'LENOVO', 'SK-8827', '--', '46XD5Z1', '74089500JH82', '1', '2024', 'BID 001428', 'COMPRADO POR EL BID', 0),
(138, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGK2', '74088037E736', '1', '2024', 'BID 005438', 'COMPRADO POR EL BID ', 0),
(139, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGN3', '74088037E739', '1', '2024', 'BID 005445', 'COMPRADO POR EL BID ', 0),
(140, 3, 'LENOVO', 'SK-8827', '--', '46XD3WW', '74089500JH46', '1', '2024', 'BID 000394', 'COMPRADO POR EL BID', 0),
(141, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMB', '74088037E743', '1', '2024', 'BID 005449', 'COMPRADO POR EL BID ', 0),
(142, 3, 'LENOVO', 'SK-8827', '--', '46XD3VM', '74089500JH77', '1', '2024', 'BID 000444', 'COMPRADO POR EL BID', 0),
(143, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGM5', '74088037E744', '1', '2024', 'BID 005450', 'COMPRADO POR EL BID ', 0),
(144, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGN7', '74088037E722', '1', '2024', 'BID 005401', 'COMPRADO POR EL BID ', 0),
(145, 3, 'LENOVO', 'SK-8827', '--', '46XD53F', '74089500JH50', '1', '2024', 'BID 000402', 'COMPRADO POR EL BID', 0),
(146, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGNX', '74088037E723', '1', '2024', 'BID 005403', 'COMPRADO POR EL BID ', 0),
(147, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMA', '74088037E740', '1', '2024', 'BID 005446', 'COMPRADO POR EL BID ', 0),
(148, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGLR', '74088037E730', '1', '2024', 'BID 005426', 'COMPRADO POR EL BID ', 0),
(149, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMC', '74088037E742', '1', '2024', 'BID 005448', 'COMPRADO POR EL BID ', 0),
(150, 3, 'LENOVO', 'SK-8827', '--', '46XD3WS', '74089500JH47', '1', '2024', 'BID 000396', 'COMPRADO POR EL BID', 0),
(151, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGMR', '74088037E749', '1', '2024', 'BID 005458', 'COMPRADO POR EL BID ', 0),
(152, 2, 'LENOVO', 'THINKVISION E24-30 FLAT PANEL MONITOR', '--', 'VNAAWGN2', '74088037E733', '1', '2024', 'BID 005435', 'COMPRADO POR EL BID ', 0),
(153, 3, 'LENOVO', 'SK-8827', '--', '46XD3WC', '74089500JH79', '1', '2024', 'BID 000448', 'COMPRADO POR EL BID', 0),
(154, 3, 'LENOVO', 'SK-8827', '--', '46XD3W9', '74089500JH60', '1', '2024', 'BID 000410', 'COMPRADO POR EL BID', 0),
(155, 3, 'LENOVO', 'SK-8827', '--', '46XD3WB', '74089500JH73', '1', '2024', 'BID 000436', 'COMPRADO POR EL BID', 0),
(156, 3, 'LENOVO', 'SK-8827', '--', '46XD3VG', '74089500JH68', '1', '2024', 'BID 000426', 'COMPRADO POR EL BID', 0),
(157, 3, 'LENOVO', 'SK-8827', '--', '46XD3VK', '74089500JH71', '1', '2024', 'BID 000432', 'COMPRADO POR EL BID', 0),
(158, 3, 'LENOVO', 'SK-8827', '--', '46XD3WR', '74089500JH75', '1', '2024', 'BID 000440', 'COMPRADO POR EL BID', 0),
(159, 3, 'LENOVO', 'SK-8827', '--', '46XD3WV', '74089500JH76', '1', '2024', 'BID 000442', 'COMPRADO POR EL BID', 0),
(160, 3, 'LENOVO', 'SK-8827', '--', '46XD53G', '74089500JH48', '1', '2024', 'BID 000398', 'COMPRADO POR EL BID', 0),
(161, 3, 'LENOVO', 'SK-8827', '--', '46XD53H', '74089500JH49', '1', '2024', 'BID 000400', 'COMPRADO POR EL BID', 0),
(162, 3, 'LENOVO', 'SK-8827', '--', '46XD3WA', '74089500JH72', '1', '2024', 'BID 000434', 'COMPRADO POR EL BID', 0),
(163, 3, 'LENOVO', 'SK-8827', '--', '46XD3VR', '74089500JH62', '1', '2024', 'BID 000414', 'COMPRADO POR EL BID', 0),
(164, 3, 'LENOVO', 'SK-8827', '--', '46XD3WP', '74089500JH74', '1', '2024', 'BID 000438', 'COMPRADO POR EL BID', 0),
(165, 3, 'LENOVO', 'SK-8827', '--', '46XD4GB', '74089500JH81', '1', '2024', 'BID 001426', 'COMPRADO POR EL BID', 0),
(166, 3, 'LENOVO', 'SK-8827', '--', '46XD3W7', '74089500JH65', '1', '2024', 'BID 000420', 'COMPRADO POR EL BID', 0),
(167, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922362', '1', '2025', 'NEA-00233-2025', 'BID 7266', 0),
(168, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922391', '1', '2025', 'NEA-00233-2025', 'BID9317', 0),
(169, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922361', '1', '2025', 'NEA-00233-2025', 'BID 7262', 0),
(170, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922360', '1', '2025', 'NEA-00233-2025', 'BID 7271', 0),
(171, 12, 'FORZA', 'FVR 1012', '--', '91432408516085', '46225215BE81', '1', '2025', 'NEA-00233-2025', 'BID 8390', 0),
(172, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922388', '1', '2025', 'NEA-00233-2025', 'BID 7291', 0),
(173, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922387', '1', '2025', 'NEA-00233-2025', 'BID 7256', 0),
(174, 12, 'FORZA', 'FVR 1012', '--', '91432408515656', '46225215BE65', '1', '2025', 'NEA-00233-2025', 'BID 8231', 0),
(175, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922385', '1', '2025', 'NEA-00233-2025', 'BID 7292', 0),
(176, 12, 'FORZA', 'FVR 1012', '--', '91432408515659 ', '46225215BE86', '1', '2025', 'NEA-00233-2025', 'BID 8216', 0),
(177, 12, 'FORZA', 'FVR 1012', '--', '91432408515654', '46225215BE58', '1', '2025', 'NEA-00233-2025', 'BID 8225', 0),
(178, 12, 'FORZA', 'FVR 1012', '--', '91432408516092', '46225215BE78', '1', '2025', 'NEA-00233-2025', 'BID 8387', 0),
(179, 12, 'FORZA', 'FVR 1012', '--', '91432408516087 ', '46225215BE75', '1', '2025', 'NEA-00233-2025', 'BID 8384', 0),
(180, 12, 'FORZA', 'FVR 1012', '--', '91432408515646', '46225215BE91', '1', '2025', 'NEA-00233-2025', 'BID 8222', 0),
(181, 12, 'FORZA', 'FVR 1012', '--', '91432408515648', '46225215BE87', '1', '2025', 'NEA-00233-2025', 'BID 8217', 0),
(182, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922384', '1', '2025', 'NEA-00233-2025', 'BID 7270', 0),
(183, 12, 'FORZA', 'FVR 1012', '--', '91432408516081', '46225215BE70', '1', '2025', 'NEA-00233-2025', 'BID 8379', 0),
(184, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922383', '1', '2025', 'NEA-00233-2025', 'BID 9307', 0),
(185, 12, 'FORZA', 'FVR 1012', '--', '91432408516079', '46225215BE82', '1', '2025', 'NEA-00233-2025', 'BID 8391', 0),
(186, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922382', '1', '2025', 'NEA-00233-2025', 'BID 7259', 0),
(187, 12, 'FORZA', 'FVR 1012', '--', '91432408516086', '46225215BE80', '1', '2025', 'NEA-00233-2025', 'BID 8389', 0),
(188, 12, 'FORZA', 'FVR 1012', '--', '91432408516075', '46225215BE67', '1', '2025', 'NEA-00233-2025', 'BID 8376', 0),
(189, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922381', '1', '2025', 'NEA-00233-2025', 'BID 9292', 0),
(190, 12, 'FORZA', 'FVR 1012', '--', '91432408516090 ', '46225215BE77', '1', '2025', 'NEA-00233-2025', 'BID 8386', 0),
(191, 12, 'FORZA', 'FVR 1012', '--', '91432408515647', '46225215BE89', '1', '2025', 'NEA-00233-2025', 'BID 8219', 0),
(192, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922380', '1', '2025', 'NEA-00233-2025', 'BID 7267', 0),
(193, 12, 'FORZA', 'FVR 1012', '--', '91432408515649 ', '46225215BE60', '1', '2025', 'NEA-00233-2025', 'BID 8226', 0),
(194, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922379', '1', '2025', 'NEA-00233-2025', 'BID 7290', 0),
(195, 12, 'FORZA', 'FVR 1012', '--', '91432408515660 ', '46225215BE92', '1', '2025', 'NEA-00233-2025', 'BID 8223', 0),
(196, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922378', '1', '2025', 'NEA-00233-2025', 'BID 7265', 0),
(197, 12, 'FORZA', 'FVR 1012', '--', '91432408515645', '46225215BE90', '1', '2025', 'NEA-00233-2025', 'BID 8221', 0),
(199, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922377', '1', '2025', 'NEA-00233-2025', 'BID 9285', 0),
(200, 12, 'FORZA', 'FVR 1012', '--', '91432408515658', '46225215BE88', '1', '2025', 'NEA-00233-2025', 'BID 8218', 0),
(201, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922376', '1', '2025', 'NEA-00233-2025', 'BID 9287', 0),
(202, 12, 'FORZA', 'FVR 1012', '--', '91432408515643 ', '46225215BE61', '1', '2025', 'NEA-00233-2025', 'BID 8227', 0),
(204, 12, 'FORZA', 'FVR 1012', '--', '91432408516082', '46225215BE71', '1', '2025', 'NEA-00233-2025', 'BID 8380', 0),
(205, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922375', '1', '2025', 'NEA-00233-2025', 'BID 9286', 0),
(206, 12, 'FORZA', 'FVR 1012', '--', '91432408516078', '46225215BE84', '1', '2025', 'NEA-00233-2025', 'BID 8393', 0),
(207, 12, 'FORZA', 'FVR 1012', '--', '91432408516080', '46225215BE69', '1', '2025', 'NEA-00233-2025', 'BID 8378', 0),
(208, 12, 'FORZA', 'FVR 1012', '--', '91432408515651', '46225215BE62', '1', '2025', 'NEA-00233-2025', 'BID 8228', 0),
(209, 12, 'FORZA', 'FVR 1012', '--', '91432408516076', '46225215BE68', '1', '2025', 'NEA-00233-2025', 'BID 8377', 0),
(210, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922374', '1', '2025', 'NEA-00233-2025', 'BID 9290', 0),
(211, 12, 'FORZA', 'FVR 1012', '--', '91432408516084', '46225215BE83', '1', '2025', 'NEA-00233-2025', 'BID 8392', 0),
(212, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922386', '1', '2025', 'NEA-00233-2025', 'BID 9289', 0),
(213, 12, 'FORZA', 'FVR 1012', '--', '91432408516091', '46225215BE79', '1', '2025', 'NEA-00233-2025', 'BID 8388', 0),
(214, 12, 'FORZA', 'FVR 1012', '--', '91432408515652', '46225215BE63', '1', '2025', 'NEA-00233-2025', 'BID 8229', 0),
(215, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922373', '1', '2025', 'NEA-00233-2025', 'BID 7268', 0),
(216, 12, 'FORZA', 'FVR 1012', '--', '91432408515657', '46225215BE85', '1', '2025', 'NEA-00233-2025', 'BID 8215', 0),
(217, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922372', '1', '2025', 'NEA-00233-2025', 'BID 7269', 0),
(218, 12, 'FORZA', 'FVR 1012', '--', '91432408515655 ', '46225215BE66', '1', '2025', 'NEA-00233-2025', 'BID 8232', 0),
(219, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922389', '1', '2025', 'NEA-00233-2025', 'BID 7251', 0),
(220, 12, 'FORZA', 'FVR 1012', '--', '91432408516088 ', '46225215BE76', '1', '2025', 'NEA-00233-2025', 'BID 8385', 0),
(222, 12, 'FORZA', 'FVR 1012', '--', '91432408516083', '46225215BE72', '1', '2025', 'NEA-00233-2025', 'BID 8381', 0),
(223, 12, 'FORZA', 'FVR 1012', '--', '91432408515653', '46225215BE64', '1', '2025', 'NEA-00233-2025', 'BID 8230', 0),
(224, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922390', '1', '2025', 'NEA-00233-2025', 'BID 9291', 0),
(225, 12, 'FORZA', 'FVR 1012', '--', '91432408516077 ', '46225215BE73', '1', '2025', 'NEA-00233-2025', 'BID 8382', 0),
(226, 12, 'FORZA', 'FVR 1012', '--', '91432408515650 ', '46225215BE59', '1', '2025', 'NEA-00233-2025', 'BID 8224', 0),
(227, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922371', '1', '2025', 'NEA-00233-2025', 'BID 7257', 0),
(228, 12, 'FORZA', 'FVR 1012', '--', '91432408516089', '46225215BE74', '1', '2025', 'NEA-00233-2025', 'BID 8383', 0),
(229, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922392', '1', '2025', 'NEA-00233-2025', 'BID 9305', 0),
(230, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922393', '1', '2025', 'NEA-00233-2025', 'BID 7264', 0),
(231, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922394', '1', '2025', 'NEA-00233-2025', 'BID 7263', 0),
(232, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922370', '1', '2025', 'NEA-00233-2025', 'BID 9314', 0),
(233, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922369', '1', '2025', 'NEA-00233-2025', 'BID 7260', 0),
(234, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922368', '1', '2025', 'NEA-00233-2025', 'BID 7255', 0),
(235, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922367', '1', '2025', 'NEA-00233-2025', 'BID 7261', 0),
(236, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922366', '1', '2025', 'NEA-00233-2025', 'BID 7253', 0),
(237, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922365', '1', '2025', 'NEA-00233-2025', 'BID 7252', 0),
(238, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922364', '1', '2025', 'NEA-00233-2025', 'BID 7258', 0),
(239, 11, 'CLIO', 'CLC-1080LIVE', '--', 'S/S', '740899922363', '1', '2025', 'NEA-00233-2025', 'BID 7289', 0),
(240, 18, 'SYMBOL', 'LS2208', '--', 'Z4D2M1', '740863503307', '2', '2022', 'C-02319', 'C-02319-2022', 0),
(241, 12, 'CDP', 'R2C-AVR 1008i', '--', '200920-0902792', '46225215Y931', '1', '2019', '-', 'Ninguna', 0),
(242, 12, 'CDP', 'R2C-AVR 1008i', '--', '200920-0902795', '46225215Y935', '1', '2020', 'O/C-01658-2020', 'NINGUNA', 0),
(243, 12, 'CDP', 'R2C-AVR 1008i', '--', '200920-0902816', '46225215Y943', '1', '2020', 'O/C-01658-2020', 'NINGUNA', 0),
(244, 14, 'SONY', 'ICP-PX370', '--', '1012819', '952245651197', '2', '2020', '0/c-01658', 'Ninguno', 0),
(245, 12, 'CDP', 'R2C-AVR 1008i', '--', '1805150901195', '46225215Y920', '2', '2020', 'O/C-01658', 'Ninguno', 0),
(246, 12, 'CDP', 'R2C-AVR 1008i', '--', '200920-0902773', '46225215Y918', '2', '2020', 'O/C-01658', 'Ninguno', 0);

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
(6, 'Caballococha', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallemovimiento`
--

CREATE TABLE `detallemovimiento` (
  `id_detallemovimiento` int(11) NOT NULL,
  `id_bien_detmov` int(11) NOT NULL,
  `id_mov_detallemovimiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallemovimiento`
--

INSERT INTO `detallemovimiento` (`id_detallemovimiento`, `id_bien_detmov`, `id_mov_detallemovimiento`) VALUES
(66, 18, 20),
(67, 17, 21),
(68, 19, 20),
(69, 20, 20),
(70, 21, 22),
(71, 23, 23),
(72, 22, 24),
(73, 24, 25),
(74, 25, 26),
(75, 26, 27),
(76, 41, 28),
(77, 42, 29),
(78, 43, 30),
(79, 44, 30),
(80, 45, 30),
(81, 46, 31),
(82, 47, 31),
(83, 48, 31),
(84, 49, 32),
(85, 50, 32),
(86, 51, 32),
(87, 52, 32),
(88, 53, 32),
(89, 54, 32),
(90, 55, 33),
(91, 56, 33),
(92, 57, 33),
(93, 59, 34),
(94, 58, 34),
(95, 60, 34),
(96, 61, 35),
(97, 66, 36),
(98, 77, 36),
(99, 74, 36),
(100, 169, 36),
(101, 176, 36),
(102, 62, 36),
(103, 63, 36),
(104, 64, 36),
(105, 167, 36),
(106, 171, 36),
(107, 65, 37),
(108, 72, 37),
(109, 69, 37),
(110, 168, 37),
(111, 174, 37),
(112, 67, 38),
(113, 81, 38),
(114, 80, 38),
(115, 170, 38),
(116, 177, 38),
(117, 68, 39),
(118, 84, 39),
(119, 83, 39),
(120, 172, 39),
(121, 178, 39),
(122, 70, 40),
(123, 91, 40),
(124, 87, 40),
(125, 173, 40),
(126, 179, 40),
(127, 103, 41),
(128, 134, 41),
(129, 154, 41),
(130, 224, 41),
(131, 208, 41),
(132, 71, 42),
(133, 93, 42),
(134, 90, 42),
(135, 175, 42),
(136, 180, 42),
(137, 76, 43),
(138, 105, 43),
(139, 101, 43),
(140, 186, 43),
(141, 185, 43),
(142, 104, 44),
(143, 136, 44),
(144, 155, 44),
(145, 227, 44),
(146, 209, 44),
(147, 73, 45),
(148, 98, 45),
(149, 94, 45),
(150, 182, 45),
(151, 181, 45),
(152, 75, 46),
(153, 102, 46),
(154, 97, 46),
(155, 184, 46),
(156, 183, 46),
(157, 106, 47),
(158, 138, 47),
(159, 156, 47),
(160, 229, 47),
(161, 211, 47),
(165, 110, 49),
(166, 139, 49),
(167, 157, 49),
(168, 230, 49),
(169, 213, 49),
(170, 78, 50),
(171, 108, 50),
(172, 107, 50),
(173, 189, 50),
(174, 187, 50),
(175, 111, 50),
(176, 141, 50),
(177, 158, 50),
(178, 231, 50),
(179, 214, 50),
(181, 119, 51),
(182, 146, 51),
(183, 161, 51),
(184, 234, 51),
(185, 220, 51),
(186, 79, 52),
(187, 109, 52),
(188, 114, 52),
(189, 192, 52),
(190, 188, 52),
(196, 122, 54),
(197, 147, 54),
(198, 162, 54),
(199, 235, 54),
(200, 222, 54),
(201, 82, 55),
(202, 112, 55),
(203, 118, 55),
(204, 194, 55),
(205, 190, 55),
(206, 113, 56),
(207, 143, 56),
(208, 159, 56),
(209, 232, 56),
(210, 216, 56),
(211, 116, 57),
(212, 144, 57),
(213, 160, 57),
(214, 233, 57),
(215, 85, 58),
(216, 115, 58),
(217, 121, 58),
(218, 196, 58),
(219, 191, 58),
(220, 218, 57),
(221, 124, 59),
(222, 148, 59),
(223, 163, 59),
(224, 236, 59),
(225, 223, 59),
(226, 129, 59),
(227, 151, 59),
(228, 165, 59),
(229, 238, 59),
(230, 226, 59),
(231, 126, 60),
(232, 149, 60),
(233, 164, 60),
(234, 237, 60),
(235, 225, 60),
(241, 133, 62),
(242, 152, 62),
(243, 166, 62),
(244, 239, 62),
(245, 228, 62),
(246, 86, 63),
(247, 117, 63),
(248, 128, 63),
(249, 199, 63),
(250, 193, 63),
(251, 96, 60),
(252, 130, 60),
(253, 145, 60),
(254, 215, 60),
(255, 204, 60),
(256, 88, 64),
(257, 120, 64),
(258, 135, 64),
(259, 201, 64),
(260, 195, 64),
(261, 89, 65),
(262, 123, 65),
(263, 137, 65),
(264, 205, 65),
(265, 197, 65),
(266, 92, 66),
(267, 125, 66),
(268, 140, 66),
(269, 210, 66),
(270, 200, 66),
(271, 95, 67),
(272, 127, 67),
(273, 142, 67),
(274, 212, 67),
(275, 202, 67),
(276, 99, 68),
(277, 131, 68),
(278, 150, 68),
(279, 217, 68),
(280, 206, 68),
(281, 100, 69),
(282, 132, 69),
(283, 153, 69),
(284, 219, 69),
(285, 207, 69),
(286, 240, 70),
(287, 23, 71),
(288, 241, 72),
(289, 242, 73),
(290, 244, 74),
(291, 243, 75),
(292, 245, 76),
(293, 246, 77);

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
(6, 2, 'insertar', 'area', 13, '2024-10-14 19:42:35', 'Nueva área agregada: Descripción = ED dominio, Estado = 1'),
(7, 2, 'insertar', 'area', 14, '2024-10-14 19:48:39', 'Nueva área agregada: Descripción = Jip Transitorio, Estado = 1'),
(36, 3, 'Insertar', 'movimiento', 10, '2024-10-17 04:47:10', 'Se ha registrado un nuevo movimiento.'),
(37, 3, 'insertar', 'persona', 5, '2024-10-17 04:48:27', 'Nueva persona agregada: Descripción = Gabril Gipa Marin, 45231256 , Estado = 1'),
(38, 3, 'insertar', 'usuario', 47, '2024-10-17 04:49:17', 'Nuevo usuario agregado: ggipa, Estado = 1'),
(39, 3, 'insertar', 'persona', 6, '2024-10-17 05:44:00', 'Nueva persona agregada: Descripción = Ricardo manuel Prieto Gimenez, 45071104 , Estado = 1'),
(40, 3, 'insertar', 'persona', 7, '2024-10-17 05:45:06', 'Nueva persona agregada: Descripción = Sadith Estrada Fernandez, 87646342 , Estado = 1'),
(41, 3, 'insertar', 'persona', 8, '2024-10-17 05:45:48', 'Nueva persona agregada: Descripción = Alondra Torres Batista, 89674534 , Estado = 1'),
(42, 3, 'insertar', 'persona', 9, '2024-10-17 05:46:27', 'Nueva persona agregada: Descripción = Mishel Quizpe Tuesta, 89657452 , Estado = 1'),
(43, 3, 'insertar', 'persona', 10, '2024-10-17 05:47:11', 'Nueva persona agregada: Descripción = Alexy Silvano Carrillo, 04566898 , Estado = 1'),
(44, 3, 'insertar', 'persona', 11, '2024-10-17 05:47:40', 'Nueva persona agregada: Descripción = Matin Diaz Nolazco, 78452312 , Estado = 1'),
(45, 3, 'insertar', 'persona', 12, '2024-10-17 05:50:36', 'Nueva persona agregada: Descripción = Martin Mori Caballero, 76434534 , Estado = 1'),
(46, 3, 'insertar', 'bien', 10, '2024-10-21 04:15:32', 'Nueva bien agregado: Descripción = Monitor, CCC!7, 77778'),
(47, 3, 'insertar', 'bien', 11, '2024-10-21 04:16:25', 'Nueva bien agregado: Descripción = Monitor, CCC!8, 77779'),
(48, 3, 'insertar', 'bien', 12, '2024-10-21 04:17:30', 'Nueva bien agregado: Descripción = Monitor, CCC!9, 77710'),
(49, 3, 'insertar', 'bien', 13, '2024-10-21 04:19:24', 'Nueva bien agregado: Descripción = CPU, CBC!9, 77711'),
(50, 3, 'insertar', 'bien', 14, '2024-10-21 04:21:47', 'Nueva bien agregado: Descripción = Teclado, CCC!T6, 77773T1'),
(51, 3, 'insertar', 'bien', 15, '2024-10-21 04:22:20', 'Nueva bien agregado: Descripción = Teclado, CCC!1T4, 77771T5'),
(52, 3, 'insertar', 'bien', 16, '2024-10-21 04:22:49', 'Nueva bien agregado: Descripción = Audífono, CCC!T6AU, 77711AU'),
(53, 3, 'Insertar', 'movimiento', 11, '2024-10-22 04:54:24', 'Se ha registrado un nuevo movimiento.'),
(54, 3, 'Insertar', 'movimiento', 12, '2024-10-30 05:10:05', 'Se ha registrado un nuevo movimiento.'),
(55, 3, 'Insertar', 'movimiento', 13, '2024-10-30 05:12:05', 'Se ha registrado un nuevo movimiento.'),
(56, 3, 'Insertar', 'movimiento', 14, '2024-11-01 19:08:09', 'Se ha registrado un nuevo movimiento.'),
(57, 3, 'Insertar', 'movimiento', 15, '2024-11-02 04:58:12', 'Se ha registrado un nuevo movimiento.'),
(58, 3, 'Insertar', 'movimiento', 16, '2024-11-02 06:10:27', 'Se ha registrado un nuevo movimiento.'),
(59, 3, 'Insertar', 'movimiento', 17, '2024-11-02 06:10:47', 'Se ha registrado un nuevo movimiento.'),
(60, 3, 'Insertar', 'movimiento', 18, '2024-11-11 21:14:50', 'Se ha registrado un nuevo movimiento.'),
(61, 3, 'Insertar', 'movimiento', 19, '2024-11-11 21:20:20', 'Se ha registrado un nuevo movimiento.'),
(62, 2, 'insertar', 'bien', 17, '2024-11-12 15:53:45', 'Nueva bien agregado: Descripción = LAPTOP, PF28DZBC, 740805003302'),
(63, 2, 'insertar', 'bien', 18, '2024-11-12 15:55:53', 'Nueva bien agregado: Descripción = CPU, MXL5282S3K, 74089950AQ14'),
(64, 2, 'insertar', 'persona', 13, '2024-11-12 15:58:14', 'Nueva persona agregada: Descripción = TELLO DANTAS GINO , 41852379 , Estado = 1'),
(65, 2, 'insertar', 'persona', 14, '2024-11-12 15:59:45', 'Nueva persona agregada: Descripción = HUGO CLAY TIBURCIO COLLANTES, 10269301 , Estado = 1'),
(66, 2, 'Insertar', 'movimiento', 20, '2024-11-12 16:02:56', 'Se ha registrado un nuevo movimiento.'),
(67, 2, 'Insertar', 'movimiento', 21, '2024-11-12 16:04:00', 'Se ha registrado un nuevo movimiento.'),
(68, 2, 'insertar', 'bien', 19, '2024-11-12 16:38:15', 'Nueva bien agregado: Descripción = TECLADO, UL2118302672, 740895500PNDT'),
(69, 2, 'insertar', 'bien', 20, '2024-11-12 16:51:32', 'Nueva bien agregado: Descripción = MONITOR, D170519ENGD4200318, 740880375766'),
(70, NULL, 'Actualizar', 'movimiento', 21, '2024-11-12 19:25:14', 'Se ha actualizado el PDF del movimiento.'),
(71, NULL, 'Actualizar', 'movimiento', 21, '2024-11-12 19:25:14', 'Se ha actualizado el PDF del movimiento.'),
(72, NULL, 'Actualizar', 'movimiento', 21, '2024-11-12 19:25:14', 'Se ha actualizado el PDF del movimiento.'),
(73, NULL, 'Actualizar', 'movimiento', 21, '2024-11-12 19:25:14', 'Se ha actualizado el PDF del movimiento.'),
(74, 3, 'Actualizar', 'movimiento', 20, '2024-11-12 19:26:49', 'Se ha actualizado el PDF del movimiento.'),
(75, 2, 'insertar', 'bien', 21, '2024-11-13 13:50:43', 'Nueva bien agregado: Descripción = GRABADORA DIGITAL, 1011662, 952245651208'),
(76, 2, 'insertar', 'persona', 15, '2024-11-13 13:55:05', 'Nueva persona agregada: Descripción = MARJORIE ZULEIKA PASQUEL GARCIA, 40041614 , Estado = 1'),
(77, 2, 'insertar', 'area', 16, '2024-11-13 14:00:13', 'Nueva área agregada: Descripción = PRIMERJUZGADO PENAL UNIPERSONAL SUPRAPROVINCIAL TRANSITORIO, Estado = 1'),
(78, 2, 'Insertar', 'movimiento', 22, '2024-11-13 14:01:04', 'Se ha registrado un nuevo movimiento.'),
(79, 3, 'Actualizar', 'movimiento', 22, '2024-11-13 17:10:59', 'Se ha actualizado el PDF del movimiento.'),
(80, 3, 'Actualizar', 'movimiento', 22, '2024-11-13 17:10:59', 'Se ha actualizado el PDF del movimiento.'),
(81, 3, 'Actualizar', 'movimiento', 22, '2024-11-13 17:10:59', 'Se ha actualizado el PDF del movimiento.'),
(82, 2, 'insertar', 'persona', 16, '2024-11-13 17:23:56', 'Nueva persona agregada: Descripción =  JOHNNY ALEXANDER VELA COLLAZOS, 70751018 , Estado = 1'),
(83, 2, 'insertar', 'persona', 17, '2024-11-13 17:29:19', 'Nueva persona agregada: Descripción = DILVER ABEL CHOCTALIN TAUMA , 72810712 , Estado = 1'),
(84, 2, 'insertar', 'bien', 22, '2024-11-13 17:40:03', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 180620-1065252, 46225215X976'),
(85, 2, 'insertar', 'bien', 23, '2024-11-13 17:43:37', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 190225-0903913 , 46225215Y911'),
(86, 2, 'Insertar', 'movimiento', 23, '2024-11-13 17:44:58', 'Se ha registrado un nuevo movimiento.'),
(87, 2, 'Insertar', 'movimiento', 24, '2024-11-13 17:45:53', 'Se ha registrado un nuevo movimiento.'),
(88, 2, 'insertar', 'area', 17, '2024-11-14 17:21:39', 'Nueva área agregada: Descripción = TERCER JUZGADO DE INVESTIGACIÓN PREPARATORIA , Estado = 1'),
(89, 2, 'insertar', 'area', 18, '2024-11-14 17:21:49', 'Nueva área agregada: Descripción = PRIMER JUZGADO PENAL UNIPERSONAL SUPRAPROVINCIAL TRANSITORIO, Estado = 1'),
(90, 2, 'insertar', 'area', 19, '2024-11-14 17:22:01', 'Nueva área agregada: Descripción = QUINTO JUZGADO DE INVESTIGACIÓN PREPARATORIA, Estado = 1'),
(91, 2, 'insertar', 'area', 20, '2024-11-14 17:22:10', 'Nueva área agregada: Descripción = ADMINISTRACIÓN, Estado = 1'),
(92, 2, 'insertar', 'area', 21, '2024-11-14 17:22:17', 'Nueva área agregada: Descripción = PRIMER JUZGADO UNIPERSONAL TRANSITORIO, Estado = 1'),
(93, 2, 'insertar', 'area', 22, '2024-11-14 17:22:23', 'Nueva área agregada: Descripción = SEGUNDO JUZGADO DE INVESTIGACIÓN PREPARATORIA, Estado = 1'),
(94, 2, 'insertar', 'area', 23, '2024-11-14 17:22:32', 'Nueva área agregada: Descripción = CUARTO JUZGADO DE INVESTIGACIÓN PREPARATORIA, Estado = 1'),
(95, 2, 'insertar', 'area', 24, '2024-11-14 17:22:41', 'Nueva área agregada: Descripción = JUZGADO DE INVESTIGACIÓN PREPARATORIA TRANSITORIO, Estado = 1'),
(96, 2, 'insertar', 'area', 25, '2024-11-14 17:22:52', 'Nueva área agregada: Descripción = SEGUNDO JUZGADO UNIPERSONAL, Estado = 1'),
(97, 2, 'insertar', 'area', 26, '2024-11-14 17:22:58', 'Nueva área agregada: Descripción = EXTINSIÓN DE DOMINIO, Estado = 1'),
(98, 2, 'insertar', 'area', 27, '2024-11-14 17:23:04', 'Nueva área agregada: Descripción = JUZGADO DE NAUTA, Estado = 1'),
(99, 2, 'insertar', 'area', 28, '2024-11-14 17:23:11', 'Nueva área agregada: Descripción = PRIMER JUZGADO UNIPERSONAL, Estado = 1'),
(100, 2, 'insertar', 'area', 29, '2024-11-14 17:23:19', 'Nueva área agregada: Descripción = SEGUNDO JUZGADO UNIPERSONAL TRANSITORIO , Estado = 1'),
(101, 2, 'insertar', 'area', 30, '2024-11-14 17:23:28', 'Nueva área agregada: Descripción = TERCER JUZGADO UNIPERSONAL, Estado = 1'),
(102, 2, 'insertar', 'area', 31, '2024-11-14 17:23:35', 'Nueva área agregada: Descripción = PRIMER JUZGADO DE INVESTIGACIÓN PREPARATORIA , Estado = 1'),
(103, 2, 'insertar', 'area', 32, '2024-11-14 17:23:41', 'Nueva área agregada: Descripción = PENAL DE AVARONES, Estado = 1'),
(104, 2, 'insertar', 'area', 33, '2024-11-14 17:23:49', 'Nueva área agregada: Descripción = JUZGADO PENAL COLEGIADO SUPRAPROVINCIAL TRANSITORIO, Estado = 1'),
(105, 2, 'insertar', 'area', 34, '2024-11-14 17:23:55', 'Nueva área agregada: Descripción = CAMARA GESELL, Estado = 1'),
(106, 2, 'insertar', 'area', 35, '2024-11-14 17:24:02', 'Nueva área agregada: Descripción = CUSTODIA DE EXPEDIENTES, Estado = 1'),
(107, 2, 'insertar', 'area', 36, '2024-11-14 17:24:09', 'Nueva área agregada: Descripción = SEGUNDA SALA PENAL DE APELACIONES EN ADICION A LIQUIDADORA, Estado = 1'),
(108, 2, 'insertar', 'area', 37, '2024-11-14 17:24:18', 'Nueva área agregada: Descripción = ESTABLECIMIENTO PENITENCIARIO PENAL DE VARONES, Estado = 1'),
(109, 2, 'insertar', 'area', 38, '2024-11-14 17:24:24', 'Nueva área agregada: Descripción = MESA DE PARTES , Estado = 1'),
(110, 2, 'insertar', 'dependencia', 6, '2024-11-14 17:27:50', 'Nueva dependencia agregada: Descripción = CABALLOCOCHA, Estado = 1'),
(111, 2, 'insertar', 'usuario', 48, '2024-11-19 13:57:02', 'Nuevo usuario agregado: jvasquez, Estado = 3'),
(112, 2, 'insertar', 'persona', 18, '2024-11-20 16:05:08', 'Nueva persona agregada: Descripción = SOTO QUINTANILLA ERIKA, 44968676 , Estado = 1'),
(113, 2, 'insertar', 'bien', 24, '2024-11-20 16:25:19', 'Nueva bien agregado: Descripción = AUDIFONOS PROFESIONALES, MI4022-208209, 952210701553'),
(114, 2, 'Insertar', 'movimiento', 25, '2024-11-20 16:26:11', 'Se ha registrado un nuevo movimiento.'),
(115, 2, 'insertar', 'persona', 19, '2024-11-20 16:52:55', 'Nueva persona agregada: Descripción = RAMIREZ ARREGUI MICHEL ANGELO, 70271700 , Estado = 1'),
(116, 2, 'insertar', 'bien', 25, '2024-11-20 16:59:59', 'Nueva bien agregado: Descripción = GRABADORA DIGITAL, 1011664, 952245651196'),
(117, 2, 'Insertar', 'movimiento', 26, '2024-11-20 17:02:48', 'Se ha registrado un nuevo movimiento.'),
(118, 2, 'insertar', 'persona', 20, '2024-11-21 14:34:44', 'Nueva persona agregada: Descripción = Dolly Smiht Alvarado Lazo  , 05373352 , Estado = 1'),
(119, 2, 'insertar', 'persona', 21, '2024-11-21 14:37:27', 'Nueva persona agregada: Descripción = Daniela Villacorta Barbaran , 44834948 , Estado = 1'),
(120, 2, 'insertar', 'persona', 22, '2024-11-21 14:39:45', 'Nueva persona agregada: Descripción = Eddier Rojas Linares , 05338887 , Estado = 1'),
(121, 2, 'insertar', 'persona', 23, '2024-11-21 15:09:13', 'Nueva persona agregada: Descripción = Alex Antonio Valdez Marrou, 70651824 , Estado = 1'),
(122, 3, 'insertar', 'usuario', 49, '2024-11-21 15:16:02', 'Nuevo usuario agregado: htiburcioc, Estado = 1'),
(123, 2, 'insertar', 'persona', 24, '2024-11-21 15:16:20', 'Nueva persona agregada: Descripción = Francisco Javier Soplin Escudero , 70748525 , Estado = 1'),
(124, 2, 'insertar', 'persona', 25, '2024-11-21 15:57:56', 'Nueva persona agregada: Descripción = Sheyla Talhia Rojas Ihuaraqui , 45300214 , Estado = 1'),
(125, 2, 'insertar', 'persona', 26, '2024-11-21 16:01:28', 'Nueva persona agregada: Descripción = Martha Indira De Los Santos Vilchez , 44278812 , Estado = 1'),
(126, 2, 'insertar', 'persona', 27, '2024-11-21 16:03:36', 'Nueva persona agregada: Descripción = Maria Del Carmen Ruck Sanchez , 05380528 , Estado = 1'),
(127, 2, 'insertar', 'persona', 28, '2024-11-21 16:47:12', 'Nueva persona agregada: Descripción = Angie Lianhell Perez Macedo , 72513368 , Estado = 1'),
(128, 2, 'insertar', 'persona', 29, '2024-11-21 16:50:49', 'Nueva persona agregada: Descripción = Betti Ramirez Gutierrez , 05266650 , Estado = 1'),
(129, 2, 'Actualizar', 'movimiento', 26, '2024-11-21 16:52:22', 'Se ha actualizado el PDF del movimiento.'),
(130, 2, 'Actualizar', 'movimiento', 26, '2024-11-21 16:52:22', 'Se ha actualizado el PDF del movimiento.'),
(131, 2, 'Actualizar', 'movimiento', 25, '2024-11-21 16:53:14', 'Se ha actualizado el PDF del movimiento.'),
(132, 2, 'Actualizar', 'movimiento', 25, '2024-11-21 16:53:14', 'Se ha actualizado el PDF del movimiento.'),
(133, 2, 'Actualizar', 'movimiento', 23, '2024-11-21 16:53:41', 'Se ha actualizado el PDF del movimiento.'),
(134, 2, 'Actualizar', 'movimiento', 23, '2024-11-21 16:53:41', 'Se ha actualizado el PDF del movimiento.'),
(135, 2, 'Actualizar', 'movimiento', 24, '2024-11-21 16:54:07', 'Se ha actualizado el PDF del movimiento.'),
(136, 2, 'Actualizar', 'movimiento', 24, '2024-11-21 16:54:07', 'Se ha actualizado el PDF del movimiento.'),
(137, 2, 'insertar', 'persona', 30, '2024-11-21 17:00:29', 'Nueva persona agregada: Descripción = Luz Rosenda Maldonado Garay , 23016474 , Estado = 1'),
(138, 2, 'insertar', 'persona', 31, '2024-11-21 17:02:05', 'Nueva persona agregada: Descripción = Ximena Pinedo Chavez , 72283037 , Estado = 1'),
(139, 2, 'insertar', 'persona', 32, '2024-11-21 17:03:56', 'Nueva persona agregada: Descripción = Johans Igor Diaz Melendez , 45356873 , Estado = 1'),
(140, 2, 'insertar', 'persona', 33, '2024-11-21 17:05:46', 'Nueva persona agregada: Descripción = Erick Edwin Solsol Cespedes , 41885434 , Estado = 1'),
(141, 2, 'insertar', 'persona', 34, '2024-11-21 17:07:27', 'Nueva persona agregada: Descripción = Moises Leonardo Racchumick Castillo, 72737271 , Estado = 1'),
(142, 2, 'insertar', 'persona', 35, '2024-11-21 17:10:06', 'Nueva persona agregada: Descripción = Ximena Karina Garcia Lopez, 40244228 , Estado = 1'),
(143, 2, 'insertar', 'persona', 36, '2024-11-21 17:12:07', 'Nueva persona agregada: Descripción = Jorge Luis Pasquel Curitima , 48371122 , Estado = 1'),
(144, 2, 'insertar', 'persona', 37, '2024-11-21 17:16:39', 'Nueva persona agregada: Descripción = Cusy Carolina Reategui Malafaya , 71113370 , Estado = 1'),
(145, 2, 'insertar', 'persona', 38, '2024-11-21 17:18:41', 'Nueva persona agregada: Descripción = Jairo Neyser Salazar Angulo , 42772071 , Estado = 1'),
(146, 2, 'insertar', 'persona', 39, '2024-11-21 17:21:01', 'Nueva persona agregada: Descripción = Fernando Villegas Nuñez, 47432487 , Estado = 1'),
(147, 2, 'insertar', 'persona', 40, '2024-11-21 17:23:30', 'Nueva persona agregada: Descripción = Nidia Shirley Lozano Aspajo, 71245304 , Estado = 1'),
(148, 2, 'insertar', 'persona', 41, '2024-11-21 17:34:55', 'Nueva persona agregada: Descripción = Allison Paulina Vargas Silva , 76601828 , Estado = 1'),
(149, 2, 'insertar', 'persona', 42, '2024-11-21 17:43:59', 'Nueva persona agregada: Descripción = Grace Wendy Pacaya Garcia , 41885426 , Estado = 1'),
(150, 2, 'insertar', 'persona', 43, '2024-11-21 17:46:01', 'Nueva persona agregada: Descripción = Gianira Mercedes Valera Diaz , 43619702 , Estado = 1'),
(151, 2, 'insertar', 'persona', 44, '2024-11-22 15:56:53', 'Nueva persona agregada: Descripción = Andrea Del Pilar Chuquipiondo Sanchez , 71777766 , Estado = 1'),
(152, 2, 'insertar', 'persona', 45, '2024-11-22 16:03:53', 'Nueva persona agregada: Descripción = Jhovany Vasquez Huaman, 42720755 , Estado = 1'),
(153, 2, 'insertar', 'persona', 46, '2024-11-22 16:20:10', 'Nueva persona agregada: Descripción = Karen Vanessa Rios Guzman   , 40333618 , Estado = 1'),
(154, 2, 'insertar', 'persona', 47, '2024-11-22 16:54:28', 'Nueva persona agregada: Descripción = Alondra Pierina Villacorta Ramirez, 75816086 , Estado = 1'),
(155, 2, 'insertar', 'persona', 48, '2024-11-22 16:55:41', 'Nueva persona agregada: Descripción = Juan Abelardo Chiong Amasifuen , 43708065 , Estado = 1'),
(156, 2, 'insertar', 'persona', 49, '2024-11-22 17:00:55', 'Nueva persona agregada: Descripción = Jessica Gisela Olortegui Cumari , 71584673 , Estado = 1'),
(157, 2, 'insertar', 'persona', 50, '2024-11-22 17:13:44', 'Nueva persona agregada: Descripción = Gilda Eloisa Hidalgo Chavez , 05416105 , Estado = 1'),
(158, 2, 'insertar', 'persona', 51, '2024-11-22 17:19:13', 'Nueva persona agregada: Descripción = Victor Raul Ramirez Vela , 05265686 , Estado = 1'),
(159, 2, 'insertar', 'persona', 52, '2024-11-22 17:20:33', 'Nueva persona agregada: Descripción = Issis Arletty Mavila Hurtado , 40868730 , Estado = 1'),
(160, 2, 'insertar', 'persona', 53, '2024-11-22 17:22:05', 'Nueva persona agregada: Descripción = Alixey Swidin Aguirre , 46537071 , Estado = 1'),
(161, 2, 'insertar', 'persona', 54, '2024-11-22 17:35:34', 'Nueva persona agregada: Descripción = Julio Cesar Modesto Davila, 40806799 , Estado = 1'),
(162, 2, 'insertar', 'persona', 55, '2024-11-22 17:38:22', 'Nueva persona agregada: Descripción = Dayana Kanylu Andia Alosilla , 46596859 , Estado = 1'),
(163, 2, 'insertar', 'persona', 56, '2024-11-22 17:41:12', 'Nueva persona agregada: Descripción = Tania Elena Niño De Guzman Vilca, 46642985 , Estado = 1'),
(164, 2, 'insertar', 'persona', 57, '2024-11-22 17:46:47', 'Nueva persona agregada: Descripción = Samuel Martin Soldevilla Escudero , 41750718 , Estado = 1'),
(165, 2, 'insertar', 'persona', 58, '2024-11-22 17:55:31', 'Nueva persona agregada: Descripción = Jose Neil Chumbe Silva , 05417100 , Estado = 1'),
(166, 2, 'insertar', 'persona', 59, '2024-11-22 17:57:42', 'Nueva persona agregada: Descripción = Karen Jemima Gonzales Cury, 71307805 , Estado = 1'),
(167, 2, 'insertar', 'persona', 60, '2024-11-25 13:14:06', 'Nueva persona agregada: Descripción = Katherine Patricia Silva Wong , 74317865 , Estado = 1'),
(168, 2, 'insertar', 'persona', 61, '2024-11-25 13:17:44', 'Nueva persona agregada: Descripción = Jorge Stalin Macedo Piña, 72288201 , Estado = 1'),
(169, 2, 'insertar', 'persona', 62, '2024-11-25 13:20:00', 'Nueva persona agregada: Descripción = Ana Paula Fernandez Gonzales , 72899677 , Estado = 1'),
(170, 2, 'insertar', 'persona', 63, '2024-11-25 13:22:08', 'Nueva persona agregada: Descripción = Manuel Humberto Guillermo Felipe, 19187634 , Estado = 1'),
(171, 2, 'insertar', 'persona', 64, '2024-11-25 13:24:13', 'Nueva persona agregada: Descripción = Anibal Segundo Tapia Flores , 16658606 , Estado = 1'),
(172, 2, 'insertar', 'persona', 65, '2024-11-25 13:26:00', 'Nueva persona agregada: Descripción = Wendy Guerra Fasabi , 73416036 , Estado = 1'),
(173, 2, 'insertar', 'persona', 66, '2024-11-25 13:28:20', 'Nueva persona agregada: Descripción = Neper Socrates Gil Macedo , 05335589 , Estado = 1'),
(174, 2, 'insertar', 'persona', 67, '2024-11-25 13:30:31', 'Nueva persona agregada: Descripción = Omar Saul Cabrera Altamirano , 10633806 , Estado = 1'),
(175, 2, 'insertar', 'persona', 68, '2024-11-25 13:31:56', 'Nueva persona agregada: Descripción = Veronica Atenas Castro Huaman , 45086989 , Estado = 1'),
(176, 2, 'insertar', 'persona', 69, '2024-11-25 14:01:09', 'Nueva persona agregada: Descripción = Iris Alina Sampertegui Tapullima , 73106014 , Estado = 1'),
(177, 2, 'insertar', 'persona', 70, '2024-11-25 14:13:14', 'Nueva persona agregada: Descripción = Asiria Fiorella Tucto Coriat , 74093980 , Estado = 1'),
(178, 2, 'insertar', 'persona', 71, '2024-11-25 14:14:56', 'Nueva persona agregada: Descripción = Percy Enrique Cardenas Rodriguez , 41761697 , Estado = 1'),
(179, 2, 'insertar', 'persona', 72, '2024-11-25 15:13:47', 'Nueva persona agregada: Descripción = Keiko Liria Perez Parano, 73059523 , Estado = 1'),
(180, 2, 'insertar', 'persona', 73, '2024-11-25 15:15:25', 'Nueva persona agregada: Descripción = Agui Nataly Montalvan Flores , 44555039 , Estado = 1'),
(181, 2, 'insertar', 'persona', 74, '2024-11-25 15:17:16', 'Nueva persona agregada: Descripción = Oseas Lucas Augusto Wong Rojas , 70600495 , Estado = 1'),
(182, 2, 'insertar', 'persona', 75, '2024-11-25 15:18:51', 'Nueva persona agregada: Descripción = Augusto Guerra Rojas , 05402424 , Estado = 1'),
(183, 2, 'insertar', 'persona', 76, '2024-11-25 15:27:37', 'Nueva persona agregada: Descripción = Karla Victoria Rengifo Rengifo , 44988411 , Estado = 1'),
(184, 2, 'insertar', 'persona', 77, '2024-11-25 15:29:16', 'Nueva persona agregada: Descripción = Zully Rengifo Rinaby , 05410112 , Estado = 1'),
(185, 2, 'insertar', 'persona', 78, '2024-11-25 15:30:57', 'Nueva persona agregada: Descripción = Claudia Vela Rengifo, 41182972 , Estado = 1'),
(186, 2, 'insertar', 'persona', 79, '2024-11-25 15:41:00', 'Nueva persona agregada: Descripción = Gamaniel Gonzalo Laulate Lozano , 41638984 , Estado = 1'),
(187, 2, 'insertar', 'persona', 80, '2024-11-25 15:42:51', 'Nueva persona agregada: Descripción = Gabriel Taricuarima Perea, 41728131 , Estado = 1'),
(188, 2, 'insertar', 'persona', 81, '2024-11-25 15:44:48', 'Nueva persona agregada: Descripción = Lesly Jannina Montani Baca , 05410233 , Estado = 1'),
(189, 2, 'insertar', 'persona', 82, '2024-11-25 15:47:06', 'Nueva persona agregada: Descripción = Franz Richet Velasquez Aricari , 42660473 , Estado = 1'),
(190, 2, 'insertar', 'persona', 83, '2024-11-25 15:48:51', 'Nueva persona agregada: Descripción = Maria Cecilia Ruiz Fernandez , 05370187 , Estado = 1'),
(191, 2, 'insertar', 'persona', 84, '2024-11-25 15:50:39', 'Nueva persona agregada: Descripción = Maria Esther Ruiz Bazalar , 42405447 , Estado = 1'),
(192, 2, 'insertar', 'persona', 85, '2024-11-25 15:52:32', 'Nueva persona agregada: Descripción = Karen Vanessa Rios Guzman , 40333618 , Estado = 1'),
(193, 2, 'insertar', 'persona', 86, '2024-11-25 16:06:14', 'Nueva persona agregada: Descripción = Vanessa Guerra Maca , 47844386 , Estado = 1'),
(194, 2, 'insertar', 'persona', 87, '2024-11-25 16:17:27', 'Nueva persona agregada: Descripción = Eldi Marina Sias Peña, 05229307 , Estado = 1'),
(195, 2, 'insertar', 'persona', 88, '2024-11-25 16:20:34', 'Nueva persona agregada: Descripción = Stephanny Geraldine Nadir Ortiz Cruz, 72650610 , Estado = 1'),
(196, 2, 'insertar', 'persona', 89, '2024-11-25 16:25:11', 'Nueva persona agregada: Descripción = Sonia Patricia Gutierrez Tafur , 05316572 , Estado = 1'),
(197, 2, 'insertar', 'persona', 90, '2024-11-25 16:32:39', 'Nueva persona agregada: Descripción = Carlos Enrique Huari Mendoza , 08844854 , Estado = 1'),
(198, 2, 'insertar', 'persona', 91, '2024-11-25 16:45:44', 'Nueva persona agregada: Descripción = Ana Elizabeth Silva More , 45711960 , Estado = 1'),
(199, 2, 'insertar', 'persona', 92, '2024-11-25 17:11:24', 'Nueva persona agregada: Descripción = Magda Lisbeth Venancino Elaluf , 71208040 , Estado = 1'),
(200, 2, 'insertar', 'persona', 93, '2024-11-25 17:14:04', 'Nueva persona agregada: Descripción = Judith Gisela Toro Guevara , 46215178 , Estado = 1'),
(201, 2, 'insertar', 'persona', 94, '2024-11-25 17:19:42', 'Nueva persona agregada: Descripción = Milton Ronald Melendez Cobos , 05365345 , Estado = 1'),
(202, 2, 'insertar', 'persona', 95, '2024-11-26 14:13:13', 'Nueva persona agregada: Descripción = Edgar Ramon Guillen Vallejo , 42463286 , Estado = 1'),
(203, 2, 'insertar', 'persona', 96, '2024-11-26 14:15:06', 'Nueva persona agregada: Descripción = William Jhonatan Caceres Alfaro , 46277120 , Estado = 1'),
(204, 2, 'insertar', 'persona', 97, '2024-11-26 14:17:43', 'Nueva persona agregada: Descripción = Anita Valeria Acho Arevalo , 70542689 , Estado = 1'),
(205, 2, 'insertar', 'persona', 98, '2024-11-26 14:21:16', 'Nueva persona agregada: Descripción = Anayka Helany Torres Padilla , 48717866 , Estado = 1'),
(206, 2, 'insertar', 'persona', 99, '2024-11-26 14:22:54', 'Nueva persona agregada: Descripción = Adriana Scheherazade Estrada Fernandez , 48140032 , Estado = 1'),
(207, 2, 'insertar', 'persona', 100, '2024-11-26 14:25:08', 'Nueva persona agregada: Descripción = Mario Rene Diaz Diaz , 05392929 , Estado = 1'),
(208, 2, 'insertar', 'persona', 101, '2024-11-26 14:27:21', 'Nueva persona agregada: Descripción = Martha Junelly Marin Garcia , 71563678 , Estado = 1'),
(209, 2, 'insertar', 'persona', 102, '2024-11-26 14:29:03', 'Nueva persona agregada: Descripción = Dennis Tello Marapara , 40021826 , Estado = 1'),
(210, 2, 'insertar', 'persona', 103, '2024-11-26 14:30:42', 'Nueva persona agregada: Descripción = Alberth Martin Benavides Panduro , 05392406 , Estado = 1'),
(211, 2, 'insertar', 'persona', 104, '2024-11-26 14:32:42', 'Nueva persona agregada: Descripción = Jose Sinclair Seminario Seminario , 03381094 , Estado = 1'),
(212, 2, 'insertar', 'persona', 105, '2024-11-26 14:34:15', 'Nueva persona agregada: Descripción = Andrea Lopez Urresti , 43834887 , Estado = 1'),
(213, 2, 'insertar', 'persona', 106, '2024-11-26 14:36:09', 'Nueva persona agregada: Descripción = Victor Alejandro Balarezo Diaz , 40770709 , Estado = 1'),
(214, 2, 'insertar', 'persona', 107, '2024-11-26 14:43:40', 'Nueva persona agregada: Descripción = Nathaly Ornella Sangama Sajami , 40939517 , Estado = 1'),
(215, 2, 'insertar', 'persona', 108, '2024-11-26 14:45:31', 'Nueva persona agregada: Descripción = Cinthia Del Pilar Cespedes Rodriguez , 70496100 , Estado = 1'),
(216, 2, 'insertar', 'persona', 109, '2024-11-26 14:47:50', 'Nueva persona agregada: Descripción = Bethy Vilma Palomino Pedraza , 23957282 , Estado = 1'),
(217, 2, 'insertar', 'persona', 110, '2024-11-26 14:53:12', 'Nueva persona agregada: Descripción = Nelly Lilian Lima Gutierrez , 05278769 , Estado = 1'),
(218, 2, 'insertar', 'persona', 111, '2024-11-26 14:54:56', 'Nueva persona agregada: Descripción = Ketty Gutierrez Ore , 40323397 , Estado = 1'),
(219, 2, 'insertar', 'persona', 112, '2024-11-26 16:11:52', 'Nueva persona agregada: Descripción = Carlos Alberto Del Pielago Cardenas , 08704656 , Estado = 1'),
(220, 2, 'insertar', 'persona', 113, '2024-11-26 16:13:46', 'Nueva persona agregada: Descripción = Petty Regina Ruiz Tenazoa , 47193801 , Estado = 1'),
(221, 2, 'insertar', 'persona', 114, '2024-11-26 16:15:28', 'Nueva persona agregada: Descripción = Elena Rocio Guerrero Roque , 72786603 , Estado = 1'),
(222, 2, 'insertar', 'persona', 115, '2024-11-26 16:17:05', 'Nueva persona agregada: Descripción = Roxana Karina Argomedo Obeso , 05365785 , Estado = 1'),
(223, 2, 'insertar', 'bien', 26, '2024-11-26 16:30:52', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 200920-0902782, 46225215Y912'),
(224, 2, 'Insertar', 'movimiento', 27, '2024-11-26 16:31:56', 'Se ha registrado un nuevo movimiento.'),
(225, 2, 'insertar', 'persona', 116, '2024-11-26 16:34:47', 'Nueva persona agregada: Descripción = Evelyn Odaliz Yoxuni Zevallos Mora , 70763540 , Estado = 1'),
(226, 2, 'insertar', 'persona', 117, '2024-11-26 16:36:43', 'Nueva persona agregada: Descripción = Aldo Nervo Atarama Lonzoy , 05373094 , Estado = 1'),
(227, 2, 'insertar', 'persona', 118, '2024-11-26 16:38:30', 'Nueva persona agregada: Descripción = Natasha Prokopiuk Otero , 40187693 , Estado = 1'),
(228, 2, 'insertar', 'persona', 119, '2024-11-26 16:40:37', 'Nueva persona agregada: Descripción = Pascual Ceberino Del Rosario Cornejo , 06697743 , Estado = 1'),
(229, 2, 'insertar', 'persona', 120, '2024-11-26 16:46:19', 'Nueva persona agregada: Descripción = Guillermo Arturo Bendezu Cigaran , 06017889 , Estado = 1'),
(230, 2, 'insertar', 'persona', 121, '2024-11-26 16:48:34', 'Nueva persona agregada: Descripción = Jean Pierre Laydacker Rivas Mestanza , 45598101 , Estado = 1'),
(231, 2, 'insertar', 'persona', 122, '2024-11-26 16:51:43', 'Nueva persona agregada: Descripción = Greysi Valeria Gonzales Valdivia , 46024011 , Estado = 1'),
(232, 2, 'insertar', 'persona', 123, '2024-11-26 16:53:48', 'Nueva persona agregada: Descripción = Ana Chamoli Ruiz , 43771553 , Estado = 1'),
(233, 2, 'insertar', 'persona', 124, '2024-11-26 16:56:13', 'Nueva persona agregada: Descripción = Jorge Ruy Llerena Solano , 45295043 , Estado = 1'),
(234, 2, 'insertar', 'persona', 125, '2024-11-26 16:58:13', 'Nueva persona agregada: Descripción = Elvira Amarilis Rodriguez Vela , 45461562 , Estado = 1'),
(235, 2, 'insertar', 'persona', 126, '2024-11-26 17:36:24', 'Nueva persona agregada: Descripción = Rosa Katiuska Silva Rengifo , 73194041 , Estado = 1'),
(236, 2, 'insertar', 'persona', 127, '2024-11-26 17:39:21', 'Nueva persona agregada: Descripción = Magali Burga Garcia , 42530380 , Estado = 1'),
(237, 2, 'insertar', 'persona', 128, '2024-11-26 17:41:20', 'Nueva persona agregada: Descripción = Gino Ruiz Salazar , 42838128 , Estado = 1'),
(238, 2, 'insertar', 'persona', 129, '2024-11-26 17:43:11', 'Nueva persona agregada: Descripción = Milagros Del Pilar Sanchez Flores , 42022628 , Estado = 1'),
(239, 2, 'insertar', 'persona', 130, '2024-11-26 17:45:15', 'Nueva persona agregada: Descripción = Janeth Gisella Rodriguez Gil , 05402328 , Estado = 1'),
(240, 2, 'insertar', 'persona', 131, '2024-11-26 17:48:10', 'Nueva persona agregada: Descripción = Angie Lianhell Perez Macedo , 72513368 , Estado = 1'),
(241, 2, 'insertar', 'persona', 132, '2024-11-26 17:55:04', 'Nueva persona agregada: Descripción = Issis Arletty Mavila Hurtado , 40868730 , Estado = 1'),
(242, 2, 'insertar', 'persona', 133, '2024-11-29 16:42:07', 'Nueva persona agregada: Descripción = Karla Milagros Aliaga Palla, 48657309 , Estado = 1'),
(243, 2, 'insertar', 'persona', 134, '2024-11-29 16:59:30', 'Nueva persona agregada: Descripción = Llajaira Valquiria Perez Perea , 72542557 , Estado = 1'),
(244, 3, 'insertar', 'bien', 27, '2025-01-02 17:15:43', 'Nueva bien agregado: Descripción = CPU, CX34X54, 74089950GR06'),
(245, 3, 'insertar', 'bien', 28, '2025-01-02 17:16:31', 'Nueva bien agregado: Descripción = MONITOR, CN44171JRP, 74088187N375'),
(246, 3, 'insertar', 'bien', 29, '2025-01-02 17:18:39', 'Nueva bien agregado: Descripción = TECLADO, CN019M93LO30048101XDA04, 74089500IS74'),
(247, 3, 'insertar', 'bien', 30, '2025-01-02 17:21:27', 'Nueva bien agregado: Descripción = CPU, 5PGV564, 74089950GR08'),
(248, 3, 'insertar', 'bien', 31, '2025-01-02 17:22:28', 'Nueva bien agregado: Descripción = MONITOR, CN44182KKJ, 74088187N378'),
(249, 3, 'insertar', 'bien', 32, '2025-01-02 17:23:53', 'Nueva bien agregado: Descripción = TECLADO, CN019M93LO30047D0DCTA04, 74089500IS76'),
(250, 3, 'insertar', 'bien', 33, '2025-01-02 17:43:13', 'Nueva bien agregado: Descripción = CPU, 5NSV564, 74089950GR05'),
(251, 3, 'insertar', 'bien', 34, '2025-01-02 17:44:00', 'Nueva bien agregado: Descripción = MONITOR, CN44190KNZ, 74088187N376'),
(252, 3, 'insertar', 'bien', 35, '2025-01-02 17:44:36', 'Nueva bien agregado: Descripción = TECLADO, CN019M93LO30047D0DFDA04, 74089500IS75'),
(253, 3, 'insertar', 'bien', 36, '2025-01-02 17:45:09', 'Nueva bien agregado: Descripción = CPU, JTWV564, 74089950GR07'),
(254, 3, 'insertar', 'bien', 37, '2025-01-02 17:45:44', 'Nueva bien agregado: Descripción = MONITOR, CN441933QB, 74088187N377'),
(255, 3, 'insertar', 'bien', 38, '2025-01-02 17:46:19', 'Nueva bien agregado: Descripción = TECLADO, CN019M93LO30048105KRA04, 74089500IS73'),
(256, 3, 'insertar', 'bien', 39, '2025-01-02 17:49:29', 'Nueva bien agregado: Descripción = LAPTOP, 1H84252FHL, 740805008181'),
(257, 3, 'insertar', 'bien', 40, '2025-01-02 17:49:57', 'Nueva bien agregado: Descripción = LAPTOP, 1H84252FGM, 740805008182'),
(258, 2, 'insertar', 'bien', 41, '2025-01-21 14:43:17', 'Nueva bien agregado: Descripción = UPS, AS1953190525, 462200505059'),
(259, 2, 'Insertar', 'movimiento', 28, '2025-01-21 14:44:47', 'Se ha registrado un nuevo movimiento.'),
(260, 2, 'insertar', 'bien', 42, '2025-01-21 15:13:26', 'Nueva bien agregado: Descripción = LAPTOP, PF-28D41B, 740805003309'),
(261, 2, 'insertar', 'persona', 135, '2025-01-21 15:16:30', 'Nueva persona agregada: Descripción = Alan Douglas Pinche Moreno , 43010135 , Estado = 1'),
(262, 2, 'Insertar', 'movimiento', 29, '2025-01-21 15:17:46', 'Se ha registrado un nuevo movimiento.'),
(263, 3, 'insertar', 'bien', 43, '2025-01-22 19:14:55', 'Nueva bien agregado: Descripción = CPU, DGX6704, 74089950GJ41'),
(264, 3, 'insertar', 'bien', 44, '2025-01-22 19:16:23', 'Nueva bien agregado: Descripción = MONITOR, CN03GM7VFCC0039MCJ3XA00, 74088187M836'),
(265, 3, 'insertar', 'bien', 45, '2025-01-22 19:19:37', 'Nueva bien agregado: Descripción = TECLADO, CN019M93LO30036007CNA04, 74089500IL39'),
(266, 3, 'Insertar', 'movimiento', 30, '2025-01-22 19:22:50', 'Se ha registrado un nuevo movimiento.'),
(267, 2, 'insertar', 'bien', 46, '2025-01-23 14:30:17', 'Nueva bien agregado: Descripción = CPU, 3DK6704, 74089950GJ12'),
(268, 2, 'insertar', 'bien', 47, '2025-01-23 14:31:17', 'Nueva bien agregado: Descripción = MONITOR, CN03GM7VFCC0039MAMHXA00, 74088187M919'),
(269, 2, 'insertar', 'bien', 48, '2025-01-23 14:32:15', 'Nueva bien agregado: Descripción = TECLADO, CN019M93LO30038S15WCA04, 74089500IK44'),
(270, 2, 'insertar', 'bien', 49, '2025-01-23 14:33:08', 'Nueva bien agregado: Descripción = CPU, FGN6704, 74089950GJ06'),
(271, 2, 'insertar', 'bien', 50, '2025-01-23 14:33:50', 'Nueva bien agregado: Descripción = MONITOR, CN03GM7VFCC0039MA83XA00, 74088187M409'),
(272, 2, 'insertar', 'bien', 51, '2025-01-23 14:34:35', 'Nueva bien agregado: Descripción = TECLADO, CN019M93LO30038S152QA04, 74089500IN81'),
(273, 2, 'Insertar', 'movimiento', 31, '2025-01-23 14:39:17', 'Se ha registrado un nuevo movimiento.'),
(274, 2, 'Insertar', 'movimiento', 32, '2025-01-23 14:41:29', 'Se ha registrado un nuevo movimiento.'),
(275, 2, 'insertar', 'bien', 52, '2025-01-23 14:55:22', 'Nueva bien agregado: Descripción = CPU, MXL5282S43, 74089950AQ54'),
(276, 2, 'insertar', 'bien', 53, '2025-01-23 14:56:28', 'Nueva bien agregado: Descripción = MONITOR, 3CQ4503LLG, 740880371297'),
(277, 2, 'insertar', 'bien', 54, '2025-01-23 14:57:48', 'Nueva bien agregado: Descripción = TECLADO, 2313MR109178, S/C'),
(278, 2, 'insertar', 'bien', 55, '2025-01-23 16:56:59', 'Nueva bien agregado: Descripción = CPU, 7GYF8Z1, 74089950Y387'),
(279, 2, 'insertar', 'bien', 56, '2025-01-23 16:57:54', 'Nueva bien agregado: Descripción = MONITOR, 6CM228227L, 74088187F287'),
(280, 2, 'insertar', 'bien', 57, '2025-01-23 16:59:51', 'Nueva bien agregado: Descripción = TECLADO, UL2118300179, --'),
(281, 2, 'Insertar', 'movimiento', 33, '2025-01-23 17:01:11', 'Se ha registrado un nuevo movimiento.'),
(282, 2, 'insertar', 'bien', 58, '2025-01-24 14:02:38', 'Nueva bien agregado: Descripción = CPU, 2170511000308005740, 74089950CQ18'),
(283, 2, 'insertar', 'bien', 59, '2025-01-24 14:04:16', 'Nueva bien agregado: Descripción = MONITOR, 6CM2282221, 74088187F334'),
(284, 2, 'insertar', 'bien', 60, '2025-01-24 14:06:00', 'Nueva bien agregado: Descripción = TECLADO, 202012000726, --'),
(285, 2, 'Insertar', 'movimiento', 34, '2025-01-24 14:08:07', 'Se ha registrado un nuevo movimiento.'),
(286, 3, 'Actualizar', 'movimiento', 34, '2025-01-28 14:13:47', 'Se ha actualizado el PDF del movimiento.'),
(287, 3, 'Actualizar', 'movimiento', 31, '2025-01-28 14:14:49', 'Se ha actualizado el PDF del movimiento.'),
(288, 3, 'Actualizar', 'movimiento', 32, '2025-01-28 14:15:08', 'Se ha actualizado el PDF del movimiento.'),
(289, 3, 'Actualizar', 'movimiento', 33, '2025-01-28 14:15:18', 'Se ha actualizado el PDF del movimiento.'),
(290, 3, 'Actualizar', 'movimiento', 30, '2025-01-28 14:15:40', 'Se ha actualizado el PDF del movimiento.'),
(291, 3, 'Actualizar', 'movimiento', 28, '2025-01-28 14:15:50', 'Se ha actualizado el PDF del movimiento.'),
(292, 3, 'Actualizar', 'movimiento', 28, '2025-01-28 14:15:50', 'Se ha actualizado el PDF del movimiento.'),
(293, 3, 'Actualizar', 'movimiento', 29, '2025-01-28 14:16:01', 'Se ha actualizado el PDF del movimiento.'),
(294, 3, 'Actualizar', 'movimiento', 29, '2025-01-28 14:16:01', 'Se ha actualizado el PDF del movimiento.'),
(295, 3, 'Actualizar', 'movimiento', 29, '2025-01-28 14:16:01', 'Se ha actualizado el PDF del movimiento.'),
(296, 3, 'Actualizar', 'movimiento', 27, '2025-01-28 14:36:31', 'Se ha actualizado el PDF del movimiento.'),
(297, 3, 'Actualizar', 'movimiento', 27, '2025-01-28 14:36:31', 'Se ha actualizado el PDF del movimiento.'),
(298, 3, 'Actualizar', 'movimiento', 27, '2025-01-28 14:36:31', 'Se ha actualizado el PDF del movimiento.'),
(299, 3, 'Actualizar', 'movimiento', 27, '2025-01-28 14:36:31', 'Se ha actualizado el PDF del movimiento.'),
(300, 3, 'Actualizar', 'movimiento', 27, '2025-01-28 14:36:31', 'Se ha actualizado el PDF del movimiento.'),
(301, 3, 'insertar', 'bien', 61, '2025-04-15 21:26:54', 'Nueva bien agregado: Descripción = IMPRESORA, LAK5601996, 742227260040'),
(302, 3, 'insertar', 'persona', 136, '2025-04-15 21:28:38', 'Nueva persona agregada: Descripción = CHUQUIPIONDO SANCHEZ ANDREA DEL PILAR, 71777766 , Estado = 1'),
(303, 3, 'Insertar', 'movimiento', 35, '2025-04-15 21:29:47', 'Se ha registrado un nuevo movimiento.'),
(304, 3, 'insertar', 'persona', 137, '2025-04-16 14:51:34', 'Nueva persona agregada: Descripción = SEGUNDO LUCAS LOZANO RIOS, 05323677 , Estado = 1'),
(305, 3, 'insertar', 'persona', 138, '2025-04-16 14:55:19', 'Nueva persona agregada: Descripción = MARCO VALERIO GRANDEZ CELIS, 40879831 , Estado = 1'),
(306, NULL, 'Actualizar', 'movimiento', 35, '2025-04-22 16:19:45', 'Se ha actualizado el PDF del movimiento.'),
(307, NULL, 'Actualizar', 'movimiento', 35, '2025-04-22 16:19:45', 'Se ha actualizado el PDF del movimiento.'),
(308, NULL, 'Actualizar', 'movimiento', 35, '2025-04-22 16:19:45', 'Se ha actualizado el PDF del movimiento.'),
(309, NULL, 'Actualizar', 'movimiento', 35, '2025-04-22 16:19:45', 'Se ha actualizado el PDF del movimiento.'),
(310, 3, 'insertar', 'bien', 62, '2025-06-11 13:30:47', 'Nueva bien agregado: Descripción = CPU, MZ00K9BR, 74089950HG11'),
(311, 3, 'insertar', 'bien', 63, '2025-06-11 13:30:52', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGLB, 74088037E738'),
(312, 3, 'insertar', 'bien', 64, '2025-06-11 13:31:01', 'Nueva bien agregado: Descripción = TECLADO, 46XD3VP, 74089500JH70'),
(313, 3, 'insertar', 'bien', 65, '2025-06-11 13:32:59', 'Nueva bien agregado: Descripción = CPU, MZ00K9AA, 74089950HG02'),
(314, 3, 'insertar', 'bien', 66, '2025-06-11 13:33:57', 'Nueva bien agregado: Descripción = CPU, MZ00KGFK, 74089950HF90'),
(315, 3, 'insertar', 'bien', 67, '2025-06-11 13:34:55', 'Nueva bien agregado: Descripción = CPU, MZ00KJLN, 74089950HF86'),
(316, 3, 'insertar', 'bien', 68, '2025-06-11 13:35:57', 'Nueva bien agregado: Descripción = CPU, MZ00K9AS, 74089950HF99'),
(317, 3, 'insertar', 'bien', 69, '2025-06-11 13:36:19', 'Nueva bien agregado: Descripción = TECLADO, 46XD3VP, 74089500JH61'),
(318, 3, 'insertar', 'bien', 70, '2025-06-11 13:37:00', 'Nueva bien agregado: Descripción = CPU, MZ00K9BP, 74089950HG05'),
(319, 3, 'insertar', 'bien', 71, '2025-06-11 13:38:15', 'Nueva bien agregado: Descripción = CPU, MZ00K9AJ, 74089950HG08'),
(320, 3, 'insertar', 'bien', 72, '2025-06-11 13:39:07', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGMV, 74088037E729'),
(321, 3, 'insertar', 'bien', 73, '2025-06-11 13:39:16', 'Nueva bien agregado: Descripción = CPU, MZ00K9A5, 74089950HG00'),
(322, 3, 'insertar', 'bien', 74, '2025-06-11 13:39:21', 'Nueva bien agregado: Descripción = TECLADO, 46XD187, 74089500JH84'),
(323, 3, 'insertar', 'bien', 75, '2025-06-11 13:40:02', 'Nueva bien agregado: Descripción = CPU, MZ00K9AP, 74089950HG04'),
(324, 3, 'insertar', 'bien', 76, '2025-06-11 13:40:46', 'Nueva bien agregado: Descripción = CPU, MZ00K9AL, 74089950HF98'),
(325, 3, 'insertar', 'bien', 77, '2025-06-11 13:41:40', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGLG, 74088037E752'),
(326, 3, 'insertar', 'bien', 78, '2025-06-11 13:41:56', 'Nueva bien agregado: Descripción = CPU, MZ00K995, 74089950HG07'),
(327, 3, 'insertar', 'bien', 79, '2025-06-11 13:42:41', 'Nueva bien agregado: Descripción = CPU, MZ00K9AY, 74089950HF84'),
(328, 3, 'insertar', 'bien', 80, '2025-06-11 13:42:41', 'Nueva bien agregado: Descripción = TECLADO, 46XD5GA, 74089500JH80'),
(329, 3, 'insertar', 'bien', 81, '2025-06-11 13:43:15', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGL8, 74088037E748'),
(330, 3, 'insertar', 'bien', 82, '2025-06-11 13:43:26', 'Nueva bien agregado: Descripción = CPU, MZ00KJ07, 74089950HF92'),
(331, 3, 'insertar', 'bien', 83, '2025-06-11 13:44:18', 'Nueva bien agregado: Descripción = TECLADO, 46XD3VH, 74089500JH52'),
(332, 3, 'insertar', 'bien', 84, '2025-06-11 13:44:28', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGP4, 74088037E726'),
(333, 3, 'insertar', 'bien', 85, '2025-06-11 13:44:43', 'Nueva bien agregado: Descripción = CPU, MZ00KGTG, 74089950HF89'),
(334, 3, 'insertar', 'bien', 86, '2025-06-11 13:45:30', 'Nueva bien agregado: Descripción = CPU, MZ00KGGR, 74089950H91'),
(335, 3, 'insertar', 'bien', 87, '2025-06-11 13:45:36', 'Nueva bien agregado: Descripción = TECLADO, 46XD3VN, 740899500JH64'),
(336, 3, 'insertar', 'bien', 88, '2025-06-11 13:46:36', 'Nueva bien agregado: Descripción = CPU, MZ00K9A0, 74089950HG10'),
(337, 3, 'insertar', 'bien', 89, '2025-06-11 13:47:15', 'Nueva bien agregado: Descripción = CPU, MZ00KGTC, 74089950HF88'),
(338, 3, 'insertar', 'bien', 90, '2025-06-11 13:47:19', 'Nueva bien agregado: Descripción = TECLADO, 46XD3VF, 74089500JH67'),
(339, 3, 'insertar', 'bien', 91, '2025-06-11 13:47:29', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGNR, 74088037E732'),
(340, 3, 'insertar', 'bien', 92, '2025-06-11 13:48:04', 'Nueva bien agregado: Descripción = CPU, MZ00K9A7, 74089950HF93'),
(341, 3, 'insertar', 'bien', 93, '2025-06-11 13:48:32', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGL4, 74088037E735'),
(342, 3, 'insertar', 'bien', 94, '2025-06-11 13:48:40', 'Nueva bien agregado: Descripción = TECLADO, 46XD3WX, 74089500JH59'),
(343, 3, 'insertar', 'bien', 95, '2025-06-11 13:48:54', 'Nueva bien agregado: Descripción = CPU, MZ00K9AR, 74089950HF83'),
(344, 3, 'insertar', 'bien', 96, '2025-06-11 13:49:29', 'Nueva bien agregado: Descripción = CPU, MZ00K9A3, 74089950HF97'),
(345, 3, 'insertar', 'bien', 97, '2025-06-11 13:49:41', 'Nueva bien agregado: Descripción = TECLADO, 46XD53E, 74089500JH63'),
(346, 3, 'insertar', 'bien', 98, '2025-06-11 13:49:48', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGNZ, 74088037E727'),
(347, 3, 'insertar', 'bien', 99, '2025-06-11 13:50:03', 'Nueva bien agregado: Descripción = CPU, MZ00K9AZ, 74089950HF94'),
(348, 3, 'insertar', 'bien', 100, '2025-06-11 13:50:42', 'Nueva bien agregado: Descripción = CPU, MZ00K99P, 74089950HF85'),
(349, 3, 'insertar', 'bien', 101, '2025-06-11 13:50:57', 'Nueva bien agregado: Descripción = TECLADO, 46XD3VJ, 74089500JH51'),
(350, 3, 'insertar', 'bien', 102, '2025-06-11 13:51:22', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGN8, 74088037E731'),
(351, 3, 'insertar', 'bien', 103, '2025-06-11 13:51:30', 'Nueva bien agregado: Descripción = CPU, MZ00K999, 74089950HG01'),
(352, 3, 'insertar', 'bien', 104, '2025-06-11 13:52:01', 'Nueva bien agregado: Descripción = CPU, MZ00K99S, 74089950HG14'),
(353, 3, 'insertar', 'bien', 105, '2025-06-11 13:52:26', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGNV, 74088037E725'),
(354, 3, 'insertar', 'bien', 106, '2025-06-11 13:52:43', 'Nueva bien agregado: Descripción = CPU, MZ00K9AQ, 74089950HG09'),
(355, 3, 'insertar', 'bien', 107, '2025-06-11 13:53:04', 'Nueva bien agregado: Descripción = TECLADO, 46XD3W6, 74089500JH66'),
(356, 3, 'insertar', 'bien', 108, '2025-06-11 13:53:06', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGML, 74088037E734'),
(357, 3, 'insertar', 'bien', 109, '2025-06-11 13:54:00', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGLC, 74088037E746'),
(358, 3, 'insertar', 'bien', 110, '2025-06-11 13:54:32', 'Nueva bien agregado: Descripción = CPU, MZ00K99C, 74089950HG12'),
(359, 3, 'insertar', 'bien', 111, '2025-06-11 13:55:13', 'Nueva bien agregado: Descripción = CPU, MZ00K9B1, 74089950HG16'),
(360, 3, 'insertar', 'bien', 112, '2025-06-11 13:55:35', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGK7, 74088037E719'),
(361, 3, 'insertar', 'bien', 113, '2025-06-11 13:56:19', 'Nueva bien agregado: Descripción = CPU, MZ00K9AB, 74089950HG17'),
(362, 3, 'insertar', 'bien', 114, '2025-06-11 13:56:31', 'Nueva bien agregado: Descripción = TECLADO, 46XD3VL, 74089500JH78'),
(363, 3, 'insertar', 'bien', 115, '2025-06-11 13:56:34', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGN0, 74088037E751'),
(364, 3, 'insertar', 'bien', 116, '2025-06-11 13:56:59', 'Nueva bien agregado: Descripción = CPU, MZ00K9AF, 74089950HF95'),
(365, 3, 'insertar', 'bien', 117, '2025-06-11 13:57:15', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGLF, 74088037E753'),
(366, 3, 'insertar', 'bien', 118, '2025-06-11 13:57:36', 'Nueva bien agregado: Descripción = TECLADO, 46XD1F3, 74089500JH45'),
(367, 3, 'insertar', 'bien', 119, '2025-06-11 13:57:59', 'Nueva bien agregado: Descripción = CPU, MZ00K9A2, 74089950HF96'),
(368, 3, 'insertar', 'bien', 120, '2025-06-11 13:58:00', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGMP, 74088037E737'),
(369, 3, 'insertar', 'bien', 121, '2025-06-11 13:58:43', 'Nueva bien agregado: Descripción = TECLADO, 46XD5Z6, 74089500JH83'),
(370, 3, 'insertar', 'bien', 122, '2025-06-11 13:58:43', 'Nueva bien agregado: Descripción = CPU, MZ00K99X, 74089950HG13'),
(371, 3, 'insertar', 'bien', 123, '2025-06-11 13:59:00', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGNN, 74088037E750'),
(372, 3, 'insertar', 'bien', 124, '2025-06-11 13:59:32', 'Nueva bien agregado: Descripción = CPU, MZ00K9AK, 74089950HG03'),
(373, 3, 'insertar', 'bien', 125, '2025-06-11 13:59:43', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGN4, 74088037E720'),
(374, 3, 'insertar', 'bien', 126, '2025-06-11 14:00:12', 'Nueva bien agregado: Descripción = CPU, MZ00K9AX, 74089950HG15'),
(375, 3, 'insertar', 'bien', 127, '2025-06-11 14:00:19', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGM8, 74088037E745'),
(376, 3, 'insertar', 'bien', 128, '2025-06-11 14:00:46', 'Nueva bien agregado: Descripción = TECLADO, 46XD4G9, 74089500JH85'),
(377, 3, 'insertar', 'bien', 129, '2025-06-11 14:00:49', 'Nueva bien agregado: Descripción = CPU, MZ00KJJS, 74089950HF87'),
(378, 3, 'insertar', 'bien', 130, '2025-06-11 14:01:01', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGP9, 74088037E724'),
(379, 3, 'insertar', 'bien', 131, '2025-06-11 14:01:50', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGMF, 74088037E721'),
(380, 3, 'insertar', 'bien', 132, '2025-06-11 14:02:24', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGMH, 74088037E747'),
(381, 3, 'insertar', 'bien', 133, '2025-06-11 14:02:42', 'Nueva bien agregado: Descripción = CPU, MZ00K98X, 74089950HG06'),
(382, 3, 'insertar', 'bien', 134, '2025-06-11 14:03:15', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGM7, 74088037E728'),
(383, 3, 'insertar', 'bien', 135, '2025-06-11 14:03:43', 'Nueva bien agregado: Descripción = TECLADO, 46XD3WT, 74089500JH69'),
(384, 3, 'insertar', 'bien', 136, '2025-06-11 14:03:48', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGM9, 74088037E741'),
(385, 3, 'insertar', 'bien', 137, '2025-06-11 14:04:48', 'Nueva bien agregado: Descripción = TECLADO, 46XD5Z1, 74089500JH82'),
(386, 3, 'insertar', 'bien', 138, '2025-06-11 14:04:49', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGK2, 74088037E736'),
(387, 3, 'insertar', 'bien', 139, '2025-06-11 14:05:19', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGN3, 74088037E739'),
(388, 3, 'insertar', 'bien', 140, '2025-06-11 14:05:54', 'Nueva bien agregado: Descripción = TECLADO, 46XD3WW, 74089500JH46'),
(389, 3, 'insertar', 'bien', 141, '2025-06-11 14:06:16', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGMB, 74088037E743'),
(390, 3, 'insertar', 'bien', 142, '2025-06-11 14:06:54', 'Nueva bien agregado: Descripción = TECLADO, 46XD3VM, 74089500JH77'),
(391, 3, 'insertar', 'bien', 143, '2025-06-11 14:07:18', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGM5, 74088037E744'),
(392, 3, 'insertar', 'bien', 144, '2025-06-11 14:07:56', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGN7, 74088037E722'),
(393, 3, 'insertar', 'bien', 145, '2025-06-11 14:08:09', 'Nueva bien agregado: Descripción = TECLADO, 46XD53F, 74089500JH50'),
(394, 3, 'insertar', 'bien', 146, '2025-06-11 14:08:22', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGNX, 74088037E723'),
(395, 3, 'insertar', 'bien', 147, '2025-06-11 14:08:47', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGMA, 74088037E740'),
(396, 3, 'insertar', 'bien', 148, '2025-06-11 14:09:20', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGLR, 74088037E730'),
(397, 3, 'insertar', 'bien', 149, '2025-06-11 14:09:51', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGMC, 74088037E742'),
(398, 3, 'insertar', 'bien', 150, '2025-06-11 14:10:14', 'Nueva bien agregado: Descripción = TECLADO, 46XD3WS, 74089500JH47'),
(399, 3, 'insertar', 'bien', 151, '2025-06-11 14:10:24', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGMR, 74088037E749'),
(400, 3, 'insertar', 'bien', 152, '2025-06-11 14:11:21', 'Nueva bien agregado: Descripción = MONITOR, VNAAWGN2, 74088037E733'),
(401, 3, 'insertar', 'bien', 153, '2025-06-11 14:11:56', 'Nueva bien agregado: Descripción = TECLADO, 46XD3WC, 74089500JH79'),
(402, 3, 'insertar', 'bien', 154, '2025-06-11 14:14:23', 'Nueva bien agregado: Descripción = TECLADO, 46XD3W9, 74089500JH60'),
(403, 3, 'insertar', 'bien', 155, '2025-06-11 14:15:22', 'Nueva bien agregado: Descripción = TECLADO, 46XD3WB, 74089500JH73'),
(404, 3, 'insertar', 'bien', 156, '2025-06-11 14:16:00', 'Nueva bien agregado: Descripción = TECLADO, 46XD3VG, 74089500JH68'),
(405, 3, 'insertar', 'bien', 157, '2025-06-11 14:16:40', 'Nueva bien agregado: Descripción = TECLADO, 46XD3VK, 74089500JH71'),
(406, 3, 'insertar', 'bien', 158, '2025-06-11 14:17:23', 'Nueva bien agregado: Descripción = TECLADO, 46XD3WR, 74089500JH75'),
(407, 3, 'insertar', 'bien', 159, '2025-06-11 14:18:00', 'Nueva bien agregado: Descripción = TECLADO, 46XD3WV, 74089500JH76'),
(408, 3, 'insertar', 'bien', 160, '2025-06-11 14:18:38', 'Nueva bien agregado: Descripción = TECLADO, 46XD53G, 74089500JH48'),
(409, 3, 'insertar', 'bien', 161, '2025-06-11 14:19:33', 'Nueva bien agregado: Descripción = TECLADO, 46XD53H, 74089500JH49'),
(410, 3, 'insertar', 'bien', 162, '2025-06-11 14:20:11', 'Nueva bien agregado: Descripción = TECLADO, 46XD3WA, 74089500JH72'),
(411, 3, 'insertar', 'bien', 163, '2025-06-11 14:20:47', 'Nueva bien agregado: Descripción = TECLADO, 46XD3VR, 74089500JH62');
INSERT INTO `log_acciones` (`id_log`, `id_usuario_log`, `accion_log`, `tabla_afectada_log`, `id_fila_afectada_log`, `fecha_accion_log`, `detalles_log`) VALUES
(412, 3, 'insertar', 'bien', 164, '2025-06-11 14:21:25', 'Nueva bien agregado: Descripción = TECLADO, 46XD3WP, 74089500JH74'),
(413, 3, 'insertar', 'bien', 165, '2025-06-11 14:22:03', 'Nueva bien agregado: Descripción = TECLADO, 46XD4GB, 74089500JH81'),
(414, 3, 'insertar', 'bien', 166, '2025-06-11 14:22:44', 'Nueva bien agregado: Descripción = TECLADO, 46XD3W7, 74089500JH65'),
(415, 3, 'insertar', 'bien', 167, '2025-06-11 15:43:19', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922362'),
(416, 3, 'insertar', 'bien', 168, '2025-06-11 15:45:23', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922391'),
(417, 3, 'insertar', 'bien', 169, '2025-06-11 15:47:02', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922361'),
(418, 3, 'insertar', 'bien', 170, '2025-06-11 15:48:14', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922360'),
(419, 3, 'insertar', 'bien', 171, '2025-06-11 15:48:45', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516085, 46225215BE81'),
(420, 3, 'insertar', 'bien', 172, '2025-06-11 15:49:54', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922388'),
(421, 3, 'insertar', 'bien', 173, '2025-06-11 15:51:08', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922387'),
(422, 3, 'insertar', 'bien', 174, '2025-06-11 15:51:26', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515656, 46225215BE65'),
(423, 3, 'insertar', 'bien', 175, '2025-06-11 15:51:53', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922385'),
(424, 3, 'insertar', 'bien', 176, '2025-06-11 15:52:04', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515659 , 46225215BE86'),
(425, 3, 'insertar', 'bien', 177, '2025-06-11 15:52:50', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515654, 46225215BE58'),
(426, 3, 'insertar', 'bien', 178, '2025-06-11 15:53:25', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516092, 46225215BE78'),
(427, 3, 'insertar', 'bien', 179, '2025-06-11 15:54:03', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516087 , 46225215BE75'),
(428, 3, 'insertar', 'bien', 180, '2025-06-11 15:54:41', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515646, 46225215BE91'),
(429, 3, 'insertar', 'bien', 181, '2025-06-11 15:55:20', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515648, 46225215BE87'),
(430, 3, 'insertar', 'bien', 182, '2025-06-11 15:55:27', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922384'),
(431, 3, 'insertar', 'bien', 183, '2025-06-11 15:56:23', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516081, 46225215BE70'),
(432, 3, 'insertar', 'bien', 184, '2025-06-11 15:56:35', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922383'),
(433, 3, 'insertar', 'bien', 185, '2025-06-11 15:56:51', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516079, 46225215BE82'),
(434, 3, 'insertar', 'bien', 186, '2025-06-11 15:57:20', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922382'),
(435, 3, 'insertar', 'bien', 187, '2025-06-11 15:57:23', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516086, 46225215BE80'),
(436, 3, 'insertar', 'bien', 188, '2025-06-11 15:57:51', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516075, 46225215BE67'),
(437, 3, 'insertar', 'bien', 189, '2025-06-11 15:58:13', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922381'),
(438, 3, 'insertar', 'bien', 190, '2025-06-11 15:58:21', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516090 , 46225215BE77'),
(439, 3, 'insertar', 'bien', 191, '2025-06-11 15:58:54', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515647, 46225215BE89'),
(440, 3, 'insertar', 'bien', 192, '2025-06-11 15:58:55', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922380'),
(441, 3, 'insertar', 'bien', 193, '2025-06-11 15:59:30', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515649 , 46225215BE60'),
(442, 3, 'insertar', 'bien', 194, '2025-06-11 15:59:31', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922379'),
(443, 3, 'insertar', 'bien', 195, '2025-06-11 16:00:03', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515660 , 46225215BE92'),
(444, 3, 'insertar', 'bien', 196, '2025-06-11 16:00:14', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922378'),
(445, 3, 'insertar', 'bien', 197, '2025-06-11 16:00:40', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515645, 46225215BE90'),
(446, 3, 'insertar', 'bien', 198, '2025-06-11 16:00:45', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922377'),
(447, 3, 'insertar', 'bien', 199, '2025-06-11 16:01:15', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922377'),
(448, 3, 'insertar', 'bien', 200, '2025-06-11 16:01:18', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515658, 46225215BE88'),
(449, 3, 'insertar', 'bien', 201, '2025-06-11 16:01:43', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922376'),
(450, 3, 'insertar', 'bien', 202, '2025-06-11 16:01:45', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515643 , 46225215BE61'),
(451, 3, 'insertar', 'bien', 203, '2025-06-11 16:02:06', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922376'),
(452, 3, 'insertar', 'bien', 204, '2025-06-11 16:02:08', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516082, 46225215BE71'),
(453, 3, 'insertar', 'bien', 205, '2025-06-11 16:02:34', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922375'),
(454, 3, 'insertar', 'bien', 206, '2025-06-11 16:02:35', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516078, 46225215BE84'),
(455, 3, 'insertar', 'bien', 207, '2025-06-11 16:03:01', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516080, 46225215BE69'),
(456, 3, 'insertar', 'bien', 208, '2025-06-11 16:03:25', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515651, 46225215BE62'),
(457, 3, 'insertar', 'bien', 209, '2025-06-11 16:03:54', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516076, 46225215BE68'),
(458, 3, 'insertar', 'bien', 210, '2025-06-11 16:04:05', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922374'),
(459, 3, 'insertar', 'bien', 211, '2025-06-11 16:04:30', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516084, 46225215BE83'),
(460, 3, 'insertar', 'bien', 212, '2025-06-11 16:04:40', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922386'),
(461, 3, 'insertar', 'bien', 213, '2025-06-11 16:04:55', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516091, 46225215BE79'),
(462, 3, 'insertar', 'bien', 214, '2025-06-11 16:05:46', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515652, 46225215BE63'),
(463, 3, 'insertar', 'bien', 215, '2025-06-11 16:05:49', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922373'),
(464, 3, 'insertar', 'bien', 216, '2025-06-11 16:06:10', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515657, 46225215BE85'),
(465, 3, 'insertar', 'bien', 217, '2025-06-11 16:06:18', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922372'),
(466, 3, 'insertar', 'bien', 218, '2025-06-11 16:06:33', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515655 , 46225215BE66'),
(467, 3, 'insertar', 'bien', 219, '2025-06-11 16:06:41', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922389'),
(468, 3, 'insertar', 'bien', 220, '2025-06-11 16:07:04', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516088 , 46225215BE76'),
(469, 3, 'insertar', 'bien', 221, '2025-06-11 16:07:11', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922390'),
(470, 3, 'insertar', 'bien', 222, '2025-06-11 16:07:28', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516083, 46225215BE72'),
(471, 3, 'insertar', 'bien', 223, '2025-06-11 16:07:55', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515653, 46225215BE64'),
(472, 3, 'insertar', 'bien', 224, '2025-06-11 16:08:06', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922390'),
(473, 3, 'insertar', 'bien', 225, '2025-06-11 16:08:20', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516077 , 46225215BE73'),
(474, 3, 'insertar', 'bien', 226, '2025-06-11 16:08:43', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408515650 , 46225215BE59'),
(475, 3, 'insertar', 'bien', 227, '2025-06-11 16:08:49', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922371'),
(476, 3, 'insertar', 'bien', 228, '2025-06-11 16:09:17', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 91432408516089, 46225215BE74'),
(477, 3, 'insertar', 'bien', 229, '2025-06-11 16:09:21', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922392'),
(478, 3, 'insertar', 'bien', 230, '2025-06-11 16:09:57', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922393'),
(479, 3, 'insertar', 'bien', 231, '2025-06-11 16:10:35', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922394'),
(480, 3, 'insertar', 'bien', 232, '2025-06-11 16:11:09', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922370'),
(481, 3, 'insertar', 'bien', 233, '2025-06-11 16:11:43', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922369'),
(482, 3, 'insertar', 'bien', 234, '2025-06-11 16:12:20', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922368'),
(483, 3, 'insertar', 'bien', 235, '2025-06-11 16:12:54', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922367'),
(484, 3, 'insertar', 'bien', 236, '2025-06-11 16:13:32', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922366'),
(485, 3, 'insertar', 'bien', 237, '2025-06-11 16:14:03', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922365'),
(486, 3, 'insertar', 'bien', 238, '2025-06-11 16:14:33', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922364'),
(487, 3, 'insertar', 'bien', 239, '2025-06-11 16:15:09', 'Nueva bien agregado: Descripción = CÁMARA WEB, S/S, 740899922363'),
(488, 3, 'Insertar', 'movimiento', 36, '2025-06-11 16:40:15', 'Se ha registrado un nuevo movimiento.'),
(489, 3, 'Insertar', 'movimiento', 37, '2025-06-11 16:48:13', 'Se ha registrado un nuevo movimiento.'),
(490, 3, 'insertar', 'persona', 139, '2025-06-11 16:50:10', 'Nueva persona agregada: Descripción = VANESSA MICHELY TANG DE LA CRUZ, 47338317 , Estado = 1'),
(491, 3, 'Insertar', 'movimiento', 38, '2025-06-11 16:56:16', 'Se ha registrado un nuevo movimiento.'),
(492, 3, 'Insertar', 'movimiento', 39, '2025-06-11 16:59:23', 'Se ha registrado un nuevo movimiento.'),
(493, 3, 'Insertar', 'movimiento', 40, '2025-06-11 17:02:18', 'Se ha registrado un nuevo movimiento.'),
(494, 3, 'Insertar', 'movimiento', 41, '2025-06-11 17:04:20', 'Se ha registrado un nuevo movimiento.'),
(495, 3, 'Insertar', 'movimiento', 42, '2025-06-11 17:10:12', 'Se ha registrado un nuevo movimiento.'),
(496, 3, 'Insertar', 'movimiento', 43, '2025-06-11 17:10:19', 'Se ha registrado un nuevo movimiento.'),
(497, 3, 'Insertar', 'movimiento', 44, '2025-06-11 17:10:52', 'Se ha registrado un nuevo movimiento.'),
(498, 3, 'Insertar', 'movimiento', 45, '2025-06-11 17:12:43', 'Se ha registrado un nuevo movimiento.'),
(499, 3, 'insertar', 'persona', 140, '2025-06-11 17:15:51', 'Nueva persona agregada: Descripción = JUAN ACHING SANCHEZ, 41736697 , Estado = 1'),
(500, 3, 'insertar', 'persona', 141, '2025-06-11 17:18:31', 'Nueva persona agregada: Descripción = ROBERT LUIS CHUMBIMUNE PORRAS, 10561613 , Estado = 1'),
(501, 3, 'Insertar', 'movimiento', 46, '2025-06-11 17:20:13', 'Se ha registrado un nuevo movimiento.'),
(502, 3, 'Insertar', 'movimiento', 47, '2025-06-11 17:21:52', 'Se ha registrado un nuevo movimiento.'),
(503, 3, 'Insertar', 'movimiento', 48, '2025-06-11 17:22:30', 'Se ha registrado un nuevo movimiento.'),
(504, 3, 'Insertar', 'movimiento', 49, '2025-06-11 17:26:12', 'Se ha registrado un nuevo movimiento.'),
(505, 3, 'Insertar', 'movimiento', 50, '2025-06-11 17:26:36', 'Se ha registrado un nuevo movimiento.'),
(506, 3, 'Insertar', 'movimiento', 51, '2025-06-11 17:37:12', 'Se ha registrado un nuevo movimiento.'),
(507, 3, 'Insertar', 'movimiento', 52, '2025-06-11 17:37:53', 'Se ha registrado un nuevo movimiento.'),
(508, 3, 'Insertar', 'movimiento', 53, '2025-06-11 17:38:17', 'Se ha registrado un nuevo movimiento.'),
(509, 3, 'Insertar', 'movimiento', 54, '2025-06-11 17:39:32', 'Se ha registrado un nuevo movimiento.'),
(510, 3, 'Insertar', 'movimiento', 55, '2025-06-11 17:40:58', 'Se ha registrado un nuevo movimiento.'),
(511, 3, 'Insertar', 'movimiento', 56, '2025-06-11 17:42:38', 'Se ha registrado un nuevo movimiento.'),
(512, 3, 'insertar', 'area', 39, '2025-06-11 17:43:34', 'Nueva área agregada: Descripción = JUZGADO DE INVESTIGACIÓN TRANSITORIO, Estado = 1'),
(513, 3, 'insertar', 'persona', 142, '2025-06-11 17:44:27', 'Nueva persona agregada: Descripción = BIBIANA SCARLETT REATEGUI SHUPINGAHUA, 76722227 , Estado = 1'),
(514, 3, 'Insertar', 'movimiento', 57, '2025-06-11 17:46:29', 'Se ha registrado un nuevo movimiento.'),
(515, 3, 'Insertar', 'movimiento', 58, '2025-06-11 17:47:35', 'Se ha registrado un nuevo movimiento.'),
(516, 3, 'Insertar', 'movimiento', 59, '2025-06-11 17:48:38', 'Se ha registrado un nuevo movimiento.'),
(517, 3, 'Insertar', 'movimiento', 60, '2025-06-11 17:52:21', 'Se ha registrado un nuevo movimiento.'),
(518, 3, 'Insertar', 'movimiento', 61, '2025-06-11 17:52:21', 'Se ha registrado un nuevo movimiento.'),
(519, 3, 'insertar', 'persona', 143, '2025-06-11 17:54:32', 'Nueva persona agregada: Descripción = ANGELICA DEL CARMEN MONCADA NAVARRO, 70427520 , Estado = 1'),
(520, 3, 'Insertar', 'movimiento', 62, '2025-06-11 17:56:23', 'Se ha registrado un nuevo movimiento.'),
(521, 3, 'Insertar', 'movimiento', 63, '2025-06-11 17:56:57', 'Se ha registrado un nuevo movimiento.'),
(522, 3, 'Insertar', 'movimiento', 64, '2025-06-12 12:51:48', 'Se ha registrado un nuevo movimiento.'),
(523, 3, 'Insertar', 'movimiento', 65, '2025-06-12 12:56:05', 'Se ha registrado un nuevo movimiento.'),
(524, 3, 'Insertar', 'movimiento', 66, '2025-06-12 13:08:12', 'Se ha registrado un nuevo movimiento.'),
(525, 3, 'Insertar', 'movimiento', 67, '2025-06-12 13:11:53', 'Se ha registrado un nuevo movimiento.'),
(526, 3, 'Insertar', 'movimiento', 68, '2025-06-12 13:15:02', 'Se ha registrado un nuevo movimiento.'),
(527, 3, 'Insertar', 'movimiento', 69, '2025-06-12 13:16:45', 'Se ha registrado un nuevo movimiento.'),
(528, 3, 'insertar', 'bien', 240, '2025-06-19 15:14:05', 'Nueva bien agregado: Descripción = LECTOR DE CÓDIGO DE BARRAS, Z4D2M1, 740863503307'),
(529, 3, 'Insertar', 'movimiento', 70, '2025-06-19 15:17:08', 'Se ha registrado un nuevo movimiento.'),
(530, 3, 'insertar', 'persona', 144, '2025-07-01 14:08:11', 'Nueva persona agregada: Descripción = ALFONSO KURTHER TELLO TAMANI, 71645619 , Estado = 1'),
(531, 3, 'insertar', 'persona', 145, '2025-07-01 14:09:25', 'Nueva persona agregada: Descripción = WILLIAMS MIGUEL ORDORES FLORES, 72906836 , Estado = 1'),
(532, 3, 'insertar', 'usuario', 50, '2025-07-01 14:11:03', 'Nuevo usuario agregado: WilliamsWick19, Estado = 2'),
(533, 3, 'insertar', 'usuario', 51, '2025-07-01 14:11:16', 'Nuevo usuario agregado: KURTH99, Estado = 2'),
(534, 3, 'insertar', 'persona', 146, '2025-07-01 14:20:23', 'Nueva persona agregada: Descripción = Mauricio Leonardo Di Caprio, 70795139 , Estado = 1'),
(535, 3, 'insertar', 'usuario', 52, '2025-07-01 14:21:15', 'Nuevo usuario agregado: mauchucha, Estado = 2'),
(536, 3, 'insertar', 'usuario', 53, '2025-07-01 14:30:49', 'Nuevo usuario agregado: WilliamsWick, Estado = 1'),
(537, 3, 'insertar', 'usuario', 54, '2025-07-01 14:32:08', 'Nuevo usuario agregado: kurth99, Estado = 1'),
(538, 3, 'insertar', 'usuario', 55, '2025-07-01 14:33:02', 'Nuevo usuario agregado: mauchucha, Estado = 1'),
(539, 145, 'Insertar', 'movimiento', 71, '2025-07-01 15:05:53', 'Se ha registrado un nuevo movimiento.'),
(540, 145, 'insertar', 'bien', 241, '2025-07-01 15:35:33', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 200920-0902792, 46225215Y931'),
(541, 145, 'Insertar', 'movimiento', 72, '2025-07-01 15:37:13', 'Se ha registrado un nuevo movimiento.'),
(542, 146, 'insertar', 'bien', 242, '2025-07-01 16:13:50', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 200920-0902795, 46225215Y935'),
(543, 146, 'insertar', 'persona', 147, '2025-07-01 16:17:58', 'Nueva persona agregada: Descripción = Sara Miluska Olortegui Vela, 72546541 , Estado = 1'),
(544, 146, 'Insertar', 'movimiento', 73, '2025-07-01 16:20:24', 'Se ha registrado un nuevo movimiento.'),
(545, 146, 'insertar', 'bien', 243, '2025-07-01 16:45:24', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 200920-0902816, 46225215Y943'),
(546, 146, 'insertar', 'persona', 148, '2025-07-01 16:49:04', 'Nueva persona agregada: Descripción = Jennifer Mozombite Catashunga, 46226733 , Estado = 1'),
(547, 3, 'insertar', 'bien', 244, '2025-07-01 16:49:15', 'Nueva bien agregado: Descripción = GRABADORA DIGITAL, 1012819, 952245651197'),
(548, 3, 'Insertar', 'movimiento', 74, '2025-07-01 16:51:25', 'Se ha registrado un nuevo movimiento.'),
(549, 146, 'Insertar', 'movimiento', 75, '2025-07-01 16:54:14', 'Se ha registrado un nuevo movimiento.'),
(550, 3, 'insertar', 'persona', 149, '2025-07-02 13:13:28', 'Nueva persona agregada: Descripción = Briseida Morgana Llerena Arizaga, 40386949 , Estado = 1'),
(551, 3, 'insertar', 'bien', 245, '2025-07-02 13:20:17', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 1805150901195, 46225215Y920'),
(552, 3, 'Insertar', 'movimiento', 76, '2025-07-02 13:21:38', 'Se ha registrado un nuevo movimiento.'),
(553, 3, 'insertar', 'bien', 246, '2025-07-02 14:00:23', 'Nueva bien agregado: Descripción = ESTABILIZADOR, 200920-0902773, 46225215Y918'),
(554, 3, 'insertar', 'persona', 150, '2025-07-02 14:04:02', 'Nueva persona agregada: Descripción = JIMMY JOAN AMBICHO CESPEDES , 45491810 , Estado = 1'),
(555, 3, 'Insertar', 'movimiento', 77, '2025-07-02 14:05:39', 'Se ha registrado un nuevo movimiento.'),
(556, 145, 'insertar', 'menu', 8, '2025-07-06 14:05:00', 'Nuevo menu agregado: Descripción = Listar Usuarios, Estado = 1'),
(557, 145, 'insertar', 'persona', 151, '2025-07-06 15:17:18', 'Nueva persona agregada: Descripción = prueba, 12345678 , Estado = 1'),
(558, 145, 'insertar', 'usuario', 56, '2025-07-06 15:17:39', 'Nuevo usuario agregado: usuprueba, Estado = 2'),
(559, NULL, 'actualiza el estado de usuario', 'usuario', 0, '2025-07-07 16:46:02', 'Se actualizo el estado del usuario = 54'),
(560, NULL, 'actualiza el estado de usuario', 'usuario', 0, '2025-07-07 16:48:09', 'Se actualizo el estado del usuario = 54'),
(561, NULL, 'actualiza el estado de usuario', 'usuario', 54, '2025-07-07 16:53:52', 'Se actualizó el estado del usuario ID = 54 a estado = 1'),
(562, NULL, 'actualiza el estado de usuario', 'usuario', 54, '2025-07-07 17:06:19', 'Se actualizó el estado del usuario con ID = 54 a estado = 2'),
(563, 145, 'actualiza el estado de usuario', 'usuario', 54, '2025-07-07 17:08:28', 'Se actualizó el estado del usuario con ID = 54 a estado = 1'),
(564, 145, 'actualiza el estado de usuario', 'usuario', 54, '2025-07-07 17:09:01', 'Se actualizó el estado del usuario con ID = 54 a estado = 2'),
(565, 145, 'asigna módulos a usuario', 'usuario_menu', 54, '2025-07-07 17:14:15', 'Módulos anteriores: [8], nuevos módulos asignados: [6, 8]'),
(566, 145, 'asigna módulos a usuario', 'usuario_menu', 54, '2025-07-07 17:15:02', 'Módulos anteriores: [6, 8], nuevos módulos asignados: [6]'),
(567, 145, 'insertar', 'menu', 9, '2025-07-10 04:08:06', 'Nuevo menu agregado: Descripción = prueba, Estado = 1'),
(568, 145, 'insertar', 'menu', 10, '2025-07-10 04:10:18', 'Nuevo menu agregado: Descripción = prueba, Estado = 1'),
(569, 145, 'insertar', 'menu', 11, '2025-07-10 04:12:56', 'Nuevo menu agregado: Descripción = prueba2, Estado = 1'),
(570, 145, 'insertar', 'menu', 12, '2025-07-10 04:16:03', 'Nuevo menu agregado: Descripción = prueba3, Estado = 1'),
(571, 145, 'actualizar archivo', 'menu', 12, '2025-07-10 04:29:49', 'Se reemplazó el archivo por: prueba.php en menú existente con descripción \'prueba3\''),
(572, 145, 'insertar', 'menu', 13, '2025-07-10 04:30:45', 'Nuevo menú agregado: Descripción = prueba4, Archivo = prueba.php, Estado = 1'),
(573, 145, 'insertar', 'menu', 14, '2025-07-10 04:39:09', 'Nuevo menú agregado: Descripción = prueba5, Archivo = prueba.php, Estado = 1'),
(574, 145, 'insertar', 'menu', 15, '2025-07-10 04:46:54', 'Nuevo menú agregado: Descripción = prueba6, Archivo = prueba.php, Estado = 1'),
(575, 145, 'actualizar archivo', 'menu', 15, '2025-07-10 06:02:46', 'Archivos actualizados en menú \'prueba6\': nombrearchivo_ln = ?'),
(576, 145, 'actualizar archivo', 'menu', 15, '2025-07-10 06:08:47', 'Archivos actualizados en menú \'prueba6\': nombrearchivo_ad = ?, nombrearchivo_libreria = ?, nombrearchivo_img = ?'),
(577, 145, 'insertar', 'menu', 16, '2025-07-10 06:29:12', 'Nuevo menú: prueba7 con archivos.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `descripcion_menu` varchar(300) NOT NULL,
  `estado_menu` int(1) NOT NULL,
  `nombrearchivo_menu` varchar(50) DEFAULT NULL,
  `nombrearchivo_ln` varchar(50) DEFAULT NULL,
  `nombrearchivo_ad` varchar(50) DEFAULT NULL,
  `nombrearchivo_libreria` varchar(50) DEFAULT NULL,
  `nombrearchivo_img` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id_menu`, `descripcion_menu`, `estado_menu`, `nombrearchivo_menu`, `nombrearchivo_ln`, `nombrearchivo_ad`, `nombrearchivo_libreria`, `nombrearchivo_img`) VALUES
(1, 'Registrar Movimientoooo', 1, '', '', '', '', ''),
(2, 'Ver Movimentos', 1, '', '', '', '', ''),
(3, 'Resumen de  Usuarios / Bienes / Ubicación', 1, '', '', '', '', ''),
(4, 'Registrar', 1, '', '', '', '', ''),
(5, 'Ver / Editar registros actuales', 1, '', '', '', '', ''),
(6, 'Crear usuario', 1, '--', '', '', '', ''),
(8, 'Administrar Usuarios', 1, '', '', '', '', ''),
(9, 'prueba', 1, 'prueba.php', '', '', '', ''),
(10, 'prueba', 1, 'prueba.php', '', '', '', ''),
(11, 'prueba2', 1, 'prueba.php', '', '', '', ''),
(12, 'prueba3', 1, 'prueba.php', '', '', '', ''),
(13, 'prueba4', 1, 'prueba.php', '', '', '', ''),
(14, 'prueba5', 1, 'prueba.php', '', '', '', ''),
(15, 'prueba6', 1, 'prueba.php', 'prueba_ln.php', 'prueba_AD.php', 'prueba_libreria.php', 'prueba_img.php'),
(16, 'prueba7', 1, NULL, NULL, NULL, NULL, NULL);

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
(20, 14, 13, 1, 1, 2, 5, '2024-11-12', 'DOCS/mov_6733abf98bc226.56897671.pdf', 1),
(21, 13, 14, 1, 1, 5, 2, '2024-11-12', 'DOCS/mov_6733ab9abae2b1.51800556.pdf', 1),
(22, 14, 15, 1, 1, 2, 16, '2024-11-13', 'DOCS/mov_6734dda3517321.50903291.pdf', 1),
(23, 14, 16, 1, 1, 2, 14, '2024-11-13', 'DOCS/mov_673f659580f4a6.43042358.pdf', 2),
(24, 14, 17, 1, 1, 2, 14, '2024-11-13', 'DOCS/mov_673f65afe63a87.63086672.pdf', 1),
(25, 14, 18, 1, 1, 2, 19, '2024-11-20', 'DOCS/mov_673f657a46dd71.72844975.pdf', 1),
(26, 14, 19, 1, 1, 2, 3, '2024-11-20', 'DOCS/mov_673f6546667d64.86428609.pdf', 1),
(27, 14, 114, 1, 1, 2, 4, '2024-11-26', 'DOCS/mov_6798eb6f7910d7.97761062.pdf', 1),
(28, 14, 53, 1, 1, 2, 31, '2025-01-21', 'DOCS/mov_6798e696366ad2.69740764.pdf', 1),
(29, 14, 135, 1, 1, 2, 30, '2025-01-21', 'DOCS/mov_6798e6a1187580.27712440.pdf', 1),
(30, 14, 123, 1, 1, 2, 13, '2025-01-22', 'DOCS/mov_6798e68c4ea8c7.95928685.pdf', 1),
(31, 14, 90, 1, 1, 2, 21, '2025-01-23', 'DOCS/mov_6798e659b27688.17369334.pdf', 1),
(32, 14, 45, 1, 1, 2, 28, '2025-01-23', 'DOCS/mov_6798e66c9ed439.97704861.pdf', 1),
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
(55, 14, 19, 1, 1, 2, 3, '2025-06-11', '--', 0),
(56, 14, 62, 1, 1, 2, 14, '2025-06-11', '--', 0),
(57, 14, 72, 1, 1, 2, 14, '2025-06-11', '--', 0),
(58, 14, 142, 1, 1, 2, 3, '2025-06-11', '--', 0),
(59, 14, 129, 1, 1, 2, 39, '2025-06-11', '--', 0),
(60, 14, 13, 1, 1, 2, 22, '2025-06-11', '--', 0),
(62, 14, 143, 1, 1, 2, 19, '2025-06-11', '--', 0),
(63, 14, 74, 1, 1, 2, 3, '2025-06-11', '--', 0),
(64, 14, 61, 1, 1, 2, 3, '2025-06-12', '--', 0),
(65, 14, 63, 1, 1, 2, 4, '2025-06-12', '--', 0),
(66, 14, 18, 1, 1, 2, 19, '2025-06-12', '--', 0),
(67, 14, 134, 1, 1, 2, 14, '2025-06-12', '--', 0),
(68, 14, 54, 1, 1, 2, 5, '2025-06-12', '--', 0),
(69, 14, 46, 1, 1, 2, 29, '2025-06-12', '--', 0),
(70, 14, 123, 1, 1, 2, 13, '2025-06-19', '--', 0),
(71, 14, 66, 1, 1, 2, 20, '2025-07-01', '--', 0),
(72, 14, 47, 1, 1, 2, 20, '2025-07-01', '--', 0),
(73, 14, 147, 1, 1, 2, 20, '2025-07-01', '--', 0),
(74, 14, 142, 1, 1, 2, 3, '2025-07-01', '--', 0),
(75, 14, 148, 1, 1, 2, 20, '2025-07-01', '--', 0),
(76, 14, 149, 1, 1, 2, 20, '2025-07-01', '--', 0),
(77, 14, 150, 1, 1, 2, 20, '2025-07-01', '--', 0);

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
(18, 'LECTOR DE CÓDIGO DE BARRAS', 1);

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
(151, 'prueba', '12345678', '123456789', '-', '-', 1);

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
(56, 151, 'usuprueba', '202cb962ac59075b964b07152d234b70', 2);

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
(20, 54, 6);

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
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `bien`
--
ALTER TABLE `bien`
  MODIFY `id_bien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT de la tabla `dependencia`
--
ALTER TABLE `dependencia`
  MODIFY `id_dependencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detallemovimiento`
--
ALTER TABLE `detallemovimiento`
  MODIFY `id_detallemovimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;

--
-- AUTO_INCREMENT de la tabla `log_acciones`
--
ALTER TABLE `log_acciones`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=578;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `nombre_bien`
--
ALTER TABLE `nombre_bien`
  MODIFY `id_nombre_bien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `usuario_menu`
--
ALTER TABLE `usuario_menu`
  MODIFY `id_usuariomenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuario_menu`
--
ALTER TABLE `usuario_menu`
  ADD CONSTRAINT `usuario_menu_ibfk_1` FOREIGN KEY (`id_usuario_menu`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `usuario_menu_ibfk_2` FOREIGN KEY (`id_menu_usuario_menu`) REFERENCES `menu` (`id_menu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
