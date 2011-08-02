DROP TABLE IF EXISTS `bk_#__modules`;;
CREATE TABLE IF NOT EXISTS `bk_#__modules` SELECT * FROM `#__modules`;;

TRUNCATE TABLE `#__modules`;;
INSERT INTO `#__modules` (`id`, `title`, `content`, `ordering`, `position`, `checked_out`, `checked_out_time`, `published`, `module`, `numnews`, `access`, `showtitle`, `params`, `iscore`, `client_id`, `control`) VALUES
(1, 'Main Menu', '', 1, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 1, 'menutype=mainmenu\nmoduleclass_sfx=_menu\n', 1, 0, ''),
(2, 'Login', '', 1, 'login', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 1, '', 1, 1, ''),
(3, 'Popular', '', 3, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_popular', 0, 2, 1, '', 0, 1, ''),
(4, 'Recent added Articles', '', 4, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_latest', 0, 2, 1, 'ordering=c_dsc\nuser_id=0\ncache=0\n\n', 0, 1, ''),
(5, 'Menu Stats', '', 5, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_stats', 0, 2, 1, '', 0, 1, ''),
(6, 'Unread Messages', '', 1, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_unread', 0, 2, 1, '', 1, 1, ''),
(7, 'Online Users', '', 2, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_online', 0, 2, 1, '', 1, 1, ''),
(8, 'Toolbar', '', 1, 'toolbar', 0, '0000-00-00 00:00:00', 1, 'mod_toolbar', 0, 2, 1, '', 1, 1, ''),
(9, 'Quick Icons', '', 1, 'icon', 0, '0000-00-00 00:00:00', 1, 'mod_quickicon', 0, 2, 1, '', 1, 1, ''),
(10, 'Logged in Users', '', 2, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_logged', 0, 2, 1, '', 0, 1, ''),
(11, 'Footer', '', 0, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_footer', 0, 0, 1, '', 1, 1, ''),
(12, 'Admin Menu', '', 1, 'menu', 0, '0000-00-00 00:00:00', 1, 'mod_menu', 0, 2, 1, '', 0, 1, ''),
(13, 'Admin SubMenu', '', 1, 'submenu', 0, '0000-00-00 00:00:00', 1, 'mod_submenu', 0, 2, 1, '', 0, 1, ''),
(14, 'User Status', '', 1, 'status', 0, '0000-00-00 00:00:00', 1, 'mod_status', 0, 2, 1, '', 0, 1, ''),
(15, 'Title', '', 1, 'title', 0, '0000-00-00 00:00:00', 1, 'mod_title', 0, 2, 1, '', 0, 1, ''),
(16, 'Polls', '', 1, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_poll', 0, 0, 1, 'id=14\ncache=1', 0, 0, ''),
(17, 'User Menu', '', 4, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 1, 1, 'menutype=usermenu\nmoduleclass_sfx=_menu\ncache=1', 1, 0, ''),
(18, 'Login Form', '', 8, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 1, 'cache=0\nmoduleclass_sfx=\npretext=\nposttext=\nlogin=\nlogout=\ngreeting=1\nname=0\nusesecure=0\n\n', 1, 0, ''),
(19, 'Latest News', '', 4, 'user1', 0, '0000-00-00 00:00:00', 1, 'mod_latestnews', 0, 0, 1, 'cache=1', 1, 0, ''),
(20, 'Statistics', '', 6, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_stats', 0, 0, 1, 'serverinfo=1\nsiteinfo=1\ncounter=1\nincrease=0\nmoduleclass_sfx=', 0, 0, ''),
(21, 'Who''s Online', '', 1, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_whosonline', 0, 0, 1, 'online=1\nusers=1\nmoduleclass_sfx=', 0, 0, ''),
(22, 'Popular', '', 6, 'user2', 0, '0000-00-00 00:00:00', 1, 'mod_mostread', 0, 0, 1, 'cache=1', 0, 0, ''),
(23, 'Archive', '', 9, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_archive', 0, 0, 1, 'cache=1', 1, 0, ''),
(24, 'Sections', '', 10, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_sections', 0, 0, 1, 'cache=1', 1, 0, ''),
(25, 'Newsflash', '', 1, 'top', 0, '0000-00-00 00:00:00', 1, 'mod_newsflash', 0, 0, 1, 'catid=3\r\nstyle=random\r\nitems=\r\nmoduleclass_sfx=', 0, 0, ''),
(26, 'Related Items', '', 11, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_related_items', 0, 0, 1, '', 0, 0, ''),
(27, 'Search', '', 1, 'user4', 0, '0000-00-00 00:00:00', 1, 'mod_search', 0, 0, 0, 'cache=1', 0, 0, ''),
(28, 'Random Image', '', 9, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_random_image', 0, 0, 1, '', 0, 0, ''),
(29, 'Top Menu', '', 1, 'user3', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 0, 'cache=1\nmenutype=topmenu\nmenu_style=list_flat\nmenu_images=n\nmenu_images_align=left\nexpand_menu=n\nclass_sfx=-nav\nmoduleclass_sfx=\nindent_image1=0\nindent_image2=0\nindent_image3=0\nindent_image4=0\nindent_image5=0\nindent_image6=0', 1, 0, ''),
(30, 'Banners', '', 1, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_banners', 0, 0, 0, 'target=1\ncount=1\ncid=1\ncatid=33\ntag_search=0\nordering=random\nheader_text=\nfooter_text=\nmoduleclass_sfx=\ncache=1\ncache_time=15\n\n', 1, 0, ''),
(31, 'Resources', '', 2, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 1, 'menutype=othermenu\nmenu_style=list\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=\nmoduleclass_sfx=_menu\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\n\n', 0, 0, ''),
(32, 'Wrapper', '', 12, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_wrapper', 0, 0, 1, '', 0, 0, ''),
(33, 'Footer', '', 2, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_footer', 0, 0, 0, 'cache=1\n\n', 1, 0, ''),
(34, 'Feed Display', '', 13, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_feed', 0, 0, 1, '', 1, 0, ''),
(35, 'Breadcrumbs', '', 1, 'breadcrumb', 0, '0000-00-00 00:00:00', 1, 'mod_breadcrumbs', 0, 0, 1, 'moduleclass_sfx=\ncache=0\nshowHome=1\nhomeText=Home\nshowComponent=1\nseparator=\n\n', 1, 0, ''),
(36, 'Syndication', '', 3, 'syndicate', 0, '0000-00-00 00:00:00', 1, 'mod_syndicate', 0, 0, 0, '', 1, 0, ''),
(38, 'Advertisement', '', 3, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_banners', 0, 0, 1, 'count=4\r\nrandomise=0\r\ncid=0\r\ncatid=14\r\nheader_text=Featured Links:\r\nfooter_text=<a href="http://www.joomla.org">Ads by Joomla!</a>\r\nmoduleclass_sfx=_text\r\ncache=0\r\n\r\n', 0, 0, ''),
(39, 'Example Pages', '', 5, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 1, 'cache=1\nclass_sfx=\nmoduleclass_sfx=_menu\nmenutype=ExamplePages\nmenu_style=list_flat\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nfull_active_id=0\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nactivate_parent=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\nwindow_open=\n\n', 0, 0, ''),
(40, 'Key Concepts', '', 3, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 1, 'cache=1\nclass_sfx=\nmoduleclass_sfx=_menu\nmenutype=keyconcepts\nmenu_style=list\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nfull_active_id=0\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nactivate_parent=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\nwindow_open=\n\n', 0, 0, ''),
(41, 'Welcome to Joomla!', '<div style="padding: 5px">  <p>   Congratulations on choosing Joomla! as your content management system. To   help you get started, check out these excellent resources for securing your   server and pointers to documentation and other helpful resources. </p> <p>   <strong>Security</strong><br /> </p> <p>   On the Internet, security is always a concern. For that reason, you are   encouraged to subscribe to the   <a href="http://feedburner.google.com/fb/a/mailverify?uri=JoomlaSecurityNews" target="_blank">Joomla!   Security Announcements</a> for the latest information on new Joomla! releases,   emailed to you automatically. </p> <p>   If this is one of your first Web sites, security considerations may   seem complicated and intimidating. There are three simple steps that go a long   way towards securing a Web site: (1) regular backups; (2) prompt updates to the   <a href="http://www.joomla.org/download.html" target="_blank">latest Joomla! release;</a> and (3) a <a href="http://docs.joomla.org/Security_Checklist_2_-_Hosting_and_Server_Setup" target="_blank" title="good Web host">good Web host</a>. There are many other important security considerations that you can learn about by reading the <a href="http://docs.joomla.org/Category:Security_Checklist" target="_blank" title="Joomla! Security Checklist">Joomla! Security Checklist</a>. </p> <p>If you believe your Web site was attacked, or you think you have discovered a security issue in Joomla!, please do not post it in the Joomla! forums. Publishing this information could put other Web sites at risk. Instead, report possible security vulnerabilities to the <a href="http://developer.joomla.org/security/contact-the-team.html" target="_blank" title="Joomla! Security Task Force">Joomla! Security Task Force</a>.</p><p><strong>Learning Joomla!</strong> </p> <p>   A good place to start learning Joomla! is the   "<a href="http://docs.joomla.org/beginners" target="_blank">Absolute Beginner''s   Guide to Joomla!.</a>" There, you will find a Quick Start to Joomla!   <a href="http://help.joomla.org/ghop/feb2008/task048/joomla_15_quickstart.pdf" target="_blank">guide</a>   and <a href="http://help.joomla.org/ghop/feb2008/task167/index.html" target="_blank">video</a>,   amongst many other tutorials. The   <a href="http://community.joomla.org/magazine/view-all-issues.html" target="_blank">Joomla!   Community Magazine</a> also has   <a href="http://community.joomla.org/magazine/article/522-introductory-learning-joomla-using-sample-data.html" target="_blank">articles   for new learners</a> and experienced users, alike. A great place to look for   answers is the   <a href="http://docs.joomla.org/Category:FAQ" target="_blank">Frequently Asked   Questions (FAQ)</a>. If you are stuck on a particular screen in the   Administrator (which is where you are now), try clicking the Help toolbar   button to get assistance specific to that page. </p> <p>   If you still have questions, please feel free to use the   <a href="http://forum.joomla.org/" target="_blank">Joomla! Forums.</a> The forums   are an incredibly valuable resource for all levels of Joomla! users. Before   you post a question, though, use the forum search (located at the top of each   forum page) to see if the question has been asked and answered. </p> <p>   <strong>Getting Involved</strong> </p> <p>   <a name="twjs" title="twjs"></a> If you want to help make Joomla! better, consider getting   involved. There are   <a href="http://www.joomla.org/about-joomla/contribute-to-joomla.html" target="_blank">many ways   you can make a positive difference.</a> Have fun using Joomla!.</p></div>', 0, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 0, 2, 1, 'moduleclass_sfx=\n\n', 1, 1, ''),
(42, 'Joomla! Security Newsfeed', '', 6, 'cpanel', 62, '2008-10-25 20:15:17', 0, 'mod_feed', 0, 0, 1, 'cache=1\ncache_time=15\nmoduleclass_sfx=\nrssurl=http://feeds.joomla.org/JoomlaSecurityNews\nrssrtl=0\nrsstitle=1\nrssdesc=0\nrssimage=1\nrssitems=1\nrssitemdesc=1\nword_count=0\n\n', 0, 1, ''),
(43, 'CB Login', '', 0, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_cblogin', 0, 0, 1, 'moduleclass_sfx=\nhorizontal=0\ncompact=0\npretext=\nposttext=\nlogoutpretext=\nlogoutposttext=\nlogin=\nlogout=index.php\nshow_lostpass=1\nshow_newaccount=1\nshow_username_pass_icons=0\nname_lenght=14\npass_lenght=14\nshow_buttons_icons=0\nshow_remind_register_icons=0\nlogin_message=0\nlogout_message=0\nremember_enabled=1\ngreeting=1\nname=0\nshow_avatar=0\navatar_position=default\ntext_show_profile=\ntext_edit_profile=\npms_type=0\nshow_pms=0\nshow_connection_notifications=0\nhttps_post=0\ncb_plugins=0\n\n', 0, 0, ''),
(44, 'XiusListing', '', 14, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_xiuslisting', 0, 0, 1, '', 0, 0, ''),
(45, 'Xius Proximity Search', '', 15, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_xiusproximity', 0, 0, 1, 'xius_proximity=google\n				  				 		xius_proximity_params=googlemap\n				  				 		xius_distance=kms\n				  				 		xius_color=gray', 0, 0, ''),
(46, 'Xius Search Panel', '', 16, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_xiussearchpanel', 0, 0, 1, 'moduleclass_sfx=\n  xius_info_range=All\n xius_layout=horizontal\n', 0, 0, '');;

TRUNCATE TABLE `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(15, 'Age', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '14', '', 'Rangesearch', 7, 1),
(14, 'Birthday', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '3', '', 'Jsfields', 6, 1),
(13, 'Keyword', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'keywordsearch', '', 'Keyword', 5, 1),
(12, 'E-mail', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'email', '', 'Joomla', 4, 1),
(9, 'latitude', 'isSearchable=0\nisVisible=0\nisSortable=0\nisExportable=0\ntooltip=\n\n', 'latitude', '', 'Jsuser', 6, 1),
(10, 'longitude', 'isSearchable=0\nisVisible=0\nisSortable=0\nisExportable=0\ntooltip=\n\n', 'longitude', '', 'Jsuser', 7, 1),
(11, 'By Information', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', 'information', 'xius_proximity_latitude=9\nxius_proximity_longitude=10\nxius_default_location=none\n\n', 'Proximity', 8, 1),
(16, 'City / Town', 'isSearchable=0\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '11', '', 'Jsfields', 8, 1),
(17, 'Country', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '12', '', 'Jsfields', 9, 1),
(19, 'State', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '10', '', 'Jsfields', 10, 1);;


DROP TABLE IF EXISTS `#__xius_cache`;;

CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `joomlaemail_0` varchar(250) NOT NULL,
  `jsfields3_0` datetime NOT NULL,
  `jsuserlatitude_0` varchar(250) NOT NULL,
  `rangesearch14_0` int(31) NOT NULL DEFAULT '0',
  `jsuserlongitude_0` varchar(250) NOT NULL,
  `jsfields11_0` varchar(250) NOT NULL,
  `jsfields12_0` varchar(250) NOT NULL,
  `jsfields10_0` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;


INSERT INTO `#__xius_cache` (`userid`, `joomlaemail_0`, `jsfields3_0`, `jsuserlatitude_0`, `rangesearch14_0`, `jsuserlongitude_0`, `jsfields11_0`, `jsfields12_0`, `jsfields10_0`) VALUES
(62, 'shyam@joomlaxi.com', '0000-00-00 00:00:00', '25.3463001251221', 0, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan'),
(63, 'username64@email.com', '0000-00-00 00:00:00', '26.4538993835449', 0, '74.6389007568359', 'Ajmer', 'India', 'Rajasthan'),
(64, 'username65@email.com', '2000-12-25 23:59:59', '21.1949996948242', 9, '72.8195037841797', 'Surat', 'India', 'Gujrat'),
(65, 'username66@email.com', '1992-02-09 23:59:59', '30.9022006988525', 18, '75.8546981811523', 'Ludhiana', 'India', 'Punjab'),
(66, 'username67@email.com', '1994-09-22 23:59:59', '20.2376003265381', 15, '84.2699966430664', 'Chandigarh', 'India', 'Punjab'),
(67, 'username68@email.com', '1993-06-20 23:59:59', '22.726900100708', 17, '75.8638000488281', 'Indore', 'India', 'Madhya Pradesh'),
(68, 'username69@email.com', '1994-05-21 23:59:59', '28.6165008544922', 16, '77.2415008544922', 'Noida', 'India', 'Uttar Pradesh'),
(69, 'username70@email.com', '1992-09-21 23:59:59', '29.0587997436523', 17, '76.0856018066406', 'Shimla', 'India', 'Himachal Pradesh'),
(70, 'username71@email.com', '1999-01-21 23:59:59', '18.5200004577637', 11, '73.8565979003906', 'Pune', 'India', 'Maharashtra'),
(71, 'username72@email.com', '1994-01-27 23:59:59', '24.5949001312256', 16, '84.7142028808594', 'Kolkata', 'India', 'West Bangal'),
(72, 'username73@email.com', '1996-10-03 23:59:59', '27.5618000030518', 13, '76.6087036132812', 'Alwar', 'India', 'Rajasthan'),
(73, 'username74@email.com', '1998-12-21 23:59:59', '18.5200004577637', 11, '73.8565979003906', 'Pune', 'India', 'Maharashtra'),
(74, 'username75@email.com', '1995-09-18 23:59:59', '28.6182994842529', 14, '77.2422027587891', 'Noida', 'India', 'Uttar Pradesh'),
(75, 'username76@email.com', '1996-07-10 23:59:59', '25.1979999542236', 14, '85.5218963623047', 'Ajmer', 'India', 'Rajasthan'),
(76, 'username77@email.com', '1999-12-20 23:59:59', '28.6165008544922', 10, '77.2415008544922', 'Noida', 'India', 'Uttar Pradesh'),
(77, 'username78@email.com', '1994-06-03 23:59:59', '30.8820991516113', 16, '75.8339996337891', 'Ludhiana', 'India', 'Punjab'),
(78, 'username79@email.com', '1997-10-23 23:59:59', '15.3172998428345', 12, '75.7138977050781', 'Bikaner', 'India', 'Rajasthan'),
(79, 'username80@email.com', '1990-05-07 23:59:59', '26.2005996704102', 20, '92.9375991821289', 'Nagpur', 'India', 'Maharashtra'),
(80, 'username81@email.com', '1998-12-20 23:59:59', '13.0604000091553', 11, '80.2496032714844', 'chennai', 'India', 'Tamilnadu'),
(81, 'username82@email.com', '1996-11-20 23:59:59', '23.0396003723145', 13, '72.5660018920898', 'Ahmedabad', 'India', 'Gujrat'),
(82, 'username83@email.com', '1995-10-13 23:59:59', '10.7985000610352', 14, '77.1025009155273', 'Coimbatore', 'India', 'Karnataka'),
(83, 'username84@email.com', '1997-01-12 23:59:59', '21.1539001464844', 13, '79.0830993652344', 'Nagpur', 'India', 'Maharashtra'),
(84, 'username85@email.com', '1994-06-02 23:59:59', '25.3463001251221', 16, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan'),
(85, 'username86@email.com', '2000-10-08 23:59:59', '30.9022006988525', 9, '75.8546981811523', 'Ludhiana', 'India', 'Punjab'),
(86, 'username87@email.com', '2000-01-07 23:59:59', '31.3199996948242', 10, '75.5800018310547', 'Jalandhar', 'India', 'Punjab'),
(87, 'username88@email.com', '1996-04-14 23:59:59', '26.2805995941162', 14, '73.0158004760742', 'Jodhapur', 'India', 'Rajasthan'),
(88, 'username89@email.com', '1998-08-24 23:59:59', '30.9022006988525', 12, '75.8546981811523', 'Ludhiana', 'India', 'Punjab'),
(89, 'username90@email.com', '1994-01-17 23:59:59', '27.5618000030518', 16, '76.6087036132812', 'Alwar', 'India', 'Rajasthan'),
(90, 'username91@email.com', '1993-06-09 23:59:59', '25.3463001251221', 17, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan'),
(91, 'username92@email.com', '1998-08-19 23:59:59', '22.7252998352051', 12, '75.8656005859375', 'Indore', 'India', 'Madhya Pradesh'),
(92, 'username93@email.com', '1990-02-03 23:59:59', '28.5832996368408', 20, '77.3332977294922', 'Noida', 'India', 'Uttar Pradesh'),
(93, 'username94@email.com', '2000-06-20 23:59:59', '22.7252998352051', 10, '75.8656005859375', 'Indore', 'India', 'Madhya Pradesh'),
(94, 'username95@email.com', '1994-06-13 23:59:59', '22.5725994110107', 16, '88.363899230957', 'Kolkata', 'India', 'West Bangal'),
(95, 'username96@email.com', '1998-06-17 23:59:59', '21.2287006378174', 12, '79.2901992797852', 'Nagpur', 'India', 'Madhya Pradesh'),
(96, 'username97@email.com', '1998-09-03 23:59:59', '26.9260997772217', 12, '75.8088989257812', 'Jaipur', 'India', 'Rajasthan'),
(97, 'username98@email.com', '1999-10-25 23:59:59', '23.2474994659424', 10, '77.4158020019531', 'Bhopal', 'India', 'Madhya Pradesh'),
(98, 'username99@email.com', '1992-11-18 23:59:59', '19.0177001953125', 17, '72.856201171875', 'Mumbai', 'India', 'Maharashtra'),
(99, 'username100@email.com', '1996-04-22 23:59:59', '30.9022006988525', 14, '75.8546981811523', 'Ludhiana', 'India', 'Punjab'),
(100, 'username101@email.com', '1998-05-14 23:59:59', '30.9022006988525', 12, '75.8546981811523', 'Ludhiana', 'India', 'Punjab'),
(101, 'username102@email.com', '1995-02-18 23:59:59', '26.4538993835449', 15, '74.6389007568359', 'Ajmer', 'India', 'Rajasthan'),
(102, 'username103@email.com', '1992-09-23 23:59:59', '10.7985000610352', 17, '77.1025009155273', 'Coimbatore', 'India', 'Karnataka'),
(103, 'username104@email.com', '1999-02-27 23:59:59', '18.5205001831055', 11, '73.8565979003906', 'Pune', 'India', 'Maharashtra'),
(104, 'username105@email.com', '1990-06-02 23:59:59', '22.3064994812012', 20, '73.1875991821289', 'Vadodara', 'India', 'Gujrat'),
(105, 'username106@email.com', '1998-04-21 23:59:59', '28.0167007446289', 12, '73.3332977294922', 'Bikaner', 'India', 'Rajasthan'),
(106, 'username107@email.com', '1998-09-11 23:59:59', '17.3850002288818', 11, '78.486701965332', 'Hyderabad', 'India', 'Andhra Pradesh'),
(107, 'username108@email.com', '1997-11-16 23:59:59', '13.0604000091553', 12, '80.2496032714844', 'chennai', 'India', 'Tamilnadu'),
(108, 'username109@email.com', '1993-02-12 23:59:59', '25.3463001251221', 17, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan'),
(109, 'username110@email.com', '1998-04-16 23:59:59', '24.5713005065918', 12, '73.6914978027344', 'Udaipur', 'India', 'Rajasthan'),
(110, 'username111@email.com', '1995-04-05 23:59:59', '13.0604000091553', 15, '80.2496032714844', 'chennai', 'India', 'Tamilnadu'),
(111, 'username112@email.com', '1990-03-13 23:59:59', '26.9260997772217', 20, '75.8088989257812', 'Jaipur', 'India', 'Rajasthan'),
(112, 'username113@email.com', '1995-01-20 23:59:59', '23.0396003723145', 15, '72.5660018920898', 'Ahmedabad', 'India', 'Gujrat'),
(113, 'username114@email.com', '1996-04-18 23:59:59', '31.3199996948242', 14, '75.5800018310547', 'Jalandhar', 'India', 'Punjab'),
(114, 'username115@email.com', '1997-06-16 23:59:59', '17.3850002288818', 13, '78.486701965332', 'Hyderabad', 'India', 'Andhra Pradesh'),
(115, 'username116@email.com', '1994-09-01 23:59:59', '25.3463001251221', 16, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan'),
(116, 'username117@email.com', '1990-01-13 23:59:59', '31.1000003814697', 20, '77.1699981689453', 'Shimla', 'India', 'Himachal Pradesh'),
(117, 'username118@email.com', '1999-08-12 23:59:59', '12.9715995788574', 11, '77.5943984985352', 'Banglore', 'India', 'Karnataka'),
(118, 'username119@email.com', '1999-10-22 23:59:59', '26.9260997772217', 10, '75.8088989257812', 'Jaipur', 'India', 'Rajasthan'),
(119, 'username120@email.com', '1999-07-04 23:59:59', '21.1949996948242', 11, '72.8195037841797', 'Surat', 'India', 'Gujrat'),
(120, 'username121@email.com', '1990-06-13 23:59:59', '30.9022006988525', 20, '75.8546981811523', 'Ludhiana', 'India', 'Punjab');;
