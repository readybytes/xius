TRUNCATE TABLE `#__xius_info`;;
INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(23, 'Send Email', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'Email', 'xius_email=21\n\n', 'Xiusemail', 3, 1),
(21, 'E-mail', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'email', '', 'Joomla', 1, 1),
(24, 'Hometown', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '4', '', 'Jsfields', 4, 1);;

DROP TABLE IF EXISTS `#__xius_cache`;;
CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `joomlaemail_0` varchar(250) NOT NULL,
  `jsfields11_0` varchar(250) NOT NULL,
  `jsfields4_0` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;;
INSERT INTO `#__xius_cache` (`userid`, `joomlaemail_0`, `jsfields11_0`, `jsfields4_0`) VALUES
(62, 'shyam@readybytes.in', '', ''),
(79, 'regtest7046025@gmail.com', '', ''),
(80, 'regtest6208627@gmail.com', '', ' '),
(81, 'regtest8635954@gmail.com', '', ''),
(82, 'regtest8774090@gmail.com', '', ''),
(83, 'regtest1789672@gmail.com', '', ''),
(84, 'regtest6461827@gmail.com', '', ''),
(85, 'regtest3843261@gmail.com', '', ''),
(86, 'regtest1504555@gmail.com', '', ''),
(87, 'regtest1674526@gmail.com', '', '');;

TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users`(`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`, `alias`, `latitude`, `longitude`) VALUES
(62, '', 12, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(83, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(84, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(85, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(86, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(87, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(79, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(80, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(81, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255),
(82, '', 2, '0000-00-00 00:00:00', 'images/avatar/23b20a8afc288ad7bcd02af4.jpg', 'images/avatar/thumb_23b20a8afc288ad7bcd02af4.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\ndaylightsavingoffset=0\n\n', 0, 0, '', 255, 255);;

TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, 25, '2009-10-27 14:21:57', '2010-11-01 11:45:50', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(82, 'regtest8774090', 'regtest8774090', 'regtest8774090@gmail.com', 'f478ff7ef92fcb7a7cb62d4c1f08e43a:7rptUeQifMIkdyqE59fnxb0o74NE4sk8', 'Registered', 0, 0, 18, '2009-12-03 08:16:35', '0000-00-00 00:00:00', 'a3a9fc5ff08868ee458cda29142e6e36', 'language=\ntimezone=0\n\n'),
(83, 'regtest1789672', 'regtest1789672', 'regtest1789672@gmail.com', 'c33a3ac03bfbc13368383edc0e6ae42d:bUwtJXMI49daOhAPzdaLBdRY1IOOgm0D', 'Registered', 0, 0, 18, '2009-12-03 08:16:44', '0000-00-00 00:00:00', 'a25e8cbbf5a534e0d5b934589be66756', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(84, 'regtest6461827', 'regtest6461827', 'regtest6461827@gmail.com', '56f606098f0631341e8c398eaae179c6:aOJ5ghvQqtSCPnIH8SwFw90001MNaRI6', 'Registered', 0, 0, 18, '2009-12-03 08:16:52', '0000-00-00 00:00:00', 'd8e2cc8000b17d6791a451354a281937', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(85, 'regtest3843261', 'regtest3843261', 'regtest3843261@gmail.com', '0f2e8c8f8433fd1604880e9ac0d33fc1:d4b8PHWIkuHEI4AfHM1XWkFh4sR4t1gj', 'Registered', 0, 0, 18, '2009-12-03 08:17:00', '0000-00-00 00:00:00', '0e11cd0ed924846a11c84e3618f2c5eb', 'language=\ntimezone=0\n\n'),
(86, 'regtest1504555', 'regtest1504555', 'regtest1504555@gmail.com', '78c3901d9d2c31108f9f758a18ee7f89:UIbbRXlJUORtEqogoLPr9ZP0bouM0lLT', 'Registered', 0, 0, 18, '2009-12-03 08:17:09', '0000-00-00 00:00:00', '77981cae5948a5be5e553db5dcb8d00f', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(87, 'regtest1674526', 'regtest1674526', 'regtest1674526@gmail.com', '948b72e649363975c49ba818d6880843:PezoDwP9dbIXQETtPbG0IfkpE0jogLi2', 'Registered', 0, 0, 18, '2009-12-03 08:17:17', '0000-00-00 00:00:00', '51bcf29e8ec7bbaf00dc2160257b8987', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(79, 'regtest7046025', 'regtest7046025', 'regtest7046025@gmail.com', '64d5a5a65e0433fefad4d52255857f59:rBhZVyCqDIKioTNuCNBkpQNhRXsCHb1t', 'Registered', 0, 0, 18, '2009-12-03 08:16:09', '0000-00-00 00:00:00', 'd45373ce0b2c4bfa6065235a5c353add', 'language=\ntimezone=0\n\n'),
(80, 'regtest6208627', 'regtest6208627', 'regtest6208627@gmail.com', '73e7830c01e705a5adeaaa3e278fbdec:uQb0sUh0KdTyybJuHnYHAtpOmtfVNxr2', 'Registered', 0, 0, 18, '2009-12-03 08:16:18', '0000-00-00 00:00:00', '0e24ede794209ad6de9624f89077daed', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(81, 'regtest8635954', 'regtest8635954', 'regtest8635954@gmail.com', '7dc28bb5bc0119a23ac236b82837586e:vBNJaILgct7EzdE4wmJANFeLuVSTLHdh', 'Registered', 0, 0, 18, '2009-12-03 08:16:26', '0000-00-00 00:00:00', '1ebc22393cc2619be62d28fe7c960e5a', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n');;

TRUNCATE TABLE `#__community_fields`;;
INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `options`, `fieldcode`,  `registration`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basic information for user', 1, 0, 1, '', '', 1),
(2, 'select', 2, 1, 10, 100, 'Gender', 'Select gender', 1, 0, 1, 'Male\nFemale', 'FIELD_GENDER', 1),
(3, 'date', 3, 1, 10, 100, 'Birthday', 'Enter your date of birth so other users can know when to wish you happy birthday ', 1, 0, 1, '', 'FIELD_BIRTHDAY', 1),
(4, 'text', 4, 1, 5, 250, 'Hometown', 'Hometown', 1, 0, 1, '', 'FIELD_HOMETOWN', 1),
(5, 'textarea', 5, 1, 1, 800, 'About me', 'Tell us more about yourself', 1, 0, 1, '', 'FIELD_ABOUTME', 1),
(6, 'group', 6, 1, 10, 100, 'Contact Information', 'Specify your contact details', 1, 0, 1, '', '', 1),
(7, 'text', 7, 1, 10, 100, 'Mobile phone', 'Mobile carrier number that other users can contact you.', 1, 0, 1, '', 'FIELD_MOBILE', 1),
(8, 'text', 8, 1, 10, 100, 'Land phone', 'Contact number that other users can contact you.', 1, 0, 1, '', 'FIELD_LANDPHONE', 1),
(9, 'textarea', 9, 1, 10, 100, 'Address', 'Address', 1, 0, 1, '', 'FIELD_ADDRESS', 1),
(10, 'text', 10, 1, 10, 100, 'State', 'State', 1, 0, 1, '', 'FIELD_STATE', 1),
(11, 'text', 11, 1, 10, 100, 'City / Town', 'City / Town', 1, 0, 1, '', 'FIELD_CITY', 1),
(12, 'select', 12, 1, 10, 100, 'Country', 'Country', 1, 0, 1, 'Afghanistan\nAlbania\nAlgeria\nAmerican Samoa\nAndorra\nAngola\nAnguilla\nAntarctica\nAntigua and Barbuda\nArgentina\nArmenia\nAruba', 'FIELD_COUNTRY', 1),
(13, 'text', 13, 1, 10, 100, 'Website', 'Website', 1, 0, 1, '', 'FIELD_WEBSITE', 1),
(14, 'group', 14, 1, 10, 100, 'Education', 'Educations', 1, 0, 1, '', '', 1),
(15, 'text', 15, 1, 10, 200, 'College / University', 'College / University', 1, 0, 1, '', 'FIELD_COLLEGE', 1),
(16, 'text', 16, 1, 5, 100, 'Graduation Year', 'Graduation year', 1, 0, 1, '', 'FIELD_GRADUATION', 1);;

TRUNCATE TABLE `#__xius_config`;;
INSERT INTO `#__xius_config` (`name`, `params`) VALUES
('cache', 'cacheStartTime=1282050943\ncacheEndTime=1282050944\n\n'),
('config', 'xiusTemplates=default\nintegrateJomSocial=1\nxiusKey=SSV445\nxiusDebugMode=1\nxiusListCreator=a:1:{i:0;s:19:"Super Administrator";}\nxiusReplaceSearch=1\nxiusSlideShow=none\nxiusLoadJquery=0\nxiusEnableMatch=1\nxiusDefaultMatch=OR\nxiusCronJob=1\nxiusCronFrequency=900\nxiusCronAcessTime=0\n\n');;

TRUNCATE TABLE `#__community_fields_values`;;
INSERT INTO `#__community_fields_values` (`id`, `user_id`, `field_id`, `value`) VALUES
(1, 62, 2, 'Male'),
(2, 62, 3, ''),
(3, 62, 4, 'Bhilwar'),
(4, 62, 5, ''),
(5, 62, 7, ''),
(6, 62, 8, ''),
(7, 62, 9, ''),
(8, 62, 10, ''),
(9, 62, 11, ''),
(10, 62, 12, ''),
(11, 62, 13, ''),
(12, 62, 15, ''),
(13, 62, 16, ''),
(14, 84, 2, ''),
(15, 84, 3, ''),
(16, 84, 4, 'Chittorgarh'),
(17, 84, 5, ''),
(18, 84, 7, ''),
(19, 84, 8, ''),
(20, 84, 9, ''),
(21, 84, 10, ''),
(22, 84, 11, ''),
(23, 84, 12, ''),
(24, 84, 13, ''),
(25, 84, 15, ''),
(26, 84, 16, ''),
(27, 80, 2, ''),
(28, 80, 3, ''),
(29, 80, 4, 'Dhanet Kalan'),
(30, 80, 5, ''),
(31, 80, 7, ''),
(32, 80, 8, ''),
(33, 80, 9, ''),
(34, 80, 10, ''),
(35, 80, 11, ''),
(36, 80, 12, ''),
(37, 80, 13, ''),
(38, 80, 15, ''),
(39, 80, 16, ''),
(40, 86, 2, ''),
(41, 86, 3, ''),
(42, 86, 4, 'Dil k Kone me..'),
(43, 86, 5, ''),
(44, 86, 7, ''),
(45, 86, 8, ''),
(46, 86, 9, ''),
(47, 86, 10, ''),
(48, 86, 11, ''),
(49, 86, 12, ''),
(50, 86, 13, ''),
(51, 86, 15, ''),
(52, 86, 16, ''),
(53, 87, 2, ''),
(54, 87, 3, ''),
(55, 87, 4, 'Kyo btau'),
(56, 87, 5, ''),
(57, 87, 7, ''),
(58, 87, 8, ''),
(59, 87, 9, ''),
(60, 87, 10, ''),
(61, 87, 11, ''),
(62, 87, 12, ''),
(63, 87, 13, ''),
(64, 87, 15, ''),
(65, 87, 16, '');;

DROP TABLE IF EXISTS `au_#__xius_cache`;;
CREATE TABLE IF NOT EXISTS `au_#__xius_cache` (
  `userid` int(21) NOT NULL,
  `joomlaemail_0` varchar(250) NOT NULL,
  `jsfields4_0` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;;
INSERT INTO `au_#__xius_cache` (`userid`, `joomlaemail_0`, `jsfields4_0`) VALUES
(62, 'shyam@readybytes.in', 'Bhilwar'),
(79, 'regtest7046025@gmail.com', ''),
(80, 'regtest6208627@gmail.com', 'Dhanet Kalan'),
(81, 'regtest8635954@gmail.com', ''),
(82, 'regtest8774090@gmail.com', ''),
(83, 'regtest1789672@gmail.com', ''),
(84, 'regtest6461827@gmail.com', 'Chittorgarh'),
(85, 'regtest3843261@gmail.com', ''),
(86, 'regtest1504555@gmail.com', 'Dil k Kone me..'),
(87, 'regtest1674526@gmail.com', 'Kyo btau');;