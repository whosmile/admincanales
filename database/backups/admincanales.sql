-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-03-2025 a las 13:47:20
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
-- Base de datos: `admincanales`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrative_and_transactional_logs`
--

CREATE TABLE `administrative_and_transactional_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afiliaciones_servicio`
--

CREATE TABLE `afiliaciones_servicio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `servicio_id` bigint(20) UNSIGNED NOT NULL,
  `numero_afiliado` varchar(255) NOT NULL,
  `estatus` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `accion` varchar(255) NOT NULL,
  `modulo_id` bigint(20) UNSIGNED NOT NULL,
  `detalles` text DEFAULT NULL,
  `datos_nuevos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_nuevos`)),
  `ip` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `user_id`, `usuario`, `accion`, `modulo_id`, `detalles`, `datos_nuevos`, `ip`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin Sistema', 'B??squeda de cliente', 1, 'B??squeda exitosa de cliente con c??dula: V-11223344', '\"{\\\"cedula\\\":\\\"V-11223344\\\",\\\"encontrado\\\":true,\\\"cliente_id\\\":3}\"', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', '2024-12-20 20:58:05', '2024-12-20 20:58:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_administrativa`
--

CREATE TABLE `bitacora_administrativa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `accion` varchar(255) NOT NULL,
  `modulo` varchar(255) NOT NULL,
  `detalles` text NOT NULL,
  `ip` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones_servicios`
--

CREATE TABLE `configuraciones_servicios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `servicio_id` bigint(20) UNSIGNED NOT NULL,
  `maxima_afiliacion` int(11) NOT NULL,
  `requiere_verificacion` tinyint(1) NOT NULL DEFAULT 0,
  `parametros_adicionales` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parametros_adicionales`)),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_por` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuraciones_servicios`
--

INSERT INTO `configuraciones_servicios` (`id`, `servicio_id`, `maxima_afiliacion`, `requiere_verificacion`, `parametros_adicionales`, `fecha_actualizacion`, `actualizado_por`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 0, NULL, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(2, 2, 5, 0, NULL, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(3, 3, 3, 0, NULL, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(4, 4, 3, 0, NULL, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(5, 5, 3, 0, NULL, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(6, 6, 2, 0, NULL, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(7, 7, 2, 0, NULL, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(8, 8, 5, 0, NULL, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(9, 9, 1, 0, NULL, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(10, 10, 2, 0, NULL, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(11, 11, 5, 0, NULL, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas_servicios`
--

CREATE TABLE `empresas_servicios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `rif` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `persona_contacto` varchar(255) DEFAULT NULL,
  `estatus` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresas_servicios`
--

INSERT INTO `empresas_servicios` (`id`, `nombre`, `rif`, `direccion`, `telefono`, `email`, `persona_contacto`, `estatus`, `created_at`, `updated_at`) VALUES
(1, 'Empresa Por Defecto', 'J-00000000-0', NULL, NULL, NULL, NULL, 'Activo', '2024-12-20 21:39:28', '2024-12-20 21:39:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_transaccion`
--

CREATE TABLE `estados_transaccion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estados_transaccion`
--

INSERT INTO `estados_transaccion` (`id`, `codigo`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'PENDIENTE', 'Pendiente', NULL, '2024-12-20 21:39:28', '2024-12-20 21:39:28'),
(2, 'APROBADA', 'Aprobada', NULL, '2024-12-20 21:39:28', '2024-12-20 21:39:28'),
(3, 'RECHAZADA', 'Rechazada', NULL, '2024-12-20 21:39:28', '2024-12-20 21:39:28'),
(4, 'CANCELADA', 'Cancelada', NULL, '2024-12-20 21:39:28', '2024-12-20 21:39:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_parametros`
--

CREATE TABLE `grupos_parametros` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `grupos_parametros`
--

INSERT INTO `grupos_parametros` (`id`, `codigo`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'sistema', 'Configuraci??n del Sistema', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(2, 'pagos', 'Configuraci??n de Pagos', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(3, 'transferencias', 'Configuraci??n de Transferencias', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(4, 'seguridad', 'Configuraci??n de Seguridad', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(5, 'notificaciones', 'Configuraci??n de Notificaciones', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(6, 'logs', 'Configuraci??n de Logs', '2024-12-20 20:53:47', '2024-12-20 20:53:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `limites_servicios`
--

CREATE TABLE `limites_servicios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `servicio_id` bigint(20) UNSIGNED NOT NULL,
  `limite_minimo` decimal(20,2) NOT NULL,
  `limite_maximo` decimal(20,2) NOT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_por` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `limites_servicios`
--

INSERT INTO `limites_servicios` (`id`, `servicio_id`, `limite_minimo`, `limite_maximo`, `fecha_actualizacion`, `actualizado_por`, `created_at`, `updated_at`) VALUES
(1, 1, 1.00, 1000000.00, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(2, 2, 1.00, 1000000.00, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(3, 3, 1.00, 5000000.00, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(4, 4, 1.00, 1000000.00, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(5, 5, 1.00, 2000000.00, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(6, 6, 1.00, 1500000.00, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(7, 7, 1.00, 500000.00, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(8, 8, 100.00, 10000000.00, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(9, 9, 1.00, 50000000.00, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(10, 10, 1.00, 5000000.00, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28'),
(11, 11, 1.00, 100000000.00, '2024-12-20 17:39:28', NULL, '2024-12-20 17:39:28', '2024-12-20 17:39:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_12_18_074444_reorganize_database_structure', 1),
(2, '2024_12_18_074445_create_default_modules', 1),
(3, '2024_12_19_072834_create_servicios_bancarios_tables', 1),
(4, '2024_12_19_084052_add_avatar_to_users_table', 1),
(5, '2024_12_20_142107_create_administrative_and_transactional_logs', 1),
(6, '2024_12_20_143936_create_web_transactional_logs_table', 1),
(8, '2024_12_20_133400_normalize_servicios_table', 2),
(9, '2024_12_20_133700_fix_relationships', 2),
(10, '2024_03_15_000000_create_bitacora_administrativa_table', 3),
(11, '2025_02_01_125300_create_permisos_vuelto_table', 3),
(12, '2025_03_15_162554_create_web_transactional_logs_table', 4),
(13, '2025_03_16_000000_create_user_limits_table', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id`, `codigo`, `nombre`, `descripcion`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'CLIENTES', 'CLIENTES', 'M??dulo de gesti??n de clientes', 1, '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(2, 'LOG-TRANSACCIONAL', 'LOG-TRANSACCIONAL', 'M??dulo de consulta de log transaccional', 1, '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(3, 'PARAMETROS', 'PARAMETROS', 'Configuraci??n de par??metros del sistema', 1, '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(4, 'BITACORA', 'BITACORA', 'Registro de actividades del sistema', 1, '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(5, 'USUARIOS', 'Gesti??n de Usuarios', 'M??dulo para la administraci??n de usuarios y roles', 1, '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(6, 'SERVICIOS', 'Gesti??n de Servicios', 'M??dulo para la administraci??n de servicios y afiliaciones', 1, '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(7, 'DASHBOARD', 'DASHBOARD', 'M??dulo principal del dashboard', 1, '2024-12-20 20:53:46', '2024-12-20 20:53:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros`
--

CREATE TABLE `parametros` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grupo_id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `valor` text NOT NULL,
  `descripcion` text NOT NULL,
  `es_editable` tinyint(1) NOT NULL DEFAULT 1,
  `es_visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `parametros`
--

INSERT INTO `parametros` (`id`, `grupo_id`, `codigo`, `valor`, `descripcion`, `es_editable`, `es_visible`, `created_at`, `updated_at`) VALUES
(1, 1, 'sistema.version', '1.0.0', 'Versi??n actual del sistema de administraci??n de canales', 0, 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(2, 1, 'sistema.nombre', 'Admin Canales', 'Nombre oficial del sistema para mostrar en la interfaz', 1, 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(3, 2, 'pagos.monto.minimo', '15', 'Monto m??nimo permitido para transacciones de pago en el sistema', 1, 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(4, 2, 'pagos.monto.maximo', '5900', 'Monto m??ximo permitido para transacciones de pago en el sistema', 1, 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(5, 3, 'transferencias.monto.maximo', '1600000', 'L??mite m??ximo permitido para transferencias entre cuentas diferentes', 1, 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(6, 3, 'transferencias.internas.monto.maximo', '-1', 'L??mite m??ximo para transferencias entre cuentas del mismo titular (-1 sin l??mite)', 1, 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(7, 4, 'seguridad.sesion.duracion', '120', 'Tiempo m??ximo de inactividad antes de cerrar la sesi??n (en minutos)', 1, 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(8, 4, 'seguridad.intentos.maximos', '3', 'N??mero m??ximo de intentos fallidos de inicio de sesi??n antes del bloqueo', 1, 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(9, 5, 'notificaciones.email.habilitado', 'true', 'Activa o desactiva el env??o de notificaciones por correo electr??nico', 1, 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(10, 6, 'logs.dias.retencion', '90', 'D??as que se mantienen los registros de actividad antes de ser archivados', 1, 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(11, 6, 'logs.nivel.minimo', 'info', 'Nivel m??nimo de importancia para registrar eventos en los logs del sistema', 1, 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_vuelto`
--

CREATE TABLE `permisos_vuelto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `permiso_p2p` tinyint(1) NOT NULL DEFAULT 0,
  `permiso_homebanking` tinyint(1) NOT NULL DEFAULT 0,
  `modificado_por` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `nombre`, `codigo`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Ver Dashboard', 'dashboard.view', 'Permite ver el dashboard', '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(2, 'Gestionar Usuarios', 'users.manage', 'Permite gestionar usuarios', '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(3, 'Gestionar Roles', 'roles.manage', 'Permite gestionar roles', '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(4, 'Gestionar Servicios', 'services.manage', 'Permite gestionar servicios', '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(5, 'Ver Transacciones', 'transactions.view', 'Permite ver transacciones', '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(6, 'Realizar Transacciones', 'transactions.create', 'Permite realizar transacciones', '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(7, 'Gestionar Par??metros', 'parameters.manage', 'Permite gestionar par??metros del sistema', '2024-12-20 20:53:46', '2024-12-20 20:53:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'Rol con acceso completo al sistema', '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(2, 'Usuario', 'Usuario regular del sistema', '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(3, 'Operador', 'Operador con acceso a funciones espec??ficas', '2024-12-20 20:53:46', '2024-12-20 20:53:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(1, 2, '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(1, 3, '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(1, 4, '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(1, 5, '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(1, 6, '2024-12-20 20:53:46', '2024-12-20 20:53:46'),
(1, 7, '2024-12-20 20:53:46', '2024-12-20 20:53:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_servicio_id` bigint(20) UNSIGNED NOT NULL,
  `empresa_servicio_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `codigo_servicio` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `tipo_servicio_id`, `empresa_servicio_id`, `nombre`, `empresa`, `codigo_servicio`, `activo`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Movistar Venezuela', 'Telef??nica Venezuela', 'MOVISTAR_VE', 1, 'Servicios de telefon??a m??vil Movistar', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(2, 1, 0, 'Digitel', 'Corporaci??n Digitel C.A.', 'DIGITEL_VE', 1, 'Servicios de telefon??a m??vil Digitel', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(3, 2, 0, 'CORPOELEC', 'Corporaci??n El??ctrica Nacional', 'CORPOELEC_VE', 1, 'Servicio el??ctrico nacional', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(4, 3, 0, 'Hidrocapital', 'Hidrol??gica de la Regi??n Capital', 'HIDROCAPITAL_VE', 1, 'Servicio de agua potable regi??n capital', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(5, 4, 0, 'CANTV', 'Compa????a An??nima Nacional Tel??fonos de Venezuela', 'CANTV_INTERNET_VE', 1, 'Servicio de internet ABA', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(6, 5, 0, 'Inter', 'Inter Venezuela', 'INTER_VE', 1, 'Servicio de televisi??n por cable', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(7, 6, 0, 'Gas Comunal', 'Gas Comunal S.A.', 'GAS_COMUNAL_VE', 1, 'Servicio de gas dom??stico', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(8, 7, 0, 'Seguros La Previsora', 'La Previsora Seguros C.A.', 'PREVISORA_VE', 1, 'Servicios de seguros varios', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(9, 8, 0, 'SENIAT', 'Servicio Nacional Integrado de Administraci??n Aduanera y Tributaria', 'SENIAT_VE', 1, 'Pago de impuestos nacionales', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(10, 9, 0, 'Universidad Central de Venezuela', 'Universidad Central de Venezuela', 'UCV_VE', 1, 'Pagos universitarios UCV', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(11, 10, 0, 'Banco de Venezuela', 'Banco de Venezuela S.A.', 'BDV_TC_VE', 1, 'Pago de tarjetas de cr??dito Banco de Venezuela', '2024-12-20 20:53:47', '2024-12-20 20:53:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ORyDhMDcu1quu9SY4ooz6PevOe3x3Zrb176hxqMl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicGxaT0pDMWc5aGlHNm0yODFCYnk1NXpQdHdCWUR2TWhXb3Flc1gwcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9hZG1pbmNhbmFsZXMudGVzdCI7fX0=', 1734716459);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_servicios`
--

CREATE TABLE `tipos_servicios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_servicios`
--

INSERT INTO `tipos_servicios` (`id`, `codigo`, `nombre`, `descripcion`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'TELEFONIA', 'Telefon??a', 'Servicios de telefon??a fija y m??vil', 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(2, 'ELECTRICIDAD', 'Electricidad', 'Servicios de energ??a el??ctrica', 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(3, 'AGUA', 'Agua', 'Servicios de agua potable', 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(4, 'INTERNET', 'Internet', 'Servicios de internet', 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(5, 'TELEVISION', 'Televisi??n por Cable', 'Servicios de televisi??n por cable y satelital', 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(6, 'GAS', 'Gas Natural', 'Servicios de gas dom??stico', 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(7, 'SEGUROS', 'Seguros', 'Servicios de seguros', 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(8, 'IMPUESTOS', 'Impuestos', 'Pagos de impuestos nacionales', 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(9, 'EDUCACION', 'Instituciones Educativas', 'Pagos de instituciones educativas', 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(10, 'TARJETAS', 'Tarjetas de Cr??dito', 'Pagos de tarjetas de cr??dito', 1, '2024-12-20 20:53:47', '2024-12-20 20:53:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_transaccion`
--

CREATE TABLE `tipos_transaccion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_transaccion`
--

INSERT INTO `tipos_transaccion` (`id`, `codigo`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'PAGO', 'Pago de Servicio', 'Pago de servicio realizado por el cliente', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(2, 'RECA', 'Recarga', 'Recarga de saldo', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(3, 'CONS', 'Consulta', 'Consulta de saldo o estado de cuenta', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(4, 'TRAN', 'Transferencia', 'Transferencia entre cuentas', '2024-12-20 20:53:47', '2024-12-20 20:53:47'),
(5, 'REVE', 'Reverso', 'Reverso de transacci??n', '2024-12-20 20:53:47', '2024-12-20 20:53:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_transaccion_id` bigint(20) UNSIGNED NOT NULL,
  `cedula` varchar(255) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `origen` varchar(255) DEFAULT NULL,
  `destino` varchar(255) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `descripcion` varchar(255) DEFAULT NULL,
  `ref` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `servicio_id` bigint(20) UNSIGNED DEFAULT NULL,
  `estado_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `transacciones`
--

INSERT INTO `transacciones` (`id`, `user_id`, `tipo_transaccion_id`, `cedula`, `fecha_hora`, `origen`, `destino`, `monto`, `descripcion`, `ref`, `ip`, `deleted_at`, `created_at`, `updated_at`, `servicio_id`, `estado_id`) VALUES
(1, 2, 1, 'V-12345678', '2024-12-18 16:53:47', 'Cuenta 1234', 'Servicio XYZ', 150.00, 'Pago de servicio mensual', 'REF-6247', '192.168.1.105', NULL, '2024-12-20 20:53:47', '2024-12-20 20:53:47', NULL, NULL),
(2, 2, 2, 'V-87654321', '2024-12-19 16:53:47', 'Agente 5678', 'Cuenta 9876', 200.00, 'Recarga de saldo', 'REF-5691', '192.168.1.52', NULL, '2024-12-20 20:53:47', '2024-12-20 20:53:47', NULL, NULL),
(3, 2, 3, 'V-12345678', '2024-12-20 16:53:47', 'App M??vil', 'Sistema', 0.00, 'Consulta de saldo', 'REF-7921', '192.168.1.49', NULL, '2024-12-20 20:53:47', '2024-12-20 20:53:47', NULL, NULL),
(4, 3, 4, 'V-87654321', '2024-12-20 13:53:47', 'Cuenta 1234', 'Cuenta 5678', 300.00, 'Transferencia entre cuentas', 'REF-8304', '192.168.1.57', NULL, '2024-12-20 20:53:47', '2024-12-20 20:53:47', NULL, NULL),
(5, 2, 5, 'V-12345678', '2024-12-20 15:53:47', 'Sistema', 'Cuenta 1234', 150.00, 'Reverso de pago', 'REF-5298', '192.168.1.132', NULL, '2024-12-20 20:53:47', '2024-12-20 20:53:47', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive','blocked') NOT NULL DEFAULT 'active',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `ultimo_login` timestamp NULL DEFAULT NULL,
  `intentos_fallidos` int(11) NOT NULL DEFAULT 0,
  `bloqueado_hasta` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `apellido`, `cedula`, `telefono`, `email`, `avatar`, `username`, `password`, `status`, `activo`, `ultimo_login`, `intentos_fallidos`, `bloqueado_hasta`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'Sistema', 'V-12345678', '04141234567', 'admin@admin.com', NULL, 'admin', '$2y$12$fqC4LE8GrhJdrpdzoDmeouAWREI.uI4GHoWXCnLJA2jpsFaonH1pC', 'active', 1, NULL, 0, NULL, NULL, NULL, NULL),
(2, 2, 'Usuario', 'Demo', 'V-87654321', '04141234568', 'usuario@demo.com', NULL, 'usuario', '$2y$12$zGRUWiwSSMoW/MjV5zjOMO0RX2g1fZWC7rOnNxE/YHAGa8CmJtDTa', 'active', 1, NULL, 0, NULL, NULL, NULL, NULL),
(3, 3, 'Operador', 'Sistema', 'V-11223344', '04141234569', 'operador@sistema.com', NULL, 'operador', '$2y$12$PnYBBDKP2Qm2EzrlRav46uZ6ciGlx33TjwNW92wlgDezGFUhNJ4XK', 'active', 1, NULL, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_limits`
--

CREATE TABLE `user_limits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cedula` varchar(255) NOT NULL,
  `limite_delsur` decimal(15,2) NOT NULL DEFAULT 0.00,
  `limite_otros` decimal(15,2) NOT NULL DEFAULT 50000.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_logs`
--

CREATE TABLE `user_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `web_transactional_logs`
--

CREATE TABLE `web_transactional_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `accion` varchar(255) NOT NULL,
  `modulo` varchar(255) NOT NULL DEFAULT 'parametros_generales',
  `tabla_afectada` varchar(255) DEFAULT NULL,
  `detalles` text DEFAULT NULL,
  `datos_anteriores` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_anteriores`)),
  `datos_nuevos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_nuevos`)),
  `parametros_busqueda` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parametros_busqueda`)),
  `total_resultados` int(11) DEFAULT NULL,
  `criterio_busqueda` varchar(255) DEFAULT NULL,
  `filtros_aplicados` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrative_and_transactional_logs`
--
ALTER TABLE `administrative_and_transactional_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `afiliaciones_servicio`
--
ALTER TABLE `afiliaciones_servicio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `afiliaciones_servicio_user_id_servicio_id_numero_afiliado_unique` (`user_id`,`servicio_id`,`numero_afiliado`),
  ADD KEY `afiliaciones_servicio_servicio_id_foreign` (`servicio_id`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bitacora_user_id_foreign` (`user_id`),
  ADD KEY `bitacora_modulo_id_foreign` (`modulo_id`);

--
-- Indices de la tabla `bitacora_administrativa`
--
ALTER TABLE `bitacora_administrativa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bitacora_administrativa_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `configuraciones_servicios`
--
ALTER TABLE `configuraciones_servicios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `configuraciones_servicios_servicio_id_fecha_actualizacion_unique` (`servicio_id`,`fecha_actualizacion`);

--
-- Indices de la tabla `empresas_servicios`
--
ALTER TABLE `empresas_servicios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empresas_servicios_rif_unique` (`rif`);

--
-- Indices de la tabla `estados_transaccion`
--
ALTER TABLE `estados_transaccion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `estados_transaccion_codigo_unique` (`codigo`);

--
-- Indices de la tabla `grupos_parametros`
--
ALTER TABLE `grupos_parametros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grupos_parametros_codigo_unique` (`codigo`);

--
-- Indices de la tabla `limites_servicios`
--
ALTER TABLE `limites_servicios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `limites_servicios_servicio_id_fecha_actualizacion_unique` (`servicio_id`,`fecha_actualizacion`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modulos_codigo_unique` (`codigo`);

--
-- Indices de la tabla `parametros`
--
ALTER TABLE `parametros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `parametros_codigo_unique` (`codigo`),
  ADD KEY `parametros_grupo_id_foreign` (`grupo_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permisos_vuelto`
--
ALTER TABLE `permisos_vuelto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permisos_vuelto_user_id_index` (`user_id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_codigo_unique` (`codigo`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `role_permissions_permission_id_foreign` (`permission_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `servicios_codigo_servicio_unique` (`codigo_servicio`),
  ADD KEY `servicios_tipo_servicio_id_foreign` (`tipo_servicio_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tipos_servicios`
--
ALTER TABLE `tipos_servicios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tipos_servicios_codigo_unique` (`codigo`);

--
-- Indices de la tabla `tipos_transaccion`
--
ALTER TABLE `tipos_transaccion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tipos_transaccion_codigo_unique` (`codigo`);

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transacciones_user_id_foreign` (`user_id`),
  ADD KEY `transacciones_tipo_transaccion_id_foreign` (`tipo_transaccion_id`),
  ADD KEY `transacciones_servicio_id_foreign` (`servicio_id`),
  ADD KEY `transacciones_estado_id_foreign` (`estado_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_cedula_unique` (`cedula`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `user_limits`
--
ALTER TABLE `user_limits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_limits_cedula_unique` (`cedula`);

--
-- Indices de la tabla `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_logs_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `web_transactional_logs`
--
ALTER TABLE `web_transactional_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `web_transactional_logs_user_id_index` (`user_id`),
  ADD KEY `web_transactional_logs_accion_index` (`accion`),
  ADD KEY `web_transactional_logs_modulo_index` (`modulo`),
  ADD KEY `web_transactional_logs_created_at_index` (`created_at`),
  ADD KEY `web_transactional_logs_criterio_busqueda_index` (`criterio_busqueda`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrative_and_transactional_logs`
--
ALTER TABLE `administrative_and_transactional_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `afiliaciones_servicio`
--
ALTER TABLE `afiliaciones_servicio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `bitacora_administrativa`
--
ALTER TABLE `bitacora_administrativa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuraciones_servicios`
--
ALTER TABLE `configuraciones_servicios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `empresas_servicios`
--
ALTER TABLE `empresas_servicios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estados_transaccion`
--
ALTER TABLE `estados_transaccion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `grupos_parametros`
--
ALTER TABLE `grupos_parametros`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `limites_servicios`
--
ALTER TABLE `limites_servicios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `parametros`
--
ALTER TABLE `parametros`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `permisos_vuelto`
--
ALTER TABLE `permisos_vuelto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tipos_servicios`
--
ALTER TABLE `tipos_servicios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipos_transaccion`
--
ALTER TABLE `tipos_transaccion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `user_limits`
--
ALTER TABLE `user_limits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `web_transactional_logs`
--
ALTER TABLE `web_transactional_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `afiliaciones_servicio`
--
ALTER TABLE `afiliaciones_servicio`
  ADD CONSTRAINT `afiliaciones_servicio_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`),
  ADD CONSTRAINT `afiliaciones_servicio_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `bitacora_modulo_id_foreign` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`),
  ADD CONSTRAINT `bitacora_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `bitacora_administrativa`
--
ALTER TABLE `bitacora_administrativa`
  ADD CONSTRAINT `bitacora_administrativa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `configuraciones_servicios`
--
ALTER TABLE `configuraciones_servicios`
  ADD CONSTRAINT `configuraciones_servicios_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `limites_servicios`
--
ALTER TABLE `limites_servicios`
  ADD CONSTRAINT `limites_servicios_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `parametros`
--
ALTER TABLE `parametros`
  ADD CONSTRAINT `parametros_grupo_id_foreign` FOREIGN KEY (`grupo_id`) REFERENCES `grupos_parametros` (`id`);

--
-- Filtros para la tabla `permisos_vuelto`
--
ALTER TABLE `permisos_vuelto`
  ADD CONSTRAINT `permisos_vuelto_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_tipo_servicio_id_foreign` FOREIGN KEY (`tipo_servicio_id`) REFERENCES `tipos_servicios` (`id`);

--
-- Filtros para la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD CONSTRAINT `transacciones_estado_id_foreign` FOREIGN KEY (`estado_id`) REFERENCES `estados_transaccion` (`id`),
  ADD CONSTRAINT `transacciones_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`),
  ADD CONSTRAINT `transacciones_tipo_transaccion_id_foreign` FOREIGN KEY (`tipo_transaccion_id`) REFERENCES `tipos_transaccion` (`id`),
  ADD CONSTRAINT `transacciones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `user_limits`
--
ALTER TABLE `user_limits`
  ADD CONSTRAINT `user_limits_cedula_foreign` FOREIGN KEY (`cedula`) REFERENCES `users` (`cedula`) ON DELETE CASCADE;

--
-- Filtros para la tabla `user_logs`
--
ALTER TABLE `user_logs`
  ADD CONSTRAINT `user_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `web_transactional_logs`
--
ALTER TABLE `web_transactional_logs`
  ADD CONSTRAINT `web_transactional_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
