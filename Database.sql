-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-12-2018 a las 11:36:12
-- Versión del servidor: 10.1.35-MariaDB
-- Versión de PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `lup_toolkit`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(13) NOT NULL,
  `fb_token` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `admin` int(2) NOT NULL,
  `time_confirmed` int(150) NOT NULL DEFAULT '0',
  `name` varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  `username` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `birth` int(5) DEFAULT NULL,
  `avatar` varchar(250) COLLATE latin1_spanish_ci DEFAULT NULL,
  `password` varchar(150) COLLATE latin1_spanish_ci DEFAULT NULL,
  `password_recall` int(13) DEFAULT NULL,
  `email` varchar(150) COLLATE latin1_spanish_ci NOT NULL,
  `descr` text COLLATE latin1_spanish_ci,
  `ident` varchar(10) COLLATE latin1_spanish_ci DEFAULT NULL,
  `send_mail_com` int(1) NOT NULL DEFAULT '0',
  `last_logged` int(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `fb_token`, `admin`, `time_confirmed`, `name`, `username`, `birth`, `avatar`, `password`, `password_recall`, `email`, `descr`, `ident`, `send_mail_com`, `last_logged`) VALUES
(1, '', 1, 0, 'Administrador', 'admin', 0, NULL, '81dc9bdb52d04dc20036dbd8313ed055', NULL, 'noreply@midominio.com', 'Usuario generado automáticamente', NULL, 0, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;


--
-- Estructura de tabla para la tabla `users_temp`
--

CREATE TABLE `users_temp` (
  `id` int(13) NOT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `username` varchar(12) COLLATE utf8_bin NOT NULL,
  `email` varchar(150) COLLATE utf8_bin NOT NULL,
  `password` varchar(150) COLLATE utf8_bin NOT NULL,
  `token` varchar(150) COLLATE utf8_bin NOT NULL,
  `expire` int(25) NOT NULL,
  `birth` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indices de la tabla `users_temp`
--
ALTER TABLE `users_temp`
  ADD PRIMARY KEY (`id`);
  
--
-- Estructura de tabla para la tabla `newsletter`
--

CREATE TABLE `newsletter` (
  `id_nl` int(13) NOT NULL,
  `token` varchar(50) COLLATE utf8_bin NOT NULL,
  `format` varchar(15) COLLATE utf8_bin NOT NULL,
  `title` varchar(250) COLLATE utf8_bin NOT NULL,
  `body` text COLLATE utf8_bin NOT NULL,
  `image` varchar(250) COLLATE utf8_bin NOT NULL,
  `button_link` tinytext COLLATE utf8_bin NOT NULL,
  `id_cats` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `test_email` varchar(50) COLLATE utf8_bin NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `time` int(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indices de la tabla `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id_nl`);
  
--
-- Estructura de tabla para la tabla `newsletter_send`
--

CREATE TABLE `newsletter_send` (
  `id` int(13) NOT NULL,
  `id_nl` int(13) NOT NULL,
  `id_user` int(13) NOT NULL,
  `status` int(2) NOT NULL,
  `log` varchar(200) COLLATE utf8_bin NOT NULL,
  `time` int(13) NOT NULL,
  `token` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indices de la tabla `newsletter_send`
--
ALTER TABLE `newsletter_send`
  ADD PRIMARY KEY (`id`);

--
-- Estructura de tabla para la tabla `users_type`
--

CREATE TABLE `users_type` (
  `id_type` int(13) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `descr` varchar(250) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `users_type`
--

INSERT INTO `users_type` (`id_type`, `name`, `descr`) VALUES
(1, 'Standard', 'Usuario estándar'),
(2, 'Premium', 'Usuario Premium');

--
-- Indices de la tabla `users_type`
--
ALTER TABLE `users_type`
  ADD PRIMARY KEY (`id_type`);
  
  
 --
-- AUTO_INCREMENT de las tablas volcadas
--
  
  
--
-- AUTO_INCREMENT de la tabla `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id_nl` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `newsletter_send`
--
ALTER TABLE `newsletter_send`
  MODIFY `id` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `users_temp`
--
ALTER TABLE `users_temp`
  MODIFY `id` int(13) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users_type`
--
ALTER TABLE `users_type`
  MODIFY `id_type` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;