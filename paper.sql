-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 05-04-2015 a las 01:07:38
-- Versión del servidor: 5.5.38
-- Versión de PHP: 5.5.14

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `paper`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_bar_stock`
--

CREATE TABLE `sky_bar_stock` (
`id_bar_stock` int(11) NOT NULL,
  `bs_pd_id_product` int(11) NOT NULL,
  `bs_unity_quantity` int(11) NOT NULL,
  `bs_sell_price` float NOT NULL,
  `bs_min` int(11) NOT NULL DEFAULT '1',
  `bs_max` int(11) NOT NULL,
  `bs_status` int(11) NOT NULL DEFAULT '1',
  `bs_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `sky_bar_stock`
--

INSERT INTO `sky_bar_stock` (`id_bar_stock`, `bs_pd_id_product`, `bs_unity_quantity`, `bs_sell_price`, `bs_min`, `bs_max`, `bs_status`, `bs_timestamp`) VALUES
(1, 1, 97, 1.2, 5, 50, 1, 1425425588),
(2, 3, 65, 141.5, 24, 100, 1, 1425417967),
(3, 6, 50, 3, 20, 50, 1, 1428099841);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_brand`
--

CREATE TABLE `sky_brand` (
`id_brand` int(11) NOT NULL,
  `br_brand` varchar(128) NOT NULL,
  `br_status` int(11) NOT NULL DEFAULT '1',
  `br_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `sky_brand`
--

INSERT INTO `sky_brand` (`id_brand`, `br_brand`, `br_status`, `br_timestamp`) VALUES
(1, 'SCRIBE', 1, 1423673090),
(2, 'BIC', 1, 1423673090),
(3, 'Norma', 1, 1425311672),
(4, 'Pelican', 1, 1425311672),
(5, 'SCRIBE', 1, 1427911694),
(6, 'BIC', 1, 1427911694);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_computer`
--

CREATE TABLE `sky_computer` (
`id_computer` int(11) NOT NULL,
  `cm_computer` varchar(64) NOT NULL,
  `cm_ct_id_computer_type` int(11) NOT NULL,
  `cm_brand` varchar(64) NOT NULL,
  `cm_model` varchar(64) NOT NULL,
  `cm_serial` varchar(128) NOT NULL,
  `cm_so` varchar(64) NOT NULL,
  `cm_status` int(11) NOT NULL DEFAULT '1',
  `cm_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `sky_computer`
--

INSERT INTO `sky_computer` (`id_computer`, `cm_computer`, `cm_ct_id_computer_type`, `cm_brand`, `cm_model`, `cm_serial`, `cm_so`, `cm_status`, `cm_timestamp`) VALUES
(1, 'PC No. 5', 1, 'Lenovo', 'Blanco', '1255', 'Windows 8.1', 1, 1427731964),
(2, 'Maquina #2', 2, 'Lenovo', 'MXV-KKLS', '2346765ABC', 'Windows 7', 1, 1427737327);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_computer_maintenance`
--

CREATE TABLE `sky_computer_maintenance` (
`id_maintenance` int(11) NOT NULL,
  `mt_date` int(11) NOT NULL,
  `mt_cm_id_computer` int(11) NOT NULL,
  `mt_ms_id_maintenance_status` int(11) NOT NULL,
  `mt_notes` text,
  `mt_status` int(11) NOT NULL DEFAULT '1',
  `mt_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_computer_type`
--

CREATE TABLE `sky_computer_type` (
`id_computer_type` int(11) NOT NULL,
  `ct_computer_type` varchar(64) NOT NULL,
  `ct_status` int(11) NOT NULL DEFAULT '1',
  `ct_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `sky_computer_type`
--

INSERT INTO `sky_computer_type` (`id_computer_type`, `ct_computer_type`, `ct_status`, `ct_timestamp`) VALUES
(1, 'ALL IN ONE', 1, 1427731964),
(2, 'DESKTOP', 1, 1427731964),
(3, 'LAPTOP', 1, 1427731964);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_contact`
--

CREATE TABLE `sky_contact` (
`id_contact` int(11) NOT NULL,
  `ct_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_leasing`
--

CREATE TABLE `sky_leasing` (
`id_leasing` int(11) NOT NULL,
  `ls_cm_id_computer` int(11) NOT NULL,
  `ls_start` int(11) NOT NULL,
  `ls_end` int(11) NOT NULL,
  `ls_us_id_user` int(11) NOT NULL,
  `ls_tx_id_tax` int(11) NOT NULL,
  `ls_total` float NOT NULL DEFAULT '0',
  `ls_status` int(11) NOT NULL DEFAULT '1',
  `ls_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `sky_leasing`
--

INSERT INTO `sky_leasing` (`id_leasing`, `ls_cm_id_computer`, `ls_start`, `ls_end`, `ls_us_id_user`, `ls_tx_id_tax`, `ls_total`, `ls_status`, `ls_timestamp`) VALUES
(1, 1, 1427916002, 1428098765, 1, 1, 0.5, 0, 1427916002),
(4, 2, 1427918015, 1427918172, 1, 1, 0, 0, 1427918015),
(6, 1, 1427929409, 1428098765, 1, 1, 0.5, 0, 1427929409),
(7, 1, 1427931831, 1428098765, 1, 1, 0.5, 0, 1427931831),
(8, 1, 1427931882, 1428098765, 1, 1, 0.5, 0, 1427931882),
(9, 1, 1427932013, 1428098765, 1, 1, 0.5, 0, 1427932013),
(10, 1, 1427932356, 1428098765, 1, 1, 0.5, 0, 1427932356),
(11, 1, 1427932437, 1428098765, 1, 1, 0.5, 0, 1427932437),
(12, 1, 1427932626, 1428098765, 1, 1, 0.5, 0, 1427932626),
(13, 1, 1428098733, 1428098765, 1, 1, 0.5, 0, 1428098733),
(14, 2, 1428098757, 0, 1, 1, 0, 1, 1428098757);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_maintenance_status`
--

CREATE TABLE `sky_maintenance_status` (
`id_maintenance_status` int(11) NOT NULL,
  `ms_maintenance_status` varchar(64) NOT NULL,
  `ms_status` int(11) NOT NULL DEFAULT '1',
  `ms_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_order`
--

CREATE TABLE `sky_order` (
`id_order` int(11) NOT NULL,
  `or_name` varchar(256) NOT NULL,
  `or_description` text NOT NULL,
  `or_date` int(11) NOT NULL,
  `or_us_id_user` int(11) NOT NULL,
  `or_status` int(11) NOT NULL DEFAULT '1',
  `or_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_product`
--

CREATE TABLE `sky_product` (
`id_product` int(11) NOT NULL,
  `pd_product` varchar(128) NOT NULL,
  `pd_alias` varchar(128) NOT NULL,
  `pd_description` text NOT NULL,
  `pd_sku` varchar(128) NOT NULL,
  `pd_br_id_brand` int(11) NOT NULL,
  `pd_sp_id_supplier` int(11) NOT NULL,
  `pd_pc_id_product_category` int(11) NOT NULL,
  `pd_status` int(11) NOT NULL DEFAULT '1',
  `pd_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `sky_product`
--

INSERT INTO `sky_product` (`id_product`, `pd_product`, `pd_alias`, `pd_description`, `pd_sku`, `pd_br_id_brand`, `pd_sp_id_supplier`, `pd_pc_id_product_category`, `pd_status`, `pd_timestamp`) VALUES
(1, 'PRODUCTO 1', 'ALIAS PROD 1', 'DESC PROD 1', 'SKUPD0001', 1, 1, 3, 1, 1423673444),
(2, 'Producto 2', 'Alias 2', 'Descripcion', 'SKUPD0002', 1, 1, 2, 1, 1425173426),
(3, 'PRODUCTO 3', 'ALIAS PROD 3', 'DESC PROD 3', 'SKUPD0003', 1, 1, 2, 1, 1425311672),
(4, 'Producto 4', 'ALIAS PROD 04', 'DESC PROD 04', 'SKU0004', 3, 3, 4, 1, 1425670424),
(5, 'PRODUCTO 1', 'ALIAS PROD 1', 'DESC PROD 1', 'SKUPD0001', 1, 1, 3, 1, 1427911694),
(6, 'Cartulina Pastel', 'Cartulina color pastel', '', '1234567', 1, 1, 9, 1, 1428099679);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_product_category`
--

CREATE TABLE `sky_product_category` (
`id_product_category` int(11) NOT NULL,
  `pc_product_category` varchar(64) NOT NULL,
  `pc_status` int(11) NOT NULL DEFAULT '1',
  `pc_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `sky_product_category`
--

INSERT INTO `sky_product_category` (`id_product_category`, `pc_product_category`, `pc_status`, `pc_timestamp`) VALUES
(1, 'CONSUMIBLE', 1, 1423673384),
(2, 'REGALO', 1, 1423673384),
(3, 'ESCOLAR', 1, 1423673384),
(4, 'MAPAS', 1, 1425311672),
(5, 'PLASTICOS', 1, 1425311672),
(6, 'MERCERIA', 1, 1425311672),
(7, 'CONSUMIBLE', 1, 1427911694),
(8, 'REGALO', 1, 1427911694),
(9, 'ESCOLAR', 1, 1427911694);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_product_packing`
--

CREATE TABLE `sky_product_packing` (
`id_product_packing` int(11) NOT NULL,
  `pp_product_packing` varchar(64) NOT NULL,
  `pp_unity_quantity` int(11) NOT NULL,
  `pp_pp_id_parent` int(11) DEFAULT NULL,
  `pp_status` int(11) NOT NULL DEFAULT '1',
  `pp_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `sky_product_packing`
--

INSERT INTO `sky_product_packing` (`id_product_packing`, `pp_product_packing`, `pp_unity_quantity`, `pp_pp_id_parent`, `pp_status`, `pp_timestamp`) VALUES
(1, 'CAJA 12 pzas', 12, NULL, 1, 1423677458),
(2, 'CAJA 24 pzas', 24, NULL, 1, 1423677458),
(3, 'CAJA 50 pzas', 50, NULL, 1, 1425311672),
(4, 'CAJA 10 pzas', 10, NULL, 1, 1425311672),
(5, 'UNIDAD', 1, NULL, 1, 0),
(6, 'CAJA 12 pzas', 12, NULL, 1, 1427911694),
(7, 'CAJA 24 pzas', 24, NULL, 1, 1427911694);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_profile`
--

CREATE TABLE `sky_profile` (
`id_profile` int(11) NOT NULL,
  `pf_profile` varchar(128) NOT NULL,
  `pf_status` int(11) NOT NULL DEFAULT '1',
  `pf_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `sky_profile`
--

INSERT INTO `sky_profile` (`id_profile`, `pf_profile`, `pf_status`, `pf_timestamp`) VALUES
(1, 'Administrador del Sistema', 1, 1423673090),
(2, 'Gerente', 1, 1423673090),
(3, 'Administrador', 1, 1423673090),
(4, 'Supervisor', 1, 1423673090),
(5, 'Administrador del Sistema', 1, 1425311672),
(6, 'Gerente', 1, 1425311672),
(7, 'Administrador', 1, 1425311672),
(8, 'Supervisor', 1, 1425311672),
(9, 'Administrador del Sistema', 1, 1427911694),
(10, 'Gerente', 1, 1427911694),
(11, 'Administrador', 1, 1427911694),
(12, 'Supervisor', 1, 1427911694);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_rack`
--

CREATE TABLE `sky_rack` (
`id_rack` int(11) NOT NULL,
  `rk_name` varchar(256) NOT NULL,
  `rk_description` text NOT NULL,
  `rk_location` varchar(128) DEFAULT NULL,
  `rk_status` int(11) NOT NULL DEFAULT '1',
  `rk_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `sky_rack`
--

INSERT INTO `sky_rack` (`id_rack`, `rk_name`, `rk_description`, `rk_location`, `rk_status`, `rk_timestamp`) VALUES
(1, 'Anaquel 01', 'Lapices', 'Vitrina Grande, cajon derecho', 1, 1425176440),
(2, 'Anaquel 02', 'Lapices', 'Vitrina Grande, cajon derecho abajo', 1, 1425176440);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_rack_products`
--

CREATE TABLE `sky_rack_products` (
  `rkp_rk_id_rack` int(11) NOT NULL,
  `rkp_pd_id_product` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_sell`
--

CREATE TABLE `sky_sell` (
`id_sell` int(11) NOT NULL,
  `sl_date` int(11) NOT NULL DEFAULT '0',
  `sl_subtotal` float DEFAULT NULL,
  `sl_discount` float DEFAULT '0',
  `sl_total` float NOT NULL,
  `sl_us_id_user` int(11) NOT NULL,
  `sl_status` int(11) NOT NULL DEFAULT '1',
  `sl_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `sky_sell`
--

INSERT INTO `sky_sell` (`id_sell`, `sl_date`, `sl_subtotal`, `sl_discount`, `sl_total`, `sl_us_id_user`, `sl_status`, `sl_timestamp`) VALUES
(1, 1425176440, 90, 0, 103.5, 2, 1, 1425173426);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_sell_detail`
--

CREATE TABLE `sky_sell_detail` (
`id_sell_detail` int(11) NOT NULL,
  `sd_sl_id_sell` int(11) NOT NULL,
  `sd_pd_id_product` int(11) NOT NULL,
  `sd_bs_id_bar_stock` int(11) DEFAULT NULL,
  `sd_quantity` int(11) NOT NULL,
  `sd_price` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `sky_sell_detail`
--

INSERT INTO `sky_sell_detail` (`id_sell_detail`, `sd_sl_id_sell`, `sd_pd_id_product`, `sd_bs_id_bar_stock`, `sd_quantity`, `sd_price`) VALUES
(2, 1, 1, 1, 3, 0),
(3, 1, 2, NULL, 2, 0),
(4, 1, 1, 1, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_settings_option`
--

CREATE TABLE `sky_settings_option` (
`id_settings_option` int(11) NOT NULL,
  `so_us_id_user` int(11) NOT NULL,
  `so_option` varchar(64) NOT NULL,
  `so_value` text NOT NULL,
  `so_status` int(11) NOT NULL DEFAULT '1',
  `so_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `sky_settings_option`
--

INSERT INTO `sky_settings_option` (`id_settings_option`, `so_us_id_user`, `so_option`, `so_value`, `so_status`, `so_timestamp`) VALUES
(1, 1, 'global_sys_title', 'Paper Store 1.0', 1, 1423673090),
(2, 1, 'global_css_color1', '#638e63', 1, 1423673090),
(3, 1, 'global_css_color2', '#fafafa', 1, 1423673090),
(4, 1, 'global_css_color3', '#454545', 1, 1423673090),
(5, 1, 'global_backend_version', '3.0a', 1, 1423673090),
(6, 1, 'global_sys_logo', 'img/logo.png', 1, 1423673090),
(7, 1, 'global_app_version', '1.0', 1, 1423673090),
(8, 1, 'show_sidebar', 'false', 1, 1423673090),
(17, 1, 'sitemap_config', '4,3', 1, 1428098696),
(18, 1, 'global_sys_title', 'Paper Store 1.0', 1, 1427911694),
(19, 1, 'global_css_color1', '#638e63', 1, 1427911694),
(20, 1, 'global_css_color2', '#fafafa', 1, 1427911694),
(21, 1, 'global_css_color3', '#454545', 1, 1427911694),
(22, 1, 'global_backend_version', '3.0a', 1, 1427911694),
(23, 1, 'global_sys_logo', 'img/logo.png', 1, 1427911694),
(24, 1, 'global_app_version', '1.0', 1, 1427911694),
(25, 1, 'show_sidebar', 'false', 1, 1427911694),
(26, 1, 'sitemap_config', '4,3', 1, 1427911694),
(27, 1, 'default_tax', '1', 1, 1427911694);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_sitemap`
--

CREATE TABLE `sky_sitemap` (
`id_sitemap` int(11) NOT NULL,
  `sm_cm_id_computer` int(11) NOT NULL,
  `sm_site` int(11) NOT NULL,
  `sm_status` int(11) NOT NULL DEFAULT '1',
  `sm_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `sky_sitemap`
--

INSERT INTO `sky_sitemap` (`id_sitemap`, `sm_cm_id_computer`, `sm_site`, `sm_status`, `sm_timestamp`) VALUES
(6, 1, 3, 1, 1428098709),
(7, 2, 8, 1, 1428098714);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_storehouse_stock`
--

CREATE TABLE `sky_storehouse_stock` (
`id_storehouse_stock` int(11) NOT NULL,
  `ss_pd_id_product` int(11) NOT NULL,
  `ss_pp_id_product_packing` int(11) NOT NULL,
  `ss_quantity` int(11) NOT NULL,
  `ss_min` int(11) NOT NULL,
  `ss_max` int(11) NOT NULL,
  `ss_status` int(11) NOT NULL DEFAULT '1',
  `ss_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `sky_storehouse_stock`
--

INSERT INTO `sky_storehouse_stock` (`id_storehouse_stock`, `ss_pd_id_product`, `ss_pp_id_product_packing`, `ss_quantity`, `ss_min`, `ss_max`, `ss_status`, `ss_timestamp`) VALUES
(1, 1, 1, 12, 10, 20, 1, 1428099550),
(2, 2, 2, 3, 10, 20, 1, 1425675448),
(3, 3, 1, 10, 5, 15, 1, 1),
(4, 4, 2, 25, 20, 50, 1, 1425672528),
(5, 6, 5, 100, 10, 100, 1, 1428099763);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_supplier`
--

CREATE TABLE `sky_supplier` (
`id_supplier` int(11) NOT NULL,
  `sp_supplier` varchar(128) NOT NULL,
  `sp_ct_id_contact` int(11) DEFAULT NULL,
  `sp_status` int(11) NOT NULL DEFAULT '1',
  `sp_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `sky_supplier`
--

INSERT INTO `sky_supplier` (`id_supplier`, `sp_supplier`, `sp_ct_id_contact`, `sp_status`, `sp_timestamp`) VALUES
(1, 'Proveedor 1', NULL, 1, 1423673155),
(2, 'Proveedor 2', NULL, 1, 1423673155),
(3, 'Proveedor 3', NULL, 1, 1425311672),
(4, 'Proveedor 4', NULL, 1, 1425311672),
(5, 'Proveedor 1', NULL, 1, 1427911694),
(6, 'Proveedor 2', NULL, 1, 1427911694);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_tax`
--

CREATE TABLE `sky_tax` (
`id_tax` int(11) NOT NULL,
  `tx_tax` varchar(64) NOT NULL,
  `tx_hour_amount` float DEFAULT NULL,
  `tx_type` int(11) DEFAULT NULL,
  `tx_amount_fraction` float DEFAULT NULL,
  `tx_amount_first_half` float DEFAULT NULL,
  `tx_amount_second_half` float DEFAULT NULL,
  `tx_status` int(11) NOT NULL DEFAULT '1',
  `tx_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `sky_tax`
--

INSERT INTO `sky_tax` (`id_tax`, `tx_tax`, `tx_hour_amount`, `tx_type`, `tx_amount_fraction`, `tx_amount_first_half`, `tx_amount_second_half`, `tx_status`, `tx_timestamp`) VALUES
(1, 'Apertura', 6, 2, 0.5, NULL, NULL, 1, 1427914497);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sky_user`
--

CREATE TABLE `sky_user` (
`id_user` int(11) NOT NULL,
  `us_user` varchar(128) NOT NULL,
  `us_pf_id_profile` int(11) NOT NULL,
  `us_password` varchar(256) NOT NULL,
  `us_status` int(11) NOT NULL DEFAULT '1',
  `us_timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `sky_user`
--

INSERT INTO `sky_user` (`id_user`, `us_user`, `us_pf_id_profile`, `us_password`, `us_status`, `us_timestamp`) VALUES
(1, 'ignacio.cerda', 1, '8e25afe9b50e6d1c2f444840b9d9e056', 1, 1423673090),
(2, 'rosalva.colin', 1, '9450476b384b32d8ad8b758e76c98a69', 2, 1423673090),
(3, 'ignacio.cerda', 1, '8e25afe9b50e6d1c2f444840b9d9e056', 1, 1425311672),
(4, 'rosalva.colin', 1, '9450476b384b32d8ad8b758e76c98a69', 2, 1425311672),
(5, 'ignacio.cerda', 1, '8e25afe9b50e6d1c2f444840b9d9e056', 1, 1427911694),
(6, 'rosalva.colin', 1, '9450476b384b32d8ad8b758e76c98a69', 2, 1427911694);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sky_bar_stock`
--
ALTER TABLE `sky_bar_stock`
 ADD PRIMARY KEY (`id_bar_stock`), ADD KEY `fk_bs_pd_id_product_idx` (`bs_pd_id_product`);

--
-- Indices de la tabla `sky_brand`
--
ALTER TABLE `sky_brand`
 ADD PRIMARY KEY (`id_brand`);

--
-- Indices de la tabla `sky_computer`
--
ALTER TABLE `sky_computer`
 ADD PRIMARY KEY (`id_computer`), ADD KEY `fk_cm_ct_id_computer_type_idx` (`cm_ct_id_computer_type`);

--
-- Indices de la tabla `sky_computer_maintenance`
--
ALTER TABLE `sky_computer_maintenance`
 ADD PRIMARY KEY (`id_maintenance`), ADD KEY `fk_mt_cm_id_computer_idx` (`mt_cm_id_computer`), ADD KEY `fk_mt_ms_id_maintenance_status_idx` (`mt_ms_id_maintenance_status`);

--
-- Indices de la tabla `sky_computer_type`
--
ALTER TABLE `sky_computer_type`
 ADD PRIMARY KEY (`id_computer_type`);

--
-- Indices de la tabla `sky_contact`
--
ALTER TABLE `sky_contact`
 ADD PRIMARY KEY (`id_contact`);

--
-- Indices de la tabla `sky_leasing`
--
ALTER TABLE `sky_leasing`
 ADD PRIMARY KEY (`id_leasing`), ADD KEY `fk_ls_cm_id_computer_idx` (`ls_cm_id_computer`), ADD KEY `fk_ls_us_id_user_idx` (`ls_us_id_user`), ADD KEY `fk_ls_tx_id_tax_idx` (`ls_tx_id_tax`);

--
-- Indices de la tabla `sky_maintenance_status`
--
ALTER TABLE `sky_maintenance_status`
 ADD PRIMARY KEY (`id_maintenance_status`);

--
-- Indices de la tabla `sky_order`
--
ALTER TABLE `sky_order`
 ADD PRIMARY KEY (`id_order`), ADD KEY `fk_or_us_id_user_idx` (`or_us_id_user`);

--
-- Indices de la tabla `sky_product`
--
ALTER TABLE `sky_product`
 ADD PRIMARY KEY (`id_product`), ADD KEY `fk_pd_br_id_brand_idx` (`pd_br_id_brand`), ADD KEY `fk_pd_sp_id_supplier_idx` (`pd_sp_id_supplier`), ADD KEY `fk_pd_pc_id_product_category_idx` (`pd_pc_id_product_category`);

--
-- Indices de la tabla `sky_product_category`
--
ALTER TABLE `sky_product_category`
 ADD PRIMARY KEY (`id_product_category`);

--
-- Indices de la tabla `sky_product_packing`
--
ALTER TABLE `sky_product_packing`
 ADD PRIMARY KEY (`id_product_packing`), ADD KEY `fk_pp_pp_id_parent_idx` (`pp_pp_id_parent`);

--
-- Indices de la tabla `sky_profile`
--
ALTER TABLE `sky_profile`
 ADD PRIMARY KEY (`id_profile`);

--
-- Indices de la tabla `sky_rack`
--
ALTER TABLE `sky_rack`
 ADD PRIMARY KEY (`id_rack`);

--
-- Indices de la tabla `sky_rack_products`
--
ALTER TABLE `sky_rack_products`
 ADD KEY `fk_rkp_rk_id_rack_idx` (`rkp_rk_id_rack`), ADD KEY `fk_rkp_pd_id_product_idx` (`rkp_pd_id_product`);

--
-- Indices de la tabla `sky_sell`
--
ALTER TABLE `sky_sell`
 ADD PRIMARY KEY (`id_sell`), ADD KEY `fk_sl_us_id_user_idx` (`sl_us_id_user`);

--
-- Indices de la tabla `sky_sell_detail`
--
ALTER TABLE `sky_sell_detail`
 ADD PRIMARY KEY (`id_sell_detail`), ADD KEY `fk_sd_sl_id_sell_idx` (`sd_sl_id_sell`), ADD KEY `fk_sd_pd_id_product_idx` (`sd_pd_id_product`), ADD KEY `fk_sd_bs_id_bar_stock_idx` (`sd_bs_id_bar_stock`);

--
-- Indices de la tabla `sky_settings_option`
--
ALTER TABLE `sky_settings_option`
 ADD PRIMARY KEY (`id_settings_option`), ADD KEY `fk_so_us_id_user_idx` (`so_us_id_user`);

--
-- Indices de la tabla `sky_sitemap`
--
ALTER TABLE `sky_sitemap`
 ADD PRIMARY KEY (`id_sitemap`), ADD KEY `fk_sm_cm_id_computer_idx` (`sm_cm_id_computer`);

--
-- Indices de la tabla `sky_storehouse_stock`
--
ALTER TABLE `sky_storehouse_stock`
 ADD PRIMARY KEY (`id_storehouse_stock`), ADD KEY `fk_ss_pd_id_product_idx` (`ss_pd_id_product`), ADD KEY `ss_pp_id_product_packing_idx` (`ss_pp_id_product_packing`);

--
-- Indices de la tabla `sky_supplier`
--
ALTER TABLE `sky_supplier`
 ADD PRIMARY KEY (`id_supplier`), ADD KEY `fk_sp_ct_id_contact_idx` (`sp_ct_id_contact`);

--
-- Indices de la tabla `sky_tax`
--
ALTER TABLE `sky_tax`
 ADD PRIMARY KEY (`id_tax`);

--
-- Indices de la tabla `sky_user`
--
ALTER TABLE `sky_user`
 ADD PRIMARY KEY (`id_user`), ADD KEY `fk_us_pf_id_profile_idx` (`us_pf_id_profile`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `sky_bar_stock`
--
ALTER TABLE `sky_bar_stock`
MODIFY `id_bar_stock` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `sky_brand`
--
ALTER TABLE `sky_brand`
MODIFY `id_brand` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `sky_computer`
--
ALTER TABLE `sky_computer`
MODIFY `id_computer` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `sky_computer_maintenance`
--
ALTER TABLE `sky_computer_maintenance`
MODIFY `id_maintenance` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `sky_computer_type`
--
ALTER TABLE `sky_computer_type`
MODIFY `id_computer_type` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `sky_contact`
--
ALTER TABLE `sky_contact`
MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `sky_leasing`
--
ALTER TABLE `sky_leasing`
MODIFY `id_leasing` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `sky_maintenance_status`
--
ALTER TABLE `sky_maintenance_status`
MODIFY `id_maintenance_status` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `sky_order`
--
ALTER TABLE `sky_order`
MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `sky_product`
--
ALTER TABLE `sky_product`
MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `sky_product_category`
--
ALTER TABLE `sky_product_category`
MODIFY `id_product_category` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `sky_product_packing`
--
ALTER TABLE `sky_product_packing`
MODIFY `id_product_packing` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `sky_profile`
--
ALTER TABLE `sky_profile`
MODIFY `id_profile` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `sky_rack`
--
ALTER TABLE `sky_rack`
MODIFY `id_rack` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `sky_sell`
--
ALTER TABLE `sky_sell`
MODIFY `id_sell` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `sky_sell_detail`
--
ALTER TABLE `sky_sell_detail`
MODIFY `id_sell_detail` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `sky_settings_option`
--
ALTER TABLE `sky_settings_option`
MODIFY `id_settings_option` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `sky_sitemap`
--
ALTER TABLE `sky_sitemap`
MODIFY `id_sitemap` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `sky_storehouse_stock`
--
ALTER TABLE `sky_storehouse_stock`
MODIFY `id_storehouse_stock` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `sky_supplier`
--
ALTER TABLE `sky_supplier`
MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `sky_tax`
--
ALTER TABLE `sky_tax`
MODIFY `id_tax` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `sky_user`
--
ALTER TABLE `sky_user`
MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `sky_bar_stock`
--
ALTER TABLE `sky_bar_stock`
ADD CONSTRAINT `fk_bs_pd_id_product` FOREIGN KEY (`bs_pd_id_product`) REFERENCES `sky_product` (`id_product`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sky_computer`
--
ALTER TABLE `sky_computer`
ADD CONSTRAINT `fk_cm_ct_id_computer_type` FOREIGN KEY (`cm_ct_id_computer_type`) REFERENCES `sky_computer_type` (`id_computer_type`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sky_computer_maintenance`
--
ALTER TABLE `sky_computer_maintenance`
ADD CONSTRAINT `fk_mt_cm_id_computer` FOREIGN KEY (`mt_cm_id_computer`) REFERENCES `sky_computer` (`id_computer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_mt_ms_id_maintenance_status` FOREIGN KEY (`mt_ms_id_maintenance_status`) REFERENCES `sky_maintenance_status` (`id_maintenance_status`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sky_leasing`
--
ALTER TABLE `sky_leasing`
ADD CONSTRAINT `fk_ls_cm_id_computer` FOREIGN KEY (`ls_cm_id_computer`) REFERENCES `sky_computer` (`id_computer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ls_tx_id_tax` FOREIGN KEY (`ls_tx_id_tax`) REFERENCES `sky_tax` (`id_tax`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ls_us_id_user` FOREIGN KEY (`ls_us_id_user`) REFERENCES `sky_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sky_order`
--
ALTER TABLE `sky_order`
ADD CONSTRAINT `fk_or_us_id_user` FOREIGN KEY (`or_us_id_user`) REFERENCES `sky_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sky_product`
--
ALTER TABLE `sky_product`
ADD CONSTRAINT `fk_pd_br_id_brand` FOREIGN KEY (`pd_br_id_brand`) REFERENCES `sky_brand` (`id_brand`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pd_pc_id_product_category` FOREIGN KEY (`pd_pc_id_product_category`) REFERENCES `sky_product_category` (`id_product_category`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pd_sp_id_supplier` FOREIGN KEY (`pd_sp_id_supplier`) REFERENCES `sky_supplier` (`id_supplier`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sky_product_packing`
--
ALTER TABLE `sky_product_packing`
ADD CONSTRAINT `fk_pp_pp_id_parent` FOREIGN KEY (`pp_pp_id_parent`) REFERENCES `sky_product_packing` (`id_product_packing`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sky_rack_products`
--
ALTER TABLE `sky_rack_products`
ADD CONSTRAINT `fk_rkp_pd_id_product` FOREIGN KEY (`rkp_pd_id_product`) REFERENCES `sky_product` (`id_product`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_rkp_rk_id_rack` FOREIGN KEY (`rkp_rk_id_rack`) REFERENCES `sky_rack` (`id_rack`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sky_sell`
--
ALTER TABLE `sky_sell`
ADD CONSTRAINT `fk_sl_us_id_user` FOREIGN KEY (`sl_us_id_user`) REFERENCES `sky_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sky_sell_detail`
--
ALTER TABLE `sky_sell_detail`
ADD CONSTRAINT `fk_sd_bs_id_bar_stock` FOREIGN KEY (`sd_bs_id_bar_stock`) REFERENCES `sky_bar_stock` (`id_bar_stock`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_sd_pd_id_product` FOREIGN KEY (`sd_pd_id_product`) REFERENCES `sky_product` (`id_product`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_sd_sl_id_sell` FOREIGN KEY (`sd_sl_id_sell`) REFERENCES `sky_sell` (`id_sell`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sky_settings_option`
--
ALTER TABLE `sky_settings_option`
ADD CONSTRAINT `fk_so_us_id_user` FOREIGN KEY (`so_us_id_user`) REFERENCES `sky_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sky_sitemap`
--
ALTER TABLE `sky_sitemap`
ADD CONSTRAINT `fk_sm_cm_id_computer` FOREIGN KEY (`sm_cm_id_computer`) REFERENCES `sky_computer` (`id_computer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sky_storehouse_stock`
--
ALTER TABLE `sky_storehouse_stock`
ADD CONSTRAINT `fk_ss_pd_id_product` FOREIGN KEY (`ss_pd_id_product`) REFERENCES `sky_product` (`id_product`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `ss_pp_id_product_packing` FOREIGN KEY (`ss_pp_id_product_packing`) REFERENCES `sky_product_packing` (`id_product_packing`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sky_supplier`
--
ALTER TABLE `sky_supplier`
ADD CONSTRAINT `fk_sp_ct_id_contact` FOREIGN KEY (`sp_ct_id_contact`) REFERENCES `sky_contact` (`id_contact`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sky_user`
--
ALTER TABLE `sky_user`
ADD CONSTRAINT `fk_us_pf_id_profile` FOREIGN KEY (`us_pf_id_profile`) REFERENCES `sky_profile` (`id_profile`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
