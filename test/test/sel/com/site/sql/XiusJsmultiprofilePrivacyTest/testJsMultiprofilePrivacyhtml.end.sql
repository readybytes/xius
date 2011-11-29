TRUNCATE TABLE `#__plugins`;;
DROP TABLE IF EXISTS `au_#__plugins`;;
INSERT INTO `#__plugins` SELECT * FROM `bk_#__plugins`;;
DROP TABLE IF EXISTS  `bk_#__plugins`;;

TRUNCATE TABLE `#__community_config`;;
DROP TABLE IF EXISTS `au_#__community_config`;;
INSERT INTO `#__community_config` SELECT * FROM `bk_#__community_config`;;
DROP TABLE IF EXISTS  `bk_#__community_config`;;
