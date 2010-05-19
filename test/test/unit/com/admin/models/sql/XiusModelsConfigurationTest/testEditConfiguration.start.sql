TRUNCATE TABLE `#__xius_config`;;

DROP TABLE IF EXISTS `au_#__xius_config`;;
CREATE TABLE `au_#__xius_config` SELECT * FROM `#__xius_config`;;
INSERT INTO `au_#__xius_config` (`name`, `params`) VALUES
('config', 'xiusUserLimit=1930\nxiusKey=AB2F4\nxiusDebugMode=0\n\n'),
('cache', 'cacheStartTime=1274243747\ncacheEndTime=1274243748\n\n');;

INSERT INTO `#__xius_config` (`name`, `params`) VALUES
('config', 'xiusUserLimit=3500\nxiusKey=AD3F4\nxiusDebugMode=1\n\n'),
('cache', 'cacheStartTime=1274243647\ncacheEndTime=1274243648\n\n');;
