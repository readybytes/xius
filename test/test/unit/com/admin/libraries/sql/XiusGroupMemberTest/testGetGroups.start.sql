
-- Drop Old Back-up Table
DROP TABLE IF EXISTS `bk_#__community_groups`;;

-- Creat Back-up table
CREATE TABLE IF NOT EXISTS `bk_#__community_groups` 
	SELECT * FROM `#__community_groups`;;

-- Truncate Old Table
TRUNCATE TABLE `#__community_groups`;;

-- Data insert
INSERT INTO `#__community_groups` (`id`, `published`, `ownerid`, `categoryid`, `name`, `description`, `email`, `website`, `approvals`, `created`, `avatar`, `thumb`, `discusscount`, `wallcount`, `membercount`, `params`) VALUES
(16, 1, 62, 8, 'Lufange-Parinde', 'All Crazy Guyzzzzzzz', '', '', 0, '2011-01-25 14:56:06', '', '', 0, 0, 0, 'discussordering=0\nphotopermission=0\nvideopermission=1\ngrouprecentphotos=6\ngrouprecentvideos=6\nnewmembernotification=1\njoinrequestnotification=1\nwallnotification=1\n\n'),
(13, 1, 62, 6, 'XiPT', 'RBSL Product', '', '', 0, '2011-01-25 14:54:59', '', '', 0, 0, 0, 'discussordering=0\nphotopermission=0\nvideopermission=1\ngrouprecentphotos=6\ngrouprecentvideos=6\nnewmembernotification=1\njoinrequestnotification=1\nwallnotification=1\n\n'),
(14, 1, 62, 7, 'Joomlaxi', 'Company', '', '', 0, '2011-01-25 14:55:15', '', '', 0, 0, 0, 'discussordering=0\nphotopermission=0\nvideopermission=1\ngrouprecentphotos=6\ngrouprecentvideos=6\nnewmembernotification=1\njoinrequestnotification=1\nwallnotification=1\n\n'),
(15, 1, 62, 6, 'XiEC', 'RBSL Product', '', '', 0, '2011-01-25 14:55:27', '', '', 0, 0, 0, 'discussordering=0\nphotopermission=0\nvideopermission=1\ngrouprecentphotos=6\ngrouprecentvideos=6\nnewmembernotification=1\njoinrequestnotification=1\nwallnotification=1\n\n'),
(12, 1, 62, 6, 'XiUS', 'RBSL Product', '', '', 0, '2011-01-25 14:54:48', '', '', 0, 0, 0, 'discussordering=0\nphotopermission=0\nvideopermission=1\ngrouprecentphotos=6\ngrouprecentvideos=6\nnewmembernotification=1\njoinrequestnotification=1\nwallnotification=1\n\n'),
(9, 1, 62, 8, 'Joomla_lover', 'Manish love to Joomla', '', '', 0, '2011-01-25 14:53:25', '', '', 0, 0, 0, 'discussordering=0\nphotopermission=0\nvideopermission=1\ngrouprecentphotos=6\ngrouprecentvideos=6\nnewmembernotification=1\njoinrequestnotification=1\nwallnotification=1\n\n'),
(10, 1, 62, 6, 'RBSL Customer', 'Which have RBSL Product', '', '', 0, '2011-01-25 14:53:54', '', '', 0, 0, 0, 'discussordering=0\nphotopermission=0\nvideopermission=1\ngrouprecentphotos=6\ngrouprecentvideos=6\nnewmembernotification=1\njoinrequestnotification=1\nwallnotification=1\n\n'),
(11, 1, 62, 7, 'RBSL', 'All RBSL member', '', '', 0, '2011-01-25 14:54:22', '', '', 0, 0, 0, 'discussordering=0\nphotopermission=0\nvideopermission=1\ngrouprecentphotos=6\ngrouprecentvideos=6\nnewmembernotification=1\njoinrequestnotification=1\nwallnotification=1\n\n');;
