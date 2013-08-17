TRUNCATE TABLE `#__xius_list`;;
ALTER TABLE `#__xius_list` AUTO_INCREMENT=1;;

DROP TABLE IF EXISTS `au_#__xius_list`;;
CREATE TABLE `au_#__xius_list` SELECT * FROM `#__xius_list`;;
INSERT INTO `au_#__xius_list` (`id`, `owner`, `name`, `visibleinfo`, `sortinfo`, `sortdir`, `join`, `conditions`, `published`, `ordering`, `description`, `params`) VALUES
(1, 62, 'Male from Afghanistan', '', '8', 'ASC', 'AND', 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:4:"Male";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:11:"Afghanistan";s:8:"operator";s:1:"=";}}', 1, 0, 'All Male from Afghanistan', 'xiusListViewGroup="a:2:{i:0;s:6:"Editor";i:1;s:7:"Manager";}"'),
(2, 62, 'Register Date is 16-01-2010', '', '3', 'ASC', 'AND', 'a:1:{i:0;a:3:{s:6:"infoid";s:1:"4";s:5:"value";s:10:"16-01-2010";s:8:"operator";s:1:"=";}}', 1, 2, 'All members whose registeration date is 16 Jan 2010', 'xiusListViewGroup="a:2:{i:0;s:7:"Manager";i:1;s:19:"Super Administrator";}"'),
(3, 62, 'Male Users', '', '2', 'DESC', 'OR', 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:4:"Male";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:11:"Afghanistan";s:8:"operator";s:1:"=";}}', 1, 2, 'Show Male Users', 'js_privacy="friend"');;

INSERT INTO `#__xius_list` (`id`, `owner`, `name`, `visibleinfo`, `sortinfo`, `sortdir`, `join`, `conditions`, `published`, `ordering`, `description`, `params`) VALUES
(1, 62, 'Male from Afghanistan', '', '8', 'ASC', 'AND', 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:4:"Male";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:11:"Afghanistan";s:8:"operator";s:1:"=";}}', 1, 0, 'All Male from Afghanistan', 'xiusListViewGroup="a:2:{i:0;s:6:"Editor";i:1;s:7:"Manager";}"'),
(2, 62, 'Register Date is 16-01-2010', '', '3', 'ASC', 'AND', 'a:1:{i:0;a:3:{s:6:"infoid";s:1:"4";s:5:"value";s:10:"16-01-2010";s:8:"operator";s:1:"=";}}', 1, 2, 'All members whose registeration date is 16 Jan 2010', 'xiusListViewGroup="a:2:{i:0;s:7:"Manager";i:1;s:19:"Super Administrator";}"');;
