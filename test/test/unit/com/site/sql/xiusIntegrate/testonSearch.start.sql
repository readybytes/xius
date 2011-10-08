TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'asas@s.com', 'e63a178e999d8fdbaf78a42cefbc37aa:OPVrLCOkTcG108kFk4HdGXTfnEl5WSRN', 'Super Administrator', 0, 1, 25, '2011-04-16 12:03:24', '2011-10-08 06:04:35', '', ''),
(63, 'user-1', 'user-1', 'user1@a.com', '9edebc0c54f68271f1fb27b61a7d5369:p3CZ2iGimg9HpshsOBHGvAE6aP8MQRGc', 'Registered', 0, 0, 18, '2011-04-16 07:12:58', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(64, 'user-2', 'user-2', 'user2@a.com', '70af94b92c1b1b021359f709eae07ffe:mphowNDxUDIN1kzdaeRdX2rPr5jj3tab', 'Registered', 0, 0, 18, '2011-04-16 07:13:34', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(65, 'user-3', 'user-3', 'user3@a.com', '475310d15be5b10842e936d95dcf6a29:HdeNYDwkxOBBJ7Inlfh0Rgvc15SSWzES', 'Registered', 0, 0, 18, '2011-04-16 07:14:08', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(66, 'user-4', 'user-4', 'user4@a.com', 'dba915969bd4e55a8848a0498eaf6cd9:4GATJrcWi3IXpPx1IHQiO48tOo1r04OU', 'Registered', 0, 0, 18, '2011-04-16 07:14:46', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(67, 'user-5', 'user-5', 'user5@a.com', '46a2efb4f4e368187d0a28bbc6b1839a:7RensJdiQhP5w5VgJAa2wP5RVvok5AfM', 'Registered', 0, 0, 18, '2011-04-16 07:15:21', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n');;

TRUNCATE TABLE `#__xius_info`;;
INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(2, 'Keyword', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'keywordsearch', '', 'Keyword', 1, 1),
(3, 'name', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'name', '', 'Joomla', 2, 1),
(4, 'status', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'status', '', 'Jsuser', 3, 1);;

DROP TABLE `#__xius_cache`;;
CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `joomlaname_0` varchar(250) NOT NULL, 
  `jsuserstatus_0`varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;

INSERT INTO `#__xius_cache` (`userid`, `joomlaname_0`, `jsuserstatus_0`) VALUES
(62, 'Administrator', ''),
(63, 'user-1', ''),
(64, 'user-2', ''),
(65, 'user-3', 'Hello World'),
(66, 'user-4', 'Hello'),
(67, 'user-5', 'Things are easier said than done');;

