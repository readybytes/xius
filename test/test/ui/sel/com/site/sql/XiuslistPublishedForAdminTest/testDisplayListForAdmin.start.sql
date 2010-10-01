TRUNCATE TABLE `#__xius_info` ;;


INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', 'isVisible=1\nisSortable=1\n\n', '2', '', 'Jsfields', 1, 1),
(2, 'City', 'isSearchable=0\nisVisible=1\nisSortable=1\n\n', '11', '', 'Jsfields', 2, 1),
(3, 'Country', 'isVisible=0\nisSortable=1\n\n', '12', '', 'Jsfields', 3, 1),
(4, 'Register Date', 'isVisible=0\nisSortable=1\n\n', 'registerDate', '', 'Joomla', 4, 1),
(5, 'Username', 'isVisible=0\nisSortable=1\n\n', 'username', '', 'Joomla', 5, 1),
(6, 'State', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '10', '', 'Jsfields', 6, 1);;

TRUNCATE TABLE `#__xius_list` ;;

INSERT INTO `#__xius_list` (`id`, `owner`, `name`, `visibleinfo`, `sortinfo`, `sortdir`, `join`, `conditions`, `published`, `ordering`, `description`, `params`) VALUES
(1, 62, 'some list', '', '3', 'ASC', 'OR', 'a:4:{i:0;a:3:{s:6:"infoid";s:2:"10";s:5:"value";a:4:{i:0;s:9:"28.635308";i:1;s:8:"77.22496";i:2;s:2:"10";i:3;s:5:"miles";}s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:6:"Female";s:8:"operator";s:1:"=";}i:2;a:3:{s:6:"infoid";s:2:"10";s:5:"value";a:6:{i:0;s:10:"addressbox";i:1;s:8:"bhilwara";i:2;s:9:"28.635308";i:3;s:8:"77.22496";i:4;s:2:"10";i:5;s:5:"miles";}s:8:"operator";s:1:"=";}i:3;a:3:{s:6:"infoid";s:1:"4";s:5:"value";s:10:"05-03-2009";s:8:"operator";s:1:"=";}}', 0, 0, '', 'js_privacy=public\nxiusListViewGroup=a:1:{i:0;s:3:"All";}\n\n'),
(2, 62, 'Private list', '', '3', 'ASC', 'OR', 'a:3:{i:0;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:4:"Male";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:11:"Afghanistan";s:8:"operator";s:1:"=";}i:2;a:3:{s:6:"infoid";s:1:"4";s:5:"value";s:10:"05-03-2009";s:8:"operator";s:1:"=";}}', 0, 1, '', 'js_privacy=public\n\n');;

