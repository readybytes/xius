TRUNCATE TABLE `#__xius_info`;;
CREATE TABLE IF NOT EXISTS `au_#__xius_info` SELECT * FROM `#__xius_info`;;
TRUNCATE TABLE `au_#__xius_info`;;

INSERT INTO `au_#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(17, 'State', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '10', '', 'Jsfields', 1, 1),
(18, 'Country', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '12', '', 'Jsfields', 2, 1),
(19, 'City / Town', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '11', '', 'Jsfields', 3, 1),
(20, 'By Google API', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\nxipt_privacy=a:1:{i:0;s:1:"0";}\njs_privacy=public\n\n', 'google', 'xius_proximity_country=18\nxius_proximity_zipcode=\nxius_proximity_state=17\nxius_proximity_city=19\nxius_gmap_key=\nxius_default_location=none\nxiusProximityDefaultLat=28.635308\nxiusProximityDefaultLong=77.22496\nxiusDefaultDistance=10\nxiusDefaultDistanceUnit=miles\nxiusProximityGmapZoom=2\n\n', 'Proximity', 4, 1);;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(17, 'State', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '10', '', 'Jsfields', 1, 1),
(18, 'Country', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '12', '', 'Jsfields', 2, 1),
(19, 'City / Town', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '11', '', 'Jsfields', 3, 1);;

DROP TABLE IF EXISTS `#__xius_proximity_geocode`;;
DROP TABLE IF EXISTS `au_#__xius_proximity_geocode`;;

CREATE TABLE IF NOT EXISTS `au_#__xius_proximity_geocode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(250) NOT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;;

INSERT INTO `au_#__xius_proximity_geocode` (`id`, `address`, `latitude`, `longitude`, `valid`) VALUES
(1, 'Bhilwara,Rajasthan,India', 25.346251, 74.636383, 1),
(2, 'Ajmer,Rajasthan,India', 26.450001, 74.639999, 1),
(3, 'Surat,Gujrat,India', 21.195000, 72.819443, 1),
(4, 'Ludhiana,Punjab,India', 30.906090, 75.846786, 1),
(5, 'Chandigarh,Punjab,India', 30.731344, 76.775383, 1),
(6, 'Indore,Madhya Pradesh,India', NULL, NULL, 0),
(7, 'Noida,Uttar Pradesh,India', NULL, NULL, 0),
(8, 'Shimla,Himachal Pradesh,India', NULL, NULL, 0),
(9, 'Pune,Maharashtra,India', NULL, NULL, 0),
(10, 'Kolkata,West Bangal,India', NULL, NULL, 0),
(11, 'Alwar,Rajasthan,India', NULL, NULL, 0),
(12, 'Bikaner,Rajasthan,India', NULL, NULL, 0),
(13, 'Nagpur,Maharashtra,India', NULL, NULL, 0),
(14, 'chennai,Tamilnadu,India', NULL, NULL, 0),
(15, 'Ahmedabad,Gujrat,India', NULL, NULL, 0),
(16, 'Coimbatore,Karnataka,India', NULL, NULL, 0),
(17, 'Jalandhar,Punjab,India', NULL, NULL, 0),
(18, 'Jodhapur,Rajasthan,India', NULL, NULL, 0),
(19, 'Nagpur,Madhya Pradesh,India', NULL, NULL, 0),
(20, 'Jaipur,Rajasthan,India', NULL, NULL, 0),
(21, 'Bhopal,Madhya Pradesh,India', NULL, NULL, 0),
(22, 'Mumbai,Maharashtra,India', NULL, NULL, 0),
(23, 'Vadodara,Gujrat,India', NULL, NULL, 0),
(24, 'Hyderabad,Andhra Pradesh,India', NULL, NULL, 0),
(25, 'Udaipur,Rajasthan,India', NULL, NULL, 0),
(26, 'Banglore,Karnataka,India', NULL, NULL, 0);;

