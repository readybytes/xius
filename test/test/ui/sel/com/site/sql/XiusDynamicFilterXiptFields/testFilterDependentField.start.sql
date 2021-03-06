TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'Free Member', 0, 1, 'If you are just want to explore the site, choose this type. Its free.', 'privacyprofile=20\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '4', '', '', '', 1, 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator, admin, support, owner, employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'Paid Subscriber', 1, 1, 'If you wish to subscribe for the paid components and services, choose this account type.', 'privacyprofile=30\n\n', 'default', 'Registered', 'images/profiletype/avatar_2.gif', 0, 1, '1', '', '', '', 1, 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator, admin, support, owner, employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(3, 'Serious Joomla User', 2, 1, 'Serious Joomla User, are the users who really want to motivate the joomla developers to enhance the joomla experience. When you subscribe to this plan, you support us by paying few $$.', 'privacyprofile=30\n\n', 'default', 'Registered', 'images/profiletype/avatar_3.png', 0, 0, '0', '', '', '', 1, 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator, admin, support, owner, employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(4, 'Moderator', 3, 0, 'The members are moderating the website.', 'privacyprofile=30\n\n', 'default', 'Registered', '/images/avatar/a1f960fb81d15c26035a6808.jpg', 1, 0, '0', '', '', '', 1, 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator, admin, support, owner, employee\njspt_allowed_email=\njspt_prevent_email=\n\n');;

TRUNCATE TABLE `#__community_fields`;;

INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`, `params`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basic information for user', 1, 1, 1, 1, '', '', ''),
(2, 'select', 7, 1, 10, 100, 'Gender', 'Select gender', 1, 1, 1, 1, 'Male\nFemale', 'FIELD_GENDER', ''),
(3, 'date', 8, 1, 10, 100, 'Birthday', 'Enter your date of birth so other users can know when to wish you happy birthday ', 1, 1, 1, 1, '', 'FIELD_BIRTHDAY', ''),
(4, 'text', 9, 1, 5, 250, 'Hometown', 'Hometown', 1, 1, 1, 1, '', 'FIELD_HOMETOWN', ''),
(5, 'textarea', 10, 1, 1, 800, 'About me', 'Tell us more about yourself', 1, 1, 1, 1, '', 'FIELD_ABOUTME', ''),
(6, 'group', 11, 1, 10, 100, 'Contact Information', 'Specify your contact details', 1, 1, 1, 1, '', '', ''),
(7, 'text', 12, 1, 10, 100, 'Mobile phone', 'Mobile carrier number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_MOBILE', ''),
(8, 'text', 13, 1, 10, 100, 'Land phone', 'Contact number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_LANDPHONE', ''),
(9, 'textarea', 14, 1, 10, 100, 'Address', 'Address', 1, 1, 1, 1, '', 'FIELD_ADDRESS', ''),
(10, 'text', 15, 1, 10, 100, 'State', 'State', 1, 1, 1, 1, '', 'FIELD_STATE', ''),
(11, 'text', 16, 1, 10, 100, 'City / Town', 'City / Town', 1, 1, 1, 1, '', 'FIELD_CITY', ''),
(12, 'select', 17, 1, 10, 100, 'Country', 'Country', 1, 1, 1, 1, 'Afghanistan\nAlbania\nAlgeria\nAmerican Samoa\nAndorra\nAngola\nAnguilla\nAntarctica\nAntigua and Barbuda\nArgentina\nArmenia\nAruba\nIndia', 'FIELD_COUNTRY', ''),
(13, 'text', 18, 1, 10, 100, 'Website', 'Website', 1, 1, 1, 1, '', 'FIELD_WEBSITE', ''),
(14, 'group', 19, 1, 10, 100, 'Education', 'Educations', 1, 1, 1, 1, '', '', ''),
(15, 'text', 20, 1, 10, 200, 'College / University', 'College / University', 1, 1, 1, 1, '', 'FIELD_COLLEGE', ''),
(16, 'text', 21, 1, 5, 100, 'Graduation Year', 'Graduation year', 1, 1, 1, 1, '', 'FIELD_GRADUATION', ''),
(17, 'templates', 5, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, 1, '', 'XIPT_TEMPLATE', ''),
(18, 'profiletypes', 4, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, 1, '', 'XIPT_PROFILETYPE', '');;

TRUNCATE TABLE `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '2', '', 'Jsfields', 1, 1),
(2, 'Birthday', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '3', '', 'Jsfields', 2, 1),
(3, 'Hometown', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '4', '', 'Jsfields', 3, 1),
(4, 'About me', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '5', '', 'Jsfields', 4, 1),
(5, 'Mobile phone', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '7', '', 'Jsfields', 5, 1),
(6, 'Profiletype', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '18', '', 'Jsfields', 6, 1),
(7, 'Land phone', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '8', '', 'Jsfields', 7, 1),
(8, 'BirthdayRange', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\nxipt_privacy=a:1:{i:0;s:1:"0";}\njs_privacy=public\n\n', '2', 'rangesearchType=date\n\n', 'Rangesearch', 8, 1),
(10, 'City / Town', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\nxipt_privacy=a:1:{i:0;s:1:"0";}\njs_privacy=public\n\n', '11', '', 'Jsfields', 9, 1),
(11, 'State', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\nxipt_privacy=a:1:{i:0;s:1:"0";}\njs_privacy=public\n\n', '10', '', 'Jsfields', 10, 1),
(12, 'Country', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\nxipt_privacy=a:1:{i:0;s:1:"0";}\njs_privacy=public\n\n', '12', '', 'Jsfields', 11, 1),
(13, 'By Google API', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\nxipt_privacy=a:1:{i:0;s:1:"0";}\njs_privacy=public\n\n', 'google', 'xius_proximity_country=12\nxius_proximity_zipcode=\nxius_proximity_state=11\nxius_proximity_city=10\nxius_gmap_key=\nxius_default_location=none\nxiusProximityDefaultLat=28.635308\nxiusProximityDefaultLong=77.22496\nxiusDefaultDistance=10\nxiusDefaultDistanceUnit=miles\nxiusProximityGmapZoom=2\n\n', 'Proximity', 12, 1);;

DROP TABLE `#__xius_cache`;;
CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `jsfields12_0` varchar(250) NOT NULL,
  `jsfields10_0` varchar(250) NOT NULL,
  `jsfields11_0` varchar(250) NOT NULL,
  `jsfields8_0` varchar(250) NOT NULL,
  `jsfields18_0` varchar(250) NOT NULL,
  `jsfields7_0` varchar(250) NOT NULL,
  `jsfields5_0` varchar(250) NOT NULL,
  `jsfields4_0` varchar(250) NOT NULL,
  `jsfields3_0` datetime NOT NULL,
  `jsfields2_0` varchar(250) NOT NULL,
  `rangesearch2_0` double NOT NULL DEFAULT '0',
  `proximity_google_latitude_0` float(10,6) DEFAULT NULL,
  `proximity_google_longitude_0` float(10,6) DEFAULT NULL,
  `proximity_google_address_0` varchar(250) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;;


TRUNCATE TABLE `#__xius_cache`;;
INSERT INTO `#__xius_cache` (`userid`, `jsfields12_0`, `jsfields10_0`, `jsfields11_0`, `jsfields8_0`, `jsfields18_0`, `jsfields7_0`, `jsfields5_0`, `jsfields4_0`, `jsfields3_0`, `jsfields2_0`, `rangesearch2_0`, `proximity_google_latitude_0`, `proximity_google_longitude_0`, `proximity_google_address_0`) VALUES
(62, 'India', 'Rajasthan', 'Bhilwara', '', '', '', '', '', '0000-00-00 00:00:00', '', 0, 25.346251, 74.636383, 'Bhilwara,Rajasthan,India'),
(63, 'India', 'Rajasthan', 'Ajmer', '', '', '', '', '', '0000-00-00 00:00:00', '', 0, NULL, NULL, 'Ajmer,Rajasthan,India'),
(64, 'India', 'Gujrat', 'Surat', '1299648940', '', '61096620', '', 'Surat', '2000-12-25 23:59:59', 'Female', 10, 21.195009, 72.819527, 'Surat,Gujrat,India'),
(65, 'India', 'Punjab', 'Ludhiana', '1156881164', '', '1373346876', '', 'Ludhiana', '1992-02-09 23:59:59', 'Female', 19, 30.902222, 75.854721, 'Ludhiana,Punjab,India'),
(66, 'India', 'Punjab', 'Chandigarh', '1348999261', '', '1122361707', '', 'Chandigarh', '1994-09-22 23:59:59', 'Male', 17, NULL, NULL, 'Chandigarh,Punjab,India'),
(67, 'India', 'Madhya Pradesh', 'Indore', '1191652949', '', '420395176', '', 'Indore', '1993-06-20 23:59:59', 'Male', 18, 22.725313, 75.865555, 'Indore,Madhya Pradesh,India');;

TRUNCATE TABLE `#__xipt_profilefields`;;
INSERT INTO `#__xipt_profilefields` (`id`, `fid`, `pid`, `category`) VALUES
(1, 22, 1, 0),
(2, 22, 3, 0),
(3, 22, 4, 0),
(4, 23, 1, 0),
(5, 23, 4, 0),
(6, 24, 1, 0),
(7, 24, 4, 0),
(8, 25, 1, 0),
(9, 25, 4, 0),
(10, 26, 1, 0),
(11, 26, 4, 0),
(12, 27, 1, 0),
(13, 27, 4, 0),
(14, 18, 2, 0),
(15, 18, 3, 0),
(16, 18, 4, 0),
(32, 4, 4, 0),
(31, 4, 3, 0),
(30, 4, 1, 0),
(23, 2, 1, 0),
(24, 2, 2, 0),
(25, 2, 4, 0),
(45, 3, 4, 0),
(44, 3, 2, 0),
(33, 5, 3, 0),
(34, 5, 4, 0),
(35, 7, 1, 0),
(36, 7, 4, 0),
(37, 8, 2, 0),
(38, 8, 4, 0),
(42, 11, 2, 0),
(43, 12, 3, 0);;

TRUNCATE TABLE `#__plugins`;;
INSERT INTO `#__plugins` (`id`, `name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES
(1, 'Authentication - Joomla', 'joomla', 'authentication', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(2, 'Authentication - LDAP', 'ldap', 'authentication', 0, 2, 0, 1, 0, 0, '0000-00-00 00:00:00', 'host=\nport=389\nuse_ldapV3=0\nnegotiate_tls=0\nno_referrals=0\nauth_method=bind\nbase_dn=\nsearch_string=\nusers_dn=\nusername=\npassword=\nldap_fullname=fullName\nldap_email=mail\nldap_uid=uid\n\n'),
(3, 'Authentication - GMail', 'gmail', 'authentication', 0, 4, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(4, 'Authentication - OpenID', 'openid', 'authentication', 0, 3, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(5, 'User - Joomla!', 'joomla', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'autoregister=1\n\n'),
(6, 'Search - Content', 'content', 'search', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\nsearch_content=1\nsearch_uncategorised=1\nsearch_archived=1\n\n'),
(7, 'Search - Contacts', 'contacts', 'search', 0, 3, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(8, 'Search - Categories', 'categories', 'search', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(9, 'Search - Sections', 'sections', 'search', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(10, 'Search - Newsfeeds', 'newsfeeds', 'search', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(11, 'Search - Weblinks', 'weblinks', 'search', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(12, 'Content - Pagebreak', 'pagebreak', 'content', 0, 10000, 1, 1, 0, 0, '0000-00-00 00:00:00', 'enabled=1\ntitle=1\nmultipage_toc=1\nshowall=1\n\n'),
(13, 'Content - Rating', 'vote', 'content', 0, 4, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(14, 'Content - Email Cloaking', 'emailcloak', 'content', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', 'mode=1\n\n'),
(15, 'Content - Code Hightlighter (GeSHi)', 'geshi', 'content', 0, 5, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(16, 'Content - Load Module', 'loadmodule', 'content', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', 'enabled=1\nstyle=0\n\n'),
(17, 'Content - Page Navigation', 'pagenavigation', 'content', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', 'position=1\n\n'),
(18, 'Editor - No Editor', 'none', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(19, 'Editor - TinyMCE', 'tinymce', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', 'mode=advanced\nskin=0\ncompressed=0\ncleanup_startup=0\ncleanup_save=2\nentity_encoding=raw\nlang_mode=0\nlang_code=en\ntext_direction=ltr\ncontent_css=1\ncontent_css_custom=\nrelative_urls=1\nnewlines=0\ninvalid_elements=applet\nextended_elements=\ntoolbar=top\ntoolbar_align=left\nhtml_height=550\nhtml_width=750\nelement_path=1\nfonts=1\npaste=1\nsearchreplace=1\ninsertdate=1\nformat_date=%Y-%m-%d\ninserttime=1\nformat_time=%H:%M:%S\ncolors=1\ntable=1\nsmilies=1\nmedia=1\nhr=1\ndirectionality=1\nfullscreen=1\nstyle=1\nlayer=1\nxhtmlxtras=1\nvisualchars=1\nnonbreaking=1\ntemplate=0\nadvimage=1\nadvlink=1\nautosave=1\ncontextmenu=1\ninlinepopups=1\nsafari=1\ncustom_plugin=\ncustom_button=\n\n'),
(20, 'Editor - XStandard Lite 2.0', 'xstandard', 'editors', 0, 0, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(21, 'Editor Button - Image', 'image', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(22, 'Editor Button - Pagebreak', 'pagebreak', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(23, 'Editor Button - Readmore', 'readmore', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(24, 'XML-RPC - Joomla', 'joomla', 'xmlrpc', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(25, 'XML-RPC - Blogger API', 'blogger', 'xmlrpc', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', 'catid=1\nsectionid=0\n\n'),
(27, 'System - SEF', 'sef', 'system', 0, 1, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(28, 'System - Debug', 'debug', 'system', 0, 2, 1, 0, 0, 0, '0000-00-00 00:00:00', 'queries=1\nmemory=1\nlangauge=1\n\n'),
(29, 'System - Legacy', 'legacy', 'system', 0, 3, 0, 1, 0, 0, '0000-00-00 00:00:00', 'route=0\n\n'),
(30, 'System - Cache', 'cache', 'system', 0, 4, 0, 1, 0, 0, '0000-00-00 00:00:00', 'browsercache=0\ncachetime=15\n\n'),
(31, 'System - Log', 'log', 'system', 0, 5, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(32, 'System - Remember Me', 'remember', 'system', 0, 6, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(33, 'System - Backlink', 'backlink', 'system', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(34, 'System - Mootools Upgrade', 'mtupgrade', 'system', 0, 8, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(35, 'Azrul System Mambot For Joomla', 'azrul.system', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'compress=1\n'),
(49, 'User - Jomsocial User', 'jomsocialuser', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(37, 'Walls', 'walls', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'cache=1\nposition=content\n'),
(38, 'System - Jomsocial Facebook Connect', 'jomsocialconnect', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(39, 'Jomsocial Update', 'jomsocialupdate', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(40, 'System - Zend Lib', 'zend', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(41, 'JSPT Community Plugin', 'xipt_community', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(42, 'JSPT System Plugin', 'xipt_system', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(43, 'XiUS Dynamic filtering of XiPT-fields Plugin', 'xipt_fieldselection', 'xius', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'xiusSetInfo=1\n\n'),
(44, 'XIUS XiProfileType Privacy Plugin', 'xipt_privacy', 'xius', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(45, 'XIUS Community Plugin', 'xius', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(46, 'XIUS Joomla Integration Plugin', 'xius', 'search', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(47, 'XIUS JS Privacy Plugin', 'js_privacy', 'xius', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(48, 'XIUS System Plugin', 'xius_system', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');;
