TRUNCATE TABLE `#__xius_info`;;
ALTER TABLE `#__xius_info` AUTO_INCREMENT=1;;


DROP TABLE IF EXISTS `au_#__xius_info`;;
CREATE TABLE `au_#__xius_info` SELECT * FROM `#__xius_info`;;
INSERT INTO `au_#__xius_info` (`id`,`labelName` , `params`, `key`,`pluginParams`,`pluginType`,`ordering`,`published`) VALUES
('1', 'Gender', 'isSearchable=1\nisVisible=1\nisSortable=0\nisExportable=0',2,'','Jsfields',1,1),
('2', 'Name', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0','name','','Joomla',2,1);;
