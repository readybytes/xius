TRUNCATE TABLE `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '2', '', 'Jsfields', 1, 1),
(2, 'Birthday', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '3', '', 'Jsfields', 2, 1),
(3, 'Hometown', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '4', '', 'Jsfields', 3, 1),
(4, 'About me', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '5', '', 'Jsfields', 4, 1),
(5, 'Mobile phone', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '7', '', 'Jsfields', 5, 1),
(6, 'Profiletype', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '18', '', 'Jsfields', 6, 1),
(7, 'Land phone', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '8', '', 'Jsfields', 7, 1);;

TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'Free Member', 0, 1, 'If you are just want to explore the site, choose this type. Its free.', 'privacyprofile=20\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '4', '', '', '', 1, 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator, admin, support, owner, employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'Paid Subscriber', 1, 1, 'If you wish to subscribe for the paid components and services, choose this account type.', 'privacyprofile=30\n\n', 'default', 'Registered', 'images/profiletype/avatar_2.gif', 0, 1, '1', '', '', '', 1, 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator, admin, support, owner, employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(3, 'Serious Joomla User', 2, 1, 'Serious Joomla User, are the users who really want to motivate the joomla developers to enhance the joomla experience. When you subscribe to this plan, you support us by paying few $$.', 'privacyprofile=30\n\n', 'default', 'Registered', 'images/profiletype/avatar_3.png', 0, 0, '0', '', '', '', 1, 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator, admin, support, owner, employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(4, 'Moderator', 3, 0, 'The members are moderating the website.', 'privacyprofile=30\n\n', 'default', 'Registered', '/images/avatar/a1f960fb81d15c26035a6808.jpg', 1, 0, '0', '', '', '', 1, 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator, admin, support, owner, employee\njspt_allowed_email=\njspt_prevent_email=\n\n');;


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
(43, 'XiUS Dynamic filtering of XiPT-fields Plugin', 'xipt_fieldselection', 'xius', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'xiusSetInfo=0\n\n'),
(44, 'XIUS XiProfileType Privacy Plugin', 'xipt_privacy', 'xius', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(45, 'XIUS Community Plugin', 'xius', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(46, 'XIUS Joomla Integration Plugin', 'xius', 'search', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(47, 'XIUS JS Privacy Plugin', 'js_privacy', 'xius', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(48, 'XIUS System Plugin', 'xius_system', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');;
