
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
DROP TABLE IF EXISTS `wpcp_revisr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpcp_revisr` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `message` text COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `event` varchar(42) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `user` varchar(60) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `wpcp_revisr` WRITE;
/*!40000 ALTER TABLE `wpcp_revisr` DISABLE KEYS */;
INSERT INTO `wpcp_revisr` VALUES (1,'2020-07-12 13:33:21','Error pushing changes to the remote repository.','error','layne'),(2,'2020-07-12 13:35:16','There was an error committing the changes to the local repository.','error','layne'),(3,'2020-07-12 13:35:30','Committed <a href=\"https://nationalparkg1.me/wp-admin/admin.php?page=revisr_view_commit&commit=5017aa5&success=true\">#5017aa5</a> to the local repository.','commit','layne'),(4,'2020-07-12 13:35:31','Error pushing changes to the remote repository.','error','layne'),(5,'2020-07-12 13:36:02','Checked out branch: master.','branch','layne'),(6,'2020-07-12 13:45:40','Successfully pushed 15 commits to origin/master.','push','layne'),(7,'2020-07-12 13:48:19','Committed <a href=\"https://nationalparkg1.me/wp-admin/admin.php?page=revisr_view_commit&commit=730ba03&success=true\">#730ba03</a> to the local repository.','commit','layne'),(8,'2020-07-12 13:48:23','Successfully pushed 1 commit to origin/master.','push','layne'),(9,'2020-07-12 14:24:20','Committed <a href=\"https://nationalparkg1.me/wp-admin/admin.php?page=revisr_view_commit&commit=930fe39&success=true\">#930fe39</a> to the local repository.','commit','layne'),(10,'2020-07-12 14:24:25','Successfully pushed 1 commit to origin/master.','push','layne'),(11,'2020-07-12 17:53:41','Committed <a href=\"https://nationalparkg1.me/wp-admin/admin.php?page=revisr_view_commit&commit=0ad9cd6&success=true\">#0ad9cd6</a> to the local repository.','commit','layne'),(12,'2020-07-12 17:53:45','Successfully pushed 1 commit to origin/master.','push','layne'),(13,'2020-07-12 17:56:59','Successfully pushed 11 commits to origin/master.','push','layne'),(14,'2020-07-12 18:04:32','Successfully pushed 11 commits to origin/master.','push','layne'),(15,'2020-07-12 18:08:36','Error pushing changes to the remote repository.','error','layne'),(16,'2020-07-12 18:08:36','Reverted to commit <a href=\"https://nationalparkg1.me/wp-admin/admin.php?page=revisr_view_commit&commit=0ad9cd6\">#0ad9cd6</a>.','revert','layne'),(17,'2020-07-12 18:09:05','Error pushing changes to the remote repository.','error','layne'),(18,'2020-07-12 18:09:36','There was an error committing the changes to the local repository.','error','layne'),(19,'2020-07-12 18:09:50','Committed <a href=\"https://nationalparkg1.me/wp-admin/admin.php?page=revisr_view_commit&commit=5e5d98a&success=true\">#5e5d98a</a> to the local repository.','commit','layne'),(20,'2020-07-12 18:09:51','Error pushing changes to the remote repository.','error','layne'),(21,'2020-07-12 18:10:20','Error pushing changes to the remote repository.','error','layne'),(22,'2020-07-12 18:10:53','Merged branch origin/master into branch master.','merge','layne'),(23,'2020-07-12 18:11:07','Successfully pushed 3 commits to origin/master.','push','layne'),(24,'2020-07-12 18:11:27','Successfully pushed 0 commits to origin/master.','push','layne'),(25,'2020-07-12 18:11:27','Reverted to commit <a href=\"https://nationalparkg1.me/wp-admin/admin.php?page=revisr_view_commit&commit=0ad9cd6\">#0ad9cd6</a>.','revert','layne'),(26,'2020-07-12 18:15:34','Successfully backed up the database.','backup','layne'),(27,'2020-07-12 18:15:35','There was an error committing the changes to the local repository.','error','layne'),(28,'2020-07-12 18:15:43','Committed <a href=\"https://nationalparkg1.me/wp-admin/admin.php?page=revisr_view_commit&commit=905b0a0&success=true\">#905b0a0</a> to the local repository.','commit','layne'),(29,'2020-07-12 18:15:47','Successfully pushed 1 commit to origin/master.','push','layne'),(30,'2020-07-12 18:20:00','Successfully backed up the database.','backup','layne'),(31,'2020-07-12 18:20:00','Committed <a href=\"https://nationalparkg1.me/wp-admin/admin.php?page=revisr_view_commit&commit=ea69341&success=true\">#ea69341</a> to the local repository.','commit','layne'),(32,'2020-07-12 18:20:07','Successfully pushed 1 commit to origin/master.','push','layne'),(33,'2020-07-12 18:29:35','Committed <a href=\"https://nationalparkg1.me/wp-admin/admin.php?page=revisr_view_commit&commit=62a22a3&success=true\">#62a22a3</a> to the local repository.','commit','layne'),(34,'2020-07-12 18:29:39','Successfully pushed 1 commit to origin/master.','push','layne'),(35,'2020-07-12 18:33:09','Successfully backed up the database.','backup','layne'),(36,'2020-07-12 18:33:09','Committed <a href=\"https://nationalparkg1.me/wp-admin/admin.php?page=revisr_view_commit&commit=008094f&success=true\">#008094f</a> to the local repository.','commit','layne'),(37,'2020-07-12 18:33:13','Successfully pushed 1 commit to origin/master.','push','layne'),(38,'2020-07-12 18:33:35','Successfully backed up the database.','backup','layne'),(39,'2020-07-12 18:33:38','Successfully pushed 1 commit to origin/master.','push','layne'),(40,'2020-07-12 18:33:45','Successfully backed up the database.','backup','layne'),(41,'2020-07-12 18:33:49','Successfully pushed 1 commit to origin/master.','push','layne');
/*!40000 ALTER TABLE `wpcp_revisr` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

