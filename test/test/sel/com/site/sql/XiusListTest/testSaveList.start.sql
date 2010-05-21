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
(2, 62, 'Register Date is 16-01-2010', '', '3', 'ASC', 'AND', 'a:1:{i:0;a:3:{s:6:"infoid";s:1:"4";s:5:"value";s:10:"16-01-2010";s:8:"operator";s:1:"=";}}', 1, 2, 'All members whose registeration date is 16 Jan 2010', ''),
(3, 62, 'Female From Afghanistan', '', '8', 'ASC', 'AND', 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:11:"Afghanistan";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:6:"Female";s:8:"operator";s:1:"=";}}', 1, 2, 'All Female from afghanistan', '');;


INSERT INTO `#__xius_list` (`id`, `owner`, `name`, `visibleinfo`, `sortinfo`, `sortdir`, `join`, `conditions`, `published`, `ordering`, `description`, `params`) VALUES
(1, 62, 'Male From Afghanistan', '', '8', 'ASC', 'AND', 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:4:"Male";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:11:"Afghanistan";s:8:"operator";s:1:"=";}}', 1, 4, 'All Male From Afghanistan', ''),
(2, 62, 'Register Date is 16-01-2010', '', '3', 'ASC', 'AND', 'a:1:{i:0;a:3:{s:6:"infoid";s:1:"4";s:5:"value";s:10:"16-01-2010";s:8:"operator";s:1:"=";}}', 1, 2, 'All members whose registeration date is 16 Jan 2010', '');;

DROP TABLE IF EXISTS `#__xius_cache`;;

CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `jsfields2` varchar(250) NOT NULL,
  `jsfields11` varchar(250) NOT NULL,
  `jsfields12` varchar(250) NOT NULL,
  `joomlaregisterDate` datetime NOT NULL,
  `joomlausername` varchar(250) NOT NULL,
  `joomlaname` varchar(250) NOT NULL,
  `jsfields17` varchar(250) NOT NULL,
  `jsfields3` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;

--
-- Dumping data for table `j415_xius_cache`
--

INSERT INTO `#__xius_cache` (`userid`, `jsfields2`, `jsfields11`, `jsfields12`, `joomlaregisterDate`, `joomlausername`, `joomlaname`, `jsfields17`, `jsfields3`) VALUES
(62, '', '', '', '2010-01-16 11:12:08', 'admin', 'Administrator', '', ''),
(63, 'Male', 'Noida', 'India', '2009-03-05 08:18:00', 'ssv', 'Moderator', 'JomSocial Redirector,', ''),
(64, '', '', '', '2009-03-15 00:26:29', 'shansmith01', 'Shannon', '', ''),
(65, '', '', '', '2009-03-15 11:26:31', 'pembaris', 'pembaris', '', ''),
(66, '', '', '', '2009-03-16 10:56:18', 'collaborator', 'collaborator', '', ''),
(67, '', '', '', '2009-03-17 06:00:03', 'edge', 'edge', '', ''),
(68, '', '', '', '2009-03-17 13:55:57', 'Twinkiez', 'Frank', '', ''),
(70, '', '', '', '2009-03-22 00:51:13', 'Mapelibebuime', 'Mapelibebuime', '', ''),
(71, '', '', '', '2009-03-24 16:44:51', 'Metaltome', 'Christopher', '', ''),
(73, '', '', '', '2009-04-01 15:16:42', 'CurveeOrg', 'CurveeOrg', '', ''),
(74, '', '', '', '2009-04-01 20:59:23', 'Dano', 'Dan', '', ''),
(75, '', '', '', '2009-04-04 08:31:16', 'rrvision', 'vision', '', ''),
(76, '', '', '', '2009-04-04 11:57:41', 'maxiron', 'maxiron', '', ''),
(77, '', '', '', '2009-04-04 12:56:20', 'vicky', 'vicky', '', ''),
(78, '', '', '', '2009-04-04 16:10:26', 'Janz', 'Janz', '', ''),
(79, '', '', '', '2009-04-04 18:12:54', 'Hanslinux', 'Hanslinux', '', ''),
(80, 'Female', 'bhilwara', 'India', '2009-04-05 07:25:24', 'meenal', 'Moderator-2', '', ''),
(81, '', '', '', '2009-04-05 14:03:47', 'k9disc', 'Ron Watson', '', ''),
(82, '', '', '', '2009-04-06 00:00:02', 'axoxiaengendy', 'axoxiaengendy', '', ''),
(83, '', '', '', '2009-04-06 03:06:01', 'Regresscoerne', 'Regresscoerne', '', ''),
(84, '', '', '', '2009-04-06 19:19:01', 'enkacom', 'enkacom', '', ''),
(85, '', '', '', '2009-04-06 22:42:52', 'sahaj', 'bodhi sahaj', '', ''),
(86, '', '', '', '2009-04-08 20:52:36', 'xert77', 'David', '', ''),
(87, '', '', '', '2009-04-09 08:28:48', 'Clint', 'Clinton', '', ''),
(88, '', '', '', '2009-04-09 14:40:17', 'Cewnorneltrit', 'Cewnorneltrit', '', ''),
(89, '', '', '', '2009-04-10 01:06:58', 'freeman76', 'Helio Alves', '', ''),
(90, '', '', '', '2009-04-10 12:47:35', 'onix', 'onix', '', '');;




TRUNCATE TABLE `#__community_fields`;;
ALTER TABLE `#__community_fields` AUTO_INCREMENT=1;;

/* add data into community_fields table */
INSERT INTO `#__community_fields`(`id`,`type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) 
VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basic information for user', 1, 1, 1, 1, '', ''),
(2, 'select', 2, 1, 10, 100, 'Gender', 'Select gender', 1, 1, 1, 1, 'Male\nFemale', 'FIELD_GENDER'),
(3, 'date', 3, 1, 10, 100, 'Birthday', 'Enter your date of birth so other users can know when to wish you happy birthday ', 1, 1, 1, 1, '', 'FIELD_BIRTHDAY'),
(4, 'text', 4, 1, 5, 250, 'Hometown', 'Hometown', 1, 1, 1, 1, '', 'FIELD_HOMETOWN'),
(5, 'textarea', 5, 1, 1, 800, 'About me', 'Tell us more about yourself', 1, 1, 1, 1, '', 'FIELD_ABOUTME'),
(6, 'group', 6, 1, 10, 100, 'Contact Information', 'Specify your contact details', 1, 1, 1, 1, '', ''),
(7, 'text', 7, 1, 10, 100, 'Mobile phone', 'Mobile carrier number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_MOBILE'),
(8, 'text', 8, 1, 10, 100, 'Land phone', 'Contact number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_LANDPHONE'),
(9, 'textarea', 9, 1, 10, 100, 'Address', 'Address', 1, 1, 1, 1, '', 'FIELD_ADDRESS'),
(10, 'text', 10, 1, 10, 100, 'State', 'State', 1, 1, 1, 1, '', 'FIELD_STATE'),
(11, 'text', 11, 1, 10, 100, 'City / Town', 'City / Town', 1, 1, 1, 1, '', 'FIELD_CITY'),
(12, 'select', 12, 1, 10, 100, 'Country', 'Country', 1, 1, 1, 1, 'Afghanistan\nAlbania\nAlgeria\nAmerican Samoa\nAndorra\nAngola\nAnguilla\nAntarctica\nAntigua and Barbuda\nArgentina\nArmenia\nAruba', 'FIELD_COUNTRY'),
(13, 'text', 13, 1, 10, 100, 'Website', 'Website', 1, 1, 1, 1, '', 'FIELD_WEBSITE'),
(14, 'group', 14, 1, 10, 100, 'Education', 'Educations', 1, 1, 1, 1, '', ''),
(15, 'text', 15, 1, 10, 200, 'College / University', 'College / University', 1, 1, 1, 1, '', 'FIELD_COLLEGE'),
(16, 'text', 16, 1, 5, 100, 'Graduation Year', 'Graduation year', 1, 1, 1, 1, '', 'FIELD_GRADUATION'),
(17, 'checkbox', 2, 1, 10, 100, 'Checkbox1', 'Checkbox1', 1, 1, 1, 1, 'Checkbox1\nCheckbox11\nCheckbox2\nCheckbox21\nCheckbox', 'Checkbox1');;
