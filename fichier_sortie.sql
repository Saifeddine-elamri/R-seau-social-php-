-- MySQL dump 10.13  Distrib 9.1.0, for Win64 (x86_64)
--
-- Host: localhost    Database: facebook_clone
-- ------------------------------------------------------
-- Server version	9.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comment_likes`
--

DROP TABLE IF EXISTS `comment_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment_likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comment_id` int NOT NULL,
  `user_id` int NOT NULL,
  `emoji_type` varchar(10) DEFAULT '?',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `comment_id` (`comment_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comment_likes_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comment_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment_likes`
--

LOCK TABLES `comment_likes` WRITE;
/*!40000 ALTER TABLE `comment_likes` DISABLE KEYS */;
INSERT INTO `comment_likes` VALUES (3,52,1,'❤️','2025-02-24 15:24:54'),(4,46,1,'😂','2025-02-24 15:25:10'),(5,39,1,'❤️','2025-02-24 15:34:55'),(6,53,2,'❤️','2025-02-24 16:40:12'),(7,60,1,'😂','2025-03-31 10:17:24');
/*!40000 ALTER TABLE `comment_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment_replies`
--

DROP TABLE IF EXISTS `comment_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment_replies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comment_id` int NOT NULL,
  `user_id` int NOT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `comment_id` (`comment_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comment_replies_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comment_replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment_replies`
--

LOCK TABLES `comment_replies` WRITE;
/*!40000 ALTER TABLE `comment_replies` DISABLE KEYS */;
INSERT INTO `comment_replies` VALUES (1,38,1,'coucou rouwaida','2025-02-24 15:39:32'),(2,51,1,'yes beautiful','2025-02-24 15:39:54'),(3,45,1,'haha','2025-02-24 16:04:25'),(4,51,2,'yep yep','2025-02-24 16:05:32'),(5,45,2,'tet9ou7eb 3a rajel hh','2025-02-24 16:06:18'),(6,52,2,'chbik tadh7ek','2025-02-24 16:42:32'),(7,56,1,'bara nayek b3id ya miboun','2025-02-26 11:26:24'),(8,52,1,'chbik tadh7ek sa7bi','2025-03-31 10:16:57');
/*!40000 ALTER TABLE `comment_replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (6,1,16,'haha','2025-02-06 13:48:15'),(7,1,16,'salut','2025-02-06 14:04:01'),(8,1,16,'salut','2025-02-06 14:04:40'),(9,1,16,'salut','2025-02-06 14:04:50'),(10,5,16,'7atteni','2025-02-06 14:06:44'),(11,5,13,'cute','2025-02-06 14:06:57'),(12,5,13,'cute','2025-02-06 14:07:58'),(13,5,13,'cute','2025-02-06 14:08:41'),(14,1,28,'9addechni zabour','2025-02-06 15:32:25'),(15,1,30,'wa9ila so5nit','2025-02-06 15:51:24'),(16,2,34,'Wow singab sa7bi','2025-02-06 17:35:43'),(17,1,31,'otiik ottik','2025-02-07 09:11:59'),(18,1,32,'yes tree','2025-02-07 09:26:36'),(19,1,31,'wouuu','2025-02-07 09:29:47'),(20,1,34,'sa7a sa7a','2025-02-07 10:00:45'),(21,2,28,'mala chojra','2025-02-07 18:44:33'),(22,2,33,'chojra mezyana','2025-02-07 18:44:48'),(23,2,42,'ramadhan 9rob kahaw','2025-02-10 14:14:38'),(24,1,63,'te7chée','2025-02-10 21:25:34'),(25,1,66,'hvjjh','2025-02-11 08:20:55'),(26,1,66,'jbjkjkb','2025-02-11 08:21:05'),(27,1,66,'bnbnb,','2025-02-11 08:21:14'),(28,1,66,'nbbnbvhv','2025-02-11 08:21:31'),(29,3,70,'good morning 7aboub','2025-02-11 12:38:36'),(30,3,67,'aah louled','2025-02-11 12:43:47'),(31,3,70,'commentaires','2025-02-11 12:45:46'),(32,3,70,'habibi :p','2025-02-11 12:46:17'),(33,6,71,'eyy 3andek 7a9 ya 7assra','2025-02-11 12:50:04'),(34,6,71,'hawka b3athtlik invi i9belha','2025-02-11 12:50:18'),(35,9,73,'7atteni jdida 9a3da net3lem kifech nessta3malha','2025-02-11 13:19:08'),(36,8,76,'ramdhank mabrouk imed','2025-02-11 14:17:49'),(37,10,76,'merci siwar mabrouk 3lik zeda','2025-02-11 14:18:22'),(38,17,81,'coucou salma','2025-02-11 16:49:18'),(39,3,82,'coucou','2025-02-11 17:20:52'),(40,3,80,'yo9tel bedhohk karim gharbi','2025-02-11 17:21:52'),(41,12,77,'7atteni rien','2025-02-11 17:24:15'),(42,10,81,'coucou','2025-02-11 17:25:20'),(43,10,78,'yeeeees','2025-02-11 17:33:36'),(44,5,83,'eyy sma3tou passage 7lou','2025-02-11 17:45:47'),(45,7,85,'3ak3ek yal monjo','2025-02-16 22:13:07'),(46,5,85,'7ala m3ak yal monji','2025-02-16 22:13:34'),(47,14,85,'wow je veux bien visiter la tunisie','2025-02-16 22:15:16'),(48,14,83,'jenjoun ghoul','2025-02-16 22:25:35'),(49,5,87,'wouuu','2025-02-17 09:14:00'),(50,5,75,'kasse7 karim gharbi','2025-02-17 09:18:26'),(51,5,86,'thats impressing','2025-02-17 09:20:43'),(52,1,88,'haha','2025-02-17 11:46:01'),(53,1,89,'good morning','2025-02-17 11:53:06'),(54,2,89,'goof morning saif','2025-02-17 11:53:41'),(55,1,85,'otik otik','2025-02-21 16:27:16'),(56,2,91,'Ya3tik 3assba','2025-02-26 11:25:52'),(57,2,92,'Habbay','2025-02-26 11:33:19'),(58,2,92,'Otik otik','2025-02-26 11:33:46'),(59,4,93,'What','2025-02-26 11:41:46'),(60,1,84,'mala korza','2025-03-31 10:17:12'),(61,1,93,'coucou youssef','2025-03-31 10:17:51');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friends` (
  `user_id` int NOT NULL,
  `friend_id` int NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  PRIMARY KEY (`user_id`,`friend_id`),
  KEY `friend_id` (`friend_id`),
  CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` VALUES (1,2,'accepted'),(1,4,'accepted'),(1,5,'accepted'),(1,10,'accepted'),(1,11,'accepted'),(2,1,'accepted'),(2,5,'accepted'),(3,2,'accepted'),(3,4,'accepted'),(3,5,'accepted'),(3,6,'pending'),(3,8,'accepted'),(3,9,'pending'),(3,11,'pending'),(4,2,'accepted'),(4,6,'pending'),(4,8,'accepted'),(4,12,'accepted'),(5,2,'accepted'),(5,4,'accepted'),(5,6,'pending'),(5,13,'pending'),(5,15,'pending'),(5,16,'accepted'),(5,17,'pending'),(5,18,'pending'),(6,7,'accepted'),(7,2,'accepted'),(7,3,'accepted'),(7,4,'accepted'),(7,5,'accepted'),(7,12,'accepted'),(8,2,'accepted'),(8,5,'accepted'),(8,10,'accepted'),(9,4,'accepted'),(9,5,'accepted'),(9,6,'pending'),(10,3,'accepted'),(10,4,'accepted'),(10,5,'accepted'),(10,6,'pending'),(11,4,'accepted'),(11,5,'accepted'),(11,8,'accepted'),(11,9,'pending'),(11,12,'accepted'),(12,2,'accepted'),(12,3,'accepted'),(12,5,'accepted'),(12,6,'pending'),(12,9,'pending'),(12,10,'accepted'),(14,2,'accepted'),(14,3,'accepted'),(14,4,'accepted'),(14,5,'accepted');
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `emoji_type` varchar(10) NOT NULL DEFAULT '?',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (2,1,9,'2025-02-06 13:50:05','?'),(10,1,17,'2025-02-06 14:01:52','?'),(11,1,16,'2025-02-06 14:01:55','?'),(12,1,15,'2025-02-06 14:05:02','😂'),(15,5,17,'2025-02-06 14:06:31','?'),(16,5,16,'2025-02-06 14:06:37','?'),(17,5,18,'2025-02-06 14:09:24','?'),(18,3,19,'2025-02-06 14:18:12','?'),(20,4,20,'2025-02-06 15:07:52','?'),(21,4,21,'2025-02-06 15:08:11','?'),(22,4,27,'2025-02-06 15:10:56','?'),(24,4,22,'2025-02-06 15:11:07','?'),(25,4,23,'2025-02-06 15:11:16','?'),(26,4,25,'2025-02-06 15:17:28','?'),(27,1,18,'2025-02-07 08:59:02','?'),(31,1,13,'2025-02-07 09:23:41','?'),(34,1,19,'2025-02-07 09:53:38','?'),(41,1,34,'2025-02-07 10:13:25','?'),(42,1,20,'2025-02-07 10:13:42','😂'),(45,2,28,'2025-02-07 18:46:39','?'),(51,2,36,'2025-02-07 18:55:52','?'),(53,2,35,'2025-02-07 18:56:07','?'),(54,2,31,'2025-02-07 18:56:43','?'),(55,2,42,'2025-02-10 14:15:18','?'),(56,2,41,'2025-02-10 14:15:22','?'),(57,2,26,'2025-02-10 14:15:36','?'),(58,1,25,'2025-02-10 15:07:39','?'),(59,5,24,'2025-02-10 15:24:41','?'),(60,5,42,'2025-02-10 15:24:49','?'),(61,1,59,'2025-02-10 20:48:33','?'),(62,1,61,'2025-02-11 08:17:14','?'),(63,1,66,'2025-02-11 08:17:20','?'),(65,1,63,'2025-02-11 08:55:04','?'),(67,1,79,'2025-02-16 20:08:22','?'),(74,1,83,'2025-02-16 20:40:03','😡'),(76,1,76,'2025-02-16 20:47:46','😡'),(77,1,64,'2025-02-16 20:47:57','😡'),(81,1,84,'2025-02-16 21:01:16','😡'),(82,1,81,'2025-02-16 21:13:07','😂'),(84,1,80,'2025-02-16 21:17:05','😂'),(85,1,70,'2025-02-16 21:19:12','😂'),(87,1,82,'2025-02-16 21:19:29','❤️'),(90,2,79,'2025-02-16 21:29:15','😂'),(91,2,73,'2025-02-16 21:32:05','😂'),(93,2,81,'2025-02-16 21:33:34','😂'),(94,2,80,'2025-02-16 21:34:30','😂'),(95,2,74,'2025-02-16 21:34:57','❤️'),(96,2,75,'2025-02-16 21:35:38','😂'),(97,2,83,'2025-02-16 21:37:12','😂'),(98,2,82,'2025-02-16 21:37:44','❤️'),(99,2,77,'2025-02-16 21:38:20','😡'),(100,2,76,'2025-02-16 22:03:07','😂'),(101,7,84,'2025-02-16 22:03:57','❤️'),(102,6,84,'2025-02-16 22:04:18','😂'),(103,6,82,'2025-02-16 22:04:52','❤️'),(104,6,80,'2025-02-16 22:05:04','❤️'),(105,6,66,'2025-02-16 22:09:45','❤️'),(106,7,85,'2025-02-16 22:12:54','❤️'),(107,5,85,'2025-02-16 22:13:40','❤️'),(108,4,85,'2025-02-16 22:14:04','👍'),(109,14,85,'2025-02-16 22:15:00','😮'),(110,14,81,'2025-02-16 22:23:59','👍'),(111,14,82,'2025-02-16 22:24:28','👍'),(112,14,84,'2025-02-16 22:24:45','❤️'),(113,14,83,'2025-02-16 22:25:03','❤️'),(114,14,86,'2025-02-16 22:29:13','❤️'),(115,3,86,'2025-02-16 22:29:46','❤️'),(117,5,87,'2025-02-17 09:14:08','❤️'),(118,5,80,'2025-02-17 09:18:37','😂'),(119,1,60,'2025-02-17 11:45:48','❤️'),(120,1,88,'2025-02-17 11:45:53','😂'),(121,1,52,'2025-02-17 11:46:24','😡'),(122,1,89,'2025-02-17 11:53:14','❤️'),(125,2,87,'2025-02-17 12:07:29','😂'),(126,2,86,'2025-02-17 12:09:22','😡'),(127,2,85,'2025-02-17 12:12:04','😡'),(130,2,89,'2025-02-17 12:26:42','👍'),(131,2,71,'2025-02-17 12:42:22','❤️'),(132,2,88,'2025-02-17 13:10:52','❤️'),(134,1,85,'2025-02-21 16:26:59','❤️'),(135,1,90,'2025-02-21 16:29:32','😡'),(136,1,91,'2025-02-26 11:25:22','❤️'),(137,2,91,'2025-02-26 11:26:31','😂'),(138,2,92,'2025-02-26 11:28:03','❤️'),(139,1,92,'2025-02-26 11:28:57','😢'),(140,4,93,'2025-02-26 11:41:50','😮'),(141,1,93,'2025-03-31 10:17:39','❤️');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_reactions`
--

DROP TABLE IF EXISTS `message_reactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message_reactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message_id` int NOT NULL,
  `user_id` int NOT NULL,
  `reaction` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `message_id` (`message_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `message_reactions_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `message_reactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_reactions`
--

LOCK TABLES `message_reactions` WRITE;
/*!40000 ALTER TABLE `message_reactions` DISABLE KEYS */;
INSERT INTO `message_reactions` VALUES (1,81,2,'❤️','2025-02-24 16:29:46'),(2,7,1,'❤️','2025-03-31 10:19:58'),(3,92,1,'❤️','2025-04-01 20:47:16');
/*!40000 ALTER TABLE `message_reactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `image` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `audio` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,1,3,'hello sofienne',NULL,0,'2025-02-05 10:28:05',NULL),(2,1,3,'hello sofienne',NULL,0,'2025-02-05 10:29:01',NULL),(3,1,3,'labes',NULL,0,'2025-02-05 10:29:19',NULL),(4,3,1,'hello saif',NULL,1,'2025-02-05 10:32:48',NULL),(5,2,3,'ahla sofienne',NULL,0,'2025-02-05 11:40:02',NULL),(6,5,3,'we are friends now',NULL,0,'2025-02-05 11:49:22',NULL),(7,4,1,'hana ami youpi doupi',NULL,1,'2025-02-05 11:55:09',NULL),(8,4,3,'salut sofienne',NULL,0,'2025-02-05 12:19:03',NULL),(9,1,3,'hello',NULL,0,'2025-02-06 10:57:02',NULL),(10,1,2,'salut youssef',NULL,1,'2025-02-06 11:22:31',NULL),(11,3,2,'ahla youssef',NULL,1,'2025-02-06 12:33:50',NULL),(12,3,2,'cvn',NULL,1,'2025-02-06 12:38:13',NULL),(13,3,2,'chbik matjawebech ya 7aggar',NULL,1,'2025-02-06 12:38:30',NULL),(14,3,2,'manich 7aggar sa7bi',NULL,1,'2025-02-06 12:39:41',NULL),(15,2,3,'chbi 3zzek',NULL,0,'2025-02-06 12:40:45',NULL),(16,1,4,'Pour accéder au nouveau design de Facebook sur votre navigateur, deux possibilités. Pour certains, il suffit d’aller sur Facebook : le réseau social peut vous proposer l’activation de la nouvelle version. Si ce n’est pas le cas, bonne nouvelle : vous pouvez activer manuellement la nouvelle version de Facebook. Accédez simplement au menu situé en haut à droite et cliquez sur « Passer au nouveau Facebook ».\r\n\r\n\r\nPasser au nouveau Facebook. Crédits : BDM.\r\nLe dark mode de Facebook est disponible\r\nLa nouvelle version de Facebook permet notamment d’accéder au dark mode, le thème sombre de Facebook sur desktop. Les publications se chargent plus rapidement et l’interface est épurée pour vous permettre « d’accéder à ce que vous voulez plus facilement ». Le dark mode peut être choisi à l’activation du nouveau design ou plus tard, manuellement, via le menu situé en haut à droite. À noter que pendant encore quelques temps, vous pouvez revenir à l’ancien design de Facebook, toujours via le menu.',NULL,0,'2025-02-06 13:54:25',NULL),(17,4,1,'oui oui oui',NULL,1,'2025-02-06 14:43:17',NULL),(18,4,1,'ya3tik 3assba 7louwa',NULL,1,'2025-02-06 14:43:31',NULL),(19,4,2,'dqsd',NULL,1,'2025-02-06 14:52:24',NULL),(20,1,5,'welcome',NULL,1,'2025-02-06 15:26:22',NULL),(21,1,4,'cwcx',NULL,0,'2025-02-06 15:42:51',NULL),(22,1,4,'go nayek',NULL,0,'2025-02-06 15:43:02',NULL),(23,1,3,'aa hagar',NULL,0,'2025-02-06 15:54:29',NULL),(24,1,3,'heyy',NULL,0,'2025-02-06 15:57:55',NULL),(25,1,3,'tree baba','1738857553_tree.jpeg',0,'2025-02-06 15:59:13',NULL),(26,1,3,'chahi s7ayen kosksi sa7bik','1738857658_couscsi.jpeg',0,'2025-02-06 16:00:58',NULL),(27,1,3,'ramadhan','1738858143_ramadhan.jpg',0,'2025-02-06 16:09:03',NULL),(28,1,5,'shutter','1738858339_shutterstock-81020101.jpg',1,'2025-02-06 16:12:19',NULL),(29,1,5,'tree','1738858367_tree.jpeg',1,'2025-02-06 16:12:47',NULL),(30,2,5,'haw dhib 3al faza',NULL,1,'2025-02-06 17:39:00',NULL),(31,2,5,'jnkbj','1738863773_tree.jpeg',1,'2025-02-06 17:42:53',NULL),(32,1,5,'salut',NULL,1,'2025-02-07 11:38:48',NULL),(33,1,2,'ahh sa7bi',NULL,1,'2025-02-10 11:23:23',NULL),(34,1,4,'chbik w5ayti ta7gri',NULL,0,'2025-02-10 11:23:40',NULL),(35,1,4,'salut',NULL,0,'2025-02-10 13:32:35',NULL),(36,1,2,'dqsdqs',NULL,1,'2025-02-10 13:57:12',NULL),(37,2,1,'wa chbi 3zek',NULL,1,'2025-02-10 13:57:36',NULL),(38,2,1,'singab 3lik','1739195944_singab.jpeg',1,'2025-02-10 13:59:04',NULL),(39,2,3,'chouf singab hadha','1739195987_singab.jpeg',0,'2025-02-10 13:59:47',NULL),(40,2,4,'7out 3lik','1739196154_poisson.jpeg',0,'2025-02-10 14:02:34',NULL),(41,1,2,'singab','1739265558_singab.jpeg',1,'2025-02-11 09:19:18',NULL),(42,1,2,'tree','1739266034_tree.jpeg',1,'2025-02-11 09:27:14',NULL),(43,1,2,'dqsdq',NULL,1,'2025-02-11 09:28:19',NULL),(44,1,2,'singab baba','1739266359_singab.jpeg',1,'2025-02-11 09:32:39',NULL),(45,1,2,'7out','1739275443_poisson.jpeg',1,'2025-02-11 12:04:03',NULL),(46,7,6,'aa zabourou',NULL,0,'2025-02-11 12:52:52',NULL),(47,7,6,'na3mlou chayy',NULL,0,'2025-02-11 12:53:03',NULL),(48,6,7,'yezzi e7chem ma9al 7yek',NULL,0,'2025-02-11 12:54:11',NULL),(49,6,7,'chiib wel 3ib',NULL,0,'2025-02-11 12:54:19',NULL),(50,10,12,'coucou chérie',NULL,1,'2025-02-11 13:23:56',NULL),(51,10,12,'❤️ habibi',NULL,1,'2025-02-11 13:25:37',NULL),(52,10,12,'mala zid 3lik yhebbel o5ti ❤️ ❤️❤️❤️❤️❤️❤️',NULL,1,'2025-02-11 13:30:43',NULL),(53,12,10,'👍',NULL,0,'2025-02-11 13:37:35',NULL),(54,12,10,'je nblokik rahou kan mezelt tsayeb rkaktek 😂',NULL,0,'2025-02-11 13:38:00',NULL),(55,12,10,'😂😂😂😂',NULL,0,'2025-02-11 13:38:07',NULL),(56,7,6,'🍕 hay pizza 3al faza',NULL,0,'2025-02-11 13:56:14',NULL),(57,5,12,'coucou 🎉',NULL,1,'2025-02-11 13:58:43',NULL),(58,7,5,'hello😂😂',NULL,1,'2025-02-11 13:59:17',NULL),(59,1,4,'🥰🤔🤔🤔',NULL,0,'2025-02-11 14:02:44',NULL),(60,1,4,'🥰',NULL,0,'2025-02-11 14:03:01',NULL),(61,1,4,'🎶🎶 musqiqua habibi',NULL,0,'2025-02-11 14:03:41',NULL),(62,4,1,'💖💖💖💖',NULL,1,'2025-02-11 14:04:15',NULL),(63,4,3,'😄💪🥳🎶❤️❤️❤️❤️',NULL,0,'2025-02-11 14:13:45',NULL),(64,1,2,'😍👍👍👍',NULL,1,'2025-02-11 14:15:07',NULL),(65,10,8,'hello ❤️❤️❤️',NULL,1,'2025-02-11 14:16:39',NULL),(66,4,2,'😂😂😂😂😂',NULL,1,'2025-02-11 14:33:00',NULL),(67,12,7,'ahla monjiya',NULL,0,'2025-02-11 15:09:28',NULL),(68,8,11,'ahla sami 😊😊',NULL,1,'2025-02-11 15:19:37',NULL),(69,11,5,'ahla zaid',NULL,1,'2025-02-11 15:24:19',NULL),(70,5,1,'❤️❤️❤️❤️',NULL,1,'2025-02-11 17:47:03',NULL),(71,5,9,'n7ebbek ya chirazzzz ❤️❤️❤️❤️❤️',NULL,0,'2025-02-11 17:47:25',NULL),(72,5,7,'ti bara rou7',NULL,0,'2025-02-11 17:47:43',NULL),(73,5,7,'tal9a 5ir',NULL,0,'2025-02-11 17:47:51',NULL),(74,3,14,'coucou ma belle ❤️❤️❤️❤️',NULL,0,'2025-02-16 22:30:14',NULL),(75,1,11,'coucou',NULL,1,'2025-02-17 08:16:40',NULL),(76,11,12,'coucou je suis sami',NULL,1,'2025-02-17 08:23:55',NULL),(77,16,5,'coucou',NULL,1,'2025-02-17 08:34:07',NULL),(78,2,8,'🥺🥺 hi siwar',NULL,1,'2025-02-17 14:44:50',NULL),(79,2,8,'can i talk with you please',NULL,1,'2025-02-17 14:45:02',NULL),(80,2,8,'3id 7ot mabrouk sa3a','1739803554_love.jpeg',1,'2025-02-17 14:45:54',NULL),(81,8,2,'<script>alert(\'Malicious code!\');</script>',NULL,1,'2025-02-17 15:05:11',NULL),(82,1,4,'coucou 😂❤️❤️',NULL,0,'2025-02-21 16:07:21',NULL),(83,2,5,'hello zaid\r\n 😂😂😂😂',NULL,0,'2025-02-24 16:39:42',NULL),(84,1,11,'salut',NULL,0,'2025-02-25 15:27:33',NULL),(85,1,5,'thanks',NULL,0,'2025-02-25 15:27:47',NULL),(86,4,1,'ya beznes wahf yrodik',NULL,0,'2025-02-25 15:28:51',NULL),(87,4,1,'contrainte','1740497762_Afaire.png',0,'2025-02-25 15:36:02',NULL),(88,4,1,'voice',NULL,0,'2025-02-25 15:36:16',NULL),(89,4,1,'voice bb',NULL,0,'2025-02-25 15:39:34',NULL),(90,2,4,'Chenhi lomour',NULL,0,'2025-02-26 11:27:23',NULL),(91,1,2,'labes 5ouya tab3athli fi emojis hadhi kol',NULL,0,'2025-04-01 20:46:32',NULL),(92,2,1,'ti enti ba3ethhomli ya5i mahboul',NULL,0,'2025-04-01 20:47:01',NULL);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (2,2,'ahla saif','2025-02-04 17:09:09',NULL,NULL),(7,2,'asma3ni saif 9adech 3omrek eni 3omri 25','2025-02-04 17:33:17',NULL,NULL),(8,2,'jaweb sa7bi','2025-02-04 17:33:25',NULL,NULL),(9,2,'chbik 7aggar','2025-02-04 17:33:34',NULL,NULL),(10,1,'3omri 25 kifek','2025-02-04 17:33:56',NULL,NULL),(13,3,'Wash daniw','2025-02-04 17:36:24',NULL,NULL),(15,5,'ani khoukom sghir','2025-02-04 17:43:59',NULL,NULL),(16,5,'n7ebkom barcha','2025-02-04 17:44:50',NULL,NULL),(17,4,'Im here guys','2025-02-05 12:12:49',NULL,NULL),(18,3,'im sofienne','2025-02-06 12:16:25',NULL,NULL),(19,3,'my new post','2025-02-06 14:14:50','1738851290_post.jpg',NULL),(20,3,'my new post','2025-02-06 14:17:00','1738851420_post.jpg',NULL),(21,3,'houhou','2025-02-06 14:19:04','1738851544_na3na3.jpeg',NULL),(22,3,'video kase7','2025-02-06 14:24:13',NULL,NULL),(23,3,'njnb','2025-02-06 14:25:31','1738851931_Photo.jpg',NULL),(24,3,'Fourmis','2025-02-06 14:27:27','1738852047_shutterstock-81020101.jpg',NULL),(25,4,'Chica','2025-02-06 14:29:17','1738852157_chika.jpeg',NULL),(26,4,'na3na3','2025-02-06 14:32:33',NULL,NULL),(27,4,'na3na3','2025-02-06 14:33:01','1738852381_na3na3.jpeg',NULL),(28,1,'tree louled','2025-02-06 15:32:08','1738855928_tree.jpeg',NULL),(29,1,'ward chabeb','2025-02-06 15:50:48','1738857048_flowers.jpeg',NULL),(30,1,'Ch3amla fikom s5ana','2025-02-06 15:51:11',NULL,NULL),(31,1,'ramadhan jana w fri7na bouh ba3d 8yabou ahlan ramadhan','2025-02-06 15:54:00','1738857240_ramadhan.jpg',NULL),(32,5,'tree','2025-02-06 17:32:52',NULL,NULL),(33,5,'tree','2025-02-06 17:34:07','1738863247_tree.jpeg',NULL),(34,5,'singab louled','2025-02-06 17:35:10','1738863310_singab.jpeg',NULL),(35,1,'xnxn','2025-02-07 12:35:11','',NULL),(36,1,'tree','2025-02-07 12:42:22','tree.jpeg',NULL),(37,1,'post flowers','2025-02-10 13:18:25','flowers.jpeg',NULL),(38,1,'ramdhan','2025-02-10 13:23:10','ramadhan.jpg',NULL),(39,1,'ramdhan','2025-02-10 13:23:10','ramadhan.jpg',NULL),(40,1,'singab hahi','2025-02-10 13:30:31','singab.jpeg',NULL),(41,1,'singab hahi','2025-02-10 13:30:31','singab.jpeg',NULL),(42,1,'ramdhan louled','2025-02-10 13:52:46','ramadhan.jpg',NULL),(43,1,'bjhb','2025-02-10 19:38:29','CV.jpg','SampleVideo_720x480_2mb.mp4'),(44,1,'video','2025-02-10 19:40:21','','SampleVideo_720x480_2mb.mp4'),(45,1,'sample','2025-02-10 19:41:37','','SampleVideo_720x480_2mb.mp4'),(46,1,'singab','2025-02-10 19:42:26','singab.jpeg',''),(47,1,'sample','2025-02-10 19:53:18','','SampleVideo_720x480_2mb.mp4'),(48,1,'mo','2025-02-10 19:54:10','','SampleVideo_720x480_2mb.mp4'),(49,1,'wez','2025-02-10 19:58:41','','SampleVideo_720x480_2mb.mp4'),(50,1,'posttest','2025-02-10 20:02:53','','SampleVideo_720x480_2mb.mp4'),(51,1,'wxcvcx','2025-02-10 20:19:29','',''),(52,1,'wxcwxv','2025-02-10 20:19:46','ramadhan.jpg',''),(53,1,'wxcvwxwx','2025-02-10 20:19:56','','SampleVideo_720x480_2mb.mp4'),(54,1,'x<c<','2025-02-10 20:21:01','','SampleVideo_720x480_2mb.mp4'),(55,1,'wxcwx','2025-02-10 20:21:24','','SampleVideo_720x480_2mb.mp4'),(56,1,'xaqswccwxcv','2025-02-10 20:22:57','',''),(57,1,'haaaaaaaaaaaaaaaa','2025-02-10 20:27:15','','1739219235_e5f79b5290.mp4'),(58,1,'chaambre','2025-02-10 20:31:07','','1739219467_2f76def6fa.mp4'),(59,1,'rire','2025-02-10 20:48:18','','1739220498_a00763be97.mp4'),(60,1,'karim','2025-02-10 20:53:19','','1739220799_8999daa40d.mp4'),(61,2,'klay louledd','2025-02-10 20:54:56','','1739220896_d255bf9058.mp4'),(62,5,'dar','2025-02-10 21:09:22','','1739221762_a66cd28158.mp4'),(63,1,',n,n','2025-02-10 21:25:17','','1739222717_778ef3cf05.mp4'),(64,1,'wardd','2025-02-11 08:11:41','1739261501_47d18bdb91.jpeg',''),(65,1,'klayy','2025-02-11 08:12:08','','1739261528_634e4ddff4.mp4'),(66,1,'binzerte','2025-02-11 08:14:31','1739261671_8ebea7ca44.jpg',''),(67,1,'klay w singab','2025-02-11 09:41:50','1739266910_4604057b3c.jpeg','1739266910_40e15d1da3.mp4'),(68,1,'romdhan w karim','2025-02-11 09:43:02','1739266982_5412bdc65e.jpg','1739266982_fdbe93a770.mp4'),(69,1,'Choufou mazynha stan fi nancy','2025-02-11 11:12:38','1739272358_24b5ba8d16.jpg','1739272358_2e845706b7.mp4'),(70,4,'Good morning as7bi bejemla wel 7amla','2025-02-11 12:36:55','1739277415_88af70027a.jpg',''),(71,7,'ya hasra 3la ayam zman','2025-02-11 12:49:32','1739278172_1f72fb7375.jpg',''),(72,5,'karim gharbi chabeb ma9tla dho7k','2025-02-11 13:06:07','','1739279167_2ef310431d.mp4'),(73,8,'salut eni jdida fil plateform hadha so coucou tout le monde','2025-02-11 13:17:43','',''),(74,12,'coucou chabeb','2025-02-11 13:22:47','',''),(75,10,'karim bob','2025-02-11 14:16:57','','1739283417_2629f95830.mp4'),(76,10,'ramdhan 9rob chebeb','2025-02-11 14:17:21','1739283441_881882a229.jpg',''),(77,4,'Rien de nouveau','2025-02-11 14:41:20','',''),(78,12,'C\'est beau le nouveau style','2025-02-11 14:49:10','',''),(79,11,'Salut. Je suis nouveau ici','2025-02-11 15:21:49','',''),(80,3,'ramadhan','2025-02-11 15:24:53','1739287493_f88bbf5b6c.jpg','1739287493_8d1492bb9a.mp4'),(81,16,'Coucou','2025-02-11 16:46:14','',''),(82,17,'coucou','2025-02-11 17:17:41','',''),(83,4,'Jenjoun t3ada fi mousaique fm','2025-02-11 17:44:08','1739295848_1bb5479d34.jpeg',''),(84,1,'kevinderin louled','2025-02-15 10:11:32','1739614292_5395947aa5.jpg',''),(85,6,'m3a touriste fi soussa el mezyana','2025-02-16 22:12:17','','1739743937_2e58f995c6.mp4'),(86,14,'Our story in 1 Minute','2025-02-16 22:29:07','','1739744947_d7ebfd69aa.mp4'),(87,1,'<script>alert(\"salut\");</script>','2025-02-16 22:31:33','',''),(88,5,'Good morning shabeb','2025-02-17 10:14:20','1739787260_6fd99e837a.png',''),(89,1,'good morning','2025-02-17 11:46:40','1739792800_964fa022e1.png',''),(90,1,'Dr willy hhh','2025-02-21 15:44:25','1740152665_2fa62edea5.jpg',''),(91,1,'Coucou','2025-02-26 11:24:58','',''),(92,2,'Aah chabeb serveur ytire','2025-02-26 11:27:46','',''),(93,2,'Coucou les enfantd','2025-02-26 11:40:54','','');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_image` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text,
  `birth_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'saif','saif@saif.saif','$2y$10$MJXdPxI/3AHrWz2.cT2XVOj2UzjUSs5H8grxXpIKOLRHvXdvqW8LS','2025-02-04 16:59:45','Saif.jpg','saif','elamri','98756521',NULL,'1999-10-02'),(2,'youssef','youssef@youssef.youssef','$2y$10$svXY61LQC7Uao4RZB/U5OuDGHChyogbVbalByuL/CU31VIIMzuM4C','2025-02-04 17:01:23','youssef.jpeg','youssef','elamri','987554451',NULL,'1997-07-02'),(3,'sofienne','sofienne@sofienne.sofienne','$2y$10$KZkrZVIeqlwTgz99L9LUtee1aTNtX4AeMavarOPVT4hbzFls/GYIm','2025-02-04 17:35:35','sofienne.jpeg','Sofienne','chawati','252562987',NULL,'1997-01-01'),(4,'ahlem','ahlem@ahlem.ahlem','$2y$10$8.MYoBjOnyv2KDsQEfr9J.bfy2ssCt3LgE5o.MMhdo3GhDrbxeWVi','2025-02-04 17:37:33','ahlem.jpg','Ahlem','guiga','55654987',NULL,'1980-05-02'),(5,'zaid','zaid@zaid.zaid','$2y$10$UTFTLu74HqIwNBSjBeGj/e74b2c1GKhr9gMDyQagscXAUAL9ojWaS','2025-02-04 17:40:14','zaid.jpg','zaid','garca','92321109',NULL,'1987-08-05'),(6,'monji','monji@monji.monji','$2y$10$PCuGaUbUJ31fnkxkVXpXOO1bwjY81xQJKeGYB6lMceKY0D6QXp1ce','2025-02-11 09:50:09','monji.jpeg',NULL,NULL,NULL,NULL,NULL),(7,'monjiya','monjiya@monjiya.monjiya','$2y$10$yN1wulKJtYsU6wMgDoUrZ.LFflKC3Nrbt.A9DZp2A9JkdaCXo4GGy','2025-02-11 12:46:52','monjiya.jpg',NULL,NULL,NULL,NULL,NULL),(8,'siwar','siwar@siwar.siwar','$2y$10$uBYl1gXPqoy89yX0aE9ome7VXXx9a2d63rGmPoWvnme7tPBGFqXtO','2025-02-11 13:12:59','siwar.jpeg',NULL,NULL,NULL,NULL,NULL),(9,'chiraz','chiraz@chiraz.chiraz','$2y$10$WI4Du0VENM30RVKobhUcIOgTjsnTbJ6u3kIR/QxBi93xGoTif9oRe','2025-02-11 13:18:19','Chiraz.jpg',NULL,NULL,NULL,NULL,NULL),(10,'imed','imed@imed.imed','$2y$10$DhsO8jZSgGMuPfyCg1cRiOHr/YqaQ9C3fGOhw0hru7OfNrBxUewAe','2025-02-11 13:20:38','imed.jpeg','Imed','Trabelsi','26654987',NULL,'1995-05-01'),(11,'Sami','Sami@sami.sami','$2y$10$8oG9wlR0GGJzgCew3vvFPOaKggxlkSj8bTOOBQ862LDB674BxLDqC','2025-02-11 13:21:18','Sami.jpeg','Sami','Nasri','9210210931',NULL,'1998-08-03'),(12,'Mouna','mouna@mouna.mouna','$2y$10$6ok9SBagYcE4kJZ2qNtRke0D45Xm6bPir8Z71sx.Rcp2VG50OM37C','2025-02-11 13:22:04','Mouna.jpeg','Mouna','khdiri','9210210931',NULL,'1997-06-07'),(13,'Foued','foued@foued.foued','$2y$10$5QbjXK8EWkFDTlWlryadruWvu0lpvzx5s6vdc3ZThQ7WYu4bXa8ju','2025-02-11 16:42:59','Foued.jpg',NULL,NULL,NULL,NULL,NULL),(14,'Amelie','amelie@amelie.amelie','$2y$10$sG6pTTWpDbLgJiAAS4yp5OsE9IBDTILnzUuE2BlKvy3Unlm.X13qG','2025-02-11 16:43:58','amelie.jpg',NULL,NULL,NULL,NULL,NULL),(15,'Layla','layla@layla.layla','$2y$10$KFTL60UlrZklCguob/ZYwOHteigfqdPine5QWLR3DHl5nKohbNyqO','2025-02-11 16:44:55',NULL,NULL,NULL,NULL,NULL,NULL),(16,'salma','salma@salma.salma','$2y$10$ddDpeF0osY1bDrTcZSwcWOPCtj3Rc/U7BqFo50iMWy/slf8ytYxXC','2025-02-11 16:45:37','salma.jpg','Salma','Bourawi','23559875',NULL,'1999-10-02'),(17,'rouwaida','rouwaida@rouwaida.rouwaida','$2y$10$RVpU2AvmMpnF6WrinjIPseqqljwxriAbI9Oy552lpEjyS5HVq9eFO','2025-02-11 16:48:49','rouwaida.jpeg','rouwaida','kacem','9010210931',NULL,'1980-01-02'),(18,'nadi','nadi@nadi.nadi','$2y$10$AK2MIEXEkkEwPBI8IZcqpeXT4KOX9Qr3TQKJ75H.3hE3ZRACr0xga','2025-02-16 22:57:24',NULL,NULL,NULL,NULL,NULL,NULL);
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

-- Dump completed on 2025-04-11 17:07:53
