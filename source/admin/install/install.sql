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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__xius_list` (
  `id` int(11) NOT NULL auto_increment,
  `owner` int(21) NOT NULL,
  `name` text NOT NULL,
  `visibleinfo` varchar(250) NOT NULL,
  `sortinfo` varchar(250) NOT NULL,
  `sortdir` varchar(250) NOT NULL,
  `join` varchar(250) NOT NULL,
  `conditions` text NOT NULL,
  `published` tinyint(1) NOT NULL default '1',
  `ordering` int(10) default NULL,
  `description` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `#__xius_config` (
  `name` varchar(64) NOT NULL,
  `params` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;