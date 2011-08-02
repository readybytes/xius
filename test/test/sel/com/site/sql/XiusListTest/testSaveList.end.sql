TRUNCATE TABLE `#__modules`;;
INSERT INTO `#__modules` SELECT * FROM `bk_#__modules`;;
DROP TABLE IF EXISTS `bk_#__modules`;;
