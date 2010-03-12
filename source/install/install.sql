CREATE TABLE IF NOT EXISTS `#__xius_info` (
  `id` int(21) unsigned NOT NULL auto_increment,
  `key` varchar(250) NOT NULL,
  `params` text NOT NULL,
  `plgintype` varchar(250) NOT NULL,
  `ordering` int(10) default NULL,
  `published` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
