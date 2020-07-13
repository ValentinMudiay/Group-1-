
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
DROP TABLE IF EXISTS `wpcp_usermeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpcp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `wpcp_usermeta` WRITE;
/*!40000 ALTER TABLE `wpcp_usermeta` DISABLE KEYS */;
INSERT INTO `wpcp_usermeta` VALUES (1,1,'nickname','layne'),(2,1,'first_name',''),(3,1,'last_name',''),(4,1,'description',''),(5,1,'rich_editing','true'),(6,1,'syntax_highlighting','true'),(7,1,'comment_shortcuts','false'),(8,1,'admin_color','fresh'),(9,1,'use_ssl','0'),(10,1,'show_admin_bar_front','true'),(11,1,'locale',''),(12,1,'wpcp_capabilities','a:1:{s:13:\"administrator\";b:1;}'),(13,1,'wpcp_user_level','10'),(14,1,'dismissed_wp_pointers',''),(15,1,'show_welcome_panel','1'),(16,1,'session_tokens','a:5:{s:64:\"1eced219db61f636506654ec126ad84615ee37f5dcc171e99e69ef5eb042c9e1\";a:4:{s:10:\"expiration\";i:1594733282;s:2:\"ip\";s:13:\"69.138.67.177\";s:2:\"ua\";s:78:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0\";s:5:\"login\";i:1594560482;}s:64:\"be729d070dfbd2a9c1878b88ebf3ac1b67ce0eadc167b5b6cf9f3b3054ee873c\";a:4:{s:10:\"expiration\";i:1594736363;s:2:\"ip\";s:13:\"69.138.67.177\";s:2:\"ua\";s:78:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0\";s:5:\"login\";i:1594563563;}s:64:\"3587f5d7dea426c8baf49f3b13dc717121d174227a409869c2a316e31dda180c\";a:4:{s:10:\"expiration\";i:1594749178;s:2:\"ip\";s:13:\"69.138.67.177\";s:2:\"ua\";s:78:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0\";s:5:\"login\";i:1594576378;}s:64:\"6dd7d8ade85ad6525922162d5b5b8768bcd3e908b6675691fc2f1a1c2b35cd7a\";a:4:{s:10:\"expiration\";i:1594818987;s:2:\"ip\";s:13:\"69.138.67.177\";s:2:\"ua\";s:78:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0\";s:5:\"login\";i:1594646187;}s:64:\"ff9e9cbdcb2f11a4b7e44cf5165c1d1617b9831f4ef6e5be417e99b8a4c198ec\";a:4:{s:10:\"expiration\";i:1594825123;s:2:\"ip\";s:13:\"69.138.67.177\";s:2:\"ua\";s:78:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0\";s:5:\"login\";i:1594652323;}}'),(17,1,'wpcp_user-settings','libraryContent=browse&mfold=o'),(18,1,'wpcp_user-settings-time','1594560477'),(19,1,'wpcp_dashboard_quick_press_last_post_id','4'),(20,1,'community-events-location','a:1:{s:2:\"ip\";s:11:\"69.138.67.0\";}'),(21,2,'nickname','valentin'),(22,2,'first_name','valentin'),(23,2,'last_name','mudiay'),(24,2,'description',''),(25,2,'rich_editing','true'),(26,2,'syntax_highlighting','true'),(27,2,'comment_shortcuts','false'),(28,2,'admin_color','fresh'),(29,2,'use_ssl','0'),(30,2,'show_admin_bar_front','true'),(31,2,'locale',''),(32,2,'wpcp_capabilities','a:1:{s:13:\"administrator\";b:1;}'),(33,2,'wpcp_user_level','10'),(34,2,'dismissed_wp_pointers',''),(35,2,'session_tokens','a:2:{s:64:\"5fb56432e6233bd075e4d2947b3c0592e574f7284024aaf40215aaef44bc1d07\";a:4:{s:10:\"expiration\";i:1594749579;s:2:\"ip\";s:12:\"73.39.63.183\";s:2:\"ua\";s:115:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36\";s:5:\"login\";i:1594576779;}s:64:\"f002c3a27d52ac3cb71f7c727e71b01f223a4bffb88e2bf782861118c94f4764\";a:4:{s:10:\"expiration\";i:1594827866;s:2:\"ip\";s:12:\"73.39.63.183\";s:2:\"ua\";s:115:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36\";s:5:\"login\";i:1594655066;}}'),(36,2,'wpcp_dashboard_quick_press_last_post_id','6'),(37,2,'community-events-location','a:1:{s:2:\"ip\";s:10:\"73.39.63.0\";}'),(38,2,'closedpostboxes_dashboard','a:0:{}'),(39,2,'metaboxhidden_dashboard','a:0:{}'),(40,3,'nickname','austin'),(41,3,'first_name','austin'),(42,3,'last_name','ryan'),(43,3,'description',''),(44,3,'rich_editing','true'),(45,3,'syntax_highlighting','true'),(46,3,'comment_shortcuts','false'),(47,3,'admin_color','fresh'),(48,3,'use_ssl','0'),(49,3,'show_admin_bar_front','true'),(50,3,'locale',''),(51,3,'wpcp_capabilities','a:1:{s:13:\"administrator\";b:1;}'),(52,3,'wpcp_user_level','10'),(53,3,'dismissed_wp_pointers',''),(54,4,'nickname','abel'),(55,4,'first_name',''),(56,4,'last_name',''),(57,4,'description',''),(58,4,'rich_editing','true'),(59,4,'syntax_highlighting','true'),(60,4,'comment_shortcuts','false'),(61,4,'admin_color','fresh'),(62,4,'use_ssl','0'),(63,4,'show_admin_bar_front','true'),(64,4,'locale',''),(65,4,'wpcp_capabilities','a:1:{s:6:\"editor\";b:1;}'),(66,4,'wpcp_user_level','7'),(67,4,'dismissed_wp_pointers',''),(68,3,'session_tokens','a:1:{s:64:\"3b9d37b6a4f5dca406ba6947f8544d5cb60000539c99fbd8bd19496b00b18367\";a:4:{s:10:\"expiration\";i:1594828001;s:2:\"ip\";s:13:\"69.250.28.122\";s:2:\"ua\";s:117:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1 Safari/605.1.15\";s:5:\"login\";i:1594655201;}}'),(69,3,'wpcp_user-settings','mfold=o&libraryContent=browse'),(70,3,'wpcp_user-settings-time','1594655197'),(71,4,'session_tokens','a:1:{s:64:\"67a474dbe7ec31236f0f85c8b254d47ef3d58026dd4bfbe00425f9628e59399d\";a:4:{s:10:\"expiration\";i:1594828074;s:2:\"ip\";s:12:\"69.251.34.61\";s:2:\"ua\";s:78:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0\";s:5:\"login\";i:1594655274;}}');
/*!40000 ALTER TABLE `wpcp_usermeta` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

