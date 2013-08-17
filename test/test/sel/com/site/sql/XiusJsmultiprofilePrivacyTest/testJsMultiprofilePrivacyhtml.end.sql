TRUNCATE TABLE `#__community_config`;;
DROP TABLE IF EXISTS `au_#__community_config`;;
INSERT INTO `#__community_config` SELECT * FROM `bk_#__community_config`;;
DROP TABLE IF EXISTS  `bk_#__community_config`;;
