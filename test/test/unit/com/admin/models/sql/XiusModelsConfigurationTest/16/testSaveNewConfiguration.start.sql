TRUNCATE TABLE `#__xius_config`;;

DROP TABLE IF EXISTS `au_#__xius_config`;;
CREATE TABLE `au_#__xius_config` SELECT * FROM `#__xius_config`;;
INSERT INTO `au_#__xius_config` (`name`, `params`) VALUES
('', 'xiusCronJob=0'),
('config', 'xiusUserLimit=3500\nxiusKey="AB2F4"\nxiusDebugMode=1'),
('cache', 'cacheStartTime=1274243647\ncacheEndTime=1274243648');;
