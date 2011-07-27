TRUNCATE TABLE `#__community_profiles`;;
TRUNCATE TABLE `#__xius_info`;;

INSERT INTO `#__community_profiles` (`id`, `name`, `description`, `approvals`, `published`, `avatar`, `watermark`, `watermark_hash`, `watermark_location`, `thumb`, `create_groups`, `ordering`) VALUES
(1, 'Male', '', 0, 1, '', '', '', '', '', 0, 1),
(2, 'Female', '', 0, 1, '', '', '', '', '', 0, 2);;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(9, 'profile_id', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\n\n', 'profile_id', '', 'Jsuser', 9, 1);;

