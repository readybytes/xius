TRUNCATE TABLE `#__xius_info`;;
INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\ntooltip=\n\n', '2', '', 'Jsfields', 1, 1),
(2, 'City', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', '', 'Jsfields', 2, 1),
(3, 'Country', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '12', '', 'Jsfields', 3, 1),
(4, 'Register Date', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'registerDate', '', 'Joomla', 4, 1),
(5, 'Birthday', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '3', '', 'Jsfields', 5, 1),
(6, 'Age', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '5', 'rangesearchType=date\n\n', 'Rangesearch', 6, 1),
(7, 'ID', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'id', '', 'Joomla', 7, 0),
(8, 'ID range', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '7', 'rangesearchType=integer\n\n', 'Rangesearch', 8, 1);;

DROP TABLE IF EXISTS `#__xius_cache`;;
CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `jsfields2_0` varchar(250) NOT NULL,
  `jsfields11_0` varchar(250) NOT NULL,
  `jsfields12_0` varchar(250) NOT NULL,
  `joomlaregisterDate_0` datetime NOT NULL,
  `jsfields3_0` varchar(250) NOT NULL,
  `rangesearch5_0` int(5) NOT NULL DEFAULT '0',
  `joomlaid_0` int(21) NOT NULL,
  `rangesearch7_0` int(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;

INSERT INTO `#__xius_cache` (`userid`, `jsfields2_0`, `jsfields11_0`, `jsfields12_0`, `joomlaregisterDate_0`, `jsfields3_0`, `rangesearch5_0`, `joomlaid_0`, `rangesearch7_0`) VALUES
(62, '', '', '', '2010-01-16 11:12:08', '', 0, 62, 62),
(63, '', '', '', '2010-05-20 10:31:50', '', 0, 63, 63),
(64, 'Female', 'Surat', 'Angola', '2010-05-20 10:32:10', '2000-12-25 23:59:59', 10, 64, 64),
(65, 'Female', 'Ludhiana', 'Andorra', '2010-05-20 10:32:10', '1992-2-9 23:59:59', 18, 65, 65),
(66, 'Male', 'Chandigarh', 'Andorra', '2010-05-20 10:32:10', '1994-9-22 23:59:59', 16, 66, 66),
(67, 'Male', 'Indore', 'Algeria', '2010-05-20 10:32:10', '1993-6-20 23:59:59', 17, 67, 67),
(68, 'Female', 'Noida', 'Andorra', '2010-05-20 10:32:10', '1994-5-21 23:59:59', 16, 68, 68),
(69, 'Female', 'Shimla', 'Anguilla', '2010-05-20 10:32:10', '1992-9-21 23:59:59', 18, 69, 69),
(70, 'Female', 'Pune', 'Andorra', '2010-05-20 10:32:10', '1999-1-21 23:59:59', 11, 70, 70),
(71, 'Female', 'Kolkata', 'American Samoa', '2010-05-20 10:32:10', '1994-1-27 23:59:59', 16, 71, 71),
(72, 'Female', 'Alwar', 'Anguilla', '2010-05-20 10:32:10', '1996-10-3 23:59:59', 14, 72, 72),
(73, 'Male', 'Pune', 'Angola', '2010-05-20 10:32:10', '1998-12-21 23:59:59', 12, 73, 73),
(74, 'Female', 'Noida', 'Algeria', '2010-05-20 10:32:10', '1995-9-18 23:59:59', 15, 74, 74),
(75, 'Male', 'Ajmer', 'Argentina', '2010-05-20 10:32:10', '1996-7-10 23:59:59', 14, 75, 75),
(76, 'Male', 'Noida', 'Anguilla', '2010-05-20 10:32:10', '1999-12-20 23:59:59', 11, 76, 76),
(77, 'Male', 'Ludhiana', 'Antarctica', '2010-05-20 10:32:10', '1994-6-3 23:59:59', 16, 77, 77),
(78, 'Female', 'Bikaner', 'Algeria', '2010-05-20 10:32:10', '1997-10-23 23:59:59', 13, 78, 78),
(79, 'Female', 'Nagpur', 'Afghanistan', '2010-05-20 10:32:10', '1990-5-7 23:59:59', 20, 79, 79),
(80, 'Female', 'chennai', 'Albania', '2010-05-20 10:32:10', '1998-12-20 23:59:59', 12, 80, 80),
(81, 'Male', 'Ahmedabad', 'Angola', '2010-05-20 10:32:10', '1996-11-20 23:59:59', 14, 81, 81),
(82, 'Male', 'Coimbatore', 'Andorra', '2010-05-20 10:32:10', '1995-10-13 23:59:59', 15, 82, 82),
(83, 'Female', 'Nagpur', 'Afghanistan', '2010-05-20 10:32:10', '1997-1-12 23:59:59', 13, 83, 83),
(84, 'Female', 'Bhilwara', 'Andorra', '2010-05-20 10:32:10', '1994-6-2 23:59:59', 16, 84, 84),
(85, 'Male', 'Ludhiana', 'Argentina', '2010-05-20 10:32:10', '2000-10-8 23:59:59', 10, 85, 85),
(86, 'Female', 'Jalandhar', 'Algeria', '2010-05-20 10:32:10', '2000-1-7 23:59:59', 10, 86, 86),
(87, 'Female', 'Jodhapur', 'Albania', '2010-05-20 10:32:10', '1996-4-14 23:59:59', 14, 87, 87),
(88, 'Female', 'Ludhiana', 'Armenia', '2010-05-20 10:32:10', '1998-8-24 23:59:59', 12, 88, 88),
(89, 'Male', 'Alwar', 'Andorra', '2010-05-20 10:32:10', '1994-1-17 23:59:59', 16, 89, 89),
(90, 'Female', 'Bhilwara', 'Afghanistan', '2010-05-20 10:32:10', '1993-6-9 23:59:59', 17, 90, 90),
(91, 'Female', 'Indore', 'Argentina', '2010-05-20 10:32:10', '1998-8-19 23:59:59', 12, 91, 91),
(92, 'Male', 'Noida', 'Armenia', '2010-05-20 10:32:10', '1990-2-3 23:59:59', 20, 92, 92),
(93, 'Female', 'Indore', 'Anguilla', '2010-05-20 10:32:10', '2000-6-20 23:59:59', 10, 93, 93),
(94, 'Male', 'Kolkata', 'Angola', '2010-05-20 10:32:10', '1994-6-13 23:59:59', 16, 94, 94),
(95, 'Female', 'Nagpur', 'Armenia', '2010-05-20 10:32:10', '1998-6-17 23:59:59', 12, 95, 95),
(96, 'Male', 'Jaipur', 'Anguilla', '2010-05-20 10:32:10', '1998-9-3 23:59:59', 12, 96, 96),
(97, 'Female', 'Bhopal', 'Algeria', '2010-05-20 10:32:10', '1999-10-25 23:59:59', 11, 97, 97),
(98, 'Female', 'Mumbai', 'Albania', '2010-05-20 10:32:10', '1992-11-18 23:59:59', 18, 98, 98),
(99, 'Male', 'Ludhiana', 'Angola', '2010-05-20 10:32:10', '1996-4-22 23:59:59', 14, 99, 99),
(100, 'Male', 'Ludhiana', 'Anguilla', '2010-05-20 10:32:10', '1998-5-14 23:59:59', 12, 100, 100),
(101, 'Male', 'Ajmer', 'Aruba', '2010-05-20 10:32:10', '1995-2-18 23:59:59', 15, 101, 101),
(102, 'Female', 'Coimbatore', 'Aruba', '2010-05-20 10:32:10', '1992-9-23 23:59:59', 18, 102, 102),
(103, 'Male', 'Pune', 'Antigua and Barbuda', '2010-05-20 10:32:10', '1999-2-27 23:59:59', 11, 103, 103),
(104, 'Male', 'Vadodara', 'Armenia', '2010-05-20 10:32:10', '1990-6-2 23:59:59', 20, 104, 104),
(105, 'Female', 'Bikaner', 'Antarctica', '2010-05-20 10:32:10', '1998-4-21 23:59:59', 12, 105, 105),
(106, 'Male', 'Hyderabad', 'Andorra', '2010-05-20 10:32:10', '1998-9-11 23:59:59', 12, 106, 106),
(107, 'Male', 'chennai', 'Albania', '2010-05-20 10:32:10', '1997-11-16 23:59:59', 13, 107, 107),
(108, 'Male', 'Chandigarh', 'Andorra', '2010-05-20 10:32:10', '1993-2-12 23:59:59', 17, 108, 108),
(109, 'Male', 'Udaipur', 'Angola', '2010-05-20 10:32:10', '1998-4-16 23:59:59', 12, 109, 109),
(110, 'Male', 'chennai', 'Antigua and Barbuda', '2010-05-20 10:32:10', '1995-4-5 23:59:59', 15, 110, 110),
(111, 'Male', 'Jaipur', 'Antigua and Barbuda', '2010-05-20 10:32:10', '1990-3-13 23:59:59', 20, 111, 111),
(112, 'Male', 'Ahmedabad', 'Andorra', '2010-05-20 10:32:10', '1995-1-20 23:59:59', 15, 112, 112),
(113, 'Male', 'Jalandhar', 'Antigua and Barbuda', '2010-05-20 10:32:10', '1996-4-18 23:59:59', 14, 113, 113),
(114, 'Female', 'Hyderabad', 'Argentina', '2010-05-20 10:32:10', '1997-6-16 23:59:59', 13, 114, 114),
(115, 'Female', 'Bhilwara', 'Albania', '2010-05-20 10:32:10', '1994-9-1 23:59:59', 16, 115, 115),
(116, 'Female', 'Shimla', 'Aruba', '2010-05-20 10:32:10', '1990-1-13 23:59:59', 20, 116, 116),
(117, 'Female', 'Banglore', 'Albania', '2010-05-20 10:32:10', '1999-8-12 23:59:59', 11, 117, 117),
(118, 'Female', 'Jaipur', 'American Samoa', '2010-05-20 10:32:10', '1999-10-22 23:59:59', 11, 118, 118),
(119, 'Male', 'Surat', 'Albania', '2010-05-20 10:32:10', '1999-7-4 23:59:59', 11, 119, 119),
(120, 'Male', 'Ludhiana', 'Algeria', '2010-05-20 10:32:10', '1990-6-13 23:59:59', 20, 120, 120);;

