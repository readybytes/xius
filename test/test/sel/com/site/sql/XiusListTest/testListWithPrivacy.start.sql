TRUNCATE TABLE `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '2', '', 'Jsfields', 1, 1),
(2, 'City', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', '', 'Jsfields', 2, 1),
(3, 'Country', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '12', '', 'Jsfields', 3, 1),
(4, 'Register Date', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'registerDate', '', 'Joomla', 4, 1),
(5, 'Username', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=1\n\n', 'username', '', 'Joomla', 5, 1),
(6, 'Name', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'name', '', 'Joomla', 6, 1),
(8, 'Birthday', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '3', '', 'Jsfields', 8, 1);;


TRUNCATE TABLE `#__xius_list`;;
ALTER TABLE `#__xius_list` AUTO_INCREMENT=1;;


INSERT INTO `#__xius_list` (`id`, `owner`, `name`, `visibleinfo`, `sortinfo`, `sortdir`, `join`, `conditions`, `published`, `ordering`, `description`, `params`) VALUES
(1, 62, 'Male From Afghanistan', '', '8', 'ASC', 'AND', 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:4:"Male";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:11:"Afghanistan";s:8:"operator";s:1:"=";}}', 1, 4, '<p>All Male From Afghanistan</p>', 'xipt_privacy=a:2:{i:0;s:1:"1";i:1;s:1:"4";}\nxiusListViewGroup=a:1:{i:0;s:3:"All";}\njs_privacy=member\n\n'),
(2, 62, 'Register Date is 16-01-2010', '', '3', 'ASC', 'AND', 'a:1:{i:0;a:3:{s:6:"infoid";s:1:"4";s:5:"value";s:10:"16-01-2010";s:8:"operator";s:1:"=";}}', 1, 2, '<p>All members whose registeration date is 16 Jan 2010</p>', 'xipt_privacy=a:1:{i:0;s:1:"1";}\nxiusListViewGroup=a:1:{i:0;s:3:"All";}\njs_privacy=member\n\n'),
(3, 62, 'All female From Afghanistan', '', '8', 'ASC', 'AND', 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:11:"Afghanistan";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:6:"Female";s:8:"operator";s:1:"=";}}', 1, 2, '<p>All Female from afghanistan</p>', 'xipt_privacy=a:1:{i:0;s:1:"3";}\nxiusListViewGroup=a:1:{i:0;s:3:"All";}\njs_privacy=member\n\n'),
(4, 62, 'All Amrican female', '', '1', 'ASC', 'AND', 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:14:"American Samoa";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:6:"Female";s:8:"operator";s:1:"=";}}', 1, 3, '<p>female</p>', 'xipt_privacy=a:1:{i:0;s:1:"2";}\nxiusListViewGroup=a:1:{i:0;s:3:"All";}\njs_privacy=member\n\n'),
(5, 62, 'All user', '', '1', 'ASC', 'AND', 'a:0:{}', 1, 4, '', 'xipt_privacy=a:1:{i:0;s:1:"0";}\nxiusListViewGroup=a:1:{i:0;s:3:"All";}\njs_privacy=public\n\n');;


