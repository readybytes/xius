TRUNCATE TABLE `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', '', '2', '', 'Jsfields', 1, 0),
(2, 'City', '', '11', '', 'Jsfields', 2, 1),
(3, 'Country', '', '12', '', 'Jsfields', 3, 1),
(4, 'Register Date', 'isVisible=0\n\n', 'registerDate', '', 'Joomla', 4, 0),
(5, 'Username', '', 'username', '', 'Joomla', 5, 1),
(6, 'block', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'block', '', 'Joomla', 6, 1),
(8, 'Register Date', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '4', 'rangesearchType=date-range\n\n', 'Rangesearch', 7, 1),
(9, 'force for male', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '1', 'infoid=1\nvalue=s:4:"Male";\noperator==\n\n', 'Forcesearch', 8, 1);;

TRUNCATE TABLE `#__xius_config` ;;

INSERT INTO `#__xius_config` (`name`, `params`) VALUES
('config', 'xiusTemplates=default\nintegrateJomSocial=1\nxiusKey=AB2F4\nxiusDebugMode=0\nxiusListCreator=a:1:{i:0;s:19:"Super Administrator";}\nxiusReplaceSearch=1\nxiusSlideShow=none\nxiusLoadJquery=0\nxiusEnableMatch=1\nxiusDefaultMatch=AND\n\n');;
