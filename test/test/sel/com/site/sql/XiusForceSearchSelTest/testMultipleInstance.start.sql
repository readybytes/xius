TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` (`userid`) VALUES
(62),(63),(64),(65),(66),(67),(68),(69);;

TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, 25, '2009-10-27 14:21:57', '2010-11-29 11:30:35', '', '\n'),
(63, 'user10', 'username10', 'username@gmail.com', 'a10245739bccdc39e792c361d681f39f:Toew3Cuh8lkSCc6EDtDS9z1M96IxZJ8I', 'Registered', 0, 0, 18, '2010-09-18 09:53:34', '2010-09-20 04:29:39', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(64, 'user20', 'username20', 'username20@gmail.com', 'b9654ac581b7c291f8e313cc394ee684:XdrrNsN7N29jOE9HAnJPkBeCrlJVjYTL', 'Administrator', 0, 0, 24, '2010-09-18 09:57:25', '2010-09-20 05:25:16', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(65, 'user30', 'username30', 'username30@gmail.com', '0e6cd24132b082a8c4bf76df5da45aa0:Ht9b3kmcf5Fg9Te62hkgmdVxgn57unLk', 'Manager', 0, 0, 23, '2010-09-18 09:58:19', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(66, 'user40', 'username40', 'username40@gmail.com', 'ec9d070bd53808b0c64e92da3b098d39:mBQ78zCG4TPxlx7iZiu8c3efw4Y9wz85', 'Publisher', 0, 0, 21, '2010-09-18 09:59:18', '2010-09-20 05:25:45', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(67, 'user50', 'username50', 'username50@gmail.com', '30553d7bb93e65a0e122038cf4f62aa7:mU6yIJKkG5RYNG95ueI5oEp52J4narLw', 'Registered', 0, 0, 18, '2010-09-18 10:00:37', '2010-09-20 05:03:26', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(68, 'user60', 'username60', 'username60@gmail.com', '75c042bfce0ff812f93390aa7a4d4a19:IGDFuFiYXbVIEZTQ7sqYi1BZulbYSorM', 'Administrator', 0, 0, 24, '2010-09-18 10:01:18', '2010-09-20 04:44:53', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(70, 'user80', 'username80', 'username80@gmail.com', '87f637cde7d39f5b8af896a899df2a13:gEBgHAhv5ZgukL6vAwCVbLzGXmd8HQkQ', 'Registered', 1, 0, 18, '2010-09-18 10:38:34', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(69, 'user70', 'username70', 'username70@gmail.com', '856f265dc924a2f7aac5d65e8106a8a7:CYb6RZGlecUKc3fj5eCzDXsvqJTprSuL', 'Registered', 1, 0, 18, '2010-09-18 10:29:15', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n');;


TRUNCATE TABLE `#__core_acl_aro`;;
INSERT INTO `#__core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(11, 'users', '63', 0, 'user10', 0),
(12, 'users', '64', 0, 'user20', 0),
(13, 'users', '65', 0, 'user30', 0),
(14, 'users', '66', 0, 'user40', 0),
(15, 'users', '67', 0, 'user50', 0),
(16, 'users', '68', 0, 'user60', 0),
(17, 'users', '69', 0, 'user70', 0),
(18, 'users', '70', 0, 'user80', 0);;


TRUNCATE TABLE `#__core_acl_groups_aro_map`;;
INSERT INTO `#__core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES
(18, '', 11),
(18, '', 15),
(18, '', 17),
(18, '', 18),
(21, '', 14),
(23, '', 13),
(24, '', 12),
(24, '', 16),
(25, '', 10);;

TRUNCATE TABLE `#__xius_info`;;
INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '2', '', 'Jsfields', 1, 1),
(2, 'City', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', '', 'Jsfields', 2, 1),
(3, 'Country', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '12', '', 'Jsfields', 3, 1),
(4, 'Register Date', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'registerDate', '', 'Joomla', 4, 1),
(5, 'Username', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=1\n\n', 'username', '', 'Joomla', 5, 1),
(6, 'Name', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'name', '', 'Joomla', 6, 1),
(8, 'Birthday', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '3', '', 'Jsfields', 8, 1),
(9, 'ID', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'id', '', 'Joomla', 9, 1),
(10, 'E-mail', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'email', '', 'Joomla', 10, 1),
(11, 'usertype', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'usertype', '', 'Joomla', 11, 1),
(12, 'Block', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'block', '', 'Joomla', 12, 1),
(13, 'lastvisitDate', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'lastvisitDate', '', 'Joomla', 13, 1),
(14, 'Block should be 0', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:2:"18";}\nisExportable=1\ntooltip=\njs_privacy=public\n\n', '12', 'infoid=12\nvalue=s:1:"0";\noperator==\n\n', 'Forcesearch', 14, 1),
(15, 'All Female', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:2:"23";}\nisExportable=1\ntooltip=\njs_privacy=public\n\n', '1', 'infoid=1\nvalue=s:6:"Female";\noperator==\n\n', 'Forcesearch', 15, 1),
(16, 'All Female', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:2:"19";}\nisExportable=1\ntooltip=\njs_privacy=public\n\n', '1', 'infoid=1\nvalue=s:4:"Male";\noperator==\n\n', 'Forcesearch', 15, 1),
(20, 'All Female', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:2:"19";}\nisExportable=1\ntooltip=\njs_privacy=public\n\n', '1', 'infoid=1\nvalue=s:6:"Female";\noperator==\n\n', 'Forcesearch', 15, 1),
(17, 'All Female', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:2:"24";}\nisExportable=1\ntooltip=\njs_privacy=public\n\n', '1', 'infoid=1\nvalue=s:4:"Male";\noperator==\n\n', 'Forcesearch', 15, 1),
(19, 'All Female', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:2:"24";}\nisExportable=1\ntooltip=\njs_privacy=public\n\n', '1', 'infoid=1\nvalue=s:6:"Female";\noperator==\n\n', 'Forcesearch', 15, 1),
(18, 'Super Admin should not be visible', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', 'infoid=11\nvalue=s:19:"Super Administrator";\noperator==\n\n', 'Forcesearch', 16, 0);;

TRUNCATE TABLE `#__community_fields`;;
INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `options`, `fieldcode`, `registration`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basic information for user', 1, 0, 1, '', '', 1),
(2, 'select', 2, 1, 10, 100, 'Gender', 'Select gender', 1, 0, 1, 'Male\nFemale', 'FIELD_GENDER', 1),
(3, 'date', 3, 1, 10, 100, 'Birthday', 'Enter your date of birth so other users can know when to wish you happy birthday ', 1, 0, 1, '', 'FIELD_BIRTHDAY', 1),
(4, 'text', 4, 1, 5, 250, 'Hometown', 'Hometown', 1, 0, 1, '', 'FIELD_HOMETOWN', 1),
(5, 'textarea', 5, 1, 1, 800, 'About me', 'Tell us more about yourself', 1, 0, 1, '', 'FIELD_ABOUTME', 1),
(6, 'group', 6, 1, 10, 100, 'Contact Information', 'Specify your contact details', 1, 0, 1, '', '', 1),
(7, 'text', 7, 1, 10, 100, 'Mobile phone', 'Mobile carrier number that other users can contact you.', 1, 0, 1, '', 'FIELD_MOBILE', 1),
(8, 'text', 8, 1, 10, 100, 'Land phone', 'Contact number that other users can contact you.', 1, 0, 1, '', 'FIELD_LANDPHONE', 1),
(9, 'textarea', 9, 1, 10, 100, 'Address', 'Address', 1, 0, 1, '', 'FIELD_ADDRESS', 1),
(10, 'text', 10, 1, 10, 100, 'State', 'State', 1, 0, 1, '', 'FIELD_STATE', 1),
(11, 'text', 11, 1, 10, 100, 'City / Town', 'City / Town', 1, 0, 1, '', 'FIELD_CITY', 1),
(13, 'text', 12, 1, 10, 100, 'Website', 'Website', 1, 0, 1, '', 'FIELD_WEBSITE', 1),
(14, 'group', 13, 1, 10, 100, 'Education', 'Educations', 1, 0, 1, '', '', 1),
(15, 'text', 14, 1, 10, 200, 'College / University', 'College / University', 1, 0, 1, '', 'FIELD_COLLEGE', 1),
(16, 'text', 15, 1, 5, 100, 'Graduation Year', 'Graduation year', 1, 0, 1, '', 'FIELD_GRADUATION', 1);;

DROP TABLE IF EXISTS `#__xius_cache`;;
CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `jsfields2_0` varchar(250) NOT NULL,
  `jsfields11_0` varchar(250) NOT NULL,
  `jsfields12_0` varchar(250) NOT NULL,
  `joomlaregisterDate_0` datetime NOT NULL,
  `joomlausername_0` varchar(250) NOT NULL,
  `joomlaname_0` varchar(250) NOT NULL,
  `jsfields3_0` datetime NOT NULL,
  `joomlaid_0` int(21) NOT NULL,
  `joomlaemail_0` varchar(250) NOT NULL,
  `joomlausertype_0` varchar(250) NOT NULL,
  `joomlablock_0` tinyint(4) NOT NULL,
  `joomlalastvisitDate_0` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;

--
-- Dumping data for table `j341_xius_cache`
--

INSERT INTO `#__xius_cache` (`userid`, `jsfields2_0`, `jsfields11_0`, `jsfields12_0`, `joomlaregisterDate_0`, `joomlausername_0`, `joomlaname_0`, `jsfields3_0`, `joomlaid_0`, `joomlaemail_0`, `joomlausertype_0`, `joomlablock_0`, `joomlalastvisitDate_0`) VALUES
(62, 'Male', '', '', '2009-10-27 14:21:57', 'admin', 'Administrator', '0000-00-00 00:00:00', 62, 'shyam@readybytes.in', 'Super Administrator', 0, '2010-11-29 11:30:35'),
(63, 'Female', '', '', '2010-09-18 09:53:34', 'username10', 'user10', '0000-00-00 00:00:00', 63, 'username@gmail.com', 'Registered', 0, '2010-11-30 07:52:28'),
(64, 'Male', '', '', '2010-09-18 09:57:25', 'username20', 'user20', '0000-00-00 00:00:00', 64, 'username20@gmail.com', 'Administrator', 0, '2010-09-20 05:25:16'),
(65, 'Female', '', '', '2010-09-18 09:58:19', 'username30', 'user30', '0000-00-00 00:00:00', 65, 'username30@gmail.com', 'Manager', 0, '2010-11-30 07:52:32'),
(66, 'Female', '', '', '2010-09-18 09:59:18', 'username40', 'user40', '0000-00-00 00:00:00', 66, 'username40@gmail.com', 'Publisher', 0, '2010-09-20 05:25:45'),
(67, 'Male', '', '', '2010-09-18 10:00:37', 'username50', 'user50', '0000-00-00 00:00:00', 67, 'username50@gmail.com', 'Registered', 0, '2010-09-20 05:03:26'),
(68, 'Female', '', '', '2010-09-18 10:01:18', 'username60', 'user60', '0000-00-00 00:00:00', 68, 'username60@gmail.com', 'Administrator', 0, '2010-09-20 04:44:53'),
(69, 'Male', '', '', '2010-09-18 10:29:15', 'username70', 'user70', '0000-00-00 00:00:00', 69, 'username70@gmail.com', 'Registered', 1, '0000-00-00 00:00:00'),
(70, 'Female', '', '', '2010-09-18 10:38:34', 'username80', 'user80', '0000-00-00 00:00:00', 70, 'username80@gmail.com', 'Registered', 1, '0000-00-00 00:00:00');;

