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


TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@joomlaxi.com', 'aa95a2cb1a9bd63f349a7fb72502489c:IXZhjkhVI11TgPm5YIVeHNcJTH8HbIKs', 'Super Administrator', 0, 1, 25, '2010-01-16 11:12:08', '2010-11-27 10:05:01', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(63, 'Moderator', 'ssv', 'er.ssverma@gmail.com', '309f8af4a165c4c2cf79f9f06bebb5dd:ozrTdqb0xcCOQYG16d7vqwvFFWU1b5c9', 'Super Administrator', 0, 1, 25, '2009-03-05 08:18:00', '2010-01-04 09:12:26', '1832fd05a95d08ea463508c84bf30fd9', 'admin_language=\nlanguage=\neditor=tinymce\nhelpsite=\ntimezone=5.5\n\n'),
(64, 'Shannon', 'shansmith01', 'shannon@nomadsworld.com', 'd164259c3e82d79bca1ffc6d6db5986c:EizmMsVD0SrcA1cNNENjUyRRxbGrwfhs', 'Registered', 0, 0, 18, '2009-03-15 00:26:29', '2009-06-17 08:11:01', '', '\n'),
(65, 'pembaris', 'pembaris', 'pembaris@gmail.com', '9c57460b92ecf9741c40e55deb061f6f:h1JXinxGbBEe9jb4wcOaQIzOsw0PVQWO', 'Registered', 0, 0, 18, '2009-03-15 11:26:31', '2009-06-21 13:54:26', '', '\n'),
(66, 'collaborator', 'collaborator', 'collaborator@bonbon.net', 'cf3e4436268bb1cfde6e5f516cad7640:brhPLEExGWTQbMw9CMlIiI7zAdi17i56', 'Registered', 0, 0, 18, '2009-03-16 10:56:18', '2009-03-16 11:07:29', '', '\n'),
(67, 'edge', 'edge', 'clover97field@yahoo.com', '8b17ca2204170265edad7bf350b0602e:B0TGnxbQ4AsK3NZCGtjNYfmhlopImwsz', 'Registered', 0, 0, 18, '2009-03-17 06:00:03', '2009-03-23 05:25:54', '', '\n'),
(68, 'Frank', 'Twinkiez', 'devowriter@gmail.com', '14846f5b3ddbbfd632f95d6e775d0709:zhZXAN27fqjsAOLGmC6RwxPSYudxLy8o', 'Registered', 0, 0, 18, '2009-03-17 13:55:57', '2009-04-05 14:34:45', '', '\n'),
(70, 'Mapelibebuime', 'Mapelibebuime', 'balsekata@gmail.com', '1055d2b4e2e255f6cbe714b0478bdc8a:butHxVXf1AniOggicqW1y2yL5ThaT4ks', 'Registered', 1, 0, 18, '2009-03-22 00:51:13', '0000-00-00 00:00:00', '62bd348000c2c758bcc96e1aa1f63096', '\n');;
