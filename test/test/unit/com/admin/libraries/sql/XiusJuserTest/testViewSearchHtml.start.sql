TRUNCATE TABLE `#__xius_info`;;
TRUNCATE TABLE `#__community_profiles`;;
ALTER TABLE `#__xius_info` AUTO_INCREMENT=1;;

INSERT INTO `#__community_profiles` (`id`, `name`, `description`, `approvals`, `published`, `avatar`, `watermark`, `watermark_hash`, `watermark_location`, `thumb`, `create_groups`, `ordering`) VALUES
(1, 'Male', '', 0, 1, '', '', '', '', '', 0, 1),
(2, 'Female', '', 0, 1, '', '', '', '', '', 0, 2);;

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




