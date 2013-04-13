TRUNCATE TABLE `#__community_groups`;;

INSERT INTO `#__community_groups` SELECT * FROM `bk_#__community_groups`;;

DROP TABLE IF EXISTS `bk_#__community_groups`;;

