-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: admincanales
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `admincanales`
--

/*!40000 DROP DATABASE IF EXISTS `admincanales`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `admincanales` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `admincanales`;

--
-- Table structure for table `administrative_and_transactional_logs`
--

DROP TABLE IF EXISTS `administrative_and_transactional_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrative_and_transactional_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrative_and_transactional_logs`
--

LOCK TABLES `administrative_and_transactional_logs` WRITE;
/*!40000 ALTER TABLE `administrative_and_transactional_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `administrative_and_transactional_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `afiliaciones_servicio`
--

DROP TABLE IF EXISTS `afiliaciones_servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `afiliaciones_servicio` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `servicio_id` bigint(20) unsigned NOT NULL,
  `numero_afiliado` varchar(255) NOT NULL,
  `estatus` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `afiliaciones_servicio_user_id_servicio_id_numero_afiliado_unique` (`user_id`,`servicio_id`,`numero_afiliado`),
  KEY `afiliaciones_servicio_servicio_id_foreign` (`servicio_id`),
  CONSTRAINT `afiliaciones_servicio_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`),
  CONSTRAINT `afiliaciones_servicio_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `afiliaciones_servicio`
--

LOCK TABLES `afiliaciones_servicio` WRITE;
/*!40000 ALTER TABLE `afiliaciones_servicio` DISABLE KEYS */;
/*!40000 ALTER TABLE `afiliaciones_servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bitacora`
--

DROP TABLE IF EXISTS `bitacora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bitacora` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `accion` varchar(255) NOT NULL,
  `modulo_id` bigint(20) unsigned NOT NULL,
  `detalles` text DEFAULT NULL,
  `datos_nuevos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_nuevos`)),
  `ip` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bitacora_user_id_foreign` (`user_id`),
  KEY `bitacora_modulo_id_foreign` (`modulo_id`),
  CONSTRAINT `bitacora_modulo_id_foreign` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`),
  CONSTRAINT `bitacora_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bitacora`
--

LOCK TABLES `bitacora` WRITE;
/*!40000 ALTER TABLE `bitacora` DISABLE KEYS */;
INSERT INTO `bitacora` VALUES (1,1,'Admin Sistema','Búsqueda de cliente',1,'Búsqueda exitosa de cliente con cédula: V-11223344','\"{\\\"cedula\\\":\\\"V-11223344\\\",\\\"encontrado\\\":true,\\\"cliente_id\\\":3}\"','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0','2024-12-20 20:58:05','2024-12-20 20:58:05');
/*!40000 ALTER TABLE `bitacora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuraciones_servicios`
--

DROP TABLE IF EXISTS `configuraciones_servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuraciones_servicios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `servicio_id` bigint(20) unsigned NOT NULL,
  `maxima_afiliacion` int(11) NOT NULL,
  `requiere_verificacion` tinyint(1) NOT NULL DEFAULT 0,
  `parametros_adicionales` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parametros_adicionales`)),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_por` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `configuraciones_servicios_servicio_id_fecha_actualizacion_unique` (`servicio_id`,`fecha_actualizacion`),
  CONSTRAINT `configuraciones_servicios_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuraciones_servicios`
--

LOCK TABLES `configuraciones_servicios` WRITE;
/*!40000 ALTER TABLE `configuraciones_servicios` DISABLE KEYS */;
INSERT INTO `configuraciones_servicios` VALUES (1,1,5,0,NULL,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(2,2,5,0,NULL,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(3,3,3,0,NULL,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(4,4,3,0,NULL,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(5,5,3,0,NULL,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(6,6,2,0,NULL,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(7,7,2,0,NULL,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(8,8,5,0,NULL,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(9,9,1,0,NULL,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(10,10,2,0,NULL,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(11,11,5,0,NULL,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28');
/*!40000 ALTER TABLE `configuraciones_servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresas_servicios`
--

DROP TABLE IF EXISTS `empresas_servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresas_servicios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `rif` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `persona_contacto` varchar(255) DEFAULT NULL,
  `estatus` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `empresas_servicios_rif_unique` (`rif`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresas_servicios`
--

LOCK TABLES `empresas_servicios` WRITE;
/*!40000 ALTER TABLE `empresas_servicios` DISABLE KEYS */;
INSERT INTO `empresas_servicios` VALUES (1,'Empresa Por Defecto','J-00000000-0',NULL,NULL,NULL,NULL,'Activo','2024-12-20 21:39:28','2024-12-20 21:39:28');
/*!40000 ALTER TABLE `empresas_servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_transaccion`
--

DROP TABLE IF EXISTS `estados_transaccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estados_transaccion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `estados_transaccion_codigo_unique` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_transaccion`
--

LOCK TABLES `estados_transaccion` WRITE;
/*!40000 ALTER TABLE `estados_transaccion` DISABLE KEYS */;
INSERT INTO `estados_transaccion` VALUES (1,'PENDIENTE','Pendiente',NULL,'2024-12-20 21:39:28','2024-12-20 21:39:28'),(2,'APROBADA','Aprobada',NULL,'2024-12-20 21:39:28','2024-12-20 21:39:28'),(3,'RECHAZADA','Rechazada',NULL,'2024-12-20 21:39:28','2024-12-20 21:39:28'),(4,'CANCELADA','Cancelada',NULL,'2024-12-20 21:39:28','2024-12-20 21:39:28');
/*!40000 ALTER TABLE `estados_transaccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupos_parametros`
--

DROP TABLE IF EXISTS `grupos_parametros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupos_parametros` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `grupos_parametros_codigo_unique` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos_parametros`
--

LOCK TABLES `grupos_parametros` WRITE;
/*!40000 ALTER TABLE `grupos_parametros` DISABLE KEYS */;
INSERT INTO `grupos_parametros` VALUES (1,'sistema','Configuración del Sistema','2024-12-20 20:53:47','2024-12-20 20:53:47'),(2,'pagos','Configuración de Pagos','2024-12-20 20:53:47','2024-12-20 20:53:47'),(3,'transferencias','Configuración de Transferencias','2024-12-20 20:53:47','2024-12-20 20:53:47'),(4,'seguridad','Configuración de Seguridad','2024-12-20 20:53:47','2024-12-20 20:53:47'),(5,'notificaciones','Configuración de Notificaciones','2024-12-20 20:53:47','2024-12-20 20:53:47'),(6,'logs','Configuración de Logs','2024-12-20 20:53:47','2024-12-20 20:53:47');
/*!40000 ALTER TABLE `grupos_parametros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limites_servicios`
--

DROP TABLE IF EXISTS `limites_servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limites_servicios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `servicio_id` bigint(20) unsigned NOT NULL,
  `limite_minimo` decimal(20,2) NOT NULL,
  `limite_maximo` decimal(20,2) NOT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_por` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `limites_servicios_servicio_id_fecha_actualizacion_unique` (`servicio_id`,`fecha_actualizacion`),
  CONSTRAINT `limites_servicios_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limites_servicios`
--

LOCK TABLES `limites_servicios` WRITE;
/*!40000 ALTER TABLE `limites_servicios` DISABLE KEYS */;
INSERT INTO `limites_servicios` VALUES (1,1,1.00,1000000.00,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(2,2,1.00,1000000.00,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(3,3,1.00,5000000.00,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(4,4,1.00,1000000.00,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(5,5,1.00,2000000.00,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(6,6,1.00,1500000.00,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(7,7,1.00,500000.00,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(8,8,100.00,10000000.00,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(9,9,1.00,50000000.00,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(10,10,1.00,5000000.00,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28'),(11,11,1.00,100000000.00,'2024-12-20 17:39:28',NULL,'2024-12-20 17:39:28','2024-12-20 17:39:28');
/*!40000 ALTER TABLE `limites_servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2024_12_18_074444_reorganize_database_structure',1),(2,'2024_12_18_074445_create_default_modules',1),(3,'2024_12_19_072834_create_servicios_bancarios_tables',1),(4,'2024_12_19_084052_add_avatar_to_users_table',1),(5,'2024_12_20_142107_create_administrative_and_transactional_logs',1),(6,'2024_12_20_143936_create_web_transactional_logs_table',1),(8,'2024_12_20_133400_normalize_servicios_table',2),(9,'2024_12_20_133700_fix_relationships',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulos`
--

DROP TABLE IF EXISTS `modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `modulos_codigo_unique` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` VALUES (1,'CLIENTES','CLIENTES','Módulo de gestión de clientes',1,'2024-12-20 20:53:46','2024-12-20 20:53:46'),(2,'LOG-TRANSACCIONAL','LOG-TRANSACCIONAL','Módulo de consulta de log transaccional',1,'2024-12-20 20:53:46','2024-12-20 20:53:46'),(3,'PARAMETROS','PARAMETROS','Configuración de parámetros del sistema',1,'2024-12-20 20:53:46','2024-12-20 20:53:46'),(4,'BITACORA','BITACORA','Registro de actividades del sistema',1,'2024-12-20 20:53:46','2024-12-20 20:53:46'),(5,'USUARIOS','Gestión de Usuarios','Módulo para la administración de usuarios y roles',1,'2024-12-20 20:53:46','2024-12-20 20:53:46'),(6,'SERVICIOS','Gestión de Servicios','Módulo para la administración de servicios y afiliaciones',1,'2024-12-20 20:53:46','2024-12-20 20:53:46'),(7,'DASHBOARD','DASHBOARD','Módulo principal del dashboard',1,'2024-12-20 20:53:46','2024-12-20 20:53:46');
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametros`
--

DROP TABLE IF EXISTS `parametros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametros` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `grupo_id` bigint(20) unsigned NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `valor` text NOT NULL,
  `descripcion` text NOT NULL,
  `es_editable` tinyint(1) NOT NULL DEFAULT 1,
  `es_visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parametros_codigo_unique` (`codigo`),
  KEY `parametros_grupo_id_foreign` (`grupo_id`),
  CONSTRAINT `parametros_grupo_id_foreign` FOREIGN KEY (`grupo_id`) REFERENCES `grupos_parametros` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametros`
--

LOCK TABLES `parametros` WRITE;
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
INSERT INTO `parametros` VALUES (1,1,'sistema.version','1.0.0','Versión actual del sistema de administración de canales',0,1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(2,1,'sistema.nombre','Admin Canales','Nombre oficial del sistema para mostrar en la interfaz',1,1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(3,2,'pagos.monto.minimo','15','Monto mínimo permitido para transacciones de pago en el sistema',1,1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(4,2,'pagos.monto.maximo','5900','Monto máximo permitido para transacciones de pago en el sistema',1,1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(5,3,'transferencias.monto.maximo','1600000','Límite máximo permitido para transferencias entre cuentas diferentes',1,1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(6,3,'transferencias.internas.monto.maximo','-1','Límite máximo para transferencias entre cuentas del mismo titular (-1 sin límite)',1,1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(7,4,'seguridad.sesion.duracion','120','Tiempo máximo de inactividad antes de cerrar la sesión (en minutos)',1,1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(8,4,'seguridad.intentos.maximos','3','Número máximo de intentos fallidos de inicio de sesión antes del bloqueo',1,1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(9,5,'notificaciones.email.habilitado','true','Activa o desactiva el envío de notificaciones por correo electrónico',1,1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(10,6,'logs.dias.retencion','90','Días que se mantienen los registros de actividad antes de ser archivados',1,1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(11,6,'logs.nivel.minimo','info','Nivel mínimo de importancia para registrar eventos en los logs del sistema',1,1,'2024-12-20 20:53:47','2024-12-20 20:53:47');
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_codigo_unique` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'Ver Dashboard','dashboard.view','Permite ver el dashboard','2024-12-20 20:53:46','2024-12-20 20:53:46'),(2,'Gestionar Usuarios','users.manage','Permite gestionar usuarios','2024-12-20 20:53:46','2024-12-20 20:53:46'),(3,'Gestionar Roles','roles.manage','Permite gestionar roles','2024-12-20 20:53:46','2024-12-20 20:53:46'),(4,'Gestionar Servicios','services.manage','Permite gestionar servicios','2024-12-20 20:53:46','2024-12-20 20:53:46'),(5,'Ver Transacciones','transactions.view','Permite ver transacciones','2024-12-20 20:53:46','2024-12-20 20:53:46'),(6,'Realizar Transacciones','transactions.create','Permite realizar transacciones','2024-12-20 20:53:46','2024-12-20 20:53:46'),(7,'Gestionar Parámetros','parameters.manage','Permite gestionar parámetros del sistema','2024-12-20 20:53:46','2024-12-20 20:53:46');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_permissions` (
  `role_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `role_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permissions`
--

LOCK TABLES `role_permissions` WRITE;
/*!40000 ALTER TABLE `role_permissions` DISABLE KEYS */;
INSERT INTO `role_permissions` VALUES (1,1,'2024-12-20 20:53:46','2024-12-20 20:53:46'),(1,2,'2024-12-20 20:53:46','2024-12-20 20:53:46'),(1,3,'2024-12-20 20:53:46','2024-12-20 20:53:46'),(1,4,'2024-12-20 20:53:46','2024-12-20 20:53:46'),(1,5,'2024-12-20 20:53:46','2024-12-20 20:53:46'),(1,6,'2024-12-20 20:53:46','2024-12-20 20:53:46'),(1,7,'2024-12-20 20:53:46','2024-12-20 20:53:46');
/*!40000 ALTER TABLE `role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador','Rol con acceso completo al sistema','2024-12-20 20:53:46','2024-12-20 20:53:46'),(2,'Usuario','Usuario regular del sistema','2024-12-20 20:53:46','2024-12-20 20:53:46'),(3,'Operador','Operador con acceso a funciones específicas','2024-12-20 20:53:46','2024-12-20 20:53:46');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicios`
--

DROP TABLE IF EXISTS `servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_servicio_id` bigint(20) unsigned NOT NULL,
  `empresa_servicio_id` bigint(20) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `codigo_servicio` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `servicios_codigo_servicio_unique` (`codigo_servicio`),
  KEY `servicios_tipo_servicio_id_foreign` (`tipo_servicio_id`),
  CONSTRAINT `servicios_tipo_servicio_id_foreign` FOREIGN KEY (`tipo_servicio_id`) REFERENCES `tipos_servicios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios`
--

LOCK TABLES `servicios` WRITE;
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
INSERT INTO `servicios` VALUES (1,1,0,'Movistar Venezuela','Telefónica Venezuela','MOVISTAR_VE',1,'Servicios de telefonía móvil Movistar','2024-12-20 20:53:47','2024-12-20 20:53:47'),(2,1,0,'Digitel','Corporación Digitel C.A.','DIGITEL_VE',1,'Servicios de telefonía móvil Digitel','2024-12-20 20:53:47','2024-12-20 20:53:47'),(3,2,0,'CORPOELEC','Corporación Eléctrica Nacional','CORPOELEC_VE',1,'Servicio eléctrico nacional','2024-12-20 20:53:47','2024-12-20 20:53:47'),(4,3,0,'Hidrocapital','Hidrológica de la Región Capital','HIDROCAPITAL_VE',1,'Servicio de agua potable región capital','2024-12-20 20:53:47','2024-12-20 20:53:47'),(5,4,0,'CANTV','Compañía Anónima Nacional Teléfonos de Venezuela','CANTV_INTERNET_VE',1,'Servicio de internet ABA','2024-12-20 20:53:47','2024-12-20 20:53:47'),(6,5,0,'Inter','Inter Venezuela','INTER_VE',1,'Servicio de televisión por cable','2024-12-20 20:53:47','2024-12-20 20:53:47'),(7,6,0,'Gas Comunal','Gas Comunal S.A.','GAS_COMUNAL_VE',1,'Servicio de gas doméstico','2024-12-20 20:53:47','2024-12-20 20:53:47'),(8,7,0,'Seguros La Previsora','La Previsora Seguros C.A.','PREVISORA_VE',1,'Servicios de seguros varios','2024-12-20 20:53:47','2024-12-20 20:53:47'),(9,8,0,'SENIAT','Servicio Nacional Integrado de Administración Aduanera y Tributaria','SENIAT_VE',1,'Pago de impuestos nacionales','2024-12-20 20:53:47','2024-12-20 20:53:47'),(10,9,0,'Universidad Central de Venezuela','Universidad Central de Venezuela','UCV_VE',1,'Pagos universitarios UCV','2024-12-20 20:53:47','2024-12-20 20:53:47'),(11,10,0,'Banco de Venezuela','Banco de Venezuela S.A.','BDV_TC_VE',1,'Pago de tarjetas de crédito Banco de Venezuela','2024-12-20 20:53:47','2024-12-20 20:53:47');
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('ORyDhMDcu1quu9SY4ooz6PevOe3x3Zrb176hxqMl',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoicGxaT0pDMWc5aGlHNm0yODFCYnk1NXpQdHdCWUR2TWhXb3Flc1gwcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9hZG1pbmNhbmFsZXMudGVzdCI7fX0=',1734716459);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_servicios`
--

DROP TABLE IF EXISTS `tipos_servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos_servicios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tipos_servicios_codigo_unique` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_servicios`
--

LOCK TABLES `tipos_servicios` WRITE;
/*!40000 ALTER TABLE `tipos_servicios` DISABLE KEYS */;
INSERT INTO `tipos_servicios` VALUES (1,'TELEFONIA','Telefonía','Servicios de telefonía fija y móvil',1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(2,'ELECTRICIDAD','Electricidad','Servicios de energía eléctrica',1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(3,'AGUA','Agua','Servicios de agua potable',1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(4,'INTERNET','Internet','Servicios de internet',1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(5,'TELEVISION','Televisión por Cable','Servicios de televisión por cable y satelital',1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(6,'GAS','Gas Natural','Servicios de gas doméstico',1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(7,'SEGUROS','Seguros','Servicios de seguros',1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(8,'IMPUESTOS','Impuestos','Pagos de impuestos nacionales',1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(9,'EDUCACION','Instituciones Educativas','Pagos de instituciones educativas',1,'2024-12-20 20:53:47','2024-12-20 20:53:47'),(10,'TARJETAS','Tarjetas de Crédito','Pagos de tarjetas de crédito',1,'2024-12-20 20:53:47','2024-12-20 20:53:47');
/*!40000 ALTER TABLE `tipos_servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_transaccion`
--

DROP TABLE IF EXISTS `tipos_transaccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos_transaccion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tipos_transaccion_codigo_unique` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_transaccion`
--

LOCK TABLES `tipos_transaccion` WRITE;
/*!40000 ALTER TABLE `tipos_transaccion` DISABLE KEYS */;
INSERT INTO `tipos_transaccion` VALUES (1,'PAGO','Pago de Servicio','Pago de servicio realizado por el cliente','2024-12-20 20:53:47','2024-12-20 20:53:47'),(2,'RECA','Recarga','Recarga de saldo','2024-12-20 20:53:47','2024-12-20 20:53:47'),(3,'CONS','Consulta','Consulta de saldo o estado de cuenta','2024-12-20 20:53:47','2024-12-20 20:53:47'),(4,'TRAN','Transferencia','Transferencia entre cuentas','2024-12-20 20:53:47','2024-12-20 20:53:47'),(5,'REVE','Reverso','Reverso de transacción','2024-12-20 20:53:47','2024-12-20 20:53:47');
/*!40000 ALTER TABLE `tipos_transaccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transacciones`
--

DROP TABLE IF EXISTS `transacciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transacciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `tipo_transaccion_id` bigint(20) unsigned NOT NULL,
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
  `servicio_id` bigint(20) unsigned DEFAULT NULL,
  `estado_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transacciones_user_id_foreign` (`user_id`),
  KEY `transacciones_tipo_transaccion_id_foreign` (`tipo_transaccion_id`),
  KEY `transacciones_servicio_id_foreign` (`servicio_id`),
  KEY `transacciones_estado_id_foreign` (`estado_id`),
  CONSTRAINT `transacciones_estado_id_foreign` FOREIGN KEY (`estado_id`) REFERENCES `estados_transaccion` (`id`),
  CONSTRAINT `transacciones_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`),
  CONSTRAINT `transacciones_tipo_transaccion_id_foreign` FOREIGN KEY (`tipo_transaccion_id`) REFERENCES `tipos_transaccion` (`id`),
  CONSTRAINT `transacciones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transacciones`
--

LOCK TABLES `transacciones` WRITE;
/*!40000 ALTER TABLE `transacciones` DISABLE KEYS */;
INSERT INTO `transacciones` VALUES (1,2,1,'V-12345678','2024-12-18 16:53:47','Cuenta 1234','Servicio XYZ',150.00,'Pago de servicio mensual','REF-6247','192.168.1.105',NULL,'2024-12-20 20:53:47','2024-12-20 20:53:47',NULL,NULL),(2,2,2,'V-87654321','2024-12-19 16:53:47','Agente 5678','Cuenta 9876',200.00,'Recarga de saldo','REF-5691','192.168.1.52',NULL,'2024-12-20 20:53:47','2024-12-20 20:53:47',NULL,NULL),(3,2,3,'V-12345678','2024-12-20 16:53:47','App Móvil','Sistema',0.00,'Consulta de saldo','REF-7921','192.168.1.49',NULL,'2024-12-20 20:53:47','2024-12-20 20:53:47',NULL,NULL),(4,3,4,'V-87654321','2024-12-20 13:53:47','Cuenta 1234','Cuenta 5678',300.00,'Transferencia entre cuentas','REF-8304','192.168.1.57',NULL,'2024-12-20 20:53:47','2024-12-20 20:53:47',NULL,NULL),(5,2,5,'V-12345678','2024-12-20 15:53:47','Sistema','Cuenta 1234',150.00,'Reverso de pago','REF-5298','192.168.1.132',NULL,'2024-12-20 20:53:47','2024-12-20 20:53:47',NULL,NULL);
/*!40000 ALTER TABLE `transacciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_logs`
--

DROP TABLE IF EXISTS `user_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `action` varchar(255) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `user_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_logs`
--

LOCK TABLES `user_logs` WRITE;
/*!40000 ALTER TABLE `user_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_cedula_unique` (`cedula`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'Admin','Sistema','V-12345678','04141234567','admin@admin.com',NULL,'admin','$2y$12$fqC4LE8GrhJdrpdzoDmeouAWREI.uI4GHoWXCnLJA2jpsFaonH1pC','active',1,NULL,0,NULL,NULL,NULL,NULL),(2,2,'Usuario','Demo','V-87654321','04141234568','usuario@demo.com',NULL,'usuario','$2y$12$zGRUWiwSSMoW/MjV5zjOMO0RX2g1fZWC7rOnNxE/YHAGa8CmJtDTa','active',1,NULL,0,NULL,NULL,NULL,NULL),(3,3,'Operador','Sistema','V-11223344','04141234569','operador@sistema.com',NULL,'operador','$2y$12$PnYBBDKP2Qm2EzrlRav46uZ6ciGlx33TjwNW92wlgDezGFUhNJ4XK','active',1,NULL,0,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `web_transactional_logs`
--

DROP TABLE IF EXISTS `web_transactional_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `web_transactional_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `web_transactional_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `web_transactional_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `web_transactional_logs`
--

LOCK TABLES `web_transactional_logs` WRITE;
/*!40000 ALTER TABLE `web_transactional_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `web_transactional_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'admincanales'
--

--
-- Dumping routines for database 'admincanales'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-20 14:21:41
