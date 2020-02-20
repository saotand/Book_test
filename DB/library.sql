-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-02-2020 a las 20:29:26
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `library`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `ID` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `authors`
--

INSERT INTO `authors` (`ID`, `name`, `description`) VALUES
('34b879c3d0c3a50de24adba72e256e', 'Leonardo', '-_-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `ID` varchar(30) NOT NULL,
  `title` varchar(50) NOT NULL,
  `pages` int(11) NOT NULL,
  `author` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `books`
--

INSERT INTO `books` (`ID`, `title`, `pages`, `author`) VALUES
('5dbdf661d1a359bece278dfab579f9', 'Lo que el viento se llevó_____________', 250, 'dsddfad3441234dasfdf23213'),
('7ead654f1e2dcbf3327782d93ae018', 'Lo que el viento se llevó', 250, 'dsddfad3441234dasfdf23213');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `authors`
--
ALTER TABLE `authors`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `books`
--
ALTER TABLE `books`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `title` (`title`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
