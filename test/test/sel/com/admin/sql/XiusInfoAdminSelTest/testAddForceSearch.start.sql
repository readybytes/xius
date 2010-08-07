/* XIUS INFO */

TRUNCATE TABLE `#__xius_info`;;

/* XIUS INFO */

TRUNCATE TABLE `#__xius_info`;;

DROP TABLE IF EXISTS `au_#__xius_info`;;
CREATE TABLE `au_#__xius_info` SELECT * FROM `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '2', '', 'Jsfields', 1, 1),
(2, 'City', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', '', 'Jsfields', 2, 1),
(3, 'Country', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '12', '', 'Jsfields', 3, 1),
(4, 'Register Date', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'registerDate', '', 'Joomla', 4, 1),
(5, 'Username', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=1\n\n', 'username', '', 'Joomla', 5, 1),
(6, 'Name', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'name', '', 'Joomla', 6, 1),
(7, 'Checkbox1', 'isSearchable=1\nisVisible=0\nisSortable=0\nisExportable=1\n\n', '17', '', 'Jsfields', 7, 1),
(8, 'Birthday', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '3', '', 'Jsfields', 8, 1),
(9, 'ID', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'id', '', 'Joomla', 9, 1),
(10, 'E-mail', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'email', '', 'Joomla', 10, 1),
(11, 'usertype', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'usertype', '', 'Joomla', 11, 1),
(12, 'Block', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'block', '', 'Joomla', 12, 1),
(13, 'lastvisitDate', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'lastvisitDate', '', 'Joomla', 13, 1),
(14, 'Block should be 0', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 12, 'infoid=12\nvalue=s:1:"0";\noperator==\n\n', 'Forcesearch', 14, 1),
(15, 'All Female', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 1, 'infoid=1\nvalue=s:6:"Female";\noperator==\n\n', 'Forcesearch', 15, 1),
(16, 'Super Admin should not be visible', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 11, 'infoid=11\nvalue=s:19:"Super Administrator";\noperator==\n\n', 'Forcesearch', 16, 0);;


INSERT INTO `au_#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '2', '', 'Jsfields', 1, 1),
(2, 'City', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', '', 'Jsfields', 2, 1),
(3, 'Country', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '12', '', 'Jsfields', 3, 1),
(4, 'Register Date', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'registerDate', '', 'Joomla', 4, 1),
(5, 'Username', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=1\n\n', 'username', '', 'Joomla', 5, 1),
(6, 'Name', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'name', '', 'Joomla', 6, 1),
(7, 'Checkbox1', 'isSearchable=1\nisVisible=0\nisSortable=0\nisExportable=1\n\n', '17', '', 'Jsfields', 7, 1),
(8, 'Birthday', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '3', '', 'Jsfields', 8, 1),
(9, 'ID', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'id', '', 'Joomla', 9, 1),
(10, 'E-mail', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'email', '', 'Joomla', 10, 1),
(11, 'usertype', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'usertype', '', 'Joomla', 11, 1),
(12, 'Block', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'block', '', 'Joomla', 12, 1),
(13, 'lastvisitDate', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'lastvisitDate', '', 'Joomla', 13, 1),
(14, 'Block should be 0', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 12, 'infoid=12\nvalue=s:1:"0";\noperator==\n\n', 'Forcesearch', 14, 1),
(15, 'All Female', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 1, 'infoid=1\nvalue=s:6:"Female";\noperator==\n\n', 'Forcesearch', 15, 1),
(16, 'Super Admin should not be visible', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 11, 'infoid=11\nvalue=s:19:"Super Administrator";\noperator==\n\n', 'Forcesearch', 16, 0),
(17, 'Register Date Should be 10 Jun 2009', 'isSearchable=0\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', '4', 'infoid=4\nvalue=s:10:"10-06-2009";\noperator==\n\n', 'Forcesearch', 17, 1),
(18, 'Checkbox1 value should be checkbox11 and checkbox', 'isSearchable=0\nisVisible=0\nisSortable=0\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', '7', 'infoid=7\nvalue=a:2:{i:0;s:10:"Checkbox11";i:1;s:8:"Checkbox";}\noperator==\n\n', 'Forcesearch', 18, 0);;
