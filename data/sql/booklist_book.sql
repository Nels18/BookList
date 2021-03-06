CREATE DATABASE  IF NOT EXISTS `booklist` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `booklist`;
-- MySQL dump 10.13  Distrib 8.0.26, for macos11 (x86_64)
--
-- Host: localhost    Database: booklist
-- ------------------------------------------------------
-- Server version	8.0.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int NOT NULL,
  `category_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `published_at` date NOT NULL,
  `summary` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_book_author` (`author_id`),
  KEY `fk_book_category` (`category_id`),
  CONSTRAINT `fk_book_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
  CONSTRAINT `fk_book_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (1,1,1,'Les Entretiens de Confucius','2020-11-29','Devenu quelques si??cles apr??s sa mort, et durant deux mill??naires, le saint patron des lettr??s, Confucius (551-479 av. J.-C.) est universellement consid??r?? comme l\'une des plus ??minentes figures de la Chine dont il est d??sormais l\'ic??ne culturelle. Si sa vie est m??connue, il nous reste un t??moignage de premi??re importance quant ?? son activit?? de p??dagogue, qui offre un portrait ?? la fois moral, intellectuel et affectif de l\'homme : ces Entretiens, compilation des notes prises du vivant du Ma??tre par chacun des disciples et r??unies apr??s sa mort.','2022-05-30 18:58:41',NULL,NULL),(2,2,2,'150 recettes de sauces','2000-01-01','Vous d??couvrirez que r??aliser une bonne sauce n\'est pas forc??ment synonyme de difficult??. De plus, une bonne sauce nappant un plat tout simple peut en faire une d??licatesse ! De nombreux conseils pour que fonds, jus ou bouillons, bases, liaisons, ?? chaud ou ?? froid, n\'aient plus de secret pour vous.','2022-05-30 18:58:41',NULL,NULL),(3,3,3,'Alex','2012-05-02','Qui conna??t vraiment Alex ? Elle est belle. Excitante. Est-ce pour cela qu\'on l\'a enlev??e, s??questr??e et livr??e ?? l\'inimaginable ? Mais quand le commissaire Verhoeven d??couvre enfin sa prison, Alex a disparu. Alex, plus intelligente que son bourreau. Alex qui ne pardonne rien, qui n\'oublie rien, ni personne. Un thriller gla??ant qui jongle avec les codes de la folie meurtri??re, une m??canique diabolique et impr??visible o?? l\'on retrouve le talent de l\'auteur de Robe de mari??.','2022-05-30 18:58:41',NULL,NULL),(4,4,3,'Th??rapie','2009-11-04','Josy, douze ans, la fille du c??l??bre psychiatre berlinois Viktor Larenz, est atteinte d???une maladie qu???aucun m??decin ne parvient ?? diagnostiquer. Un jour, apr??s que son p??re l???a accompagn??e chez l???un de ses confr??res, elle dispara??t. Quatre ans ont pass??. Larenz est toujours sans nouvelles de sa fille quand une inconnue frappe ?? sa porte. Anna Spiegel, romanci??re, pr??tend souffrir d???une forme rare de schizophr??nie : les personnages de ses r??cits prennent vie sous ses yeux. Or, le dernier roman d???Anna a pour h??ro??ne une fillette qui souffre d???un mal ??trange et qui s?????vanouit sans laisser de traces... Le psychiatre n???a d??s lors plus qu???un seul but, obsessionnel : conna??tre la suite de son histoire.');
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-02 15:48:33
