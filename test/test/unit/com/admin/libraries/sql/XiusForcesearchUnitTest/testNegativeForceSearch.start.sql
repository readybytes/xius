TRUNCATE TABLE `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'name', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'name', '', 'Joomla', 1, 1),
(2, 'About me', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '4', '', 'Jsfields', 2, 1),
(3, 'name Force', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '1', 'infoid=1\nvalue=s:20:"name73,name79,name93";\noperator==\noperatorType=NOT IN\n\n', 'Forcesearch', 3, 1),
(4, 'About me Force', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '2', 'infoid=2\nvalue=s:14:"11,12,Hello,Hi";\noperator==\noperatorType=IN\n\n', 'Forcesearch', 4, 1),
(5, 'points', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'points', '', 'Jsuser', 5, 1),
(6, 'points force', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '5', 'infoid=5\nvalue=s:1:"5";\noperator==\noperatorType=GreaterThanEqual\n\n', 'Forcesearch', 6, 1),
(7, 'name', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '1', 'infoid=1\nvalue=s:4:"name";\noperator==\noperatorType=NOTLIKE\n\n', 'Forcesearch', 7, 1),
(8, 'usertype', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'usertype', '', 'Joomla', 8, 1),
(9, 'usertype force','isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '1', 'infoid=8\nvalue=a:2:{i:0;s:2:"18";i:1;s:2:"19";}\noperator==\noperatorType=IN\n\n','Forcesearch', 9, 1),
(10, 'Birthdate', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '3', '', 'Jsfields', 10, 1),
(11, 'Birthdate force', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '10', 'infoid=10\nvalue=s:10:"20-11-1989";\noperator==\noperatorType=Equal\n\n', 'Forcesearch', 11, 1),
(12, 'About me', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '2', 'infoid=2\nvalue=s:5:"Hello";\noperator==\noperatorType=NotEqual\n\n', 'Forcesearch', 12, 1),
(13, 'Profiletype', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '17', '', 'Jsfields', 13, 1),
(14, 'ProfiletypeForce', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '13', 'infoid=13\nvalue=a:1:{i:0;s:1:"1";}\noperator==\noperatorType=NOT IN\n\n', 'Forcesearch', 14, 1);;

DROP TABLE IF EXISTS `#__xius_cache`;;

CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `jsfields17_0` varchar(250) NOT NULL,
  `jsfields3_0` datetime NOT NULL,
  `jsfields4_0` varchar(250) NOT NULL,
  `joomlaname_0` varchar(250) NOT NULL,
  `jsuserpoints_0` varchar(250) NOT NULL,
  `joomlausertype_0` varchar(250) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;;

TRUNCATE TABLE `#__xius_cache`;;
INSERT INTO `#__xius_cache` (`userid`,`jsfields17_0`, `jsfields3_0`, `jsfields4_0`, `joomlaname_0`, `jsuserpoints_0`, `joomlausertype_0`) VALUES
(62, 1, '0000-00-00 00:00:00', '', 'Administrator', '0', 'Super Administrator'),
(63, 2, '0000-00-00 00:00:00', '', 'user-1', '1', 'Registered'),
(64, 1, '0000-00-00 00:00:00', '', 'user-2', '6', 'Registered'),
(65, 2, '0000-00-00 00:00:00', '', 'user-3', '2', 'Author'),
(66, 1, '0000-00-00 00:00:00', '', 'user-4', '5', 'Registered'),
(67, 2, '0000-00-00 00:00:00', '', 'user-5', '3', 'Registered'),
(68, 1, '1989-11-20 23:59:59', 'Hello',   'john', '8', 'Registered'),
(69, 2, '1988-09-09 23:59:59', 'Hi', 'name79', '9', 'Publisher'),
(70, 1, '1988-08-09 23:59:59', '11', 'name93', '0', 'Registered'),
(71, 2, '1988-10-09 23:59:59', '12', 'name73', '3', 'Registered'),
(72, 1, '1988-09-19 23:59:59', 'Hello World', 'user7', '4', 'Registered'),
(73, 2, '0000-00-00 00:00:00', '', 'user8', '5', 'Registered'),
(74, 1, '0000-00-00 00:00:00', '', 'user9', '7', 'Registered'),
(75, 2, '0000-00-00 00:00:00', '', 'user10','6', 'Registered');;

DROP TABLE IF EXISTS `#__xius_jsfields_value`;;
CREATE TABLE IF NOT EXISTS `#__xius_jsfields_value` (
  `user_id` int(21) NOT NULL,
  `field_id_4` text,
  `field_id_3` varchar(250) DEFAULT NULL,
  `field_id_17` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;

INSERT INTO `#__xius_jsfields_value` (`user_id`, `field_id_4`, `field_id_3`,`field_id_17`) VALUES
(62, NULL, NULL ,1),
(63, NULL, NULL,2),
(64, NULL, NULL,1),
(65, NULL, NULL,2),
(66, NULL, NULL,1),
(67, NULL, NULL,2),
(68, 'Hello', '1989-11-20 23:59:59',1),
(69, 'Hi','1988-09-09 23:59:59',2),
(70, '11','1988-08-09 23:59:59',1),
(71,'12','1988-10-09 23:59:59',2),
(72, 'Hello World','1988-09-19 23:59:59',1),
(73, NULL,NULL,2),
(74, NULL,NULL,1),
(75, NULL,NULL,2);;
