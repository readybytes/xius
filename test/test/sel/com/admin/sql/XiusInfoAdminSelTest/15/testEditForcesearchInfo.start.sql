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
(14, 'Block should be 1', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 12, 'infoid=12\nvalue=s:1:"1";\noperator==\noperatorType=LIKE\n\n', 'Forcesearch', 14, 1),
(15, 'All Male', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 1, 'infoid=1\nvalue=s:4:"Male";\noperator==\noperatorType=LIKE\n\n', 'Forcesearch', 15, 1),
(16, 'Super Admin should not be visible', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 11, 'infoid=11\nvalue=s:19:"Super Administrator";\noperator==\noperatorType=LIKE\n\n', 'Forcesearch', 16, 0),
(17, 'Age', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '8', '', 'Rangesearch', 17, 1),
(18, 'From 10 to 12 age group', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '17', 'infoid=17\nvalue=a:2:{i:0;s:2:"10";i:1;s:2:"12";}\noperator==\noperatorType=LIKE\n\n', 'Forcesearch', 20, 1);;


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
(14, 'Block should be 0', 'isSearchable=1\nisVisible=0\nisSortable=0\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=1\ntooltip=Not Blocked User\nxipt_privacy=a:1:{i:0;s:1:"0";}\njs_privacy=public\n\n', '12', 'infoid=12\nvalue=s:1:"0";\noperator==\noperatorType=LIKE\n\n', 'Forcesearch', 14, 1),
(15, 'All Female', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=Female User\nxipt_privacy=a:1:{i:0;s:1:"0";}\njs_privacy=public\n\n', '1', 'infoid=1\nvalue=s:6:"Female";\noperator==\noperatorType=LIKE\n\n', 'Forcesearch', 15, 1),
(16, 'Super Admin should not be visible', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', 'infoid=11\nvalue=s:19:"Super Administrator";\noperator==\noperatorType=LIKE\n\n', 'Forcesearch', 16, 0),
(17, 'Age', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '8', '', 'Rangesearch', 17, 1),
(18, 'From 0 to 16 age group', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\nxipt_privacy=a:1:{i:0;s:1:"0";}\njs_privacy=public\n\n', '17', 'infoid=17\nvalue=a:2:{i:0;s:1:"0";i:1;s:2:"16";}\noperator==\noperatorType=LIKE\n\n', 'Forcesearch', 20, 1);;

