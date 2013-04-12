TRUNCATE TABLE `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'userid', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'userid', '', 'Jsuser', 1, 1),
(2, 'status', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'status', '', 'Jsuser', 2, 1),
(3, 'Country', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '12', '', 'Jsfields', 3, 1),
(4, 'Register Date', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'registerDate', '', 'Joomla', 4, 1),
(5, 'Username', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=1\n\n', 'username', '', 'Joomla', 5, 1),
(6, 'Name', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'name', '', 'Joomla', 6, 1),
(7, 'Checkbox1', 'isSearchable=1\nisVisible=0\nisSortable=0\nisExportable=1\n\n', '17', '', 'Jsfields', 7, 1),
(8, 'Birthday', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '3', '', 'Jsfields', 8, 1),
(9, 'profile_id', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\n\n', 'profile_id', '', 'Jsuser', 9, 1),
(10, 'avatar', 'isSearchable="1"\nisVisible="0"\nisSortable="1"\nisAccessible="a:1:{i:0;s:3:"All";}"\nisExportable="0"\ntooltip=""\njs_privacy="public"', 'avatar', '', 'Jsuser', 10, 1);;

TRUNCATE TABLE `#__xipt_profiletypes`;; 

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'Dummy1', 1, 1, '', 'jsPrivacyController=1\nprivacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nprivacyVideoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'images/profiletype/avatar_1.jpg', 0, 0, '0', 'images/profiletype/watermark_1.png', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=0\n\n', 1, 'jspt_restrict_reg_check=0\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'Dummy2', 2, 1, '', 'jsPrivacyController=1\nprivacyProfileView=30\nprivacyFriendsView=0\nprivacyPhotoView=0\nprivacyVideoView=0\nnotifyEmailSystem=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 'default', 'Registered', 'images/profiletype/avatar_2.jpg', 0, 0, '0', 'images/profiletype/watermark_2.png', '', 'enableWaterMark=0\nxiText=P\nxiWidth=40\nxiHeight=40\nxiThumbWidth=20\nxiThumbHeight=20\nxiFontName=monofont\nxiFontSize=26\nxiTextColor=FFFFFF\nxiBackgroundColor=9CD052\nxiWatermarkPosition=tl\ndemo=0\n\n', 1, 'jspt_restrict_reg_check=0\njspt_prevent_username=moderator; admin; support; owner; employee\njspt_allowed_email=\njspt_prevent_email=\n\n');;



DROP TABLE IF EXISTS `#__xius_cache`;;
CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `jsuseruserid_0` int(21) NOT NULL,
  `jsuserstatus_0` varchar(250) NOT NULL,
  `jsfields12_0` varchar(250) NOT NULL,
  `joomlaregisterDate_0` datetime NOT NULL,
  `joomlausername_0` varchar(250) NOT NULL,
  `joomlaname_0` varchar(250) NOT NULL,
  `jsfields17_0` varchar(250) NOT NULL,
  `jsfields3_0` datetime NOT NULL,
  `jsuserprofile_id_0` varchar(250) NOT NULL,
  `jsuseravatar_0` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;;


INSERT INTO `#__xius_cache` (`userid`, `jsuseruserid_0`, `jsuserstatus_0`, `jsfields12_0`, `joomlaregisterDate_0`, `joomlausername_0`, `joomlaname_0`, `jsfields17_0`, `jsfields3_0`, `jsuserprofile_id_0`, `jsuseravatar_0`) VALUES
(62, 62, '', '', '2011-03-03 06:53:07', 'admin', 'Super User', '2', '0000-00-00 00:00:00', '0', 1),
(63, 63, '', '', '2011-03-03 07:14:21', 'user-1', 'user-1', '1', '0000-00-00 00:00:00', '0', 1),
(64, 64, '', '', '2011-03-03 07:15:13', 'user-2', 'user-2', '1', '0000-00-00 00:00:00', '0', 1),
(65, 65, '', '', '2011-03-03 07:16:37', 'user-3', 'user-3', '1', '0000-00-00 00:00:00', '0', 1),
(66, 66, '', '', '2011-03-03 07:17:30', 'user-4', 'user-4', '1', '0000-00-00 00:00:00', '0', 1),
(67, 67, '', '', '2011-03-03 07:18:17', 'user-5', 'user-5', '1', '0000-00-00 00:00:00', '0', 1),
(68, 68, '', '', '2011-03-03 07:19:17', 'user-6', 'user-6', '1', '1999-01-01 23:59:59', '0', 1),
(69, 69, '', '', '2011-08-10 04:25:55', 'rimjhim', 'Rimjhim', '1', '0000-00-00 00:00:00', '0', 0),
(70, 70, '', '', '2011-08-11 07:02:34', 'john', 'john', '1', '0000-00-00 00:00:00', '0', 0);;

TRUNCATE TABLE `#__community_users`;;

INSERT INTO `#__community_users` (`userid`, `status`, `status_access`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friends`, `groups`, `friendcount`, `alias`, `latitude`, `longitude`, `profile_id`, `storage`, `watermark_hash`, `search_email`) VALUES
(62, '', 0, 1, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.jpg', 'images/profiletype/avatar_2_thumb.jpg', 0, '{"notifyEmailSystem":"1","privacyProfileView":"30","privacyPhotoView":"0","privacyFriendsView":"0","privacyGroupsView":"","privacyVideoView":"0","notifyEmailMessage":1,"notifyEmailApps":"1","notifyWallComment":"0"}', 0, '', '', 0, '', 19.0176, 72.8561, 0, 'file', '', 1),
(69, '', 0, 0, '0000-00-00 00:00:00', 'images/avatar/a37d233140b6bf4101ffa874.jpg', 'images/avatar/thumb_a37d233140b6bf4101ffa874.jpg', 0, '{"notifyEmailSystem":"1","privacyProfileView":"30","privacyPhotoView":"0","privacyFriendsView":"0","privacyGroupsView":"","privacyVideoView":"0","notifyEmailMessage":1,"notifyEmailApps":"1","notifyWallComment":"0"}', 0, '', '', 0, '', 255, 255, 0, 'file', '', 1),
(68, '', 0, 0, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.jpg', 'images/profiletype/avatar_1_thumb.jpg', 0, '{"notifyEmailSystem":"1","privacyProfileView":"30","privacyPhotoView":"0","privacyFriendsView":"0","privacyGroupsView":"","privacyVideoView":"0","notifyEmailMessage":1,"notifyEmailApps":"1","notifyWallComment":"0"}', 0, '', '', 0, '', 255, 255, 0, 'file', '', 1),
(67, '', 0, 0, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.jpg', 'images/profiletype/avatar_1_thumb.jpg', 0, '{"notifyEmailSystem":"1","privacyProfileView":"30","privacyPhotoView":"0","privacyFriendsView":"0","privacyGroupsView":"","privacyVideoView":"0","notifyEmailMessage":1,"notifyEmailApps":"1","notifyWallComment":"0"}', 0, '', '', 0, '', 255, 255, 0, 'file', '', 1),
(66, '', 0, 0, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.jpg', 'images/profiletype/avatar_1_thumb.jpg', 0, '{"notifyEmailSystem":"1","privacyProfileView":"30","privacyPhotoView":"0","privacyFriendsView":"0","privacyGroupsView":"","privacyVideoView":"0","notifyEmailMessage":1,"notifyEmailApps":"1","notifyWallComment":"0"}', 0, '', '', 0, '', 255, 255, 0, 'file', '', 1),
(65, '', 0, 0, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.jpg', 'images/profiletype/avatar_1_thumb.jpg', 0, '{"notifyEmailSystem":"1","privacyProfileView":"30","privacyPhotoView":"0","privacyFriendsView":"0","privacyGroupsView":"","privacyVideoView":"0","notifyEmailMessage":1,"notifyEmailApps":"1","notifyWallComment":"0"}', 0, '', '', 0, '', 255, 255, 0, 'file', '', 1),
(64, '', 0, 0, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.jpg', 'images/profiletype/avatar_1_thumb.jpg', 0, '{"notifyEmailSystem":"1","privacyProfileView":"30","privacyPhotoView":"0","privacyFriendsView":"0","privacyGroupsView":"","privacyVideoView":"0","notifyEmailMessage":1,"notifyEmailApps":"1","notifyWallComment":"0"}', 0, '', '', 0, '', 255, 255, 0, 'file', '', 1),
(63, '', 0, 0, '0000-00-00 00:00:00', 'images/profiletype/avatar_1.jpg', 'images/profiletype/avatar_1_thumb.jpg', 0, '{"notifyEmailSystem":"1","privacyProfileView":"30","privacyPhotoView":"0","privacyFriendsView":"0","privacyGroupsView":"","privacyVideoView":"0","notifyEmailMessage":1,"notifyEmailApps":"1","notifyWallComment":"0"}', 0, '', '', 0, '', 255, 255, 0, 'file', '', 1),
(70, '', 0, 0, '0000-00-00 00:00:00', 'images/avatar/6dad755330e68a377b15cf95.jpg', 'images/avatar/thumb_6dad755330e68a377b15cf95.jpg', 0, '{"notifyEmailSystem":"1","privacyProfileView":"30","privacyPhotoView":"0","privacyFriendsView":"0","privacyGroupsView":"","privacyVideoView":"0","notifyEmailMessage":1,"notifyEmailApps":"1","notifyWallComment":"0"}', 0, '', '', 0, '', 255, 255, 0, 'file', '', 1);;

