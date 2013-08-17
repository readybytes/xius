TRUNCATE TABLE `#__xius_info`;;
INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(9, 'Profiletype', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '19', '', 'Jsfields', 1, 1);;

DROP TABLE `#__xius_cache`;;
CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `jsfields19_0` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;


TRUNCATE TABLE `#__xius_cache`;;
INSERT INTO `#__xius_cache` (`userid`, `jsfields19_0`) VALUES
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

TRUNCATE TABLE `#__xipt_profiletypes`;;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`) VALUES
(1, 'Free Member', 0, 1, 'If you are just want to explore the site, choose this type. Its free.', 'members', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 4, '', ''),
(2, 'Paid Subscriber', 1, 1, 'If you wish to subscribe for the paid components and services, choose this account type.', 'friends', 'default', 'Registered', 'images/profiletype/avatar_2.gif', 0, 1, 1, '', ''),
(3, 'Serious Joomla User', 2, 1, 'Serious Joomla User, are the users who really want to motivate the joomla developers to enhance the joomla experience. When you subscribe to this plan, you support us by paying few $$.', 'friends', 'default', 'Registered', 'images/profiletype/avatar_3.png', 0, 0, 0, '', ''),
(4, 'Moderator', 3, 0, 'The members are moderating the website.', 'friends', 'default', 'Registered', '/images/avatar/a1f960fb81d15c26035a6808.jpg', 1, 0, 0, '', '');;

