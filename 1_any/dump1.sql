-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.5.11-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Дамп структуры для таблица kfi.admins
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(66) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы kfi.admins: ~2 rows (приблизительно)
INSERT INTO `admins` (`id`, `login`, `password`) VALUES
	(1, 'pashok', 'a95bc16631ae2b6fadb455ee018da0adc2703e56d89e3eed074ce56d2f7b1b6a'),
	(2, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918');

-- Дамп структуры для таблица kfi.catalog
CREATE TABLE IF NOT EXISTS `catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_self_id` (`parent`),
  CONSTRAINT `FK_self_id` FOREIGN KEY (`parent`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы kfi.catalog: ~7 rows (приблизительно)
INSERT INTO `catalog` (`id`, `parent`, `name`, `description`) VALUES
	(13, NULL, '345345', 'оапопрлапр'),
	(14, NULL, '111', 'артордж'),
	(15, 14, '333333', 'ккккк'),
	(16, 19, '6666', 'смсмм'),
	(17, 13, '23423423', 'ьапрлрдол'),
	(19, NULL, '123131823', 'раопрнлпгршдролж66'),
	(21, 19, '456761', 'bmhj,k,');

-- Дамп структуры для триггер kfi.trigger1
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER kfi.trigger1
	BEFORE INSERT
	ON catalog
	FOR EACH ROW
BEGIN
IF NEW.id = NEW.parent THEN
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Column parent equals to id' ;
END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Дамп структуры для триггер kfi.trigger2
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER kfi.trigger2
	BEFORE UPDATE
	ON kfi.catalog
	FOR EACH ROW
BEGIN
IF NEW.id = NEW.parent THEN
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Column parent equals to id' ;
END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
