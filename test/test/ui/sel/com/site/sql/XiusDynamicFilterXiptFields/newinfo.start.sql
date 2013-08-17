TRUNCATE TABLE `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(15, 'Age', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '14', '', 'Rangesearch', 7, 0),
(14, 'Birthday', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '3', '', 'Jsfields', 6, 0),
(13, 'Keyword', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'keywordsearch', '', 'Keyword', 5, 0),
(12, 'E-mail', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'email', '', 'Joomla', 4, 0),
(9, 'latitude', 'isSearchable=0\nisVisible=0\nisSortable=0\nisExportable=0\ntooltip=\n\n', 'latitude', '', 'Jsuser', 6, 0),
(10, 'longitude', 'isSearchable=0\nisVisible=0\nisSortable=0\nisExportable=0\ntooltip=\n\n', 'longitude', '', 'Jsuser', 7, 0),
(11, 'By Information', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'information', 'xius_proximity_latitude=9\nxius_proximity_longitude=10\n\n', 'Proximity', 8, 0),
(16, 'City / Town', 'isSearchable=0\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '11', '', 'Jsfields', 8, 0),
(17, 'Country', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '12', '', 'Jsfields', 9, 0),
(19, 'State', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '10', '', 'Jsfields', 10, 1),
(20, 'By Google API', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'google', 'xius_proximity_country=17\nxius_proximity_zipcode=\nxius_proximity_state=19\nxius_proximity_city=16\nxius_gmap_key=\n\n', 'Proximity', 11, 0),
(21, 'Chekbox', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '18', '', 'Jsfields', 12, 1),
(22, 'Profiletype', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '20', '', 'Jsfields', 13, 1),
(23, 'Gender', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '2', '', 'Jsfields', 14, 1),
(24, 'RADIO', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '22', '', 'Jsfields', 15, 1),
(25, 'Multi', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '21', '', 'Jsfields', 16, 1);;
