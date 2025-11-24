-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 24-11-2025 a las 01:37:28
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `club_santiago`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pais` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_hora_local` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`, `nombre`, `correo`, `foto`, `pais`, `estado`, `fecha_hora_local`, `created_at`) VALUES
(1, 'admin', '$2y$10$87DHvo7aJrG4eJ4Byc.t0O6SE9wH6/yUI1PewxxFzHmrydKAguQ/i', '', '', 'uploads/1763834370_Capturadepantalla2025-11-19142407.png', '', '', '2025-11-15 12:45:00', '2025-11-14 19:43:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `capacidad` int(11) NOT NULL,
  `recamaras` int(11) DEFAULT NULL,
  `banos` int(11) DEFAULT NULL,
  `estacionamiento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion_corta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion_larga` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `ubicacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `distancia_mar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `servicios` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `indicaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `enlace_drive` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `datos_contacto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto_principal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado_base` enum('disponible','no_disponible') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'disponible',
  `categoria` enum('renta','venta','villa') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'renta',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `properties`
--

INSERT INTO `properties` (`id`, `nombre`, `capacidad`, `recamaras`, `banos`, `estacionamiento`, `descripcion_corta`, `descripcion_larga`, `ubicacion`, `distancia_mar`, `servicios`, `indicaciones`, `enlace_drive`, `datos_contacto`, `foto_principal`, `estado_base`, `categoria`, `created_at`) VALUES
(6, 'Casa Aurora', 10, 4, 4, '4 autos', 'Cupo máximo 10 Personas. Casa frente al mar de 4 recamaras, 4 baños completos, cocina completamente equipada, sala con servicio de TV/SKY y acceso a Internet, comedor, terraza con asador, vista al mar y alberca privada.   Ubicación: Calle Tiburón G-07 den', 'Distribución de las habitaciones;\r\nPlanta baja:   \r\nRecamara # 1 dos camas individuales\r\nRecamara # 2 una cama Kingsize\r\nPlanta alta:    \r\nRecamara # 3 una cama Kingsize\r\nRecamara # 4 dos camas King size o se puede convertir en 4 individuales.  \r\n(Las recamaras cuentan con baño completo, aire acondicionado y ventiladores en toda la casa.)\r\n\r\nMás un deposito en garantía por $ 2,000.00 ( Dos mil pesos 00/100 m.n. )  mismo que se reembolsan a su salida de no haber ningún daño o faltante en el inmueble. \r\nServicio de limpieza diario incluido.', 'Calle Tiburón G-07 dentro del Fraccionamiento Club Santiago.', 'Frente a la playa', 'Agua Potable\r\nAgua caliente\r\nInternet\r\nSala con TV\r\nServicio de SKY\r\nServicio de Mantenimientto general\r\nServicio de Limpieza\r\nA/C en todos los cuartos\r\nVentilador de techo en todos los cuartos \r\nTerraza a pie de playa\r\nAlberca privada\r\nEstacionamiento\r\nServicio de carpinteria', 'Por instrucciones de los dueños me han exigido cumplir con los siguientes requisitos.\r\n \r\n-       Horario de entrada a las 3:00 PM\r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\nEn temporada baja se puede llegar más temprano solo con previa negociación la cual tendrá un costo extra.\r\n                                                                                          \r\n-       Horario de salida a las 12:00 PM          \r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\n \r\n \r\n-       No se permiten mascotas.\r\n \r\n-       El Fraccionamiento Club Santiago es un lugar de descanso vacacional y residencial.\r\nLa renta es solo para hospedaje vacacional, están prohibidas las fiestas o los convivios.\r\nEstá prohibido tener música a alto volumen durante el día y la noche.\r\nFavor de NO afectar la tranquilidad de los vecinos.     \r\n \r\n-       La unidad cuenta con toallas de baño para el cupo especificado, se recomienda traer toallas de playa.', 'https://drive.google.com/drive/folders/1J18Fcv0uMBcOWKQwORruHVgjpac18rTn?usp=sharing', 'Lic. Gregorio Álvarez Romero Calle Delfín D-05, Fracc. Club Santiago, Manzanillo, Colima, MX. C.P. 28868 Tel. (314) 335.0525 / (314) 335.0026 / (314) 335.1085 Email: goyorealestate@gmail.com  Web: www.inmobiliariamanzanillo.mx  Facebook: Inmobiliaria Club', 'uploads/propiedades/1763779000_a.jpg', 'disponible', 'renta', '2025-11-21 20:24:06'),
(7, 'CASA HILL', 11, 3, 3, '4 autos', 'Cupo Máximo 11 personas Frente a la playa Casa 3 dormitorios con su propio baño completo cocina, totalmente equipada, comedor, sala con TV servicio de SKY e Internet, terraza con vista al mar y piscina privada. Localización: M-13 en la calle Camarón, Club', 'Distribución de las habitaciones:\r\nRecamara # 1 Cama Kingsize mas dos camitas individuales una en cada lado.\r\nRecamara # 2 Cama Kingsize mas dos camitas individuales una en cada lado.\r\nRecamara # 3 Cama Queen mas una camita individual. \r\n(Las recamaras cuentan con baño propio, aire acondicionado y ventiladores en toda la casa.)\r\n\r\nServicio de limpieza diario incluido.\r\n\r\nMás un depósito en garantía por $ 1,000.00 ( Mil pesos 00/100 m.n. )  mismo que se reembolsan a su salida de no haber ningún daño o faltante en el inmueble.', 'M-13 en la calle Camarón, Club Santiago, Manzanillo.', 'Frente a la playa', 'Agua Potable\r\nAgua caliente\r\nInternet\r\nSala con TV\r\nServicio de SKY\r\nServicio de Mantenimientto general\r\nServicio de Limpieza\r\nA/C en todos los cuartos\r\nVentilador de techo en todos los cuartos \r\nTerraza a pie de playa\r\nAlberca privada\r\nEstacionamiento\r\nServicio de carpinteria', 'Por instrucciones de los dueños me han exigido cumplir con los siguientes requisitos.\r\n \r\n-       Horario de entrada a las 3:00 PM\r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\nEn temporada baja se puede llegar más temprano solo con previa negociación la cual tendrá un costo extra.\r\n                                                                                          \r\n-       Horario de salida a las 12:00 PM          \r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\n \r\n-       No se permiten mascotas.\r\n \r\n-       El Fraccionamiento Club Santiago es un lugar de descanso vacacional y residencial.\r\nLa renta es solo para hospedaje vacacional, están prohibidas las fiestas o los convivios.\r\nEstá prohibido tener música a alto volumen durante el día y la noche.\r\nFavor de NO afectar la tranquilidad de los vecinos.     \r\n \r\n-       La unidad cuenta con toallas de baño para el cupo especificado, se recomienda traer toallas de playa.', 'https://drive.google.com/drive/folders/12PfDbm_Bkx-xqV_PZXB2usn3A3STKghx?usp=sharing', 'Lic. Gregorio Álvarez Romero Calle Delfín D-05, Fracc. Club Santiago, Manzanillo, Colima, MX. C.P. 28868 Tel. (314) 335.0525 / (314) 335.0026 / (314) 335.1085 Email: goyorealestate@gmail.com  Web: www.inmobiliariamanzanillo.mx  Facebook: Inmobiliaria Club', 'uploads/propiedades/1763788610_a.jpg', 'disponible', 'renta', '2025-11-21 23:16:50'),
(8, 'Casa CROTOS', 12, 4, 5, '4 autos', 'Cupo máximo 12 Personas. Casa de 4 recamaras, 4 baños completos más medio baño de visitas, cocina completamente equipada, comedor, sala con servicio de TV/SKY y acceso a Internet, terraza con vista al jardín y alberca privada.   Ubicación: Calle Camarón M', 'Distribución de las habitaciones;\r\nPlanta baja:   \r\nRecamara # 1 cama Kinzsase\r\nPlanta alta:   \r\nRecamara # 2 dos camas matrimoniales\r\nRecamara # 3 cama Kinzsase\r\nRecamara # 4 dos camas matrimoniales\r\n(Las recamaras cuentan con baño completo propio, aire acondicionado y ventiladores en toda la casa.)\r\nServicio de limpieza diario incluido.\r\n\r\nMás un depósito en garantía por $ 1,000.00 ( Mil pesos 00/100 m.n. ) mismo que se reembolsan a su salida de no haber ningún daño o faltante en el inmueble.', 'Calle Camarón M-03 dentro del Fraccionamiento Club Santiago.', 'Media cuadra, aproximadamente a 50Mts está el acceso a la playa.', 'Agua Potable\r\nAgua caliente\r\nInternet\r\nSala con TV\r\nServicio de SKY\r\nServicio de Mantenimientto general\r\nServicio de Limpieza\r\nA/C en todos los cuartos\r\nVentilador de techo en todos los cuartos \r\nAlberca privada\r\nEstacionamiento\r\nServicio de carpinteria', 'Por instrucciones de los dueños me han exigido cumplir con los siguientes requisitos.\r\n \r\n-       Horario de entrada a las 3:00 PM\r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\nEn temporada baja se puede llegar más temprano solo con previa negociación la cual tendrá un costo extra.\r\n                                                                                          \r\n-       Horario de salida a las 12:00 PM          \r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\n \r\n \r\n-       No se permiten mascotas.\r\n \r\n-       El Fraccionamiento Club Santiago es un lugar de descanso vacacional y residencial.\r\nLa renta es solo para hospedaje vacacional, están prohibidas las fiestas o los convivios.\r\nEstá prohibido tener música a alto volumen durante el día y la noche.\r\nFavor de NO afectar la tranquilidad de los vecinos.     \r\n \r\n-       La unidad cuenta con toallas de baño para el cupo especificado, se recomienda traer toallas de playa.', 'https://drive.google.com/drive/folders/1bylOAUYHpsqVcwiSYRYiYmATF4-u-JO-?usp=sharing', 'Lic. Gregorio Álvarez Romero Calle Delfín D-05, Fracc. Club Santiago, Manzanillo, Colima, MX. C.P. 28868 Tel. (314) 335.0525 / (314) 335.0026 / (314) 335.1085 Email: goyorealestate@gmail.com  Web: www.inmobiliariamanzanillo.mx  Facebook: Inmobiliaria Club', 'uploads/propiedades/1763789099_a.jpg', 'disponible', 'renta', '2025-11-21 23:24:59'),
(9, 'Casa G-14-B', 12, 3, 3, '2 autos', 'Cupo máximo 12 Personas Casa muy amplia de 3 recamaras, 3 baños completos más medio baño de visitas, sala con servicio de TV/SKY y acceso a Internet, cocina completamente equipada, comedor, terraza con asador, vista al jardín y alberca privada. Ubicación:', 'Distribución de las habitaciones: \r\nPlanta baja:\r\nRecamara # 1 dos camas matrimoniales  \r\nPlanta alta:  \r\nRecamara # 2 dos camas matrimoniales\r\nRecamara # 3 dos camas matrimoniales\r\nEstudio con estar de TV\r\nLas habitaciones cuentan con baño completo, aire acondicionado y ventiladores en toda la casa.\r\n\r\nServicio de limpieza diario incluido.\r\nMás un depósito en garantía por $ 1,000.00 ( Mil pesos 00/100 m.n. )  mismo que se reembolsan a su salida de no haber ningún daño o faltante en el inmueble.', 'Calle Tiburón G-14 dentro del Fraccionamiento Club Santiago.', 'Media cuadra, aproximadamente a 50Mts está el acceso a la playa.', 'Agua Potable\r\nAgua caliente\r\nInternet\r\nSala con TV\r\nServicio de SKY\r\nServicio de Mantenimientto general\r\nServicio de Limpieza\r\nA/C en todos los cuartos\r\nVentilador de techo en todos los cuartos \r\nAlberca privada\r\nEstacionamiento\r\nServicio de carpinteria', 'Por instrucciones de los dueños me han exigido cumplir con los siguientes requisitos.\r\n -       Horario de entrada a las 3:00 PM\r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\nEn temporada baja se puede llegar más temprano solo con previa negociación la cual tendrá un costo extra.\r\n                                                                                          \r\n-       Horario de salida a las 12:00 PM          \r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\n \r\n-       No se permiten mascotas.\r\n \r\n-       El Fraccionamiento Club Santiago es un lugar de descanso vacacional y residencial.\r\nLa renta es solo para hospedaje vacacional, están prohibidas las fiestas o los convivios.\r\nEstá prohibido tener música a alto volumen durante el día y la noche.\r\nFavor de NO afectar la tranquilidad de los vecinos.     \r\n \r\n-       La unidad cuenta con toallas de baño para el cupo especificado, se recomienda traer toallas de playa.', 'https://drive.google.com/drive/folders/1oyBzXT5E0ft9w7z0D5iVlaHTDrQPd6Rg?usp=sharing', 'Lic. Gregorio Álvarez Romero Calle Delfín D-05, Fracc. Club Santiago, Manzanillo, Colima, MX. C.P. 28868 Tel. (314) 335.0525 / (314) 335.0026 / (314) 335.1085 Email: goyorealestate@gmail.com  Web: www.inmobiliariamanzanillo.mx  Facebook: Inmobiliaria Club', 'uploads/propiedades/1763834592_a.jpg', 'disponible', 'renta', '2025-11-21 23:30:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `property_calendar`
--

CREATE TABLE `property_calendar` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` enum('ocupada','no_disponible') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `property_calendar`
--

INSERT INTO `property_calendar` (`id`, `property_id`, `fecha_inicio`, `fecha_fin`, `estado`) VALUES
(6, 9, '2025-11-22', '2025-11-23', 'ocupada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `property_photos`
--

CREATE TABLE `property_photos` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `orden` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `property_photos`
--

INSERT INTO `property_photos` (`id`, `property_id`, `archivo`, `titulo`, `orden`, `created_at`) VALUES
(26, 6, 'uploads/propiedades/1763779000_0_ac.jpg', NULL, 0, '2025-11-21 20:36:40'),
(27, 6, 'uploads/propiedades/1763779000_1_b.jpg', NULL, 1, '2025-11-21 20:36:40'),
(28, 6, 'uploads/propiedades/1763779000_2_bcd.jpg', NULL, 2, '2025-11-21 20:36:40'),
(29, 6, 'uploads/propiedades/1763779000_3_ca.jpg', NULL, 3, '2025-11-21 20:36:40'),
(30, 6, 'uploads/propiedades/1763779000_4_fff.jpg', NULL, 4, '2025-11-21 20:36:40'),
(31, 6, 'uploads/propiedades/1763779000_5_h.jpg', NULL, 5, '2025-11-21 20:36:40'),
(32, 6, 'uploads/propiedades/1763779000_6_hcc.jpg', NULL, 6, '2025-11-21 20:36:40'),
(33, 6, 'uploads/propiedades/1763779000_7_if.jpg', NULL, 7, '2025-11-21 20:36:40'),
(34, 7, 'uploads/propiedades/1763788611_0_b.jpg', NULL, 0, '2025-11-21 23:16:51'),
(35, 7, 'uploads/propiedades/1763788611_1_g.jpg', NULL, 1, '2025-11-21 23:16:51'),
(36, 7, 'uploads/propiedades/1763788611_2_j.jpg', NULL, 2, '2025-11-21 23:16:51'),
(37, 7, 'uploads/propiedades/1763788611_3_ll.jpg', NULL, 3, '2025-11-21 23:16:51'),
(38, 7, 'uploads/propiedades/1763788611_4_m-3-2.jpg', NULL, 4, '2025-11-21 23:16:51'),
(39, 7, 'uploads/propiedades/1763788611_6_x.jpg', NULL, 6, '2025-11-21 23:16:51'),
(40, 8, 'uploads/propiedades/1763789099_0_b.jpg', NULL, 0, '2025-11-21 23:24:59'),
(41, 8, 'uploads/propiedades/1763789099_1_d.jpg', NULL, 1, '2025-11-21 23:24:59'),
(42, 8, 'uploads/propiedades/1763789099_2_l.jpg', NULL, 2, '2025-11-21 23:24:59'),
(43, 8, 'uploads/propiedades/1763789099_3_t.jpg', NULL, 3, '2025-11-21 23:24:59'),
(44, 8, 'uploads/propiedades/1763789099_4_tt.jpg', NULL, 4, '2025-11-21 23:24:59'),
(45, 8, 'uploads/propiedades/1763789099_5_vv.jpg', NULL, 5, '2025-11-21 23:24:59'),
(46, 8, 'uploads/propiedades/1763789099_6_za.jpg', NULL, 6, '2025-11-21 23:24:59'),
(47, 8, 'uploads/propiedades/1763789099_7_zj.jpg', NULL, 7, '2025-11-21 23:24:59'),
(56, 9, 'uploads/propiedades/1763834592_0_b.jpg', NULL, 0, '2025-11-22 12:03:12'),
(57, 9, 'uploads/propiedades/1763834592_1_f.jpg', NULL, 1, '2025-11-22 12:03:12'),
(58, 9, 'uploads/propiedades/1763834593_2_k.jpg', NULL, 2, '2025-11-22 12:03:13'),
(59, 9, 'uploads/propiedades/1763834593_3_o.jpg', NULL, 3, '2025-11-22 12:03:13'),
(60, 9, 'uploads/propiedades/1763834593_4_qq.jpg', NULL, 4, '2025-11-22 12:03:13'),
(61, 9, 'uploads/propiedades/1763834593_5_s.jpg', NULL, 5, '2025-11-22 12:03:13'),
(62, 9, 'uploads/propiedades/1763834593_6_nn.jpg', NULL, 6, '2025-11-22 12:03:13'),
(63, 9, 'uploads/propiedades/1763834593_7_n.jpg', NULL, 7, '2025-11-22 12:03:13');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `property_calendar`
--
ALTER TABLE `property_calendar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_calendar_property` (`property_id`);

--
-- Indices de la tabla `property_photos`
--
ALTER TABLE `property_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_property_photos` (`property_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `property_calendar`
--
ALTER TABLE `property_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `property_photos`
--
ALTER TABLE `property_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `property_calendar`
--
ALTER TABLE `property_calendar`
  ADD CONSTRAINT `fk_calendar_property` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `property_photos`
--
ALTER TABLE `property_photos`
  ADD CONSTRAINT `fk_property_photos` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
