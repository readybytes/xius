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



CREATE TABLE IF NOT EXISTS `#__xius_lists` (
  `id` int(11) NOT NULL auto_increment,
  `owner` int(21) NOT NULL,
  `name` text NOT NULL,
  `visibleinfo` varchar(250) NOT NULL,
  `sortinfo` varchar(250) NOT NULL,
  `join` varchar(250) NOT NULL,
  `published` tinyint(1) NOT NULL default '1',
  `ordering` int(10) default NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `#__xius_conditions` (
  `id` int(21) NOT NULL auto_increment,
  `listid` int(11) NOT NULL,
  `infoid` int(11) NOT NULL,
  `operator` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `combineconditions` varchar(250) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `#__xius_config` (
  `name` varchar(64) NOT NULL,
  `params` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
