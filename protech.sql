-- MySQL dump 10.17  Distrib 10.3.16-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: protech
-- ------------------------------------------------------
-- Server version	10.3.16-MariaDB

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
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `likes` int(10) unsigned DEFAULT 0,
  `views` int(10) unsigned DEFAULT 0,
  `catagory_id` int(10) unsigned NOT NULL,
  `published` tinyint(1) DEFAULT 0,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blogs_catagory_id_foreign` (`catagory_id`),
  KEY `blogs_user_id_foreign` (`user_id`),
  CONSTRAINT `blogs_catagory_id_foreign` FOREIGN KEY (`catagory_id`) REFERENCES `catagories` (`id`),
  CONSTRAINT `blogs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
INSERT INTO `blogs` VALUES (1,'2020-06-19 14:43:56','2020-06-19 18:03:28',NULL,'Hacking','<p>helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei helloo fey jehfihei </p>','1/12/QjyY17lTAiuLEeVepyZprlXnH06h4Wz7gV8bvzDS.png',1,3,1,1,1),(2,'2020-06-19 14:51:17','2020-06-19 18:09:38',NULL,'hihie','<p>jpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepnjpfjoewpjf cnpwepn</p>','1/18/KSeuRczzIhvnls81K5IxKVFNyCV10WOKsSwZsuFy.jpeg',0,1,1,1,1),(3,'2020-06-19 18:32:42','2020-06-20 17:19:37',NULL,'How to wrote php code','<pre class=\"language-php\"><code>&lt;?php\r\necho \'hello world\';\r\n?&gt;</code></pre>\r\n<p>The above code sply prints out <strong>hello world to </strong>your web browder so let\'s examine each line to help you easily understand what is just happening.</p>\r\n<ol>\r\n<li><strong>&lt;?php </strong>this line tells that this is the starring line of the php script, every php script starts with &lt;?php without this line your code won\'t be executed </li>\r\n<li>Secondly <strong>the echo</strong> statement it tele the interpreter to print out the text that is in closed </li>\r\n<li>Then the final line tells the script is ending and it is optional bit it has exceptional cases </li>\r\n</ol>\r\n<p>Thanks for followinv up stay connectee</p>','4/3/hn6fiFh2bbKKFqqIa2Kyp4HK9aAyF6AmpvlcJEqG.jpeg',0,3,1,1,4);
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catagories`
--

DROP TABLE IF EXISTS `catagories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catagories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `catagory` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catagories_user_id_foreign` (`user_id`),
  CONSTRAINT `catagories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catagories`
--

LOCK TABLES `catagories` WRITE;
/*!40000 ALTER TABLE `catagories` DISABLE KEYS */;
INSERT INTO `catagories` VALUES (1,'2020-06-19 14:43:17','2020-06-19 14:43:17',1,'hackimg');
/*!40000 ALTER TABLE `catagories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment_replies`
--

DROP TABLE IF EXISTS `comment_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment_replies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `blog_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `parent_comment_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_replies_blog_id_foreign` (`blog_id`),
  KEY `comment_replies_user_id_foreign` (`user_id`),
  KEY `comment_replies_parent_comment_id_foreign` (`parent_comment_id`),
  CONSTRAINT `comment_replies_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comment_replies_parent_comment_id_foreign` FOREIGN KEY (`parent_comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comment_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment_replies`
--

LOCK TABLES `comment_replies` WRITE;
/*!40000 ALTER TABLE `comment_replies` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment_replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `blog_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_blog_id_foreign` (`blog_id`),
  KEY `comments_user_id_foreign` (`user_id`),
  CONSTRAINT `comments_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'2020-06-19 17:54:03','2020-06-19 17:54:03','meha','hello am mehari bel',1,3,NULL),(2,'2020-06-19 17:55:52','2020-06-19 17:55:52','Protech','hello gzaaz',2,1,NULL),(3,'2020-06-19 17:59:36','2020-06-19 17:59:36','Protech','nfsnakfnksnfksnakfnasfa',2,1,NULL),(4,'2020-06-19 18:03:50','2020-06-19 18:03:50','Cree','Jfjhhwhwha',1,2,NULL),(5,'2020-06-19 18:09:50','2020-06-19 18:09:50','Ethio real Hackers','Ihicvutci',2,4,NULL),(6,'2020-06-19 18:15:46','2020-06-19 18:15:46','Ethio real Hackers','Notify now',2,4,NULL),(7,'2020-06-19 18:17:34','2020-06-19 18:17:34','Protech','nknknknknknk',2,1,NULL),(8,'2020-06-19 18:20:55','2020-06-19 18:20:55','Ethio real Hackers','Thank you very much for your help that was great and am very grateful to see this Lind of solution am going to create new post follow up me',2,4,NULL),(9,'2020-06-19 19:00:39','2020-06-19 19:00:39','Protech','mgrnkvenv',2,1,NULL);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `default_catagories`
--

DROP TABLE IF EXISTS `default_catagories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `default_catagories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `catagory` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `default_catagories`
--

LOCK TABLES `default_catagories` WRITE;
/*!40000 ALTER TABLE `default_catagories` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_catagories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2020_04_02_112639_catagory',1),(5,'2020_04_03_122032_create_blogs_table',1),(6,'2020_04_24_115133_create_default_catagories_table',1),(7,'2020_04_26_110933_create_notification_table',1),(8,'2020_04_28_114220_create_comments_table',1),(9,'2020_05_18_063229_create_comment_reply_table',1),(10,'2020_06_05_121159_create_subscribers_table',1),(11,'2020_06_10_093848_create_user_subscribers_table',1),(12,'2020_10_12_000000_create_user_info_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `subject` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_user_id` bigint(20) unsigned NOT NULL,
  `to_user_id` bigint(20) unsigned NOT NULL,
  `blog_id` bigint(20) unsigned NOT NULL,
  `seen` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `notifications_from_user_id_foreign` (`from_user_id`),
  KEY `notifications_to_user_id_foreign` (`to_user_id`),
  KEY `notifications_blog_id_foreign` (`blog_id`),
  CONSTRAINT `notifications_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notifications_from_user_id_foreign` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `notifications_to_user_id_foreign` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,'2020-06-19 17:59:37','2020-06-19 18:00:02','Comment','Protech commented on post ',1,1,2,1),(2,'2020-06-19 18:03:50','2020-06-19 18:05:13','Comment','Cree commented on post ',2,1,1,1),(3,'2020-06-19 18:15:46','2020-06-19 18:17:49','Comment','Ethio real Hackers commented on post ',4,1,2,1),(4,'2020-06-19 18:20:56','2020-06-19 18:54:08','Comment','Ethio real Hackers commented on post ',4,1,2,1);
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscribers`
--

DROP TABLE IF EXISTS `subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscribers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscribers`
--

LOCK TABLES `subscribers` WRITE;
/*!40000 ALTER TABLE `subscribers` DISABLE KEYS */;
INSERT INTO `subscribers` VALUES (1,'2020-06-19 14:50:15','2020-06-19 14:50:15','mmm@mail.com');
/*!40000 ALTER TABLE `subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_infos`
--

DROP TABLE IF EXISTS `user_infos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_infos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `about` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skill` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `fb` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tg` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `yb` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_infos_user_id_foreign` (`user_id`),
  CONSTRAINT `user_infos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_infos`
--

LOCK TABLES `user_infos` WRITE;
/*!40000 ALTER TABLE `user_infos` DISABLE KEYS */;
INSERT INTO `user_infos` VALUES (1,'2020-06-19 16:17:02','2020-06-19 16:26:03',NULL,NULL,'storage/profiles/cover/1/cZcpV8kRpEh4MVXa8gtDQpRm8DS16aPDBtgJ2T0J.jpeg',1,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `user_infos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_subscribers`
--

DROP TABLE IF EXISTS `user_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_subscribers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_subscribers_user_id_foreign` (`user_id`),
  CONSTRAINT `user_subscribers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_subscribers`
--

LOCK TABLES `user_subscribers` WRITE;
/*!40000 ALTER TABLE `user_subscribers` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `FirstName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LastName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'2020-06-19 14:41:40','2020-06-19 16:21:24','Protech','storage/profiles/1/E1QPgu4ahzEpdjbnfGxJiFjlDaKI9DiCDs7dYSVG.jpeg',NULL,NULL,'protech@founder.GtM','$2y$10$6Zgj/47pMvPqUgwDbTP.o.UywedlV3BNyZP6EfCQmYKy33a13FPde',0,'2020-06-19 14:41:40',NULL),(2,'2020-06-19 14:41:40','2020-06-19 14:41:40','Anonymous','0',NULL,NULL,'anonymous@gmail.com','$2y$10$ydglUPVFroLqu/rGT16wgu.eeA7gPvRvhRNhvU.3LngN7saBeza6.',0,'2020-06-19 14:41:40',NULL),(3,'2020-06-19 14:44:58','2020-06-19 14:46:26','meha','0',NULL,NULL,'meharib82@gmail.com','$2y$10$y/wzyx0/M9fHa86MF8pf..AH8Gvo2vHYzB2RgljJZxUC/CZ2GXg2C',0,'2020-06-19 14:46:26',NULL),(4,'2020-06-19 18:05:49','2020-06-19 18:08:07','Ethio real Hackers','0',NULL,NULL,'protech@gmail.com','$2y$10$KOQ2nhtFwLQXFidgnq8P4..zvXxS4xWDYI3y1wgeOyne7XmoPbD0O',0,'2020-06-19 18:08:07',NULL);
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

-- Dump completed on 2020-06-22  0:42:27
