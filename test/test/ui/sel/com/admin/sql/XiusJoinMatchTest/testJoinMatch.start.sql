TRUNCATE TABLE `#__xius_info` ;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', '', '2', '', 'Jsfields', 1, 1),
(2, 'City', '', '11', '', 'Jsfields', 2, 1),
(3, 'Country', '', '12', '', 'Jsfields', 3, 1),
(4, 'Register Date', 'isVisible=0\n\n', 'registerDate', '', 'Joomla', 4, 0),
(5, 'Username', '', 'username', '', 'Joomla', 5, 1),
(6, 'block', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'block', '', 'Joomla', 6, 1),
(8, 'Register Date', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '4', 'rangesearchType=date-range\n\n', 'Rangesearch', 7, 1);;


TRUNCATE TABLE `#__xius_config`;;
DROP TABLE IF EXISTS `au_#__xius_config`;;

CREATE TABLE `au_#__xius_config` SELECT * FROM `#__xius_config`;;

INSERT INTO `#__xius_config` (`name`, `params`) VALUES
('config', 'xiusTemplates=default\nintegrateJomSocial=0\nxiusKey=AB2F4\nxiusDebugMode=0\nxiusListCreator=a:1:{i:0;s:2:"25";}\nxiusReplaceSearch=0\nxiusSlideShow=none\nxiusLoadJquery=0\nxiusEnableMatch=1\nxiusDefaultMatch=OR\n\n');;


INSERT INTO `au_#__xius_config` (`name`, `params`) VALUES
('config', 'xiusTemplates=default\nintegrateJomSocial=0\nxiusKey=AB2F4\nxiusDebugMode=0\nxiusListCreator=a:1:{i:0;s:2:"25";}\nxiusReplaceSearch=0\nxiusSlideShow=none\nxiusLoadJquery=0\nxiusSortInfo=0\nxiusSortOrder=ASC\nxiusEnableMatch=1\nxiusDefaultMatch=AND\nxiusJsfieldPrivacy=0\nxiusLimit=20\nxiusCronJob=0\nxiusCronFrequency=900\nxiusCronAcessTime=0\n\n');;

DROP TABLE IF EXISTS `#__xius_cache` ;;

CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `jsfields2_0` varchar(250) NOT NULL,
  `jsfields11_0` varchar(250) NOT NULL,
  `jsfields12_0` varchar(250) NOT NULL,
  `joomlaregisterDate_0` datetime NOT NULL,
  `joomlausername_0` varchar(250) NOT NULL,
  `joomlablock_0` tinyint(4) NOT NULL,
  `rangesearch4_0` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;


INSERT INTO `#__xius_cache` (`userid`, `jsfields2_0`, `jsfields11_0`, `jsfields12_0`, `joomlaregisterDate_0`, `joomlausername_0`, `joomlablock_0`, `rangesearch4_0`) VALUES
(62, '', 'Bhilwara', 'India', '2010-01-16 11:12:08', 'admin', 0, '2010-01-16'),
(63, '', 'Ajmer', 'India', '2010-05-20 10:31:50', 'username64', 0, '2010-05-20'),
(64, 'Female', 'Surat', 'India', '2010-05-20 10:32:10', 'username65', 0, '2010-05-20'),
(65, 'Female', 'Ludhiana', 'India', '2010-05-20 10:32:10', 'username66', 0, '2010-05-20'),
(66, 'Male', 'Chandigarh', 'India', '2010-05-20 10:32:10', 'username67', 0, '2010-05-20'),
(67, 'Male', 'Indore', 'India', '2010-05-20 10:32:10', 'username68', 0, '2010-05-20'),
(68, 'Female', 'Noida', 'India', '2010-05-20 10:32:10', 'username69', 0, '2010-05-20'),
(69, 'Female', 'Shimla', 'India', '2010-05-20 10:32:10', 'username70', 0, '2010-05-20'),
(70, 'Female', 'Pune', 'India', '2010-05-20 10:32:10', 'username71', 0, '2010-05-20'),
(71, 'Female', 'Kolkata', 'India', '2010-05-20 10:32:10', 'username72', 0, '2010-05-20'),
(72, 'Female', 'Alwar', 'India', '2010-05-20 10:32:10', 'username73', 0, '2010-05-20'),
(73, 'Male', 'Pune', 'India', '2010-05-20 10:32:10', 'username74', 0, '2010-05-20'),
(74, 'Female', 'Noida', 'India', '2010-05-20 10:32:10', 'username75', 0, '2010-05-20'),
(75, 'Male', 'Ajmer', 'India', '2010-05-20 10:32:10', 'username76', 0, '2010-05-20'),
(76, 'Male', 'Noida', 'India', '2010-05-20 10:32:10', 'username77', 0, '2010-05-20'),
(77, 'Male', 'Ludhiana', 'India', '2010-05-20 10:32:10', 'username78', 0, '2010-05-20'),
(78, 'Female', 'Bikaner', 'India', '2010-05-20 10:32:10', 'username79', 0, '2010-05-20'),
(79, 'Female', 'Nagpur', 'India', '2010-05-20 10:32:10', 'username80', 0, '2010-05-20'),
(80, 'Female', 'chennai', 'India', '2010-05-20 10:32:10', 'username81', 0, '2010-05-20'),
(81, 'Male', 'Ahmedabad', 'India', '2010-05-20 10:32:10', 'username82', 0, '2010-05-20'),
(82, 'Male', 'Coimbatore', 'India', '2010-05-20 10:32:10', 'username83', 0, '2010-05-20'),
(83, 'Female', 'Nagpur', 'India', '2010-05-20 10:32:10', 'username84', 0, '2010-05-20'),
(84, 'Female', 'Bhilwara', 'India', '2010-05-20 10:32:10', 'username85', 0, '2010-05-20'),
(85, 'Male', 'Ludhiana', 'India', '2010-05-20 10:32:10', 'username86', 0, '2010-05-20'),
(86, 'Female', 'Jalandhar', 'India', '2010-05-20 10:32:10', 'username87', 0, '2010-05-20'),
(87, 'Female', 'Jodhapur', 'India', '2010-05-20 10:32:10', 'username88', 0, '2010-05-20'),
(88, 'Female', 'Ludhiana', 'India', '2010-05-20 10:32:10', 'username89', 0, '2010-05-20'),
(89, 'Male', 'Alwar', 'India', '2010-05-20 10:32:10', 'username90', 0, '2010-05-20'),
(90, 'Female', 'Bhilwara', 'India', '2010-05-20 10:32:10', 'username91', 0, '2010-05-20'),
(91, 'Female', 'Indore', 'India', '2010-05-20 10:32:10', 'username92', 0, '2010-05-20'),
(92, 'Male', 'Noida', 'India', '2010-05-20 10:32:10', 'username93', 0, '2010-05-20'),
(93, 'Female', 'Indore', 'India', '2010-05-20 10:32:10', 'username94', 0, '2010-05-20'),
(94, 'Male', 'Kolkata', 'India', '2010-05-20 10:32:10', 'username95', 0, '2010-05-20'),
(95, 'Female', 'Nagpur', 'India', '2010-05-20 10:32:10', 'username96', 0, '2010-05-20'),
(96, 'Male', 'Jaipur', 'India', '2010-05-20 10:32:10', 'username97', 0, '2010-05-20'),
(97, 'Female', 'Bhopal', 'India', '2010-05-20 10:32:10', 'username98', 0, '2010-05-20'),
(98, 'Female', 'Mumbai', 'India', '2010-05-20 10:32:10', 'username99', 0, '2010-05-20'),
(99, 'Male', 'Ludhiana', 'India', '2010-05-20 10:32:10', 'username100', 0, '2010-05-20'),
(100, 'Male', 'Ludhiana', 'India', '2010-05-20 10:32:10', 'username101', 0, '2010-05-20'),
(101, 'Male', 'Ajmer', 'India', '2010-05-20 10:32:10', 'username102', 0, '2010-05-20'),
(102, 'Female', 'Coimbatore', 'India', '2010-05-20 10:32:10', 'username103', 0, '2010-05-20'),
(103, 'Male', 'Pune', 'India', '2010-05-20 10:32:10', 'username104', 0, '2010-05-20'),
(104, 'Male', 'Vadodara', 'India', '2010-05-20 10:32:10', 'username105', 0, '2010-05-20'),
(105, 'Female', 'Bikaner', 'India', '2010-05-20 10:32:10', 'username106', 0, '2010-05-20'),
(106, 'Male', 'Hyderabad', 'India', '2010-05-20 10:32:10', 'username107', 0, '2010-05-20'),
(107, 'Male', 'chennai', 'India', '2010-05-20 10:32:10', 'username108', 0, '2010-05-20'),
(108, 'Male', 'Bhilwara', 'India', '2010-05-20 10:32:10', 'username109', 0, '2010-05-20'),
(109, 'Male', 'Udaipur', 'India', '2010-05-20 10:32:10', 'username110', 0, '2010-05-20'),
(110, 'Male', 'chennai', 'India', '2010-05-20 10:32:10', 'username111', 0, '2010-05-20'),
(111, 'Male', 'Jaipur', 'India', '2010-05-20 10:32:10', 'username112', 0, '2010-05-20'),
(112, 'Male', 'Ahmedabad', 'India', '2010-05-20 10:32:10', 'username113', 0, '2010-05-20'),
(113, 'Male', 'Jalandhar', 'India', '2010-05-20 10:32:10', 'username114', 0, '2010-05-20'),
(114, 'Female', 'Hyderabad', 'India', '2010-05-20 10:32:10', 'username115', 0, '2010-05-20'),
(115, 'Female', 'Bhilwara', 'India', '2010-05-20 10:32:10', 'username116', 0, '2010-05-20'),
(116, 'Female', 'Shimla', 'India', '2010-05-20 10:32:10', 'username117', 0, '2010-05-20'),
(117, 'Female', 'Banglore', 'India', '2010-05-20 10:32:10', 'username118', 0, '2010-05-20'),
(118, 'Female', 'Jaipur', 'India', '2010-05-20 10:32:10', 'username119', 0, '2010-05-20'),
(119, 'Male', 'Surat', 'India', '2010-05-20 10:32:10', 'username120', 0, '2010-05-20'),
(120, 'Male', 'Ludhiana', 'India', '2010-05-20 10:32:10', 'username121', 0, '2010-05-20');;
