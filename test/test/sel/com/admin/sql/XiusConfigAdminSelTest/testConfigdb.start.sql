/* XIUS CONFIGURATION */

TRUNCATE TABLE `#__xius_config`;;

DROP TABLE IF EXISTS `au_#__xius_config`;;
CREATE TABLE `au_#__xius_config` SELECT * FROM `#__xius_config`;;

INSERT INTO `#__xius_config` (`name`, `params`) VALUES
('cache', 'cacheStartTime=1282050943\ncacheEndTime=1282050944\n\n'),
('config','xiusKey=AB2F4\nxiusDebugMode=0\nshowSearchMenuTab=0\nxiusReplaceSearch=0\nxiusSlideShow=none\nxiusProximityDefaultLat=28.635308\nxiusProximityDefaultLong=77.22496\nxiusListCreator=a:1:{i:0;s:19:"Super Administrator";}\n\n');;


INSERT INTO `au_#__xius_config` (`name`, `params`) VALUES
('cache', 'cacheStartTime=1282050943\ncacheEndTime=1282050944\n\n'),
('config', 'xiusTemplates=default\nintegrateJomSocial=1\nxiusKey=SSV445\nxiusDebugMode=1\nxiusListCreator=a:1:{i:0;s:19:"Super Administrator";}\nxiusReplaceSearch=1\nxiusSlideShow=none\nxiusLoadJquery=0\nxiusEnableMatch=1\nxiusDefaultMatch=OR\n\n');;

