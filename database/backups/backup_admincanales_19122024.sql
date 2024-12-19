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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bitacora`
--

LOCK TABLES `bitacora` WRITE;
/*!40000 ALTER TABLE `bitacora` DISABLE KEYS */;
INSERT INTO `bitacora` VALUES (1,1,'Admin Sistema','Búsqueda de cliente',2,'Búsqueda exitosa de cliente con cédula: V-87654321','\"{\\\"cedula\\\":\\\"V-87654321\\\",\\\"encontrado\\\":true,\\\"cliente_id\\\":2}\"','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0','2024-12-19 10:53:29','2024-12-19 10:53:29'),(2,1,'Admin Sistema','creación',6,'Se creó un nuevo registro','\"{\\\"name\\\":\\\"Brian\\\",\\\"apellido\\\":\\\"Maraima\\\",\\\"cedula\\\":\\\"V-27467624\\\",\\\"email\\\":\\\"brian@gmail.com\\\",\\\"username\\\":\\\"brian\\\",\\\"telefono\\\":\\\"04142358784\\\",\\\"role_id\\\":2,\\\"activo\\\":true,\\\"updated_at\\\":\\\"2024-12-19T06:54:03.000000Z\\\",\\\"created_at\\\":\\\"2024-12-19T06:54:03.000000Z\\\",\\\"id\\\":4}\"','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0','2024-12-19 10:54:03','2024-12-19 10:54:03');
/*!40000 ALTER TABLE `bitacora` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresas_servicios`
--

LOCK TABLES `empresas_servicios` WRITE;
/*!40000 ALTER TABLE `empresas_servicios` DISABLE KEYS */;
/*!40000 ALTER TABLE `empresas_servicios` ENABLE KEYS */;
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
INSERT INTO `grupos_parametros` VALUES (1,'sistema','Configuración del Sistema','2024-12-19 10:52:41','2024-12-19 10:52:41'),(2,'pagos','Configuración de Pagos','2024-12-19 10:52:41','2024-12-19 10:52:41'),(3,'transferencias','Configuración de Transferencias','2024-12-19 10:52:41','2024-12-19 10:52:41'),(4,'seguridad','Configuración de Seguridad','2024-12-19 10:52:41','2024-12-19 10:52:41'),(5,'notificaciones','Configuración de Notificaciones','2024-12-19 10:52:41','2024-12-19 10:52:41'),(6,'logs','Configuración de Logs','2024-12-19 10:52:41','2024-12-19 10:52:41');
/*!40000 ALTER TABLE `grupos_parametros` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2024_12_18_074444_reorganize_database_structure',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` VALUES (1,'DASHBOARD','DASHBOARD','Módulo principal del dashboard',1,'2024-12-19 10:52:40','2024-12-19 10:52:40'),(2,'CLIENTES','CLIENTES','Módulo de gestión de clientes',1,'2024-12-19 10:52:40','2024-12-19 10:52:40'),(3,'PARAMETROS','PARAMETROS','Configuración de parámetros del sistema',1,'2024-12-19 10:52:40','2024-12-19 10:52:40'),(4,'BITACORA','BITACORA','Registro de actividades del sistema',1,'2024-12-19 10:52:40','2024-12-19 10:52:40'),(5,'LOG-TRANSACCIONAL','LOG-TRANSACCIONAL','Módulo de consulta de log transaccional',1,'2024-12-19 10:52:40','2024-12-19 10:52:40'),(6,'USER','User','Módulo de User',1,'2024-12-19 10:54:03','2024-12-19 10:54:03');
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
INSERT INTO `parametros` VALUES (1,1,'sistema.version','1.0.0','Versión actual del sistema de administración de canales',0,1,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(2,1,'sistema.nombre','Admin Canales','Nombre oficial del sistema para mostrar en la interfaz',1,1,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(3,2,'pagos.monto.minimo','15','Monto mínimo permitido para transacciones de pago en el sistema',1,1,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(4,2,'pagos.monto.maximo','5900','Monto máximo permitido para transacciones de pago en el sistema',1,1,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(5,3,'transferencias.monto.maximo','1600000','Límite máximo permitido para transferencias entre cuentas diferentes',1,1,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(6,3,'transferencias.internas.monto.maximo','-1','Límite máximo para transferencias entre cuentas del mismo titular (-1 sin límite)',1,1,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(7,4,'seguridad.sesion.duracion','120','Tiempo máximo de inactividad antes de cerrar la sesión (en minutos)',1,1,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(8,4,'seguridad.intentos.maximos','3','Número máximo de intentos fallidos de inicio de sesión antes del bloqueo',1,1,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(9,5,'notificaciones.email.habilitado','true','Activa o desactiva el envío de notificaciones por correo electrónico',1,1,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(10,6,'logs.dias.retencion','90','Días que se mantienen los registros de actividad antes de ser archivados',1,1,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(11,6,'logs.nivel.minimo','info','Nivel mínimo de importancia para registrar eventos en los logs del sistema',1,1,'2024-12-19 10:52:41','2024-12-19 10:52:41');
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
INSERT INTO `permissions` VALUES (1,'Ver Dashboard','dashboard.view','Permite ver el dashboard','2024-12-19 10:52:40','2024-12-19 10:52:40'),(2,'Gestionar Usuarios','users.manage','Permite gestionar usuarios','2024-12-19 10:52:40','2024-12-19 10:52:40'),(3,'Gestionar Roles','roles.manage','Permite gestionar roles','2024-12-19 10:52:40','2024-12-19 10:52:40'),(4,'Gestionar Servicios','services.manage','Permite gestionar servicios','2024-12-19 10:52:40','2024-12-19 10:52:40'),(5,'Ver Transacciones','transactions.view','Permite ver transacciones','2024-12-19 10:52:40','2024-12-19 10:52:40'),(6,'Realizar Transacciones','transactions.create','Permite realizar transacciones','2024-12-19 10:52:40','2024-12-19 10:52:40'),(7,'Gestionar Parámetros','parameters.manage','Permite gestionar parámetros del sistema','2024-12-19 10:52:40','2024-12-19 10:52:40');
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
INSERT INTO `role_permissions` VALUES (1,1,'2024-12-19 10:52:40','2024-12-19 10:52:40'),(1,2,'2024-12-19 10:52:40','2024-12-19 10:52:40'),(1,3,'2024-12-19 10:52:40','2024-12-19 10:52:40'),(1,4,'2024-12-19 10:52:40','2024-12-19 10:52:40'),(1,5,'2024-12-19 10:52:40','2024-12-19 10:52:40'),(1,6,'2024-12-19 10:52:40','2024-12-19 10:52:40'),(1,7,'2024-12-19 10:52:40','2024-12-19 10:52:40');
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
INSERT INTO `roles` VALUES (1,'Administrador','Rol con acceso completo al sistema','2024-12-19 10:52:40','2024-12-19 10:52:40'),(2,'Usuario','Usuario regular del sistema','2024-12-19 10:52:40','2024-12-19 10:52:40'),(3,'Operador','Operador con acceso a funciones específicas','2024-12-19 10:52:40','2024-12-19 10:52:40');
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
  `nombre` varchar(255) NOT NULL,
  `tipo_servicio` enum('telefonia','electricidad','agua','tv') NOT NULL,
  `estatus` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `limite_minimo` decimal(10,2) NOT NULL,
  `limite_maximo` decimal(10,2) NOT NULL,
  `maxima_afiliacion` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios`
--

LOCK TABLES `servicios` WRITE;
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
INSERT INTO `servicios` VALUES (1,'Servicio de Telefonía','telefonia','Activo',5.00,1000.00,5,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(2,'Servicio Eléctrico','electricidad','Activo',10.00,5000.00,3,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(3,'Servicio de Agua','agua','Activo',5.00,2000.00,3,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(4,'Servicio de TV','tv','Activo',15.00,500.00,2,'2024-12-19 10:52:41','2024-12-19 10:52:41');
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
INSERT INTO `sessions` VALUES ('ly1Kj2bZmiusJN4jmj7sw5cvMGNDFl4TWJMIysYo',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM0NwWDhuMUJBZVA5S253TTRHUUtWWU13RlRYcm5xZG1PQVBuUk1yYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly9hZG1pbmNhbmFsZXMudGVzdC9jb25zdWx0YXMvYml0YWNvcmEiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1734591252);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
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
INSERT INTO `tipos_transaccion` VALUES (1,'PAGO','Pago de Servicio','Pago de servicio realizado por el cliente','2024-12-19 10:52:41','2024-12-19 10:52:41'),(2,'RECA','Recarga','Recarga de saldo','2024-12-19 10:52:41','2024-12-19 10:52:41'),(3,'CONS','Consulta','Consulta de saldo o estado de cuenta','2024-12-19 10:52:41','2024-12-19 10:52:41'),(4,'TRAN','Transferencia','Transferencia entre cuentas','2024-12-19 10:52:41','2024-12-19 10:52:41'),(5,'REVE','Reverso','Reverso de transacción','2024-12-19 10:52:41','2024-12-19 10:52:41');
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
  PRIMARY KEY (`id`),
  KEY `transacciones_user_id_foreign` (`user_id`),
  KEY `transacciones_tipo_transaccion_id_foreign` (`tipo_transaccion_id`),
  CONSTRAINT `transacciones_tipo_transaccion_id_foreign` FOREIGN KEY (`tipo_transaccion_id`) REFERENCES `tipos_transaccion` (`id`),
  CONSTRAINT `transacciones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transacciones`
--

LOCK TABLES `transacciones` WRITE;
/*!40000 ALTER TABLE `transacciones` DISABLE KEYS */;
INSERT INTO `transacciones` VALUES (1,1,1,'V-12345678','2024-12-17 06:52:41','Cuenta 1234','Servicio XYZ',150.00,'Pago de servicio mensual','REF-3833','192.168.1.99',NULL,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(2,3,2,'V-87654321','2024-12-18 06:52:41','Agente 5678','Cuenta 9876',200.00,'Recarga de saldo','REF-2794','192.168.1.251',NULL,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(3,3,3,'V-12345678','2024-12-19 06:52:41','App Móvil','Sistema',0.00,'Consulta de saldo','REF-6997','192.168.1.104',NULL,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(4,3,4,'V-87654321','2024-12-19 03:52:41','Cuenta 1234','Cuenta 5678',300.00,'Transferencia entre cuentas','REF-6777','192.168.1.179',NULL,'2024-12-19 10:52:41','2024-12-19 10:52:41'),(5,2,5,'V-12345678','2024-12-19 05:52:41','Sistema','Cuenta 1234',150.00,'Reverso de pago','REF-8482','192.168.1.149',NULL,'2024-12-19 10:52:41','2024-12-19 10:52:41');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'Admin','Sistema','V-12345678','04141234567','admin@admin.com','admin','$2y$12$W3AuESYgd1Y1pX38wNuF2ekJikoAmXOy9jpnNc77XmrZNEu10IM2u','active',1,NULL,0,NULL,NULL,NULL,NULL),(2,2,'Usuario','Demo','V-87654321','04141234568','usuario@demo.com','usuario','$2y$12$589UhVIaTVtpN5VFHkr9ruMaEscTiNDzBpdITcgGkTY0nj8YVnweW','active',1,NULL,0,NULL,NULL,NULL,NULL),(3,3,'Operador','Sistema','V-11223344','04141234569','operador@sistema.com','operador','$2y$12$SO4l3P/ZiTbTTUxLeNHOGeIbNlZps4KYBN1EV.p/UvSpZ2/swt6Hy','active',1,NULL,0,NULL,NULL,NULL,NULL),(4,2,'Brian','Maraima','V-27467624','04142358784','brian@gmail.com','brian','$2y$12$ZuKloEiJrzredmNVX/JKaewp8qK2FcxeHiUG2yt5LpTbprDdfgusS','active',1,NULL,0,NULL,NULL,'2024-12-19 10:54:03','2024-12-19 10:54:03');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-19  2:55:38
