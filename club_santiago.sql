-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 11-12-2025 a las 23:46:47
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
(1, 'admin', '$2y$10$87DHvo7aJrG4eJ4Byc.t0O6SE9wH6/yUI1PewxxFzHmrydKAguQ/i', 'Dimas', 'adimas2@ucol.mx', 'uploads/1764380066_Capturadepantalla2025-11-19142407.png', 'mexico', 'manzanillo', '2025-11-28 19:35:00', '2025-11-14 19:43:01');

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
(7, 'CASA HILL', 11, 3, 3, '4 autos', 'Cupo Máximo 11 personas Frente a la playa Casa 3 dormitorios con su propio baño completo cocina, totalmente equipada, comedor, sala con TV servicio de SKY e Internet, terraza con vista al mar y piscina privada. Localización: M-13 en la calle Camarón, Club', 'Distribución de las habitaciones:\r\nRecamara # 1 Cama Kingsize mas dos camitas individuales una en cada lado.\r\nRecamara # 2 Cama Kingsize mas dos camitas individuales una en cada lado.\r\nRecamara # 3 Cama Queen mas una camita individual. \r\n(Las recamaras cuentan con baño propio, aire acondicionado y ventiladores en toda la casa.)\r\n\r\nServicio de limpieza diario incluido.\r\n\r\nMás un depósito en garantía por $ 1,000.00 ( Mil pesos 00/100 m.n. )  mismo que se reembolsan a su salida de no haber ningún daño o faltante en el inmueble.', 'M-13 en la calle Camarón, Club Santiago, Manzanillo.', 'Frente a la playa', 'Agua Potable\r\nAgua caliente\r\nInternet\r\nSala con TV\r\nServicio de SKY\r\nServicio de Mantenimientto general\r\nServicio de Limpieza\r\nA/C en todos los cuartos\r\nVentilador de techo en todos los cuartos \r\nTerraza a pie de playa\r\nAlberca privada\r\nEstacionamiento\r\nServicio de carpinteria', 'Por instrucciones de los dueños me han exigido cumplir con los siguientes requisitos.\r\n \r\n-       Horario de entrada a las 3:00 PM\r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\nEn temporada baja se puede llegar más temprano solo con previa negociación la cual tendrá un costo extra.\r\n                                                                                          \r\n-       Horario de salida a las 12:00 PM          \r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\n \r\n-       No se permiten mascotas.\r\n \r\n-       El Fraccionamiento Club Santiago es un lugar de descanso vacacional y residencial.\r\nLa renta es solo para hospedaje vacacional, están prohibidas las fiestas o los convivios.\r\nEstá prohibido tener música a alto volumen durante el día y la noche.\r\nFavor de NO afectar la tranquilidad de los vecinos.     \r\n \r\n-       La unidad cuenta con toallas de baño para el cupo especificado, se recomienda traer toallas de playa.', 'https://drive.google.com/drive/folders/12PfDbm_Bkx-xqV_PZXB2usn3A3STKghx?usp=sharing', 'Lic. Gregorio Álvarez Romero Calle Delfín D-05, Fracc. Club Santiago, Manzanillo, Colima, MX. C.P. 28868 Tel. (314) 335.0525 / (314) 335.0026 / (314) 335.1085 Email: goyorealestate@gmail.com  Web: www.inmobiliariamanzanillo.mx  Facebook: Inmobiliaria Club', 'uploads/propiedades/1763948911_a.jpg', 'disponible', 'renta', '2025-11-21 23:16:50'),
(8, 'Casa CROTOS', 12, 4, 5, '4 autos', 'Cupo máximo 12 Personas. Casa de 4 recamaras, 4 baños completos más medio baño de visitas, cocina completamente equipada, comedor, sala con servicio de TV/SKY y acceso a Internet, terraza con vista al jardín y alberca privada.   Ubicación: Calle Camarón M', 'Distribución de las habitaciones;\r\nPlanta baja:   \r\nRecamara # 1 cama Kinzsase\r\nPlanta alta:   \r\nRecamara # 2 dos camas matrimoniales\r\nRecamara # 3 cama Kinzsase\r\nRecamara # 4 dos camas matrimoniales\r\n(Las recamaras cuentan con baño completo propio, aire acondicionado y ventiladores en toda la casa.)\r\nServicio de limpieza diario incluido.\r\n\r\nMás un depósito en garantía por $ 1,000.00 ( Mil pesos 00/100 m.n. ) mismo que se reembolsan a su salida de no haber ningún daño o faltante en el inmueble.', 'Calle Camarón M-03 dentro del Fraccionamiento Club Santiago.', 'Media cuadra, aproximadamente a 50Mts está el acceso a la playa.', 'Agua Potable\r\nAgua caliente\r\nInternet\r\nSala con TV\r\nServicio de SKY\r\nServicio de Mantenimientto general\r\nServicio de Limpieza\r\nA/C en todos los cuartos\r\nVentilador de techo en todos los cuartos \r\nAlberca privada\r\nEstacionamiento\r\nServicio de carpinteria', 'Por instrucciones de los dueños me han exigido cumplir con los siguientes requisitos.\r\n \r\n-       Horario de entrada a las 3:00 PM\r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\nEn temporada baja se puede llegar más temprano solo con previa negociación la cual tendrá un costo extra.\r\n                                                                                          \r\n-       Horario de salida a las 12:00 PM          \r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\n \r\n \r\n-       No se permiten mascotas.\r\n \r\n-       El Fraccionamiento Club Santiago es un lugar de descanso vacacional y residencial.\r\nLa renta es solo para hospedaje vacacional, están prohibidas las fiestas o los convivios.\r\nEstá prohibido tener música a alto volumen durante el día y la noche.\r\nFavor de NO afectar la tranquilidad de los vecinos.     \r\n \r\n-       La unidad cuenta con toallas de baño para el cupo especificado, se recomienda traer toallas de playa.', 'https://drive.google.com/drive/folders/1bylOAUYHpsqVcwiSYRYiYmATF4-u-JO-?usp=sharing', 'Lic. Gregorio Álvarez Romero Calle Delfín D-05, Fracc. Club Santiago, Manzanillo, Colima, MX. C.P. 28868 Tel. (314) 335.0525 / (314) 335.0026 / (314) 335.1085 Email: goyorealestate@gmail.com  Web: www.inmobiliariamanzanillo.mx  Facebook: Inmobiliaria Club', 'uploads/propiedades/1763789099_a.jpg', 'disponible', 'renta', '2025-11-21 23:24:59'),
(9, 'Casa G-14-B', 12, 3, 3, '2 autos', 'Cupo máximo 12 Personas Casa muy amplia de 3 recamaras, 3 baños completos más medio baño de visitas, sala con servicio de TV/SKY y acceso a Internet, cocina completamente equipada, comedor, terraza con asador, vista al jardín y alberca privada. Ubicación:', 'Distribución de las habitaciones: \r\nPlanta baja:\r\nRecamara # 1 dos camas matrimoniales  \r\nPlanta alta:  \r\nRecamara # 2 dos camas matrimoniales\r\nRecamara # 3 dos camas matrimoniales\r\nEstudio con estar de TV\r\nLas habitaciones cuentan con baño completo, aire acondicionado y ventiladores en toda la casa.\r\n\r\nServicio de limpieza diario incluido.\r\nMás un depósito en garantía por $ 1,000.00 ( Mil pesos 00/100 m.n. )  mismo que se reembolsan a su salida de no haber ningún daño o faltante en el inmueble.', 'Calle Tiburón G-14 dentro del Fraccionamiento Club Santiago.', 'Media cuadra, aproximadamente a 50Mts está el acceso a la playa.', 'Agua Potable\r\nAgua caliente\r\nInternet\r\nSala con TV\r\nServicio de SKY\r\nServicio de Mantenimientto general\r\nServicio de Limpieza\r\nA/C en todos los cuartos\r\nVentilador de techo en todos los cuartos \r\nAlberca privada\r\nEstacionamiento\r\nServicio de carpinteria', 'Por instrucciones de los dueños me han exigido cumplir con los siguientes requisitos.\r\n -       Horario de entrada a las 3:00 PM\r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\nEn temporada baja se puede llegar más temprano solo con previa negociación la cual tendrá un costo extra.\r\n                                                                                          \r\n-       Horario de salida a las 12:00 PM          \r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\n \r\n-       No se permiten mascotas.\r\n \r\n-       El Fraccionamiento Club Santiago es un lugar de descanso vacacional y residencial.\r\nLa renta es solo para hospedaje vacacional, están prohibidas las fiestas o los convivios.\r\nEstá prohibido tener música a alto volumen durante el día y la noche.\r\nFavor de NO afectar la tranquilidad de los vecinos.     \r\n \r\n-       La unidad cuenta con toallas de baño para el cupo especificado, se recomienda traer toallas de playa.', 'https://drive.google.com/drive/folders/1oyBzXT5E0ft9w7z0D5iVlaHTDrQPd6Rg?usp=sharing', 'Lic. Gregorio Álvarez Romero Calle Delfín D-05, Fracc. Club Santiago, Manzanillo, Colima, MX. C.P. 28868 Tel. (314) 335.0525 / (314) 335.0026 / (314) 335.1085 Email: goyorealestate@gmail.com  Web: www.inmobiliariamanzanillo.mx  Facebook: Inmobiliaria Club', 'uploads/propiedades/1763834592_a.jpg', 'disponible', 'renta', '2025-11-21 23:30:17'),
(10, 'Casa Obelisco', 12, 4, 4, '2 autos', 'Cupo máximo 12 Personas. Casa de 4 recamaras, 4 baños completos más medio baño de visitas, cocina completamente equipada, comedor, sala con servicio de TV/SKY y acceso a Internet, terraza con vista al jardín y alberca privada.   Ubicación: Calle Camarón M', 'Distribución de las habitaciones;\r\nPlanta baja:   \r\nRecamara # 1 cama Kingsize\r\nPlanta alta:   \r\nRecamara # 2 dos camas matrimoniales\r\nRecamara # 3 cama Kingsize\r\nRecamara # 4 dos camas matrimoniales\r\nLas recamaras cuentan con baño completo propio, aire acondicionado y ventiladores en toda la casa.\r\n        \r\nServicio de limpieza diario incluido.\r\nMás un depósito en garantía por $ 1,000.00 ( Mil pesos 00/100 m.n. ) mismo que se reembolsan a su salida de no haber ningún daño o faltante en el inmueble.', 'Calle Camarón M-03 dentro del Fraccionamiento Club Santiago.', 'Media cuadra, aproximadamente a 50Mts está el acceso a la playa.', '', 'Por instrucciones de los dueños me han exigido cumplir con los siguientes requisitos.\r\n \r\n-       Horario de entrada a las 3:00 PM\r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\nEn temporada baja se puede llegar más temprano solo con previa negociación la cual tendrá un costo extra.\r\n                                                                                          \r\n-       Horario de salida a las 12:00 PM          \r\nEn temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\n \r\n-       No se permiten mascotas.\r\n \r\n-       El Fraccionamiento Club Santiago es un lugar de descanso vacacional y residencial.\r\nLa renta es solo para hospedaje vacacional, están prohibidas las fiestas o los convivios.\r\nEstá prohibido tener música a alto volumen durante el día y la noche.\r\nFavor de NO afectar la tranquilidad de los vecinos.     \r\n \r\n-       La unidad cuenta con toallas de baño para el cupo especificado, se recomienda traer toallas de playa.', 'https://drive.google.com/drive/folders/1o75r5CUHE5VAw5UY35tC4rjhzXquh0BL?usp=sharing', 'Lic. Gregorio Álvarez Romero Calle Delfín D-05, Fracc. Club Santiago, Manzanillo, Colima, MX. C.P. 28868 Tel. (314) 335.0525 / (314) 335.0026 / (314) 335.1085 Email: goyorealestate@gmail.com  Web: www.inmobiliariamanzanillo.mx  Facebook: Inmobiliaria Club', 'uploads/propiedades/1765496112_a.jpg', 'disponible', 'renta', '2025-12-10 19:32:28'),
(11, 'CASA ANGRAF', 10, 3, 4, '2 autos', 'Cupo máximo 10 Personas Casa muy amplia de 3 recamaras, 4 baños completos, sala con servicio de TV/SKY y acceso a Internet, cocina completamente equipada, comedor, terraza con asador, vista al jardín y alberca privada. Ubicación: Calle Jaiba H-11 dentro d', 'Distribución de las habitaciones: \r\nPlanta baja:\r\nRecamara # 1 cama kingsize\r\nPlanta alta:  \r\nRecamara # 2 dos camas matrimoniales\r\nRecamara # 3 cama kingsize\r\n(Las habitaciones cuentan con baño completo y aire acondicionado.)\r\nLas recamaras de la planta alta cuentan con una terraza grande en común con vista a los jardines.\r\n\r\nServicio de limpieza diario.\r\nMás depósito en garantía por $ 1,000.00 mismo que se reembolsan a su salida de no haber ningún daño o faltante en el inmueble.', 'Calle Jaiba H-11 dentro del Fraccionamiento Club Santiago.', 'A una cuadra, aproximadamente 150Mt caminando por el área de jardines.', 'Agua Potable\r\nAgua caliente\r\nInternet\r\nSala con TV\r\nServicio de SKY\r\nServicio de Mantenimientto general\r\nServicio de Limpieza\r\nA/C en todos los cuartos\r\nVentilador de techo en todos los cuartos\r\nAlberca privada\r\nEstacionamiento\r\nServicio de carpinteria', 'Por instrucciones de los dueños me han exigido cumplir con los siguientes requisitos.\r\n \r\n-       Horario de entrada a las 3:00 PM\r\n-    En temporada vacacional favor de respetar el horario de entrada, no hay excepciones.\r\n-    En temporada baja se puede llegar más temprano solo con previa negociación la cual tendrá un costo extra.                                                                               \r\n-       Horario de salida a las 12:00 PM          \r\n-    En temporada vacacional favor de respetar el horario de entrada, no hay excepciones. \r\n-       No se permiten mascotas. \r\n-       El Fraccionamiento Club Santiago es un lugar de descanso vacacional y residencial.\r\n-    La renta es solo para hospedaje vacacional, están prohibidas las fiestas o los convivios.\r\n-    Está prohibido tener música a alto volumen durante el día y la noche.\r\n-    Favor de NO afectar la tranquilidad de los vecinos.     \r\n-    No incluye lavado de loza. \r\n-       La unidad cuenta con toallas de baño para el cupo especificado, se recomienda traer toallas de playa.', 'https://drive.google.com/drive/folders/12SXHHa0UHFt-Ilk6a91nnsMuvkQqRu4a?usp=sharing', 'Lic. Gregorio Álvarez Romero Calle Delfín D-05, Fracc. Club Santiago, Manzanillo, Colima, MX. C.P. 28868 Tel. (314) 335.0525 / (314) 335.0026 / (314) 335.1085 Email: goyorealestate@gmail.com  Web: www.inmobiliariamanzanillo.mx  Facebook: Inmobiliaria Club', 'uploads/propiedades/1765496405_ab.jpg', 'disponible', 'renta', '2025-12-11 17:40:05');

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
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `tipo` enum('slider','galeria') COLLATE utf8mb4_general_ci DEFAULT 'slider'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `property_photos`
--

INSERT INTO `property_photos` (`id`, `property_id`, `archivo`, `titulo`, `orden`, `created_at`, `tipo`) VALUES
(99, 8, 'uploads/propiedades/1764950495_SL_0_a.jpg', NULL, 0, '2025-12-05 10:01:35', 'slider'),
(100, 8, 'uploads/propiedades/1764950495_SL_1_b.jpg', NULL, 0, '2025-12-05 10:01:35', 'slider'),
(101, 8, 'uploads/propiedades/1764950495_SL_2_d.jpg', NULL, 0, '2025-12-05 10:01:35', 'slider'),
(102, 8, 'uploads/propiedades/1764950496_SL_3_l.jpg', NULL, 0, '2025-12-05 10:01:36', 'slider'),
(103, 8, 'uploads/propiedades/1764950496_SL_4_vv.jpg', NULL, 0, '2025-12-05 10:01:36', 'slider'),
(104, 8, 'uploads/propiedades/1764950496_SL_5_y.jpg', NULL, 0, '2025-12-05 10:01:36', 'slider'),
(105, 8, 'uploads/propiedades/1764950496_SL_6_zj.jpg', NULL, 0, '2025-12-05 10:01:36', 'slider'),
(106, 8, 'uploads/propiedades/1764950496_SL_7_qq-2.jpg', NULL, 0, '2025-12-05 10:01:36', 'slider'),
(107, 8, 'uploads/propiedades/1764950496_G4_0_ff.jpg', NULL, 0, '2025-12-05 10:01:36', 'galeria'),
(108, 8, 'uploads/propiedades/1764950496_G4_1_t.jpg', NULL, 0, '2025-12-05 10:01:36', 'galeria'),
(109, 8, 'uploads/propiedades/1764950496_G4_2_ww-2.jpg', NULL, 0, '2025-12-05 10:01:36', 'galeria'),
(110, 8, 'uploads/propiedades/1764950496_G4_3_zb.jpg', NULL, 0, '2025-12-05 10:01:36', 'galeria'),
(189, 6, 'uploads/propiedades/1764966211_SL_0_a.jpg', NULL, 0, '2025-12-05 14:23:31', 'slider'),
(190, 6, 'uploads/propiedades/1764966211_SL_1_ac.jpg', NULL, 0, '2025-12-05 14:23:31', 'slider'),
(191, 6, 'uploads/propiedades/1764966212_SL_2_b.jpg', NULL, 0, '2025-12-05 14:23:32', 'slider'),
(192, 6, 'uploads/propiedades/1764966212_SL_3_bcd.jpg', NULL, 0, '2025-12-05 14:23:32', 'slider'),
(193, 6, 'uploads/propiedades/1764966212_SL_4_ca.jpg', NULL, 0, '2025-12-05 14:23:32', 'slider'),
(194, 6, 'uploads/propiedades/1764966212_SL_5_fff.jpg', NULL, 0, '2025-12-05 14:23:32', 'slider'),
(195, 6, 'uploads/propiedades/1764966212_SL_6_h.jpg', NULL, 0, '2025-12-05 14:23:32', 'slider'),
(196, 6, 'uploads/propiedades/1764966212_SL_7_hcc.jpg', NULL, 0, '2025-12-05 14:23:32', 'slider'),
(197, 6, 'uploads/propiedades/1764966212_G4_0_ab.jpg', NULL, 0, '2025-12-05 14:23:32', 'galeria'),
(198, 6, 'uploads/propiedades/1764966212_G4_1_da.jpg', NULL, 0, '2025-12-05 14:23:32', 'galeria'),
(199, 6, 'uploads/propiedades/1764966212_G4_2_ffa.jpg', NULL, 0, '2025-12-05 14:23:32', 'galeria'),
(200, 6, 'uploads/propiedades/1764966212_G4_3_ih.jpg', NULL, 0, '2025-12-05 14:23:32', 'galeria'),
(208, 6, 'uploads/propiedades/1764966274_SL_7_if.jpg', NULL, 0, '2025-12-05 14:24:34', 'slider'),
(209, 9, 'uploads/propiedades/1764966603_SL_0_a.jpg', NULL, 0, '2025-12-05 14:30:03', 'slider'),
(210, 9, 'uploads/propiedades/1764966603_SL_1_b.jpg', NULL, 0, '2025-12-05 14:30:03', 'slider'),
(211, 9, 'uploads/propiedades/1764966603_SL_2_f.jpg', NULL, 0, '2025-12-05 14:30:03', 'slider'),
(212, 9, 'uploads/propiedades/1764966603_SL_3_ggg.jpg', NULL, 0, '2025-12-05 14:30:03', 'slider'),
(213, 9, 'uploads/propiedades/1764966603_SL_4_k.jpg', NULL, 0, '2025-12-05 14:30:03', 'slider'),
(214, 9, 'uploads/propiedades/1764966603_SL_5_qq.jpg', NULL, 0, '2025-12-05 14:30:03', 'slider'),
(215, 9, 'uploads/propiedades/1764966603_SL_6_s.jpg', NULL, 0, '2025-12-05 14:30:03', 'slider'),
(216, 9, 'uploads/propiedades/1764966604_SL_7_nn.jpg', NULL, 0, '2025-12-05 14:30:04', 'slider'),
(217, 9, 'uploads/propiedades/1764966604_G4_0_c.jpg', NULL, 0, '2025-12-05 14:30:04', 'galeria'),
(218, 9, 'uploads/propiedades/1764966604_G4_1_l.jpg', NULL, 0, '2025-12-05 14:30:04', 'galeria'),
(219, 9, 'uploads/propiedades/1764966604_G4_2_p.jpg', NULL, 0, '2025-12-05 14:30:04', 'galeria'),
(220, 9, 'uploads/propiedades/1764966604_G4_3_uuu.jpg', NULL, 0, '2025-12-05 14:30:04', 'galeria'),
(221, 9, 'uploads/propiedades/1764966733_SL_0_n.jpg', NULL, 0, '2025-12-05 14:32:13', 'slider'),
(222, 7, 'uploads/propiedades/1764966901_SL_0_a.jpg', NULL, 0, '2025-12-05 14:35:01', 'slider'),
(223, 7, 'uploads/propiedades/1764966901_SL_1_b.jpg', NULL, 0, '2025-12-05 14:35:01', 'slider'),
(224, 7, 'uploads/propiedades/1764966901_SL_2_g.jpg', NULL, 0, '2025-12-05 14:35:01', 'slider'),
(225, 7, 'uploads/propiedades/1764966901_SL_3_j.jpg', NULL, 0, '2025-12-05 14:35:01', 'slider'),
(226, 7, 'uploads/propiedades/1764966901_SL_4_ll.jpg', NULL, 0, '2025-12-05 14:35:01', 'slider'),
(227, 7, 'uploads/propiedades/1764966901_SL_5_m-3-2.jpg', NULL, 0, '2025-12-05 14:35:01', 'slider'),
(228, 7, 'uploads/propiedades/1764966902_SL_6_v.jpg', NULL, 0, '2025-12-05 14:35:02', 'slider'),
(229, 7, 'uploads/propiedades/1764966902_G4_0_c.jpg', NULL, 0, '2025-12-05 14:35:02', 'galeria'),
(230, 7, 'uploads/propiedades/1764966902_G4_1_f-2.jpg', NULL, 0, '2025-12-05 14:35:02', 'galeria'),
(231, 7, 'uploads/propiedades/1764966902_G4_2_ooo.jpg', NULL, 0, '2025-12-05 14:35:02', 'galeria'),
(232, 7, 'uploads/propiedades/1764966902_G4_3_z.jpg', NULL, 0, '2025-12-05 14:35:02', 'galeria'),
(233, 7, 'uploads/propiedades/1764966913_SL_0_x.jpg', NULL, 0, '2025-12-05 14:35:13', 'slider'),
(246, 10, 'uploads/propiedades/1765496112_SL_0_a.jpg', NULL, 0, '2025-12-11 17:35:12', 'slider'),
(247, 10, 'uploads/propiedades/1765496112_SL_1_ab.jpg', NULL, 0, '2025-12-11 17:35:12', 'slider'),
(248, 10, 'uploads/propiedades/1765496112_SL_2_ah.jpg', NULL, 0, '2025-12-11 17:35:12', 'slider'),
(249, 10, 'uploads/propiedades/1765496112_SL_3_ak.jpg', NULL, 0, '2025-12-11 17:35:12', 'slider'),
(250, 10, 'uploads/propiedades/1765496112_SL_4_ap.jpg', NULL, 0, '2025-12-11 17:35:12', 'slider'),
(251, 10, 'uploads/propiedades/1765496112_SL_5_at.jpg', NULL, 0, '2025-12-11 17:35:12', 'slider'),
(252, 10, 'uploads/propiedades/1765496112_SL_6_bs.jpg', NULL, 0, '2025-12-11 17:35:12', 'slider'),
(253, 10, 'uploads/propiedades/1765496112_SL_7_cb.jpg', NULL, 0, '2025-12-11 17:35:12', 'slider'),
(254, 10, 'uploads/propiedades/1765496112_G4_0_ac.jpg', NULL, 0, '2025-12-11 17:35:12', 'galeria'),
(255, 10, 'uploads/propiedades/1765496112_G4_1_ar.jpg', NULL, 0, '2025-12-11 17:35:12', 'galeria'),
(256, 10, 'uploads/propiedades/1765496112_G4_2_ay.jpg', NULL, 0, '2025-12-11 17:35:12', 'galeria'),
(257, 10, 'uploads/propiedades/1765496112_G4_3_bn.jpg', NULL, 0, '2025-12-11 17:35:12', 'galeria'),
(258, 11, 'uploads/propiedades/1765496405_SL_0_ab.jpg', NULL, 0, '2025-12-11 17:40:05', 'slider'),
(259, 11, 'uploads/propiedades/1765496405_SL_1_ad.jpg', NULL, 0, '2025-12-11 17:40:05', 'slider'),
(260, 11, 'uploads/propiedades/1765496405_SL_2_ag.jpg', NULL, 0, '2025-12-11 17:40:05', 'slider'),
(261, 11, 'uploads/propiedades/1765496405_SL_3_alll.jpg', NULL, 0, '2025-12-11 17:40:05', 'slider'),
(262, 11, 'uploads/propiedades/1765496405_SL_4_ar.jpg', NULL, 0, '2025-12-11 17:40:05', 'slider'),
(263, 11, 'uploads/propiedades/1765496405_SL_5_av.jpg', NULL, 0, '2025-12-11 17:40:05', 'slider'),
(264, 11, 'uploads/propiedades/1765496405_SL_6_bh.jpg', NULL, 0, '2025-12-11 17:40:05', 'slider'),
(265, 11, 'uploads/propiedades/1765496405_SL_7_bk.jpg', NULL, 0, '2025-12-11 17:40:05', 'slider'),
(266, 11, 'uploads/propiedades/1765496405_G4_0_ac.jpg', NULL, 0, '2025-12-11 17:40:05', 'galeria'),
(267, 11, 'uploads/propiedades/1765496405_G4_1_ai.jpg', NULL, 0, '2025-12-11 17:40:05', 'galeria'),
(268, 11, 'uploads/propiedades/1765496406_G4_2_bc.jpg', NULL, 0, '2025-12-11 17:40:06', 'galeria'),
(269, 11, 'uploads/propiedades/1765496406_G4_3_bs.jpg', NULL, 0, '2025-12-11 17:40:06', 'galeria');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `property_calendar`
--
ALTER TABLE `property_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `property_photos`
--
ALTER TABLE `property_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

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
