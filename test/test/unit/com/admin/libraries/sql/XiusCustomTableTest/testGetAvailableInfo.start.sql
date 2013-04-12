CREATE TABLE IF NOT EXISTS `xius_dummy_customtable` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `dob` date NOT NULL,
  `salary` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;;

TRUNCATE TABLE `xius_dummy_customtable`;;
INSERT INTO `xius_dummy_customtable` (`id`, `name`, `dob`, `salary`) VALUES
(62, 'User62', '1987-11-10', 15000),
(63, 'User63', '1987-11-10', 12000),
(64, 'User64', '1988-08-18', 14000);;

TRUNCATE TABLE `#__xius_info`;;
INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(5, 'Custom DOB', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'xius_dummy_customtable', 'customUseridColumn=id\ncustomSearchColumn=dob\n\n', 'Customtable', 1, 1),
(6, 'Custom Name', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'xius_dummy_customtable', 'customUseridColumn=id\ncustomSearchColumn=name\n\n', 'Customtable', 1, 1),
(7, 'Name', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'name', '', 'Joomla', 2, 1),
(8, 'E-mail', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'email', '', 'Joomla', 3, 1);;


DROP TABLE IF EXISTS `#__xius_cache`;;
DROP TABLE IF EXISTS `au_#__xius_cache`;;
CREATE TABLE IF NOT EXISTS `au_#__xius_cache` (
  `userid` int(21) NOT NULL,
  `customtablexius_dummy_customtabledob` date NOT NULL,
  `customtablexius_dummy_customtablename` text NOT NULL,
  `joomlaname_0` varchar(250) NOT NULL,
  `joomlaemail_0` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;

--
-- Dumping data for table `j341_xius_cache`
--
TRUNCATE TABLE `au_#__xius_cache`;;
INSERT INTO `au_#__xius_cache` (`userid`, `customtablexius_dummy_customtabledob`, `customtablexius_dummy_customtablename`, `joomlaname_0`, `joomlaemail_0`) VALUES
(62, '1987-11-10', 'User62', 'Administrator', 'shyam@joomlaxi.com'),
(63, '1987-11-10', 'User63', 'Moderator', 'er.ssverma@gmail.com'),
(64, '1988-08-18', 'User64', 'Shannon', 'shannon@nomadsworld.com'),
(65, '0000-00-00', '', 'pembaris', 'pembaris@gmail.com'),
(66, '0000-00-00', '', 'collaborator', 'collaborator@bonbon.net'),
(67, '0000-00-00', '', 'edge', 'clover97field@yahoo.com'),
(68, '0000-00-00', '', 'Frank', 'devowriter@gmail.com'),
(70, '0000-00-00', '', 'Mapelibebuime', 'balsekata@gmail.com');;
