TRUNCATE TABLE `#__xius_info`;;
ALTER TABLE `#__xius_info` AUTO_INCREMENT=1;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'DATABASE', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'database', 'xius_proximity_country=4\nxius_proximity_zipcode=\nxius_proximity_state=\nxius_proximity_city=3\nxius_proximity_table=#__xius_proximity\nxius_proximity_zipcode_column=zipcode\nxius_proximity_country_column=country\nxius_proximity_state_column=state\nxius_proximity_city_column=city\nxius_proximity_lat_column=latitude\nxius_proximity_long_column=longitude\n\n', 'Proximity', 4, 1),
(2, 'Gender', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '2', '', 'Jsfields', 1, 1),
(3, 'City', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', '', 'Jsfields', 2, 1),
(4, 'Country', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '12', '', 'Jsfields', 3, 1);;

