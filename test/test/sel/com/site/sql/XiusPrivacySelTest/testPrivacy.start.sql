TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@joomlaxi.com', 'aa95a2cb1a9bd63f349a7fb72502489c:IXZhjkhVI11TgPm5YIVeHNcJTH8HbIKs', 'Super Administrator', 0, 1, 25, '2010-01-16 11:12:08', '2010-08-05 11:38:21', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(63, 'name64', 'username64', 'username64@email.com', '57048e7e51be27d034ad468671229b86:Fzk4eZv9djbjLoqnjRX49t5GERYcY5Fx', 'Registered', 0, 0, 18, '2010-05-20 10:31:50', '2011-04-20 10:18:34', '', 'language=\ntimezone=0\n\n'),
(64, 'name65', 'username65', 'username65@email.com', 'c6760cbc8fbb0d3b330cda62f14d4df8:6xApyV7UoTXhZFvW6d9jLT9N4A8WlaQL', 'Manager', 0, 0, 23, '2010-05-20 10:32:10', '2011-04-20 10:18:38', '', 'language=\ntimezone=0\nadmin_language=\neditor=\nhelpsite=\n\n'),
(65, 'name66', 'username66', 'username66@email.com', 'a8fe0feb870e88548181583c41024e4e:saL5B5BG20caRLo60ynhCKbAZw8WIWtn', 'Administrator', 0, 0, 24, '2010-05-20 10:32:10', '0000-00-00 00:00:00', '', 'language=\ntimezone=0\nadmin_language=\neditor=\nhelpsite=\n\n'),
(66, 'name67', 'username67', 'username67@email.com', '10aaf84f6822970768033aed4c6c5ad7:Y33vW30BKxxKJgguIKxhOMazhh2j9GlT', 'Editor', 0, 0, 20, '2010-05-20 10:32:10', '0000-00-00 00:00:00', '', 'language=\ntimezone=0\nadmin_language=\neditor=\nhelpsite=\n\n'),
(67, 'name68', 'username68', 'username68@email.com', '63b3c955bf392b75648c6ef504d377e6:ngmtwZt85QNej2f0qnMxEYCLzkcTTN3n', 'Publisher', 0, 0, 21, '2010-05-20 10:32:10', '0000-00-00 00:00:00', '', 'language=\ntimezone=0\nadmin_language=\neditor=\nhelpsite=\n\n'),
(68, 'name69', 'username69', 'username69@email.com', 'f1272d04850d66ac8f02081443af7e64:iCQx3wHAXABo5fs1IlR5gYMUYINmCwQk', 'Author', 0, 0, 19, '2010-05-20 10:32:10', '0000-00-00 00:00:00', '', 'language=\ntimezone=0\neditor=\nhelpsite=\n\n');;

TRUNCATE TABLE `#__core_acl_aro`;;
INSERT INTO `#__core_acl_aro`  (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(11, 'users', '63', 0, 'name64', 0),
(12, 'users', '64', 0, 'name65', 0),
(13, 'users', '65', 0, 'name66', 0),
(14, 'users', '66', 0, 'name67', 0),
(15, 'users', '67', 0, 'name68', 0),
(16, 'users', '68', 0, 'name69', 0);;


TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`) VALUES
(63, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=20\nprivacyFriendsView=20\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\n\n', 0, -1),
(64, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=20\nprivacyFriendsView=20\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\n\n', 0, 0),
(65, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=20\nprivacyFriendsView=20\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\n\n', 0, 0),
(66, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=20\nprivacyFriendsView=20\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\n\n', 0, 0),
(67, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=20\nprivacyFriendsView=20\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\n\n', 0, 0),
(68, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=20\nprivacyFriendsView=20\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\n\n', 0, 0),
(69, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=20\nprivacyFriendsView=20\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\n\n', 0, 0),
(62, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=20\nprivacyFriendsView=20\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\n', 4, 0);;


TRUNCATE TABLE `#__community_fields`;;
INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `options`, `fieldcode`, `registration`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basic information for user', 1, 1, 1, '', '', 1),
(2, 'select', 2, 1, 10, 100, 'Gender', 'Select gender', 1, 1, 1, 'Male\nFemale', 'FIELD_GENDER', 1),
(3, 'date', 3, 1, 10, 100, 'Birthday', 'Enter your date of birth so other users can know when to wish you happy birthday ', 1, 1, 1, '', 'FIELD_BIRTHDAY', 1),
(4, 'text', 4, 1, 5, 250, 'Hometown', 'Hometown', 1, 1, 1, '', 'FIELD_HOMETOWN', 1),
(5, 'textarea', 5, 1, 1, 800, 'About me', 'Tell us more about yourself', 1, 1, 1, '', 'FIELD_ABOUTME', 1),
(6, 'group', 6, 1, 10, 100, 'Contact Information', 'Specify your contact details', 1, 1, 1, '', '', 1),
(7, 'text', 7, 1, 10, 100, 'Mobile phone', 'Mobile carrier number that other users can contact you.', 1, 0, 1, '', 'FIELD_MOBILE', 1),
(8, 'text', 8, 1, 10, 100, 'Land phone', 'Contact number that other users can contact you.', 1, 0, 1, '', 'FIELD_LANDPHONE', 1),
(9, 'textarea', 9, 1, 10, 100, 'Address', 'Address', 1, 1, 1, '', 'FIELD_ADDRESS', 1),
(10, 'text', 10, 1, 10, 100, 'State', 'State', 1, 1, 1, '', 'FIELD_STATE', 1),
(11, 'text', 11, 1, 10, 100, 'City / Town', 'City / Town', 1, 1, 1, '', 'FIELD_CITY', 1),
(12, 'select', 12, 1, 10, 100, 'Country', 'Country', 1, 1, 1, 'Afghanistan\nAlbania\nAlgeria\nAmerican Samoa\nAndorra\nAngola\nAnguilla\nAntarctica\nAntigua and Barbuda\nArgentina\nArmenia\nAruba\nIndia', 'FIELD_COUNTRY', 1),
(13, 'text', 13, 1, 10, 100, 'Website', 'Website', 1, 1, 1, '', 'FIELD_WEBSITE', 1),
(14, 'group', 14, 1, 10, 100, 'Education', 'Educations', 1, 1, 1, '', '', 1),
(15, 'text', 15, 1, 10, 200, 'College / University', 'College / University', 1, 1, 1, '', 'FIELD_COLLEGE', 1),
(16, 'text', 16, 1, 5, 100, 'Graduation Year', 'Graduation year', 1, 1, 1, '', 'FIELD_GRADUATION', 1),
(17, 'checkbox', 2, 1, 10, 100, 'Checkbox1', 'Checkbox1', 1, 1, 1, 'Checkbox1\nCheckbox11\nCheckbox2\nCheckbox21\nCheckbox', 'Checkbox1', 1);;


TRUNCATE TABLE `#__community_fields_values`;;
INSERT INTO `#__community_fields_values` (`id`, `user_id`, `field_id`, `value`) VALUES
(21322, 69, 12, 'India'),
(21321, 69, 11, 'Shimla'),
(21320, 69, 10, 'Himachal Pradesh'),
(21316, 69, 4, 'Shimla'),
(21308, 68, 7, '986750501'),
(21309, 68, 8, '1250235170'),
(21310, 68, 9, 'Noida'),
(21311, 68, 10, 'Uttar Pradesh'),
(21312, 68, 11, 'Noida'),
(21313, 68, 12, 'India'),
(21314, 69, 2, 'Female'),
(21315, 69, 3, '1992-9-21 23:59:59'),
(21304, 67, 12, 'India'),
(21303, 67, 11, 'Indore'),
(21302, 67, 10, 'Madhya Pradesh'),
(21301, 67, 9, 'Indore'),
(21300, 67, 8, '1191652949'),
(21299, 67, 7, '420395176'),
(21298, 67, 4, 'Indore'),
(21297, 67, 3, '1993-6-20 23:59:59'),
(21296, 67, 2, 'Male'),
(21295, 66, 12, 'India'),
(21294, 66, 11, 'Chandigarh'),
(21293, 66, 10, 'Punjab'),
(21292, 66, 9, 'Chandigarh'),
(21291, 66, 8, '1348999261'),
(21290, 66, 7, '1122361707'),
(21289, 66, 4, 'Chandigarh'),
(21288, 66, 3, '1994-9-22 23:59:59'),
(21287, 66, 2, 'Male'),
(21286, 65, 12, 'India'),
(21285, 65, 11, 'Ludhiana'),
(21284, 65, 10, 'Punjab'),
(21283, 65, 9, 'Ludhiana'),
(21282, 65, 8, '1156881164'),
(21281, 65, 7, '1373346876'),
(21280, 65, 4, 'Ludhiana'),
(21279, 65, 3, '1992-2-9 23:59:59'),
(21278, 65, 2, 'Female'),
(21269, 64, 2, 'Female'),
(21270, 64, 3, '2000-12-25 23:59:59'),
(21271, 64, 4, 'Surat'),
(21272, 64, 7, '61096620'),
(21273, 64, 8, '1299648940'),
(21274, 64, 9, 'Surat'),
(21275, 64, 10, 'Gujrat'),
(21276, 64, 11, 'Surat'),
(21277, 64, 12, 'India'),
(3207, 62, 21, 'Free Member'),
(13737, 62, 28, 'default'),
(13738, 62, 29, '1'),
(21305, 68, 2, 'Female'),
(21306, 68, 3, '1994-5-21 23:59:59'),
(21307, 68, 4, 'Noida'),
(21317, 69, 7, '750084835'),
(21318, 69, 8, '1398099937'),
(21319, 69, 9, 'Shimla'),
(21802, 62, 2, ''),
(21803, 62, 17, ''),
(21804, 62, 3, ''),
(21805, 62, 4, ''),
(21806, 62, 5, ''),
(21807, 62, 7, ''),
(21808, 62, 8, ''),
(21809, 62, 9, ''),
(21810, 62, 10, 'Rajasthan'),
(21811, 62, 11, 'Bhilwara'),
(21812, 62, 12, 'India'),
(21813, 62, 13, ''),
(21814, 62, 15, ''),
(21815, 62, 16, ''),
(21896, 63, 2, ''),
(21897, 63, 17, ''),
(21898, 63, 3, ''),
(21899, 63, 4, ''),
(21900, 63, 5, ''),
(21901, 63, 7, ''),
(21902, 63, 8, ''),
(21903, 63, 9, ''),
(21904, 63, 10, 'Rajasthan'),
(21905, 63, 11, 'Ajmer'),
(21906, 63, 12, 'India'),
(21907, 63, 13, ''),
(21908, 63, 15, ''),
(21909, 63, 16, ''),
(21910, 64, 17, ''),
(21911, 64, 5, ''),
(21912, 64, 13, ''),
(21913, 64, 15, ''),
(21914, 64, 16, ''),
(21915, 65, 17, ''),
(21916, 65, 5, ''),
(21917, 65, 13, ''),
(21918, 65, 15, ''),
(21919, 65, 16, ''),
(21920, 66, 17, ''),
(21921, 66, 5, ''),
(21922, 66, 13, ''),
(21923, 66, 15, ''),
(21924, 66, 16, ''),
(21925, 67, 17, ''),
(21926, 67, 5, ''),
(21927, 67, 13, ''),
(21928, 67, 15, ''),
(21929, 67, 16, ''),
(21930, 68, 17, ''),
(21931, 68, 5, ''),
(21932, 68, 13, ''),
(21933, 68, 15, ''),
(21934, 68, 16, ''),
(21935, 69, 17, ''),
(21936, 69, 5, ''),
(21937, 69, 13, ''),
(21938, 69, 15, ''),
(21939, 69, 16, '');;

TRUNCATE TABLE `#__xius_info`;;
INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(17, 'Xius State', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', '10', '', 'Jsfields', 1, 1),
(18, 'Xius Country', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', '12', '', 'Jsfields', 2, 1),
(19, 'Xius City / Town', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '11', '', 'Jsfields', 3, 1),
(21, 'Xius Gender', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:3:{i:0;s:2:"18";i:1;s:2:"21";i:2;s:2:"25";}\nisExportable=0\ntooltip=\n\n', '2', '', 'Jsfields', 4, 1),
(22, 'Xius Birthday', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:3:{i:0;s:2:"19";i:1;s:2:"23";i:2;s:10:"Guest Only";}\nisExportable=0\ntooltip=\n\n', '3', '', 'Jsfields', 5, 1),
(23, 'Xius Age', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:2:{i:0;s:2:"18";i:1;s:2:"21";}\nisExportable=0\ntooltip=\n\n', '22', 'rangesearchType=date\n\n', 'Rangesearch', 6, 1);;

DROP TABLE IF EXISTS `#__xius_cache`;;
CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `jsfields10_0` varchar(250) NOT NULL,
  `jsfields12_0` varchar(250) NOT NULL,
  `jsfields11_0` varchar(250) NOT NULL,
  `jsfields2_0` varchar(250) NOT NULL,
  `jsfields3_0` datetime NOT NULL,
  `rangesearch22_0` int(31) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;

--
-- Dumping data for table `j999_xius_cache`
--

INSERT INTO `#__xius_cache` (`userid`, `jsfields10_0`, `jsfields12_0`, `jsfields11_0`, `jsfields2_0`, `jsfields3_0`, `rangesearch22_0`) VALUES
(62, 'Rajasthan', 'India', 'Bhilwara', '', '0000-00-00 00:00:00', 0),
(63, 'Rajasthan', 'India', 'Ajmer', '', '0000-00-00 00:00:00', 0),
(64, 'Gujrat', 'India', 'Surat', 'Female', '2000-12-25 23:59:59', 10),
(65, 'Punjab', 'India', 'Ludhiana', 'Female', '1992-02-09 23:59:59', 18),
(66, 'Punjab', 'India', 'Chandigarh', 'Male', '1994-09-22 23:59:59', 16),
(67, 'Madhya Pradesh', 'India', 'Indore', 'Male', '1993-06-20 23:59:59', 17),
(68, 'Uttar Pradesh', 'India', 'Noida', 'Female', '1994-05-21 23:59:59', 16);;

TRUNCATE TABLE `#__core_acl_groups_aro_map`;;
INSERT INTO `#__core_acl_groups_aro_map`  (`group_id`, `section_value`, `aro_id`) VALUES
(18, '', 11),
(19, '', 16),
(20, '', 14),
(21, '', 15),
(23, '', 12),
(24, '', 13),
(25, '', 10);;


