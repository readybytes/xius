TRUNCATE TABLE `#__menu`;;
INSERT INTO `#__menu` SELECT * FROM `bk_#__menu`;;
DROP TABLE IF EXISTS `bk_#__menu`;;
