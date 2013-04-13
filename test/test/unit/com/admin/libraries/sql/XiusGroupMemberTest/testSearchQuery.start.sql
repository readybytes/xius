

-- Truncate Old Table
TRUNCATE TABLE `#__community_groups`;;
TRUNCATE TABLE `#__xius_info`;;
TRUNCATE TABLE`#__community_users`;;
TRUNCATE TABLE `#__community_groups_members`;;
TRUNCATE TABLE `#__community_groups_category`;;

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



INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '2', '', 'Jsfields', 1, 1),
(2, 'Latitude', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'latitude', '', 'Jsuser', 2, 0),
(3, 'Longitude', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'longitude', '', 'Jsuser', 3, 0),
(4, 'By Information', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'information', 'xius_proximity_latitude=2\nxius_proximity_longitude=3\nxius_default_location=none\nxiusProximityDefaultLat=28.635308\nxiusProximityDefaultLong=77.22496\nxiusDefaultDistance=10\nxiusDefaultDistanceUnit=miles\nxiusProximityGmapZoom=2\n\n', 'Proximity', 4, 1),
(5, 'Birthday', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '3', '', 'Jsfields', 5, 1),
(6, 'Age-Range', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '5', 'rangesearchType=date\n\n', 'Rangesearch', 6, 1),
(7, ' User Status', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'onlineuser', '', 'Onlineuser', 7, 1),
(8, 'Group Memeber''s', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'groupmember', '', 'Groupmember', 8, 1);;

INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`, `alias`, `latitude`, `longitude`) VALUES
(70, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=40\nprivacyFriendsView=30\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=0\nnotifyWallComment=0\n', 0, 0, '', 255, 255),
(69, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=40\nprivacyFriendsView=30\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=0\nnotifyWallComment=0\n', 0, 0, '', 255, 255),
(68, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=40\nprivacyFriendsView=30\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=0\nnotifyWallComment=0\n', 0, 0, '', 255, 255),
(67, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=40\nprivacyFriendsView=30\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=0\nnotifyWallComment=0\n', 0, 0, '', 255, 255),
(66, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=40\nprivacyFriendsView=30\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=0\nnotifyWallComment=0\n', 0, 0, '', 255, 255),
(65, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=40\nprivacyFriendsView=30\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=0\nnotifyWallComment=0\n', 0, 0, '', 255, 255),
(64, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=40\nprivacyFriendsView=30\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=0\nnotifyWallComment=0\n', 0, 0, '', 255, 255),
(63, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=40\nprivacyFriendsView=30\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=0\nnotifyWallComment=0\n', 0, 0, '', 255, 255),
(62, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=40\nprivacyFriendsView=30\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=0\nnotifyWallComment=0\n', 0, 0, '', 255, 255);;

INSERT INTO `#__community_groups_members` (`groupid`, `memberid`, `approved`, `permissions`) VALUES
(10, 62, 1, 1),
(9, 62, 1, 1),
(11, 62, 1, 1),
(12, 62, 1, 1),
(13, 62, 1, 1),
(14, 62, 1, 1),
(15, 62, 1, 1),
(16, 62, 1, 1),
(16, 63, 1, 0),
(9, 63, 1, 0),
(15, 70, 1, 0),
(12, 70, 1, 0),
(11, 70, 1, 0),
(16, 70, 1, 0),
(13, 70, 1, 0),
(16, 64, 1, 0),
(10, 64, 1, 0),
(9, 64, 1, 0),
(16, 67, 1, 0),
(14, 67, 1, 0),
(11, 67, 1, 0),
(9, 67, 1, 0);;

INSERT INTO `#__community_groups_category` (`id`, `name`, `description`) VALUES
(6, 'Products', 'All groups are dedicated to some products'),
(7, 'Company', 'RBSL Sub_Company'),
(8, 'Social', '');;


