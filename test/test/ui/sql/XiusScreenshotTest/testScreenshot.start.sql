DROP TABLE IF EXISTS `#__xius_info`;;

CREATE TABLE IF NOT EXISTS `#__xius_info` (
  `id` int(21) unsigned NOT NULL auto_increment,
  `labelName` varchar(250) NOT NULL,
  `params` text NOT NULL,
  `key` varchar(250) NOT NULL,
  `pluginParams` text NOT NULL,
  `pluginType` varchar(250) NOT NULL,
  `ordering` int(21) default NULL,
  `published` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;;


INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', '', '2', '', 'Jsfields', 1, 1),
(2, 'City', '', '11', '', 'Jsfields', 2, 1),
(3, 'Country', '', '12', '', 'Jsfields', 3, 1),
(4, 'Register Date', '', 'registerDate', '', 'Joomla', 4, 1),
(5, 'Username', '', 'username', '', 'Joomla', 5, 1);;
