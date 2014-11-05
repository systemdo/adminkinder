-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-11-2014 a las 13:31:48
-- Versión del servidor: 5.5.40
-- Versión de PHP: 5.4.34-1+deb.sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `adminkinder`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `children`
--

CREATE TABLE IF NOT EXISTS `children` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `organization` int(45) DEFAULT NULL,
  `account_pay` int(11) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `children`
--

INSERT INTO `children` (`id`, `name`, `surname`, `organization`, `account_pay`, `create_date`, `update_date`) VALUES
(1, 'Heloo', 'Mundo', 0, 65544, NULL, '2014-10-30 14:09:41'),
(2, 'lucas', 'fweyfywerq', 0, 232341234, NULL, NULL),
(3, 'Mauro', 'Silva', 0, 765467809, '2014-09-15 07:15:45', '2014-09-15 07:16:00'),
(4, 'hsdggsdg', 'gsdgsdgfh', 0, 2147483647, '2014-09-16 14:39:05', NULL),
(5, 'lucas24/09', 'yhyy', 5, 89988, '2014-09-23 13:56:10', NULL),
(6, 'ddd', 'aaaaa', 5, 4455555, '2014-09-24 16:26:07', '2014-09-24 16:52:47'),
(7, 'dd', 'sss', 5, 455, '2014-09-24 16:35:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `code`
--

CREATE TABLE IF NOT EXISTS `code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `abbreviation` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='		' AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `code`
--

INSERT INTO `code` (`id`, `name`, `abbreviation`, `especial`) VALUES
(5, 'd', 'de', 0),
(6, 'Luz', 'HLZ', 0),
(7, 'e', 'Hhdhhdhdhdh', 0),
(8, 'especial', 'especial', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1410386562),
('m140506_102106_rbac_init', 1410393699);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registers`
--

CREATE TABLE IF NOT EXISTS `registers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher` int(11) NOT NULL,
  `extract` int(11) NOT NULL,
  `date_buy` date NOT NULL,
  `code` int(11) NOT NULL,
  `process` longtext COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `organization` int(3) NOT NULL,
  `extra` int(10) DEFAULT NULL,
  `child` int(11) NOT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `create_date` (`create_date`),
  KEY `child` (`child`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Eintrag' AUTO_INCREMENT=30 ;

--
-- Volcado de datos para la tabla `registers`
--

INSERT INTO `registers` (`id`, `voucher`, `extract`, `date_buy`, `code`, `process`, `amount`, `organization`, `extra`, `child`, `create_date`, `update_date`) VALUES
(11, 233333, 122333, '2014-09-04', 6, 'eeee', 55.55, 0, NULL, 6, '2014-09-24 16:51:43', NULL),
(12, 6554, 65544, '2014-08-18', 5, 'jdfddghdhdh', 98.98, 0, NULL, 7, '2014-09-24 17:09:15', NULL),
(13, 0, 87776, '2014-08-05', 5, 'hgdgdgdg', 12555.55, 0, NULL, 1, '2014-09-25 10:37:27', NULL),
(17, 0, 54444, '0000-00-00', 5, 'hhgggg', 2.55, 5, 1, 4, '2014-10-28 16:09:32', NULL),
(18, 0, 54444, '0000-00-00', 5, 'hhgggg', 2.55, 5, 1, 4, '2014-10-28 16:14:03', NULL),
(20, 0, 888877, '2014-10-08', 5, '98888', 1.00, 5, 2, 1, '2014-10-28 16:39:09', NULL),
(21, 0, 65555, '2014-10-09', 6, 'kjhjasjjsad', 1.00, 5, 2, 1, '2014-10-28 16:40:48', NULL),
(22, 0, 998888998, '2014-10-10', 5, 'jjjdj11', 1.00, 5, 2, 1, '2014-10-28 16:42:38', NULL),
(23, 0, 88777, '2014-10-15', 5, 'jjj', 1.00, 5, 2, 1, '2014-10-28 17:31:31', NULL),
(24, 0, 2147483647, '2014-10-02', 5, 'jjsdhahhsd', 1.00, 5, 2, 1, '2014-10-28 17:44:53', NULL),
(25, 0, 8888998, '2014-10-10', 5, 'ujjjjjj', 1.00, 5, 9, 1, '2014-10-28 18:46:10', NULL),
(26, 0, 9888, '2014-10-19', 5, 'ajsjjs', 10.00, 5, 2, 1, '2014-10-29 08:23:15', NULL),
(27, 0, 8877, '2014-10-18', 5, 'fdjasdjajsdf', 1111.11, 5, 3, 4, '2014-10-29 08:24:36', NULL),
(28, 0, 7766, '0000-00-00', 8, 'uuuu', 21.55, 0, NULL, 1, '2014-10-30 16:31:24', NULL),
(29, 0, 88788, '2014-10-31', 7, 'jujjj', 2.22, 5, 11, 5, '2014-10-31 09:11:53', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registers_code_especial`
--

CREATE TABLE IF NOT EXISTS `registers_code_especial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher` int(11) NOT NULL,
  `extract` int(11) NOT NULL,
  `date_buy` date NOT NULL,
  `code` int(11) NOT NULL,
  `process` longtext COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `organization` int(3) NOT NULL,
  `extra` int(10) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `create_date` (`create_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Eintrag' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `registers_code_especial`
--

INSERT INTO `registers_code_especial` (`id`, `voucher`, `extract`, `date_buy`, `code`, `process`, `amount`, `organization`, `extra`, `create_date`, `update_date`) VALUES
(1, 0, 8877888, '2014-10-11', 8, '8878', 2.11, 5, NULL, '2014-10-30 18:30:36', NULL),
(2, 0, 77666, '2014-10-08', 8, '98888', 88.55, 5, NULL, '2014-10-30 18:40:43', NULL),
(3, 0, 776668877, '2014-10-10', 8, 'werqwerqwe', 1222.22, 5, NULL, '2014-10-31 07:27:30', NULL),
(4, 0, 87788778, '2014-10-23', 8, 'akahskdhfshdjk', 1222.22, 5, NULL, '2014-11-04 10:46:01', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registers_extra`
--

CREATE TABLE IF NOT EXISTS `registers_extra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher` int(11) NOT NULL,
  `extract` int(11) NOT NULL,
  `date_buy` date NOT NULL,
  `process` longtext COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `organization` int(3) NOT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `registers_extra`
--

INSERT INTO `registers_extra` (`id`, `voucher`, `extract`, `date_buy`, `process`, `amount`, `organization`, `create_date`, `update_date`) VALUES
(1, 877, 88678, '2014-10-08', 'sdsdfjsd', 102.55, 0, NULL, NULL),
(2, 877, 88678, '2014-10-09', 'sdsdfjsd', 99999969.99, 0, NULL, NULL),
(9, 77887, 9988, '2014-10-01', 'kjkjjjjj', 555.55, 5, NULL, NULL),
(10, 87887, 9888, '2014-10-09', '8878888', 200.00, 5, NULL, NULL),
(11, 0, 877788, '2014-10-31', '52555555', 0.00, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rule`) VALUES
(1, 'SUPER_ADMIN'),
(2, 'ADMIN'),
(3, 'BASIC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `account` int(11) DEFAULT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`,`role`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `account_UNIQUE` (`account`),
  KEY `fk_users_roles1` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `username`, `email`, `account`, `password`, `update_date`, `create_date`, `role`) VALUES
(3, 'Andres', 'ffdd', 'andres', '', 133244242, '122345', NULL, NULL, 1),
(5, 'Lucas', 'silverio', 'lucas', 'lukinhasmad@yahoo.com.br', 1223123, '827ccb0eea8a706c4c34a16891f84e7b', NULL, '2014-09-15 16:55:38', 1),
(7, 'Lu', 'trrreee', 'silverio', 'luh@gmail.com', 2147483647, '827ccb0eea8a706c4c34a16891f84e7b', NULL, '2014-09-16 14:36:40', 2),
(8, 'eeee', NULL, 'ksd', 'lukinhasmad@yahoo.com.br', 12233333, '925b0a1eec5a69caf39000c6fc902f50', '2014-09-25 12:01:04', '2014-09-23 14:31:19', 2),
(10, 'hhhh', NULL, 'jjjdjjddj', 'lukinhasmad@yahoo.com.br', 233444, 'aae3fed34636f7d74d23933629b8353c', NULL, '2014-09-23 14:37:06', 2),
(11, 'lucas', NULL, 'jsjdhsdhds', 'lukinhasmad@yahoo.com.br', 988777, 'e1ceb16e53ac57b41d45788683b71b82', NULL, '2014-09-23 14:46:45', 1),
(13, 'kidiii', NULL, 'asjdfasdhhasdh', 'lukinhasmad@yahoo.com.br', 87786767, 'c351ee29ff639b596251b08c9bbd13d7', NULL, '2014-09-23 14:48:00', 1),
(14, 'kidiii', NULL, '788777', 'lukinhasmad@yahoo.com.br', 766776, 'c146a930f1836567a4bb4ea844f72c46', NULL, '2014-09-23 14:56:43', 1),
(16, 'lucas', NULL, 'uu', 'lukinhasmad@yahoo.com.br', 676667766, '8e654c5d7949f4d00584d46177f65f07', NULL, '2014-09-25 09:23:57', 2),
(17, 'text', NULL, 'texty', 'lukinhasmad@yahoo.com.br', 766555, '04d5fe4f9f32d7ae0c112ce75a37801e', '2014-09-25 12:15:08', '2014-09-25 10:02:57', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `registers`
--
ALTER TABLE `registers`
  ADD CONSTRAINT `registers_ibfk_1` FOREIGN KEY (`code`) REFERENCES `code` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `registers_ibfk_2` FOREIGN KEY (`child`) REFERENCES `children` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
