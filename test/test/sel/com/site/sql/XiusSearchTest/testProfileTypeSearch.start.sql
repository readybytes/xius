TRUNCATE TABLE `#__xius_info`;;
INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(9, 'Profiletype', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '19', '', 'Jsfields', 1, 1);;

DROP TABLE `#__xius_cache`;;
CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `jsfields19` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;


TRUNCATE TABLE `#__xius_cache`;;
INSERT INTO `#__xius_cache` (`userid`, `jsfields19`) VALUES
(62, ''),
(63, ''),
(64, '2'),
(65, ''),
(66, ''),
(67, '2'),
(68, ''),
(69, ''),
(70, '1'),
(71, ''),
(72, ''),
(73, ''),
(74, ''),
(75, ''),
(76, ''),
(77, ''),
(78, '3'),
(79, '1'),
(80, ''),
(81, ''),
(82, ''),
(83, ''),
(84, ''),
(85, ''),
(86, ''),
(87, ''),
(88, ''),
(89, ''),
(90, ''),
(91, ''),
(92, ''),
(93, ''),
(94, ''),
(95, ''),
(96, ''),
(97, ''),
(98, ''),
(99, '1'),
(100, ''),
(101, '3'),
(102, '3'),
(103, ''),
(104, ''),
(105, '2'),
(106, ''),
(107, '2'),
(108, '2'),
(109, '1'),
(110, ''),
(111, '2'),
(112, ''),
(113, ''),
(114, ''),
(115, ''),
(116, ''),
(117, '2'),
(118, '3'),
(119, '2'),
(120, '1');;


