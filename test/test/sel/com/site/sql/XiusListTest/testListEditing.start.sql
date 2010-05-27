TRUNCATE TABLE `#__xius_info`;;
ALTER TABLE `#__xius_info` AUTO_INCREMENT=1;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '2', '', 'Jsfields', 1, 1),
(2, 'City', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', '', 'Jsfields', 2, 1),
(3, 'Country', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '12', '', 'Jsfields', 3, 1),
(4, 'Register Date', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'registerDate', '', 'Joomla', 4, 1),
(5, 'Username', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=1\n\n', 'username', '', 'Joomla', 5, 1),
(6, 'Name', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'name', '', 'Joomla', 6, 1),
(7, 'Checkbox1', 'isSearchable=1\nisVisible=0\nisSortable=0\nisExportable=1\n\n', '17', '', 'Jsfields', 7, 1),
(8, 'Birthday', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '3', '', 'Jsfields', 8, 1);;


TRUNCATE TABLE `#__xius_list`;;
ALTER TABLE `#__xius_list` AUTO_INCREMENT=1;;

DROP TABLE IF EXISTS `au_#__xius_list`;;
CREATE TABLE `au_#__xius_list` SELECT * FROM `#__xius_list`;;
INSERT INTO `au_#__xius_list` (`id`, `owner`, `name`, `visibleinfo`, `sortinfo`, `sortdir`, `join`, `conditions`, `published`, `ordering`, `description`, `params`) VALUES
(1, 62, 'Male From Afghanistan', '', '8', 'ASC', 'AND', 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:4:"Male";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:11:"Afghanistan";s:8:"operator";s:1:"=";}}', 1, 4, 'All Male From Afghanistan', ''),
(2, 62, 'Register Date is 16-01-2010', '', '3', 'ASC', 'AND', 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"2";s:5:"value";s:5:"Noida";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"2";s:5:"value";s:6:"Jaipur";s:8:"operator";s:1:"=";}}', 1, 2, 'All members whose registeration date is 16 Jan 2010', '');;


INSERT INTO `#__xius_list` (`id`, `owner`, `name`, `visibleinfo`, `sortinfo`, `sortdir`, `join`, `conditions`, `published`, `ordering`, `description`, `params`) VALUES
(1, 62, 'Male From Afghanistan', '', '8', 'ASC', 'AND', 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:4:"Male";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:11:"Afghanistan";s:8:"operator";s:1:"=";}}', 1, 4, 'All Male From Afghanistan', ''),
(2, 62, 'Register Date is 16-01-2010', '', '3', 'ASC', 'AND', 'a:1:{i:0;a:3:{s:6:"infoid";s:1:"4";s:5:"value";s:10:"16-01-2010";s:8:"operator";s:1:"=";}}', 1, 2, 'All members whose registeration date is 16 Jan 2010', '');;

